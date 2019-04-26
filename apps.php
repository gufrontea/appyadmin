<?php require('includes/config.php');

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1); 

if(!$user->is_logged_in()){ header('Location: index.php'); } 

$title = 'Members Page';

$userNAME =$_SESSION['USERNAME']; 
$userID=$_SESSION['ID'];

//include header template

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
					                        <div class="alert alert-info">
					                        <i class="fa fa-info-circle"></i> <strong><?php echo 'Your AppHost URL is : '.DIR ?></strong>
					                       </div>
					                </div>
            <div class="row">
                <div class="col-lg-12">
           
                    <h1 >My Apps</h1>
                    
                  <!-- /  <a href="create_app.php" class="btn-block btn-success btn-sm active" role="button"><strong>Create New App</strong></a>-->
                </div>
                <!-- /.col-lg-12 -->
            </div>

	<?php
				if(isset($_GET['editbackerror'])){
				echo '<div class="row">
                    <div class="col-lg-12">';
					if ($_GET['editbackerror'] == 'false') {
					echo  '<div class="alert alert-success alert-dismissable"> <i class="fa fa-info-circle"></i> <strong>Operation Successful. </strong>';
					
					}else {
				
					echo  '<div class="alert alert-danger alert-dismissable"> <i class="fa fa-info-circle"></i> <strong>An Error Occured. </strong>';
					
					}
					echo '</div>
                    </div>
                </div>';
					}
					
		$stmt = $db->prepare('SELECT * FROM apps WHERE memberID = :userID');
		$stmt->bindParam(':userID', $userID, PDO::PARAM_STR, 12);
		$stmt->execute();	
		
		if($stmt->rowCount()=== 0)
							{
							
						   echo '<div class="row">
				                    <div class="col-lg-12">
				                    <div class="alert alert-warning"> <i class="fa fa-info-circle"></i> <strong>You haven\'t created any apps yet ! </strong><div class="text-right"><a href="create_app.php" class="btn-primary btn-sm active"><strong>Create New App</strong></a></div>
				                    </div>
				                    </div>
				               	    </div>';
							}
							else {
						   echo '<div class="row">
				                    <div class="col-lg-12">
				                    <div class="alert alert-primary"><div class="text-right"><a href="create_app.php" class="btn-primary btn-sm active"><strong>Create New App</strong></a></div>
				                    </div>
				                    </div>
				               	    </div>';
							}
							
							?>
                 
<table class="table table-striped table-bordered table-hover">
		 <thead>	<tr >
			<th>App ID</th>
			<th>App Name</th>
			<th>App Settings</th>
			<th>Actions</th>
			</tr></thead>
		<?php
		$stmt = $db->prepare('SELECT * FROM apps WHERE memberID = :userID');
		$stmt->bindParam(':userID', $userID, PDO::PARAM_STR, 12);
		$stmt->execute();		
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
		$link_content=DIR.'edit_content.php?id='.$row['appID'];
		$link_push=DIR.'push.php?id='.$row['appID'];
		$link_delete=DIR.'deleteapp.php?userid='.$userID.'&appid='.$row['appID'].'&temp='.$row['Template'];
 		
 		 //  print $row['a'].'<br>'; 
   		?>

  <tbody>
    			<tr>
    			<td bgcolor="#f8f5a8"><b><?php echo $row['appID'] ?></b></td>
    			<td><?php echo $row['appname'] ?></td>
    			<td><a href=<?php echo $link_content;?> class="btn-block btn-success btn-sm active" role="button"><center><b>Edit</b></center></a></td>
			
			<td><a href=<?php echo $link_delete;?> class="btn-block btn-danger btn-sm active" role="button"><center><b>Delete App</b></center></a></td>
			</tr>
  		<?php
     		} 
    		?>
	
                       </tbody>
    			</table>
        <!-- /#page-wrapper -->

   </div>
    <!-- /#wrapper -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="bower_components/raphael/raphael-min.js"></script>
    <script src="bower_components/morrisjs/morris.min.js"></script>
    <script src="js/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>
<?php

require('layout/footer.php'); 
   
//include header template
?>