<?php
// Edit plugin, https://github.com/datenstrom/yellow-plugins/tree/master/edit
// Copyright (c) 2013-2018 Datenstrom, https://datenstrom.se
// This file may be used and distributed under the terms of the public license.

class YellowEdit
{
	const VERSION = "0.7.15";
	var $yellow;			//access to API
	var $response;			//web response
	var $users;				//user accounts
	var $merge;				//text merge

	// Handle initialisation
	function onLoad($yellow)
	{
		$this->yellow = $yellow;
		$this->response = new YellowResponse($yellow);
		$this->users = new YellowUsers($yellow);
		$this->merge = new YellowMerge($yellow);
		$this->yellow->config->setDefault("editLocation", "/edit/");
		$this->yellow->config->setDefault("editUploadNewLocation", "/media/@group/@filename");
		$this->yellow->config->setDefault("editUploadExtensions", ".gif, .jpg, .pdf, .png, .svg, .tgz, .zip");
		$this->yellow->config->setDefault("editKeyboardShortcuts", "ctrl+b bold, ctrl+i italic, ctrl+e code, ctrl+k link, ctrl+s save, ctrl+shift+p preview");
		$this->yellow->config->setDefault("editToolbarButtons", "auto");
		$this->yellow->config->setDefault("editEndOfLine", "auto");
		$this->yellow->config->setDefault("editUserFile", "user.ini");
		$this->yellow->config->setDefault("editUserPasswordMinLength", "8");
		$this->yellow->config->setDefault("editUserHashAlgorithm", "bcrypt");
		$this->yellow->config->setDefault("editUserHashCost", "10");
		$this->yellow->config->setDefault("editUserStatus", "active");
		$this->yellow->config->setDefault("editUserHome", "/");
		$this->yellow->config->setDefault("editLoginRestrictions", "0");
		$this->yellow->config->setDefault("editLoginSessionTimeout", "2592000");
		$this->yellow->config->setDefault("editBruteForceProtection", "25");
		$this->users->load($this->yellow->config->get("configDir").$this->yellow->config->get("editUserFile"));
	}

	// Handle startup
	function onStartup($update)
	{
		if($update) $this->cleanCommand(array("clean", "all"));
	}
	
	// Handle request
	function onRequest($scheme, $address, $base, $location, $fileName)
	{
		$statusCode = 0;
		if($this->checkRequest($location))
		{
			$scheme = $this->yellow->config->get("serverScheme");
			$address = $this->yellow->config->get("serverAddress");
			$base = rtrim($this->yellow->config->get("serverBase").$this->yellow->config->get("editLocation"), '/');
			list($scheme, $address, $base, $location, $fileName) = $this->yellow->getRequestInformation($scheme, $address, $base);
			$this->yellow->page->setRequestInformation($scheme, $address, $base, $location, $fileName);
			$statusCode = $this->processRequest($scheme, $address, $base, $location, $fileName);
		}
		return $statusCode;
	}
	
	// Handle page meta data parsing
	function onParseMeta($page)
	{
		if($page==$this->yellow->page && $this->response->isActive())
		{
			if($this->response->isUser())
			{
				if(empty($this->response->rawDataSource)) $this->response->rawDataSource = $page->rawData;
				if(empty($this->response->rawDataEdit)) $this->response->rawDataEdit = $page->rawData;
				if(empty($this->response->rawDataEndOfLine)) $this->response->rawDataEndOfLine = $this->response->getEndOfLine($page->rawData);
				if($page->statusCode==434) $this->response->rawDataEdit = $this->response->getRawDataNew($page->location);
			}
			if(empty($this->response->language)) $this->response->language = $page->get("language");
			if(empty($this->response->action)) $this->response->action = $this->response->isUser() ? "none" : "login";
			if(empty($this->response->status)) $this->response->status = "none";
			if($this->response->status=="error") $this->response->action = "error";
		}
	}
	
	// Handle page content parsing of custom block
	function onParseContentBlock($page, $name, $text, $shortcut)
	{
		$output = null;
		if($name=="edit" && $shortcut)
		{
			$editText = "$name $text";
			if(substru($text, 0, 2)=="- ") $editText = trim(substru($text, 2));
			$output = "<a href=\"".$page->get("pageEdit")."\">".htmlspecialchars($editText)."</a>";
		}
		return $output;
	}
	
	// Handle page extra HTML data
	function onExtra($name)
	{
		$output = null;
		if($name=="header" && $this->response->isActive())
		{
			$pluginLocation = $this->yellow->config->get("serverBase").$this->yellow->config->get("pluginLocation");
			$output = "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"{$pluginLocation}edit.css\" />\n";
			$output .= "<script type=\"text/javascript\" src=\"{$pluginLocation}edit.js\"></script>\n";
			$output .= "<script type=\"text/javascript\">\n";
			$output .= "// <![CDATA[\n";
			$output .= "yellow.page = ".json_encode($this->response->getPageData()).";\n";
			$output .= "yellow.config = ".json_encode($this->response->getConfigData()).";\n";
			$output .= "yellow.text = ".json_encode($this->response->getTextData()).";\n";
			$output .= "// ]]>\n";
			$output .= "</script>\n";
		}
		return $output;
	}
	
	// Handle command
	function onCommand($args)
	{
		list($command) = $args;
		switch($command)
		{
			case "clean":	$statusCode = $this->cleanCommand($args); break;
			case "user":	$statusCode = $this->userCommand($args); break;
			default:		$statusCode = 0;
		}
		return $statusCode;
	}
	
	// Handle command help
	function onCommandHelp()
	{
		return "user [EMAIL PASSWORD NAME LANGUAGE]\n";
	}

	// Clean user accounts
	function cleanCommand($args)
	{
		$statusCode = 0;
		list($command, $path) = $args;
		if($path=="all")
		{
			$fileNameUser = $this->yellow->config->get("configDir").$this->yellow->config->get("editUserFile");
			if(!$this->users->clean($fileNameUser))
			{
				$statusCode = 500;
				echo "ERROR cleaning configuration: Can't write file '$fileNameUser'!\n";
			}
		}
		return $statusCode;
	}
	
	// Update user account
	function userCommand($args)
	{
		$statusCode = 0;
		list($command, $email, $password, $name, $language) = $args;
		if(!empty($email) && !empty($password))
		{
			$userExisting = $this->users->isExisting($email);
			$status = $this->getUserAccount($email, $password, $command);
			switch($status)
			{
				case "invalid":	echo "ERROR updating configuration: Please enter a valid email!\n"; break;
				case "weak": echo "ERROR updating configuration: Please enter a different password!\n"; break;
			}
			if($status=="ok")
			{
				$fileNameUser = $this->yellow->config->get("configDir").$this->yellow->config->get("editUserFile");
				$status = $this->users->update($fileNameUser, $email, $password, $name, $language, "active") ? "ok" : "error";
				if($status=="error") echo "ERROR updating configuration: Can't write file '$fileNameUser'!\n";
			}
			if($status=="ok")
			{
				$algorithm = $this->yellow->config->get("editUserHashAlgorithm");
				$status = substru($this->users->getHash($email), 0, 5)!="error-hash" ? "ok" : "error";
				if($status=="error") echo "ERROR updating configuration: Hash algorithm '$algorithm' not supported!\n";
			}
			$statusCode = $status=="ok" ? 200 : 500;
			echo "Yellow $command: User account ".($statusCode!=200 ? "not " : "");
			echo ($userExisting ? "updated" : "created")."\n";
		} else {
			$statusCode = 200;
			foreach($this->users->getData() as $line) echo "$line\n";
			if(!$this->users->getNumber()) echo "Yellow $command: No user accounts\n";
		}
		return $statusCode;
	}
	
	// Process request
	function processRequest($scheme, $address, $base, $location, $fileName)
	{
		$statusCode = 0;
		if($this->checkUser($scheme, $address, $base, $location, $fileName))
		{
			switch($_REQUEST["action"])
			{
				case "":			$statusCode = $this->processRequestShow($scheme, $address, $base, $location, $fileName); break;
				case "login":		$statusCode = $this->processRequestLogin($scheme, $address, $base, $location, $fileName); break;
				case "logout":		$statusCode = $this->processRequestLogout($scheme, $address, $base, $location, $fileName); break;
				case "settings":	$statusCode = $this->processRequestSettings($scheme, $address, $base, $location, $fileName); break;
				case "version":		$statusCode = $this->processRequestVersion($scheme, $address, $base, $location, $fileName); break;
				case "update":		$statusCode = $this->processRequestUpdate($scheme, $address, $base, $location, $fileName); break;
				case "create":		$statusCode = $this->processRequestCreate($scheme, $address, $base, $location, $fileName); break;
				case "edit":		$statusCode = $this->processRequestEdit($scheme, $address, $base, $location, $fileName); break;
				case "delete":		$statusCode = $this->processRequestDelete($scheme, $address, $base, $location, $fileName); break;
				case "preview":		$statusCode = $this->processRequestPreview($scheme, $address, $base, $location, $fileName); break;
				case "upload":		$statusCode = $this->processRequestUpload($scheme, $address, $base, $location, $fileName); break;
			}
		} else {
			$this->yellow->lookup->requestHandler = "core";
			switch($_REQUEST["action"])
			{
				case "":			$statusCode = $this->processRequestShow($scheme, $address, $base, $location, $fileName); break;
				case "signup":		$statusCode = $this->processRequestSignup($scheme, $address, $base, $location, $fileName); break;
				case "confirm":		$statusCode = $this->processRequestConfirm($scheme, $address, $base, $location, $fileName); break;
				case "approve":		$statusCode = $this->processRequestApprove($scheme, $address, $base, $location, $fileName); break;
				case "reactivate":	$statusCode = $this->processRequestReactivate($scheme, $address, $base, $location, $fileName); break;
				case "recover":		$statusCode = $this->processRequestRecover($scheme, $address, $base, $location, $fileName); break;
				case "reconfirm":	$statusCode = $this->processRequestReconfirm($scheme, $address, $base, $location, $fileName); break;
				case "change":		$statusCode = $this->processRequestChange($scheme, $address, $base, $location, $fileName); break;
			}
			$this->checkUserFailed($scheme, $address, $base, $location, $fileName);
		}
		return $statusCode;
	}
	
