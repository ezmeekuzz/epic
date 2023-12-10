$(document).ready(function() {
    $('#usermasterlist').DataTable();
});
$('.delete-btn').on('click', function() {
    const id = $(this).data('id');
    const row = $(this).closest('tr');
    const table = $('#usermasterlist').DataTable();
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
                url: '/admin/usermasterlist/delete/' + id,
                method: 'DELETE',
                success: function(response) {
                    if (response.status === 'success') {
                        
                        table.row(row).remove().draw(false);
                    }
                }
            });
        }
    });
});  