<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	$qty = 0;
	
	$returnDetailsSearchSql = 'SELECT * FROM returnitem';
	$returnDetailsSearchStatement = $conn->prepare($returnDetailsSearchSql);
	$returnDetailsSearchStatement->execute();

	$output = '<table id="returnReportsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
				<thead>
					<tr>
						<th style="text-align:center">Return ID</th>
						<th style="text-align:center">Item Number<br> (or Serial Number)</th>
						<th style="text-align:center">Return Date</th>
						<th style="text-align:center">Issued To</th>
						<th style="text-align:center">Department</th>
						<th style="text-align:center">Position</th>
						<th style="text-align:center">Item <br>Category</th>
						<th style="text-align:center">Item<br> Name</th>
						<th style="text-align:center">Description</th>
						<th style="text-align:center">Returned Quantity</th>
					</tr>
				</thead>
				<tbody>';
	
	// Create table rows from the selected data
	while($row = $returnDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)){
		$qty = $row['quantity'];
		
		$output .= '<tr>' .
							'<td>' . $row['returnID'] . '</td>' .
							'<td>' . $row['itemNumber'] . '</td>' .
							'<td>' . $row['returnDate'] . '</td>' .
							'<td>' . $row['requestorName'] . '</td>' .
							'<td>' . $row['requestorDepartment'] . '</td>' .
							'<td>' . $row['requestorPosition'] . '</td>' .
							'<td>' . $row['categoryName'] . '</td>' .
							'<td>' . $row['itemName'] . '</td>' .
							'<td>' . $row['description'] . '</td>' .
							'<td>' . $row['quantity'] . '</td>' .
					'</tr>';
	}
	
	$returnDetailsSearchStatement->closeCursor();
	
	$output .= '</tbody>
					<tfoot>
						<tr>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
					</tfoot>
				</table>';
	echo $output;
?>


