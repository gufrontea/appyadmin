<?php require('includes/config.php');

//ini_set('display_errors',1);
//ini_set('display_startup_errors',1);
//error_reporting(-1); 

if(!$user->is_logged_in()){ header('Location: index.php'); } 


$title = 'Edit App Page';

$userNAME =$_SESSION['USERNAME']; 
$userID=$_SESSION['ID'];
$paid=$_SESSION['PAID'];
$membership=$_SESSION['MEMBERSHIP'];


$AppID = htmlspecialchars($_GET["id"]);
$stmt = $db->prepare('SELECT * FROM apps WHERE memberID = :userID AND appID = :AppID');
		$stmt->bindParam(':userID', $userID, PDO::PARAM_STR, 12);
		$stmt->bindParam(':AppID', $AppID , PDO::PARAM_STR, 12);
		$stmt->execute();		
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

if(empty($row['appID'])){
header('Location: apps.php');
} 

$Template = $row['Template'];
$monetization = $row['monetization'];
$finalmoney = explode(';',$monetization);
$network=$finalmoney[0];
$banner=$finalmoney[1];
$interstitial=$finalmoney[2];


if(isset($_POST['submit'])){
			$content= $_POST['imgurl'];
			$imgExts = array("bmp", "jpg", "jpeg", "png");
			$urlExt = pathinfo($content, PATHINFO_EXTENSION);
			
							 if ((in_array($urlExt, $imgExts)) && (filter_var($content, FILTER_VALIDATE_URL))) {
							 $finaluri =$content;
								$stmt = $db->prepare('INSERT INTO gallery (img, appID) VALUES (:contentx ,  :appIDX)');
								$stmt->bindParam(':contentx', $finaluri, PDO::PARAM_STR);
								$stmt->bindParam(':appIDX', $AppID, PDO::PARAM_INT);
								$stmt->execute();
									if($stmt) // will return true if succefull else it will return false
									{	
									
									header('Location: edit_content.php?editbackerror=false&id='.$AppID);
									}
									else {
									header('Location: edit_content.php?editbackerror=true&id='.$AppID);	
									     }
							 }
							 else {
								$error[] = 'Image URL is Invalid.';
							 } 
			   }
else if(isset($_POST['submitjoke'])){
			$content= $_POST['joketext'];
			
							 if (isset($content)) {
								$stmt = $db->prepare('INSERT INTO jokes (AppID,joke) VALUES (:appIDX,:joke)');
								$stmt->bindParam(':appIDX', $AppID, PDO::PARAM_INT);
								$stmt->bindParam(':joke', $content, PDO::PARAM_STR);
								$stmt->execute();
									if($stmt) // will return true if succefull else it will return false
									{	
									
									header('Location: edit_content.php?editbackerror=false&id='.$AppID);
									}
									else {
									header('Location: edit_content.php?editbackerror=true&id='.$AppID);	
									     }
							 }
							 else {
								$error[] = 'Joke text is empty.';
							 } 
			   }
else if(isset($_POST['dealedit'])){
			$title= $_POST['dealtitlex'];
			$price= $_POST['dealpricex'];
			$newprice= $_POST['dealnewpricex'];
			$dealid= $_POST['dealid'];
				if ( (!empty($_POST['dealtitlex'])) && (!empty($_POST['dealpricex']))  && (!empty($_POST['dealnewpricex']))   ) {
				$stmt = $db->prepare('UPDATE deals SET title=:titlex,price=:pricex,newprice=:newpricex WHERE id = :idx AND AppID=:AppID');
				
								$stmt->bindParam(':titlex', $title, PDO::PARAM_STR);
								$stmt->bindParam(':pricex', $price, PDO::PARAM_STR);
								$stmt->bindParam(':newpricex', $newprice, PDO::PARAM_STR);
								$stmt->bindParam(':idx', $dealid, PDO::PARAM_INT);
								$stmt->bindParam(':AppID', $AppID, PDO::PARAM_INT);
								$stmt->execute();
									if($stmt) // will return true if succefull else it will return false
									{
									
									   header('Location: edit_content.php?editbackerror=false&id='.$AppID);
									}
									else {
									      
									header('Location: edit_content.php?editbackerror=true&id='.$AppID);	
									     }
							
							
			   } else {
								$error[] = 'Please Fill all the Fields.';
							 } 
							 }

