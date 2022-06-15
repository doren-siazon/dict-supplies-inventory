<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');

if (isset($_POST['replenishDetailsItemNumber'])) {

	$replenishDetailsItemNumber = htmlentities($_POST['replenishDetailsItemNumber']);
	$replenishDetailsreplenishDate = htmlentities($_POST['replenishDetailsreplenishDate']);
	$replenishDetailscategoryName = htmlentities($_POST['replenishDetailscategoryName']);
	$replenishDetailsItemName = htmlentities($_POST['replenishDetailsItemName']);
	$replenishDetailsDescription = htmlentities($_POST['replenishDetailsDescription']);
	$replenishDetailsQuantity = htmlentities($_POST['replenishDetailsQuantity']);


	$initialStock = 0;
	$newStock = 0;

	// Check if mandatory fields are not empty
	if (isset($replenishDetailsItemNumber) && isset($replenishDetailsreplenishDate) && isset($replenishDetailscategoryName) && isset($replenishDetailsItemName) && isset($replenishDetailsQuantity)) {

		// Check if itemNumber is empty
		if ($replenishDetailsItemNumber == '') {
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Item Number.</div>';
			exit();
		}

		// Check if categoryName is empty
		if ($replenishDetailscategoryName == '') {
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Category Name.</div>';
			exit();
		}

		// Check if itemName is empty
		if ($replenishDetailsItemName == '') {
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Item Name.</div>';
			exit();
		}

		// Check if quantity is empty
		if ($replenishDetailsQuantity == '') {
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Quantity.</div>';
			exit();
		}

		// Check if pulloutDate is empty
		if ($replenishDetailsreplenishDate == '') {
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Date.</div>';
			exit();
		}

		// Sanitize item number
		$replenishDetailsItemNumber = filter_var($replenishDetailsItemNumber, FILTER_SANITIZE_STRING);

		// Validate item quantity. It has to be an integer
		if (filter_var($replenishDetailsQuantity, FILTER_VALIDATE_INT) === 0 || filter_var($replenishDetailsQuantity, FILTER_VALIDATE_INT)) {
			// Valid quantity
		} else {
			// Quantity is not a valid number
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid number for quantity.</div>';
			exit();
		}


		// Check if the item exists in item table and 
		// calculate the stock values and update to match the new replenish quantity
		$stockSql = 'SELECT stock FROM item WHERE itemNumber=:itemNumber';
		$stockStatement = $conn->prepare($stockSql);
		$stockStatement->execute(['itemNumber' => $replenishDetailsItemNumber]);
		if ($stockStatement->rowCount() > 0) {

			// Item exits in the item table, therefore, start the inserting data to replenish table
			$insertreplenishSql = 'INSERT INTO replenishitem(itemNumber, replenishDate, categoryName, itemName, description, quantity) VALUES(:itemNumber, :replenishDate, :categoryName, :itemName, :description, :quantity)';
			$insertreplenishStatement = $conn->prepare($insertreplenishSql);
			$insertreplenishStatement->execute(['itemNumber' => $replenishDetailsItemNumber, 'replenishDate' => $replenishDetailsreplenishDate, 'categoryName' => $replenishDetailscategoryName, 'itemName' => $replenishDetailsItemName, 'description' => $replenishDetailsDescription, 'quantity' => $replenishDetailsQuantity]);

			// Calculate the new stock value using the existing stock in item table
			$row = $stockStatement->fetch(PDO::FETCH_ASSOC);
			$initialStock = $row['stock'];
			$newStock = $initialStock + $replenishDetailsQuantity;

			// Update the new stock value in item table
			$updateStockSql = 'UPDATE item SET stock = :stock WHERE itemNumber = :itemNumber';
			$updateStockStatement = $conn->prepare($updateStockSql);
			$updateStockStatement->execute(['stock' => $newStock, 'itemNumber' => $replenishDetailsItemNumber]);

			echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>The Replenish Item added to database and stock values updated.</div>';
			exit();
		} else {
			// Item does not exist in item table, therefore, you can't make a replenish from it 
			// to add it to DB as a new replenish
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Item does not exist. Therefore, first enter this item to Database using the <strong>Item</strong> tab.</div>';
			exit();
		}
	} else {
		// One or more mandatory fields are empty. Therefore, display a the error message
		echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
		exit();
	}
}
