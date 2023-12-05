// Define an array to store selected items, sizes, and quantities
var selectedItems = [];

// Function to fetch sizes based on the selected item
function getSizes() {
    var itemId = $('#item_id').val();

    // Make an AJAX request to fetch sizes based on the selected item
    $.ajax({
        url: '/scheduling/getSizes', // Replace with the actual URL of your controller method
        type: 'POST',
        dataType: 'json',
        data: { item_id: itemId },
        success: function (response) {
            // Clear existing options
            $('#size_id').empty();

            // Populate the size dropdown with the retrieved sizes
            $.each(response.sizes, function (key, value) {
                $('#size_id').append('<option value="' + value.size_id + '">' + value.size + '</option>');
            });
        },
        error: function (error) {
            console.error('Error fetching sizes: ', error);
        }
    });
}

// Function to update the total based on selected items, sizes, and quantities
function updateTotal() {
    var item = $('#item_id').val();
    var size = $('#size_id').val();
    var quantity = $('#quantity').val();
    // Check if the quantity is 0
    if (!quantity || parseInt(quantity) === 0) {
        // Remove existing row if it exists
        var existingRow = $('#dynamic-summary-rows').find('[data-item="' + item + '"][data-size="' + size + '"]');
        if (existingRow.length > 0) {
            existingRow.remove();
        }

        // Recalculate the sum of all data-cost values
        var grandTotal = 0;
        $('.summary-row').each(function () {
            var cost = parseFloat($(this).data('cost'));
            if (!isNaN(cost)) {
                grandTotal += cost;
            } else {
                console.error('Invalid data-cost value:', $(this).data('cost'));
            }
        });

        // Update the total-price
        $('#total-price').text('$' + grandTotal.toFixed(2));

        return; // Exit the function if quantity is 0
    }
    $.ajax({
        url: '/scheduling/calculateTotal',
        type: 'POST',
        dataType: 'json',
        data: { item: item, size: size, quantity: quantity },
        success: function (response) {
            // Add a new row to the dynamic-summary-rows
            var newRow =
                '<div class="summary-row" data-item="' + item + '" data-size="' + size + '" data-quantity="' + quantity + '" data-cost="' + response.total + '">' +
                '<h3>' + response.item_name + ' (' + response.size + ') (' + quantity + ')</h3>' +
                '<h2>$' + response.total + '</h2>' +
                '</div>';

            // Check if the row already exists
            var existingRow = $('#dynamic-summary-rows').find('[data-item="' + item + '"][data-size="' + size + '"]');

            if (existingRow.length > 0) {
                // If the row exists, update it
                existingRow.replaceWith(newRow);
            } else {
                // If the row doesn't exist, append it
                $('#dynamic-summary-rows').append(newRow);
            }

            // Calculate the sum of all data-cost values
            var grandTotal = 0;
            $('.summary-row').each(function () {
                var cost = parseFloat($(this).data('cost'));
                if (!isNaN(cost)) {
                    grandTotal += cost;
                } else {
                    console.error('Invalid data-cost value:', $(this).data('cost'));
                }
            });

            // Update the total-price
            $('#total-price').text('$' + grandTotal.toFixed(2));
        },
        error: function (error) {
            console.error('Error calculating total: ', error);
        }
    });
}

// Function to update the total price based on selected items, sizes, and quantities
function updateTotalPrice() {
    // Get the selected box quantity
    var boxQuantity = $("#box_quantity").val();

    // Calculate the total price for additional boxes
    var additionalBoxPrice = 50.00;
    var totalAdditionalBoxes = boxQuantity * additionalBoxPrice;

    // Set the base price
    var basePrice = 0.00;

    // Calculate the total price by adding the base price and additional boxes price
    var total = basePrice + totalAdditionalBoxes;

    // Update the data-cost attribute and the displayed base price
    $("#basePrice").data("cost", total.toFixed(2));
    $("#base-price-row").text("$" + total.toFixed(2));

    // Calculate the sum of all data-cost values
    var grandTotal = 0;
    $('.summary-row').each(function () {
        var cost = parseFloat($(this).data('cost'));
        if (!isNaN(cost)) {
            grandTotal += cost;
        } else {
            console.error('Invalid data-cost value:', $(this).data('cost'));
        }
    });

    // Update the total-price
    $('#total-price').text('$' + grandTotal.toFixed(2));

    // Save the total price to local storage
    localStorage.setItem('storedTotalPrice', grandTotal.toFixed(2));
}

