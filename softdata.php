<?php 
require_once('includes/config.php');


//process login form if submitted
if( (isset($_GET['user'])) && (isset($_GET['pass'])) ){
		$username=$_GET['user'];
		$password=$_GET['pass'];
		
		if($user->login($username,$password)){ 

		$usersmi =$_SESSION['USERNAME']; 
		$userID=$_SESSION['ID'];
		$paid =$_SESSION['PAID'];

			
			
				$stmt = $db->prepare('SELECT * FROM apps WHERE memberID = :userID');
				$stmt->bindParam(':userID', $userID, PDO::PARAM_STR, 12);
				$stmt->execute();		
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
				echo '[app][temp]'.$row['Template'].'[/temp][pkg]'.$row['pkg'].'[/pkg][name]'.$row['appname'].'[/name][app]';
				};
			
			}else {
			
		echo 'WRONG';
		}
	
} else {
echo 'EMPTY';
}

?>