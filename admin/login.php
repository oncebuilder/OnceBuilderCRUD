<?php
ob_start("ob_gzhandler");

# SESSION -----------------
session_start();
$home=true;

# LOGIN -----------------
if(!empty($_SESSION['user_logged'])){
	header("Location: index.php"); /* Redirect browser */
}

# CREATE CONFIG FILE IF NOT EXIST -----------------
if(!file_exists("config.php")){
   $fp = fopen("config.php","w"); 
   fclose($fp);
}

# CONFIG -----------------
require_once('config.php');

# CHECK IF ONCE INSTALED -------------------
if(isset($_CONFIG['datahost']) && $_CONFIG['datahost']!=''){
	// valid hostname / ip address
	if (filter_var(gethostbyname($_CONFIG['datahost']), FILTER_VALIDATE_IP)) {
		if(isset($_CONFIG['datauser']) && $_CONFIG['datauser']!=''){
			if(isset($_CONFIG['database']) && $_CONFIG['database']!=''){
				try{
					$pdo = new PDO('mysql:host='.$_CONFIG['datahost'].';dbname='.$_CONFIG['database'].'', $_CONFIG['datauser'], $_CONFIG['datapass'], array(
						PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
					));
					//PDO::ATTR_PERSISTENT => true, 
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
					
					// Prepare statements to get selected data
					$stmt = $pdo->prepare("SELECT COUNT(id) AS ile FROM edit_users");
					$stmt->execute();
					
					// Get count of returned records
					$obj['count']=$stmt->rowCount();
					if($obj['count']){
						$obj['item']=$stmt->fetch(PDO::FETCH_ASSOC);
						// Get count of returned records
						if($obj['item']['ile']==0){
							echo 'NO USERS IN TABLE';
							echo '<p>simple reinstall by delete config <a href="doc/reinstall">read doc<a></p>';
							exit;
						}
					}
				}catch (Exception $e){
					if($e->getCode()==2002){
						echo 'NO RESPONSE FROM HOST';
						echo '<p>simple reinstall by delete config <a href="doc/reinstall">read doc<a></p>';
					}
					if($e->getCode()==1045){
						echo 'ACCESS DENIED FOR USER';
						echo '<p>simple reinstall by delete config <a href="doc/reinstall">read doc<a></p>';
					}
					if($e->getCode()==1049){
						echo 'DATABASE NOT EXISTS';
						echo '<p>simple reinstall by delete config <a href="doc/reinstall">read doc<a></p>';
					}
					exit;
				}
			}else{
				echo 'DB CANT BE EMPTY';
				echo '<p>simple reinstall by delete config <a href="doc/reinstall">read doc<a></p>';
				exit;
			}
		}else{
			echo 'USER CANT BE EMPTY';
			echo '<p>simple reinstall by delete config <a href="doc/reinstall">read doc<a></p>';
			exit;
		}
	}else{
		echo 'HOST IS NOT VALID';
		echo '<p>simple reinstall by delete config <a href="doc/reinstall">read doc<a></p>';
		exit;
	}
}else{
	require_once('./installer.php');
	exit;
}

# CLASS -------------------
//require_once('./class/core.class.php');
//$once=new core($_CONFIG);

# FUNCTION -------------------
if(!isset($_POST['install']) && isset($_POST['login']) && isset($_POST['password'])){
	$_POST['password_md5']=md5($_POST['password']);
	// Prepare statements to get selected data
	$stmt = $pdo->prepare("SELECT * FROM edit_users WHERE login=:login AND password=:password LIMIT 1");
	$stmt->bindParam(':login', $_POST['login'], PDO::PARAM_STR, 50);
	$stmt->bindParam(':password', $_POST['password_md5'], PDO::PARAM_STR, 50);
	$stmt->execute();
	
	// Get count of returned records
	$obj['count']=$stmt->rowCount();
	if($obj['count']){
		$obj['item']=$stmt->fetch(PDO::FETCH_ASSOC);
		
		ini_set("session.gc_maxlifetime","86400");
		
		// Set session
		$_SESSION['user_logged']=true;
					
		// user data
		$_SESSION['user_id']=$obj['item']['id'];
		$_SESSION['user_login']=$obj['item']['login'];
		$_SESSION['user_type_id']=$obj['item']['type_id'];
		$_SESSION['user_username']=$obj['item']['username'];
		$_SESSION['user_email']=$obj['item']['email'];
					
		// user browser
		$_SESSION['user_ip']=$_SERVER['REMOTE_ADDR'];
		$_SESSION['user_status']=$obj['item']['status'];
		
		header("Location: index.php"); /* Redirect browser */
	}
}

# PAGE START -------------------
?>
<!DOCTYPE html>
<html class="bg-blue">
    <head>
        <meta charset="UTF-8">
        <title>Once CMS | Log in</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="libs/AdminLTE/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-blue">

        <div class="form-box" id="login-box">
            <a href="login.php">
				<div class="header">Once CMS</div>
			</a>
            <form action="login.php" method="post">
                <div class="body bg-gray">
					<?php
						if(isset($_GET['installed'])){
							echo '<p class="text-center"><b>OnceBuilder has been installed.</b></br>Now you can login to your creator account.</p>';
						}
					?>
                    <div class="form-group">
                        <input type="text" name="login" class="form-control" placeholder="User ID"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password"/>
                    </div>
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn bg-olive btn-block">Zaloguj</button>
                </div>
            </form>
        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>

    </body>
</html>