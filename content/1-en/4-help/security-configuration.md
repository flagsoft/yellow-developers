---
Title: Security configuration
---
Here's how to set up security and privacy.

## Data encryption

Check if your website supports [data encryption](https://www.ssllabs.com/ssltest/). When there are problems, please contact your web hosting provider. It's best if your website automatically redirects from HTTP to HTTPS and the Internet connection is always encrypted.

## Login restrictions

If you don't want user accounts to be created in the web browser, then restrict the [login page](https://github.com/datenstrom/yellow-plugins/tree/master/edit). Open file `system/config/config.ini` and change `EditLoginRestrictions: 1`. Users are allowed to log in, but cannot create user accounts.

## User restrictions

If you don't want pages to be changed in the web browser, then restrict [user accounts](adjusting-system#user-accounts). Open file `system/config/user.ini` and at the end of the line change the user's home page. Users are only allowed to edit pages within their home page.

## Safe mode

If you want to protect your website from nuisance, then restrict further features. Open file `system/config/config.ini` and change `SafeMode: 1`. Users are no longer allowed to use HTML and JavaScript, [Markdown](markdown-cheat-sheet) and other features are restricted.

[Next: Server configuration →](server-configuration)