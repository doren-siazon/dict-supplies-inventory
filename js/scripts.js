// File that creates the return details search table
returnDetailsSearchTableCreatorFile = 'model/return/returnDetailsSearchTableCreator.php';

// File that creates the replenish details search table
replenishDetailsSearchTableCreatorFile = 'model/replenish/replenishDetailsSearchTableCreator.php';

// File that creates the requestor details search table
requestorDetailsSearchTableCreatorFile = 'model/requestor/requestorDetailsSearchTableCreator.php';

// USERS
// File that creates the users details search table
usersDetailsSearchTableCreatorFile = 'model/users/usersDetailsSearchTableCreator.php';


// File that creates the item details search table
itemDetailsSearchTableCreatorFile = 'model/item/itemDetailsSearchTableCreator.php';

// File that creates the pullout details search table
pulloutDetailsSearchTableCreatorFile = 'model/pullout/pulloutDetailsSearchTableCreator.php';



// File that creates the return reports search table
returnReportsSearchTableCreatorFile = 'model/return/returnReportsSearchTableCreator.php';

// File that creates the replenish reports search table
replenishReportsSearchTableCreatorFile = 'model/replenish/replenishReportsSearchTableCreator.php';

// File that creates the requestor reports search table
requestorReportsSearchTableCreatorFile = 'model/requestor/requestorReportsSearchTableCreator.php';

// USERS
// File that creates the users reports search table
usersReportsSearchTableCreatorFile = 'model/users/usersReportsSearchTableCreator.php';


// File that creates the item reports search table
itemReportsSearchTableCreatorFile = 'model/item/itemReportsSearchTableCreator.php';

// File that creates the Pullout Item Reports search table
pulloutReportsSearchTableCreatorFile = 'model/pullout/pulloutReportsSearchTableCreator.php';




// File that returns the last inserted requestorID
requestorLastInsertedIDFile = 'model/requestor/populateLastrequestorID.php';

// USERS
// File that returns the last inserted usersID
usersLastInsertedIDFile = 'model/users/populateLastusersID.php';

// File that returns the last inserted returnID
returnLastInsertedIDFile = 'model/return/populateLastreturnIDForreturnTab.php';

// File that returns the last inserted replenishID
replenishLastInsertedIDFile = 'model/replenish/populateLastreplenishIDForreplenishTab.php';

// File that returns the last inserted pulloutID
pulloutLastInsertedIDFile = 'model/pullout/populateLastpulloutIDForpulloutTab.php';

// File that returns the last inserted productID for item details tab
itemLastInsertedIDFile = 'model/item/populateLastProductID.php';



// File that returns returnIDs
showreturnIDSuggestionsFile = 'model/return/showreturnIDs.php';

// File that returns replenishIDs
showreplenishIDSuggestionsFile = 'model/replenish/showreplenishIDs.php';

// File that returns pulloutIDs
showpulloutIDSuggestionsFile = 'model/pullout/showpulloutIDs.php';

// File that returns requestorIDs
showrequestorIDSuggestionsFile = 'model/requestor/showrequestorIDs.php';

// USERS
// File that returns usersIDs
showusersIDSuggestionsFile = 'model/users/showusersIDs.php';

// File that returns requestorIDs for pullout tab
showrequestorIDSuggestionsForpulloutTabFile = 'model/requestor/showrequestorIDsForpulloutTab.php';

// File that returns requestorIDs for pullout tab
showrequestorIDSuggestionsForreturnTabFile = 'model/requestor/showrequestorIDsForreturnTab.php';



// File that returns itemNumbers
showItemNumberSuggestionsFile = 'model/item/showItemNumber.php';

// File that returns itemNumbers for return tab
showItemNumberForreturnTabFile = 'model/item/showItemNumberForreturnTab.php';

// File that replenishs itemNumbers for replenish tab
showItemNumberForreplenishTabFile = 'model/item/showItemNumberForreplenishTab.php';

// File that returns itemNumbers for pullout tab
showItemNumberForPulloutTabFile = 'model/item/showItemNumberForPulloutTab.php';

// File that returns itemNames
showItemNamesFile = 'model/item/showItemNames.php';

// File that returns categoryName
showcategoryNameFile = 'model/item/showcategoryName.php';



// File that returns stock 
getItemStockFile = 'model/item/getItemStock.php';

// File that returns item name
getItemNameFile = 'model/item/getItemName.php';

// File that returns category name
getcategoryNameFile = 'model/item/getcategoryName.php';




// File that creates the filtered return report table
returnFilteredReportCreatorFile = 'model/return/returnFilteredReportTableCreator.php';

// File that creates the filtered replenish report table
replenishFilteredReportCreatorFile = 'model/replenish/replenishFilteredReportTableCreator.php';

// File that creates the filtered Pullout Item Report table
pulloutFilteredReportCreatorFile = 'model/pullout/pulloutFilteredReportTableCreator.php';



