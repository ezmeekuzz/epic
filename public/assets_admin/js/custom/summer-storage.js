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
    // Get the radio button and the form
    var isStorageAdditionalItem = $('input[name="is_storage_additional_item"]');
    var additionalItemsForm = $('.additional-items-form');

    // Function to show or hide the form based on the selected value
    function showHideForm() {
        additionalItemsForm.toggle(isStorageAdditionalItem.filter(':checked').val() === 'Yes');
    }

    // Add a change event listener to the radio button
    isStorageAdditionalItem.on('change', showHideForm);

    // Call the function initially to handle the default value
    showHideForm();
    // Event listener for the "studying_abroad" radio buttons
    $('input[name="studying_abroad"]').change(function () {
        // Get the selected value
        var selectedValue = $(this).val();

        // AJAX request to update is_studying_abroad value in the database
        updateServiceOption('is_studying_abroad', selectedValue);
    });

    // Event listener for the "is_storage_additional_item" radio buttons
    $('input[name="is_storage_additional_item"]').change(function () {
        // Get the selected value
        var selectedValue = $(this).val();

        // AJAX request to update is_storage_additional_item value in the database
        updateServiceOption('is_storage_additional_item', selectedValue);
    });

    // Event listener for the "is_summer_school" radio buttons
    $('input[name="is_summer_school"]').change(function () {
        // Get the selected value
        var selectedValue = $(this).val();

        // AJAX request to update is_summer_school value in the database
        updateServiceOption('is_summer_school', selectedValue);
        $.ajax({
            url: '/scheduling/insertSummerSchoolDeliveryFee',
            type: 'POST',
            dataType: 'json',
            data: { selectedValue: selectedValue },
            success: function (response) {
                fetchBookingItems();
                fetchTotalAmount();
            },
            error: function () {
                alert('Error occurred during the AJAX request.');
            }
        });
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

    // Function to update service options in the database
    function updateServiceOption(optionName, optionValue) {
        $.ajax({
            url: '/scheduling/updateServiceOption', // Replace with your actual URL
            type: 'POST',
            dataType: 'json',
            data: {
                optionName: optionName,
                optionValue: optionValue,
            },
            success: function (response) {
                console.log(response.message);
                fetchTotalAmount();
                getStudyAbroadAdditionalStoragePrice();
            },
            error: function () {
                console.error('Error updating service option in the database.');
            }
        });
    }

    // Function to check and update radio buttons based on database values
    function checkServiceOptions() {
        $.ajax({
            url: '/scheduling/checkServiceOptions',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                console.log('Response:', response); // Add this line for debugging
                if (response.is_studying_abroad === 'Yes') {
                    // If Yes, check the "Yes" radio button
                    $('input[name="studying_abroad"][value="Yes"]').prop('checked', true);
                } else {
                    // If No or null, check the "No" radio button
                    $('input[name="studying_abroad"][value="No"]').prop('checked', true);
                }
                if (response.is_storage_additional_item === 'Yes') {
                    // If Yes, check the "Yes" radio button
                    $('input[name="is_storage_additional_item"][value="Yes"]').prop('checked', true);
                } else {
                    // If No or null, check the "No" radio button
                    $('input[name="is_storage_additional_item"][value="No"]').prop('checked', true);
                    showHideForm();
                }
                if (response.is_summer_school === 'Yes') {
                    // If Yes, check the "Yes" radio button
                    $('input[name="is_summer_school"][value="Yes"]').prop('checked', true);
                } else {
                    // If No or null, check the "No" radio button
                    $('input[name="is_summer_school"][value="No"]').prop('checked', true);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error checking service options values in the database:', status, error);
            }
        });
    }

    // Call the function when the page loads
    checkServiceOptions();
    // Function to get study_abroad_additional_storage_price using AJAX
    function getStudyAbroadAdditionalStoragePrice() {
        var html = "";
        $.ajax({
            url: '/scheduling/getStudyAbroadAdditionalStoragePrice',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.study_abroad_additional_storage_price !== undefined) {
                    // Use the value as needed
                    console.log('Study Abroad Additional Storage Price:', response.study_abroad_additional_storage_price);
                    html += '<div class="summary-row">';
                    html += '<h2>Study Abroad Additional Storage Price – Second Semester</h2>';
                    html += '<h2 class="item-total-price">$' + response.study_abroad_additional_storage_price + '<h2>';
                    html += '</div>';
                    // Call another function or update the UI with the obtained value
                    updateUI(html);
                } else {
                    updateUI(html);
                }
            },
            error: function() {
                console.error('Error in AJAX request');
            }
        });
    }

    // Function to update the UI with study_abroad_additional_storage_price
    function updateUI(studyAbroadAdditionalStoragePrice) {
        // Update your UI elements with the obtained value
        $('#studyAbroadAddtionalStoragePrice').html(studyAbroadAdditionalStoragePrice);
    }

    // Call the function to get study_abroad_additional_storage_price when needed
    getStudyAbroadAdditionalStoragePrice();
    document.querySelector('.continue-btn').addEventListener('click', function () {
        window.location.href = '/pay';
    });
});