else if(isset($_POST['quizedit'])){
			$secret= $_POST['secret'];
			$clue1= $_POST['clue1'];
			$clue2= $_POST['clue2'];
			$clue3= $_POST['clue3'];
			$clue4= $_POST['clue4'];
			$quizID= $_POST['quizid'];
			if ( (!empty($_POST['secret'])) && (!empty($_POST['clue1']))  && (!empty($_POST['clue2']))  && (!empty($_POST['clue3']))  && (!empty($_POST['clue4'])) ) {
				$stmt = $db->prepare('UPDATE quiz SET secret=:secret,clue1=:clue1,clue2=:clue2 ,clue3=:clue3 ,clue4=:clue4 WHERE id= :quizid AND appID=:AppID');
				
								$stmt->bindParam(':secret', $secret, PDO::PARAM_STR);
								$stmt->bindParam(':clue1', $clue1, PDO::PARAM_STR);
								$stmt->bindParam(':clue2', $clue2, PDO::PARAM_STR);
								$stmt->bindParam(':clue3', $clue3, PDO::PARAM_STR);
								$stmt->bindParam(':clue4', $clue4, PDO::PARAM_STR);
								$stmt->bindParam(':quizid', $quizID, PDO::PARAM_INT);
								$stmt->bindParam(':AppID', $AppID, PDO::PARAM_INT);
								$stmt->execute();
									if($stmt) // will return true if succefull else it will return false
									{	
									header('Location: edit_content.php?editbackerror=false&id='.$AppID);
									}
									else {
									      
									header('Location: edit_content.php?editbackerror=true&id='.$AppID);	
									     }
							}
							 else {
								$error[] = 'Please Fill All the Fields.';
							 } 
							
			   }
else if(isset($_POST['submitdeal'])){
			$dealtitle= $_POST['dealtitle'];
			$dealimg= $_POST['dealimg'];
			$dealcurrency= $_POST['dealcurrency'];
			$dealprice= $_POST['dealprice'];
			$dealnewprice= $_POST['dealnewprice'];
			$dealpercent= $_POST['dealpercent'];
			$deallink= $_POST['deallink'];
			$imgExts = array("bmp", "jpg", "jpeg", "png");
			$urlExt = pathinfo($dealimg, PATHINFO_EXTENSION);
			
							 if ((in_array($urlExt, $imgExts)) && (filter_var($dealimg, FILTER_VALIDATE_URL)) && (filter_var($deallink, FILTER_VALIDATE_URL)) && (is_numeric($dealpercent))) {
							 $finaluri =$content;
								$stmt = $db->prepare('INSERT INTO deals (AppID, title,img,price,newprice,currency,percent,link) VALUES 		 (:appIDX,  :title,:img,:price,:newprice,:currency,:percent,:link)');
								$stmt->bindParam(':appIDX', $AppID, PDO::PARAM_INT);
								$stmt->bindParam(':title', $dealtitle, PDO::PARAM_STR);
								$stmt->bindParam(':img', $dealimg, PDO::PARAM_STR);
								$stmt->bindParam(':price', $dealprice, PDO::PARAM_STR);
								$stmt->bindParam(':newprice', $dealnewprice, PDO::PARAM_STR);
								$stmt->bindParam(':currency', $dealcurrency, PDO::PARAM_STR);
								$stmt->bindParam(':percent', $dealpercent, PDO::PARAM_STR);
								$stmt->bindParam(':link', $deallink, PDO::PARAM_STR);
								$stmt->execute();
									if($stmt) // will return true if succefull else it will return false
									{	
									
									header('Location: edit_content.php?editbackerror=true&id='.$AppID);
									}
									else {
									      
									header('Location: edit_content.php?editbackerror=true&id='.$AppID);	
									     }
							 }
							 else {
								$error[] = 'Image URL is Invalid.';
							 } 
			   }
