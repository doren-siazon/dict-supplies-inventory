<?php
	$itemDetailsSql = 'SELECT categoryName FROM item';
	$itemDetailsStatement = $conn->prepare($itemDetailsSql);
	$itemDetailsStatement->execute();
	
	if($itemDetailsStatement->rowCount() > 0) {
		while($row = $itemDetailsStatement->fetch(PDO::FETCH_ASSOC)) {
			echo '<option>' . $row['categoryName'] . '</option>';
		}
	}
	$itemDetailsStatement->closeCursor();
?>