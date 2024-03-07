$(document).ready(function () {
    $(document).on('click', '.bookingDetails', function () {
        
        var bookingId = $(this).data("id");
        
        $.ajax({
            type: "GET",
            url: "/admin/bookings/bookingDetails",
            data: { bookingId: bookingId },
            success: function (response) {
                $("#displayDetails").html(response);
                $("#bookingDetails").modal("show");
            },
            error: function () {
                console.error("Error fetching data");
            }
        });
    });
    $(document).on('click', '#updateStatus', function () {
        const id = $(this).data('id');
        const row = $(this).closest('tr');
        const table = $('#bookings').DataTable();

        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: true,
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '/admin/bookings/updateStatus/' + id,
                    method: 'GET',
                    success: function (response) {
                        if (response.status === 'success') {
                            table.row(row).remove().draw(false);
                        }
                    }
                });
            }
        });
    });
    $(document).on('click', '#print', function () {
        var printContents = document.getElementById('printBookingDetails').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();

        document.body.innerHTML = originalContents;
    });
    $(document).on('click', '#reschedule', function () {
        // Get the data from the button attributes
        var accountId = $(this).data('account-id');
        var bookingId = $(this).data('id');

        // Prepare the data to be sent
        var requestData = {
            account_id: accountId,
            booking_id: bookingId
        };

        // Make the Ajax request
        $.ajax({
            type: 'POST',  // You can change this to 'GET' or any other method based on your server-side implementation
            url: '/bookings/reSchedule/' + bookingId + '/' + accountId,  // Replace with your actual controller URL
            data: requestData,
            dataType: 'json',
            beforeSend: function() {
                $('#loading').css('display', 'flex');
            },
            complete: function(){
                $('#loading').css('display', 'none');
            },
            success: function(response) {
                // Log the entire response for debugging
                console.log('Full response:', response);
            
                // Check if the response has the expected structure
                if (response && response.status === 'success') {
                    // Handle the success case
                    console.log('Reschedule email has been sent!');
                    swal({
                        type: 'success',
                        title: 'Success',
                        text: 'Reschedule email has been sent!',
                    });
                } else {
                    // Handle the case where the response does not have the expected structure
                    console.error('Unexpected response format:', response);
                    swal({
                        type: 'error',
                        title: 'Error',
                        text: 'Unexpected response format. Please check the console for details.',
                    });
                }
            },
            error: function(error) {
                // Handle the error response from the server
                console.error('Ajax request failed', error);

                // You can do additional error handling here
            }
        });
    });
    $(document).on('click', '#dropOff', function () {
        // Get the data from the button attributes
        var accountId = $(this).data('account-id');
        var bookingId = $(this).data('id');

        // Prepare the data to be sent
        var requestData = {
            account_id: accountId,
            booking_id: bookingId
        };

        // Make the Ajax request
        $.ajax({
            type: 'POST',  // You can change this to 'GET' or any other method based on your server-side implementation
            url: '/bookings/dropOff/' + bookingId + '/' + accountId,  // Replace with your actual controller URL
            data: requestData,
            dataType: 'json',
            beforeSend: function() {
                $('#loading').css('display', 'flex');
            },
            complete: function(){
                $('#loading').css('display', 'none');
            },
            success: function(response) {
                // Handle the success response from the server
                console.log('Ajax request successful', response);
                swal({
                    type: 'success',
                    title: 'Success',
                    text: 'Drop Off Notification email has been sent!',
                });
                // You can do additional actions here if needed
            },
            error: function(error) {
                // Handle the error response from the server
                console.error('Ajax request failed', error);

                // You can do additional error handling here
            }
        });
    });
    $(document).on('click', '#pickUp', function () {
        // Get the data from the button attributes
        var accountId = $(this).data('account-id');
        var bookingId = $(this).data('id');

        // Prepare the data to be sent
        var requestData = {
            account_id: accountId,
            booking_id: bookingId
        };

        // Make the Ajax request
        $.ajax({
            type: 'POST',  // You can change this to 'GET' or any other method based on your server-side implementation
            url: '/bookings/pickUp/' + bookingId + '/' + accountId,  // Replace with your actual controller URL
            data: requestData,
            dataType: 'json',
            beforeSend: function() {
                $('#loading').css('display', 'flex');
            },
            complete: function(){
                $('#loading').css('display', 'none');
            },
            success: function(response) {
                // Handle the success response from the server
                console.log('Ajax request successful', response);
                swal({
                    type: 'success',
                    title: 'Success',
                    text: 'Pick Up Notification email has been sent!',
                });
                // You can do additional actions here if needed
            },
            error: function(error) {
                // Handle the error response from the server
                console.error('Ajax request failed', error);

                // You can do additional error handling here
            }
        });
    });
    $('#exportCsv').on('click', function () {
        var selectedIds = [];
        
        $('#bookings tbody input[type="checkbox"]:checked').each(function () {
            selectedIds.push($(this).val());
        });
        
        var exportUrl = '/admin/bookings/exportToCsv';
        
        if (selectedIds.length > 0) {
            exportUrl += '?selectedIds=' + selectedIds.join(',');
        }
        
        window.location.href = exportUrl;
    });  
    $(document).on('click', '.print-btn', function () {
        const bookingId = $(this).data('id');
        const accountInformationId = $(this).data('account-id');
        $('#exportFrame').attr('src', '/admin/bookings/exportToExcel?bookingId=' + bookingId + '&accountInformationId=' + accountInformationId);
    });  
});
function validateInteger(element) {
    element.innerText = element.innerText.replace(/[^\d]/g, '');
    
    const parsedValue = parseInt(element.innerText, 10);
    
    if (parsedValue > 10) {
        element.innerText = '10';
    }
    updateTotalAmount(element);
}
function updateRowInWarehouse(value) {
    $.ajax({
        type: "POST",
        url: "/admin/bookingdetails/updateRowInWarehouse", // Replace with your actual URL
        data: { booking_id: booking_id, row_in_warehouse: value },
        success: function(response) {
            // Handle the success response
            console.log(response);
        },
        error: function(error) {
            // Handle the error
            console.error(error);
        }
    });
}
function deleteRow(link) {
    var row = link.closest("tr"); // Get the closest <tr> parent element
    var bookingItemId = row.querySelector("input[name='booking_item_id']").value;

    // Perform Ajax request to delete the item
    $.ajax({
        type: "POST",
        url: "/admin/bookingdetails/deleteBookingItem", // Replace with your actual URL
        data: { booking_id: booking_id, booking_item_id: bookingItemId },
        success: function(response) {
            // Handle the success response
            console.log(response);

            // Remove the row from the table
            row.remove();
            
            // Update the total amount if needed
            updateTotalAmount();
            finalTotalAmount();
        },
        error: function(error) {
            // Handle the error
            console.error(error);
        }
    });
}

