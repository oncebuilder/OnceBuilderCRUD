<?php
/*
 * Version: 1.0, 31.05.2012
 * by Adam Wysocki, goldpaid777@gmail.com
 *
 * Copyright (c) 2012 Adam Wysocki
 *
 *	This is simply JS -> PHP connector command switch
 *
*/

// Initialize connector class
$once = new once($_CONFIG);
$once->set_data(array("ajax" => true, "csrf_token" => $_GET['csrf_token']));

switch($_GET['o']){
	case 'bulk_action':{
		$once->set_data(array(
			"action" => filter($_POST['action']),
			"ids" => $_POST['ids']
		));
		$once->bulk_action();
	}break;
	case 'set_limit':{
		$once->set_data(array(
			"limit" => intval($_GET['limit'])
		));
		$once->set_limit();
	}break;
	
	case 'item_activiation':{
		$once->set_data(array(
			"id" => intval($_GET['id'])
		));
		$once->item_activiation();
	}break;
	case 'item_delete':{
		$once->set_data(array(
			"id" => intval($_GET['id'])
		));
		$once->item_delete();
	}break;
	case 'item_edit':{
		$once->set_data(array(
			"id" => intval($_GET['id']),
			"login" => filter($_POST['login']),
			"password" => filter($_POST['password']),
			"username" => filter($_POST['username']),
			"type_id" => filter($_POST['type_id']),
			"email" => filter($_POST['email']),
			"referer_id" => filter($_POST['referer_id'])
		));
		$once->item_edit();
	}break;
	case 'item_edit_contact':{
		$once->set_data(array(
			"id" => intval($_GET['id']),
			"firstname" => filter($_POST['firstname']),
			"lastname" => filter($_POST['lastname']),
			"email" => filter($_POST['email']),
			"website" => filter($_POST['website']),
			"company" => filter($_POST['company']),
			"address" => filter($_POST['address']),
			"address2" => filter($_POST['address2']),
			"city" => filter($_POST['city']),
			"phone" => filter($_POST['phone']),
			"zip" => filter($_POST['zip']),
			"province" => filter($_POST['province']),
			"country" => filter($_POST['country'])
		));
		$once->item_edit_contact();
	}break;
	case 'item_edit_social':{
		$once->set_data(array(
			"id" => intval($_GET['id']),
			"facebook" => filter($_POST['facebook']),
			"twitter" => filter($_POST['twitter']),
			"youtube" => filter($_POST['youtube']),
			"linkedin" => filter($_POST['linkedin']),
			"dribbble" => filter($_POST['dribbble']),
			"github" => filter($_POST['github']),
			"google" => filter($_POST['google']),
			"behance" => filter($_POST['behance']),
			"codepen" => filter($_POST['codepen'])
		));
		$once->item_edit_social();
	}break;
	case 'item_new':{
		$once->set_data(array(
			"type_id" => intval($_GET['type_id'])
		));
		$once->item_new();
	}break;
	case 'item_star':{
		$once->set_data(array(
			"id" => intval($_GET['id'])
		));
		$once->item_star();
	}break;
	
	case 'upload_image':{
		$once->set_data(array(
			"id" => intval($_GET['id']),
			"image" => $_FILES['myImage']
		));
		$once->upload_image();
	}break;
	//############################ OTHER ##################################################
	default:
	break;
}
?>