<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');

if (isset($_POST['requestorDetailsrequestorFullName'])) {

	$fullName = htmlentities($_POST['requestorDetailsrequestorFullName']);
	$department = htmlentities($_POST['requestorDetailsrequestordepartment']);
	$position = htmlentities($_POST['requestorDetailsrequestorposition']);
	$email = htmlentities($_POST['requestorDetailsrequestorEmail']);
	$mobile = htmlentities($_POST['requestorDetailsrequestorMobile']);
	$address = htmlentities($_POST['requestorDetailsrequestorAddress']);
	$status = htmlentities($_POST['requestorDetailsStatus']);

	if (isset($fullName) && isset($department) && isset($position) && isset($mobile) && isset($address) && isset($email)) {

		// Validate mobile number
		if (filter_var($mobile, FILTER_VALIDATE_INT) === 0 || filter_var($mobile, FILTER_VALIDATE_INT)) {
			// Valid mobile number
		} else {
			// Mobile is wrong
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid phone number</div>';
			exit();
		}


		// Validate email only if it's provided by user
		if (!empty($email)) {
			if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
				// Email is not valid
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid email</div>';
				exit();
			}
		}

		// Check if Full name is empty or not
		if ($fullName == '') {
			// Full Name is empty
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Full Name.</div>';
			exit();
		}
		// Check if Department is empty or not
		if ($department == '') {
			// Department is empty
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Department.</div>';
			exit();
		}
		// Check if Position is empty or not
		if ($position == '') {
			// Position is empty
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Position.</div>';
			exit();
		}

		// Check if address is empty or not
		if ($address == '') {
			// address is empty
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter address.</div>';
			exit();
		}


		// Start the insert process
		$sql = 'INSERT INTO requestor(fullName, department, position, email, mobile, address, status) VALUES(:fullName, :department, :position, :email, :mobile, :address, :status)';
		$stmt = $conn->prepare($sql);
		$stmt->execute(['fullName' => $fullName, 'department' => $department, 'position' => $position, 'email' => $email, 'mobile' => $mobile, 'address' => $address, 'status' => $status]);

		echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Employee added to database</div>';
	} else {
		// One or more fields are empty
		echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
		exit();
	}
}
