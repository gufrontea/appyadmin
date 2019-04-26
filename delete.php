<?php

require('includes/config.php');

	
if(!$user->is_logged_in()){ header('Location: index.php'); } 
	// confirm that the 'id' variable has been set
	if (isset($_GET['id']) && is_numeric($_GET['id']) && isset($_GET['pkg']))
	{
		// get the 'id' variable from the URL
		$id = $_GET['id'];	 $pageid= $_GET['pkg'];  $Template= $_GET['temp'];
		// delete record from database
			if ($Template==1) {
		$stmt = $db->prepare("DELETE FROM gallery WHERE id =:id");
		} else if ($Template==2) {
		$stmt = $db->prepare("DELETE FROM deals WHERE id =:id");
		} else if ($Template==3) {
		$stmt = $db->prepare("DELETE FROM quiz WHERE id =:id");
		} else if ($Template==4) {
		$stmt = $db->prepare("DELETE FROM jokes WHERE id =:id");
		}  else if ($Template==10) {
		$stmt = $db->prepare("DELETE FROM offline WHERE id =:id");
		}
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		
			$stmt->execute();
			
		
		//redirect to login page
		if($stmt) // will return true if succefull else it will return false
		{
								
		header('Location: edit_content.php?id='.$pageid);
		exit;
                 }else{
                 echo 'SQL Query Unsuccesssful';
                 }
		
	
		
		// redirect user after delete is successful
	}
	else
	// if the 'id' variable isn't set, redirect the user
	{
		if (isset($_GET['pkg'])){
		
		
		header('Location: edit_content.php?id='.$pageid);
		exit;
		} else  {
		
		header('Location: memberpage.php');
		exit;
		}
	}

?>