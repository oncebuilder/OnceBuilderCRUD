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

# XAMPP fix without turning error info off -------------------
$_GET['x'] = isset($_GET['x']) ? $_GET['x'] : '';
$_GET['route'] = isset($_GET['route']) ? $_GET['route'] : '';

# SET DATA -------------------
$once->set_data(array(
	"x" => filter($_GET['x'])
));

# GET DATA -------------------
$types=$once->type_get('users');

# PREPARE HEADER TEMPLATE
$header='
<h1>Users
	<form class="btn-group form-inline margin">
		<div class="form-group">
			<button class="btn btn-default btn-sm item-new" type="button"><i class="fa fa-plus"></i>&nbsp; new</button>
		</div>
	</form>
</h1>
<ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-users"></i> Home</a></li>
	<li class="active">users</li>
</ol>';
$obj['header']=$header;

# PREPARE BODY TEMPLATE
$str='
<div class="row">
	<div id="types-data" class="col-md-3">
		<ul class="list-group nav nav-pills nav-stacked">
			<li class="header">Users types
				<div class="btn-group margin">
					<button id="type-new" class="btn btn-default btn-xs" type="button"><i class="fa fa-plus"></i>&nbsp; new</button>
				</div>
			</li>
				<li class="list-group-item current" data-id="0">
					<div class="list-group-header"><i class="fa fa-bars"></i><span>All users</span></div>
				</li>';
			if(isset($types['items'])){
				foreach($types['items'] as $key => $val){
					$str.='
					<li id="type_'.$types['items'][$key]['id'].'" class="list-group-item" data-id="'.$types['items'][$key]['id'].'">
						<div class="list-group-header"><i class="'.$types['items'][$key]['ico'].'"></i><span>'.$types['items'][$key]['name'].'</span></div>
						<div class="list-group-hover">
							<button class="btn btn-default btn-xs type-delete" type="button"><i class="fa fa-minus"></i></button>
							<button class="btn btn-default btn-xs type-edit" type="button"><i class="fa fa-cog"></i></button>
						</div>';
						$str.='
					</li>';
				}
			}
			$str.='
		</ul>
	</div>
	<div id="content-body" class="col-md-9">
		<script type="text/javascript">
			$(function() {
				$.get("view.php?c='.($_GET['route']==''?'users':$_GET['route']).'&o=list&type_id=0", function(data) {
					$("#content-body").html(data);
				})
				.error(function() { console.log("View Error: users"); });
			});
		</script>
	</div>
</div>
<script src="js/once.users.js" type="text/javascript"></script>';
$obj['html']=$str;

# RETURN HEADER/BODY TEMPLATE
echo json_encode($obj);
?>