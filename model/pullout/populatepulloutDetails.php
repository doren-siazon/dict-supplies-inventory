<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');

	// Execute the script if the POST request is submitted
	if(isset($_POST['pulloutDetailspulloutID'])){
		
		$pulloutID = htmlentities($_POST['pulloutDetailspulloutID']);
		
		$pulloutDetailsSql = 'SELECT * FROM pullout WHERE pulloutID = :pulloutID';
		$pulloutDetailsStatement = $conn->prepare($pulloutDetailsSql);
		$pulloutDetailsStatement->execute(['pulloutID' => $pulloutID]);
		
		// If data is found for the given pulloutID, return it as a json object
		if($pulloutDetailsStatement->rowCount() > 0) {
			$row = $pulloutDetailsStatement->fetch(PDO::FETCH_ASSOC);
			echo json_encode($row);
		}
		$pulloutDetailsStatement->closeCursor();
	}
?>