	// Process request to show file
	function processRequestShow($scheme, $address, $base, $location, $fileName)
	{
		$statusCode = 0;
		if(is_readable($fileName))
		{
			$statusCode = $this->yellow->processRequest($scheme, $address, $base, $location, $fileName, false);
		} else {
			if($this->yellow->lookup->isRedirectLocation($location))
			{
				$location = $this->yellow->lookup->isFileLocation($location) ? "$location/" : "/".$this->yellow->getRequestLanguage()."/";
				$location = $this->yellow->lookup->normaliseUrl($scheme, $address, $base, $location);
				$statusCode = $this->yellow->sendStatus(301, $location);
			} else {
				$this->yellow->page->error($this->response->isUserRestrictions() ? 404 : 434);
				$statusCode = $this->yellow->processRequest($scheme, $address, $base, $location, $fileName, false);
			}
		}
		return $statusCode;
	}

	// Process request for user login
	function processRequestLogin($scheme, $address, $base, $location, $fileName)
	{
		$fileNameUser = $this->yellow->config->get("configDir").$this->yellow->config->get("editUserFile");
		if($this->users->update($fileNameUser, $this->response->userEmail))
		{
			$home = $this->users->getHome($this->response->userEmail);
			if(substru($location, 0, strlenu($home))==$home)
			{
				$location = $this->yellow->lookup->normaliseUrl($scheme, $address, $base, $location);
				$statusCode = $this->yellow->sendStatus(303, $location);
			} else {
				$location = $this->yellow->lookup->normaliseUrl($scheme, $address, $base, $home);
				$statusCode = $this->yellow->sendStatus(302, $location);
			}
		} else {
			$this->yellow->page->error(500, "Can't write file '$fileNameUser'!");
			$statusCode = $this->yellow->processRequest($scheme, $address, $base, $location, $fileName, false);
		}
		return $statusCode;
	}
	
	// Process request for user logout
	function processRequestLogout($scheme, $address, $base, $location, $fileName)
	{
		$this->response->userEmail = "";
		$this->response->destroyCookies($scheme, $address, $base);
		$location = $this->yellow->lookup->normaliseUrl(
			$this->yellow->config->get("serverScheme"),
			$this->yellow->config->get("serverAddress"),
			$this->yellow->config->get("serverBase"), $location);
		$statusCode = $this->yellow->sendStatus(302, $location);
		return $statusCode;
	}

	// Process request for user signup
	function processRequestSignup($scheme, $address, $base, $location, $fileName)
	{
		$this->response->action = "signup";
		$this->response->status = "ok";
		$name = trim(preg_replace("/[^\pL\d\-\. ]/u", "-", $_REQUEST["name"]));
		$email = trim($_REQUEST["email"]);
		$password = trim($_REQUEST["password"]);
		if(empty($name) || empty($email) || empty($password)) $this->response->status = "incomplete";
		if($this->response->status=="ok") $this->response->status = $this->getUserAccount($email, $password, $this->response->action);
		if($this->response->status=="ok" && $this->response->isLoginRestrictions()) $this->response->status = "next";
		if($this->response->status=="ok" && $this->users->isTaken($email)) $this->response->status = "next";
		if($this->response->status=="ok")
		{
			$fileNameUser = $this->yellow->config->get("configDir").$this->yellow->config->get("editUserFile");
			$this->response->status = $this->users->update($fileNameUser, $email, $password, $name, "", "unconfirmed") ? "ok" : "error";
			if($this->response->status=="error") $this->yellow->page->error(500, "Can't write file '$fileNameUser'!");
		}
		if($this->response->status=="ok")
		{
			$this->response->status = $this->response->sendMail($scheme, $address, $base, $email, "confirm") ? "next" : "error";
			if($this->response->status=="error") $this->yellow->page->error(500, "Can't send email on this server!");
		}
		$statusCode = $this->yellow->processRequest($scheme, $address, $base, $location, $fileName, false);
		return $statusCode;
	}
	
	// Process request to confirm user signup
	function processRequestConfirm($scheme, $address, $base, $location, $fileName)
	{
		$this->response->action = "confirm";
		$this->response->status = "ok";
		$email = $_REQUEST["email"];
		$this->response->status = $this->users->getResponseStatus($email, $_REQUEST["action"], $_REQUEST["expire"], $_REQUEST["id"]);
		if($this->response->status=="ok")
		{
			$fileNameUser = $this->yellow->config->get("configDir").$this->yellow->config->get("editUserFile");
			$this->response->status = $this->users->update($fileNameUser, $email, "", "", "", "unapproved") ? "ok" : "error";
			if($this->response->status=="error") $this->yellow->page->error(500, "Can't write file '$fileNameUser'!");
		}
		if($this->response->status=="ok")
		{
			$this->response->status = $this->response->sendMail($scheme, $address, $base, $email, "approve") ? "done" : "error";
			if($this->response->status=="error") $this->yellow->page->error(500, "Can't send email on this server!");
		}
		$statusCode = $this->yellow->processRequest($scheme, $address, $base, $location, $fileName, false);
		return $statusCode;
	}
	
	// Process request to approve user signup
	function processRequestApprove($scheme, $address, $base, $location, $fileName)
	{
		$this->response->action = "approve";
		$this->response->status = "ok";
		$email = $_REQUEST["email"];
		$this->response->status = $this->users->getResponseStatus($email, $_REQUEST["action"], $_REQUEST["expire"], $_REQUEST["id"]);
		if($this->response->status=="ok")
		{
			$fileNameUser = $this->yellow->config->get("configDir").$this->yellow->config->get("editUserFile");
			$this->response->status = $this->users->update($fileNameUser, $email, "", "", "", "active") ? "ok" : "error";
			if($this->response->status=="error") $this->yellow->page->error(500, "Can't write file '$fileNameUser'!");
		}
		if($this->response->status=="ok")
		{
			$this->response->status = $this->response->sendMail($scheme, $address, $base, $email, "welcome") ? "done" : "error";
			if($this->response->status=="error") $this->yellow->page->error(500, "Can't send email on this server!");
		}
		$statusCode = $this->yellow->processRequest($scheme, $address, $base, $location, $fileName, false);
		return $statusCode;
	}

	// Process request to reactivate account
	function processRequestReactivate($scheme, $address, $base, $location, $fileName)
	{
		$this->response->action = "reactivate";
		$this->response->status = "ok";
		$email = $_REQUEST["email"];
		$this->response->status = $this->users->getResponseStatus($email, $_REQUEST["action"], $_REQUEST["expire"], $_REQUEST["id"]);
		if($this->response->status=="ok")
		{
			$fileNameUser = $this->yellow->config->get("configDir").$this->yellow->config->get("editUserFile");
			$this->response->status = $this->users->update($fileNameUser, $email, "", "", "", "active") ? "done" : "error";
			if($this->response->status=="error") $this->yellow->page->error(500, "Can't write file '$fileNameUser'!");
		}
		$statusCode = $this->yellow->processRequest($scheme, $address, $base, $location, $fileName, false);
		return $statusCode;
	}
	
