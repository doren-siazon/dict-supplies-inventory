<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');

	// Execute the script if the POST request is submitted
	if(isset($_POST['returnDetailsreturnID'])){
		
		$returnID = htmlentities($_POST['returnDetailsreturnID']);
		
		$returnDetailsSql = 'SELECT * FROM returnitem WHERE returnID = :returnID';
		$returnDetailsStatement = $conn->prepare($returnDetailsSql);
		$returnDetailsStatement->execute(['returnID' => $returnID]);
		
		// If data is found for the given returnID, return it as a json object
		if($returnDetailsStatement->rowCount() > 0) {
			$row = $returnDetailsStatement->fetch(PDO::FETCH_ASSOC);
			echo json_encode($row);
		}
		$returnDetailsStatement->closeCursor();
	}
?>