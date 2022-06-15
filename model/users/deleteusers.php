<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');

if (isset($_POST['id'])) {

	$id = htmlentities($_POST['id']);

	// Check if mandatory fields are not empty
	if (!empty($id)) {

		// Sanitize id
		$id = filter_var($id, FILTER_SANITIZE_STRING);

		// Check if the users is in the database
		$usersSql = 'SELECT id FROM users WHERE id= :id';
		$usersStatement = $conn->prepare($usersSql);
		$usersStatement->execute(['id' => $id]);
		if ($usersStatement->rowCount() > 0) {

			// users exists in DB. Hence start the DELETE process
			$deleteusersSql = 'DELETE FROM users WHERE id= :id';
			$deleteusersStatement = $conn->prepare($deleteusersSql);
			$deleteusersStatement->execute(['id' => $id]);
		
			echo '<div class="alert alert-success"><a href="administrative-settings.php" class="btn btn-warning btn-md active" role="button" aria-pressed="true" style="float:right">Refresh</a> User successfully deleted.</div>';
			
		
					

		} 
	} 
}
