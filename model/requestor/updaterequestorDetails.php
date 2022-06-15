<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	// Check if the POST query is received
	if(isset($_POST['requestorDetailsrequestorID'])) {
		
		$requestorDetailsrequestorID = htmlentities($_POST['requestorDetailsrequestorID']);
		$requestorDetailsrequestorFullName = htmlentities($_POST['requestorDetailsrequestorFullName']);
		$requestorDetailsrequestordepartment = htmlentities($_POST['requestorDetailsrequestordepartment']);
		$requestorDetailsrequestorposition = htmlentities($_POST['requestorDetailsrequestorposition']);
		$requestorDetailsrequestorMobile = htmlentities($_POST['requestorDetailsrequestorMobile']);
		$requestorDetailsrequestorEmail = htmlentities($_POST['requestorDetailsrequestorEmail']);
		$requestorDetailsrequestorAddress = htmlentities($_POST['requestorDetailsrequestorAddress']);
		$requestorDetailsStatus = htmlentities($_POST['requestorDetailsStatus']);
		
		// Check if mandatory fields are not empty
		if(isset($requestorDetailsrequestorFullName) && isset($requestorDetailsrequestorMobile) && isset($requestorDetailsrequestorAddress)) {
			
			// Validate mobile number
			if(filter_var($requestorDetailsrequestorMobile, FILTER_VALIDATE_INT) === 0 || filter_var($requestorDetailsrequestorMobile, FILTER_VALIDATE_INT)) {
				// Mobile number is valid
			} else {
				// Mobile number is not valid
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid mobile number</div>';
				exit();
			}
			
			// Check if requestorID field is empty. If so, display an error message
			// We have to specifically tell this to user because the (*) mark is not added to that field
			if(empty($requestorDetailsrequestorID)){
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter the requestorID to update that requestor.</div>';
				exit();
			}
			
			
			// Validate email only if it's provided by user
			if(!empty($requestorDetailsrequestorEmail)) {
				if (filter_var($requestorDetailsrequestorEmail, FILTER_VALIDATE_EMAIL) === false) {
					// Email is not valid
					echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid email</div>';
					exit();
				}
			}

			// Check if the given requestorID is in the DB
			$requestorIDSelectSql = 'SELECT requestorID FROM requestor WHERE requestorID = :requestorDetailsrequestorID';
			$requestorIDSelectStatement = $conn->prepare($requestorIDSelectSql);
			$requestorIDSelectStatement->execute(['requestorDetailsrequestorID' => $requestorDetailsrequestorID]);
			
			if($requestorIDSelectStatement->rowCount() > 0) {
				
				// requestorID is available in DB. Therefore, we can go ahead and UPDATE its details
				// Construct the UPDATE query
				$updaterequestorDetailsSql = 'UPDATE requestor SET fullName = :fullName, department = :department, position = :position, email = :email, mobile = :mobile, address = :address, status = :status WHERE requestorID = :requestorID';
				$updaterequestorDetailsStatement = $conn->prepare($updaterequestorDetailsSql);
				$updaterequestorDetailsStatement->execute(['fullName' => $requestorDetailsrequestorFullName, 'department' => $requestorDetailsrequestordepartment, 'position' => $requestorDetailsrequestorposition, 'email' => $requestorDetailsrequestorEmail, 'mobile' => $requestorDetailsrequestorMobile, 'address' => $requestorDetailsrequestorAddress, 'status' => $requestorDetailsStatus, 'requestorID' => $requestorDetailsrequestorID]);
				
				// UPDATE requestor name in pullout table too
				$updaterequestorInpulloutTableSql = 'UPDATE pullout SET requestorName = :requestorName, requestorDepartment = :requestorDepartment WHERE requestorID = :requestorID';
				$updaterequestorInpulloutTableStatement = $conn->prepare($updaterequestorInpulloutTableSql);
				$updaterequestorInpulloutTableStatement->execute(['requestorName' => $requestorDetailsrequestorFullName, 'requestorDepartment' => $requestorDetailsrequestordepartment, 'requestorID' => $requestorDetailsrequestorID]);
				
				echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Requestor details updated.</div>';
				exit();
			} else {
				// requestorID is not in DB. Therefore, stop the update and quit
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>RequestorID does not exist in DB. Therefore, update not possible.</div>';
				exit();
			}
			
		} else {
			// One or more mandatory fields are empty. Therefore, display the error message
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
			exit();
		}
	}
?>