<?php

require('includes/config.php');

	
if(!$user->is_logged_in()){ header('Location: index.php');exit; } 
	// confirm that the 'id' variable has been set
	if (isset($_GET['userid']) && is_numeric($_GET['userid']) && isset($_GET['appid'])  && isset($_GET['temp']))
	{
		// get the 'id' variable from the URL
		$userid = $_GET['userid'];	$appid= $_GET['appid']; $Template= $_GET['temp'];
		// delete record from database
		
		
	
		$stmt = $db->prepare("DELETE FROM apps WHERE apps.appID = :appid AND  apps.memberID= :userid ");
		
			$stmt->bindParam(':appid', $appid, PDO::PARAM_STR);
			$stmt->bindParam(':userid', $userid, PDO::PARAM_STR);
		$stmt->bindParam(':appid', $appid, PDO::PARAM_STR);
			$stmt->execute();
			if($stmt) // will return true if succefull else it will return false
		{
								
		header('Location: apps.php?editbackerror=false');
		exit;
                 }
		
			if ($Template==1) {
		$stmt = $db->prepare("DELETE FROM gallery WHERE appID = :appid");
		
		} else if ($Template==2) {
		
		$stmt = $db->prepare("DELETE FROM deals WHERE AppID = :appid");
		} else if ($Template==3) {
		$stmt = $db->prepare("DELETE quiz WHERE appID = :appid");
		}
			$stmt->bindParam(':appid', $appid, PDO::PARAM_STR);
		$stmt->bindParam(':appid', $appid, PDO::PARAM_STR);
			$stmt->execute();
			
		//redirect to login page
		if($stmt) // will return true if succefull else it will return false
		{
								
		header('Location: apps.php?editbackerror=false');
		exit;
                 }else{
		header('Location: apps.php?editbackerror=true');
                 }
		
	
		
		// redirect user after delete is successful
	}
	else
	// if the 'id' variable isn't set, redirect the user
	{
		header('Location: apps.php?editbackerror=true');
		
		exit;
		
	}

?>