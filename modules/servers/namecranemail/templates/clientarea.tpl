{if $error}
<div class="alert alert-danger alert-block">
    {$error}
</div>
{else}  

<div class="row">
  <div class="col-12 text-right">
      {if $info['spamexperts']}
      <a href="clientarea.php?action=productdetails&id={$serviceid}&modop=custom&a=ssoSpamExperts" class="btn btn-success" target="_blank">Login to SpamExperts</a>
      {/if}
      <a href="https://workspace.org" class="btn btn-primary" target="_blank">Open Login Page</a>
  </div>
</div>

<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" href="#" data-toggle="tab" data-target="#nav-resources" role="tab" aria-controls="nav-home" aria-selected="true">Resource Usage</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#" data-toggle="tab" data-target="#nav-dns" role="tab" aria-controls="nav-home" aria-selected="true">DNS Records</a>
  </li>
  {if $dkim}
  <li class="nav-item">
    <a class="nav-link" href="#" data-toggle="tab" data-target="#nav-dkim" role="tab" aria-controls="nav-home" aria-selected="true">DKIM Records</a>
  </li>
  {/if}
</ul>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-resources" role="tabpanel" style="padding-top: 10px;">
    <table cellspacing="0" cellpadding="3">
      <thead>
        <th>Resource</th>
        <th>Usage / Limit</th>
        <th>Resource</th>
        <th>Usage / Limit</th>
      </thead>
      <tbody>
        <tr>
          <td class="fieldarea">Disk Space</td>
          <td>{$info['diskusage'] / 1024} GB / <strong>{$info['disklimit'] / 1024} GB</strong></td>
          <td class="fieldarea">Email Users</td>
          <td>{$info['usercount']} / <strong>{if $info['userlimit']}{$info['userlimit']}{else}&infin;{/if}</strong></td>
        </tr>
        <tr>
          <td class="fieldarea">SpamExperts Anti Spam</td>
          <td><strong>{if $info['spamexperts']}Enabled{else}Disabled{/if}</strong></td>
          <td class="fieldarea">Email Aliases</td>
          <td>{$info['useraliascount']} / <strong>{if $info['useraliaslimit']}{$info['useraliaslimit']}{else}&infin;{/if}</strong></td>
        </tr>
        <tr>
          <td class="fieldarea">Email Archiving</td>
          <td><strong>{if $info['archive_years']}Enabled{else}Disabled{/if}</strong></td>
          <td class="fieldarea">Domain Aliases</td>
          <td>{$info['domainaliascount']} / <strong>{if $info['domainaliaslimit']}{$info['domainaliaslimit']}{else}&infin;{/if}</strong></td>
        </tr>
        <tr>
          <td class="fieldarea">Archive Direction</td>
          <td>
            <strong>
            {if $info['archive_direction'] == 'in'}
              Incoming Only
            {elseif $info['archive_direction'] == 'out'}
              Outgoing Only
            {elseif $info['archive_direction'] == 'inout'}
              Incoming + Outgoing
            {/if}
            </strong>
          </td>              
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td colspan="4" class="fieldarea text-right">Last Updated: <strong>{$info['lastupdated']}</strong></td>
        </tr>        
      </tbody>
    </table>
  </div>
  <div class="tab-pane fade" id="nav-dns" role="tabpanel" style="padding-top: 10px;">
    <table cellspacing="0" cellpadding="3">
      <thead>
        <th>Type</th>
        <th>Name / Host</th>
        <th>Value</th>
      </thead>
      <tbody>
      {foreach from=$dns item=$record}
        <tr>
          <td>{$record['type']}</td>
          <td>{$record['record']}{if $record['record'] == '@'} or {$vars['domain']}.{/if}</td>
          <td>
            <code>{$record['value']}</code>
            {if $record['prio']} (priority: <code>{$record['prio']})</code>{/if}    
          </td>
        </tr>
      {/foreach}
      </tbody>
    </table>
  </div>
  {if $dkim}
  <div class="tab-pane fade" id="nav-dkim" role="tabpanel" style="padding-top: 10px;">
    <table cellspacing="0" cellpadding="3">
      <thead>
        <th>Type</th>
        <th>Name / Host</th>
        <th>Value</th>
      </thead>
      <tbody>
        <tr>
          <td>TXT</td>
          <td>{$dkim['selector']}</td>
          <td>
            <textarea class="form-control" rows="12" disabled>v=DKIM1;k=rsa;h={$dkim['algo']};p={$dkim['key']}</textarea>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  {/if}
</div>
{/if}