$(document).ready(function () {
	// Style the dropdown boxes. You need to explicitly set the width 
	// in order to fix the dropdown box not visible issue when tab is hidden
	$('.chosenSelect').chosen({ width: "95%" });

	// Initiate tooltips
	$('.invTooltip').tooltip();

	// Listen to requestor add button
	$('#addrequestor').on('click', function () {
		addrequestor();
	});

	// USERS
	// Listen to users add button
	$('#addusers').on('click', function () {
		addusers();
	});

	// Listen to item add button
	$('#addItem').on('click', function () {
		addItem();
	});

	// Listen to return add button
	$('#addreturn').on('click', function () {
		addreturn();
	});

	// Listen to replenish add button
	$('#addreplenish').on('click', function () {
		addreplenish();
	});

	// Listen to pullout add button
	$('#addpulloutButton').on('click', function () {
		addpullout();
	});

	// Listen to update button in item details tab
	$('#updateItemDetailsButton').on('click', function () {
		updateItem();
	});

	// Listen to update button in requestor details tab
	$('#updaterequestorDetailsButton').on('click', function () {
		updaterequestor();
	});

	// USERS
	// Listen to update button in users details tab
	$('#updateusersDetailsButton').on('click', function () {
		updateusers();
	});

	// Listen to update button in return details tab
	$('#updatereturnDetailsButton').on('click', function () {
		updatereturn();
	});

	// Listen to update button in replenish details tab
	$('#updatereplenishDetailsButton').on('click', function () {
		updatereplenish();
	});

	// Listen to update button in pullout details tab
	$('#updatepulloutDetailsButton').on('click', function () {
		updatepullout();
	});

	// Listen to delete button in item details tab
	$('#deleteItem').on('click', function () {
		// Confirm before deleting
		bootbox.confirm('Are you sure you want to delete?', function (result) {
			if (result) {
				deleteItem();
			}
		});
	});

	// Listen to delete button in requestor details tab
	$('#deleterequestorButton').on('click', function () {
		// Confirm before deleting


		bootbox.confirm('Are you sure you want to delete?', function (result) {
			if (result) {
				deleterequestor();
			}
		});
	});

	// USERS
	// Listen to delete button in users details tab
	$("button[name='deleteusersButton']").on('click', function (e) {
		// Confirm before deleting
		var id = $(e.target).attr("data-profile");

		bootbox.confirm('Are you sure you want to delete?', function (result) {
			if (result) {
				deleteusers(id);
			}
		});
	});




	// Listen to item name text box in item details tab
	$('#itemDetailsItemName').keyup(function () {
		showSuggestions('itemDetailsItemName', showItemNamesFile, 'itemDetailsItemNameSuggestionsDiv');
	});

	// Remove the item names suggestions dropdown in the item details tab
	// when user selects an item from it
	$(document).on('click', '#itemDetailsItemNamesSuggestionsList li', function () {
		$('#itemDetailsItemName').val($(this).text());
		$('#itemDetailsItemNamesSuggestionsList').fadeOut();
	});


	// Listen to category name text box in item details tab
	$('#itemDetailscategoryName').keyup(function () {
		showSuggestions('itemDetailscategoryName', showcategoryNameFile, 'itemDetailscategoryNameSuggestionsDiv');
	});

	// Remove the category names suggestions dropdown in the item details tab
	// when user selects an item from it
	$(document).on('click', '#itemDetailscategoryNameSuggestionsList li', function () {
		$('#itemDetailscategoryName').val($(this).text());
		$('#itemDetailscategoryNameSuggestionsList').fadeOut();
	});

	// Listen to item number text box in item details tab
	$('#itemDetailsItemNumber').keyup(function () {
		showSuggestions('itemDetailsItemNumber', showItemNumberSuggestionsFile, 'itemDetailsItemNumberSuggestionsDiv');
	});

	// Remove the item numbers suggestions dropdown in the item details tab
	// when user selects an item from it
	$(document).on('click', '#itemDetailsItemNumberSuggestionsList li', function () {
		$('#itemDetailsItemNumber').val($(this).text());
		$('#itemDetailsItemNumberSuggestionsList').fadeOut();
		getItemDetailsToPopulate();

		// Display the current stock for the selected item number
		getItemStockToPopulate('itemDetailsItemNumber', getItemStockFile, 'itemDetailsCurrentStock');

	});


	// Listen to item number text box in pullout details tab
	$('#pulloutDetailsItemNumber').keyup(function () {
		showSuggestions('pulloutDetailsItemNumber', showItemNumberForPulloutTabFile, 'pulloutDetailsItemNumberSuggestionsDiv');
	});

	// Remove the item numbers suggestions dropdown in the pullout details tab
	// when user selects an item from it
	$(document).on('click', '#pulloutDetailsItemNumberSuggestionsList li', function () {
		$('#pulloutDetailsItemNumber').val($(this).text());
		$('#pulloutDetailsItemNumberSuggestionsList').fadeOut();
		getItemDetailsToPopulateForpulloutTab();
	});


	// Refresh the return report datatable in the return report tab when Clear button is clicked
	$('#returnFilterClear').on('click', function () {
		reportsreturnTableCreator('returnReportsTableDiv', returnReportsSearchTableCreatorFile, 'returnReportsTable');
	});

	// Refresh the replenish report datatable in the replenish report tab when Clear button is clicked
	$('#replenishFilterClear').on('click', function () {
		reportsreplenishTableCreator('replenishReportsTableDiv', replenishReportsSearchTableCreatorFile, 'replenishReportsTable');
	});

	// Refresh the Pullout Item Report datatable in the Pullout Item Report tab when Clear button is clicked
	$('#pulloutFilterClear').on('click', function () {
		reportspulloutTableCreator('pulloutReportsTableDiv', pulloutReportsSearchTableCreatorFile, 'pulloutReportsTable');
	});


	// Listen to item number text box in return details tab
	$('#returnDetailsItemNumber').keyup(function () {
		showSuggestions('returnDetailsItemNumber', showItemNumberForreturnTabFile, 'returnDetailsItemNumberSuggestionsDiv');
	});

	// remove the item numbers suggestions dropdown in the return details tab
	// when user selects an item from it
	$(document).on('click', '#returnDetailsItemNumberSuggestionsList li', function () {
		$('#returnDetailsItemNumber').val($(this).text());
		$('#returnDetailsItemNumberSuggestionsList').fadeOut();

		// Display the item name for the selected item number
		getItemName('returnDetailsItemNumber', getItemNameFile, 'returnDetailsItemName');

		// Display the category name for the selected item number
		getcategoryName('returnDetailsItemNumber', getcategoryNameFile, 'returnDetailscategoryName');

		// Display the current stock for the selected item number
		getItemStockToPopulate('returnDetailsItemNumber', getItemStockFile, 'returnDetailsCurrentStock');
	});

	// Listen to item number text box in replenish details tab
	$('#replenishDetailsItemNumber').keyup(function () {
		showSuggestions('replenishDetailsItemNumber', showItemNumberForreplenishTabFile, 'replenishDetailsItemNumberSuggestionsDiv');
	});

	// remove the item numbers suggestions dropdown in the replenish details tab
	// when user selects an item from it
	$(document).on('click', '#replenishDetailsItemNumberSuggestionsList li', function () {
		$('#replenishDetailsItemNumber').val($(this).text());
		$('#replenishDetailsItemNumberSuggestionsList').fadeOut();

		// Display the item name for the selected item number
		getItemName('replenishDetailsItemNumber', getItemNameFile, 'replenishDetailsItemName');

		// Display the category name for the selected item number
		getcategoryName('replenishDetailsItemNumber', getcategoryNameFile, 'replenishDetailscategoryName');

		// Display the current stock for the selected item number
		getItemStockToPopulate('replenishDetailsItemNumber', getItemStockFile, 'replenishDetailsCurrentStock');
	});



	// Listen to requestorID text box in requestor details tab
	$('#requestorDetailsrequestorID').keyup(function () {
		showSuggestions('requestorDetailsrequestorID', showrequestorIDSuggestionsFile, 'requestorDetailsrequestorIDSuggestionsDiv');
	});

	// Remove the requestorID suggestions dropdown in the requestor details tab
	// when user selects an item from it
	$(document).on('click', '#requestorDetailsrequestorIDSuggestionsList li', function () {
		$('#requestorDetailsrequestorID').val($(this).text());
		$('#requestorDetailsrequestorIDSuggestionsList').fadeOut();
		getrequestorDetailsToPopulate();
	});



	// USERS
	// Listen to usersID text box in users details tab
	$('#id').keyup(function () {
		showSuggestions('id', showusersIDSuggestionsFile, 'idSuggestionsDiv');
	});
	// Remove the usersID suggestions dropdown in the users details tab
	// when user selects an item from it
	$(document).on('click', '#idSuggestionsList li', function () {
		$('#id').val($(this).text());
		$('#idSuggestionsList').fadeOut();
		getusersDetailsToPopulate();
	});



	// pullout
	// Listen to requestorID text box in pullout details tab
	$('#pulloutDetailsrequestorID').keyup(function () {
		showSuggestions('pulloutDetailsrequestorID', showrequestorIDSuggestionsForpulloutTabFile, 'pulloutDetailsrequestorIDSuggestionsDiv');
	});

	// Remove the requestorID suggestions dropdown in the pullout details tab
	// when user selects an item from it
	$(document).on('click', '#pulloutDetailsrequestorIDSuggestionsList li', function () {
		$('#pulloutDetailsrequestorID').val($(this).text());
		$('#pulloutDetailsrequestorIDSuggestionsList').fadeOut();
		getrequestorDetailsToPopulatepulloutTab();
	});


	// return
	// Listen to requestorID text box in return details tab
	$('#returnDetailsrequestorID').keyup(function () {
		showSuggestions('returnDetailsrequestorID', showrequestorIDSuggestionsForreturnTabFile, 'returnDetailsrequestorIDSuggestionsDiv');
	});

	// Remove the requestorID suggestions dropdown in the return details tab
	// when user selects an item from it
	$(document).on('click', '#returnDetailsrequestorIDSuggestionsList li', function () {
		$('#returnDetailsrequestorID').val($(this).text());
		$('#returnDetailsrequestorIDSuggestionsList').fadeOut();
		getrequestorDetailsToPopulatereturnTab();
	});




	// Listen to returnID text box in return details tab
	$('#returnDetailsreturnID').keyup(function () {
		showSuggestions('returnDetailsreturnID', showreturnIDSuggestionsFile, 'returnDetailsreturnIDSuggestionsDiv');
	});

	// Remove the returnID suggestions dropdown in the requestor details tab
	// when user selects an item from it
	$(document).on('click', '#returnDetailsreturnIDSuggestionsList li', function () {
		$('#returnDetailsreturnID').val($(this).text());
		$('#returnDetailsreturnIDSuggestionsList').fadeOut();
		getreturnDetailsToPopulate();
	});

	// Listen to replenishID text box in replenish details tab
	$('#replenishDetailsreplenishID').keyup(function () {
		showSuggestions('replenishDetailsreplenishID', showreplenishIDSuggestionsFile, 'replenishDetailsreplenishIDSuggestionsDiv');
	});

	// Remove the replenishID suggestions dropdown in the requestor details tab
	// when user selects an item from it
	$(document).on('click', '#replenishDetailsreplenishIDSuggestionsList li', function () {
		$('#replenishDetailsreplenishID').val($(this).text());
		$('#replenishDetailsreplenishIDSuggestionsList').fadeOut();
		getreplenishDetailsToPopulate();
	});



	// Listen to pulloutID text box in pullout details tab
	$('#pulloutDetailspulloutID').keyup(function () {
		showSuggestions('pulloutDetailspulloutID', showpulloutIDSuggestionsFile, 'pulloutDetailspulloutIDSuggestionsDiv');
	});

	// Remove the pulloutID suggestions dropdown in the pullout details tab
	// when user selects an item from it
	$(document).on('click', '#pulloutDetailspulloutIDSuggestionsList li', function () {
		$('#pulloutDetailspulloutID').val($(this).text());
		$('#pulloutDetailspulloutIDSuggestionsList').fadeOut();
		getpulloutDetailsToPopulate();
	});



	// Initiate datepickers
	$('.datepicker').datepicker({
		format: 'yyyy-mm-dd',
		todayHighlight: true,
		todayBtn: 'linked',
		orientation: 'bottom left'
	});

	// Calculate Total in return tab
	$('#returnDetailsQuantity').change(function () {
		calculateTotalInreturnTab();
	});

	// Calculate Total in replenish tab
	$('#replenishDetailsQuantity').change(function () {
		calculateTotalInreplenishTab();
	});
	// Close any suggestions lists from the page when a user clicks on the page
	$(document).on('click', function () {
		$('.suggestionsList').fadeOut();
	});

	// Load searchable datatables for requestor, return, replenish, item, pullout
	searchTableCreator('itemDetailsTableDiv', itemDetailsSearchTableCreatorFile, 'itemDetailsTable');
	searchTableCreator('returnDetailsTableDiv', returnDetailsSearchTableCreatorFile, 'returnDetailsTable');
	searchTableCreator('replenishDetailsTableDiv', replenishDetailsSearchTableCreatorFile, 'replenishDetailsTable');
	searchTableCreator('requestorDetailsTableDiv', requestorDetailsSearchTableCreatorFile, 'requestorDetailsTable');
	searchTableCreator('pulloutDetailsTableDiv', pulloutDetailsSearchTableCreatorFile, 'pulloutDetailsTable');
	// USERS
	searchTableCreator('usersDetailsTableDiv', usersDetailsSearchTableCreatorFile, 'usersDetailsTable');

	// Load searchable datatables for requestor, return, replenish, item, Pullout Item Reports
	reportsTableCreator('itemReportsTableDiv', itemReportsSearchTableCreatorFile, 'itemReportsTable');
	reportsreturnTableCreator('returnReportsTableDiv', returnReportsSearchTableCreatorFile, 'returnReportsTable');
	reportsreplenishTableCreator('replenishReportsTableDiv', replenishReportsSearchTableCreatorFile, 'replenishReportsTable');
	reportsTableCreator('requestorReportsTableDiv', requestorReportsSearchTableCreatorFile, 'requestorReportsTable');
	reportspulloutTableCreator('pulloutReportsTableDiv', pulloutReportsSearchTableCreatorFile, 'pulloutReportsTable');
	// USERS
	reportsTableCreator('usersReportsTableDiv', usersReportsSearchTableCreatorFile, 'usersReportsTable');


	// Initiate popovers
	$(document).on('mouseover', '.itemDetailsHover', function () {
		// Create item details popover boxes
		$('.itemDetailsHover').popover({
			container: 'body',
			title: 'Item Details',
			trigger: 'hover',
			html: true,
			placement: 'right',
			content: fetchData
		});
	});

	// Listen to refresh buttons
	$('#searchTablesRefresh, #reportsTablesRefresh').on('click', function () {
		searchTableCreator('itemDetailsTableDiv', itemDetailsSearchTableCreatorFile, 'itemDetailsTable');
		searchTableCreator('returnDetailsTableDiv', returnDetailsSearchTableCreatorFile, 'returnDetailsTable');
		searchTableCreator('replenishDetailsTableDiv', replenishDetailsSearchTableCreatorFile, 'replenishDetailsTable');
		searchTableCreator('requestorDetailsTableDiv', requestorDetailsSearchTableCreatorFile, 'requestorDetailsTable');
		searchTableCreator('pulloutDetailsTableDiv', pulloutDetailsSearchTableCreatorFile, 'pulloutDetailsTable');
		// USERS
		searchTableCreator('usersDetailsTableDiv', usersDetailsSearchTableCreatorFile, 'usersDetailsTable');


		reportsTableCreator('itemReportsTableDiv', itemReportsSearchTableCreatorFile, 'itemReportsTable');
		reportsreturnTableCreator('returnReportsTableDiv', returnReportsSearchTableCreatorFile, 'returnReportsTable');
		reportsreplenishTableCreator('replenishReportsTableDiv', replenishReportsSearchTableCreatorFile, 'replenishReportsTable');
		reportsTableCreator('requestorReportsTableDiv', requestorReportsSearchTableCreatorFile, 'requestorReportsTable');
		reportspulloutTableCreator('pulloutReportsTableDiv', pulloutReportsSearchTableCreatorFile, 'pulloutReportsTable');
		// USERS
		reportsTableCreator('usersReportsTableDiv', usersReportsSearchTableCreatorFile, 'usersReportsTable');

	});


	// Listen to return report show button
	$('#showreturnReport').on('click', function () {
		filteredreturnReportTableCreator('returnReportStartDate', 'returnReportEndDate', returnFilteredReportCreatorFile, 'returnReportsTableDiv', 'returnFilteredReportsTable');
	});

	// Listen to replenish report show button
	$('#showreplenishReport').on('click', function () {
		filteredreplenishReportTableCreator('replenishReportStartDate', 'replenishReportEndDate', replenishFilteredReportCreatorFile, 'replenishReportsTableDiv', 'replenishFilteredReportsTable');
	});

	// Listen to Pullout Item Report show button
	$('#showpulloutReport').on('click', function () {
		filteredpulloutReportTableCreator('pulloutReportStartDate', 'pulloutReportEndDate', pulloutFilteredReportCreatorFile, 'pulloutReportsTableDiv', 'pulloutFilteredReportsTable');
	});

});


