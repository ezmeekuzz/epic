document.addEventListener('DOMContentLoaded', function () {
    var selectedItems = [];

    var boxQuantitySelect = document.getElementById('box_quantity');
    boxQuantitySelect.addEventListener('change', function () {
        updateBoxQuantity();
    });

    function updateBoxQuantity() {
        var selectedQuantity = document.getElementById('box_quantity').value;

        if (selectedQuantity === '' || isNaN(selectedQuantity)) {
            return;
        }

        var boxCost = selectedQuantity * 50;

        var dynamicSummaryRows = document.getElementById('additional-box-row');

        dynamicSummaryRows.innerHTML = '';

        var summaryRow = document.createElement('div');
        summaryRow.classList.add('summary-row');

        summaryRow.innerHTML = '<h2>Additional Boxes (x ' + selectedQuantity + ')</h2>' +
            '<h2 id="box-quantity-row">$' + boxCost.toFixed(2) + '</h2>' +
            '<input type="hidden" name="addtl_box_name" id="addtl_box_name" value="Additional Box(es)" />' +
            '<input type="hidden" name="addtl_box_amount" id="addtl_box_amount" value="50.00" />' +
            '<input type="hidden" name="addtl_box_total_amount" id="addtl_box_total_amount" value="' + boxCost.toFixed(2) + '" />' +
            '<input type="hidden" name="addtl_box_quantity" id="addtl_box_quantity" value="' + selectedQuantity + '" />';

        dynamicSummaryRows.append(summaryRow);

        updateTotalPrice();
    }

    function updateTotalPrice() {
        try {
            var addtlBoxTotalAmount = calculateAdditionalBoxTotalAmount();
            var itemTotalAmount = calculateItemTotalAmount();

            var totalCost = addtlBoxTotalAmount + itemTotalAmount;

            document.getElementById('total-price').innerText = '$' + totalCost.toFixed(2);
            document.getElementById('totalAmount').value = totalCost.toFixed(2);

            localStorage.setItem('storedTotalPrice', totalCost.toFixed(2));
        } catch (error) {
            console.error('Error while updating total price:', error);
        }
    }

    function calculateAdditionalBoxTotalAmount() {
        var addtlBoxTotalAmountInput = document.getElementById('addtl_box_total_amount');
        return addtlBoxTotalAmountInput ? parseFloat(addtlBoxTotalAmountInput.value) : 0;
    }

    function calculateItemTotalAmount() {
        var itemTotalAmountInputs = document.getElementsByName('item_total_amount[]');
        var itemTotalAmount = 0;

        if (itemTotalAmountInputs.length > 0) {
            for (var i = 0; i < itemTotalAmountInputs.length; i++) {
                itemTotalAmount += parseFloat(itemTotalAmountInputs[i].value);
            }
        }

        return itemTotalAmount;
    }

    updateTotalPrice();

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

    $('.btn-add').on('click', calculateTotal);

    function calculateTotal() {
        var item = $('#item_id').val();
        var size = $('#size_id').val();
        var quantity = $('#quantity').val();

        $.ajax({
            url: '/scheduling/calculateTotal',
            method: 'POST',
            data: {
                item: item,
                size: size,
                quantity: quantity
            },
            dataType: 'json',
            success: function (data) {
                var existingItem = $('.order_item_id').filter(function () {
                    return $(this).val() == item;
                });

                var existingSize = $('.order_size_id').filter(function () {
                    return $(this).val() == size;
                });

                var existingRow = null;

                existingItem.each(function () {
                    var currentItemRow = $(this).closest('.summary-row');
                    var currentSize = currentItemRow.find('.order_size_id').val();

                    if (currentSize == size) {
                        existingRow = currentItemRow;
                        return false;
                    }
                });

                if (existingRow) {
                    var existingQuantityInput = existingRow.find('.item_quantity');
                    var existingTotalAmountInput = existingRow.find('.item_total_amount');
                    var existingLabel = existingRow.find('.data-label');
                    var existingAddtlBoxTotalAmount = existingRow.find('.addtlBoxTotalAmount');

                    existingQuantityInput.val(quantity);
                    existingTotalAmountInput.val(data.total.toFixed(2));
                    existingLabel.html(`${data.item_name} ${data.size} (x ${quantity})`);
                    existingAddtlBoxTotalAmount.html('$' + data.total.toFixed(2));

                    updateLocalStorage();

                    updateTotalPrice();
                } else {
                    var dynamicSummaryRows = $('#dynamic-summary-rows');
                    var summaryRow = $('<div>').addClass('summary-row');
                    summaryRow.html(`
                        <h2 class="data-label">${data.item_name} ${data.size} (x ${quantity})</h2>
                        <h2 id="box-quantity-row" class="addtlBoxTotalAmount">$${data.total.toFixed(2)}</h2>
                        <input type="hidden" name="order_item_id[]" class="order_item_id" value="${data.item_id}" />
                        <input type="hidden" name="order_size_id[]" class="order_size_id" value="${data.size_id}" />
                        <input type="hidden" name="item_amount[]" class="item_amount" value="${data.price}" />
                        <input type="hidden" name="item_total_amount[]" class="item_total_amount" value="${data.total.toFixed(2)}" />
                        <input type="hidden" name="item_quantity[]" class="item_quantity" value="${quantity}" />
                    `);
                    dynamicSummaryRows.append(summaryRow);

                    updateTotalPrice();
                }

            },
            error: function (error) {
                console.error('Error:', error);
            }
        });
    }

    function initializePage() {
        updateTotalPrice();

        var storedFormData = localStorage.getItem('formData');
        if (storedFormData) {
            var formData = JSON.parse(storedFormData);
            Object.keys(formData).forEach(function (key) {
                var element = document.querySelector('[name="' + key + '"]');
                if (element) {
                    if (element.type === 'radio') {
                        if (element.value === formData[key]) {
                            element.checked = true;
                        } else {
                            element.checked = false;
                        }
                    } else if (element.tagName === 'SELECT') {
                        element.value = formData[key];
                        var event = new Event('change');
                        element.dispatchEvent(event);
                    } else {
                        element.value = formData[key];
                    }
                }
            });
        }

        var storedSelectedItems = localStorage.getItem('selectedItems');
        if (storedSelectedItems) {
            selectedItems = JSON.parse(storedSelectedItems);

            var addtlBoxTotalAmountInput = document.getElementById('addtl_box_total_amount');
            var addtlBoxTotalAmount = addtlBoxTotalAmountInput ? parseFloat(addtlBoxTotalAmountInput.value) : 0;

            var itemTotalAmountInputs = document.getElementsByName('item_total_amount[]');
            var itemTotalAmount = 0;

            if (itemTotalAmountInputs.length > 0) {
                for (var i = 0; i < itemTotalAmountInputs.length; i++) {
                    itemTotalAmount += parseFloat(itemTotalAmountInputs[i].value);
                }
            }

            var grandTotal = addtlBoxTotalAmount + itemTotalAmount;

            document.getElementById('total-price').innerText = '$' + grandTotal.toFixed(2);
            document.getElementById('totalAmount').value = grandTotal.toFixed(2);

            localStorage.setItem('storedTotalPrice', grandTotal.toFixed(2));
        }

        var storedRows = localStorage.getItem('storedRows');
        if (storedRows) {
            $('#dynamic-summary-rows').append(storedRows);
        }

        var storedTotalPrice = localStorage.getItem('storedTotalPrice');
        if (storedTotalPrice !== null && !isNaN(storedTotalPrice)) {
            $('#total-price').text('$' + parseFloat(storedTotalPrice).toFixed(2));
        } else {
            console.error('Invalid storedTotalPrice value:', storedTotalPrice);
        }

        document.querySelector('.continue-btn').addEventListener('click', function () {
            var formData = {};
            document.querySelectorAll('input, select').forEach(function (element) {
                if (element.type === 'radio' && element.checked) {
                    formData[element.name] = element.value;
                    localStorage.setItem(element.name, element.checked);
                } else if (element.tagName === 'SELECT') {
                    formData[element.id] = element.value;
                    localStorage.setItem(element.id, element.value);
                } else {
                    formData[element.id] = element.value;
                    localStorage.setItem(element.id, element.value);
                }
            });

            localStorage.setItem('formData', JSON.stringify(formData));
            localStorage.setItem('selectedItems', JSON.stringify(selectedItems));
            localStorage.setItem('storedRows', $('#dynamic-summary-rows').html());
            window.location.href = '/pay';
        });

        updateTotalPrice();
    }
    initializePage();

    function updateLocalStorage() {
        var storedRows = $('#dynamic-summary-rows').html();
        localStorage.setItem('storedRows', storedRows);

        var storedTotalPrice = $('#total-price').text().replace('$', '');
        localStorage.setItem('storedTotalPrice', storedTotalPrice);
    }
});
