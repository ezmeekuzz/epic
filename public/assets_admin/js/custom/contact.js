function submitForm() {
    // Get form data
    var formData = $('#sendmessage').serialize();

    // Send Ajax request
    $.ajax({
        type: 'POST',
        url: '/contact/sendMessage',
        data: formData,
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                // Display success message
                iziToast.success({
                    title: 'Success',
                    message: response.message,
                });

                // You can redirect or perform other actions after successful submission
                $('#sendmessage')[0].reset();
            } else {
                // Display error message
                iziToast.error({
                    title: 'Error',
                    message: response.message,
                });
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}