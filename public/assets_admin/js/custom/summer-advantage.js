document.addEventListener('DOMContentLoaded', function () {
    $('#item_id').on('change', getSizes);

    function getSizes() {
        var itemId = $('#item_id').val();

        $.ajax({
            url: '/scheduling/getSizes',
            method: 'POST',
            data: { item_id: itemId },
            dataType: 'json',
            success: function (data) {
                var sizeDropdown = $('#size_id');
                sizeDropdown.html('<option disabled selected>Choose a size</option>');

                $.each(data.sizes, function (index, size) {
                    sizeDropdown.append($('<option>', {
                        value: size.size_id,
                        text: size.size
                    }));
                });
            },
            error: function (error) {
                console.error('Error:', error);
            }
        });
    }
    $('#box_quantity').on('change', function () {
        // Get the selected option
        var selectedOption = $(this).find(':selected');
        var selectedValue = selectedOption.val();
        // Get the data attributes from the selected option
        var selectedItemID = selectedOption.data('item-id');
        var selectedQuantity = selectedOption.data('quantity');
        
        // Make an AJAX request to insert data
        $.ajax({
            type: 'POST',
            url: '/scheduling/insertAdditionalBoxTotalAmount',
            data: { item_id: selectedItemID, quantity: selectedQuantity, size_id: selectedValue },
            success: function (response) {
                fetchBookingItems();
                fetchTotalAmount();
                getStudyAbroadAdditionalStoragePrice();
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
    function fetchBookingItems() {
        $.ajax({
            url: '/scheduling/getBookingItems', // Adjust the URL based on your project structure
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                if (data.bookingItems.length > 0) {
                    var html = '';
                    $.each(data.bookingItems, function (index, item) {
                        html += '<div class="summary-row">';
                        html += '<h2>' + item.item_name + ' / ' + item.size +' (x' + item.quantity + ')</h2>';
                        html += '<h2 class="item-total-price"><a href="#" class="remove-item" data-index="' + item.booking_item_id + '"><i class="fa fa-trash"></i> Delete</a>$' + item.totalamount + '<h2>';
                        html += '</div>';
                    });
                    $('#dynamic-summary-rows').html(html);
                    
                    $('.remove-item').on('click', function (e) {
                        e.preventDefault();
                        var index = $(this).data('index');
                        deleteBookingItem(index);
                    });
                } else {
                    $('#dynamic-summary-rows').html('<p>No booking items found.</p>');
                }
            },
            error: function () {
                console.error('Error fetching booking items.');
            }
        });
    }
    function deleteBookingItem(index) {
        $.ajax({
            url: '/scheduling/deleteBookingItem',
            type: 'POST',
            dataType: 'json',
            data: { index: index },
            success: function (data) {
                if (data.success) {
                    fetchBookingItems();
                    fetchTotalAmount();
                    getStudyAbroadAdditionalStoragePrice();
                } else {
                    console.error('Error deleting booking item.');
                }
            },
            error: function () {
                console.error('Error deleting booking item.');
            }
        });
    }
    function fetchTotalAmount() {
        $.ajax({
            url: '/scheduling/getTotalAmount', // Adjust the URL based on your project structure
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                var totalAmount = data.totalAmount || 0; // Use 0 if totalAmount is not set
                $('#total-price').html('$' + totalAmount);
            },
            error: function () {
                console.error('Error fetching total amount.');
            }
        });
    }
    $(document).ready(function () {
        fetchBookingItems();
        fetchTotalAmount();
        getStudyAbroadAdditionalStoragePrice();
    });
    
    $(document).ready(function () {
        $('.btn-add').on('click', function () {
            // Get the data from the form
            var formData = {
                item_id: $('#item_id').val(),
                size_id: $('#size_id').val(),
                quantity: $('#quantity').val()
            };

            // Make an AJAX request to the CodeIgniter controller
            $.ajax({
                url: '/scheduling/insertBookingItem',
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function (response) {
                    // Handle the response from the server
                    fetchBookingItems();
                    fetchTotalAmount();
                    getStudyAbroadAdditionalStoragePrice();
                },
                error: function () {
                    console.error('Error inserting data.');
                }
            });
        });
    });
    document.querySelector('.continue-btn').addEventListener('click', function () {
        window.location.href = '/pay';
    });
});