// Function to fetch data to show in popovers
function fetchData() {
	var fetch_data = '';
	var element = $(this);
	var id = element.attr('id');

	$.ajax({
		url: 'model/item/getItemDetailsForPopover.php',
		method: 'POST',
		async: false,
		data: { id: id },
		success: function (data) {
			fetch_data = data;
		}
	});
	return fetch_data;
}



// Function to create searchable datatables for requestor, item, return, replenish, pullout
function searchTableCreator(tableContainerDiv, tableCreatorFileUrl, table) {
	var tableContainerDivID = '#' + tableContainerDiv;
	var tableID = '#' + table;
	$(tableContainerDivID).load(tableCreatorFileUrl, function () {
		// Initiate the Datatable plugin once the table is added to the DOM
		$(tableID).DataTable();
	});
}


// Function to create reports datatables for requestor, item, return, replenish, pullout
function reportsTableCreator(tableContainerDiv, tableCreatorFileUrl, table) {
	var tableContainerDivID = '#' + tableContainerDiv;
	var tableID = '#' + table;
	$(tableContainerDivID).load(tableCreatorFileUrl, function () {
		// Initiate the Datatable plugin once the table is added to the DOM
		$(tableID).DataTable({
			dom: 'lBfrtip',
			//dom: 'lfBrtip',
			//dom: 'Bfrtip',
			buttons: [
				'copy',
				'csv', 'excel',
				{ extend: 'pdf', orientation: 'landscape', pageSize: 'LEGAL' },
				'print'
			]
		});
	});
}


// Function to create reports datatables for return
function reportsreturnTableCreator(tableContainerDiv, tableCreatorFileUrl, table) {
	var tableContainerDivID = '#' + tableContainerDiv;
	var tableID = '#' + table;
	$(tableContainerDivID).load(tableCreatorFileUrl, function () {
		// Initiate the Datatable plugin once the table is added to the DOM
		$(tableID).DataTable({
			dom: 'lBfrtip',
			buttons: [
				'copy',
				{ extend: 'csv', footer: true, title: 'Return Report' },
				{ extend: 'excel', footer: true, title: 'Return Report' },
				{ extend: 'pdf', footer: true, orientation: 'landscape', pageSize: 'LEGAL', title: 'Return Report' },
				{ extend: 'print', footer: true, title: 'Return Report' },
			],
			"footerCallback": function (row, data, start, end, display) {
				var api = this.api(), data;

				// Remove the formatting to get integer data for summation
				var intVal = function (i) {
					return typeof i === 'string' ?
						i.replace(/[\$,]/g, '') * 1 :
						typeof i === 'number' ?
							i : 0;
				};

				// Quantity total over all pages
				quantityTotal = api
					.column(9)
					.data()
					.reduce(function (a, b) {
						return intVal(a) + intVal(b);
					}, 0);

				// Quantity for current page
				quantityFilteredTotal = api
					.column(9, { page: 'current' })
					.data()
					.reduce(function (a, b) {
						return intVal(a) + intVal(b);
					}, 0);


				// Update footer columns
				$(api.column(9).footer()).html(quantityFilteredTotal + ' (' + quantityTotal + ' total)');
			}
		});
	});
}

// Function to create reports datatables for replenish
function reportsreplenishTableCreator(tableContainerDiv, tableCreatorFileUrl, table) {
	var tableContainerDivID = '#' + tableContainerDiv;
	var tableID = '#' + table;
	$(tableContainerDivID).load(tableCreatorFileUrl, function () {
		// Initiate the Datatable plugin once the table is added to the DOM
		$(tableID).DataTable({
			dom: 'lBfrtip',
			buttons: [
				'copy',
				{ extend: 'csv', footer: true, title: 'Replenish Report' },
				{ extend: 'excel', footer: true, title: 'Replenish Report' },
				{ extend: 'pdf', footer: true, orientation: 'landscape', pageSize: 'LEGAL', title: 'Replenish Report' },
				{ extend: 'print', footer: true, title: 'Replenish Report' },
			],
			"footerCallback": function (row, data, start, end, display) {
				var api = this.api(), data;

				// Remove the formatting to get integer data for summation
				var intVal = function (i) {
					return typeof i === 'string' ?
						i.replace(/[\$,]/g, '') * 1 :
						typeof i === 'number' ?
							i : 0;
				};

				// Quantity total over all pages
				quantityTotal = api
					.column(6)
					.data()
					.reduce(function (a, b) {
						return intVal(a) + intVal(b);
					}, 0);

				// Quantity for current page
				quantityFilteredTotal = api
					.column(6, { page: 'current' })
					.data()
					.reduce(function (a, b) {
						return intVal(a) + intVal(b);
					}, 0);


				// Update footer columns
				$(api.column(6).footer()).html(quantityFilteredTotal + ' (' + quantityTotal + ' total)');
			}
		});
	});
}


// Function to create reports datatables for pullout
function reportspulloutTableCreator(tableContainerDiv, tableCreatorFileUrl, table) {
	var tableContainerDivID = '#' + tableContainerDiv;
	var tableID = '#' + table;
	$(tableContainerDivID).load(tableCreatorFileUrl, function () {
		// Initiate the Datatable plugin once the table is added to the DOM
		$(tableID).DataTable({
			dom: 'lBfrtip',
			buttons: [
				'copy',
				{ extend: 'csv', footer: true, title: 'Pullout Item Report' },
				{ extend: 'excel', footer: true, title: 'Pullout Item Report' },
				{ extend: 'pdf', footer: true, orientation: 'landscape', pageSize: 'LEGAL', title: 'Pullout Item Report' },
				{ extend: 'print', footer: true, title: 'Pullout Item Report' },
			],
			"footerCallback": function (row, data, start, end, display) {
				var api = this.api(), data;

				// Remove the formatting to get integer data for summation
				var intVal = function (i) {
					return typeof i === 'string' ?
						i.replace(/[\$,]/g, '') * 1 :
						typeof i === 'number' ?
							i : 0;
				};

				// Quantity Total over all pages
				quantityTotal = api
					.column(8)
					.data()
					.reduce(function (a, b) {
						return intVal(a) + intVal(b);
					}, 0);

				// Quantity Total over this page
				quantityFilteredTotal = api
					.column(8, { page: 'current' })
					.data()
					.reduce(function (a, b) {
						return intVal(a) + intVal(b);
					}, 0);

				// Update footer columns
				$(api.column(8).footer()).html(quantityFilteredTotal + ' (' + quantityTotal + ' total)');
			}
		});
	});
}



