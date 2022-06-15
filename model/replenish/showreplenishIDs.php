<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	// Check if the POST request is received and if so, execute the script
	if(isset($_POST['textBoxValue'])){
		$output = '';
		$replenishIDString = '%' . htmlentities($_POST['textBoxValue']) . '%';
		
		// Construct the SQL query to get the replenish ID
		$sql = 'SELECT replenishID FROM replenishitem WHERE replenishID LIKE ?';
		$stmt = $conn->prepare($sql);
		$stmt->execute([$replenishIDString]);
		
		// If we receive any results from the above query, then display them in a list
		if($stmt->rowCount() > 0){
			
			// Given replenish ID is available in DB. Hence create the dropdown list
			$output = '<ul class="list-unstyled suggestionsList" id="replenishDetailsreplenishIDSuggestionsList">';
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$output .= '<li>' . $row['replenishID'] . '</li>';
			}
			echo '</ul>';
		} else {
			$output = '';
		}
		$stmt->closeCursor();
		echo $output;
	}
?>