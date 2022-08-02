<?php

return array(

	'driver' => 'smtp',
	'host' => 'mail.agentsafewalk.com',
	'port' => 587,
	'from' => array(
		'address' => 'alert@agentsafewalk.com',
		'name' => 'AgentSafeWalk-Contact Center',
	),
	'encryption' => 'tls',
	'username' => 'alert@agentsafewalk.com',
	'password' => 'S61ample',
	'sendmail' => '/usr/sbin/sendmail -bs',
	'pretend' => false,

);
