<?php
if (isset($_GET['step']))
$step = $_GET['step'];
else
$step = 0;

error_reporting(E_ERROR | E_PARSE);

require_once('installer-config.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <title><?php echo $setting['name'] ?> Installation</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <link href="installer-styles.css" rel="stylesheet" type="text/css" />
 </head>
 <body>
  <div id="container">
  <div id="header">
   <a href="installer.php">
   <?php echo $setting['name'] ?> Installation</a>
   </div>
	<div id="main">
	<div class="pad25">
<?php

// Requirements check
if (!isset($_GET['step'])) {
	if (!is_writable($setting['config']['folder']))
		$msg .= '<p>WARNING! I can not write to the <code>'.$setting['config']['folder'].'</code> directory or does not exist. You will have to either change the permissions on your installation directory or create this folder manually.';
	if (phpversion() < $setting['requirements']['php'])
		$msg .= '<p>WARNING! The minimum PHP version is <code>'.$setting['requirements']['php'].'</code>, your version is <code>'.phpversion().'</code>. Please visit http://php.net for additional information on installing a more recent version.</p>';
	if (file_exists($setting['config']['folder'] . $setting['config']['file']))
		$msg .= '<p><strong>WARNING!</strong> The <code>'.$setting['config']['folder'] . $setting['config']['file'].'</code> file already exists. Running this installation process will overwrite your current settings.</p>';
	if($msg)
		echo '<div class="requirement error">'.$msg.'</div>';
}

switch($step) {
	case 0:

?>
	<h1>Pre-Installation Notes</h1><br />

<p>Welcome to the installation process for the <?php echo $setting['name'] ?> application. Before we begin please ensure that you have the below information:</p>
<ul style="list-style:disc;margin: 10px 40px;">
  <li>Database name</li>
  <li>Database username</li>
  <li>Database password</li>
  <li>Database host</li>
</ul>
<p>If you have all the information ready yourself, then you're ready to go. Hit the "Install <?php echo $setting['name'] ?>" link to the right to continue.</p>
<br />
<p><a href="?step=1" class="button" style="float:right"> <span>Install <?php echo $setting['name'] ?> &rsaquo;</span> </a></p>
<?php
	break;

	case 1:
	?>
	<h1>Step 1: Database Information</h1><br />
<form method="post" action="?step=2" name="form">
  <p>Enter your database connection settings. These settings will be inserted into <code><?php echo $setting['config']['folder'] . $setting['config']['file'] ?></code> and will be used by the application.</p>
  <table style="width: 100%;">
    <tr>
      <th class="col1">Database Name</th>
      <td class="col2"><input name="db_name" type="text" size="20" value="<?php echo '' ?>" /></td>
      <td class="col3">The name of the database to use.</td>
    </tr>
    <tr>
      <th class="col1">Username</th>
      <td class="col2"><input name="db_user" type="text" size="20" /></td>
      <td class="col3">Your MySQL username.</td>
    </tr>
    <tr>
      <th class="col1">Password</th>
      <td class="col2"><input name="db_pass" type="password" size="20" /></td>
      <td class="col3">Your MySQL password.</td>
    </tr>
    <tr>
      <th class="col1">Database Host</th>
      <td class="col2"><input name="db_host" type="text" size="20" value="localhost" /></td>
      <td class="col3">Most likely won't need to change this value.</td>
    </tr>
  </table><br />
  	<a href="#" onclick="document['form'].submit()" class="button" style="float:right;"> <span>Generate Configuration File &rsaquo;</span> </a> 
</form>
<?php
	break;	
	case 2:
	
	echo '<h1>Step 2: Generating Configuration File</h1><br />';
	$db_name = trim($_POST['db_name']);
    $db_user = trim($_POST['db_user']);
    $db_pass = trim($_POST['db_pass']);
    $db_host = trim($_POST['db_host']); 	
	$path = getcwd();
	$urlx = $_SERVER['HTTP_HOST'];
	$handle = fopen($setting['config']['folder'] . $setting['config']['file'], 'w');
	
$input = "<?php
ob_start();
session_start();

//set timezone
date_default_timezone_set('Europe/London');

// Database Details
define('".$setting['database']['name']."', '".$db_name."');
define('".$setting['database']['user']."', '".$db_user."');
define('".$setting['database']['pass']."', '".$db_pass."');
define('".$setting['database']['host']."', '".$db_host."');

define('DIR','http://$urlx/appyadmin/');
define('SITEEMAIL','noreply@appy-gen.com');


try {

	//create PDO connection 
	\$db = new PDO(\"mysql:host=\".DBHOST.\";port=8889;dbname=\".DBNAME, DBUSER, DBPASS);
	\$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException \$e) {
	//show error
    echo '<p class=\"bg-danger\">'.\$e->getMessage().'</p>';
    exit;
}

//include the user class, pass in the database connection
include('classes/user.php');
\$user = new User(\$db); 
?>
";

fwrite($handle, $input);
fclose($handle);
if (file_exists($setting['config']['folder'] . $setting['config']['file']))
	echo '<h3>Configuration file created!</h3><p>The file <code>'.$setting['config']['folder'] . $setting['config']['file'].'</code> has been created successfully. To continue the installation, please continue the installation. </p><a href="?step=3" class="button" style="float:right;"> <span>Generate Database Tables &rsaquo;</span> </a> ';
else
	echo '<h3>ERROR!</h3><p>Configuration file was not created. Please check the the folder <code>'.$setting['config']['folder'].'</code> is created and the permissions to the  folder are set to <code>777</code>. After checking, click the link button below to regenerate the configuration file again..</p> <a href="?step=1" class="button fail" style="float:left"> <span>&lsaquo; Regenerate Configuration</span> </a>';

	break;
	case 3:

if (file_exists($setting['config']['folder'] . $setting['config']['file'])) {

	echo '<h1>Step 3: Generating Database Tables</h1><br />';
	require $setting['config']['folder'] . $setting['config']['file'];

	connect();
	
	if (mysql_error() != null) {
		echo '<h3>ERROR!</h3>';
		echo '<p>This is probably due to incorrect database credentials. Please go back to the previous step and enter your database details.</p>';
		echo '<a href="?step=1" class="button fail" style="float:left"> <span>&lsaquo; Regenerate Configuration</span> </a>';
	} else {
	
	$file_content = file('installer-sql.sql');
    $query = "";
    foreach($file_content as $sql_line){
      if(trim($sql_line) != "" && strpos($sql_line, "--") === false){
        $query .= $sql_line;
        if(preg_match("/;[\040]*\$/", $sql_line)){
          $result = mysql_query($query) or die('<h3>ERROR!</h3><p>'.mysql_error().'. You may be trying to overwrite a database whose tables already exist. Please delete the tables in <code>'.DB_NAME.'</code>.</p><a href="?step=1" class="button fail" style="float:left"> <span>&lsaquo; Regenerate Configuration</span> </a>');
          $query = "";
        }
      }
    }
    echo '<h3>Congratulations! '.$setting['name'].' has been successfully Installed!</h3>';
    echo '<p>Please delete the following files:</p>';
    echo '<ul style="list-style:disc;margin: 10px 40px;">
  			<li>installer.php</li>
  			<li>installer-styles.css</li>
  			<li>installer-sql.sql</li>
  			<li>installer-config.php</li>
		  </ul>'; 
  	echo '<p><a href="'.$setting['after_install'].'" class="button" style="float:right"> <span>'.$setting['finished'].' &rsaquo;</span> </a></p>';
    }
  } else {
  	echo '<p>Configuration file not created. You may have to fill in the database information manually. To do this, simply open phpMyAdmin or another database manager and execute the MYSQL code located in <code>installer-sql.sql</code>.</p>';
  }

	break;
}

?>
	
	 </div>
	</div>
 <br class="clr" />
  </div>
 <br class="clr" />
   <div id="footer">
    <div class="footer_inner">
&copy; 2015 | Appy-gen.com
	</div>
   </div>

 </body>
</html>