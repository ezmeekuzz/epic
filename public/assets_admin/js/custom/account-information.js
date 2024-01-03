document.addEventListener('DOMContentLoaded', function () {
    // Retrieve and display stored data
    var storedData = localStorage.getItem('studentData');
    if (storedData) {
        var data = JSON.parse(storedData);
        console.log('Stored Data:', data);
        Object.keys(data).forEach(function (key) {
            var element = document.getElementById(key);
            if (element) {
                element.value = data[key];
            }
        });
    }

    // Event listener for the CONTINUE button
    document.querySelector('.continue-btn').addEventListener('click', function () {
        var serviceType = $(this).data('service-type');

        var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();
        var student_id = $('#student_id').val();
        var phone_number = $('#phone_number').val();
        var email_address = $('#email_address').val();
        var dorm_id = $('#dorm_id').val();
        var dorm_room_number = $('#dorm_room_number').val();
        var parent_phone_number = $('#parent_phone_number').val();
        var parent_email_address = $('#parent_email_address').val();
        
        if(!first_name || !last_name || !student_id || !parent_email_address || !phone_number || !email_address || !dorm_id || !dorm_room_number || !parent_phone_number) {
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

        // Gather form data
        var formData = {};
        document.querySelectorAll('input, select').forEach(function (element) {
            formData[element.id] = element.value;
        });

        console.log('Form Data:', formData);

        // Store form data in local storage
        localStorage.setItem('studentData', JSON.stringify(formData));

        // Redirect to the service information page with the service type
        window.location.href = '/scheduling/service-information/' + serviceType;
    });
});
