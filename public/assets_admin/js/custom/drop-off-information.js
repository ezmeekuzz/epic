$(document).ready(function () {
    // Initialize the datepicker for the returnDate field
    $('#returnDate').datepicker({
        dateFormat: 'yy-mm-dd', // Set the desired date format
        minDate: 0, // Set the minimum date to today
    });
    
    $('#drop-off-information').submit(function (event) {
        event.preventDefault();

        var formData = new FormData(this);

        // Validate required fields
        var requiredFields = ['firstName', 'lastName', 'studentNumber', 'dorm_id', 'roomNumber', 'returnDate'];
        for (var i = 0; i < requiredFields.length; i++) {
            var field = $('#' + requiredFields[i]);
            if (!field.val()) {
                Swal.fire({
                    title: "Warning",
                    text: "Fields should not be empty!",
                    icon: "error"
                });
                return;
            }
        }

        $.ajax({
            url: "/dropoff/update",
            method: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('#loading').css('display', 'flex');
            },
            complete: function () {
                $('#loading').css('display', 'none');
            },
            success: function (response) {
                if (response.status === 'success') {
                    $("#drop-off-information")[0].reset();
                    Swal.fire({
                        title: "Success",
                        text: response.message,
                        icon: "success"
                    }).then(() => {
                        window.location.href = '/services';
                    });
                } else {
                    Swal.fire({
                        title: "Ooppps",
                        text: response.message,
                        icon: "error"
                    });
                }
            },
            error: function () {
                alert('Error occurred while inserting data.');
            }
        });
    });

    // Listen for changes in the dorm_id select element
    $('#dorm_id').on('change', function () {
        var selectedDorm = $(this).val();

        // Enable or disable fields based on dorm selection
        $('#street_name, #street_number, #dorm_room_number').prop('readonly', !selectedDorm);
        $('#street_name, #street_number, #dorm_room_number').prop('disabled', !selectedDorm);

        // Clear fields if dorm is not selected
        if (!selectedDorm) {
            $('#street_name, #street_number, #dorm_room_number').val('');
        }
    });
});