function updateTotalAmount() {
    // Sum the total amounts of each row
    var totalAmountSum = 0;

    // Iterate through each row with the class 'totalAmount'
    $(".totalAmount").each(function () {
        // Extract the numeric value from the text content
        var amount = parseFloat($(this).text().replace("$", ""));
        
        // Check if the value is a valid number
        if (!isNaN(amount)) {
            totalAmountSum += amount;
        }
    });

    // Update the total amount row
    $("#totalAmountRow").text("$" + totalAmountSum.toFixed(2));
    console.log("Total amount updated");
}

function finalTotalAmount() {
    $.ajax({
        type: "POST",
        url: "/admin/bookingdetails/finalTotalAmount", // Replace with your actual URL
        data: { booking_id: booking_id },
        success: function(response) {
            // Handle the success response
            $('#overAllTotalAmount').text(response);
        },
        error: function(error) {
            // Handle the error
            console.error(error);
        }
    });
}

// Call the updateTotalAmount function whenever needed
finalTotalAmount();

$(document).ready(function () {
    // Datepicker for pickUpDate
    $("#pickUpDate").datepicker({
        format: 'yyyy-mm-dd',
    }).on("changeDate", function (e) {
        var picking_date = $('#pickUpDate').val();
        updatePickUpDate(picking_date);
    });

    // Timepicker for pickUpTime
    $('#pickUpTime').timepicker({
        controlType: 'select',
        oneLine: true,
        interval: 30,
        minTime: '7:00am',
        maxTime: '6:00pm',
        change: function(time) {
            // Handle the time change here
            console.log("Selected time: ", time);
            // Trigger the Ajax request
            // Trigger the Ajax request
            var picking_time = $('#pickUpTime').val();
            updatePickUpTime(picking_time);
        }
    });

    // Function to update pickUpDate via Ajax
    function updatePickUpDate(picking_date) {
        $.ajax({
            type: "POST",
            url: "/admin/bookingdetails/updatePickUpDate", // Replace with your actual URL
            data: { booking_id: booking_id, picking_date: picking_date },
            success: function(response) {
                // Handle the success response
                console.log(response);
            },
            error: function(error) {
                // Handle the error
                console.error(error);
            }
        });
    }

    // Function to update pickUpTime via Ajax
    function updatePickUpTime(picking_time) {
        $.ajax({
            type: "POST",
            url: "/admin/bookingdetails/updatePickUpTime", // Replace with your actual URL
            data: { booking_id: booking_id, picking_time: picking_time },
            success: function(response) {
                // Handle the success response
                console.log(response);
            },
            error: function(error) {
                // Handle the error
                console.error(error);
            }
        });
    }
    $('#item_id').change(function () {
        var itemId = $(this).val();
        $.ajax({
            url: '/admin/bookingdetails/getSizes', // Replace with the correct controller and method
            method: 'GET',
            data: {item_id: itemId},
            dataType: 'json',
            success: function (response) {
                // Clear existing options
                $('#size_id').empty();
                
                // Add new options based on the response
                $('#size_id').append('<option></option>');
                $.each(response, function (index, size) {
                    $('#size_id').append('<option value="' + size.size_id + '">' + size.size + '</option>');
                });
                updateNewItemTotalAmount();
                $('#size_id').trigger('chosen:updated');
            },
            error: function (error) {
                console.log(error);
            }
        });
    });
    $('#size_id').change(function () {
        var sizeId = $(this).val();
        $.ajax({
            url: '/admin/bookingdetails/sizeAmount',
            method: 'GET',
            data: {size_id: sizeId},
            dataType: 'json',
            success: function (response) {
                $('#newItemAmount').text(response.cost);
                updateNewItemTotalAmount();
            },
            error: function (error) {
                console.log(error);
            }
        });
    });
    function updateNewItemTotalAmount() {
        var quantity = parseInt($('#quantity').val()) || 0; // Get quantity, default to 0 if not a valid number
        var itemCost = parseFloat($('#newItemAmount').text().replace('$', '')) || 0; // Get item cost, default to 0 if not a valid number
        var totalAmount = quantity * itemCost;
    
        // Update the total amount in the HTML
        $('#newItemTotalAmount').text('$' + totalAmount.toFixed(2));
    }
    $('#quantity').on('input', function () {
        // Update the total amount when quantity changes
        updateNewItemTotalAmount();
    });
});
$('a.checkmark').click(function () {
    var item_id = $('#item_id').val();
    var size_id = $('#size_id').val();
    var quantity = $('#quantity').val();
    var newItemAmount = $('#newItemAmount').text();
    var newItemTotalAmount = parseFloat($('#newItemTotalAmount').text().replace('$', '')) || 0;
    var date = new Date();
    $.ajax({
        url: '/admin/bookingdetails/insertBookingDetails',
        method: 'POST',
        data: {
            booking_id: booking_id,
            item_id: item_id,
            size_id: size_id,
            quantity: quantity,
            price: newItemAmount,
            totalamount: newItemTotalAmount,
        },
        dataType: 'json',
        success: function (response) {
            console.log(response);
            var newRow = '<tr>' +
                '<td style="font-weight: bold;">' + response.item_name + '</td>' +
                '<td style="font-weight: bold;">' + response.size + '</td>' +
                '<td><input type="number" onkeydown="return false;" class="form-control" value="' + response.quantity + '"></td>' +
                '<td>' + response.price + '</td>' +
                '<td>' + date + '</td>' +
                '<td class="totalAmount">$' + response.totalamount + '</td>' +
                '<td hidden><input type="text" name="booking_item_id" id="booking_item_id" value="' + response.booking_item_id + '" /></td>' +
                '<td><a href="javascript:" style="color: red; font-size: 20px;" onclick="deleteRow(this);"><i class="fa fa-trash"></i></a></td>' +
                '</tr>';

            // Insert the new row before the row with the "Select an Item" dropdown
            $('#item_id').closest('tr').before(newRow);
            updateTotalAmount();
            finalTotalAmount();
        },
        error: function (error) {
            console.log(error);
        }
    });
});
$('.orig_quantity').on('input', function () {
    var row = $(this).closest('tr');
    var bookingItemId = row.find('.booking_item_id').val();
    var newQuantity = $(this).val();

    updateItemDetails(bookingItemId, newQuantity, row);
});