else if(isset($_POST['submitoff'])){
			$offtitle= $_POST['offtitle'];
			$offimg= $_POST['offimg'];
			$offdesc= $_POST['offdesc'];
			$imgExts = array("bmp", "jpg", "jpeg", "png");
			$urlExt = pathinfo($offimg, PATHINFO_EXTENSION);
			
							 if ((in_array($urlExt, $imgExts)) ) {
								$stmt = $db->prepare('INSERT INTO offline (AppID, title,descs,img) VALUES (:appIDX,:title,:desc,:img)');
								$stmt->bindParam(':appIDX', $AppID, PDO::PARAM_INT);
								$stmt->bindParam(':title', $offtitle, PDO::PARAM_STR);
								$stmt->bindParam(':desc', $offdesc, PDO::PARAM_STR);
								$stmt->bindParam(':img', $offimg, PDO::PARAM_STR);
								$stmt->execute();
									if($stmt) // will return true if succefull else it will return false
									{	
									
									header('Location: edit_content.php?editbackerror=false&id='.$AppID);
									}
									else {
									header('Location: edit_content.php?editbackerror=true&id='.$AppID);	
									     }
							 }
							 else {
								$error[] = 'Image URL is Invalid.';
							 } 
			   }
else if(isset($_POST['submitquiz'])){
			$secret= $_POST['secret'];
			$clue1= $_POST['clue1'];
			$clue2= $_POST['clue2'];
			$clue3= $_POST['clue3'];
			$clue4= $_POST['clue4'];
			
							if ( (!empty($_POST['secret'])) && (!empty($_POST['clue1']))  && (!empty($_POST['clue2']))  && (!empty($_POST['clue3']))  && (!empty($_POST['clue4'])) ) {
								$stmt = $db->prepare('INSERT INTO quiz (AppID, secret,clue1,clue2,clue3,clue4) VALUES 		 (:appIDX,  :secret,:clue1,:clue2,:clue3,:clue4)');
								$stmt->bindParam(':appIDX', $AppID, PDO::PARAM_INT);
								$stmt->bindParam(':secret', $secret, PDO::PARAM_STR);
								$stmt->bindParam(':clue1', $clue1, PDO::PARAM_STR);
								$stmt->bindParam(':clue2', $clue2, PDO::PARAM_STR);
								$stmt->bindParam(':clue3', $clue3, PDO::PARAM_STR);
								$stmt->bindParam(':clue4', $clue4, PDO::PARAM_STR);
								$stmt->execute();
									if($stmt) // will return true if succefull else it will return false
									{	
									
									header('Location: edit_content.php?editbackerror=true&id='.$AppID);
									}
									else {
									      
									header('Location: edit_content.php?editbackerror=true&id='.$AppID);	
									     }
							} else {
								$error[] = 'Please fill all the Fields.';
							 } 
			   }

