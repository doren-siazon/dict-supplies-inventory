<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	if(isset($_POST['requestorDetailsrequestorID'])){
		
		$requestorDetailsrequestorID = htmlentities($_POST['requestorDetailsrequestorID']);
		
		// Check if mandatory fields are not empty
		if(!empty($requestorDetailsrequestorID)){
			
			// Sanitize requestorID
			$requestorDetailsrequestorID = filter_var($requestorDetailsrequestorID, FILTER_SANITIZE_STRING);

			// Check if the requestor is in the database
			$requestorSql = 'SELECT requestorID FROM requestor WHERE requestorID=:requestorID';
			$requestorStatement = $conn->prepare($requestorSql);
			$requestorStatement->execute(['requestorID' => $requestorDetailsrequestorID]);
			
			if($requestorStatement->rowCount() > 0){
				
				// requestor exists in DB. Hence start the DELETE process
				$deleterequestorSql = 'DELETE FROM requestor WHERE requestorID=:requestorID';
				$deleterequestorStatement = $conn->prepare($deleterequestorSql);
				$deleterequestorStatement->execute(['requestorID' => $requestorDetailsrequestorID]);

				echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>requestor deleted.</div>';
				exit();
				
			} else {
				// requestor does not exist, therefore, tell the user that he can't delete that requestor 
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>requestor does not exist in DB. Therefore, can\'t delete.</div>';
				exit();
			}
			
		} else {
			// requestorID is empty. Therefore, display the error message
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter the requestorID</div>';
			exit();
		}
	}
?>