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

# SET DATA -------------------
$once->set_data(array(
	"id" => intval($_GET['id'])
));

# GET DATA -------------------
$types=$once->type_get('users');

?>
<ul class="list-group nav nav-pills nav-stacked">
<li class="header"><?php echo ucfirst($_GET['module']);?> types
	<div class="btn-group margin">
		<button id="type-new" class="btn btn-default btn-xs" type="button"><i class="fa fa-plus"></i>&nbsp; new</button>
	</div>
</li>
	<li class="list-group-item <?php echo ($_GET['id']>0?'':'current');?>" data-id="0">
		<div class="list-group-header"><i class="fa fa-bars"></i><span>All <?php echo strtolower($_GET['module']);?></span></div>
	</li>
	<?php
	if($types['items']){
		$str='';
		foreach($types['items'] as $key => $val){
			$str.='
			<li id="type_'.$types['items'][$key]['id'].'" class="list-group-item '.($types['items'][$key]['id']==$_GET['id']?'current':'').'" data-id="'.$types['items'][$key]['id'].'">
				<div class="list-group-header"><i class="'.$types['items'][$key]['ico'].'"></i><span>'.$types['items'][$key]['name'].'</span></div>
				<div class="list-group-hover">
					<button class="btn btn-default btn-xs type-delete" type="button"><i class="fa fa-minus"></i></button>
					<button class="btn btn-default btn-xs type-edit" type="button"><i class="fa fa-cog"></i></button>
				</div>';
				$str.='
			</li>';
		}
		echo  $str;
	}
?>
</ul>
<script type="text/javascript">
	$(document).ready(function () {
		once.types.actions.typeInit();
	});
</script>