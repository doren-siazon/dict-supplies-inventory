<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');

	// Execute the script if the POST request is submitted
	if(isset($_POST['requestorID'])){
		
		$requestorID = htmlentities($_POST['requestorID']);
		
		$requestorDetailsSql = 'SELECT * FROM requestor WHERE requestorID = :requestorID';
		$requestorDetailsStatement = $conn->prepare($requestorDetailsSql);
		$requestorDetailsStatement->execute(['requestorID' => $requestorID]);
		
		// If data is found for the given item number, return it as a json object
		if($requestorDetailsStatement->rowCount() > 0) {
			$row = $requestorDetailsStatement->fetch(PDO::FETCH_ASSOC);
			echo json_encode($row);
		}
		$requestorDetailsStatement->closeCursor();
	}
?>