function addsizes() {
    var elem = "";
    elem += '<div class="sizesLists"><div class="form-group"><label for="size" style="float: left;">Size</label><div style="float: right;"><a href="javascript:void(0);" onclick="addsizes();" title="Add Size"><i class="fa fa-plus-circle" style="font-size: 18px; color: blue;"></i></a><a href="#" style="color: red; font-size: 18px;" class="remove-size"><i class="fa fa-trash"></i></a></div><input type="text" class="form-control" id="size" name="size[]" placeholder=""></div><div class="form-group"><label for="cost">Cost</label><input type="text" class="form-control" id="cost" name="cost[]" placeholder="0.00"></div></div>';
    $('.sizes').append(elem);
}

$('.sizes').on('click', '.remove-size', function() {
    $(this).closest('.sizesLists').remove();
});
$(document).ready(function() {
    
    $('#additem').submit(function(event) {
        event.preventDefault();
        
        var formData = $(this).serialize();
        
        if ($('#item_name').val().trim() === '') {
            swal({
                type: 'error',
                title: 'Ooopss...',
                text: 'Item Name cannot be empty.',
            });
            return;
        }
        
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
        
        $.ajax({
            type: 'POST',
            url: '/admin/additem/insert',
            data: formData,
            success: function(response) {
                
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