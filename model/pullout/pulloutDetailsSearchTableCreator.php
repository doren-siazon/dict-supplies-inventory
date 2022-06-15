<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	$uPrice = 0;
	$qty = 0;
	$totalPrice = 0;
	
	$pulloutDetailsSearchSql = 'SELECT * FROM pullout';
	$pulloutDetailsSearchStatement = $conn->prepare($pulloutDetailsSearchSql);
	$pulloutDetailsSearchStatement->execute();

	$output = '<table id="pulloutDetailsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
				<thead>
					<tr>
						<th style="text-align:center">Pullout ID</th>
						<th style="text-align:center">Item Number <b>(or Serial Number)</th>
						<th style="text-align:center">Requestor Name</th>
						<th style="text-align:center">Department</th>
						<th style="text-align:center">Category Name</th>
						<th style="text-align:center">Item Name</th>
						<th style="text-align:center">Pullout Date</th>
						<th style="text-align:center">Description</th>
						<th style="text-align:center">Quantity</th>
					</tr>
				</thead>
				<tbody>';
	
	// Create table rows from the selected data
	while($row = $pulloutDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)){
		$qty = $row['quantity'];
			
		$output .= '<tr>' .
						'<td>' . $row['pulloutID'] . '</td>' .
						'<td>' . $row['itemNumber'] . '</td>' .
						'<td>' . $row['requestorName'] . '</td>' .
						'<td>' . $row['requestorDepartment'] . '</td>' .
						'<td>' . $row['categoryName'] . '</td>' .
						'<td>' . $row['itemName'] . '</td>' .
						'<td>' . $row['pulloutDate'] . '</td>' .
						'<td>' . $row['description'] . '</td>' .
						'<td>' . $row['quantity'] . '</td>' .
					'</tr>';
	}
	
	$pulloutDetailsSearchStatement->closeCursor();
	
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
						</tr>
					</tfoot>
				</table>';
	echo $output;
