document.addEventListener('DOMContentLoaded', function () {
    // Check if there is data in local storage
    var storedData = localStorage.getItem('studentData');
    if (storedData) {
        // If data exists, populate the form fields
        var data = JSON.parse(storedData);
        Object.keys(data).forEach(function (key) {
            var element = document.getElementById(key);
            if (element) {
                element.value = data[key];
            }
        });
    }

    // Add click event listener to the "CONTINUE" button
    document.querySelector('.continue-btn').addEventListener('click', function () {
        // Capture form data
        var formData = {};
        document.querySelectorAll('input, select').forEach(function (element) {
            formData[element.id] = element.value;
        });

        // Save form data to local storage
        localStorage.setItem('studentData', JSON.stringify(formData));

        // Navigate to the "/scheduling/service-information" page
        window.location.href = '/scheduling/service-information';
    });
});