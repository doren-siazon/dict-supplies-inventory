<?php

// Updated script - 2018-05-09

	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	if(isset($_POST['replenishDetailsreplenishID'])){

		$replenishDetailsItemNumber = htmlentities($_POST['replenishDetailsItemNumber']);
		$replenishDetailsreplenishDate = htmlentities($_POST['replenishDetailsreplenishDate']);
		$replenishDetailscategoryName = htmlentities($_POST['replenishDetailscategoryName']);
		$replenishDetailsItemName = htmlentities($_POST['replenishDetailsItemName']);
		$replenishDetailsDescription = htmlentities($_POST['replenishDetailsDescription']);
		$replenishDetailsQuantity = htmlentities($_POST['replenishDetailsQuantity']);
		$replenishDetailsreplenishID = htmlentities($_POST['replenishDetailsreplenishID']);
		
		$quantityInOriginalOrder = 0;
		$quantityInNewOrder = 0;
		$originalStockInItemTable = 0;
		$newStock = 0;
		$originalreplenishItemNumber = '';
		
		// Check if mandatory fields are not empty
		if(isset($replenishDetailsItemNumber) && isset($replenishDetailsreplenishDate) && isset($replenishDetailsQuantity)){
			
			// Sanitize item number
			$replenishDetailsItemNumber = filter_var($replenishDetailsItemNumber, FILTER_SANITIZE_STRING);
			
			// Validate item quantity. It has to be an integer
			if(filter_var($replenishDetailsQuantity, FILTER_VALIDATE_INT) === 0 || filter_var($replenishDetailsQuantity, FILTER_VALIDATE_INT)){
				// Quantity is valid
			} else {
				// Quantity is not a valid number
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid number for quantity.</div>';
				exit();
			}
						
			// Check if replenishID is empty
			if($replenishDetailsreplenishID == ''){ 
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a replenish ID.</div>';
				exit();
			}
			
			// Check if itemNumber is empty
			if($replenishDetailsItemNumber == ''){ 
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Item Number.</div>';
				exit();
			}
			
			// Check if quantity is empty
			if($replenishDetailsQuantity == ''){ 
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter quantity.</div>';
				exit();
			}
			
			// Get the quantity and itemNumber in original replenish order
			$orginalreplenishQuantitySql = 'SELECT * FROM replenishitem WHERE replenishID = :replenishID';
			$originalreplenishQuantityStatement = $conn->prepare($orginalreplenishQuantitySql);
			$originalreplenishQuantityStatement->execute(['replenishID' => $replenishDetailsreplenishID]);
						
			if($originalreplenishQuantityStatement->rowCount() > 0){
				
				// replenish details exist in DB. Hence proceed to calculate the stock
				$originalQtyRow = $originalreplenishQuantityStatement->fetch(PDO::FETCH_ASSOC);
				$quantityInOriginalOrder = $originalQtyRow['quantity'];
				$originalOrderItemNumber = $originalQtyRow['itemNumber'];

				// Check if the user wants to update the itemNumber too. In that case,
				// we need to remove the quantity of the original order for that item and 
				// update the new item details in the item table.
				// Check if the original itemNumber is the same as the new itemNumber
				if($originalOrderItemNumber !== $replenishDetailsItemNumber) {
					// Item numbers are different. That means the user wants to update a new item number too
					// in that case, need to update both items' stocks.
						
					// Get the stock of the new item from item table
					$newItemCurrentStockSql = 'SELECT * FROM item WHERE itemNumber = :itemNumber';
					$newItemCurrentStockStatement = $conn->prepare($newItemCurrentStockSql);
					$newItemCurrentStockStatement->execute(['itemNumber' => $replenishDetailsItemNumber]);
					
					if($newItemCurrentStockStatement->rowCount() < 1){
						// Item number is not in DB. Hence abort.
						echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Item Number does not exist. If you want to update this item, please add it to the Database first.</div>';
						exit();
					}
					
					// Calculate the new stock value for new item using the existing stock in item table
					$newItemRow = $newItemCurrentStockStatement->fetch(PDO::FETCH_ASSOC);
					$originalQuantityForNewItem = $newItemRow['stock'];
					$enteredQuantityForNewItem = $replenishDetailsQuantity;
					$newItemNewStock = $originalQuantityForNewItem - $enteredQuantityForNewItem;
					
					// UPDATE the stock for new item in item table
					$newItemStockUpdateSql = 'UPDATE item SET stock = :stock WHERE itemNumber = :itemNumber';
					$newItemStockUpdateStatement = $conn->prepare($newItemStockUpdateSql);
					$newItemStockUpdateStatement->execute(['stock' => $newItemNewStock, 'itemNumber' => $replenishDetailsItemNumber]);
					
					// Get the current stock of the previous item
					$previousItemCurrentStockSql = 'SELECT * FROM item WHERE itemNumber=:itemNumber';
					$previousItemCurrentStockStatement = $conn->prepare($previousItemCurrentStockSql);
					$previousItemCurrentStockStatement->execute(['itemNumber' => $originalOrderItemNumber]);
					
					// Calculate the new stock value for the previous item using the existing stock in item table
					$previousItemRow = $previousItemCurrentStockStatement->fetch(PDO::FETCH_ASSOC);
					$currentQuantityForPreviousItem = $previousItemRow['stock'];
					$previousItemNewStock = $currentQuantityForPreviousItem - $quantityInOriginalOrder;
					
					// UPDATE the stock for previous item in item table
					$previousItemStockUpdateSql = 'UPDATE item SET stock = :stock WHERE itemNumber = :itemNumber';
					$previousItemStockUpdateStatement = $conn->prepare($previousItemStockUpdateSql);
					$previousItemStockUpdateStatement->execute(['stock' => $previousItemNewStock, 'itemNumber' => $originalOrderItemNumber]);
					
					// Finally UPDATE the replenish table for new item
					$updatereplenishDetailsSql = 'UPDATE replenishitem SET itemNumber = :itemNumber, replenishDate = :replenishDate, categoryName = :categoryName, itemName = :itemName, description = :description, quantity = :quantity WHERE replenishID = :replenishID';
					$updatereplenishDetailsStatement = $conn->prepare($updatereplenishDetailsSql);
					$updatereplenishDetailsStatement->execute(['itemNumber' => $replenishDetailsItemNumber, 'replenishDate' => $replenishDetailsreplenishDate, 'categoryName' => $replenishDetailscategoryName, 'itemName' => $replenishDetailsItemName, 'description' => $replenishDetailsDescription, 'quantity' => $replenishDetailsQuantity, 'replenishID' => $replenishDetailsreplenishID]);
					
					echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>The replenish item added to database and stock values updated.</div>';
					exit();
					
				} else {
					// Item numbers are equal. That means item number is valid
					// Get the quantity (stock) in item table
					$stockSql = 'SELECT * FROM item WHERE itemNumber=:itemNumber';
					$stockStatement = $conn->prepare($stockSql);
					$stockStatement->execute(['itemNumber' => $replenishDetailsItemNumber]);
					
					if($stockStatement->rowCount() > 0){

						// Item exists in the item table, therefore, start inserting data to replenish table	
						// Calculate the new stock value using the existing stock in item table
						$row = $stockStatement->fetch(PDO::FETCH_ASSOC);
						$quantityInNewOrder = $replenishDetailsQuantity;
						$originalStockInItemTable = $row['stock'];
						$newStock = $originalStockInItemTable + ($quantityInNewOrder - $quantityInOriginalOrder);
						
						// Update the new stock value in item table.
						$updateStockSql = 'UPDATE item SET stock = :stock WHERE itemNumber = :itemNumber';
						$updateStockStatement = $conn->prepare($updateStockSql);
						$updateStockStatement->execute(['stock' => $newStock, 'itemNumber' => $replenishDetailsItemNumber]);
						
						// Next, update the replenish table
						$updatereplenishDetailsSql = 'UPDATE replenishitem SET replenishDate = :replenishDate, description = :description, quantity = :quantity WHERE replenishID = :replenishID';
						$updatereplenishDetailsStatement = $conn->prepare($updatereplenishDetailsSql);
						$updatereplenishDetailsStatement->execute(['replenishDate' => $replenishDetailsreplenishDate, 'description' => $replenishDetailsDescription, 'quantity' => $replenishDetailsQuantity, 'replenishID' => $replenishDetailsreplenishID]);
						
						echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>The replenish item added to database and stock values updated.</div>';
						exit();
						
					} else {
						// Item does not exist in item table, therefore, you can't update 
						// replenish details for it 
						echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Item does not exist. Therefore, first enter this item to Database using the <strong>Item</strong> tab.</div>';
						exit();
					}	
					
				}
	
			} else {
				
				// replenishID does not exist in replenish table, therefore, you can't update it 
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>The replenish item  does not exist in DB for the given replenish ID. Therefore, can\'t update.</div>';
				exit();
				
			}

		} else {
			// One or more mandatory fields are empty. Therefore, display the error message
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
			exit();
		}
	}
?>