<?php
session_start();
// Redirect the user to login page if he is not logged in.
$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
	header('location:index.php');
}

require_once('inc/config/constants.php');
require_once('inc/config/db.php');
require_once('inc/header.html');



if (isset($_POST['submit'])) {

	$name = $_POST['name'];
	$name = filter_var($name, FILTER_SANITIZE_STRING);
	$email = $_POST['email'];
	$email = filter_var($email, FILTER_SANITIZE_STRING);
	$user_type = $_POST['user_type'];
	$user_type = filter_var($user_type, FILTER_SANITIZE_STRING);
	$pass = md5($_POST['pass']);
	$pass = filter_var($pass, FILTER_SANITIZE_STRING);
	$cpass = md5($_POST['cpass']);
	$cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

	$image = $_FILES['image']['name'];
	$image_tmp_name = $_FILES['image']['tmp_name'];
	$image_size = $_FILES['image']['size'];
	$image_folder = 'uploaded_img/' . $image;

	$select = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
	$select->execute([$email]);

	if ($select->rowCount() > 0) {
		$message[] = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button> &nbsp User Already Exist!</div>';
	} else {
		if ($pass != $cpass) {
			$message[] = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button> &nbsp Password not matched!</div>';
		} elseif ($image_size > 2000000) {
			$message[] = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button> &nbsp Image size is too larged!</div>';
		} else {
			$insert = $conn->prepare("INSERT INTO `users`(name, email, user_type, password, image) VALUES(?,?,?,?,?)");
			$insert->execute([$name, $email, $user_type, $cpass, $image]);
			if ($insert) {
				move_uploaded_file($image_tmp_name, $image_folder);
				$message[] = '<div class="alert alert-primary"><button type="button" class="close" data-dismiss="alert">&times;</button> &nbsp Registered Sucessfully!</div>';
			}
		}
	}
}
?>



<link rel="stylesheet" href="assets/css/image.css">

