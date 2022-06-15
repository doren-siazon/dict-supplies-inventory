<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	$insert = "SELECT MAX(id) FROM users";
	$insert = $conn->prepare($insert);
	$insert->execute();
	$row = $insert->fetch(PDO::FETCH_ASSOC);
	
	echo $row['MAX(id)'];
	$insert->closeCursor();
?>