?>

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
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
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
                <div class="col-lg-12">
					 
							<?php if(isset($error)){
						foreach($error as $error){
						echo '<br>
							<div class="row">
					                        <div class="alert alert-danger alert-dismissable">
					                        <i class="fa fa-info-circle"></i> <strong>'.$error.'</strong>
					                       </div>
					                </div>
						';
									}
							}
				
						?>
							
							
							<?php		
							
					 if($Template==1) {
							
							echo '<form role="form" method="post" action="" autocomplete="off"><div class="form-group">
							<h2>Add Image:</h2>
							<div class="form-group">
							<input type="text" name="imgurl" id="imgurl" class="form-control input-lg" placeholder="http://url.com/image.png" 	  			      		tabindex="1"><br>
							<input type="submit" name="submit" value="Add Image to Gallery" class="btn btn-primary" tabindex="5">
							
							</div>
							<h2>Gallery Content :</h2>
							<table class="table table-striped table-bordered table-hover">
							<tr>
							<th>Image</th>
							<th>URL</th>
							</tr>';
							$stmt = $db->prepare('SELECT * FROM gallery WHERE appID= :AppID');
							$stmt->bindParam(':AppID', $AppID, PDO::PARAM_INT);
							$stmt->execute();		
				
							while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
							$rowid=DIR.'delete.php?id='.$row['id'].'&pkg='.$AppID.'&temp='.$Template;
 		
   							echo '<tr>
    							<td align="center" width="20%"><img src="' .$row['img']. '" height="80" width="80"/></td>
    							<td align="center"><input type="text" class="form-control input-lg" value="'.$row['img'].'" 	      
					              	tabindex="3"><br><a href=' .$rowid. ' class="btn-block btn-danger btn-sm active" role="button">Delete</a></td>
							</tr>';
  							} 
    		
				 			echo '</table></div></form>';
				 		}	
				
			   if($Template==2) {		
			   
			   				echo'<h2>App Deals :</h2>
							<table class="table table-striped table-bordered table-hover">
							<tr>
							<th>Deal Title</th>
							<th>Regular Price</th>
							<th>Deal Price</th>
							<th>Actions</th>
							</tr>';
							$stmt = $db->prepare('SELECT * FROM deals WHERE AppID= :AppID');
							$stmt->bindParam(':AppID', $AppID, PDO::PARAM_INT);
							$stmt->execute();		
				
							while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
							$rowdelete=DIR.'delete.php?id='.$row['id'].'&pkg='.$AppID.'&temp='.$Template;
 							$rowedit=DIR.'editdeal.php?id='.$row['id'].'&pkg='.$AppID;
   							echo '<tr><form role="form" method="post" action="" autocomplete="off">
    							<td style="vertical-align:middle" width="40%"><input type="text" name="dealtitlex" id="dealtitlex" class="form-control input-lg" value="'.$row['title'].'" 	      
					              	tabindex="3"></td>
    							<td style="vertical-align:middle" width="20%"><input type="text" name="dealpricex" id="dealpricex" class="form-control input-lg" value="'.$row['price'].'" 	      
					              	tabindex="3"></td>
					              	<td style="vertical-align:middle" width="20%"><input type="text" name="dealnewpricex" id="dealnewpricex" class="form-control input-lg" value="'.$row['newprice'].'" 	      
					              	tabindex="3"><input type="hidden" name="dealid" id="dealid" value="'.$row['id'].'"/></td>
							
    							
							
							<td><a href=' .$rowdelete. ' class="btn btn-danger btn-block active" role="button">Delete Deal</a>
							<input type="submit" name="dealedit" value="Edit Deal" class="btn btn-primary btn-block" tabindex="5">
							</td></form></tr>';
  							} 
    		
				 			echo '</table>';
			   
			   
			  				 echo '<form role="form" method="post" action="" autocomplete="off"><div class="form-group">
							<h2>Add New Deal:</h2>
							<div class="form-group">
							<label for="dealtitle">Title</label>
							<input type="text" name="dealtitle" id="dealtitle" class="form-control input-lg" placeholder="Deal Title" 	  			      			  tabindex="1">
							<label for="dealimg">Image URL</label>
							<input type="text" name="dealimg" id="dealimg" class="form-control input-lg" placeholder="http://domain.com/dealimg.png" 	  			      			  tabindex="1">
							<label for="dealcurrency">Currency</label>
							<input type="text" name="dealcurrency" id="dealcurrency" class="form-control input-lg" placeholder="$" 	  			      			  tabindex="1">
							
							<label for="dealprice">Original Price</label>
							<input type="text" name="dealprice" id="dealprice" class="form-control input-lg" placeholder="100.00" 	  			      			  tabindex="1">
							<label for="dealnewprice">Discounted Price</label>
							<input type="text" name="dealnewprice" id="dealnewprice" class="form-control input-lg" placeholder="80.00" 	  			      			  tabindex="1">
							<label for="dealpercent">Discount Percent</label>
							<input type="text" name="dealpercent" id="dealpercent" class="form-control input-lg" placeholder="20" 	  			      			  tabindex="1">
							
							<label for="deallink">Buy Link</label>
							<input type="text" name="deallink" id="deallink" class="form-control input-lg" placeholder="http://domain.com/afflink" 	  			      			  tabindex="1"><br>
							<input type="submit" name="submitdeal" value="Add New Deal" class="btn btn-primary" tabindex="5">
							
							</div></form>';
							
			   }
			   
		
	 if($Template==10) {		
			   
			   				echo'<h2>App Items :</h2>
							<table class="table table-striped table-bordered table-hover">
							<tr>
							<th>Image</th>
							<th>Title</th>
							<th>Description</th>
							<th>Actions</th>
							</tr>';
							$stmt = $db->prepare('SELECT * FROM offline WHERE AppID= :AppID');
							$stmt->bindParam(':AppID', $AppID, PDO::PARAM_INT);
							$stmt->execute();		
				
							while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
							$rowdelete=DIR.'delete.php?id='.$row['id'].'&pkg='.$AppID.'&temp='.$Template;
   							echo '<tr>
   							<td align="center" width="20%"><img src="' .$row['img']. '" height="80" width="80"/></td>
    							
    							<td style="vertical-align:middle" width="40%"><input type="text" name="offtitlex" id="offtitlex" class="form-control input-lg" value="'.$row['title'].'" 	      
					              	tabindex="3"></td>
    							<td style="vertical-align:middle" width="20%"><input type="text" name="offdescx" id="offdescx" class="form-control input-lg" value="'.$row['descs'].'" 	      
					              	tabindex="3"></td>
							<input type="hidden" name="offid" id="offid" value="'.$row['id'].'"/></td>
    							
							
							<td><a href=' .$rowdelete. ' class="btn btn-danger btn-block active" role="button">Delete Item</a>
							</td></tr>';
  							} 
    		
				 			echo '</table>';
			   
			   
			  				 echo '<form role="form" method="post" action="" autocomplete="off"><div class="form-group">
							<h2>Add New Item:</h2>
							<div class="form-group">
							<label for="offtitle">Item Title</label>
							<input type="text" name="offtitle" id="offtitle" class="form-control input-lg" placeholder="Item Title" 	  			      			  tabindex="1">
							<label for="offimg">Item Image URL</label>
							<input type="text" name="offimg" id="offimg" class="form-control input-lg" placeholder="http://domain.com/itemimg.png" 	  			      			  tabindex="1">
						
							<label for="offdesc">Item Description</label>
							
							<input type="text" name="offdesc" id="offdesc" class="form-control input-lg" placeholder="Enter item Description here"  tabindex="1">
							<br>
							<input type="submit" name="submitoff" value="Add New Item" class="btn btn-primary" tabindex="5">
							
							</div></form>';
							
			   }		   
					
   if($Template==3) {					
							
			   				echo'<h2>Quiz Questions :</h2>
							<table class="table table-striped table-bordered table-hover">
							<tr >
							<th>Secret Word</th>
							<th>Clue Word 1</th>
							<th>Clue Word 2</th>
							<th>Clue Word 3</th>
							<th>Clue Word 4</th>
							<th>Actions</th>
							</tr>';
							$stmt = $db->prepare('SELECT * FROM quiz WHERE AppID= :AppID');
							$stmt->bindParam(':AppID', $AppID, PDO::PARAM_INT);
							$stmt->execute();		
				
							while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
							$rowdelete=DIR.'delete.php?id='.$row['id'].'&pkg='.$AppID.'&temp='.$Template;
 							$rowedit=DIR.'editdeal.php?id='.$row['id'].'&pkg='.$AppID;
   							echo '<tr><form role="form" method="post" action="" autocomplete="off">
   							<td style="vertical-align:middle"><input type="text" name="secret" id="secret" class="form-control input-lg" value="'.$row['secret'].'" 	      
					              	tabindex="3"><input type="hidden" name="quizid" id="quizid" value="'.$row['id'].'"/></td>
							<td style="vertical-align:middle"><input type="text" name="clue1" id="clue1" class="form-control input-lg" value="'.$row['clue1'].'" 	      
					              	tabindex="3"></td>
    							<td style="vertical-align:middle"><input type="text" name="clue2" id="clue2" class="form-control input-lg" value="'.$row['clue2'].'" 	      
					              	tabindex="3"></td>
    							<td style="vertical-align:middle"><input type="text" name="clue3" id="clue3" class="form-control input-lg" value="'.$row['clue3'].'" 	      
					              	tabindex="3"></td>
    							<td style="vertical-align:middle"><input type="text" name="clue4" id="clue4" class="form-control input-lg" value="'.$row['clue4'].'" 	      
					              	tabindex="3"></td>
							
							<td><a href=' .$rowdelete. ' class="btn btn-danger btn-block active" role="button">Delete</a>
							<input type="submit" name="quizedit" value="Edit" class="btn btn-primary btn-block active" tabindex="5">
							</td></form></tr>';
  							} 
    		
				 			echo '</table>';
				 			
				 			 echo '<form role="form" method="post" action="" autocomplete="off"><div class="form-group">
							<hr><h2>Add New Question:</h2>
							<div class="form-group">
							<label for="secret">Secret Word</label>
							<input type="text" name="secret" id="secret" class="form-control input-lg" placeholder="Breakfast" 	  			      			  tabindex="1">
							<label for="clue1">Clue Word 1</label>
							<input type="text" name="clue1" id="clue1" class="form-control input-lg" placeholder="Milk" 	  			      			  tabindex="1">
							<label for="clue2">Clue Word 2</label>
							<input type="text" name="clue2" id="clue2" class="form-control input-lg" placeholder="Juice" 	  			      			  tabindex="1">
							
							<label for="clue3">Clue Word 3</label>
							<input type="text" name="clue3" id="clue3" class="form-control input-lg" placeholder="Morning" 	  			      			  tabindex="1">
							<label for="clue4">Clue Word 4</label>
							<input type="text" name="clue4" id="clue4" class="form-control input-lg" placeholder="Cereal" 	  			      			  tabindex="1"><br>
							<input type="submit" name="submitquiz" value="Add Question" class="btn btn-primary" tabindex="5">
							
							</div></form></div>';
   
   }
							
	 if($Template==4) {
							
							echo '<form role="form" method="post" action="" autocomplete="off"><div class="form-group">
							<h2>Add Joke:</h2>
							<div class="form-group">
								<textarea rows="4" cols="100" name="joketext" placeholder="Enter Joke text here...">
</textarea><br><br>
								<input type="submit" name="submitjoke" value="Add Joke" class="btn btn-primary" tabindex="5">
							
							</div>
							<h2>Saved Jokes </h2>
							<table class="table table-striped table-bordered table-hover">
							<tr>
							<th>Jokes List</th>
							</tr>';
							$stmt = $db->prepare('SELECT * FROM jokes WHERE appID= :AppID');
							$stmt->bindParam(':AppID', $AppID, PDO::PARAM_INT);
							$stmt->execute();		
				
							while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
							$rowid=DIR.'delete.php?id='.$row['id'].'&pkg='.$AppID.'&temp='.$Template;
 		
   							echo '<tr>
    							<td align="center">'.$row['joke'].'<br><a href=' .$rowid. ' class="btn-block btn-danger btn-sm active" role="button">Delete Joke</a></td>
							</tr>';
  							} 
    		
				 			echo '</table></div></form>';
				 		}					 
					

						
						
						
						
						
								?>
					 </div>
				 
				 </div>
                <!-- /.col-lg-12 -->
            </div>
							
							
							
        <!-- page-wrapper -->
							
							
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