	// Process request to recover password
	function processRequestRecover($scheme, $address, $base, $location, $fileName)
	{
		$this->response->action = "recover";
		$this->response->status = "ok";
		$email = trim($_REQUEST["email"]);
		$password = trim($_REQUEST["password"]);
		if(empty($_REQUEST["id"]))
		{
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)) $this->response->status = "invalid";
			if($this->response->status=="ok" && !$this->users->isExisting($email)) $this->response->status = "next";
			if($this->response->status=="ok")
			{
				$this->response->status = $this->response->sendMail($scheme, $address, $base, $email, "recover") ? "next" : "error";
				if($this->response->status=="error") $this->yellow->page->error(500, "Can't send email on this server!");
			}
		} else {
			$this->response->status = $this->users->getResponseStatus($email, $_REQUEST["action"], $_REQUEST["expire"], $_REQUEST["id"]);
			if($this->response->status=="ok")
			{
				if(empty($password)) $this->response->status = "password";
				if($this->response->status=="ok") $this->response->status = $this->getUserAccount($email, $password, $this->response->action);
				if($this->response->status=="ok")
				{
					$fileNameUser = $this->yellow->config->get("configDir").$this->yellow->config->get("editUserFile");
					$this->response->status = $this->users->update($fileNameUser, $email, $password) ? "ok" : "error";
					if($this->response->status=="error") $this->yellow->page->error(500, "Can't write file '$fileNameUser'!");
				}
				if($this->response->status=="ok")
				{
					$this->response->userEmail = "";
					$this->response->destroyCookies($scheme, $address, $base);
					$this->response->status = $this->response->sendMail($scheme, $address, $base, $email, "information") ? "done" : "error";
					if($this->response->status=="error") $this->yellow->page->error(500, "Can't send email on this server!");
				}
			}
		}
		$statusCode = $this->yellow->processRequest($scheme, $address, $base, $location, $fileName, false);
		return $statusCode;
	}
	
	// Process request to change settings
	function processRequestSettings($scheme, $address, $base, $location, $fileName)
	{
		$this->response->action = "settings";
		$this->response->status = "ok";
		$email = trim($_REQUEST["email"]);
		$emailSource = $this->response->userEmail;
		$password = trim($_REQUEST["password"]);
		$name = trim(preg_replace("/[^\pL\d\-\. ]/u", "-", $_REQUEST["name"]));
		$language = trim($_REQUEST["language"]);
		if($email!=$emailSource || !empty($password))
		{
			if(empty($email)) $this->response->status = "invalid";
			if($this->response->status=="ok") $this->response->status = $this->getUserAccount($email, $password, $this->response->action);
			if($this->response->status=="ok" && $email!=$emailSource && $this->users->isTaken($email)) $this->response->status = "taken";
			if($this->response->status=="ok" && $email!=$emailSource)
			{
				$pending = $emailSource;
				$home = $this->users->getHome($emailSource);
				$fileNameUser = $this->yellow->config->get("configDir").$this->yellow->config->get("editUserFile");
				$this->response->status = $this->users->update($fileNameUser, $email, "no", $name, $language, "unconfirmed", "", "", "", $pending, $home) ? "ok" : "error";
				if($this->response->status=="error") $this->yellow->page->error(500, "Can't write file '$fileNameUser'!");
			}
			if($this->response->status=="ok")
			{
				$pending = $email.':'.(empty($password) ? $this->users->getHash($emailSource) : $this->users->createHash($password));
				$fileNameUser = $this->yellow->config->get("configDir").$this->yellow->config->get("editUserFile");
				$this->response->status = $this->users->update($fileNameUser, $emailSource, "", $name, $language, "", "", "", "", $pending) ? "ok" : "error";
				if($this->response->status=="error") $this->yellow->page->error(500, "Can't write file '$fileNameUser'!");
			}
			if($this->response->status=="ok")
			{
				$action = $email!=$emailSource ? "reconfirm" : "change";
				$this->response->status = $this->response->sendMail($scheme, $address, $base, $email, $action) ? "next" : "error";
				if($this->response->status=="error") $this->yellow->page->error(500, "Can't send email on this server!");
			}
		} else {
			if($this->response->status=="ok")
			{
				$fileNameUser = $this->yellow->config->get("configDir").$this->yellow->config->get("editUserFile");
				$this->response->status = $this->users->update($fileNameUser, $email, "", $name, $language) ? "done" : "error";
				if($this->response->status=="error") $this->yellow->page->error(500, "Can't write file '$fileNameUser'!");
			}
		}
		if($this->response->status=="done")
		{
			$location = $this->yellow->lookup->normaliseUrl($scheme, $address, $base, $location);
			$statusCode = $this->yellow->sendStatus(303, $location);
		} else {
			$statusCode = $this->yellow->processRequest($scheme, $address, $base, $location, $fileName, false);
		}
		return $statusCode;
	}

	// Process request to reconfirm email
	function processRequestReconfirm($scheme, $address, $base, $location, $fileName)
	{
		$this->response->action = "reconfirm";
		$this->response->status = "ok";
		$email = $emailSource = $_REQUEST["email"];
		$this->response->status = $this->users->getResponseStatus($email, $_REQUEST["action"], $_REQUEST["expire"], $_REQUEST["id"]);
		if($this->response->status=="ok")
		{
			$emailSource = $this->users->getPending($email);
			if($this->users->getStatus($emailSource)!="active") $this->response->status = "done";
		}
		if($this->response->status=="ok")
		{
			$fileNameUser = $this->yellow->config->get("configDir").$this->yellow->config->get("editUserFile");
			$this->response->status = $this->users->update($fileNameUser, $email, "", "", "", "unchanged") ? "ok" : "error";
			if($this->response->status=="error") $this->yellow->page->error(500, "Can't write file '$fileNameUser'!");
		}
		if($this->response->status=="ok")
		{
			$this->response->status = $this->response->sendMail($scheme, $address, $base, $emailSource, "change") ? "done" : "error";
			if($this->response->status=="error") $this->yellow->page->error(500, "Can't send email on this server!");
		}
		$statusCode = $this->yellow->processRequest($scheme, $address, $base, $location, $fileName, false);
		return $statusCode;
	}
	
	// Process request to change account
	function processRequestChange($scheme, $address, $base, $location, $fileName)
	{
		$this->response->action = "change";
		$this->response->status = "ok";
		$email = $emailSource = trim($_REQUEST["email"]);
		$this->response->status = $this->users->getResponseStatus($email, $_REQUEST["action"], $_REQUEST["expire"], $_REQUEST["id"]);
		if($this->response->status=="ok")
		{
			list($email, $hash) = explode(':', $this->users->getPending($email), 2);
			if(!$this->users->isExisting($email) || empty($hash)) $this->response->status = "done";
		}
		if($this->response->status=="ok" && $email!=$emailSource)
		{
			$fileNameUser = $this->yellow->config->get("configDir").$this->yellow->config->get("editUserFile");
			$this->users->users[$emailSource]["pending"] = "none";
			$this->response->status = $this->users->update($fileNameUser, $emailSource, "", "", "", "inactive") ? "ok" : "error";
			if($this->response->status=="error") $this->yellow->page->error(500, "Can't write file '$fileNameUser'!");
		}
		if($this->response->status=="ok")
		{
			$this->users->users[$email]["hash"] = $hash;
			$this->users->users[$email]["pending"] = "none";
			$fileNameUser = $this->yellow->config->get("configDir").$this->yellow->config->get("editUserFile");
			$this->response->status = $this->users->update($fileNameUser, $email, "", "", "", "active") ? "ok" : "error";
			if($this->response->status=="error") $this->yellow->page->error(500, "Can't write file '$fileNameUser'!");
		}
		if($this->response->status=="ok")
		{
			$this->response->userEmail = "";
			$this->response->destroyCookies($scheme, $address, $base);
			$this->response->status = $this->response->sendMail($scheme, $address, $base, $email, "information") ? "done" : "error";
			if($this->response->status=="error") $this->yellow->page->error(500, "Can't send email on this server!");
		}
		$statusCode = $this->yellow->processRequest($scheme, $address, $base, $location, $fileName, false);
		return $statusCode;
	}
	
	// Process request to show software version
	function processRequestVersion($scheme, $address, $base, $location, $fileName)
	{
		$this->response->action = "version";
		$this->response->status = "ok";
		if($this->yellow->plugins->isExisting("update"))
		{
			list($statusCodeCurrent, $dataCurrent) = $this->yellow->plugins->get("update")->getSoftwareVersion();
			list($statusCodeLatest, $dataLatest) = $this->yellow->plugins->get("update")->getSoftwareVersion(true);
			list($statusCodeModified, $dataModified) = $this->yellow->plugins->get("update")->getSoftwareModified();
			$statusCode = max($statusCodeCurrent, $statusCodeLatest, $statusCodeModified);
			if($this->response->isUserWebmaster())
			{
				foreach($dataCurrent as $key=>$value)
				{
					if(strnatcasecmp($dataCurrent[$key], $dataLatest[$key])<0)
					{
						++$updates;
						if(!empty($this->response->rawDataOutput)) $this->response->rawDataOutput .= "<br />\n";
						$this->response->rawDataOutput .= htmlspecialchars("$key $dataLatest[$key]");
					}
				}
				if($updates==0)
				{
					foreach($dataCurrent as $key=>$value)
					{
						if(!is_null($dataModified[$key]) && !is_null($dataLatest[$key]))
						{
							$rawData = $this->yellow->text->getTextHtml("editVersionUpdateModified", $this->response->language)." - <a href=\"#\" data-action=\"update\" data-status=\"update\" data-args=\"".$this->yellow->toolbox->normaliseArgs("option:force/feature:$key")."\">".$this->yellow->text->getTextHtml("editVersionUpdateForce", $this->response->language)."</a>";
							$rawData = preg_replace("/@software/i", htmlspecialchars("$key $dataLatest[$key]"), $rawData);
							if(!empty($this->response->rawDataOutput)) $this->response->rawDataOutput .= "<br />\n";
							$this->response->rawDataOutput .= $rawData;
						}
					}
				}
			} else {
				foreach($dataCurrent as $key=>$value)
				{
					if(strnatcasecmp($dataCurrent[$key], $dataLatest[$key])<0) ++$updates;
				}
			}
			$this->response->status = $updates ? "updates" : "done";
			if($statusCode!=200) $this->response->status = "error";
		}
		$statusCode = $this->yellow->processRequest($scheme, $address, $base, $location, $fileName, false);
		return $statusCode;
	}
	
	// Process request to update website
	function processRequestUpdate($scheme, $address, $base, $location, $fileName)
	{
		$statusCode = 0;
		if($this->yellow->plugins->isExisting("update") && $this->response->isUserWebmaster())
		{
			$option = trim($_REQUEST["option"]);
			$feature = trim($_REQUEST["feature"]);
			$statusCode = $this->yellow->command("update", $option, $feature);
			if($statusCode==200)
			{
				$location = $this->yellow->lookup->normaliseUrl($scheme, $address, $base, $location);
				$statusCode = $this->yellow->sendStatus(303, $location);
			}
		}
		return $statusCode;
	}
	
	// Process request to create page
	function processRequestCreate($scheme, $address, $base, $location, $fileName)
	{
		$statusCode = 0;
		if(!$this->response->isUserRestrictions() && !empty($_REQUEST["rawdataedit"]))
		{
			$this->response->rawDataSource = $_REQUEST["rawdatasource"];
			$this->response->rawDataEdit = $_REQUEST["rawdatasource"];
			$this->response->rawDataEndOfLine = $_REQUEST["rawdataendofline"];
			$rawData = $_REQUEST["rawdataedit"];
			$page = $this->response->getPageNew($scheme, $address, $base, $location, $fileName, $rawData, $this->response->getEndOfLine());
			if(!$page->isError())
			{
				if($this->yellow->toolbox->createFile($page->fileName, $page->rawData, true))
				{
					$location = $this->yellow->lookup->normaliseUrl($scheme, $address, $base, $page->location);
					$statusCode = $this->yellow->sendStatus(303, $location);
				} else {
					$this->yellow->page->error(500, "Can't write file '$page->fileName'!");
					$statusCode = $this->yellow->processRequest($scheme, $address, $base, $location, $fileName, false);
				}
			} else {
				$this->yellow->page->error(500, $page->get("pageError"));
				$statusCode = $this->yellow->processRequest($scheme, $address, $base, $location, $fileName, false);
			}
		}
		return $statusCode;
	}
	
	// Process request to edit page
	function processRequestEdit($scheme, $address, $base, $location, $fileName)
	{
		$statusCode = 0;
		if(!$this->response->isUserRestrictions() && !empty($_REQUEST["rawdataedit"]))
		{
			$this->response->rawDataSource = $_REQUEST["rawdatasource"];
			$this->response->rawDataEdit = $_REQUEST["rawdataedit"];
			$this->response->rawDataEndOfLine = $_REQUEST["rawdataendofline"];
			$rawDataFile = $this->yellow->toolbox->readFile($fileName);
			$page = $this->response->getPageEdit($scheme, $address, $base, $location, $fileName,
				$this->response->rawDataSource, $this->response->rawDataEdit, $rawDataFile, $this->response->rawDataEndOfLine);
			if(!$page->isError())
			{
				if($this->yellow->toolbox->renameFile($fileName, $page->fileName, true) &&
				   $this->yellow->toolbox->createFile($page->fileName, $page->rawData))
				{
					$location = $this->yellow->lookup->normaliseUrl($scheme, $address, $base, $page->location);
					$statusCode = $this->yellow->sendStatus(303, $location);
				} else {
					$this->yellow->page->error(500, "Can't write file '$page->fileName'!");
					$statusCode = $this->yellow->processRequest($scheme, $address, $base, $location, $fileName, false);
				}
			} else {
				$this->yellow->page->error(500, $page->get("pageError"));
				$statusCode = $this->yellow->processRequest($scheme, $address, $base, $location, $fileName, false);
			}
		}
		return $statusCode;
	}

	// Process request to delete page
	function processRequestDelete($scheme, $address, $base, $location, $fileName)
	{
		$statusCode = 0;
		if(!$this->response->isUserRestrictions() && is_file($fileName))
		{
			$this->response->rawDataSource = $_REQUEST["rawdatasource"];
			$this->response->rawDataEdit = $_REQUEST["rawdatasource"];
			$this->response->rawDataEndOfLine = $_REQUEST["rawdataendofline"];
			$rawDataFile = $this->yellow->toolbox->readFile($fileName);
			$page = $this->response->getPageDelete($scheme, $address, $base, $location, $fileName,
				$rawDataFile, $this->response->rawDataEndOfLine);
			if(!$page->isError())
			{
				if($this->yellow->lookup->isFileLocation($location))
				{
					if($this->yellow->toolbox->deleteFile($fileName, $this->yellow->config->get("trashDir")))
					{
						$location = $this->yellow->lookup->normaliseUrl($scheme, $address, $base, $location);
						$statusCode = $this->yellow->sendStatus(303, $location);
					} else {
						$this->yellow->page->error(500, "Can't delete file '$fileName'!");
						$statusCode = $this->yellow->processRequest($scheme, $address, $base, $location, $fileName, false);
					}
				} else {
					if($this->yellow->toolbox->deleteDirectory(dirname($fileName), $this->yellow->config->get("trashDir")))
					{
						$location = $this->yellow->lookup->normaliseUrl($scheme, $address, $base, $location);
						$statusCode = $this->yellow->sendStatus(303, $location);
					} else {
						$this->yellow->page->error(500, "Can't delete file '$fileName'!");
						$statusCode = $this->yellow->processRequest($scheme, $address, $base, $location, $fileName, false);
					}
				}
			} else {
				$this->yellow->page->error(500, $page->get("pageError"));
				$statusCode = $this->yellow->processRequest($scheme, $address, $base, $location, $fileName, false);
			}
		}
		return $statusCode;
	}

	// Process request to show preview
	function processRequestPreview($scheme, $address, $base, $location, $fileName)
	{
		$page = $this->response->getPagePreview($scheme, $address, $base, $location, $fileName,
			$_REQUEST["rawdataedit"], $_REQUEST["rawdataendofline"]);
		$statusCode = $this->yellow->sendData(200, $page->outputData, "", false);
		if(defined("DEBUG") && DEBUG>=1)
		{
			$parser = $page->get("parser");
			echo "YellowEdit::processRequestPreview parser:$parser<br/>\n";
		}
		return $statusCode;
	}
	
	// Process request to upload file
	function processRequestUpload($scheme, $address, $base, $location, $fileName)
	{
		$data = array();
		$fileNameTemp = $_FILES["file"]["tmp_name"];
		$fileNameShort = preg_replace("/[^\pL\d\-\.]/u", "-", basename($_FILES["file"]["name"]));
		$fileSizeMax = $this->yellow->toolbox->getNumberBytes(ini_get("upload_max_filesize"));
		$extension = strtoloweru(($pos = strrposu($fileNameShort, '.')) ? substru($fileNameShort, $pos) : "");
		$extensions = preg_split("/\s*,\s*/", $this->yellow->config->get("editUploadExtensions"));
		if(!$this->response->isUserRestrictions() && is_uploaded_file($fileNameTemp) &&
		   filesize($fileNameTemp)<=$fileSizeMax && in_array($extension, $extensions))
		{
			$file = $this->response->getFileUpload($scheme, $address, $base, $location, $fileNameTemp, $fileNameShort);
			if(!$file->isError() && $this->yellow->toolbox->renameFile($fileNameTemp, $file->fileName, true))
			{
				$data["location"] = $file->getLocation();
			} else {
				$data["error"] = "Can't write file '$file->fileName'!";
			}
		} else {
			$data["error"] = "Can't write file '$fileNameShort'!";
		}
		$statusCode = $this->yellow->sendData(is_null($data["error"]) ? 200 : 500, json_encode($data), "a.json", false);
		return $statusCode;
	}
	
	// Check request
	function checkRequest($location)
	{
		$locationLength = strlenu($this->yellow->config->get("editLocation"));
		$this->response->active = substru($location, 0, $locationLength)==$this->yellow->config->get("editLocation");
		return $this->response->isActive();
	}
	
	// Check user
	function checkUser($scheme, $address, $base, $location, $fileName)
	{
		if($this->isRequestSameSite("POST", $scheme, $address) || $_REQUEST["action"]=="")
		{
			if($_REQUEST["action"]=="login")
			{
				$email = $_REQUEST["email"];
				$password = $_REQUEST["password"];
				if($this->users->checkAuthLogin($email, $password))
				{
					$this->response->createCookies($scheme, $address, $base, $email);
					$this->response->userEmail = $email;
					$this->response->userRestrictions = $this->getUserRestrictions($email, $location, $fileName);
					$this->response->language = $this->getUserLanguage($email);
				} else {
					$this->response->userFailed = true;
					$this->response->userFailedEmail = $email;
				}
			} else if(isset($_COOKIE["authtoken"]) && isset($_COOKIE["csrftoken"])) {
				if($this->users->checkAuthToken($_COOKIE["authtoken"], $_COOKIE["csrftoken"], $_POST["csrftoken"], $_REQUEST["action"]==""))
				{
					$this->response->userEmail = $email = $this->users->getAuthEmail($_COOKIE["authtoken"]);
					$this->response->userRestrictions = $this->getUserRestrictions($email, $location, $fileName);
					$this->response->language = $this->getUserLanguage($email);
				} else {
					$this->response->userFailed = true;
					$this->response->userFailedEmail = $this->users->getAuthEmail($_COOKIE["authtoken"]);
				}
			}
		}
		return $this->response->isUser();
	}
	
	// Check user failed
	function checkUserFailed($scheme, $address, $base, $location, $fileName)
	{
		if($this->response->userFailed)
		{
			$email = $this->response->userFailedEmail;
			if($this->users->isExisting($email))
			{
				$modified = $this->users->getModified($email);
				$errors = $this->users->getErrors($email)+1;
				$fileNameUser = $this->yellow->config->get("configDir").$this->yellow->config->get("editUserFile");
				$status = $this->users->update($fileNameUser, $email, "", "", "", "", "", $modified, $errors) ? "ok" : "error";
				if($status=="error") $this->yellow->page->error(500, "Can't write file '$fileNameUser'!");
				if($errors==$this->yellow->config->get("editBruteForceProtection"))
				{
					if($status=="ok")
					{
						$status = $this->users->update($fileNameUser, $email, "", "", "", "inactive", "", $modified, $errors) ? "ok" : "error";
						if($status=="error") $this->yellow->page->error(500, "Can't write file '$fileNameUser'!");
					}
					if($status=="ok")
					{
						$status = $this->response->sendMail($scheme, $address, $base, $email, "reactivate") ? "done" : "error";
						if($status=="error") $this->yellow->page->error(500, "Can't send email on this server!");
					}
				}
			}
			$this->response->destroyCookies($scheme, $address, $base);
			$this->response->status = "error";
			$this->yellow->page->error(430);
		}
	}
	
	// Return user account changes
	function getUserAccount($email, $password, $action)
	{
		$status = null;
		foreach($this->yellow->plugins->plugins as $key=>$value)
		{
			if(method_exists($value["obj"], "onEditUserAccount"))
			{
				$status = $value["obj"]->onEditUserAccount($email, $password, $action, $this->users);
				if(!is_null($status)) break;
			}
		}
		if(is_null($status))
		{
			$status = "ok";
			if(!empty($password) && strlenu($password)<$this->yellow->config->get("editUserPasswordMinLength")) $status = "weak";
			if(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) $status = "invalid";
		}
		return $status;
	}
	
	// Return user restrictions
	function getUserRestrictions($email, $location, $fileName)
	{
		$userRestrictions = null;
		foreach($this->yellow->plugins->plugins as $key=>$value)
		{
			if(method_exists($value["obj"], "onEditUserRestrictions"))
			{
				$userRestrictions = $value["obj"]->onEditUserRestrictions($email, $location, $fileName, $this->users);
				if(!is_null($userRestrictions)) break;
			}
		}
		if(is_null($userRestrictions))
		{
			$userRestrictions = substru($location, 0, strlenu($this->users->getHome($email)))!=$this->users->getHome($email);
			$userRestrictions |= empty($fileName) || strlenu(dirname($fileName))>128 || strlenu(basename($fileName))>128;
		}
		return $userRestrictions;
	}
	
	// Return user language
	function getUserLanguage($email)
	{
		$language = $this->users->getLanguage($email);
		if(!$this->yellow->text->isLanguage($language)) $language = $this->yellow->config->get("language");
		return $language;
	}
	
	// Check if request came from same site
	function isRequestSameSite($method, $scheme, $address)
	{
		if(preg_match("#^(\w+)://([^/]+)(.*)$#", $_SERVER["HTTP_REFERER"], $matches)) $origin = "$matches[1]://$matches[2]";
		if(isset($_SERVER["HTTP_ORIGIN"])) $origin = $_SERVER["HTTP_ORIGIN"];
		return $_SERVER["REQUEST_METHOD"]==$method && $origin=="$scheme://$address";
	}
}
	