function updateItemDetails(bookingItemId, newQuantity, row) {
    $.ajax({
        url: '/admin/bookingdetails/updateBookingItemDetails',
        method: 'POST',
        data: {
            booking_id: booking_id,
            booking_item_id: bookingItemId,
            new_quantity: newQuantity,
        },
        dataType: 'json',
        success: function (response) {
            // Update the displayed quantity and total amount in the HTML for the specific row
            row.find('.orig_quantity').val(response.new_quantity);
            row.find('.totalAmount').text('$' + response.new_total_amount.toFixed(2));
            updateTotalAmount();
            finalTotalAmount();
            // You can add any other logic or visual updates here
        },
        error: function (error) {
            console.log(error);
        }
    });
}
$('#admin_notes').on('input', function () {
    var adminNotes = $(this).val();

    updateAdminNotes(booking_id, adminNotes);
});

function updateAdminNotes(bookingId, adminNotes) {
    $.ajax({
        url: '/admin/bookingdetails/updateAdminNotes',
        method: 'POST',
        data: {
            booking_id: bookingId,
            admin_notes: adminNotes,
        },
        dataType: 'json',
        success: function (response) {
            // You can handle success, e.g., show a success message
            console.log(response);
        },
        error: function (error) {
            console.log(error);
        }
    });
}
function updateDatabase(checkbox) {
    var isChecked = checkbox.checked;
    var bookingItemId = checkbox.id.replace('is_balanced', '');

    // Send AJAX request
    $.ajax({
        type: 'POST',
        url: '/admin/bookingdetails/updateBalanceStatus', // Update with your actual controller method URL
        data: {
            booking_item_id: bookingItemId,
            is_checked: isChecked
        },
        success: function(response) {
            console.log('Database updated successfully');
        },
        error: function(error) {
            console.error('Error updating database');
        }
    });
}