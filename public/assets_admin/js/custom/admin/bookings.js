$(document).ready(function () {
    $('#bookings').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/admin/bookings/getData",
            "type": "POST"
        },
        "columns": [
            {
                "data": null,
                "render": function (data, type, row) {
                    return `
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="booking_id[]" id="inlineCheckbox1${row.booking_id}" value="${row.booking_id}">
                        <label class="form-check-label" for="inlineCheckbox1${row.booking_id}"></label>
                    </div>`;
                }
            },
            { "data": "serviceType" },
            { "data": "card_holder_name" },
            { "data": "booking_date" },
            { "data": "base_price" },
            { "data": "additional_box_quantity" },
            { "data": "addtl_box_total_amount" },
            { "data": "total_amount" },
            { "data": "status" },
            {
                "data": null,
                "render": function (data, type, row) {
                    return `
                    <a href="javascript:void(0);" class="delete-btn" data-id="${row.booking_id}" style="color: red;">
                        <i class="ti ti-trash" style="font-size: 18px;"></i>
                    </a>
                    <a href="javascript:void(0);" class="print-btn" data-id="${row.booking_id}" data-account-id="${row.account_information_id}" style="color: green;">
                        <i class="fa fa-file-excel-o" style="font-size: 18px;"></i>
                    </a>`;
                }
            }
        ],
        "columnDefs": [
            { "className": "bookingDetails", "targets": [1, 2, 3, 4, 5, 6, 7, 8] },
            { "targets": [1, 2, 3, 4, 5, 6, 7, 8], "createdCell": function (td, cellData, rowData, row, col) {
                $(td).attr('data-id', rowData.booking_id);
            }}
        ],
        "createdRow": function (row, data, dataIndex) {
            $(row).attr('data-id', data.booking_id);
        },
        "initComplete": function (settings, json) {
            $(this).trigger('dt-init-complete');
        }
    });
    $('#bookings').on('dt-init-complete', function () {
        $(this).show();
    });
    $(document).on('click', '.delete-btn', function () {
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
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: true,
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '/admin/bookings/delete/' + id,
                    method: 'DELETE',
                    success: function (response) {
                        if (response.status === 'success') {
                            table.row(row).remove().draw(false);
                        }
                    }
                });
            }
        });
    });
    $(document).on('click', '.bookingDetails', function () {
        
        var bookingId = $(this).data("id");
        
        window.location.href = "/admin/booking-details/" + bookingId;
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
});

$(document).ready(function () {
    $("#sendAllDropOffNotification").on("click", function () {
        // Show the progress bar
        $(".progress").show();

        // AJAX request to trigger the method
        $.ajax({
            type: "POST",
            url: "/admin/bookings/sendDropOffNotificationToAll",
            dataType: "json",
            beforeSend: function() {
                $('#loading').css('display', 'flex');
            },
            complete: function () {
                $('#loading').css('display', 'none');
            },
            success: function (response) {
                swal({
                    type: 'success',
                    title: 'Success',
                    text: 'Drop Off Notification email has been sent!',
                });
            },
            error: function (error) {
                console.error(error);
            }
        });
    });
    $("#sendAllPickUpNotification").on("click", function () {
        // Show the progress bar
        $(".progress").show();

        // AJAX request to trigger the method
        $.ajax({
            type: "POST",
            url: "/admin/bookings/sendPickUpNotificationToAll",
            dataType: "json",
            beforeSend: function() {
                $('#loading').css('display', 'flex');
            },
            complete: function () {
                $('#loading').css('display', 'none');
            },
            success: function (response) {
                swal({
                    type: 'success',
                    title: 'Success',
                    text: 'Pick Up Notification email has been sent!',
                });
            },
            error: function (error) {
                console.error(error);
            }
        });
    });
});