class YellowResponse
{
	var $yellow;			//access to API
	var $plugin;			//access to plugin
	var $active;			//location is active? (boolean)
	var $userEmail;			//user email
	var $userRestrictions;	//user can change page? (boolean)
	var $userFailed;		//user failed authentication? (boolean)
	var $userFailedEmail;	//email of failed authentication
	var $rawDataSource;		//raw data of page for comparison
	var $rawDataEdit;		//raw data of page for editing
	var $rawDataOutput;		//raw data of dynamic output
	var $rawDataEndOfLine;	//end of line format for raw data
	var $language;			//response language
	var $action;			//response action
	var $status;			//response status
	
	function __construct($yellow)
	{
		$this->yellow = $yellow;
		$this->plugin = $yellow->plugins->get("edit");
	}
	
	// Return new page
	function getPageNew($scheme, $address, $base, $location, $fileName, $rawData, $endOfLine)
	{
		$page = new YellowPage($this->yellow);
		$page->setRequestInformation($scheme, $address, $base, $location, $fileName);
		$page->parseData($this->normaliseLines($rawData, $endOfLine), false, 0);
		$this->editContentFile($page, "create");
		if($this->yellow->lookup->isFileLocation($location) || $this->yellow->pages->find($page->location))
		{
			$page->location = $this->getPageNewLocation($page->rawData, $page->location, $page->get("pageNewLocation"));
			$page->fileName = $this->yellow->lookup->findFileNew($page->location, $page->get("published"));
			while($this->yellow->pages->find($page->location) || empty($page->fileName))
			{
				$rawData = $this->yellow->toolbox->setMetaData($page->rawData, "title", $this->getTitleNext($page->rawData));
				$page->rawData = $this->normaliseLines($rawData, $endOfLine);
				$page->location = $this->getPageNewLocation($page->rawData, $page->location, $page->get("pageNewLocation"));
				$page->fileName = $this->yellow->lookup->findFileNew($page->location, $page->get("published"));
				if(++$pageCounter>999) break;
			}
			if($this->yellow->pages->find($page->location) || empty($page->fileName))
			{
				$page->error(500, "Page '".$page->get("title")."' is not possible!");
			}
		} else {
			$page->fileName = $this->yellow->lookup->findFileNew($page->location);
		}
		if($this->plugin->getUserRestrictions($this->userEmail, $page->location, $page->fileName))
		{
			$page->error(500, "Page '".$page->get("title")."' is restricted!");
		}
		return $page;
	}
	
