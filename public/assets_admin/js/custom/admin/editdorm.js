$(function() {    
    $('#editdorm').submit(function(event) {
        event.preventDefault();
        var dorm_name = $('#dorm_name').val();
        if(dorm_name != "") {
            var formData = new FormData(this);
            $.ajax({
                url:"/admin/editdorm/update",
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
                        swal({
                            type: 'success',
                            title: 'Success',
                            text: response.message,
                        });
                    } else {
                        swal({
                            type: 'error',
                            title: 'Ooopss...',
                            text: response.message,
                        });
                    }
                },
                error: function() {
                    alert('Error occurred while inserting data.');
                }
            });
        }
        else {
            swal({
                type: 'error',
                title: 'Ooopss...',
                text: 'Please fill up required information.',
            });
        }
    });
});