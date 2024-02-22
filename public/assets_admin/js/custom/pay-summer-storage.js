document.addEventListener('DOMContentLoaded', function () {
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
                        html += '<h2 class="item-total-price">$' + item.totalamount + '<h2>';
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
                $('#totalAmount').val(totalAmount);
            },
            error: function () {
                console.error('Error fetching total amount.');
            }
        });
    }
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
    $(document).ready(function () {
        fetchBookingItems();
        fetchTotalAmount();
        getStudyAbroadAdditionalStoragePrice();
    });
});
const appId = 'sandbox-sq0idb-WgKiAdcuQNo2HcwJ7Efcbg';
const locationId = 'L7FXY3WQRVBWV';
let paymentMethod;

async function initializeCard(payments) {
    paymentMethod = await payments.card();
    paymentMethod.attach('#card-container');

    return paymentMethod;
}

async function createPayment() {
    const amount = document.getElementById('totalAmount').value;

    var formData = {};
    $("#payment-form").find(":input").each(function () {
        var name = $(this).attr("name");
        var value = $(this).val();

        if (formData.hasOwnProperty(name)) {
            if (!Array.isArray(formData[name])) {
                formData[name] = [formData[name]];
            }
            formData[name].push(value);
        } else {
            formData[name] = value;
        }
    });
    
    var combinedData = { ...formData};


    try {
        const tokenResult = await tokenize(paymentMethod);

        if (tokenResult.status === 'OK') {
        const cardNonce = tokenResult.token;
        const body = JSON.stringify({
            amount: amount,
            card_nonce: cardNonce,
            additionalData: combinedData,
        });

        const paymentResponse = await fetch('/pay/processPayment', {
            method: 'POST',
            headers: {
            'Content-Type': 'application/json',
            },
            body: body,
        });

        if (!paymentResponse) {
            console.error('Payment request did not return a response');
            throw new Error('Payment request did not return a response');
        }
        const contentType = paymentResponse.headers ? paymentResponse.headers.get('content-type') : null;

        if (contentType && contentType.includes('application/json')) {
            const responseData = await paymentResponse.json();
            if (paymentResponse.ok) {
            console.log('Payment Success', responseData);
            return responseData;
            } else {
            console.error('Payment request failed', responseData);
            throw new Error('Payment request failed');
            }
        } else {
            const textData = await paymentResponse.text();
            console.error('Payment response is not JSON', textData);
            throw new Error('Payment response is not JSON');
        }
        } else {
            let errorMessage = `Tokenization failed with status: ${tokenResult.status}`;
            if (tokenResult.errors) {
                errorMessage += ` and errors: ${JSON.stringify(tokenResult.errors)}`;
            }

            throw new Error(errorMessage);
        }
    } catch (error) {
        console.error('Create Payment error:', error);
        throw error;
    }
}

async function tokenize(paymentMethod) {
    const tokenResult = await paymentMethod.tokenize();

    if (tokenResult.status === 'OK') {
        return tokenResult;
    } else {
        let errorMessage = `Tokenization failed with status: ${tokenResult.status}`;
        if (tokenResult.errors) {
            errorMessage += ` and errors: ${JSON.stringify(tokenResult.errors)}`;
        }

        throw new Error(errorMessage);
    }
}

function displayPaymentResults(status) {
    const statusContainer = document.getElementById('payment-status-container');

    if (status === 'SUCCESS') {
        statusContainer.classList.remove('is-failure');
        statusContainer.classList.add('is-success');
    }
    statusContainer.style.visibility = 'visible';
}

document.addEventListener('DOMContentLoaded', async function () {
    if (!window.Square) {
        throw new Error('Square.js failed to load properly');
    }

    let payments;
    try {
        payments = window.Square.payments(appId, locationId);
    } catch (error) {
        console.error('Square.js initialization failed:', error);
        const statusContainer = document.getElementById('payment-status-container');
        statusContainer.className = 'missing-credentials';
        statusContainer.style.visibility = 'visible';
        return;
    }

    let card;
    try {
        card = await initializeCard(payments);
    } catch (e) {
        console.error('Initializing Card failed', e);
        return;
    }

    async function handlePaymentMethodSubmission(event, paymentMethod) {
        event.preventDefault();

        const firstName = document.getElementById('fname').value.trim();
        const lastName = document.getElementById('lname').value.trim();
        const termsCheckbox = document.getElementById('choice_4_1');
    
        if (firstName === '' || lastName === '') {
            Swal.fire({
                title: "Warning",
                text: "Please enter both first name and last name!",
                icon: "error"
            }).then(() => {
                cardButton.style.pointerEvents = 'auto';
            });
            return;
        }
    
        if (!termsCheckbox.checked) {
            Swal.fire({
                title: "Warning",
                text: "Please accept the terms and conditions!",
                icon: "error"
            }).then(() => {
                cardButton.style.pointerEvents = 'auto';
            });
            return;
        }

        const sqCardNonceResult = await paymentMethod.tokenize();
        const sqCardNonce = sqCardNonceResult.token;
    
        // Check if the Square card nonce is available
        if (!sqCardNonce) {
            Swal.fire({
                title: "Warning",
                text: "Square card details are incomplete!",
                icon: "error"
            }.then(() => {
                cardButton.style.pointerEvents = 'auto';
            }));
            return;
        }

        try {
            showLoadingSpinner();

            cardButton.disabled = true;
            const paymentResults = await createPayment(paymentMethod);
            displayPaymentResults('SUCCESS');
            console.debug('Payment Success', paymentResults);
        } catch (e) {
            cardButton.disabled = false;
            displayPaymentResults('FAILURE');
            console.error(e.message);
        } finally {
            hideLoadingSpinner();
            Swal.fire({
                title: "Payment Successful",
                text: "Payment has been successfully paid!",
                icon: "success"
            }).then(() => {
                window.location.href = '/pay/removeServiceSession';
            });
        }
    }

    function showLoadingSpinner() {
        $('#loading').css('display', 'flex');
    }

    function hideLoadingSpinner() {
        $('#loading').css('display', 'none');
    }

    const cardButton = document.getElementById('card-button');
    cardButton.addEventListener('click', async function (event) {
        cardButton.style.pointerEvents = 'none';
        await handlePaymentMethodSubmission(event, card);
    });
    
}); 