	// Return modified page
	function getPageEdit($scheme, $address, $base, $location, $fileName, $rawDataSource, $rawDataEdit, $rawDataFile, $endOfLine)
	{
		$page = new YellowPage($this->yellow);
		$page->setRequestInformation($scheme, $address, $base, $location, $fileName);
		$rawData = $this->plugin->merge->merge(
			$this->normaliseLines($rawDataSource, $endOfLine),
			$this->normaliseLines($rawDataEdit, $endOfLine),
			$this->normaliseLines($rawDataFile, $endOfLine));
		$page->parseData($this->normaliseLines($rawData, $endOfLine), false, 0);
		$this->editContentFile($page, "edit");
		if(empty($page->rawData)) $page->error(500, "Page has been modified by someone else!");
		if($this->yellow->lookup->isFileLocation($location) && !$page->isError())
		{
			$pageSource = new YellowPage($this->yellow);
			$pageSource->setRequestInformation($scheme, $address, $base, $location, $fileName);
			$pageSource->parseData($this->normaliseLines($rawDataSource, $endOfLine), false, 0);
			if(substrb($pageSource->rawData, 0, $pageSource->metaDataOffsetBytes) !=
			   substrb($page->rawData, 0, $page->metaDataOffsetBytes))
			{
				$page->location = $this->getPageNewLocation($page->rawData, $page->location, $page->get("pageNewLocation"));
				$page->fileName = $this->yellow->lookup->findFileNew($page->location, $page->get("published"));
				if($page->location!=$pageSource->location)
				{
					if(!$this->yellow->lookup->isFileLocation($page->location) || empty($page->fileName))
					{
						$page->error(500, "Page '".$page->get("title")."' is not possible!");
					} else if($this->yellow->pages->find($page->location)) {
						$page->error(500, "Page '".$page->get("title")."' already exists!");
					}
				}
			}
		}
		if($this->plugin->getUserRestrictions($this->userEmail, $page->location, $page->fileName))
		{
			$page->error(500, "Page '".$page->get("title")."' is restricted!");
		}
		return $page;
	}
	
	// Return deleted page
	function getPageDelete($scheme, $address, $base, $location, $fileName, $rawData, $endOfLine)
	{
		$page = new YellowPage($this->yellow);
		$page->setRequestInformation($scheme, $address, $base, $location, $fileName);
		$page->parseData($this->normaliseLines($rawData, $endOfLine), false, 0);
		$this->editContentFile($page, "delete");
		if($this->plugin->getUserRestrictions($this->userEmail, $page->location, $page->fileName))
		{
			$page->error(500, "Page '".$page->get("title")."' is restricted!");
		}
		return $page;
	}

	// Return preview page
	function getPagePreview($scheme, $address, $base, $location, $fileName, $rawData, $endOfLine)
	{
		$page = new YellowPage($this->yellow);
		$page->setRequestInformation($scheme, $address, $base, $location, $fileName);
		$page->parseData($this->normaliseLines($rawData, $endOfLine), false, 200);
		$this->yellow->text->setLanguage($page->get("language"));
		$page->set("pageClass", "page-preview");
		$page->set("pageClass", $page->get("pageClass")." template-".$page->get("template"));
		$output = "<div class=\"".$page->getHtml("pageClass")."\"><div class=\"content\">";
		if($this->yellow->config->get("editToolbarButtons")!="none")
		{
			$output .= "<h1>".$page->getHtml("titleContent")."</h1>\n";
		}
		$output .= $page->getContent();
		$output .= "</div></div>";
		$page->setOutput($output);
		return $page;
	}
	
	// Return uploaded file
	function getFileUpload($scheme, $address, $base, $pageLocation, $fileNameTemp, $fileNameShort)
	{
		$file = new YellowPage($this->yellow);
		$file->setRequestInformation($scheme, $address, $base, "/".$fileNameTemp, $fileNameTemp);
		$file->parseData(null, false, 0);
		$file->set("fileNameShort", $fileNameShort);
		$this->editMediaFile($file, "upload");
		$file->location = $this->getFileNewLocation($fileNameShort, $pageLocation, $file->get("fileNewLocation"));
		$file->fileName = substru($file->location, 1);
		while(is_file($file->fileName))
		{
			$fileNameShort = $this->getFileNext(basename($file->fileName));
			$file->location = $this->getFileNewLocation($fileNameShort, $pageLocation, $file->get("fileNewLocation"));
			$file->fileName = substru($file->location, 1);
			if(++$fileCounter>999) break;
		}
		if(is_file($file->fileName)) $file->error(500, "File '".$file->get("fileNameShort")."' is not possible!");
		return $file;
	}

	// Return page data including status information
	function getPageData()
	{
		$data = array();
		if($this->isUser())
		{
			$data["title"] = $this->yellow->toolbox->getMetaData($this->rawDataEdit, "title");
			$data["rawDataSource"] = $this->rawDataSource;
			$data["rawDataEdit"] = $this->rawDataEdit;
			$data["rawDataNew"] = $this->getRawDataNew();
			$data["rawDataOutput"] = strval($this->rawDataOutput);
			$data["rawDataEndOfLine"] = $this->rawDataEndOfLine;
			$data["scheme"] = $this->yellow->page->scheme;
			$data["address"] = $this->yellow->page->address;
			$data["base"] = $this->yellow->page->base;
			$data["location"] = $this->yellow->page->location;
			$data["parserSafeMode"] = $this->yellow->page->parserSafeMode;
		}
		if($this->action!="none") $data = array_merge($data, $this->getRequestData());
		$data["action"] = $this->action;
		$data["status"] = $this->status;
		$data["statusCode"] = $this->yellow->page->statusCode;
		return $data;
	}
	
	// Return configuration data including user information
	function getConfigData()
	{
		$data = $this->yellow->config->getData("", "Location");
		if($this->isUser())
		{
			$data["userEmail"] = $this->userEmail;
			$data["userName"] = $this->plugin->users->getName($this->userEmail);
			$data["userLanguage"] = $this->plugin->users->getLanguage($this->userEmail);
			$data["userStatus"] = $this->plugin->users->getStatus($this->userEmail);
			$data["userHome"] = $this->plugin->users->getHome($this->userEmail);
			$data["userRestrictions"] = intval($this->isUserRestrictions());
			$data["userWebmaster"] = intval($this->isUserWebmaster());
			$data["serverScheme"] = $this->yellow->config->get("serverScheme");
			$data["serverAddress"] = $this->yellow->config->get("serverAddress");
			$data["serverBase"] = $this->yellow->config->get("serverBase");
			$data["serverFileSizeMax"] = $this->yellow->toolbox->getNumberBytes(ini_get("upload_max_filesize"));
			$data["serverVersion"] = "Datenstrom Yellow ".YellowCore::VERSION;
			$data["serverPlugins"] = array();
			foreach($this->yellow->plugins->plugins as $key=>$value)
			{
				$data["serverPlugins"][$key] = $value["plugin"];
			}
			$data["serverLanguages"] = array();
			foreach($this->yellow->text->getLanguages() as $language)
			{
				$data["serverLanguages"][$language] = $this->yellow->text->getTextHtml("languageDescription", $language);
			}
			$data["editUploadExtensions"] = $this->yellow->config->get("editUploadExtensions");
			$data["editKeyboardShortcuts"] = $this->yellow->config->get("editKeyboardShortcuts");
			$data["editToolbarButtons"] = $this->getToolbarButtons("edit");
			$data["emojiawesomeToolbarButtons"] =  $this->getToolbarButtons("emojiawesome");
			$data["fontawesomeToolbarButtons"] =  $this->getToolbarButtons("fontawesome");
		} else {
			$data["editLoginEmail"] = $this->yellow->page->get("editLoginEmail");
			$data["editLoginPassword"] = $this->yellow->page->get("editLoginPassword");
			$data["editLoginRestrictions"] = intval($this->isLoginRestrictions());
		}
		if(defined("DEBUG") && DEBUG>=1) $data["debug"] = DEBUG;
		return $data;
	}
	
	// Return request strings
	function getRequestData()
	{
		$data = array();
		foreach($_REQUEST as $key=>$value)
		{
			if($key=="password" || $key=="authtoken" || $key=="csrftoken" || substru($key, 0, 7)=="rawdata") continue;
			$data["request".ucfirst($key)] = trim($value);
		}
		return $data;
	}
	
	// Return text strings
	function getTextData()
	{
		$textLanguage = $this->yellow->text->getData("language", $this->language);
		$textEdit = $this->yellow->text->getData("edit", $this->language);
		$textYellow = $this->yellow->text->getData("yellow", $this->language);
		return array_merge($textLanguage, $textEdit, $textYellow);
	}
	
	// Return toolbar buttons
	function getToolbarButtons($name)
	{
		if($name=="edit")
		{
			$toolbarButtons = $this->yellow->config->get("editToolbarButtons");
			if($toolbarButtons=="auto")
			{
				$toolbarButtons = "";
				if($this->yellow->plugins->isExisting("markdown")) $toolbarButtons = "preview, format, bold, italic, code, list, link, file";
				if($this->yellow->plugins->isExisting("emojiawesome")) $toolbarButtons .= ", emojiawesome";
				if($this->yellow->plugins->isExisting("fontawesome")) $toolbarButtons .= ", fontawesome";
				if($this->yellow->plugins->isExisting("draft")) $toolbarButtons .= ", draft";
				if($this->yellow->plugins->isExisting("markdown")) $toolbarButtons .= ", markdown";
			}
		} else {
			$toolbarButtons = $this->yellow->config->get("{$name}ToolbarButtons");
		}
		return $toolbarButtons;
	}
	
