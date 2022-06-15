<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');

	// Execute the script if the POST request is submitted
	if(isset($_POST['replenishDetailsreplenishID'])){
		
		$replenishID = htmlentities($_POST['replenishDetailsreplenishID']);
		
		$replenishDetailsSql = 'SELECT * FROM replenishitem WHERE replenishID = :replenishID';
		$replenishDetailsStatement = $conn->prepare($replenishDetailsSql);
		$replenishDetailsStatement->execute(['replenishID' => $replenishID]);
		
		// If data is found for the given replenishID, replenish it as a json object
		if($replenishDetailsStatement->rowCount() > 0) {
			$row = $replenishDetailsStatement->fetch(PDO::FETCH_ASSOC);
			echo json_encode($row);
		}
		$replenishDetailsStatement->closeCursor();
	}
?>