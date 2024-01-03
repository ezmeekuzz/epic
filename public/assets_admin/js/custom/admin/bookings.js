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
                    <a href="javascript:void(0);" class="print-btn" data-id="${row.booking_id}" style="color: green;">
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
            confirmButtonText: 'Yes, delete it!',
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
        $('#exportFrame').attr('src', '/admin/bookings/exportToExcel?bookingId=' + bookingId);
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

function setDefaultIfEmpty(element) {
    const trimmedContent = element.innerText.trim();
    
    if (trimmedContent === '' || parseInt(trimmedContent, 10) === 0) {
        element.innerText = '1';
        updateTotalAmount(element);
    }
}

function updateTotalAmount(element) {
    
    const qty = parseInt(element.innerText, 10);
    const bookingId = document.getElementById('booking_id').value;
    const addtl_box_total_amount = document.getElementById('addtl_box_total_amount');
    const total_amount = document.getElementById('total_amount');
    
    fetch('/admin/bookings/updateTotalAmount', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ qty, bookingId }),
    })
    .then(response => response.json())
    .then(data => {
        addtl_box_total_amount.innerText = data.newAddtlTotalAmount;
        total_amount.innerText = data.newTotalAmount;
        console.log('Total amount updated:', data.totalAmount);
    })
    .catch(error => {
        console.error('Error updating total amount:', error);
    });
}

function validateDynamicInteger(element) {
    element.innerText = element.innerText.replace(/[^\d]/g, '');

    updateDynamicTotalAmount(element);
}
function setDynamicDefaultIfEmpty(element) {
    const trimmedContent = element.innerText.trim();
    
    if (trimmedContent === '' || parseInt(trimmedContent, 10) === 0) {
        element.innerText = '1';
        updateDynamicTotalAmount(element);
    }
}

function updateDynamicTotalAmount(element) {
    const qty = parseInt(element.innerText, 10);
    const bookingId = document.getElementById('booking_id').value;

    // Get the nearest input element with the name 'booking_item_id'
    const booking_item_id = element.closest('tr').querySelector('[name="booking_item_id"]').value;
    const totalAmountElement = element.closest('tr').querySelector('.totalAmount');
    const total_amount = document.getElementById('total_amount');

    fetch('/admin/bookings/updateDynamicTotalAmount', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ qty, bookingId, booking_item_id }),
    })
    .then(response => response.json())
    .then(data => {
        totalAmountElement.innerHTML = '$' + data.totalamount;
        total_amount.innerText = data.TotalAmount;
        console.log('Total amount updated:', data);
    })
    .catch(error => {
        console.error('Error updating total amount:', error);
    });
}


