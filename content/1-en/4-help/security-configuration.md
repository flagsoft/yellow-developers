---
Title: Security configuration
---
Here's how to set up security and privacy.

## Data encryption

Check if your website supports [data encryption](https://www.ssllabs.com/ssltest/). When there are problems, please contact your web hosting provider. It's best if your website automatically redirects from HTTP to HTTPS and the Internet connection is always encrypted.

## Login restrictions

If you don't want user accounts to be created in the web browser, then restrict the [login page](https://github.com/datenstrom/yellow-extensions/tree/master/features/edit). Open file `system/settings/system.ini` and change `EditLoginRestrictions: 1`. Users are allowed to log in, but cannot create new user accounts.

## User restrictions

If you don't want pages to be changed in the web browser, then restrict [user accounts](adjusting-system#user-accounts). Open file `system/settings/user.ini` and at the end of the line change the user's home page. Users are allowed to edit pages within their home page, but nowhere else.

## Safe mode

If you want to protect your website from various nuisance, then restrict features. Open file `system/settings/system.ini` and change `SafeMode: 1`. Users are allowed to use [Markdown](markdown-cheat-sheet), but HTML and other features are restricted.

[Next: Server configuration →](server-configuration)