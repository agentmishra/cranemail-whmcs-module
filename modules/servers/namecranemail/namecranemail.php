<?php

use WHMCS\Database\Capsule;
use GuzzleHttp\Client;

function namecranemail_MetaData() {

  return [
    'DisplayName'     => 'Namecrane Email',
    'APIVersion'      => '1.1',
    'RequiresServer'  => true
  ];

}

function namecranemail_ConfigOptions() {

	return [
		'Disk Space (GB)' => [ 
			'Type'          => 'text',
			'Size'          => '25',
      'Default'       => 1,
      'SimpleMode'    => true
    ],
		'Max Email Users'   => [ 
			'Type'        => 'text',
			'Size'        => '8',
      'Description' => '0 = Unlimited',
      'Default'     => 0,      
      'SimpleMode' => true
    ],
		'SpamExperts' => [ 
			'Type'    => 'dropdown',
      'Options' => [
        '0' => 'Disabled',
        '1' => 'Enabled'
      ],
			'SimpleMode' => true
    ],
		'Max User Aliases' => [ 
			'Type'        => 'text',
			'Size'        => '8',
      'Description' => '0 = Unlimited',
      'Default'     => 0,      
      'SimpleMode' => true
    ],
		'SpamExperts Access' => [ 
			'Type'    => 'dropdown',
      'Options' => [
        'primary' => 'Primary Administrator Only',
        'all' => 'All Domain Administrators'
      ],
			'SimpleMode' => true
    ],
		'Max Domain Aliases' => [ 
			'Type'        => 'text',
			'Size'        => '8',
      'Description' => '0 = Unlimited',
      'Default'     => 0,
      'SimpleMode'  => true,
  	],
    'Email Archiving (Years)' => [
			'Type'    => 'dropdown',
      'Options' => [
        '0' => 'Disabled',
        '1' => '1 Year',
        '2' => '2 Years',
        '3' => '3 Years',
        '4' => '4 Years',
        '5' => '5 Years',
        '6' => '6 Years',
        '7' => '7 Years',
        '8' => '8 Years',
        '9' => '9 Years',
        '10' => '10 Years',
        '15' => '15 Years',
        '20' => '20 Years'
      ],
      'SimpleMode' => true,
    ],    
    'Email Archiving Direction' => [
			'Type'    => 'dropdown',
      'Options' => [
        'in' => 'Incoming',
        'out' => 'Outgoing',
        'inout' => 'Both'
      ],
      'SimpleMode' => true,
    ]
  ];

}

function namecranemail_CreateAccount($vars) {

  $post = [
    'domain'                    => $vars['domain'],
    'disklimit'                 => $vars['configoption1'],
    'userlimit'                 => $vars['configoption2'],
    'useraliaslimit'            => $vars['configoption4'],
    'spamexperts'               => $vars['configoption3'],
    'spamexperts_adminaccess'   => $vars['configoption5'],
    'domainaliaslimit'          => $vars['configoption6'],
    'archive_years'             => $vars['configoption7'],
    'archive_direction'         => $vars['configoption8'],
  ];

  $return = namecranemail_execute('POST', 'domain/create', $vars, $post);
  
  if(!$return['status']) {
    return $return['message'];
  }
  
  localAPI('UpdateClientProduct', [
    'serviceid'         => $vars['serviceid'],
    'serviceusername'   => $return['data']['username'],
    'servicepassword'   => $return['data']['password'] 
  ]);

  return 'success';

}

function namecranemail_TerminateAccount($vars) {

  $post = [
    'domain'  => $vars['domain'],
  ];

  $return = namecranemail_execute('POST', 'domain/delete', $vars, $post);
  
  if(!$return['status']) {
    return $return['message'];
  }

  return 'success';
 
}

function namecranemail_SuspendAccount($vars) {

  $post = [
    'domain'  => $vars['domain'],
  ];

  $return = namecranemail_execute('POST', 'domain/suspend', $vars, $post);
  
  if(!$return['status']) {
    return $return['message'];
  }

  return 'success';
 
}

function namecranemail_UnsuspendAccount($vars) {

  $post = [
    'domain'  => $vars['domain'],
  ];

  $return = namecranemail_execute('POST', 'domain/unsuspend', $vars, $post);
  
  if(!$return['status']) {
    return $return['message'];
  }

  return 'success';
 
}

function namecranemail_ChangePackage($vars) {

  $post = [
    'domain'                    => $vars['domain'],
    'disklimit'                 => $vars['configoption1'],
    'userlimit'                 => $vars['configoption2'],
    'useraliaslimit'            => $vars['configoption4'],
    'spamexperts'               => $vars['configoption3'],
    'spamexperts_adminaccess'   => $vars['configoption5'],
    'domainaliaslimit'          => $vars['configoption6'],
    'archive_years'             => $vars['configoption7'],
    'archive_direction'         => $vars['configoption8'],
  ];

  $return = namecranemail_execute('POST', 'domain/modify', $vars, $post);
  
  if(!$return['status']) {
    return $return['message'];
  }
  
  return 'success';

}

function namecranemail_AdminServicesTabFields($vars) {

  $post = [
    'domain' => $vars['domain']
  ];

  $stats = namecranemail_execute('POST', 'domain/info', $vars, $post);

  if(!$stats['status']) {
    $html = 'Couldn\'t get domains statistics.';
  } else {

    $smarty = new Smarty();
    $smarty->assign('info', $stats['data']['data']);

    $html = $smarty->fetch(__DIR__ . '/templates/adminoutput.tpl');

  }

  return [
    'Statistics' => $html
  ];
  
}

function namecranemail_ClientArea($vars) {

  $post = [
    'domain' => $vars['domain']
  ];

  $stats = namecranemail_execute('POST', 'domain/info', $vars, $post);

  return [
    'templatefile' => 'templates/clientarea',
    'vars' => [
      'info' => $stats['data']['data']
    ]
  ];

}


function namecranemail_execute($method, $action, $vars, $post = []) {

  $guzzle = new Client();

  try {

    $return = $guzzle->request($method, 'https://namecrane.com/index.php?m=cranemail&action=api/' . $action, [
      'headers'     => [ 'X-API-KEY' => $vars['serveraccesshash'] ],
      'form_params' => ($method == 'POST' ? $post : [])
    ])->getBody();

    $return = json_decode($return, true);

    if(json_last_error() !== JSON_ERROR_NONE) {
      return ['status' => false, 'message' => 'Invalid JSON response from Namecrane. Ticket support (and blame Fran)' ];
    }

    return [ 'status' => $return['status'], 'message' => $return['message'], 'data' => $return ];

  } catch (\GuzzleHttp\Exception\RequestException $e) {    
    // TODO - add logModule calls here
    return [ 'status' => false, 'message' => $e->getMessage() ];
  } catch(\GuzzleHttp\Exception\GuzzleException $e) {
    // TODO - add logModule calls here
    return [ 'status' => false, 'message' => $e->getMessage() ];
  }

}

?>