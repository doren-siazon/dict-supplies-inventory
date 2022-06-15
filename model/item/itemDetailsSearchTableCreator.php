<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	$itemDetailsSearchSql = 'SELECT * FROM item';
	$itemDetailsSearchStatement = $conn->prepare($itemDetailsSearchSql);
	$itemDetailsSearchStatement->execute();
	
	$output = '<table id="itemDetailsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
				<thead>
					<tr>
						<th style="text-align:center" style="text-align:center">Product ID</th>
						<th style="text-align:center" style="text-align:center">Item Number <br> (or Serial Number)</th>
						<th style="text-align:center" style="text-align:center">Category</th>
						<th style="text-align:center" style="text-align:center">Item Name</th>
						<th style="text-align:center" style="text-align:center">Stock</th>
						<th style="text-align:center" style="text-align:center">Status</th>
						<th style="text-align:center" style="text-align:center">Description</th>
					</tr>
				</thead>
				<tbody>';
	
	// Create table rows from the selected data
	while($row = $itemDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)){
		
		$output .= '<tr>' .
						'<td>' . $row['productID'] . '</td>' .
						'<td>' . $row['itemNumber'] . '</td>' .
						'<td>' . $row['categoryName'] . '</td>' .
						'<td>' . $row['itemName'] . '</td>' .
						'<td>' . $row['stock'] . '</td>' .
						'<td>' . $row['status'] . '</td>' .
						'<td>' . $row['description'] . '</td>' .
					'</tr>';
	}
	
	$itemDetailsSearchStatement->closeCursor();
	
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
						</tr>
					</tfoot>
				</table>';
	echo $output;
?>