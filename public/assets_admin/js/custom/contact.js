function submitForm() {
    
    var formData = $('#sendmessage').serialize();
    
    $.ajax({
        type: 'POST',
        url: '/contact/sendMessage',
        data: formData,
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                
                iziToast.success({
                    title: 'Success',
                    message: response.message,
                });
                
                $('#sendmessage')[0].reset();
            } else {
                
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