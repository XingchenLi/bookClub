

/* Display a table of users */
function bookTable(box_id, options) {
	options = typeof options !== 'undefined' ? options : {};

	var data = options;
	data['ajaxMode'] = true;

	// Generate the form
	$.ajax({
	  type: "GET",
	  url: FORMSPATH + "table_books.php",
	  data: data,
	  dataType: 'json',
	  cache: false
	})
	.fail(function(result) {
		addAlert("danger", "Oops, looks like our server might have goofed.  If you're an admin, please check the PHP error logs.");
		alertWidget('display-alerts');
	})
	.done(function(result) {
		$('#' + box_id).html(result['data']);

		// define pager options
		var pagerOptions = {
		  // target the pager markup - see the HTML block below
		  container: $('#' + box_id + ' .pager'),
		  // output string - default is '{page}/{totalPages}'; possible variables: {page}, {totalPages}, {startRow}, {endRow} and {totalRows}
		  output: '{startRow} - {endRow} / {filteredRows} ({totalRows})',
		  // if true, the table will remain the same height no matter how many records are displayed. The space is made up by an empty
		  // table row set to a height to compensate; default is false
		  fixedHeight: true,
		  // remove rows from the table to speed up the sort of large tables.
		  // setting this to false, only hides the non-visible rows; needed if you plan to add/remove rows with the pager enabled.
		  removeRows: false,
		  size: 10,
		  // go to page selector - select dropdown that sets the current page
		  cssGoto: '.gotoPage'
		};

		// Initialize the tablesorter
		$('#' + box_id + ' .table').tablesorter({
			debug: false,
			theme: 'bootstrap',
			widthFixed: true,
			widgets: ['filter']
		}).tablesorterPager(pagerOptions);

		// Link buttons
		$('#' + box_id + ' .btn-add-book').click(function() {
		  bookUpload();
		});

		$('#' + box_id + ' .btn-edit-book').click(function() {
            var btn = $(this);
            var book_id = btn.data('id');
			bookForm('book-update-dialog', book_id);
		});

		$('#' + box_id + ' .btn-delete-book').click(function() {
			var btn = $(this);
            var book_id = btn.data('id');
			var book_name = btn.data('book_name');
			deleteBookDialog('book-delete-dialog', book_id, book_name);
			$('#book-delete-dialog').modal('show');
		});
	});
}




/* Display a modal form for updating/creating a user */
function bookUpload(box_id, book_id) {
	alert('upload Functions');
	$('#' + box_id).modal('show');
}

// Display user info in a panel
function bookDisplay(box_id, book_id) {
	// Generate the form
	$.ajax({
	  type: "GET",
	  url: FORMSPATH + "form_books.php",
	  data: {
		box_id: box_id,
		render_mode: 'panel',
		book_id: book_id,
		ajaxMode: "true",
		fields: {
			'us_name' : {
				'display' : 'disabled'
			},
			'author_name' : {
				'display' : 'disabled'
			},
			'edition' : {
				'display' : 'disabled'
			},
			'password' : {
				'display' : 'hidden'
			},
			'passwordc' : {
				'display' : 'hidden'
			},
			'groups' : {
				'display' : 'disabled'
			}
		}
	  },
	  dataType: 'json',
	  cache: false
	})
	.fail(function(result) {
		addAlert("danger", "Oops, looks like our server might have goofed.  If you're an admin, please check the PHP error logs.");
		alertWidget('display-alerts');
	})
	.done(function(result) {
		$('#' + box_id).html(result['data']);

		// Initialize bootstrap switches for user groups
		var switches = $('#' + box_id + ' input[name="select_groups"]');
		switches.data('on-label', '<i class="fa fa-check"></i>');
		switches.data('off-label', '<i class="fa fa-times"></i>');
		switches.bootstrapSwitch();
		switches.bootstrapSwitch('setSizeClass', 'switch-mini' );

		// Initialize primary group buttons
		$(".bootstrapradio").bootstrapradio();

		// Link buttons
		$('#' + box_id + ' button[name="btn_edit"]').click(function() {
			bookForm('user-update-dialog', book_id);
		});

		$('#' + box_id + ' button[name="btn_activate"]').click(function() {
			activateUser(book_id);
		});

		$('#' + box_id + ' button[name="btn_enable"]').click(function () {
			updateUserEnabledStatus(book_id, true, $('#' + box_id + ' input[name="csrf_token"]' ).val());
		});

		$('#' + box_id + ' button[name="btn_disable"]').click(function () {
			updateUserEnabledStatus(book_id, false, $('#' + box_id + ' input[name="csrf_token"]' ).val());
		});

		$('#' + box_id + ' button[name="btn_delete"]').click(function() {
			var book_name = $(this).data('label');
			deleteBookDialog('delete-user-dialog', book_id, book_name);
			$('#delete-user-dialog').modal('show');
		});

	});
}

function deleteBookDialog(box_id, book_id, name){
	// Delete any existing instance of the form with the same name
	if($('#' + box_id).length ) {
		$('#' + box_id).remove();
	}

	var data = {
		box_id: box_id,
		edition: "Delete User",
		message: "Are you sure you want to delete the user " + name + "?",
		confirm: "Yes, delete user"
	}

	// Generate the form
	$.ajax({
	  type: "GET",
	  url: FORMSPATH + "form_book_delete.php",
	  data: data,
	  dataType: 'json',
	  cache: false
	})
	.fail(function(result) {
		addAlert("danger", "Oops, looks like our server might have goofed.  If you're an admin, please check the PHP error logs.");
		alertWidget('display-alerts');
	})
	.done(function(result) {
		if (result['errors']) {
			console.log("error");
			alertWidget('display-alerts');
			return;
		}

		// Append the form as a modal dialog to the body
		$( "body" ).append(result['data']);
		$('#' + box_id).modal('show');
	});
}
