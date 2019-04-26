<?php

/*
 *	AppInstaller v 1.0
 *	Tommy Marshall
 *	tom@sirestudios.com
 *
 */

$setting = Array(	
	
	// Configuration settings to the folder you want the configuration file created
	// and the folder to within it should be created.
	'config'		=>	Array (
		'folder'	=>	'includes/',
		'file'		=>	'config.php'
		),

	// Change function connect() (Lines 40 and 41) databa constants to match values below.
	'database'		=>	Array (		
		'name'		=> 'DBNAME',
		'user'		=> 'DBUSER',
		'pass'		=> 'DBPASS',
		'host'		=> 'DBHOST'
		),

	// You can change these settings to mee what you need, then modify the requirements
	// on line 30.
	'requirements'	=>	Array (
		'php'		=>	'5.2'
		),

	// General application settings
	'name'			=>	'AppyGEN Admin',
	'finished'		=>	'Login Now',
	'after_install'	=>	'register.php'
	);

function connect() {
	$link = mysql_connect(DBHOST,DBUSER,DBPASS);
	mysql_select_db(DBNAME,$link);
}

?>