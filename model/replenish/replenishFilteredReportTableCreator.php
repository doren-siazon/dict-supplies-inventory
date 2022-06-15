<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');

$uPrice = 0;
$qty = 0;
$totalPrice = 0;

if (isset($_POST['startDate'])) {
	$startDate = htmlentities($_POST['startDate']);
	$endDate = htmlentities($_POST['endDate']);

	$replenishFilteredReportSql = 'SELECT * FROM replenishitem WHERE replenishDate BETWEEN :startDate AND :endDate';
	$replenishFilteredReportStatement = $conn->prepare($replenishFilteredReportSql);
	$replenishFilteredReportStatement->execute(['startDate' => $startDate, 'endDate' => $endDate]);

	$output = '<table id="replenishFilteredReportsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
					<thead>
						<tr>
							<th style="text-align:center">Replenish ID</th>
							<th style="text-align:center">Item Number <br> (or Serial Number)</th>
							<th style="text-align:center">Replenish Date</th>
							<th style="text-align:center">Item Category</th>
							<th style="text-align:center">Item Name</th>
							<th style="text-align:center">Description</th>
							<th style="text-align:center">Replenish Quantity</th>
						</tr>
					</thead>
					<tbody>';

	// Create table rows from the selected data
	while ($row = $replenishFilteredReportStatement->fetch(PDO::FETCH_ASSOC)) {
		$qty = $row['quantity'];

		$output .= '<tr>' .
					'<td>' . $row['replenishID'] . '</td>' .
					'<td>' . $row['itemNumber'] . '</td>' .
					'<td>' . $row['replenishDate'] . '</td>' .
					'<td>' . $row['categoryName'] . '</td>' .
					'<td>' . $row['itemName'] . '</td>' .
					'<td>' . $row['description'] . '</td>' .
					'<td>' . $row['quantity'] . '</td>' .
					'</tr>';
	}

	$replenishFilteredReportStatement->closeCursor();

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
}
