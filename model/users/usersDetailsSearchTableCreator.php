<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');

$usersDetailsSearchSql = 'SELECT * FROM users';
$usersDetailsSearchStatement = $conn->prepare($usersDetailsSearchSql);
$usersDetailsSearchStatement->execute();

$output = '<table id="usersDetailsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
				<thead>
					<tr>
					<th style="text-align:center">Users ID</th>
					<th style="text-align:center"> Name</th>
					<th style="text-align:center">Email</th>
					<th style="text-align:center">User Role</th>
				</tr>
				</thead>
				<tbody>';

// Create table rows from the selected data
while ($row = $usersDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)) {
	$output .= '<tr>' .
		'<td>' . $row['id'] . '</td>' .
		'<td>' . $row['name'] . '</td>' .
		'<td>' . $row['email'] . '</td>' .
		'<td>' . $row['user_type'] . '</td>' .
		'</tr>';
}

$usersDetailsSearchStatement->closeCursor();

$output .= '</tbody>
					<tfoot>
						<tr>
							<th style="text-align:center"></th>
							<th style="text-align:center"></th>
							<th style="text-align:center"></th>
							<th style="text-align:center"></th>
						</tr>
					</tfoot>
				</table>';
echo $output;