// Function to initialize the page
function initializePage() {
    // Initial call to update total price based on default box quantity
    updateTotalPrice();

    // Attach event listener to the quantity input
    $('#quantity').on('input', updateTotal);

    // Check if there is data in local storage
    var storedFormData = localStorage.getItem('formData');
    if (storedFormData) {
        // If data exists, populate the form fields
        var formData = JSON.parse(storedFormData);
        Object.keys(formData).forEach(function (key) {
            var element = document.querySelector('[name="' + key + '"]');
            if (element) {
                // Check if the element is a radio button
                if (element.type === 'radio') {
                    // Handle radio buttons differently
                    if (element.value === formData[key]) {
                        element.checked = true;
                    } else {
                        element.checked = false;
                    }
                } else if (element.tagName === 'SELECT') {
                    // Handle select elements
                    element.value = formData[key];
                    // Trigger change event for select elements to update dependent fields
                    var event = new Event('change');
                    element.dispatchEvent(event);
                } else {
                    element.value = formData[key];
                }
            }
        });
    }
    // Check if there is data in local storage for selected items, sizes, and quantities
    var storedSelectedItems = localStorage.getItem('selectedItems');
    if (storedSelectedItems) {
        // If data exists, populate the selected items
        selectedItems = JSON.parse(storedSelectedItems);

        // Your existing code for updating the dynamic-summary-rows and total-price based on selectedItems

        // ...

        // Calculate the sum of all data-cost values
        var grandTotal = 0;
        $('.summary-row').each(function () {
            var cost = parseFloat($(this).data('cost'));
            if (!isNaN(cost)) {
                grandTotal += cost;
            } else {
                console.error('Invalid data-cost value:', $(this).data('cost'));
            }
        });

        // Update the total-price
        $('#total-price').text('$' + grandTotal.toFixed(2));
        
        // Save the total price to local storage
        localStorage.setItem('storedTotalPrice', grandTotal.toFixed(2));
    }

    // Check if there is data in local storage for dynamic summary rows
    var storedRows = localStorage.getItem('storedRows');
    if (storedRows) {
        // If data exists, append the stored rows to the dynamic-summary-rows
        $('#dynamic-summary-rows').append(storedRows);
    }
    // Check if there is data in local storage for total price
    var storedTotalPrice = localStorage.getItem('storedTotalPrice');
    if (storedTotalPrice !== null && !isNaN(storedTotalPrice)) {
        // If data exists and is a valid number, update the total-price
        $('#total-price').text('$' + parseFloat(storedTotalPrice).toFixed(2));
    } else {
        console.error('Invalid storedTotalPrice value:', storedTotalPrice);
    }

    // Check if there is data in local storage for base price
    var storedBasePrice = localStorage.getItem('storedBasePrice');
    if (storedBasePrice !== null && !isNaN(storedBasePrice)) {
        // If data exists and is a valid number, update the basePrice and base-price-row
        $("#basePrice").data("cost", parseFloat(storedBasePrice));
        $("#base-price-row").text('$' + parseFloat(storedBasePrice).toFixed(2));
    } else {
        console.error('Invalid storedBasePrice value:', storedBasePrice);
    }

    // Add click event listener to the "CONTINUE" button
    document.querySelector('.continue-btn').addEventListener('click', function () {
        // Capture form data and save each field individually to local storage
        var formData = {};
        document.querySelectorAll('input, select').forEach(function (element) {
            if (element.type === 'radio' && element.checked) {
                // Save the selected radio button's value based on its name
                formData[element.name] = element.value;
                // Save each radio button individually to local storage
                localStorage.setItem(element.name, element.checked);
            } else if (element.tagName === 'SELECT') {
                // Save the selected option's value for select elements
                formData[element.id] = element.value;
                // Save each select element individually to local storage
                localStorage.setItem(element.id, element.value);
            } else {
                formData[element.id] = element.value;
                // Save each field individually to local storage
                localStorage.setItem(element.id, element.value);
            }
        });

        // Save all form data to local storage
        localStorage.setItem('formData', JSON.stringify(formData));

        // Save the selected items, sizes, and quantities
        localStorage.setItem('selectedItems', JSON.stringify(selectedItems));

        // Save the dynamic summary rows to local storage
        localStorage.setItem('storedRows', $('#dynamic-summary-rows').html());

        // Save the base price to local storage
        localStorage.setItem('storedBasePrice', $("#basePrice").data("cost"));

        // Navigate to the "/scheduling/service-information" page
        window.location.href = '/scheduling/service-information';
    });
}

// Call the initializePage function when the DOM is fully loaded
$(document).ready(function () {
    initializePage();
});