// Function to create filtered datatable for pullout details with total values
function filteredpulloutReportTableCreator(startDate, endDate, scriptPath, tableDIV, tableID) {
	var startDate = $('#' + startDate).val();
	var endDate = $('#' + endDate).val();

	$.ajax({
		url: scriptPath,
		method: 'POST',
		data: {
			startDate: startDate,
			endDate: endDate,
		},
		success: function (data) {
			$('#' + tableDIV).empty();
			$('#' + tableDIV).html(data);
		},
		complete: function () {
			// Initiate the Datatable plugin once the table is added to the DOM
			$('#' + tableID).DataTable({
				dom: 'lBfrtip',
				buttons: [
					'copy',
					{ extend: 'csv', footer: true, title: 'Pullout Item Report' },
					{ extend: 'excel', footer: true, title: 'Pullout Item Report' },
					{ extend: 'pdf', footer: true, orientation: 'landscape', pageSize: 'LEGAL', title: 'Pullout Item Report' },
					{ extend: 'print', footer: true, title: 'Pullout Item Report' },
				],
				"footerCallback": function (row, data, start, end, display) {
					var api = this.api(), data;

					// Remove the formatting to get integer data for summation
					var intVal = function (i) {
						return typeof i === 'string' ?
							i.replace(/[\$,]/g, '') * 1 :
							typeof i === 'number' ?
								i : 0;
					};

					// Total over all pages
					quantityTotal = api
						.column(8)
						.data()
						.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);

					// Total over this page
					quantityFilteredTotal = api
						.column(8, { page: 'current' })
						.data()
						.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);

					// Update footer columns
					$(api.column(8).footer()).html(quantityFilteredTotal + ' (' + quantityTotal + ' total)');
				}
			});
		}
	});
}


// Function to create filtered datatable for return details with total values
function filteredreturnReportTableCreator(startDate, endDate, scriptPath, tableDIV, tableID) {
	var startDate = $('#' + startDate).val();
	var endDate = $('#' + endDate).val();

	$.ajax({
		url: scriptPath,
		method: 'POST',
		data: {
			startDate: startDate,
			endDate: endDate,
		},
		success: function (data) {
			$('#' + tableDIV).empty();
			$('#' + tableDIV).html(data);
		},
		complete: function () {
			// Initiate the Datatable plugin once the table is added to the DOM
			$('#' + tableID).DataTable({
				dom: 'lBfrtip',
				buttons: [
					'copy',
					{ extend: 'csv', footer: true, title: 'Return Report' },
					{ extend: 'excel', footer: true, title: 'Return Report' },
					{ extend: 'pdf', footer: true, orientation: 'landscape', pageSize: 'LEGAL', title: 'Return Report' },
					{ extend: 'print', footer: true, title: 'Return Report' }
				],
				"footerCallback": function (row, data, start, end, display) {
					var api = this.api(), data;

					// Remove the formatting to get integer data for summation
					var intVal = function (i) {
						return typeof i === 'string' ?
							i.replace(/[\$,]/g, '') * 1 :
							typeof i === 'number' ?
								i : 0;
					};

					// Quantity total over all pages
					quantityTotal = api
						.column(9)
						.data()
						.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);

					// Quantity for current page
					quantityFilteredTotal = api
						.column(9, { page: 'current' })
						.data()
						.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);

					// Update footer columns
					$(api.column(9).footer()).html(quantityFilteredTotal + ' (' + quantityTotal + ' total)');
				}
			});
		}
	});
}

// Function to create filtered datatable for replenish details with total values
function filteredreplenishReportTableCreator(startDate, endDate, scriptPath, tableDIV, tableID) {
	var startDate = $('#' + startDate).val();
	var endDate = $('#' + endDate).val();

	$.ajax({
		url: scriptPath,
		method: 'POST',
		data: {
			startDate: startDate,
			endDate: endDate,
		},
		success: function (data) {
			$('#' + tableDIV).empty();
			$('#' + tableDIV).html(data);
		},
		complete: function () {
			// Initiate the Datatable plugin once the table is added to the DOM
			$('#' + tableID).DataTable({
				dom: 'lBfrtip',
				buttons: [
					'copy',
					{ extend: 'csv', footer: true, title: 'Replenish Report' },
					{ extend: 'excel', footer: true, title: 'Replenish Report' },
					{ extend: 'pdf', footer: true, orientation: 'landscape', pageSize: 'LEGAL', title: 'Replenish Report' },
					{ extend: 'print', footer: true, title: 'Replenish Report' }
				],
				"footerCallback": function (row, data, start, end, display) {
					var api = this.api(), data;

					// Remove the formatting to get integer data for summation
					var intVal = function (i) {
						return typeof i === 'string' ?
							i.replace(/[\$,]/g, '') * 1 :
							typeof i === 'number' ?
								i : 0;
					};

					// Quantity total over all pages
					quantityTotal = api
						.column(6)
						.data()
						.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);

					// Quantity for current page
					quantityFilteredTotal = api
						.column(6, { page: 'current' })
						.data()
						.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);

					// Update footer columns
					$(api.column(6).footer()).html(quantityFilteredTotal + ' (' + quantityTotal + ' total)');
				}
			});
		}
	});
}


// Function to call the insertrequestor.php script to insert requestor data to db
function addrequestor() {
	var requestorDetailsrequestorFullName = $('#requestorDetailsrequestorFullName').val();
	var requestorDetailsrequestordepartment = $('#requestorDetailsrequestordepartment').val();
	var requestorDetailsrequestorposition = $('#requestorDetailsrequestorposition').val();
	var requestorDetailsrequestorEmail = $('#requestorDetailsrequestorEmail').val();
	var requestorDetailsrequestorMobile = $('#requestorDetailsrequestorMobile').val();
	var requestorDetailsrequestorAddress = $('#requestorDetailsrequestorAddress').val();
	var requestorDetailsStatus = $('#requestorDetailsStatus option:selected').text();

	$.ajax({
		url: 'model/requestor/insertrequestor.php',
		method: 'POST',
		data: {
			requestorDetailsrequestorFullName: requestorDetailsrequestorFullName,
			requestorDetailsrequestordepartment: requestorDetailsrequestordepartment,
			requestorDetailsrequestorposition: requestorDetailsrequestorposition,
			requestorDetailsrequestorEmail: requestorDetailsrequestorEmail,
			requestorDetailsrequestorMobile: requestorDetailsrequestorMobile,
			requestorDetailsrequestorAddress: requestorDetailsrequestorAddress,
			requestorDetailsStatus: requestorDetailsStatus,
		},
		success: function (data) {
			$('#requestorDetailsMessage').fadeIn();
			$('#requestorDetailsMessage').html(data);
		},
		complete: function (data) {
			populateLastInsertedID(requestorLastInsertedIDFile, 'requestorDetailsrequestorID');
			searchTableCreator('requestorDetailsTableDiv', requestorDetailsSearchTableCreatorFile, 'requestorDetailsTable');
			reportsTableCreator('requestorReportsTableDiv', requestorReportsSearchTableCreatorFile, 'requestorReportsTable');
		}
	});
}


// USERS
// Function to call the insertusers.php script to insert users data to db
function addusers() {
	var usersDetailsusersname = $('#usersDetailsusersname').val();
	var usersDetailsusersemail = $('#usersDetailsusersemail').val();
	var usersDetailsusersuser_type = $('#usersDetailsusersuser_type').val();
	var usersDetailsuserspassword = $('#usersDetailsuserspassword').val();
	var usersDetailsusersimage = $('#usersDetailsusersimage').val();

	$.ajax({
		url: 'model/users/insertusers.php',
		method: 'POST',
		data: {
			usersDetailsusersname: usersDetailsusersname,
			usersDetailsusersemail: usersDetailsusersemail,
			usersDetailsusersuser_type: usersDetailsusersuser_type,
			usersDetailsuserspassword: usersDetailsuserspassword,
			usersDetailsusersimage: usersDetailsusersimage,
		},
		success: function (data) {
			$('#usersDetailsMessage').fadeIn();
			$('#usersDetailsMessage').html(data);
		},
		complete: function (data) {
			populateLastInsertedID(usersLastInsertedIDFile, 'id');
			searchTableCreator('usersDetailsTableDiv', usersDetailsSearchTableCreatorFile, 'usersDetailsTable');
			reportsTableCreator('usersReportsTableDiv', usersReportsSearchTableCreatorFile, 'usersReportsTable');
		}
	});
}


