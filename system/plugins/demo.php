<?php
// Demo plugin, https://github.com/datenstrom/yellow-developers
// Copyright (c) 2013-2018 Datenstrom, https://datenstrom.se
// This file may be used and distributed under the terms of the public license.

class YellowDemo {
    const VERSION = "0.7.4";
    public $yellow;         //access to API

    // Handle initialisation
    public function onLoad($yellow) {
        $this->yellow = $yellow;
    }
    
    // Handle page meta data
    public function onParseMeta($page) {
        if ($page==$this->yellow->page) {
            $prefix = strtoloweru($this->yellow->text->getText("LanguageDescription", $page->get("language")));
            $page->set("editLoginEmail", "$prefix@demo.com");
            $page->set("editLoginPassword", "password");
        }
    }
}
