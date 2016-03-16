<?php
ob_start("ob_gzhandler");

# SESSION -----------------
session_start();
$home=true;

# XAMPP FIXING -----------------
$_GET['route'] = isset($_GET['route']) ? $_GET['route'] : '';
$_GET['v'] = isset($_GET['v']) ? $_GET['v'] : '';

# LOGIN -----------------
if(!$_SESSION['user_logged'] || $_SESSION['user_type_id']!=1){
	session_unset();
	session_destroy();
	header("Location: login.php"); /* Redirect browser */
}

# LOGOUT ----------------
if($_GET['route']=='logout'){
	session_unset();
	session_destroy();
	header("Location: login.php"); /* Redirect browser */
}

# SECURE -----------------
if(!$home) exit;

# FUNC -----------------
require_once('func/once.php');

# CONFIG -----------------
require_once('config.php');

# CLASS -------------------
require_once('./class/core.class.php');
$core = new core($_CONFIG);

# PAGE START -------------------
?>
<!DOCTYPE html>
<html>
    <head>
		<!-- some meta tags / oncebuilder.com -->
		<title>Once CMS | Dashboard</title>
		 
		<meta charset="UTF-8">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<meta content="<?php echo $core->once_csrf_token();?>" name="csrf_token">

		<!-- Boostrap style -->
		<link href="libs/bootstrap-3.3.6/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        
		<!-- Font awesome -->
		<link href="libs/font-awesome-4.5.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

        <!-- Ionicons -->
        <link href="libs/ionicons-2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        
		<!-- Theme AdminLTE style -->
        <link href="libs/AdminLTE/AdminLTE.css" rel="stylesheet" type="text/css" />
		
		<!-- iCheck for checkboxes and radio inputs -->
        <link href="libs/icheck-1.0.2/skins/minimal/blue.css" rel="stylesheet" type="text/css" />

		<!-- Oncebudiler style -->
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		
		<!-- Running thanks to jQuery & Bootstrap -->
		<script src="js/jquery.min.js"></script>
		<script src="libs/bootstrap-3.3.6/js/bootstrap.min.js" type="text/javascript"></script>

		<!-- jQuery UI -->
        <script src="js/jquery-ui.min.js" type="text/javascript"></script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="index.php" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                OnceBuilder CRUD
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
						<!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo $core->get_data('user_username');?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="/uploads/<?php echo $core->get_data('user_id');?>/photo.png" onerror="this.src='img/photo.png'" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php echo $core->get_data('user_username');?> - Web Developer
                                        <small>Level - OnceBuilder Creator</small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-right">
                                        <a href="index.php?route=logout" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <?php
					echo '
					<ul class="sidebar-menu">
                        <li '.($_GET['route']==''?'class="active"':'').'>
                            <a href="index.php">
								<i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
						<li '.($_GET['route']=='users'?'class="active"':'').'>
                             <a href="index.php?route=users">
								<i class="fa fa-users"></i> <span>Users</span>
                            </a>
                        </li>
                    </ul>';
					?>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section id="header" class="content-header"> </section>
                <!-- Main content -->
                <section id="content" class="content">
					<script type="text/javascript">
						$(function() {
							$.getJSON("view.php?c=<?php echo ($_GET['route']==''?'dashboard':$_GET['route']);?>&v=<?php echo $_GET['v'];?>", function(data) {
								$('#header').html(data.header);
								$('#content').html(data.html);
							})
							.error(function() { alert("couldn't load: get_<?php echo $_GET['route'];?>"); });
						});
					</script>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

		<!-- iCheck -->
        <script src="libs/icheck-1.0.2/icheck.min.js" type="text/javascript"></script>

        <!-- AdminLTE App -->
        <script src="libs/AdminLTE/app.js" type="text/javascript"></script>

		<!-- Once App -->
        <script src="js/script.js" type="text/javascript"></script>
        <script src="js/once.js?<?php echo time();?>" type="text/javascript"></script>
    </body>
</html>
<?php
ob_end_flush(); 
?>