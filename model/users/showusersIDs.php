<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');

// Check if the POST request is received and if so, execute the script
if (isset($_POST['textBoxValue'])) {
	$output = '';
	$idString = '%' . htmlentities($_POST['textBoxValue']) . '%';

	// Construct the select query to get the users ID
	$select = 'SELECT id FROM users WHERE id LIKE ?';
	$select = $conn->prepare($select);
	$select->execute([$idString]);

	// If we receive any results from the above query, then display them in a list
	if ($select->rowCount() > 0) {

		// Given users ID is available in DB. Hence create the dropdown list
		$output = '<ul class="list-unstyled suggestionsList" id="idSuggestionsList">';
		while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
			$output .= '<li>' . $row['id'] . '</li>';
		}
		echo '</ul>';
	} else {
		$output = '';
	}
	$select->closeCursor();
	echo $output;
}