// Function to call the insertItem.php script to insert item data to db
function addItem() {
	var itemDetailsItemNumber = $('#itemDetailsItemNumber').val();
	var itemDetailscategoryName = $('#itemDetailscategoryName').val();
	var itemDetailsItemName = $('#itemDetailsItemName').val();
	var itemDetailsQuantity = $('#itemDetailsQuantity').val();
	var itemDetailsStatus = $('#itemDetailsStatus').val();
	var itemDetailsDescription = $('#itemDetailsDescription').val();

	$.ajax({
		url: 'model/item/insertItem.php',
		method: 'POST',
		data: {
			itemDetailsItemNumber: itemDetailsItemNumber,
			itemDetailscategoryName: itemDetailscategoryName,
			itemDetailsItemName: itemDetailsItemName,
			itemDetailsQuantity: itemDetailsQuantity,
			itemDetailsStatus: itemDetailsStatus,
			itemDetailsDescription: itemDetailsDescription,
		},
		success: function (data) {
			$('#itemDetailsMessage').fadeIn();
			$('#itemDetailsMessage').html(data);
		},
		complete: function () {
			populateLastInsertedID(itemLastInsertedIDFile, 'itemDetailsProductID');
			getItemStockToPopulate('itemDetailsItemNumber', getItemStockFile, itemDetailsTotalStock, itemDetailsCurrentStock);
			searchTableCreator('itemDetailsTableDiv', itemDetailsSearchTableCreatorFile, 'itemDetailsTable');
			reportsTableCreator('itemReportsTableDiv', itemReportsSearchTableCreatorFile, 'itemReportsTable');
		}
	});
}


// Function to call the insertreturn.php script to insert return data to db
function addreturn() {
	var returnDetailsItemNumber = $('#returnDetailsItemNumber').val();
	var returnDetailsrequestorID = $('#returnDetailsrequestorID').val();
	var returnDetailsreturnDate = $('#returnDetailsreturnDate').val();
	var returnDetailsrequestorName = $('#returnDetailsrequestorName').val();
	var returnDetailsrequestorDepartment = $('#returnDetailsrequestorDepartment').val();
	var returnDetailsrequestorPosition = $('#returnDetailsrequestorPosition').val();
	var returnDetailscategoryName = $('#returnDetailscategoryName').val();
	var returnDetailsItemName = $('#returnDetailsItemName').val();
	var returnDetailsrequestorID = $('#returnDetailsrequestorID').val();
	var returnDetailsfullName = $('#returnDetailsfullName').val();
	var returnDetailsdepartment = $('#returnDetailsdepartment').val();
	var returnDetailsposition = $('#returnDetailsposition').val();
	var returnDetailsDescription = $('#returnDetailsDescription').val();
	var returnDetailsQuantity = $('#returnDetailsQuantity').val();

	$.ajax({
		url: 'model/return/insertreturn.php',
		method: 'POST',
		data: {
			returnDetailsItemNumber: returnDetailsItemNumber,
			returnDetailsrequestorID: returnDetailsrequestorID,
			returnDetailsreturnDate: returnDetailsreturnDate,
			returnDetailsrequestorName: returnDetailsrequestorName,
			returnDetailsrequestorDepartment: returnDetailsrequestorDepartment,
			returnDetailsrequestorPosition: returnDetailsrequestorPosition,
			returnDetailscategoryName: returnDetailscategoryName,
			returnDetailsItemName: returnDetailsItemName,
			returnDetailsrequestorID: returnDetailsrequestorID,
			returnDetailsfullName: returnDetailsfullName,
			returnDetailsdepartment: returnDetailsdepartment,
			returnDetailsposition: returnDetailsposition,
			returnDetailsDescription: returnDetailsDescription,
			returnDetailsQuantity: returnDetailsQuantity,
		},
		success: function (data) {
			$('#returnDetailsMessage').fadeIn();
			$('#returnDetailsMessage').html(data);
		},
		complete: function () {
			getItemStockToPopulate('returnDetailsItemNumber', getItemStockFile, 'returnDetailsCurrentStock');
			populateLastInsertedID(returnLastInsertedIDFile, 'returnDetailsreturnID');
			searchTableCreator('returnDetailsTableDiv', returnDetailsSearchTableCreatorFile, 'returnDetailsTable');
			reportsreturnTableCreator('returnReportsTableDiv', returnReportsSearchTableCreatorFile, 'returnReportsTable');
			searchTableCreator('itemDetailsTableDiv', itemDetailsSearchTableCreatorFile, 'itemDetailsTable');
			reportsTableCreator('itemReportsTableDiv', itemReportsSearchTableCreatorFile, 'itemReportsTable');
		}
	});
}

// Function to call the insertreplenish.php script to insert replenish data to db
function addreplenish() {
	var replenishDetailsItemNumber = $('#replenishDetailsItemNumber').val();
	var replenishDetailscategoryName = $('#replenishDetailscategoryName').val();
	var replenishDetailsreplenishDate = $('#replenishDetailsreplenishDate').val();
	var replenishDetailsItemName = $('#replenishDetailsItemName').val();
	var replenishDetailsDescription = $('#replenishDetailsDescription').val();
	var replenishDetailsQuantity = $('#replenishDetailsQuantity').val();

	$.ajax({
		url: 'model/replenish/insertreplenish.php',
		method: 'POST',
		data: {
			replenishDetailsItemNumber: replenishDetailsItemNumber,
			replenishDetailscategoryName: replenishDetailscategoryName,
			replenishDetailsreplenishDate: replenishDetailsreplenishDate,
			replenishDetailsItemName: replenishDetailsItemName,
			replenishDetailsDescription: replenishDetailsDescription,
			replenishDetailsQuantity: replenishDetailsQuantity,
		},
		success: function (data) {
			$('#replenishDetailsMessage').fadeIn();
			$('#replenishDetailsMessage').html(data);
		},
		complete: function () {
			getItemStockToPopulate('replenishDetailsItemNumber', getItemStockFile, 'replenishDetailsCurrentStock');
			populateLastInsertedID(replenishLastInsertedIDFile, 'replenishDetailsreplenishID');
			searchTableCreator('replenishDetailsTableDiv', replenishDetailsSearchTableCreatorFile, 'replenishDetailsTable');
			reportsreplenishTableCreator('replenishReportsTableDiv', replenishReportsSearchTableCreatorFile, 'replenishReportsTable');
			searchTableCreator('itemDetailsTableDiv', itemDetailsSearchTableCreatorFile, 'itemDetailsTable');
			reportsTableCreator('itemReportsTableDiv', itemReportsSearchTableCreatorFile, 'itemReportsTable');
		}
	});
}


// Function to call the insertpullout.php script to insert pullout data to db
function addpullout() {
	var pulloutDetailsItemNumber = $('#pulloutDetailsItemNumber').val();
	var pulloutDetailsrequestorID = $('#pulloutDetailsrequestorID').val();
	var pulloutDetailsrequestorName = $('#pulloutDetailsrequestorName').val();
	var pulloutDetailsrequestorDepartment = $('#pulloutDetailsrequestorDepartment').val();
	var pulloutDetailscategoryName = $('#pulloutDetailscategoryName').val();
	var pulloutDetailsItemName = $('#pulloutDetailsItemName').val();
	var pulloutDetailspulloutDate = $('#pulloutDetailspulloutDate').val();
	var pulloutDetailsdescription = $('#pulloutDetailsdescription').val();
	var pulloutDetailsQuantity = $('#pulloutDetailsQuantity').val();

	$.ajax({
		url: 'model/pullout/insertpullout.php',
		method: 'POST',
		data: {
			pulloutDetailsItemNumber: pulloutDetailsItemNumber,
			pulloutDetailsrequestorID: pulloutDetailsrequestorID,
			pulloutDetailsrequestorName: pulloutDetailsrequestorName,
			pulloutDetailsrequestorDepartment: pulloutDetailsrequestorDepartment,
			pulloutDetailscategoryName: pulloutDetailscategoryName,
			pulloutDetailsItemName: pulloutDetailsItemName,
			pulloutDetailspulloutDate: pulloutDetailspulloutDate,
			pulloutDetailsdescription: pulloutDetailsdescription,
			pulloutDetailsQuantity: pulloutDetailsQuantity,
		},
		success: function (data) {
			$('#pulloutDetailsMessage').fadeIn();
			$('#pulloutDetailsMessage').html(data);
		},
		complete: function () {
			getItemStockToPopulate('pulloutDetailsItemNumber', getItemStockFile, 'pulloutDetailsTotalStock');
			populateLastInsertedID(pulloutLastInsertedIDFile, 'pulloutDetailspulloutID');
			searchTableCreator('pulloutDetailsTableDiv', pulloutDetailsSearchTableCreatorFile, 'pulloutDetailsTable');
			reportspulloutTableCreator('pulloutReportsTableDiv', pulloutReportsSearchTableCreatorFile, 'pulloutReportsTable');
			searchTableCreator('itemDetailsTableDiv', itemDetailsSearchTableCreatorFile, 'itemDetailsTable');
			reportsTableCreator('itemReportsTableDiv', itemReportsSearchTableCreatorFile, 'itemReportsTable');
		}
	});
}


// Function to send itemNumber so that item details can be pulled from db
// to be displayed on item details tab
function getItemDetailsToPopulate() {
	// Get the itemNumber entered in the text box
	var itemNumber = $('#itemDetailsItemNumber').val();

	// Call the populateItemDetails.php script to get item details
	// relevant to the itemNumber which the user entered
	$.ajax({
		url: 'model/item/populateItemDetails.php',
		method: 'POST',
		data: { itemNumber: itemNumber },
		dataType: 'json',
		success: function (data) {
			//$('#itemDetailsItemNumber').val(data.itemNumber);
			$('#itemDetailsProductID').val(data.productID);
			$('#itemDetailscategoryName').val(data.categoryName);
			$('#itemDetailsItemName').val(data.itemName);
			$('#itemDetailsTotalStock').val(data.stock);
			$('#itemDetailsDescription').val(data.description);
			$('#itemDetailsStatus').val(data.status).trigger("chosen:updated");

		}
	});
}

