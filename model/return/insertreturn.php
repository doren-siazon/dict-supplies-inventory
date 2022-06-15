<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');

if (isset($_POST['returnDetailsItemNumber'])) {

	$returnDetailsItemNumber = htmlentities($_POST['returnDetailsItemNumber']);
	$returnDetailsreturnDate = htmlentities($_POST['returnDetailsreturnDate']);
	$returnDetailsrequestorID = htmlentities($_POST['returnDetailsrequestorID']);
	$returnDetailsrequestorName = htmlentities($_POST['returnDetailsrequestorName']);
	$returnDetailsrequestorDepartment = htmlentities($_POST['returnDetailsrequestorDepartment']);
	$returnDetailsrequestorPosition = htmlentities($_POST['returnDetailsrequestorPosition']);
	$returnDetailscategoryName = htmlentities($_POST['returnDetailscategoryName']);
	$returnDetailsItemName = htmlentities($_POST['returnDetailsItemName']);
	$returnDetailsDescription = htmlentities($_POST['returnDetailsDescription']);
	$returnDetailsQuantity = htmlentities($_POST['returnDetailsQuantity']);


	$initialStock = 0;
	$newStock = 0;

	// Check if mandatory fields are not empty
	if (isset($returnDetailsItemNumber) && isset($returnDetailsreturnDate) && isset($returnDetailscategoryName) && isset($returnDetailsItemName) && isset($returnDetailsQuantity)) {

		// Check if itemNumber is empty
		if ($returnDetailsItemNumber == '') {
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Item Number.</div>';
			exit();
		}

		// Check if categoryName is empty
		if ($returnDetailscategoryName == '') {
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Category Name.</div>';
			exit();
		}

		// Check if itemName is empty
		if ($returnDetailsItemName == '') {
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Item Name.</div>';
			exit();
		}

		// Check if quantity is empty
		if ($returnDetailsQuantity == '') {
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Quantity.</div>';
			exit();
		}
		// Check if pulloutDate is empty
		if ($returnDetailsreturnDate == '') {
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Date.</div>';
			exit();
		}

		// Sanitize item number
		$returnDetailsItemNumber = filter_var($returnDetailsItemNumber, FILTER_SANITIZE_STRING);

		// Validate item quantity. It has to be an integer
		if (filter_var($returnDetailsQuantity, FILTER_VALIDATE_INT) === 0 || filter_var($returnDetailsQuantity, FILTER_VALIDATE_INT)) {
			// Valid quantity
		} else {
			// Quantity is not a valid number
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid number for quantity.</div>';
			exit();
		}


		// Check if the item exists in item table and 
		// calculate the stock values and update to match the new return quantity
		$stockSql = 'SELECT stock FROM item WHERE itemNumber=:itemNumber';
		$stockStatement = $conn->prepare($stockSql);
		$stockStatement->execute(['itemNumber' => $returnDetailsItemNumber]);
		if ($stockStatement->rowCount() > 0) {

			// Check if the requestor is in DB
			$requestorSql = 'SELECT * FROM requestor WHERE requestorID = :requestorID';
			$requestorStatement = $conn->prepare($requestorSql);
			$requestorStatement->execute(['requestorID' => $returnDetailsrequestorID]);

			if ($requestorStatement->rowCount() > 0) {
				// requestor exits. That means both requestor, item, and stocks are available. Hence start INSERT and UPDATE
				$requestorRow = $requestorStatement->fetch(PDO::FETCH_ASSOC);
				$requestorName = $requestorRow['fullName'];
				$requestorDepartment = $requestorRow['department'];
				$requestorPosition = $requestorRow['position'];



				// Item exits in the item table, therefore, start the inserting data to return table
				$insertreturnSql = 'INSERT INTO returnitem(itemNumber, returnDate, requestorID, requestorName, requestorDepartment, requestorPosition, categoryName, itemName, description, quantity) VALUES(:itemNumber, :returnDate, :requestorID, :requestorName, :requestorDepartment, :requestorPosition, :categoryName, :itemName, :description, :quantity)';
				$insertreturnStatement = $conn->prepare($insertreturnSql);
				$insertreturnStatement->execute(['itemNumber' => $returnDetailsItemNumber, 'returnDate' => $returnDetailsreturnDate, 'requestorID' => $returnDetailsrequestorID, 'requestorName' => $returnDetailsrequestorName, 'requestorDepartment' => $returnDetailsrequestorDepartment, 'requestorPosition' => $returnDetailsrequestorPosition, 'categoryName' => $returnDetailscategoryName, 'itemName' => $returnDetailsItemName, 'description' => $returnDetailsDescription, 'quantity' => $returnDetailsQuantity]);

				// Calculate the new stock value using the existing stock in item table
				$row = $stockStatement->fetch(PDO::FETCH_ASSOC);
				$initialStock = $row['stock'];
				$newStock = $initialStock + $returnDetailsQuantity;

				// Update the new stock value in item table
				$updateStockSql = 'UPDATE item SET stock = :stock WHERE itemNumber = :itemNumber';
				$updateStockStatement = $conn->prepare($updateStockSql);
				$updateStockStatement->execute(['stock' => $newStock, 'itemNumber' => $returnDetailsItemNumber]);

				echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>The Return Item added to database and stock values updated.</div>';
				exit();
			} else {
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Requestor does not exist.</div>';
				exit();
			}
		} else {
			// Item does not exist in item table, therefore, you can't make a return from it 
			// to add it to DB as a new return
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Item does not exist. Therefore, first enter this item to Database using the <strong>Item</strong> tab.</div>';
			exit();
		}
	} else {
		// One or more mandatory fields are empty. Therefore, display a the error message
		echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
		exit();
	}
}
