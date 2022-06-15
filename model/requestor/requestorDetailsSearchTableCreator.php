<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	$requestorDetailsSearchSql = 'SELECT * FROM requestor';
	$requestorDetailsSearchStatement = $conn->prepare($requestorDetailsSearchSql);
	$requestorDetailsSearchStatement->execute();

	$output = '<table id="requestorDetailsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
				<thead>
					<tr>
						<th style="text-align:center">Requestor ID</th>
						<th style="text-align:center">Full Name</th>
						<th style="text-align:center">Department</th>
						<th style="text-align:center">Position</th>
						<th style="text-align:center">Email</th>
						<th style="text-align:center">Mobile</th>
						<th style="text-align:center">Address</th>
						<th style="text-align:center">Status</th>
					</tr>
				</thead>
				<tbody>';
	
	// Create table rows from the selected data
	while($row = $requestorDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)){
		$output .= '<tr>' .
						'<td>' . $row['requestorID'] . '</td>' .
						'<td>' . $row['fullName'] . '</td>' .
						'<td>' . $row['department'] . '</td>' .
						'<td>' . $row['position'] . '</td>' .
						'<td>' . $row['email'] . '</td>' .
						'<td>' . $row['mobile'] . '</td>' .
						'<td>' . $row['address'] . '</td>' .
						'<td>' . $row['status'] . '</td>' .
					'</tr>';
	}
	
	$requestorDetailsSearchStatement->closeCursor();
	
	$output .= '</tbody>
					<tfoot>
						<tr>
							<th style="text-align:center"></th>
							<th style="text-align:center"></th>
							<th style="text-align:center"></th>
							<th style="text-align:center"></th>
							<th style="text-align:center"></th>
							<th style="text-align:center"></th>
							<th style="text-align:center"></th>
							<th style="text-align:center"></th>
						</tr>
					</tfoot>
				</table>';
	echo $output;
