<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');

	// Execute the script if the POST request is submitted
	if(isset($_POST['id'])){
		
		$id = htmlentities($_POST['id']);
		
		$usersDetailsSql = 'SELECT * FROM users WHERE id = :id';
		$usersDetailsStatement = $conn->prepare($usersDetailsSql);
		$usersDetailsStatement->execute(['id' => $id]);
		
		// If data is found for the given item number, return it as a json object
		if($usersDetailsStatement->rowCount() > 0) {
			$row = $usersDetailsStatement->fetch(PDO::FETCH_ASSOC);
			echo json_encode($row);
		}
		$usersDetailsStatement->closeCursor();
	}