// Function to send itemNumber so that item details can be pulled from db
// to be displayed on pullout details tab
function getItemDetailsToPopulateForpulloutTab() {
	// Get the itemNumber entered in the text box
	var itemNumber = $('#pulloutDetailsItemNumber').val();

	// Call the populateItemDetails.php script to get item details
	// relevant to the itemNumber which the user entered
	$.ajax({
		url: 'model/item/populateItemDetails.php',
		method: 'POST',
		data: { itemNumber: itemNumber },
		dataType: 'json',
		success: function (data) {
			//$('#pulloutDetailsItemNumber').val(data.itemNumber);
			$('#pulloutDetailscategoryName').val(data.categoryName);
			$('#pulloutDetailsItemName').val(data.itemName);
			$('#pulloutDetailsTotalStock').val(data.stock);

		},
		complete: function () {
			//$('#pulloutDetailsDiscount, #pulloutDetailsQuantity, #pulloutDetailsUnitPrice').trigger('change');
		}
	});
}




// Function to send itemNumber so that item name can be pulled from db
function getItemName(itemNumberTextBoxID, scriptPath, itemNameTextbox) {
	// Get the itemNumber entered in the text box
	var itemNumber = $('#' + itemNumberTextBoxID).val();

	// Call the script to get item details
	$.ajax({
		url: scriptPath,
		method: 'POST',
		data: { itemNumber: itemNumber },
		dataType: 'json',
		success: function (data) {
			$('#' + itemNameTextbox).val(data.itemName);
		},
		error: function (xhr, ajaxOptions, thrownError) {
		}
	});
}

// Function to send itemNumber so that item name can be pulled from db
function getcategoryName(itemNumberTextBoxID, scriptPath, categoryNameTextbox) {
	// Get the itemNumber entered in the text box
	var itemNumber = $('#' + itemNumberTextBoxID).val();

	// Call the script to get item details
	$.ajax({
		url: scriptPath,
		method: 'POST',
		data: { itemNumber: itemNumber },
		dataType: 'json',
		success: function (data) {
			$('#' + categoryNameTextbox).val(data.categoryName);
		},
		error: function (xhr, ajaxOptions, thrownError) {
		}
	});
}


// Function to send itemNumber so that item stock can be pulled from db
function getItemStockToPopulate(itemNumberTextbox, scriptPath, stockTextbox) {
	// Get the itemNumber entered in the text box
	var itemNumber = $('#' + itemNumberTextbox).val();

	// Call the script to get stock details
	$.ajax({
		url: scriptPath,
		method: 'POST',
		data: { itemNumber: itemNumber },
		dataType: 'json',
		success: function (data) {
			$('#' + stockTextbox).val(data.stock);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			//alert(xhr.status);
			//alert(thrownError);
			//console.warn(xhr.responseText)
		}
	});
}


// Function to populate last inserted ID
function populateLastInsertedID(scriptPath, textBoxID) {
	$.ajax({
		url: scriptPath,
		method: 'POST',
		dataType: 'json',
		success: function (data) {
			$('#' + textBoxID).val(data);
		}
	});
}


// Function to show suggestions
function showSuggestions(textBoxID, scriptPath, suggestionsDivID) {
	// Get the value entered by the user
	var textBoxValue = $('#' + textBoxID).val();

	// Call the showreturnIDs.php script only if there is a value in the
	// return ID textbox
	if (textBoxValue != '') {
		$.ajax({
			url: scriptPath,
			method: 'POST',
			data: { textBoxValue: textBoxValue },
			success: function (data) {
				$('#' + suggestionsDivID).fadeIn();
				$('#' + suggestionsDivID).html(data);
			}
		});
	}
}

// Function to show suggestions
function showSuggestions(textBoxID, scriptPath, suggestionsDivID) {
	// Get the value entered by the user
	var textBoxValue = $('#' + textBoxID).val();

	// Call the showreplenishIDs.php script only if there is a value in the
	// replenish ID textbox
	if (textBoxValue != '') {
		$.ajax({
			url: scriptPath,
			method: 'POST',
			data: { textBoxValue: textBoxValue },
			success: function (data) {
				$('#' + suggestionsDivID).fadeIn();
				$('#' + suggestionsDivID).html(data);
			}
		});
	}
}

// Function to delte item from db
function deleteItem() {
	// Get the item number entered by the user
	var itemDetailsItemNumber = $('#itemDetailsItemNumber').val();

	// Call the deleteItem.php script only if there is a value in the
	// item number textbox
	if (itemDetailsItemNumber != '') {
		$.ajax({
			url: 'model/item/deleteItem.php',
			method: 'POST',
			data: { itemDetailsItemNumber: itemDetailsItemNumber },
			success: function (data) {
				$('#itemDetailsMessage').fadeIn();
				$('#itemDetailsMessage').html(data);
			},
			complete: function () {
				searchTableCreator('itemDetailsTableDiv', itemDetailsSearchTableCreatorFile, 'itemDetailsTable');
				reportsTableCreator('itemReportsTableDiv', itemReportsSearchTableCreatorFile, 'itemReportsTable');
			}
		});
	}
}


// Function to delete item from db
function deleterequestor() {
	// Get the requestorID entered by the user
	var requestorDetailsrequestorID = $('#requestorDetailsrequestorID').val();

	// Call the deleterequestor.php script only if there is a value in the
	// item number textbox
	if (requestorDetailsrequestorID != '') {
		$.ajax({
			url: 'model/requestor/deleterequestor.php',
			method: 'POST',
			data: { requestorDetailsrequestorID: requestorDetailsrequestorID },
			success: function (data) {
				$('#requestorDetailsMessage').fadeIn();
				$('#requestorDetailsMessage').html(data);
			},
			complete: function () {
				searchTableCreator('requestorDetailsTableDiv', requestorDetailsSearchTableCreatorFile, 'requestorDetailsTable');
				reportsTableCreator('requestorReportsTableDiv', requestorReportsSearchTableCreatorFile, 'requestorReportsTable');
			}
		});
	}
}

// USERS
// Function to delete item from db
function deleteusers(id) {
	// Get the usersID entered by the user


	// Call the deleteusers.php script only if there is a value in the
	// item number textbox
	if (id != '') {
		$.ajax({
			url: 'model/users/deleteusers.php',
			method: 'POST',
			data: { id: id },
			success: function (data) {
				$('#usersDetailsMessage').fadeIn();
				$('#usersDetailsMessage').html(data);
			},
			complete: function () {
				searchTableCreator('usersDetailsTableDiv', usersDetailsSearchTableCreatorFile, 'usersDetailsTable');
				reportsTableCreator('usersReportsTableDiv', usersReportsSearchTableCreatorFile, 'usersReportsTable');
			}
		});
	}
}



// Function to send requestorID so that requestor details can be pulled from db
// to be displayed on requestor details tab
function getrequestorDetailsToPopulate() {
	// Get the requestorID entered in the text box
	var requestorDetailsrequestorID = $('#requestorDetailsrequestorID').val();

	// Call the populateItemDetails.php script to get item details
	// relevant to the itemNumber which the user entered
	$.ajax({
		url: 'model/requestor/populaterequestorDetails.php',
		method: 'POST',
		data: { requestorID: requestorDetailsrequestorID },
		dataType: 'json',
		success: function (data) {
			//$('#requestorDetailsrequestorID').val(data.requestorID);
			$('#requestorDetailsrequestorFullName').val(data.fullName);
			$('#requestorDetailsrequestordepartment').val(data.department);
			$('#requestorDetailsrequestorposition').val(data.position);
			$('#requestorDetailsrequestorMobile').val(data.mobile);
			$('#requestorDetailsrequestorEmail').val(data.email);
			$('#requestorDetailsrequestorAddress').val(data.address);
			$('#requestorDetailsStatus').val(data.status).trigger("chosen:updated");
		}
	});
}

// USERS
// Function to send usersID so that users details can be pulled from db
// to be displayed on users details tab
function getusersDetailsToPopulate() {
	// Get the usersID entered in the text box
	var id = $('#id').val();

	// Call the populateItemDetails.php script to get item details
	// relevant to the itemNumber which the user entered
	$.ajax({
		url: 'model/users/populateusersDetails.php',
		method: 'POST',
		data: { usersID: id },
		dataType: 'json',
		success: function (data) {
			//$('#id').val(data.usersID);
			$('#usersDetailsusersname').val(data.name);
			$('#usersDetailsusersemail').val(data.email);
			$('#usersDetailsusersuser_type').val(data.user_type);
			$('#usersDetailsuserspassword').val(data.password);
			$('#usersDetailsusersimage').val(data.image);
		}
	});
}



