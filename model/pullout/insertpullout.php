<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');

if (isset($_POST['pulloutDetailsItemNumber'])) {

	$itemNumber = htmlentities($_POST['pulloutDetailsItemNumber']);
	$requestorID = htmlentities($_POST['pulloutDetailsrequestorID']);
	$requestorName = htmlentities($_POST['pulloutDetailsrequestorName']);
	$requestorDepartment = htmlentities($_POST['pulloutDetailsrequestorDepartment']);
	$categoryName = htmlentities($_POST['pulloutDetailscategoryName']);
	$itemName = htmlentities($_POST['pulloutDetailsItemName']);
	$pulloutDate = htmlentities($_POST['pulloutDetailspulloutDate']);
	$description = htmlentities($_POST['pulloutDetailsdescription']);
	$quantity = htmlentities($_POST['pulloutDetailsQuantity']);

	// Check if mandatory fields are not empty
	if (!empty($itemNumber) && isset($requestorID) && isset($pulloutDate) && isset($quantity)) {


		// Sanitize item number
		$itemNumber = filter_var($itemNumber, FILTER_SANITIZE_STRING);

		// Validate item quantity. It has to be a number
		if (filter_var($quantity, FILTER_VALIDATE_INT) === 0 || filter_var($quantity, FILTER_VALIDATE_INT)) {
			// Valid quantity
		} else {
			// Quantity is not a valid number
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid number for quantity</div>';
			exit();
		}

		// Check if requestorID is empty
		if ($requestorID == '') {
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a requestor ID.</div>';
			exit();
		}

		// Validate requestorID
		if (filter_var($requestorID, FILTER_VALIDATE_INT) === 0 || filter_var($requestorID, FILTER_VALIDATE_INT)) {
			// Valid requestorID
		} else {
			// requestorID is not a valid number
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid requestor ID</div>';
			exit();
		}

		// Check if itemNumber is empty
		if ($itemNumber == '') {
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Item Number.</div>';
			exit();
		}

		// Check if pulloutDate is empty
		if ($pulloutDate == '') {
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Date.</div>';
			exit();
		}




		// Calculate the stock values
		$stockSql = 'SELECT stock FROM item WHERE itemNumber = :itemNumber';
		$stockStatement = $conn->prepare($stockSql);
		$stockStatement->execute(['itemNumber' => $itemNumber]);
		if ($stockStatement->rowCount() > 0) {
			// Item exits in DB, therefore, can proceed to a pullout
			$row = $stockStatement->fetch(PDO::FETCH_ASSOC);
			$currentQuantityInItemsTable = $row['stock'];

			if ($currentQuantityInItemsTable <= 0) {
				// If currentQuantityInItemsTable is <= 0, stock is empty! that means we can't make a sell. Hence abort.
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Stock is empty. Therefore, can\'t make a pullout. Please select a different item.</div>';
				exit();
			} elseif ($currentQuantityInItemsTable < $quantity) {
				// Requested pullout quantity is higher than available item quantity. Hence abort 
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Not enough stock available for this pullout. Therefore, can\'t make a pullout. Please select a different item.</div>';
				exit();
			} else {
				// Has at least 1 or more in stock, hence proceed to next steps
				$newQuantity = $currentQuantityInItemsTable - $quantity;

				// Check if the requestor is in DB
				$requestorSql = 'SELECT * FROM requestor WHERE requestorID = :requestorID';
				$requestorStatement = $conn->prepare($requestorSql);
				$requestorStatement->execute(['requestorID' => $requestorID]);

				if ($requestorStatement->rowCount() > 0) {
					// requestor exits. That means both requestor, item, and stocks are available. Hence start INSERT and UPDATE
					$requestorRow = $requestorStatement->fetch(PDO::FETCH_ASSOC);
					$requestorName = $requestorRow['fullName'];
					$requestorDepartment = $requestorRow['department'];



					// INSERT data to pullout table
					$insertpulloutSql = 'INSERT INTO pullout(itemNumber, requestorID, requestorName, requestorDepartment, categoryName, itemName, pulloutDate, description, quantity) VALUES(:itemNumber, :requestorID, :requestorName, :requestorDepartment, :categoryName, :itemName, :pulloutDate, :description, :quantity)';
					$insertpulloutStatement = $conn->prepare($insertpulloutSql);
					$insertpulloutStatement->execute(['itemNumber' => $itemNumber, 'requestorID' => $requestorID, 'requestorName' => $requestorName, 'requestorDepartment' => $requestorDepartment, 'categoryName' => $categoryName, 'itemName' => $itemName, 'pulloutDate' => $pulloutDate, 'description' => $description, 'quantity' => $quantity]);

					// UPDATE the stock in item table
					$stockUpdateSql = 'UPDATE item SET stock = :stock WHERE itemNumber = :itemNumber';
					$stockUpdateStatement = $conn->prepare($stockUpdateSql);
					$stockUpdateStatement->execute(['stock' => $newQuantity, 'itemNumber' => $itemNumber]);

					echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Pullout details added to DB and stocks updated.</div>';
					exit();
				} else {
					echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Requestor does not exist.</div>';
					exit();
				}
			}

			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Item already exists in DB. Please click the <strong>Update</strong> button to update the details. Or use a different Item Number.</div>';
			exit();
		} else {
			// Item does not exist, therefore, you can't make a pullout from it
			echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Item does not exist in DB.</div>';
			exit();
		}
	} else {
		// One or more mandatory fields are empty. Therefore, display a the error message
		echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
		exit();
	}
}
