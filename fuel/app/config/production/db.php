<?php
/**
 * The production database settings. These get merged with the global settings.
 */

return array(
	'default' => array(
		'connection'  => array(
			'dsn'        => 'mysql:host=localhost;dbname=isheeet_prod',
			'username'   => 'isheeet_prod',
			'password'   => 'isheeet_prod',
		),
	),
);
