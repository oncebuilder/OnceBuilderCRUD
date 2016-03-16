<?php

# SESSION -----------------
if(!$home)
exit;

# FUNCTION -------------------
if(isset($_POST['install'])){

	$obj['error']=0;
		
	if(isset($_POST['datahost']) && strlen($_POST['datahost'])<=0){
		$obj['errors'][0][]='DATAHOST CAN\'T BE EMPTY';
		$obj['error']++;
	}
	if(!filter_var(gethostbyname($_POST['datahost']), FILTER_VALIDATE_IP)) {
		$obj['errors'][0][]='DATAHOST is not valid';
		$obj['error']++;
	}
	if(isset($_POST['database']) && strlen($_POST['database'])<=0){
		$obj['errors'][1][]='DATABASE CAN\'T BE EMPTY';
		$obj['error']++;
	}
	if(isset($_POST['datauser']) && strlen($_POST['datauser'])<=0){
		$obj['errors'][2][]='DATAUSER CAN\'T BE EMPTY';
		$obj['error']++;
	}
	if(isset($_POST['login']) && strlen($_POST['login'])<=0){
		$obj['errors'][3][]='LOGIN CAN\'T BE EMPTY';
		$obj['error']++;
	}
	if(isset($_POST['password']) && strlen($_POST['password'])<=0){
		$obj['errors'][4][]='PASSWORD CAN\'T BE EMPTY';
		$obj['error']++;
	}

	if($obj['error']==0){
		try{
			$pdo = new PDO('mysql:host='.$_POST['datahost'].'', $_POST['datauser'], $_POST['datapass'], array(
				PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
			));
			//PDO::ATTR_PERSISTENT => true, 
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
				
			$pdo->query("CREATE DATABASE IF NOT EXISTS ".$_POST['database']."");
			$pdo->query("use ".$_POST['database']."");
	
			// install db from file
			$database = file_get_contents('database.sql');

			// execute sql
			$qr = $pdo->exec($database);
	
			// Create creator account
			$pdo->query("INSERT INTO `edit_users` (`id`, `login`, `password`, `type_id`) VALUES (NULL, '".$_POST['login']."', '".md5($_POST['password'])."', '1');");

			// Create project
			$pdo->query("INSERT INTO `edit_projects` (`id`, `user_id`, `name`, `default`) VALUES (NULL, '".$pdo->lastInsertId()."', 'This in only OnceBuilder CRUD', '1');");

			// Building simple config file with mysql connection for Once Builder
			$config="";
			$config.="<?php\n";
			$config.="# SECURE -----------------\n";
			$config.="if(!\$home) exit;\n";
			$config.="\n";
			$config.="# CONFIG MYSQL -------------------\n";
			$config.="\$_CONFIG['datahost']='".$_POST['datahost']."';\n";
			$config.="\$_CONFIG['database']='".$_POST['database']."';\n";
			$config.="\$_CONFIG['datauser']='".$_POST['datauser']."';\n";
			$config.="\$_CONFIG['datapass']='".$_POST['datapass']."';\n";
			$config.="\n";
			$config.="\$_SESSION['user_lang'] = isset(\$_SESSION['user_lang']) ? \$_SESSION['user_lang'] : '';\n";
			$config.="?>\n";
			file_put_contents('./config.php',$config);
			
			header("Location: login.php?installed"); /* Redirect browser */
		}catch (Exception $e){
			if($e->getCode()==2002){
				$obj['errors'][0][]='NO RESPONSE FROM HOST';
				$obj['error']++;
			}
			if($e->getCode()==1045){
				$obj['errors'][2][]='ACCESS DENIED FOR USER';
				$obj['error']++;
			}
			if($e->getCode()!=2002 && $e->getCode()!=1045){
				die('Error: '.$e->getMessage().' Code: '.$e->getCode());
			}
		}
	}
}

# PAGE START -------------------
?>
<!DOCTYPE html>
<html class="bg-blue">
    <head>
        <meta charset="UTF-8">
        <title>Once CMS | Installer</title>
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
        <div class="form-box install-form" id="install-box">
            <a href="login.php">
				<div class="header">OnceBuilder Installer</div>
			</a>
            <form action="login.php" method="post">
                <div class="body bg-gray">
					Database Settings
					<div class="form-group">
						<?php
						if(isset($obj['errors'][0]) && count($obj['errors'][0])>0){
							echo '<label for="datahost">'.$obj['errors'][0][0].'</label>';
						}
						?>
                        <input type="text" name="datahost" value="<?php if(isset($_POST['datahost'])){echo $_POST['datahost'];}?>" class="form-control" placeholder="Database host"/>
                    </div>
                    <div class="form-group">
						<?php
						if(isset($obj['errors'][1]) && count($obj['errors'][1])>0){
							echo '<label for="database">'.$obj['errors'][1][0].'</label>';
						}
						?>
                       <input type="text" name="database" value="<?php if(isset($_POST['database'])){echo $_POST['database'];}?>" class="form-control" placeholder="Database name"/>
                    </div>
					<div class="form-group">
						<?php
						if(isset($obj['errors'][2]) && count($obj['errors'][2])>0){
							echo '<label for="datauser">'.$obj['errors'][2][0].'</label>';
						}
						?>
                       <input type="text" name="datauser" value="<?php if(isset($_POST['datauser'])){echo $_POST['datauser'];}?>" class="form-control" placeholder="Database username"/>
                    </div>
					<div class="form-group">
                       <input type="password" name="datapass" value="<?php if(isset($_POST['datapass'])){echo $_POST['datapass'];}?>" class="form-control" placeholder="Database password"/>
                    </div>
					<hr>
					Creator's Account
					<div class="form-group">
						<?php
						if(isset($obj['errors'][3]) && count($obj['errors'][3])>0){
							echo '<label for="login">'.$obj['errors'][3][0].'</label>';
						}
						?>
						</label>
                        <input type="text" name="login" value="<?php if(isset($_POST['login'])){echo $_POST['login'];}?>" class="form-control" placeholder="Creator login"/>
                    </div>
					<div class="form-group">
						<?php
						if(isset($obj['errors'][4]) && count($obj['errors'][4])>0){
							echo '<label for="password">'.$obj['errors'][4][0].'</label>';
						}
						?>
						</label>
                       <input type="password" name="password" value="<?php if(isset($_POST['password'])){echo $_POST['password'];}?>" class="form-control" placeholder="Creator password"/>
                    </div>
                </div>
                <div class="footer">                                                               
                    <button type="submit" name="install" class="btn bg-olive btn-block">Install OnceBuidler</button>
                </div>
            </form>
        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>

    </body>
</html>