<body>
	<?php
	require 'inc/navigation-admin.php';
	?>
	<!-- Page Content -->
	<div class="container-fluid">



		<div class="row">
			<div class="col-lg-2">
				<h1 class="my-4"></h1>
				<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
					<a class="nav-link" id="v-pills-search-tab" data-toggle="pill" href="#v-pills-search" role="tab" aria-controls="v-pills-search" aria-selected="false">Search</a>
					<a class="nav-link active" id="v-pills-item-tab" data-toggle="pill" href="#v-pills-item" role="tab" aria-controls="v-pills-item" aria-selected="true">Inventory</a>
					<a class="nav-link" id="v-pills-requestor-tab" data-toggle="pill" href="#v-pills-requestor" role="tab" aria-controls="v-pills-requestor" aria-selected="false">Requestor</a>
					<a class="nav-link" id="v-pills-reports-tab" data-toggle="pill" href="#v-pills-reports" role="tab" aria-controls="v-pills-reports" aria-selected="false">Reports</a>

				</div>
			</div>
			<div class="col-lg-10">
				<div class="tab-content" id="v-pills-tabContent">


					<div class="tab-pane fade show active" id="v-pills-item" role="tabpanel" aria-labelledby="v-pills-item-tab">
						<div class="card card-outline-secondary my-4">
							<div class="card-header">Inventory Details</div>
							<div class="card-body">
								<ul class="nav nav-tabs" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" data-toggle="tab" href="#itemDetailsTab">Add New Item</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#replenishTab">Replenish Item</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#returnTab">Return Item</a>
									</li>
								</ul>

								<!-- Tab panes for item details and image sections -->
								<div class="tab-content">


									<div id="itemDetailsTab" class="container-fluid tab-pane active">
										<br>
										<div id="itemDetailsMessage"></div>
										<form>
											<div class="form-row">
												<div class="form-group col-md-3" style="display:inline-block">
													<label for="itemDetailsItemNumber">Item Number (or Serial Number)<span class="requiredIcon">*</span></label>
													<input type="text" class="form-control" name="itemDetailsItemNumber" id="itemDetailsItemNumber" autocomplete="off">
													<div id="itemDetailsItemNumberSuggestionsDiv" class="customListDivWidth"></div>
												</div>
												<div class="form-group col-md-3">
													<label for="itemDetailsProductID">Product ID</label>
													<input class="form-control invTooltip" type="number" readonly id="itemDetailsProductID" name="itemDetailsProductID" title="This will be auto-generated when you add a new item">
												</div>
												<div class="form-group col-md-2">
													<label for="itemDetailsStatus">Status</label>
													<select id="itemDetailsStatus" name="itemDetailsStatus" class="form-control chosenSelect">
														<?php include('inc/statusList.html'); ?>
													</select>
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-5">
													<label for="itemDetailscategoryName"> Item Category<span class="requiredIcon">*</span></label>
													<input type="text" class="form-control" name="itemDetailscategoryName" id="itemDetailscategoryName" autocomplete="off">
													<div id="itemDetailscategoryNameSuggestionsDiv" class="customListDivWidth"></div>
												</div>

												<div class="form-group col-md-5">
													<label for="itemDetailsItemName">Item Name<span class="requiredIcon">*</span></label>
													<input type="text" class="form-control" name="itemDetailsItemName" id="itemDetailsItemName" autocomplete="off">
													<div id="itemDetailsItemNameSuggestionsDiv" class="customListDivWidth"></div>
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-6" style="display:inline-block">
													<!-- <label for="itemDetailsDescription">Description</label> -->
													<textarea rows="4" class="form-control" placeholder="Description" name="itemDetailsDescription" id="itemDetailsDescription"></textarea>
												</div>

											</div>
											<div class="form-row">
												<div class="form-group col-md-3">
													<label for="itemDetailsQuantity">Quantity<span class="requiredIcon">*</span></label>
													<input type="number" class="form-control" value="0" name="itemDetailsQuantity" id="itemDetailsQuantity">
												</div>
												<div class="form-group col-md-3">
													<label for="itemDetailsTotalStock">Total Stock</label>
													<input type="text" class="form-control" name="itemDetailsTotalStock" id="itemDetailsTotalStock" readonly>
												</div>
											</div>
											<button type="button" id="addItem" class="btn btn-success">Add Item</button>
											<button type="button" id="updateItemDetailsButton" class="btn btn-primary">Update</button>
											<button type="button" id="deleteItem" class="btn btn-danger">Delete</button>
											<button type="reset" class="btn" id="itemClear">Clear</button>
										</form>
									</div>


									<div id="replenishTab" class="container-fluid tab-pane fade">
										<br>
										<div id="replenishDetailsMessage"></div>
										<form>
											<div class="form-row">
												<div class="form-group col-md-3">
													<label for="replenishDetailsItemNumber">Item Number (or Serial Number)<span class="requiredIcon">*</span></label>
													<input type="text" class="form-control" id="replenishDetailsItemNumber" name="replenishDetailsItemNumber" autocomplete="off">
													<div id="replenishDetailsItemNumberSuggestionsDiv" class="customListDivWidth"></div>
												</div>
												<div class="form-group col-md-3">
													<label for="replenishDetailsreplenishDate">Replenish Date<span class="requiredIcon">*</span></label>
													<input type="date" class="form-control datepicker" id="replenishDetailsreplenishDate" name="replenishDetailsreplenishDate" value="">
												</div>
												<div class="form-group col-md-2">
													<label for="replenishDetailsreplenishID">Replenish ID</label>
													<input type="text" class="form-control invTooltip" id="replenishDetailsreplenishID" name="replenishDetailsreplenishID" title="This will be auto-generated when you add a new record" autocomplete="off" readonly>
													<div id="replenishDetailsreplenishIDSuggestionsDiv" class="customListDivWidth"></div>
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-4">
													<label for="replenishDetailscategoryName">Category Name<span class="requiredIcon">*</span></label>
													<input type="text" class="form-control invTooltip" id="replenishDetailscategoryName" name="replenishDetailscategoryName" readonly title="This will be auto-filled when you enter the item number above">
												</div>
												<div class="form-group col-md-4">
													<label for="replenishDetailsItemName">Item Name<span class="requiredIcon">*</span></label>
													<input type="text" class="form-control invTooltip" id="replenishDetailsItemName" name="replenishDetailsItemName" readonly title="This will be auto-filled when you enter the item number above">
												</div>

											</div>
											<div class="form-row">
												<div class="form-group col-md-6" style="display:inline-block">
													<!-- <label for="itemDetailsDescription">Description</label> -->
													<textarea rows="4" class="form-control" placeholder="Description" name="replenishDetailsDescription" id="replenishDetailsDescription"></textarea>
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-2">
													<label for="replenishDetailsCurrentStock">Current Stock</label>
													<input type="text" class="form-control" id="replenishDetailsCurrentStock" name="replenishDetailsCurrentStock" readonly>
												</div>
												<div class="form-group col-md-2">
													<label for="replenishDetailsQuantity">Replenish Quantity<span class="requiredIcon">*</span></label>
													<input type="number" class="form-control" id="replenishDetailsQuantity" name="replenishDetailsQuantity" value="0">
												</div>
											</div>
											<button type="button" id="addreplenish" class="btn btn-success">Add Replenish</button>
											<!-- <button type="button" id="updatereplenishDetailsButton" class="btn btn-primary">Update</button> -->
											<button type="reset" class="btn">Clear</button>
										</form>
									</div>


									<div id="returnTab" class="container-fluid tab-pane fade">
										<br>
										<div id="returnDetailsMessage"></div>
										<form>
											<div class="form-row">
												<div class="form-group col-md-3">
													<label for="returnDetailsItemNumber">Item Number (or Serial Number)<span class="requiredIcon">*</span></label>
													<input type="text" class="form-control" id="returnDetailsItemNumber" name="returnDetailsItemNumber" autocomplete="off">
													<div id="returnDetailsItemNumberSuggestionsDiv" class="customListDivWidth"></div>
												</div>
												<div class="form-group col-md-3">
													<label for="returnDetailsrequestorID">Employee ID<span class="requiredIcon">*</span></label>
													<input type="text" class="form-control" id="returnDetailsrequestorID" name="returnDetailsrequestorID" autocomplete="off">
													<div id="returnDetailsrequestorIDSuggestionsDiv" class="customListDivWidth"></div>
												</div>
												<div class="form-group col-md-3">
													<label for="returnDetailsreturnDate">Return Date<span class="requiredIcon">*</span></label>
													<input type="date" class="form-control datepicker" id="returnDetailsreturnDate" name="returnDetailsreturnDate">
												</div>
												<div class="form-group col-md-2">
													<label for="returnDetailsreturnID">Return ID</label>
													<input type="text" class="form-control invTooltip" id="returnDetailsreturnID" name="returnDetailsreturnID" title="This will be auto-generated when you add a new record" readonly autocomplete="off">
													<div id="returnDetailsreturnIDSuggestionsDiv" class="customListDivWidth"></div>
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-4">
													<label for="returnDetailscategoryName">Category Name<span class="requiredIcon">*</span></label>
													<input type="text" class="form-control invTooltip" id="returnDetailscategoryName" name="returnDetailscategoryName" readonly title="This will be auto-filled when you enter the item number above">
												</div>
												<div class="form-group col-md-4">
													<label for="returnDetailsItemName">Item Name<span class="requiredIcon">*</span></label>
													<input type="text" class="form-control invTooltip" id="returnDetailsItemName" name="returnDetailsItemName" readonly title="This will be auto-filled when you enter the item number above">
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-4">
													<label for="returnDetailsrequestorName">Employee Name</label>
													<input type="text" class="form-control" id="returnDetailsrequestorName" name="returnDetailsrequestorName" readonly>
												</div>
												<div class="form-group col-md-4">
													<label for="returnDetailsrequestorDepartment">Department</label>
													<input type="text" class="form-control" id="returnDetailsrequestorDepartment" name="returnDetailsrequestorDepartment" readonly>
												</div>
												<div class="form-group col-md-4">
													<label for="returnDetailsrequestorPosition">Position</label>
													<input type="text" class="form-control" id="returnDetailsrequestorPosition" name="returnDetailsrequestorPosition" readonly>
												</div>
											</div>

											<div class="form-row">
												<div class="form-group col-md-6" style="display:inline-block">
													<!-- <label for="itemDetailsDescription">Description</label> -->
													<textarea rows="4" class="form-control" placeholder="Description" name="returnDetailsDescription" id="returnDetailsDescription"></textarea>
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-2">
													<label for="returnDetailsCurrentStock">Current Stock</label>
													<input type="text" class="form-control" id="returnDetailsCurrentStock" name="returnDetailsCurrentStock" readonly>
												</div>
												<div class="form-group col-md-2">
													<label for="returnDetailsQuantity">Return Quantity<span class="requiredIcon">*</span></label>
													<input type="number" class="form-control" id="returnDetailsQuantity" name="returnDetailsQuantity" value="0">
												</div>
											</div>
											<button type="button" id="addreturn" class="btn btn-success">Add Return</button>
											<!-- <button type="button" id="updatereturnDetailsButton" class="btn btn-primary">Update</button> -->
											<button type="reset" class="btn">Clear</button>
										</form>

										<br>
									</div>
								</div>

							</div>
						</div>
					</div>

					<div class="tab-pane fade" id="v-pills-requestor" role="tabpanel" aria-labelledby="v-pills-requestor-tab">
						<div class="card card-outline-secondary my-4">
							<div class="card-header">Requestor Details</div>
							<div class="card-body">
								<ul class="nav nav-tabs" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" data-toggle="tab" href="#pulloutDetailsTab">Requestor</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#requestorDetailsTab">Add Requestor</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#v-pills-search-list">Requestor List</a>
									</li>
								</ul>
								<br>

								<div class="tab-content">

									<div id="pulloutDetailsTab" class="container-fluid tab-pane active">
										<div id="pulloutDetailsMessage"></div>
										<form>
											<div class="form-row">
												<div class="form-group col-md-2">
													<label for="pulloutDetailspulloutID">Pullout ID</label>
													<input type="text" class="form-control invTooltip" id="pulloutDetailspulloutID" name="pulloutDetailspulloutID" title="This will be auto-generated when you add a new record" readonly autocomplete="off">
													<div id="pulloutDetailspulloutIDSuggestionsDiv" class="customListDivWidth"></div>
												</div>
												<div class="form-group col-md-3">
													<label for="pulloutDetailspulloutDate">Pullout Date<span class="requiredIcon">*</span></label>
													<input type="date" class="form-control datepicker" id="pulloutDetailspulloutDate" value="" name="pulloutDetailspulloutDate">
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-3">
													<label for="pulloutDetailsItemNumber">Item Number (or Serial Number)<span class="requiredIcon">*</span></label>
													<input type="text" class="form-control" id="pulloutDetailsItemNumber" name="pulloutDetailsItemNumber" autocomplete="off">
													<div id="pulloutDetailsItemNumberSuggestionsDiv" class="customListDivWidth"></div>
												</div>
												<div class="form-group col-md-4">
													<label for="pulloutDetailscategoryName">Category Name<span class="requiredIcon">*</span></label>
													<input type="text" class="form-control invTooltip" id="pulloutDetailscategoryName" name="pulloutDetailscategoryName" readonly title="This will be auto-filled when you enter the item number above">
												</div>
												<div class="form-group col-md-4">
													<label for="pulloutDetailsItemName">Item Name<span class="requiredIcon">*</span></label>
													<input type="text" class="form-control invTooltip" id="pulloutDetailsItemName" name="pulloutDetailsItemName" readonly title="This will be auto-filled when you enter the item number above">
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-3">
													<label for="pulloutDetailsrequestorID">Employee ID<span class="requiredIcon">*</span></label>
													<input type="text" class="form-control" id="pulloutDetailsrequestorID" name="pulloutDetailsrequestorID" autocomplete="off">
													<div id="pulloutDetailsrequestorIDSuggestionsDiv" class="customListDivWidth"></div>
												</div>
												<div class="form-group col-md-4">
													<label for="pulloutDetailsrequestorName">Requestor Name</label>
													<input type="text" class="form-control" id="pulloutDetailsrequestorName" name="pulloutDetailsrequestorName" readonly>
												</div>
												<div class="form-group col-md-4">
													<label for="pulloutDetailsrequestorDepartment">Department</label>
													<input type="text" class="form-control" id="pulloutDetailsrequestorDepartment" name="pulloutDetailsrequestorDepartment" readonly>
												</div>

											</div>
											<div class="form-row">

												<div class="form-group col-md-6" style="display:inline-block">
													<textarea rows="4" class="form-control" placeholder="Description" name="pulloutDetailsdescription" id="pulloutDetailsdescription"></textarea>
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-2">
													<label for="pulloutDetailsTotalStock">Total Stock</label>
													<input type="text" class="form-control" name="pulloutDetailsTotalStock" id="pulloutDetailsTotalStock" readonly>
												</div>
												<div class="form-group col-md-2">
													<label for="pulloutDetailsQuantity">Quantity<span class="requiredIcon">*</span></label>
													<input type="number" class="form-control" id="pulloutDetailsQuantity" name="pulloutDetailsQuantity" value="0">
												</div>
											</div>

											<button type="button" id="addpulloutButton" class="btn btn-success">Save</button>
											<button type="reset" id="pulloutClear" class="btn">Clear</button>
										</form>
									</div>


									<div id="requestorDetailsTab" class="container-fluid tab-pane">
										<div id="requestorDetailsMessage"></div>

										<form>
											<div class="form-row">
												<div class="form-group col-md-2">
													<label for="requestorDetailsrequestorID">Employee ID </label>
													<input type="text" class="form-control invTooltip" id="requestorDetailsrequestorID" name="requestorDetailsrequestorID" autocomplete="off">
													<div id="requestorDetailsrequestorIDSuggestionsDiv" class="customListDivWidth"></div>
												</div>
												<div class="form-group col-md-3">
													<label for="requestorDetailsStatus">Status</label>
													<select id="requestorDetailsStatus" name="requestorDetailsStatus" class="form-control chosenSelect">
														<?php include('inc/statusList.html'); ?>
													</select>
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-6">
													<label for="requestorDetailsrequestorFullName">Full Name (Last Name, First Name, M.I.)<span class="requiredIcon">*</span></label>
													<input type="text" class="form-control" id="requestorDetailsrequestorFullName" name="requestorDetailsrequestorFullName">
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-6">
													<label for="requestorDetailsrequestordepartment">Department<span class="requiredIcon">*</span></label>
													<input type="text" class="form-control" id="requestorDetailsrequestordepartment" name="requestorDetailsrequestordepartment">
												</div>
												<div class="form-group col-md-4">
													<label for="requestorDetailsrequestorposition">Position<span class="requiredIcon">*</span></label>
													<input type="text" class="form-control" id="requestorDetailsrequestorposition" name="requestorDetailsrequestorposition">
												</div>

											</div>
											<div class="form-row">
												<div class="form-group col-md-3">
													<label for="requestorDetailsrequestorMobile">Phone (mobile)<span class="requiredIcon">*</span></label>
													<input type="text" class="form-control invTooltip" id="requestorDetailsrequestorMobile" name="requestorDetailsrequestorMobile" title="Do not enter leading 0">
												</div>
												<div class="form-group col-md-6">
													<label for="requestorDetailsrequestorEmail">Email</label>
													<input type="email" class="form-control" id="requestorDetailsrequestorEmail" name="requestorDetailsrequestorEmail">
												</div>
											</div>
											<div class="form-group">
												<label for="requestorDetailsrequestorAddress">Address (Street Address, City, Province)<span class="requiredIcon">*</span></label>
												<input type="text" class="form-control" id="requestorDetailsrequestorAddress" name="requestorDetailsrequestorAddress">
											</div>

											<button type="button" id="addrequestor" name="addrequestor" class="btn btn-success">Add Employee</button>
											<button type="button" id="updaterequestorDetailsButton" class="btn btn-primary">Update</button>
											<button type="button" id="deleterequestorButton" class="btn btn-danger">Delete</button>
											<a class="nav-link" data-toggle="tab" href="#v-pills-search-list" hidden>Employee List</a>

											<button type="reset" class="btn">Clear</button>
										</form>
									</div>

									<div id="v-pills-search-list" class="container-fluid tab-pane fade">
										<button id="reportsTablesRefresh" name="reportsTablesRefresh" class="btn btn-success float-left btn-sm">Refresh</button>
										<div class="card-body">
											<br>
											<div class="table-responsive" id="requestorDetailsTableDiv"></div>
										</div>
									</div>


								</div>
							</div>
						</div>
					</div>

					<div class="tab-pane fade" id="v-pills-reports" role="tabpanel" aria-labelledby="v-pills-reports-tab">
						<div class="card card-outline-secondary my-4">
							<div class="card-header"> Inventory Reports<button id="reportsTablesRefresh" name="reportsTablesRefresh" class="btn btn-warning float-right btn-sm">Refresh</button></div>
							<div class="card-body">
								<ul class="nav nav-tabs" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" data-toggle="tab" href="#itemReportsTab">Item</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#replenishReportsTab">Replenish Item</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#returnReportsTab">Return Item</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#pulloutReportsTab">Pullout Item</a>
									</li>
								</ul>

								<!-- Tab panes for reports sections -->
								<div class="tab-content">
									<div id="itemReportsTab" class="container-fluid tab-pane active">
										<br>
										<p>Use the grid below to get reports for items</p>
										<div class="table-responsive" id="itemReportsTableDiv"></div>
									</div>

									<div id="pulloutReportsTab" class="container-fluid tab-pane fade">
										<br>
										<!-- <p>Use the grid below to get reports for pullouts</p> -->
										<form>
											<div class="form-row">
												<div class="form-group col-md-3">
													<label for="pulloutReportStartDate">Start Date</label>
													<input type="text" class="form-control datepicker" id="pulloutReportStartDate" value="Date" name="pulloutReportStartDate" readonly>
												</div>
												<div class="form-group col-md-3">
													<label for="pulloutReportEndDate">End Date</label>
													<input type="text" class="form-control datepicker" id="pulloutReportEndDate" value="Date" name="pulloutReportEndDate" readonly>
												</div>
											</div>
											<button type="button" id="showpulloutReport" class="btn btn-dark">Show Report</button>
											<button type="reset" id="pulloutFilterClear" class="btn">Clear</button>
										</form>
										<br><br>
										<div class="table-responsive" id="pulloutReportsTableDiv"></div>
									</div>
									<div id="returnReportsTab" class="container-fluid tab-pane fade">
										<br>
										<!-- <p>Use the grid below to get reports for returns</p> -->
										<form>
											<div class="form-row">
												<div class="form-group col-md-3">
													<label for="returnReportStartDate">Start Date</label>
													<input type="text" class="form-control datepicker" id="returnReportStartDate" value="Date" name="returnReportStartDate" readonly>
												</div>
												<div class="form-group col-md-3">
													<label for="returnReportEndDate">End Date</label>
													<input type="text" class="form-control datepicker" id="returnReportEndDate" value="Date" name="returnReportEndDate" readonly>
												</div>
											</div>
											<button type="button" id="showreturnReport" class="btn btn-dark">Show Report</button>
											<button type="reset" id="returnFilterClear" class="btn">Clear</button>
										</form>
										<br><br>
										<div class="table-responsive" id="returnReportsTableDiv"></div>
									</div>
									<div id="replenishReportsTab" class="container-fluid tab-pane fade">
										<br>
										<!-- <p>Use the grid below to get reports for returns</p> -->
										<form>
											<div class="form-row">
												<div class="form-group col-md-3">
													<label for="replenishReportStartDate">Start Date</label>
													<input type="text" class="form-control datepicker" id="replenishReportStartDate" value="Date" name="replenishReportStartDate" readonly>
												</div>
												<div class="form-group col-md-3">
													<label for="replenishReportEndDate">End Date</label>
													<input type="text" class="form-control datepicker" id="replenishReportEndDate" value="Date" name="replenishReportEndDate" readonly>
												</div>
											</div>
											<button type="button" id="showreplenishReport" class="btn btn-dark">Show Report</button>
											<button type="reset" id="replenishFilterClear" class="btn">Clear</button>
										</form>
										<br><br>
										<div class="table-responsive" id="replenishReportsTableDiv"></div>
									</div>


									<div id="vendorReportsTab" class="container-fluid tab-pane fade">
										<br>
										<p>Use the grid below to get reports for vendors</p>
										<div class="table-responsive" id="vendorReportsTableDiv"></div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- SEARCH INVENTORY -->
					<div class="tab-pane fade" id="v-pills-search" role="tabpanel" aria-labelledby="v-pills-search-tab">
						<div class="card card-outline-secondary my-4">
							<div class="card-header">Search Inventory<button id="searchTablesRefresh" name="searchTablesRefresh" class="btn btn-warning float-right btn-sm">Refresh</button></div>
							<div class="card-body">
								<ul class="nav nav-tabs" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" data-toggle="tab" href="#itemSearchTab">Item</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#replenishSearchTab">Replenish Item</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#returnSearchTab">Return Item</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#pulloutSearchTab">Pullout Item</a>
									</li>
								</ul>

								<!-- Tab panes -->
								<div class="tab-content">
									<div id="itemSearchTab" class="container-fluid tab-pane active">
										<br>
										<p>Use the grid below to search all details of items</p>
										<!-- <a href="#" class="itemDetailsHover" data-toggle="popover" id="10">wwwee</a> -->
										<div class="table-responsive" id="itemDetailsTableDiv"></div>
									</div>
									<div id="replenishSearchTab" class="container-fluid tab-pane fade">
										<br>
										<p>Use the grid below to search replenish details</p>
										<div class="table-responsive" id="replenishDetailsTableDiv"></div>
									</div>
									<div id="returnSearchTab" class="container-fluid tab-pane fade">
										<br>
										<p>Use the grid below to search return details</p>
										<div class="table-responsive" id="returnDetailsTableDiv"></div>
									</div>
									<!-- <div id="requestorSearchTab" class="container-fluid tab-pane fade">
										<br>
										<p>Use the grid below to search all details of requestors</p>
										<div class="table-responsive" id="requestorDetailsTableDiv"></div>
									</div> -->
									<div id="pulloutSearchTab" class="container-fluid tab-pane fade">
										<br>
										<p>Use the grid below to search pullout details</p>
										<div class="table-responsive" id="pulloutDetailsTableDiv"></div>
									</div>
									<div id="vendorSearchTab" class="container-fluid tab-pane fade">
										<br>
										<p>Use the grid below to search vendor details</p>
										<div class="table-responsive" id="vendorDetailsTableDiv"></div>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>



			</div>
		</div>
	</div>
	<?php
	require 'inc/footer.php';
	?>


</body>

</html>