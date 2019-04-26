<?php
require('includes/config.php');

if( (isset($_GET['appid'])) && (isset($_GET['temp'])) ){
$appid=$_GET['appid'];
$temp=$_GET['temp'];


	if ($temp==10) {
			$stmt = $db->prepare('SELECT * FROM offline WHERE AppID= :AppID');
			$stmt->bindParam(':AppID', $appid, PDO::PARAM_INT);
			$stmt->execute();		
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
				echo '[item][title]'.$row['title'].'[/title][desc]'.$row['descs'].'[/desc][img]'.$row['img'].'[/img][/item]';
								}
	
	
	} // END OFF TEMP
	
	else if ($temp==1) {
			$stmt = $db->prepare('SELECT * FROM gallery WHERE appID= :AppID');
			$stmt->bindParam(':AppID', $appid, PDO::PARAM_INT);
			$stmt->execute();		
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
				echo $row['img'].';';
								}
	
	
	}//end gallery
		else if ($temp==3) {
			$stmt = $db->prepare('SELECT * FROM quiz WHERE appID= :AppID');
			$stmt->bindParam(':AppID', $appid, PDO::PARAM_INT);
			$stmt->execute();
			echo '[answer]';		
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
				echo $row['secret'].',';
								}
			echo '[/answer]';
			
			$stmt = $db->prepare('SELECT * FROM quiz WHERE appID= :AppID');
			$stmt->bindParam(':AppID', $appid, PDO::PARAM_INT);
			$stmt->execute();
			echo '[clue]';		
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
				echo $row['clue1'].','.$row['clue2'].','.$row['clue3'].','.$row['clue4'].'-';
								}
			echo '[/clue]';
	// end quizz
	}else if ($temp==4) {
			$stmt = $db->prepare('SELECT * FROM jokes WHERE AppID= :AppID');
			$stmt->bindParam(':AppID', $appid, PDO::PARAM_INT);
			$stmt->execute();
			echo '<jokes>';	
			$counter=1;
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
				echo '<joke><id>'.$counter.'</id><jokeText>'.$row['joke'].'</jokeText></joke>';
						 $counter ++;		}
				
			echo '/<jokes>';	

	
	}//end jokes
}
else {
echo 'error';
}

?>