	// Return end of line format
	function getEndOfLine($rawData = "")
	{
		$endOfLine = $this->yellow->config->get("editEndOfLine");
		if($endOfLine=="auto")
		{
			$rawData = empty($rawData) ? PHP_EOL : substru($rawData, 0, 4096);
			$endOfLine = strposu($rawData, "\r")===false ? "lf" : "crlf";
		}
		return $endOfLine;
	}
	
	// Return raw data for new page
	function getRawDataNew($location = "")
	{
		foreach($this->yellow->pages->path($this->yellow->page->location)->reverse() as $page)
		{
			if($page->isExisting("templateNew"))
			{
				$name = $this->yellow->lookup->normaliseName($page->get("templateNew"));
				$fileName = strreplaceu("(.*)", $name, $this->yellow->config->get("configDir").$this->yellow->config->get("newFile"));
				if(is_file($fileName)) break;
			}
		}
		if(!is_file($fileName))
		{
			$name = $this->yellow->lookup->normaliseName($this->yellow->config->get("template"));
			$fileName = strreplaceu("(.*)", $name, $this->yellow->config->get("configDir").$this->yellow->config->get("newFile"));
		}
		$rawData = $this->yellow->toolbox->readFile($fileName);
		$rawData = preg_replace("/@timestamp/i", time(), $rawData);
		$rawData = preg_replace("/@datetime/i", date("Y-m-d H:i:s"), $rawData);
		$rawData = preg_replace("/@date/i", date("Y-m-d"), $rawData);
		$rawData = preg_replace("/@usershort/i", strtok($this->plugin->users->getName($this->userEmail), " "), $rawData);
		$rawData = preg_replace("/@username/i", $this->plugin->users->getName($this->userEmail), $rawData);
		$rawData = preg_replace("/@userlanguage/i", $this->plugin->users->getLanguage($this->userEmail), $rawData);
		if(!empty($location))
		{
			$rawData = $this->yellow->toolbox->setMetaData($rawData, "title", $this->yellow->toolbox->createTextTitle($location));
		}
		return $rawData;
	}
	
	// Return location for new/modified page
	function getPageNewLocation($rawData, $pageLocation, $pageNewLocation)
	{
		$location = empty($pageNewLocation) ? "@title" : $pageNewLocation;
		$location = preg_replace("/@timestamp/i", $this->getPageNewData($rawData, "published", true, "U"), $location);
		$location = preg_replace("/@date/i", $this->getPageNewData($rawData, "published", true, "Y-m-d"), $location);
		$location = preg_replace("/@year/i", $this->getPageNewData($rawData, "published", true, "Y"), $location);
		$location = preg_replace("/@month/i", $this->getPageNewData($rawData, "published", true, "m"), $location);
		$location = preg_replace("/@day/i", $this->getPageNewData($rawData, "published", true, "d"), $location);
		$location = preg_replace("/@tag/i", $this->getPageNewData($rawData, "tag", true), $location);
		$location = preg_replace("/@author/i", $this->getPageNewData($rawData, "author", true), $location);
		$location = preg_replace("/@title/i", $this->getPageNewData($rawData, "title"), $location);
		if(!preg_match("/^\//", $location))
		{
			$location = $this->yellow->lookup->getDirectoryLocation($pageLocation).$location;
		}
		return $location;
	}
	
	// Return data for new/modified page
	function getPageNewData($rawData, $key, $filterFirst = false, $dateFormat = "")
	{
		$value = $this->yellow->toolbox->getMetaData($rawData, $key);
		if($filterFirst && preg_match("/^(.*?)\,(.*)$/", $value, $matches)) $value = $matches[1];
		if(!empty($dateFormat)) $value = date($dateFormat, strtotime($value));
		if(strempty($value)) $value = "none";
		$value = $this->yellow->lookup->normaliseName($value, true, false, true);
		return trim(preg_replace("/-+/", "-", $value), "-");
	}

	// Return location for new file
	function getFileNewLocation($fileNameShort, $pageLocation, $fileNewLocation)
	{
		$location = empty($fileNewLocation) ? $this->yellow->config->get("editUploadNewLocation") : $fileNewLocation;
		$location = preg_replace("/@timestamp/i", time(), $location);
		$location = preg_replace("/@type/i", $this->yellow->toolbox->getFileType($fileNameShort), $location);
		$location = preg_replace("/@group/i", $this->getFileNewGroup($fileNameShort), $location);
		$location = preg_replace("/@folder/i", $this->getFileNewFolder($pageLocation), $location);
		$location = preg_replace("/@filename/i", strtoloweru($fileNameShort), $location);
		if(!preg_match("/^\//", $location))
		{
			$location = $this->yellow->config->get("mediaLocation").$location;
		}
		return $location;
	}
	
	// Return group for new file
	function getFileNewGroup($fileNameShort)
	{
		$path = $this->yellow->config->get("mediaDir");
		$fileType = $this->yellow->toolbox->getFileType($fileNameShort);
		$fileName = $this->yellow->config->get(preg_match("/(gif|jpg|png|svg)$/", $fileType) ? "imageDir" : "downloadDir").$fileNameShort;
		preg_match("#^$path(.+?)\/#", $fileName, $matches);
		return strtoloweru($matches[1]);
	}

	// Return folder for new file
	function getFileNewFolder($pageLocation)
	{
		$parentTopLocation = $this->yellow->pages->getParentTopLocation($pageLocation);
		if($parentTopLocation==$this->yellow->pages->getHomeLocation($pageLocation)) $parentTopLocation .= "home";
		return strtoloweru(trim($parentTopLocation, '/'));
	}
	
	// Return next title
	function getTitleNext($rawData)
	{
		preg_match("/^(.*?)(\d*)$/", $this->yellow->toolbox->getMetaData($rawData, "title"), $matches);
		$titleText = $matches[1];
		$titleNumber = strempty($matches[2]) ? " 2" : $matches[2]+1;
		return $titleText.$titleNumber;
	}
	
	// Return next file name
	function getFileNext($fileNameShort)
	{
		preg_match("/^(.*?)(\d*)(\..*?)?$/", $fileNameShort, $matches);
		$fileText = $matches[1];
		$fileNumber = strempty($matches[2]) ? "-2" : $matches[2]+1;
		$fileExtension = $matches[3];
		return $fileText.$fileNumber.$fileExtension;
	}

	// Normalise text lines, convert line endings
	function normaliseLines($text, $endOfLine = "lf")
	{
		if($endOfLine=="lf")
		{
			$text = preg_replace("/\R/u", "\n", $text);
		} else {
			$text = preg_replace("/\R/u", "\r\n", $text);
		}
		return $text;
	}
	
	// Create browser cookies
	function createCookies($scheme, $address, $base, $email)
	{
		$authToken = $this->plugin->users->createAuthToken($email);
		$csrfToken = $this->plugin->users->createCsrfToken();
		$timeout = $this->yellow->config->get("editLoginSessionTimeout");
		setcookie("authtoken", $authToken, $timeout ? time()+$timeout : 0, "$base/", "", $scheme=="https", true);
		setcookie("csrftoken", $csrfToken, $timeout ? time()+$timeout : 0, "$base/", "", $scheme=="https", false);
	}
	
	// Destroy browser cookies
	function destroyCookies($scheme, $address, $base)
	{
		setcookie("authtoken", "", 1, "$base/", "", $scheme=="https", true);
		setcookie("csrftoken", "", 1, "$base/", "", $scheme=="https", false);
	}
	
	// Send mail to user
	function sendMail($scheme, $address, $base, $email, $action)
	{
		if($action=="welcome" || $action=="information")
		{
			$url = "$scheme://$address$base/";
		} else {
			$expire = time()+60*60*24;
			$id = $this->plugin->users->createRequestId($email, $action, $expire);
			$url = "$scheme://$address$base"."/action:$action/email:$email/expire:$expire/id:$id/";
		}
		if($action=="approve")
		{
			$account = $email;
			$name = $this->yellow->config->get("author");
			$email = $this->yellow->config->get("email");
		} else {
			$account = $email;
			$name = $this->plugin->users->getName($email);
		}
		$language = $this->plugin->users->getLanguage($email);
		if(!$this->yellow->text->isLanguage($language)) $language = $this->yellow->config->get("language");
		$sitename = $this->yellow->config->get("sitename");
		$prefix = "edit".ucfirst($action);
		$message = $this->yellow->text->getText("{$prefix}Message", $language);
		$message = preg_replace("/@useraccount/i", $account, $message);
		$message = preg_replace("/@usershort/i", strtok($name, " "), $message);
		$message = preg_replace("/@username/i", $name, $message);
		$message = preg_replace("/@userlanguage/i", $language, $message);
		$mailTo = mb_encode_mimeheader("$name")." <$email>";
		$mailSubject = mb_encode_mimeheader($this->yellow->text->getText("{$prefix}Subject", $language));
		$mailHeaders = mb_encode_mimeheader("From: $sitename")." <noreply>\r\n";
		$mailHeaders .= mb_encode_mimeheader("X-Request-Url: $scheme://$address$base")."\r\n";
		$mailHeaders .= mb_encode_mimeheader("X-Remote-Addr: $_SERVER[REMOTE_ADDR]")."\r\n";
		$mailHeaders .= "Mime-Version: 1.0\r\n";
		$mailHeaders .= "Content-Type: text/plain; charset=utf-8\r\n";
		$mailMessage = "$message\r\n\r\n$url\r\n-- \r\n$sitename";
		return mail($mailTo, $mailSubject, $mailMessage, $mailHeaders);
	}
	
	// Change content file
	function editContentFile($page, $action)
	{
		if(!$page->isError())
		{
			foreach($this->yellow->plugins->plugins as $key=>$value)
			{
				if(method_exists($value["obj"], "onEditContentFile")) $value["obj"]->onEditContentFile($page, $action);
			}
		}
	}

	// Change media file
	function editMediaFile($file, $action)
	{
		if(!$file->isError())
		{
			foreach($this->yellow->plugins->plugins as $key=>$value)
			{
				if(method_exists($value["obj"], "onEditMediaFile")) $value["obj"]->onEditMediaFile($file, $action);
			}
		}
	}
	
