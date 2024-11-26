WHMCS module to handle provisioning of domains on the Namecrane Mail platform.

*This is still in Beta, feedback is welcome!*

***WHMCS Tutorial***

1) Login to NameCrane and view the CraneMail management Portal.
2) Pull down the <code>Reseller Tools</code> menu option and pick <code>API Key</code>.
3) Click the `Refresh` icon incase you don't already have an API key.
4) Upload the module to your WHMCS install
5) Add a `Server`, picking `Namecrane Mail` from the module list
6) For the `Hostname`, just put `workspace.org`. This value isn't used at the moment, so it doesn't matter.
7) Place the `API KEY` in the `Access Hash` textarea.
8) Create your plans, specifying `Namecrane Mail` as the module.

***Missing Features***

- need to implement the `UsageUpdate` function to update storage usage.
- add `logModuleCall` to some of the exceptions in `namecranemail_execute()`
- Pulling resellers whitelabel domain and use that in place of our included whitelabel domain

***Order time customizing (À la carte)***

You can to add `Configuration Options` to allow users to on-demand customize their resources. These values override whatever is set in the plan itself.

A value must be split by a pipe character (`|`) and must have the below `Option Name` on the left side of the pipe.
You can then put your own description on the right side seen in the example.

***If you're using this feature, we recommend setting the limits to **0** inside of your packages to stop any confusion.***

Available values:

| Option Name | Example | Type | Description |
| ------------| ------- | ---- | ----------- |
| `userlimit` | `userlimit\|User Emails` | `quantity` | How many email accounts the domain may have |
| `disklimit` | `disklimit\|Disk Storage (GB)` | `quantity` | Total disk storage available (GB) |
| `useraliaslimit` | `useraliaslimit\|User Aliases` | `quantity` | How many email aliases the domain may have | 
| `spamexperts` | `spamexperts\|Spamexperts` | `yesno` | Enable SpamExperts anti spam filtering on the domain | 
| `domainaliaslimit` | `domainaliaslimit\|Domain Aliases` | `quantity` | How many domain aliases the domain may have |
| `archive_years` | `archive_years\|Email Archiving (years)` | `dropdown` | How many years to archive emails for |
| `archive_direction` | `archive_direction\|Email Archiving Direction` | `dropdown` (values `in`, `out,` `inout`) | Archive incoming, outgoing, or both, emails |
| `filestorage` | `filestorage\|Online Web Drive` | `yesno` | Enable the online File Storage & Sharing |
| `office` | `office\|Office Suite` | `yesno` | Enable the online Document creating & editing feature suite |


***Archiving Years Options***

| Value | Description |
|-|-|
| `0` | `Disabled` |
| `1` | `1 Year` |
| `2` | `2 Years` |
| `3` | `3 Years` |
| `4` | `4 Years` |
| `5` | `5 Years` |
| `6` | `6 Years` |
| `7` | `7 Years` |
| `8` | `8 Years` |
| `9` | `9 Years` |
| `10` | `10 Years` |
| `15` | `15 Years` |
| `20` | `20 Years` |

