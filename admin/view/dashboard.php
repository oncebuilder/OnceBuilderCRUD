<?php
/*
 * Version: 1.0, 31.05.2012
 * by Adam Wysocki, goldpaid777@gmail.com
 *
 * Copyright (c) 2012 Adam Wysocki
 *
 *	This is core connector class
 *
*/

# FIX XAMPP AND UNDEFINED -------------------
$_GET['t'] = isset($_GET['t']) ? $_GET['t'] : '';
$_POST['query'] = isset($_POST['query']) ? $_POST['query'] : '';

# SET DATA -------------------
$once->set_data(array(
	"t" => filter($_GET['t']),
	"query" => filter($_POST['query'])
));
//$dashboard=$once->get_dashboard();

$header='
<!-- Content Header (Page header) dashboard.class.php -->
<h1>Dashboard</h1>
<ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">dashboard</li>
</ol>
';

$obj['header']=$header;
		
$str='
<div class="row">
	<div class="col-md-12">
		<div class="box">
			<div id="content-body" class="box-body margin">
				<p>Thank you for downloading OnceBuilder CRUD</p>
				</br>
				<p>Well, I know guys that you would like to try a our CMS now... but everything has right time... and must follow each milestone!</p>
				<p>Right now, I just want to show you core of OnceBuilder CMS and how we going to edit data, yeah... most of mange data is based with dialog mode!</p>
				</br>
				<p>Anyway... you may use this CRUD for your project or cooperate with OnceBuilder and make your own modules and we will choose the most usefull ones.</p>
				</br>
				<p>Fell free to join our community, learn how you will be able to make any most of sites in less than one hour... <a target="_blank" href="http://facebook.com/oncebuilder">http://facebook.com/oncebuilder</a></p>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div><!-- /.col -->
</div><!-- /.row -->
<div id="dialog-add"></div>
<div id="dialog-edit"></div>
<script src="js/once.dashboard.js" type="text/javascript"></script>';
	
$obj['html']=$str;

if(true){
	$obj['status']='ok';
}else{
	$obj['error']='view not found';
}

echo json_encode($obj);
?>