	// Check if active
	function isActive()
	{
		return $this->active;
	}
	
	// Check if user is logged in
	function isUser()
	{
		return !empty($this->userEmail);
	}
	
	// Check if user has restrictions
	function isUserRestrictions()
	{
		return empty($this->userEmail) || $this->userRestrictions;
	}
	
	// Check if user is webmaster
	function isUserWebmaster()
	{
		return !empty($this->userEmail) && $this->userEmail==$this->yellow->config->get("email");
	}
	
	// Check if login has restrictions
	function isLoginRestrictions()
	{
		return $this->yellow->config->get("editLoginRestrictions");
	}
}

class YellowUsers
{
	var $yellow;	//access to API
	var $users;		//registered users
	
	function __construct($yellow)
	{
		$this->yellow = $yellow;
		$this->users = array();
	}

	// Load users from file
	function load($fileName)
	{
		if(defined("DEBUG") && DEBUG>=2) echo "YellowUsers::load file:$fileName<br/>\n";
		$fileData = $this->yellow->toolbox->readFile($fileName);
		foreach($this->yellow->toolbox->getTextLines($fileData) as $line)
		{
			if(preg_match("/^\#/", $line)) continue;
			preg_match("/^\s*(.*?)\s*:\s*(.*?)\s*$/", $line, $matches);
			if(!empty($matches[1]) && !empty($matches[2]))
			{
				list($hash, $name, $language, $status, $stamp, $modified, $errors, $pending, $home) = explode(',', $matches[2]);
				if($errors=="none") { $home=$pending; $pending=$errors; $errors=$modified; $modified=$stamp; $stamp=$matches[1]; } //TODO: remove later
				$this->set($matches[1], $hash, $name, $language, $status, $stamp, $modified, $errors, $pending, $home);
				if(defined("DEBUG") && DEBUG>=3) echo "YellowUsers::load email:$matches[1]<br/>\n";
			}
		}
	}
	
	// Clean users in file
	function clean($fileName)
	{
		$fileData = $this->yellow->toolbox->readFile($fileName);
		foreach($this->yellow->toolbox->getTextLines($fileData) as $line)
		{
			preg_match("/^\s*(.*?)\s*:\s*(.*?)\s*$/", $line, $matches);
			if(!empty($matches[1]) && !empty($matches[2]))
			{
				list($hash, $name, $language, $status, $stamp, $modified, $errors, $pending, $home) = explode(',', $matches[2]);
				if($errors=="none") { $home=$pending; $pending=$errors; $errors=$modified; $modified=$stamp; $stamp=$this->createStamp(); } //TODO: remove later
				if(strlenu($stamp)!=20) $stamp=$this->createStamp(); //TODO: remove later, converts old file format
				if($status=="active" || $status=="inactive")
				{
					$pending = "none";
					$fileDataNew .= "$matches[1]: $hash,$name,$language,$status,$stamp,$modified,$errors,$pending,$home\n";
				}
			} else {
				$fileDataNew .= $line;
			}
		}
		return $this->yellow->toolbox->createFile($fileName, $fileDataNew);
	}
	
	// Update users in file
	function update($fileName, $email, $password = "", $name = "", $language = "", $status = "", $stamp = "", $modified = "", $errors = "", $pending = "", $home = "")
	{
		if(!empty($password)) $hash = $this->createHash($password);
		if($this->isExisting($email))
		{
			$email = strreplaceu(',', '-', $email);
			$hash = strreplaceu(',', '-', empty($hash) ? $this->users[$email]["hash"] : $hash);
			$name = strreplaceu(',', '-', empty($name) ? $this->users[$email]["name"] : $name);
			$language = strreplaceu(',', '-', empty($language) ? $this->users[$email]["language"] : $language);
			$status = strreplaceu(',', '-', empty($status) ? $this->users[$email]["status"] : $status);
			$stamp = strreplaceu(',', '-', empty($stamp) ? $this->users[$email]["stamp"] : $stamp);
			$modified = strreplaceu(',', '-', empty($modified) ? time() : $modified);
			$errors = strreplaceu(',', '-', empty($errors) ? "0" : $errors);
			$pending = strreplaceu(',', '-', empty($pending) ? $this->users[$email]["pending"] : $pending);
			$home = strreplaceu(',', '-', empty($home) ? $this->users[$email]["home"] : $home);
		} else {
			$email = strreplaceu(',', '-', empty($email) ? "none" : $email);
			$hash = strreplaceu(',', '-', empty($hash) ? "none" : $hash);
			$name = strreplaceu(',', '-', empty($name) ? $this->yellow->config->get("sitename") : $name);
			$language = strreplaceu(',', '-', empty($language) ? $this->yellow->config->get("language") : $language);
			$status = strreplaceu(',', '-', empty($status) ? $this->yellow->config->get("editUserStatus") : $status);
			$stamp = strreplaceu(',', '-', empty($stamp) ? $this->createStamp() : $stamp);
			$modified = strreplaceu(',', '-', empty($modified) ? time() : $modified);
			$errors = strreplaceu(',', '-', empty($errors) ? "0" : $errors);
			$pending = strreplaceu(',', '-', empty($pending) ? "none" : $pending);
			$home = strreplaceu(',', '-', empty($home) ? $this->yellow->config->get("editUserHome") : $home);
		}
		$this->set($email, $hash, $name, $language, $status, $stamp, $modified, $errors, $pending, $home);
		$fileData = $this->yellow->toolbox->readFile($fileName);
		foreach($this->yellow->toolbox->getTextLines($fileData) as $line)
		{
			preg_match("/^\s*(.*?)\s*:\s*(.*?)\s*$/", $line, $matches);
			if(!empty($matches[1]) && $matches[1]==$email)
			{
				$fileDataNew .= "$email: $hash,$name,$language,$status,$stamp,$modified,$errors,$pending,$home\n";
				$found = true;
			} else {
				$fileDataNew .= $line;
			}
		}
		if(!$found) $fileDataNew .= "$email: $hash,$name,$language,$status,$stamp,$modified,$errors,$pending,$home\n";
		return $this->yellow->toolbox->createFile($fileName, $fileDataNew);
	}

	// Set user data
	function set($email, $hash, $name, $language, $status, $stamp, $modified, $errors, $pending, $home)
	{
		$this->users[$email] = array();
		$this->users[$email]["email"] = $email;
		$this->users[$email]["hash"] = $hash;
		$this->users[$email]["name"] = $name;
		$this->users[$email]["language"] = $language;
		$this->users[$email]["status"] = $status;
		$this->users[$email]["stamp"] = $stamp;
		$this->users[$email]["modified"] = $modified;
		$this->users[$email]["errors"] = $errors;
		$this->users[$email]["pending"] = $pending;
		$this->users[$email]["home"] = $home;
	}
	
	// Check user authentication from email and password
	function checkAuthLogin($email, $password)
	{
		$algorithm = $this->yellow->config->get("editUserHashAlgorithm");
		return $this->isExisting($email) && $this->users[$email]["status"]=="active" &&
			$this->yellow->toolbox->verifyHash($password, $algorithm, $this->users[$email]["hash"]);
	}

	// Check user authentication from tokens
	function checkAuthToken($authToken, $csrfTokenExpected, $csrfTokenReceived, $ignoreCsrfToken)
	{
		$session = "$5y$".substru($authToken, 0, 96);
		$email = $this->getAuthEmail($authToken);
		return $this->isExisting($email) && $this->users[$email]["status"]=="active" &&
			$this->yellow->toolbox->verifyHash($this->users[$email]["hash"], "sha256", $session) &&
			($this->verifyToken($csrfTokenExpected, $csrfTokenReceived) || $ignoreCsrfToken);
	}
	
	// Create authentication token
	function createAuthToken($email)
	{
		$session = $this->yellow->toolbox->createHash($this->users[$email]["hash"], "sha256");
		if(empty($session)) $session = "padd"."error-hash-algorithm-sha256";
		return substru($session, 4).$this->getStamp($email);
	}
	
	// Create CSRF token
	function createCsrfToken()
	{
		return $this->yellow->toolbox->createSalt(64);
	}
	
	// Create user stamp
	function createStamp()
	{
		$stamp = $this->yellow->toolbox->createSalt(20);
		while($this->getAuthEmail("none", $stamp)) $stamp = $this->yellow->toolbox->createSalt(20);
		return $stamp;
	}
	
	// Create password hash
	function createHash($password)
	{
		$algorithm = $this->yellow->config->get("editUserHashAlgorithm");
		$cost = $this->yellow->config->get("editUserHashCost");
		$hash = $this->yellow->toolbox->createHash($password, $algorithm, $cost);
		if(empty($hash)) $hash = "error-hash-algorithm-$algorithm";
		return $hash;
	}
	
	// Create request ID for action
	function createRequestId($email, $action, $expire)
	{
		$id = $this->yellow->toolbox->createHash($this->users[$email]["hash"].$action.$expire, "sha256");
		if(empty($id)) $hash = "error-hash-algorithm-sha256";
		return $id;
	}
	
	// Return response status for action
	function getResponseStatus($email, $action, $expire, $id)
	{
		$status = "done";
		switch($action)
		{
			case "confirm":		$statusExpected = "unconfirmed"; break;
			case "reconfirm":	$statusExpected = "unconfirmed"; break;
			case "approve":		$statusExpected = "unapproved"; break;
			case "reactivate":	$statusExpected = "inactive"; break;
			default:			$statusExpected = "active"; break;
		}
		if($this->isExisting($email) && $this->users[$email]["status"]==$statusExpected &&
		   $this->yellow->toolbox->verifyHash($this->users[$email]["hash"].$action.$expire, "sha256", $id))
		{
			$status = "ok";
		}
		if($expire<=time()) $status = "expired";
		return $status;
	}

	// Return user email from authentication, timing attack safe email lookup
	function getAuthEmail($authToken, $stamp = "")
	{
		if(empty($stamp)) $stamp = substru($authToken, 96);
		foreach($this->users as $key=>$value)
		{
			if($this->verifyToken($value["stamp"], $stamp)) $email = $key;
		}
		return $email;
	}
	
	// Return user hash
	function getHash($email)
	{
		return $this->isExisting($email) ? $this->users[$email]["hash"] : "";
	}
	