// Function to send requestorID so that requestor details can be pulled from db
// to be displayed on pullout details tab
function getrequestorDetailsToPopulatepulloutTab() {
	// Get the requestorID entered in the text box
	var requestorDetailsrequestorID = $('#pulloutDetailsrequestorID').val();

	// Call the populaterequestorDetails.php script to get requestor details
	// relevant to the requestorID which the user entered
	$.ajax({
		url: 'model/requestor/populaterequestorDetails.php',
		method: 'POST',
		data: { requestorID: requestorDetailsrequestorID },
		dataType: 'json',
		success: function (data) {
			//$('#pulloutDetailsrequestorID').val(data.requestorID);
			$('#pulloutDetailsrequestorName').val(data.fullName);
			$('#pulloutDetailsrequestorDepartment').val(data.department);

		}
	});
}

// Function to send requestorID so that requestor details can be pulled from db
// to be displayed on return details tab
function getrequestorDetailsToPopulatereturnTab() {
	// Get the requestorID entered in the text box
	var requestorDetailsrequestorID = $('#returnDetailsrequestorID').val();

	// Call the populaterequestorDetails.php script to get requestor details
	// relevant to the requestorID which the user entered
	$.ajax({
		url: 'model/requestor/populaterequestorDetails.php',
		method: 'POST',
		data: { requestorID: requestorDetailsrequestorID },
		dataType: 'json',
		success: function (data) {
			//$('#returnDetailsrequestorID').val(data.requestorID);
			$('#returnDetailsrequestorName').val(data.fullName);
			$('#returnDetailsrequestorDepartment').val(data.department);
			$('#returnDetailsrequestorPosition').val(data.position);


		}
	});
}



// Function to send returnID so that return details can be pulled from db
// to be displayed on return details tab
function getreturnDetailsToPopulate() {
	// Get the returnID entered in the text box
	var returnDetailsreturnID = $('#returnDetailsreturnID').val();

	// Call the populatereturnDetails.php script to get item details
	// relevant to the itemNumber which the user entered
	$.ajax({
		url: 'model/return/populatereturnDetails.php',
		method: 'POST',
		data: { returnDetailsreturnID: returnDetailsreturnID },
		dataType: 'json',
		success: function (data) {
			//$('#returnDetailsreturnID').val(data.requestorID);
			$('#returnDetailsItemNumber').val(data.itemNumber);
			$('#returnDetailsrequestorID').val(data.requestorID);
			$('#returnDetailsreturnDate').val(data.returnDate);
			$('#returnDetailsrequestorName').val(data.requestorName);
			$('#returnDetailsrequestorDepartment').val(data.requestorDepartment);
			$('#returnDetailsrequestorPosition').val(data.requestorPosition);
			$('#returnDetailscategoryName').val(data.categoryName);
			$('#returnDetailsItemName').val(data.itemName);
			$('#returnDetailsfullName').val(data.fullName);
			$('#returnDetailsposition').val(data.position);
			$('#returnDetailsDescription').val(data.description);
			$('#returnDetailsQuantity').val(data.quantity);

		},
		complete: function () {
			calculateTotalInreturnTab();
			getItemStockToPopulate('returnDetailsItemNumber', getItemStockFile, 'returnDetailsCurrentStock');
		}
	});
}

// Function to send replenishID so that replenish details can be pulled from db
// to be displayed on replenish details tab
function getreplenishDetailsToPopulate() {
	// Get the replenishID entered in the text box
	var replenishDetailsreplenishID = $('#replenishDetailsreplenishID').val();

	// Call the populatereplenishDetails.php script to get item details
	// relevant to the itemNumber which the user entered
	$.ajax({
		url: 'model/replenish/populatereplenishDetails.php',
		method: 'POST',
		data: { replenishDetailsreplenishID: replenishDetailsreplenishID },
		dataType: 'json',
		success: function (data) {
			//$('#replenishDetailsreplenishID').val(data.requestorID);
			$('#replenishDetailsItemNumber').val(data.itemNumber);
			$('#replenishDetailsreplenishDate').val(data.replenishDate);
			$('#replenishDetailscategoryName').val(data.categoryName);
			$('#replenishDetailsItemName').val(data.itemName);
			$('#replenishDetailsDescription').val(data.description);
			$('#replenishDetailsQuantity').val(data.quantity);

		},
		complete: function () {
			calculateTotalInreplenishTab();
			getItemStockToPopulate('replenishDetailsItemNumber', getItemStockFile, 'replenishDetailsCurrentStock');
		}
	});
}


// Function to send pulloutID so that pullout details can be pulled from db
// to be displayed on pullout details tab
function getpulloutDetailsToPopulate() {
	// Get the pulloutID entered in the text box
	var pulloutDetailspulloutID = $('#pulloutDetailspulloutID').val();

	// Call the populatepulloutDetails.php script to get item details
	// relevant to the itemNumber which the user entered
	$.ajax({
		url: 'model/pullout/populatepulloutDetails.php',
		method: 'POST',
		data: { pulloutDetailspulloutID: pulloutDetailspulloutID },
		dataType: 'json',
		success: function (data) {
			//$('#pulloutDetailspulloutID').val(data.pulloutID);
			$('#pulloutDetailsItemNumber').val(data.itemNumber);
			$('#pulloutDetailsrequestorID').val(data.requestorID);
			$('#pulloutDetailsrequestorName').val(data.requestorName);
			$('#pulloutDetailsrequestorDepartment').val(data.requestorDepartment);
			$('#pulloutDetailscategoryName').val(data.categoryName);
			$('#pulloutDetailsItemName').val(data.itemName);
			$('#pulloutDetailspulloutDate').val(data.pulloutDate);
			$('#pulloutDetailsdescription').val(data.description);
			$('#pulloutDetailsQuantity').val(data.quantity);
		},
		complete: function () {
			getItemStockToPopulate('pulloutDetailsItemNumber', getItemStockFile, 'pulloutDetailsTotalStock');
		}
	});
}


// Function to call the upateItemDetails.php script to UPDATE item data in db
function updateItem() {
	var itemDetailsItemNumber = $('#itemDetailsItemNumber').val();
	var itemDetailscategoryName = $('#itemDetailscategoryName').val();
	var itemDetailsItemName = $('#itemDetailsItemName').val();
	var itemDetailsQuantity = $('#itemDetailsQuantity').val();
	var itemDetailsStatus = $('#itemDetailsStatus').val();
	var itemDetailsDescription = $('#itemDetailsDescription').val();

	$.ajax({
		url: 'model/item/updateItemDetails.php',
		method: 'POST',
		data: {
			itemNumber: itemDetailsItemNumber,
			itemDetailscategoryName: itemDetailscategoryName,
			itemDetailsItemName: itemDetailsItemName,
			itemDetailsQuantity: itemDetailsQuantity,
			itemDetailsStatus: itemDetailsStatus,
			itemDetailsDescription: itemDetailsDescription,
		},
		success: function (data) {
			var result = $.parseJSON(data);
			$('#itemDetailsMessage').fadeIn();
			$('#itemDetailsMessage').html(result.alertMessage);
			if (result.newStock != null) {
				$('#itemDetailsTotalStock').val(result.newStock);
			}
		},
		complete: function () {
			searchTableCreator('itemDetailsTableDiv', itemDetailsSearchTableCreatorFile, 'itemDetailsTable');
			searchTableCreator('returnDetailsTableDiv', returnDetailsSearchTableCreatorFile, 'returnDetailsTable');
			searchTableCreator('replenishDetailsTableDiv', replenishDetailsSearchTableCreatorFile, 'replenishDetailsTable');
			searchTableCreator('pulloutDetailsTableDiv', pulloutDetailsSearchTableCreatorFile, 'pulloutDetailsTable');
			reportsTableCreator('itemReportsTableDiv', itemReportsSearchTableCreatorFile, 'itemReportsTable');
			reportsreturnTableCreator('returnReportsTableDiv', returnReportsSearchTableCreatorFile, 'returnReportsTable');
			reportsreplenishTableCreator('replenishReportsTableDiv', replenishReportsSearchTableCreatorFile, 'replenishReportsTable');
			reportspulloutTableCreator('pulloutReportsTableDiv', pulloutReportsSearchTableCreatorFile, 'pulloutReportsTable');
		}
	});
}


// Function to call the upaterequestorDetails.php script to UPDATE requestor data in db
function updaterequestor() {
	var requestorDetailsrequestorID = $('#requestorDetailsrequestorID').val();
	var requestorDetailsrequestorFullName = $('#requestorDetailsrequestorFullName').val();
	var requestorDetailsrequestordepartment = $('#requestorDetailsrequestordepartment').val();
	var requestorDetailsrequestorposition = $('#requestorDetailsrequestorposition').val();
	var requestorDetailsrequestorMobile = $('#requestorDetailsrequestorMobile').val();
	var requestorDetailsrequestorAddress = $('#requestorDetailsrequestorAddress').val();
	var requestorDetailsrequestorEmail = $('#requestorDetailsrequestorEmail').val();
	var requestorDetailsStatus = $('#requestorDetailsStatus option:selected').text();

	$.ajax({
		url: 'model/requestor/updaterequestorDetails.php',
		method: 'POST',
		data: {
			requestorDetailsrequestorID: requestorDetailsrequestorID,
			requestorDetailsrequestorFullName: requestorDetailsrequestorFullName,
			requestorDetailsrequestordepartment: requestorDetailsrequestordepartment,
			requestorDetailsrequestorposition: requestorDetailsrequestorposition,
			requestorDetailsrequestorMobile: requestorDetailsrequestorMobile,
			requestorDetailsrequestorAddress: requestorDetailsrequestorAddress,
			requestorDetailsrequestorEmail: requestorDetailsrequestorEmail,
			requestorDetailsStatus: requestorDetailsStatus,
		},
		success: function (data) {
			$('#requestorDetailsMessage').fadeIn();
			$('#requestorDetailsMessage').html(data);
		},
		complete: function () {
			searchTableCreator('requestorDetailsTableDiv', requestorDetailsSearchTableCreatorFile, 'requestorDetailsTable');
			reportsTableCreator('requestorReportsTableDiv', requestorReportsSearchTableCreatorFile, 'requestorReportsTable');
			searchTableCreator('pulloutDetailsTableDiv', pulloutDetailsSearchTableCreatorFile, 'pulloutDetailsTable');
			reportspulloutTableCreator('pulloutReportsTableDiv', pulloutReportsSearchTableCreatorFile, 'pulloutReportsTable');
		}
	});
}

