WHMCS module to handle provisioing of domains on the Namecrane Mail platform.

*This is still in Beta, feedback is welcome!*

***WHMCS Tutorial***

1) Login to NameCrane and view the CraneMail management Portal.
2) Pull down the <code>Reseller Tools</code> menu option and pick <code>API Key</code>.
3) Click the `Refresh` icon incase you don't already have an API key.
4) Upload the module to your WHMCS install
5) Add a `Server`, picking `Namecrane Mail` from the module list
6) For the `Hostname`, just put `namecrane.com`. This value isn't used at the moment, so it doesn't matter.
7) Place the `API KEY` in the `Access Hash` textarea.
8) Create your plans, specifying `Namecrane Mail` as the module.

***Missing Features***

- need to implement the `UsageUpdate` function to update storage usage.
- add `logModuleCall` to some of the exceptions in `namecranemail_execute()`
- Pulling resellers whitelabel domain and use that in place of our included whitelabel domain
- Implement SSO for Spamexperts Domain Administrator access?