	// Return user name
	function getName($email)
	{
		return $this->isExisting($email) ? $this->users[$email]["name"] : "";
	}

	// Return user language
	function getLanguage($email)
	{
		return $this->isExisting($email) ? $this->users[$email]["language"] : "";
	}	
	
	// Return user status
	function getStatus($email)
	{
		return $this->isExisting($email) ? $this->users[$email]["status"] : "";
	}
	
	// Return user stamp
	function getStamp($email)
	{
		return $this->isExisting($email) ? $this->users[$email]["stamp"] : "";
	}
	
	// Return user modified
	function getModified($email)
	{
		return $this->isExisting($email) ? $this->users[$email]["modified"] : "";
	}

	// Return user errors
	function getErrors($email)
	{
		return $this->isExisting($email) ? $this->users[$email]["errors"] : "";
	}

	// Return user pending
	function getPending($email)
	{
		return $this->isExisting($email) ? $this->users[$email]["pending"] : "";
	}
	
	// Return user home
	function getHome($email)
	{
		return $this->isExisting($email) ? $this->users[$email]["home"] : "";
	}
	
	// Return number of users
	function getNumber()
	{
		return count($this->users);
	}

	// Return user data
	function getData()
	{
		$data = array();
		foreach($this->users as $key=>$value)
		{
			$name = $value["name"]; if(preg_match("/\s/", $name)) $name = "\"$name\"";
			$language = $value["language"]; if(preg_match("/\s/", $language)) $language = "\"$language\"";
			$status = $value["status"]; if(preg_match("/\s/", $status)) $status = "\"$status\"";
			$data[$key] = "$value[email] - $name $language $status";
			if($value["home"]!="/") $data[$key] .= " restrictions";
		}
		uksort($data, "strnatcasecmp");
		return $data;
	}
	
	// Verify that token is not empty and identical, timing attack safe text string comparison
	function verifyToken($tokenExpected, $tokenReceived) //TODO: remove later, use directly from core after next release
	{
		$ok = false;
		$lengthExpected = strlenb($tokenExpected);
		$lengthReceived = strlenb($tokenReceived);
		if($lengthExpected!=0 && $lengthReceived!=0)
		{
			$ok = $lengthExpected==$lengthReceived;
			for($i=0; $i<$lengthReceived; ++$i) $ok &= $tokenExpected[$i<$lengthExpected ? $i : 0]==$tokenReceived[$i];
		}
		return $ok;
	}
	
	// Check if user is taken
	function isTaken($email)
	{
		$taken = false;
		if($this->isExisting($email))
		{
			$status = $this->users[$email]["status"];
			$reserved = $this->users[$email]["modified"] + 60*60*24;
			if($status=="active" || $status=="inactive" || $reserved>time()) $taken = true;
		}
		return $taken;
	}
	
	// Check if user exists
	function isExisting($email)
	{
		return !is_null($this->users[$email]);
	}
}
	
class YellowMerge
{
	var $yellow;		//access to API
	const ADD = '+';	//merge types
	const MODIFY = '*';
	const REMOVE = '-';
	const SAME = ' ';
	
	function __construct($yellow)
	{
		$this->yellow = $yellow;
	}
	
	// Merge text, null if not possible
	function merge($textSource, $textMine, $textYours, $showDiff = false)
	{
		if($textMine!=$textYours)
		{
			$diffMine = $this->buildDiff($textSource, $textMine);
			$diffYours = $this->buildDiff($textSource, $textYours);
			$diff = $this->mergeDiff($diffMine, $diffYours);
			$output = $this->getOutput($diff, $showDiff);
		} else {
			$output = $textMine;
		}
		return $output;
	}
	
	// Build differences to common source
	function buildDiff($textSource, $textOther)
	{
		$diff = array();
		$lastRemove = -1;
		$textStart = 0;
		$textSource = $this->yellow->toolbox->getTextLines($textSource);
		$textOther = $this->yellow->toolbox->getTextLines($textOther);
		$sourceEnd = $sourceSize = count($textSource);
		$otherEnd = $otherSize = count($textOther);
		while($textStart<$sourceEnd && $textStart<$otherEnd && $textSource[$textStart]==$textOther[$textStart]) ++$textStart;
		while($textStart<$sourceEnd && $textStart<$otherEnd && $textSource[$sourceEnd-1]==$textOther[$otherEnd-1])
		{
			--$sourceEnd; --$otherEnd;
		}
		for($pos=0; $pos<$textStart; ++$pos) array_push($diff, array(YellowMerge::SAME, $textSource[$pos], false));
		$lcs = $this->buildDiffLCS($textSource, $textOther, $textStart, $sourceEnd-$textStart, $otherEnd-$textStart);
		for($x=0,$y=0,$xEnd=$otherEnd-$textStart,$yEnd=$sourceEnd-$textStart; $x<$xEnd || $y<$yEnd;)
		{
			$max = $lcs[$y][$x];
			if($y<$yEnd && $lcs[$y+1][$x]==$max)
			{
				array_push($diff, array(YellowMerge::REMOVE, $textSource[$textStart+$y], false));
				if($lastRemove==-1) $lastRemove = count($diff)-1;
				++$y;
				continue;
			}
			if($x<$xEnd && $lcs[$y][$x+1]==$max)
			{
				if($lastRemove==-1 || $diff[$lastRemove][0]!=YellowMerge::REMOVE)
				{
					array_push($diff, array(YellowMerge::ADD, $textOther[$textStart+$x], false));
					$lastRemove = -1;
				} else {
					$diff[$lastRemove] = array(YellowMerge::MODIFY, $textOther[$textStart+$x], false);
					++$lastRemove; if(count($diff)==$lastRemove) $lastRemove = -1;
				}
				++$x;
				continue;
			}
			array_push($diff, array(YellowMerge::SAME, $textSource[$textStart+$y], false));
			$lastRemove = -1;
			++$x;
			++$y;
		}
		for($pos=$sourceEnd;$pos<$sourceSize; ++$pos) array_push($diff, array(YellowMerge::SAME, $textSource[$pos], false));
		return $diff;
	}
	
	// Build longest common subsequence
	function buildDiffLCS($textSource, $textOther, $textStart, $yEnd, $xEnd)
	{
		$lcs = array_fill(0, $yEnd+1, array_fill(0, $xEnd+1, 0));
		for($y=$yEnd-1; $y>=0; --$y)
		{
			for($x=$xEnd-1; $x>=0; --$x)
			{
				if($textSource[$textStart+$y]==$textOther[$textStart+$x])
				{
					$lcs[$y][$x] = $lcs[$y+1][$x+1]+1;
				} else {
					$lcs[$y][$x] = max($lcs[$y][$x+1], $lcs[$y+1][$x]);
				}
			}
		}
		return $lcs;
	}
	
	// Merge differences
	function mergeDiff($diffMine, $diffYours)
	{
		$diff = array();
		$posMine = $posYours = 0;
		while($posMine<count($diffMine) && $posYours<count($diffYours))
		{
			$typeMine = $diffMine[$posMine][0];
			$typeYours = $diffYours[$posYours][0];
			if($typeMine==YellowMerge::SAME)
			{
				array_push($diff, $diffYours[$posYours]);
			} else if($typeYours==YellowMerge::SAME) {
				array_push($diff, $diffMine[$posMine]);
			} else if($typeMine==YellowMerge::ADD && $typeYours==YellowMerge::ADD) {
				$this->mergeConflict($diff, $diffMine[$posMine], $diffYours[$posYours], false);
			} else if($typeMine==YellowMerge::MODIFY && $typeYours==YellowMerge::MODIFY) {
				$this->mergeConflict($diff, $diffMine[$posMine], $diffYours[$posYours], false);
			} else if($typeMine==YellowMerge::REMOVE && $typeYours==YellowMerge::REMOVE) {
				array_push($diff, $diffMine[$posMine]);
			} else if($typeMine==YellowMerge::ADD) {
				array_push($diff, $diffMine[$posMine]);
			} else if($typeYours==YellowMerge::ADD) {
				array_push($diff, $diffYours[$posYours]);
			} else {
				$this->mergeConflict($diff, $diffMine[$posMine], $diffYours[$posYours], true);
			}
			if(defined("DEBUG") && DEBUG>=2) echo "YellowMerge::mergeDiff $typeMine $typeYours pos:$posMine\t$posYours<br/>\n";
			if($typeMine==YellowMerge::ADD || $typeYours==YellowMerge::ADD)
			{
				if($typeMine==YellowMerge::ADD) ++$posMine;
				if($typeYours==YellowMerge::ADD) ++$posYours;
			} else {
				++$posMine;
				++$posYours;
			}
		}
		for(;$posMine<count($diffMine); ++$posMine)
		{
			array_push($diff, $diffMine[$posMine]);
			$typeMine = $diffMine[$posMine][0]; $typeYours = ' ';
			if(defined("DEBUG") && DEBUG>=2) echo "YellowMerge::mergeDiff $typeMine $typeYours pos:$posMine\t$posYours<br/>\n";
		}
		for(;$posYours<count($diffYours); ++$posYours)
		{
			array_push($diff, $diffYours[$posYours]);
			$typeYours = $diffYours[$posYours][0]; $typeMine = ' ';
			if(defined("DEBUG") && DEBUG>=2) echo "YellowMerge::mergeDiff $typeMine $typeYours pos:$posMine\t$posYours<br/>\n";
		}
		return $diff;
	}
	
	// Merge potential conflict
	function mergeConflict(&$diff, $diffMine, $diffYours, $conflict)
	{
		if(!$conflict && $diffMine[1]==$diffYours[1])
		{
			array_push($diff, $diffMine);
		} else {
			array_push($diff, array($diffMine[0], $diffMine[1], true));
			array_push($diff, array($diffYours[0], $diffYours[1], true));
		}
	}
	
	// Return merged text, null if not possible
	function getOutput($diff, $showDiff = false)
	{
		$output = "";
		if(!$showDiff)
		{
			for($i=0; $i<count($diff); ++$i)
			{
				if($diff[$i][0]!=YellowMerge::REMOVE) $output .= $diff[$i][1];
				$conflict |= $diff[$i][2];
			}
		} else {
			for($i=0; $i<count($diff); ++$i)
			{
				$output .= $diff[$i][2] ? "! " : $diff[$i][0].' ';
				$output .= $diff[$i][1];
			}
		}
		return !$conflict ? $output : null;
	}
}

$yellow->plugins->register("edit", "YellowEdit", YellowEdit::VERSION);
?>