// USERS
// Function to call the upateusersDetails.php script to UPDATE users data in db
function updateusers() {
	var id = $('#id').val();
	var usersDetailsusersname = $('#usersDetailsusersname').val();
	var usersDetailsusersemail = $('#usersDetailsusersemail').val();
	var usersDetailsusersuser_type = $('#usersDetailsusersuser_type').val();
	var usersDetailsuserspassword = $('#usersDetailsuserspassword').val();
	var usersDetailsusersimage = $('#usersDetailsusersimage').val();

	$.ajax({
		url: 'model/users/updateusersDetails.php',
		method: 'POST',
		data: {
			id: id,
			usersDetailsusersname: usersDetailsusersname,
			usersDetailsusersemail: usersDetailsusersemail,
			usersDetailsusersuser_type: usersDetailsusersuser_type,
			usersDetailsuserspassword: usersDetailsuserspassword,
			usersDetailsusersimage: usersDetailsusersimage,
		},
		success: function (data) {
			$('#usersDetailsMessage').fadeIn();
			$('#usersDetailsMessage').html(data);
		},
		complete: function () {
			searchTableCreator('usersDetailsTableDiv', usersDetailsSearchTableCreatorFile, 'usersDetailsTable');
			reportsTableCreator('usersReportsTableDiv', usersReportsSearchTableCreatorFile, 'usersReportsTable');
			searchTableCreator('pulloutDetailsTableDiv', pulloutDetailsSearchTableCreatorFile, 'pulloutDetailsTable');
			reportspulloutTableCreator('pulloutReportsTableDiv', pulloutReportsSearchTableCreatorFile, 'pulloutReportsTable');
		}
	});
}




// Function to call the updatereturn.php script to update return data to db
function updatereturn() {
	var returnDetailsItemNumber = $('#returnDetailsItemNumber').val();
	var returnDetailsrequestorID = $('#returnDetailsrequestorID').val();
	var returnDetailsreturnDate = $('#returnDetailsreturnDate').val();
	var returnDetailsrequestorName = $('#returnDetailsrequestorName').val();
	var returnDetailsrequestorDepartment = $('#returnDetailsrequestorDepartment').val();
	var returnDetailsrequestorposition = $('#returnDetailsrequestorposition').val();
	var returnDetailscategoryName = $('#returnDetailscategoryName').val();
	var returnDetailsItemName = $('#returnDetailsItemName').val();
	var returnDetailsQuantity = $('#returnDetailsQuantity').val();
	var returnDetailsDescription = $('#returnDetailsDescription').val();
	var returnDetailsreturnID = $('#returnDetailsreturnID').val();

	$.ajax({
		url: 'model/return/updatereturn.php',
		method: 'POST',
		data: {
			returnDetailsItemNumber: returnDetailsItemNumber,
			returnDetailsrequestorID: returnDetailsrequestorID,
			returnDetailsreturnDate: returnDetailsreturnDate,
			returnDetailsrequestorfullName: returnDetailsrequestorfullName,
			returnDetailsrequestorDepartment: returnDetailsrequestorDepartment,
			returnDetailsrequestorposition: returnDetailsrequestorposition,
			returnDetailscategoryName: returnDetailscategoryName,
			returnDetailsItemName: returnDetailsItemName,
			returnDetailsDescription: returnDetailsDescription,
			returnDetailsQuantity: returnDetailsQuantity,
		},
		success: function (data) {
			$('#returnDetailsMessage').fadeIn();
			$('#returnDetailsMessage').html(data);
		},
		complete: function () {
			getItemStockToPopulate('returnDetailsItemNumber', getItemStockFile, 'returnDetailsCurrentStock');
			searchTableCreator('returnDetailsTableDiv', returnDetailsSearchTableCreatorFile, 'returnDetailsTable');
			reportsreturnTableCreator('returnReportsTableDiv', returnReportsSearchTableCreatorFile, 'returnReportsTable');
			searchTableCreator('itemDetailsTableDiv', itemDetailsSearchTableCreatorFile, 'itemDetailsTable');
			reportsTableCreator('itemReportsTableDiv', itemReportsSearchTableCreatorFile, 'itemReportsTable');
		}
	});
}

// Function to call the updatereplenish.php script to update replenish data to db
function updatereplenish() {
	var replenishDetailsItemNumber = $('#replenishDetailsItemNumber').val();
	var replenishDetailsreplenishDate = $('#replenishDetailsreplenishDate').val();
	var replenishDetailscategoryName = $('#replenishDetailscategoryName').val();
	var replenishDetailsItemName = $('#replenishDetailsItemName').val();
	var replenishDetailsQuantity = $('#replenishDetailsQuantity').val();
	var replenishDetailsDescription = $('#replenishDetailsDescription').val();
	var replenishDetailsreplenishID = $('#replenishDetailsreplenishID').val();

	$.ajax({
		url: 'model/replenish/updatereplenish.php',
		method: 'POST',
		data: {
			replenishDetailsItemNumber: replenishDetailsItemNumber,
			replenishDetailsreplenishDate: replenishDetailsreplenishDate,
			replenishDetailscategoryName: replenishDetailscategoryName,
			replenishDetailsItemName: replenishDetailsItemName,
			replenishDetailsDescription: replenishDetailsDescription,
			replenishDetailsQuantity: replenishDetailsQuantity,
		},
		success: function (data) {
			$('#replenishDetailsMessage').fadeIn();
			$('#replenishDetailsMessage').html(data);
		},
		complete: function () {
			getItemStockToPopulate('replenishDetailsItemNumber', getItemStockFile, 'replenishDetailsCurrentStock');
			searchTableCreator('replenishDetailsTableDiv', replenishDetailsSearchTableCreatorFile, 'replenishDetailsTable');
			reportsreplenishTableCreator('replenishReportsTableDiv', replenishReportsSearchTableCreatorFile, 'replenishReportsTable');
			searchTableCreator('itemDetailsTableDiv', itemDetailsSearchTableCreatorFile, 'itemDetailsTable');
			reportsTableCreator('itemReportsTableDiv', itemReportsSearchTableCreatorFile, 'itemReportsTable');
		}
	});
}


// Function to call the updatepullout.php script to update pullout data to db
function updatepullout() {
	var pulloutDetailsItemNumber = $('#pulloutDetailsItemNumber').val();
	var pulloutDetailsrequestorID = $('#pulloutDetailsrequestorID').val();
	var pulloutDetailsrequestorName = $('#pulloutDetailsrequestorName').val();
	var pulloutDetailsrequestorDepartment = $('#pulloutDetailsrequestorDepartment').val();
	var pulloutDetailscategoryName = $('#pulloutDetailscategroyName').val();
	var pulloutDetailsItemName = $('#pulloutDetailsItemName').val();
	var pulloutDetailspulloutDate = $('#pulloutDetailspulloutDate').val();
	var pulloutDetailsQuantity = $('#pulloutDetailsQuantity').val();
	var pulloutDetailspulloutID = $('#pulloutDetailspulloutID').val();

	$.ajax({
		url: 'model/pullout/updatepullout.php',
		method: 'POST',
		data: {
			pulloutDetailsItemNumber: pulloutDetailsItemNumber,
			pulloutDetailsrequestorID: pulloutDetailsrequestorID,
			pulloutDetailsrequestorName: pulloutDetailsrequestorName,
			pulloutDetailsrequestorDepartment: pulloutDetailsrequestorDepartment,
			pulloutDetailscategoryName: pulloutDetailscategoryName,
			pulloutDetailsItemName: pulloutDetailsItemName,
			pulloutDetailspulloutDate: pulloutDetailspulloutDate,
			pulloutDetailsdescription: pulloutDetailsdescription,
			pulloutDetailsQuantity: pulloutDetailsQuantity,
			pulloutDetailspulloutID: pulloutDetailspulloutID,
		},
		success: function (data) {
			$('#pulloutDetailsMessage').fadeIn();
			$('#pulloutDetailsMessage').html(data);
		},
		complete: function () {
			getItemStockToPopulate('pulloutDetailsItemNumber', getItemStockFile, 'pulloutDetailsTotalStock');
			searchTableCreator('pulloutDetailsTableDiv', pulloutDetailsSearchTableCreatorFile, 'pulloutDetailsTable');
			reportspulloutTableCreator('pulloutReportsTableDiv', pulloutReportsSearchTableCreatorFile, 'pulloutReportsTable');
			searchTableCreator('itemDetailsTableDiv', itemDetailsSearchTableCreatorFile, 'itemDetailsTable');
			reportsTableCreator('itemReportsTableDiv', itemReportsSearchTableCreatorFile, 'itemReportsTable');
		}
	});
}