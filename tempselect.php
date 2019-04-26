<?php require('includes/config.php');

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1); 

if(!$user->is_logged_in()){ header('Location: index.php'); } 

$title = 'Select a Template';
$userNAME =$_SESSION['USERNAME']; 
$userID=$_SESSION['ID'];

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>AppyGEN Admin</title>

    <!-- Bootstrap Core CSS -->
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

  

</head>

<body>


<div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="memberpage.php">AppyGEN Admin v1.0</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        
                        <li>
                            <a href="memberpage.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                       
                        <li>
                            <a href="apps.php"><i class="fa fa-android fa-fw"></i>My Apps<span class="fa arrow"></span></a>
                        </li>
                        <li>
                            <a href="analytics.php"><i class="fa fa-tasks fa-fw"></i>Analytics</a>
                        </li>
                       <li>
                            <a href="forum.php"><i class="fa fa-comment fa-fw"></i>Forum</a>
                        </li>
                        
                       <li>
                            <a href="suport.php"><i class="fa fa-support fa-fw"></i>Support</a>
                        </li>
                       
                     
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
        
        
   <div id="page-wrapper">
   
            <div class="row">
                <div class="col-lg-12">
                    <h1 >Choose your Template</h1>
                    
                </div>
            </div>

	<?php
	
				if(isset($error)){
						foreach($error as $error){
						echo '
						<div class="row">
                    <div class="col-lg-12">
					 <div class="alert alert-danger alert-dismissable"> <i class="fa fa-info-circle"></i> <strong>'.$error.' </strong>
					 </div>
                    </div>
                </div>';
									}
							} 
	?>
	
	
					              
	<div class="row">
  		<div class="col-md-4">
  		<img border="0" alt="" class="hover-img" width="157" src="http://seattleclouds.com/images/preview-splash.jpg">
  		</div>
  		<div class="col-md-8">	
  		<h2>Gallery App Template</h2>
  		Template Description
  		<?php
		$link_content=DIR.'create_app.php?temp=1';
  		?>
  		<a href=<?php echo $link_content;?> class="btn-block btn-success btn-sm active" role="button"><center><b>Choose</b></center></a>
  		</div>
  	</div>		              						