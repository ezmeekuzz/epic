$(function() {    
    $('#account-information').submit(function(event) {
        event.preventDefault();

        var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();
        var student_id = $('#student_id').val();
        var phone_number = $('#phone_number').val();
        var email_address = $('#email_address').val();
        var password = $('#password').val();
        var dorm_id = $('#dorm_id').val();
        var dorm_room_number = $('#dorm_room_number').val();
        var parent_phone_number = $('#parent_phone_number').val();
        var parent_email_address = $('#parent_email_address').val();

        if(!first_name || !last_name || !student_id || !parent_email_address || !password || !phone_number || !email_address || !dorm_id || !dorm_room_number || !parent_phone_number) {
            Swal.fire({
                title: "Warning",
                text: "Fields should not be empty!",
                icon: "error"
            });
            return;
        }

        if(!isValidEmail(email_address) || !isValidEmail(parent_email_address)) {
            Swal.fire({
                title: "Warning",
                text: "Email(s) should be in email format!",
                icon: "error"
            });
            return;
        }

        // Function to check if the email is in a valid format
        function isValidEmail(email) {
            // Use a simple regular expression for basic email format validation
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        var formData = new FormData(this);
        $.ajax({
            url:"/signup/insert",
            method: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#loading').css('display', 'flex');
            },
            complete: function(){
                $('#loading').css('display', 'none');
            },
            success: function(response) {
                if (response.status === 'success') {
                    $("#account-information")[0].reset();
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
            error: function() {
                alert('Error occurred while inserting data.');
            }
        });
    });
});
$(document).ready(function() {
    // Listen for changes in the dorm_id select element
    $('#dorm_id').on('change', function() {
        // Get the selected value
        var selectedDorm = $(this).val();

        // Check if a dorm is selected
        if (selectedDorm) {
            // If a dorm is selected, empty the street_name and street_number fields
            $('#street_name').val('');
            $('#street_number').val('');
            $('#dorm_room_number').val('');
            // Enable and make the fields editable
            $('#street_name').prop('readonly', false);
            $('#street_number').prop('readonly', false);
            $('#dorm_room_number').prop('readonly', false);
            $('#street_name').prop('disabled', false);
            $('#street_number').prop('disabled', false);
            $('#dorm_room_number').prop('disabled', false);
        } else {
            // Disable and make the fields readonly
            $('#street_name').prop('readonly', true);
            $('#street_number').prop('readonly', true);
            $('#dorm_room_number').prop('readonly', true);
            $('#street_name').prop('disabled', true);
            $('#street_number').prop('disabled', true);
            $('#dorm_room_number').prop('disabled', true);
        }
    });
});
