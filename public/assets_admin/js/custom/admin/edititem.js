function addSizes() {
    var elem = "";
    elem += '<div class="sizesLists"><div class="form-group"><label for="size" style="float: left;">Size</label><div style="float: right;"><a href="javascript:void(0);" onclick="addSizes();" title="Add Size"><i class="fa fa-plus-circle" style="font-size: 18px; color: blue;"></i></a><a href="#" style="color: red; font-size: 18px;" class="remove-size"><i class="fa fa-trash"></i></a></div><input type="text" class="form-control sizes" id="size" name="size[]" placeholder=""></div><div class="form-group"><label for="cost">Cost</label><input type="text" class="form-control" id="cost" name="cost[]" placeholder="0.00"></div></div>';
    $('.sizes').append(elem);
}
// Function to remove elements
$('.sizes').on('click', '.remove-size', function() {
    $(this).closest('.sizesLists').remove();
});
$(document).ready(function() {
    // Submit form using AJAX
    $('#edititem').submit(function(event) {
        event.preventDefault(); // Prevent the form from submitting in the traditional way

        // Serialize the form data
        var formData = $(this).serialize();

        // Check if item_name is empty
        if ($('#item_name').val().trim() === '') {
            swal({
                type: 'error',
                title: 'Ooopss...',
                text: 'Item Name cannot be empty.',
            });
            return;
        }

        // Check if size field is empty
        if ($('input[name="size[]"]').filter(function() {
            return $.trim(this.value) !== '';
        }).length === 0) {
            swal({
                type: 'error',
                title: 'Ooopss...',
                text: 'Size field cannot be empty.',
            });
            return;
        }

        // Perform AJAX request
        $.ajax({
            type: 'POST',
            url: '/admin/edititem/update', // Replace with your server-side script URL
            data: formData,
            success: function(response) {
                // Handle success response here
                swal({
                    type: 'success',
                    title: 'Success',
                    text: response.message,
                });
            },
            error: function() {
                alert('Error occurred while inserting data.');
            }
        });
    });
});