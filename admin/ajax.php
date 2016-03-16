<?php
/*
 * Version: 1.0, 31.05.2012
 * by Adam Wysocki, goldpaid777@gmail.com
 *
 * Copyright (c) 2012 Adam Wysocki
 *
 *	This is simply JS -> PHP connector
 *
*/

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
//header('Access-Control-Max-Age: 604800');
//if you need special headers
header('Access-Control-Allow-Headers: x-requested-with');

if($_GET['o']!='exec_AJAX')
ob_start("ob_gzhandler");
$home=true;
//session_unset();session_destroy();
// print_r($_SESSION);
session_start();

// Require some usefull functions
require_once('func/once.php');

// Config need to be inclued with $_SESSION['project_id'] inside and name to identify project
require_once('config.php');

// Required classes
require_once('class/core.class.php');

if($_GET['c']!='core'){
	// Require connector class on type if not core
	require_once('class/'.$_GET['c'].'.class.php');
}

// Require connector depends on type and let it do work
require_once('ajax/'.$_GET['c'].'.php');

/*
	1. Switcher which define incall function by parametr o
	Example:
		once.php?c=once.edplorer&o=get_project&id=1
		
	once.php?
		c => connector file with prefix "once."
		o => connector command
		id => other parms can be send same way $_GET or $_POST

	2. Setting data is defined in once.core.class
	Example:
		$once->set_data(array(
			"project_name" => filter($_GET['name'])
		));

	3. After initializing, we can call function
		$once->new_project();
	
	Varibles: data['project_id'], data['project_name'] data['project_path'] are defined in constructor
*/
?>