<?php

	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	if(isset($_POST['pulloutDetailspulloutID'])){

		$pulloutDetailsItemNumber = htmlentities($_POST['pulloutDetailsItemNumber']);
		$pulloutDetailsrequestorID = htmlentities($_POST['pulloutDetailsrequestorID']);
		$pulloutDetailsrequestorName = htmlentities($_POST['pulloutDetailsrequestorName']);
		$pulloutDetailsrequestorDepartment = htmlentities($_POST['pulloutDetailsrequestorDepartment']);
		$pulloutDetailsrequestorPosition = htmlentities($_POST['pulloutDetailsrequestorPosition']);
		$pulloutDetailscategoryName = htmlentities($_POST['pulloutDetailscategoryName']);
		$pulloutDetailsItemName = htmlentities($_POST['pulloutDetailsItemName']);
		$pulloutDetailspulloutDate = htmlentities($_POST['pulloutDetailspulloutDate']);
		$pulloutDetailsQuantity = htmlentities($_POST['pulloutDetailsQuantity']);
		$pulloutDetailsdescription = htmlentities($_POST['pulloutDetailsdescription']);
		$pulloutDetailspulloutID = htmlentities($_POST['pulloutDetailspulloutID']);

		
		$quantityInOriginalOrder = 0;
		$quantityInNewOrder = 0;
		$originalStockInItemTable = 0;
		$newStock = 0;
		
		// Check if mandatory fields are not empty
		if(isset($pulloutDetailsItemNumber) && isset($pulloutDetailspulloutDate) && isset($pulloutDetailsQuantity) && isset($pulloutDetailsrequestorID)){
			
			// Sanitize item number
			$pulloutDetailsItemNumber = filter_var($pulloutDetailsItemNumber, FILTER_SANITIZE_STRING);
			
			// Validate item quantity. It has to be an integer
			if(filter_var($pulloutDetailsQuantity, FILTER_VALIDATE_INT) === 0 || filter_var($pulloutDetailsQuantity, FILTER_VALIDATE_INT)){
				// Quantity is valid
			} else {
				// Quantity is not a valid number
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid number for Quantity.</div>';
				exit();
			}
						
			// Check if pulloutID is empty
			if($pulloutDetailspulloutID == ''){ 
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a Pullout ID.</div>';
				exit();
			}
			
			// Check if requestorID is empty
			if($pulloutDetailsrequestorID == ''){ 
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a Requestor ID.</div>';
				exit();
			}
			
			// Check if itemNumber is empty
			if($pulloutDetailsItemNumber == ''){ 
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Item Number.</div>';
				exit();
			}
			
			// Check if quantity is empty
			if($pulloutDetailsQuantity == ''){ 
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter quantity.</div>';
				exit();
			}
			
			
			// Get the quantity and itemNumber in original pullout order
			$orginalpulloutQuantitySql = 'SELECT * FROM pullout WHERE pulloutID = :pulloutID';
			$originalpulloutQuantityStatement = $conn->prepare($orginalpulloutQuantitySql);
			$originalpulloutQuantityStatement->execute(['pulloutID' => $pulloutDetailspulloutID]);

			
			// Get the requestorID for the given requestorName
			/* $requestorIDsql = 'SELECT * FROM requestor WHERE fullName = :fullName';
			$requestorIDStatement = $conn->prepare($requestorIDsql);
			$requestorIDStatement->execute(['fullName' => $pulloutDetailsrequestorName]);
			$row = $requestorIDStatement->fetch(PDO::FETCH_ASSOC);
			$requestorID = $row['requestorID']; */
			
			$requestorIDsql = 'SELECT * FROM requestor WHERE requestorID = :requestorID';
			$requestorIDStatement = $conn->prepare($requestorIDsql);
			$requestorIDStatement->execute(['requestorID' => $pulloutDetailsrequestorID]);
			
			if($requestorIDStatement->rowCount() < 1){
				// requestor id is wrong
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Requestor ID does not exist in DB. Please enter a valid requestor ID.</div>';
				exit();
			} else {
				$row = $requestorIDStatement->fetch(PDO::FETCH_ASSOC);
				$requestorID = $row['requestorID'];
				$pulloutDetailsrequestorName = $row['fullName'];
				$pulloutDetailsrequestorDepartment = $row['department'];
				$pulloutDetailsrequestorPosition = $row['position'];


			}
			
			if($originalpulloutQuantityStatement->rowCount() > 0){
				
				// pullout details exist in DB. Hence proceed to calculate the stock
				$originalQtyRow = $originalpulloutQuantityStatement->fetch(PDO::FETCH_ASSOC);
				$quantityInOriginalOrder = $originalQtyRow['quantity'];
				$originalOrderItemNumber = $originalQtyRow['itemNumber'];

				// Check if the user wants to update the itemNumber too. In that case,
				// we need to remove the quantity of the original order for that item and 
				// update the new item details in the item table.
				// Check if the original itemNumber is the same as the new itemNumber
				if($originalOrderItemNumber !== $pulloutDetailsItemNumber) {
					// Item numbers are different. That means the user wants to update a new item number too
					// in that case, need to update both items' stocks.
						
					// Get the stock of the new item from item table
					$newItemCurrentStockSql = 'SELECT * FROM item WHERE itemNumber = :itemNumber';
					$newItemCurrentStockStatement = $conn->prepare($newItemCurrentStockSql);
					$newItemCurrentStockStatement->execute(['itemNumber' => $pulloutDetailsItemNumber]);
					
					if($newItemCurrentStockStatement->rowCount() < 1){
						// Item number is not in DB. Hence abort.
						echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Item Number does not exist in DB. If you want to update this item, please add it to DB first.</div>';
						exit();
					}
					
					// Calculate the new stock value for new item using the existing stock in item table
					$newItemRow = $newItemCurrentStockStatement->fetch(PDO::FETCH_ASSOC);
					$originalQuantityForNewItem = $newItemRow['stock'];
					$enteredQuantityForNewItem = $pulloutDetailsQuantity;
					$newItemNewStock = $originalQuantityForNewItem - $enteredQuantityForNewItem;
					
					// UPDATE the stock for new item in item table
					$newItemStockUpdateSql = 'UPDATE item SET stock = :stock WHERE itemNumber = :itemNumber';
					$newItemStockUpdateStatement = $conn->prepare($newItemStockUpdateSql);
					$newItemStockUpdateStatement->execute(['stock' => $newItemNewStock, 'itemNumber' => $pulloutDetailsItemNumber]);
					
					// Get the current stock of the previous item
					$previousItemCurrentStockSql = 'SELECT * FROM item WHERE itemNumber=:itemNumber';
					$previousItemCurrentStockStatement = $conn->prepare($previousItemCurrentStockSql);
					$previousItemCurrentStockStatement->execute(['itemNumber' => $originalOrderItemNumber]);
					
					// Calculate the new stock value for the previous item using the existing stock in item table
					$previousItemRow = $previousItemCurrentStockStatement->fetch(PDO::FETCH_ASSOC);
					$currentQuantityForPreviousItem = $previousItemRow['stock'];
					$previousItemNewStock = $currentQuantityForPreviousItem + $quantityInOriginalOrder;
					
					// UPDATE the stock for previous item in item table
					$previousItemStockUpdateSql = 'UPDATE item SET stock = :stock WHERE itemNumber = :itemNumber';
					$previousItemStockUpdateStatement = $conn->prepare($previousItemStockUpdateSql);
					$previousItemStockUpdateStatement->execute(['stock' => $previousItemNewStock, 'itemNumber' => $originalOrderItemNumber]);
					
					// Finally UPDATE the pullout table for new item
					$updatepulloutDetailsSql = 'UPDATE pullout SET itemNumber = :itemNumber, requestorID = :requestorID, requestorName = :requestorName, requestorDepartment = :requestorDepartment, requestorPosition = :requestorPosition, categoryName = :categoryName, itemName = :itemName, pulloutDate = :pulloutDate,  description = :description, quantity = :quantity WHERE pulloutID = :pulloutID';
					$updatepulloutDetailsStatement = $conn->prepare($updatepulloutDetailsSql);
					$updatepulloutDetailsStatement->execute(['itemNumber' => $pulloutDetailsItemNumber, 'requestorID' => $requestorID, 'requestorName' => $pulloutDetailsrequestorName, 'requestorDepartment' => $pulloutDetailsrequestorDepartment, 'requestorPosition' => $pulloutDetailsrequestorPosition, 'categoryName' => $pulloutDetailscategoryName, 'itemName' => $pulloutDetailsItemName, 'pulloutDate' => $pulloutDetailspulloutDate, 'description' => $pulloutDetailsdescription, 'quantity' => $pulloutDetailsQuantity, 'pulloutID' => $pulloutDetailspulloutID]);
					
					echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Pullout details updated.</div>';
					exit();
					
				} else {
					// Item numbers are equal. That means item number is valid
					
					// Get the quantity (stock) in item table
					$stockSql = 'SELECT * FROM item WHERE itemNumber=:itemNumber';
					$stockStatement = $conn->prepare($stockSql);
					$stockStatement->execute(['itemNumber' => $pulloutDetailsItemNumber]);
					
					if($stockStatement->rowCount() > 0){
						// Item exists in the item table, therefore, start updating data in pullout table
						
						// Calculate the new stock value using the existing stock in item table
						$row = $stockStatement->fetch(PDO::FETCH_ASSOC);
						$quantityInNewOrder = $pulloutDetailsQuantity;
						$originalStockInItemTable = $row['stock'];
						$newStock = $originalStockInItemTable - ($quantityInNewOrder - $quantityInOriginalOrder);
						
						// Update the new stock value in item table.
						$updateStockSql = 'UPDATE item SET stock = :stock WHERE itemNumber = :itemNumber';
						$updateStockStatement = $conn->prepare($updateStockSql);
						$updateStockStatement->execute(['stock' => $newStock, 'itemNumber' => $pulloutDetailsItemNumber]);
						
						// Next, update the pullout table
						$updatepulloutDetailsSql = 'UPDATE pullout SET itemNumber = :itemNumber, requestorID = :requestorID, requestorName = :requestorName, requestorDepartment = :requestorDepartment, categoryName = :categoryName, itemName = :itemName, pulloutDate = :pulloutDate,  description = :description, quantity = :quantity WHERE pulloutID = :pulloutID';
						$updatepulloutDetailsStatement = $conn->prepare($updatepulloutDetailsSql);
						$updatepulloutDetailsStatement->execute(['itemNumber' => $pulloutDetailsItemNumber, 'requestorID' => $requestorID, 'requestorName' => $pulloutDetailsrequestorName, 'requestorDepartment' => $pulloutDetailsrequestorDepartment, 'categoryName' => $pulloutDetailscategoryName, 'itemName' => $pulloutDetailsItemName, 'pulloutDate' => $pulloutDetailspulloutDate, 'description' => $pulloutDetailsdescription, 'quantity' => $pulloutDetailsQuantity, 'pulloutID' => $pulloutDetailspulloutID]);
							
						echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Pullout details updated.</div>';
						exit();
						
					} else {
						// Item does not exist in item table, therefore, you can't update 
						// pullout details for it 
						echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Item does not exist in DB. Therefore, first enter this item to DB using the <strong>Item</strong> tab.</div>';
						exit();
					}	
					
				}
	
			} else {
				
				// pulloutID does not exist in return table, therefore, you can't update it 
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Pullout details does not exist in DB for the given pullout ID. Therefore, can\'t update.</div>';
				exit();
				
			}

		} else {
			// One or more mandatory fields are empty. Therefore, display the error message
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
			exit();
		}
	}
