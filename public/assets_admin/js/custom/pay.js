function displayStoredData() {
    
    var storedData = localStorage.getItem('studentData');
    if (storedData) {
        var data = JSON.parse(storedData);
        
        Object.keys(data).forEach(function (key) {
            var element = document.getElementById(key);
            if (element) {
                element.value = data[key];
            }
        });
    }
    var storedFormData = localStorage.getItem('formData');
    if (storedFormData) {
        var formData = JSON.parse(storedFormData);
    }

    var storedSelectedItems = localStorage.getItem('selectedItems');
    if (storedSelectedItems) {
        var selectedItems = JSON.parse(storedSelectedItems);
    }

    var storedRows = localStorage.getItem('storedRows');
    if (storedRows) {
        
        document.getElementById('dynamic-summary-rows').innerHTML = storedRows;
    }

    var totalAmount = localStorage.getItem('totalAmount');
    if (totalAmount !== null && !isNaN(totalAmount)) {
        
        document.getElementById('total-price').innerText = '$' + parseFloat(totalAmount).toFixed(2);
        
        document.getElementById('totalAmount').value = parseFloat(totalAmount).toFixed(2);
    } else {
        console.error('Invalid storedTotalPrice value:', totalAmount);
    }

    var storedAddtlBoxAmount = localStorage.getItem('addtl_box_amount');
    var addtl_box_quantity = localStorage.getItem('addtl_box_quantity');
    var addtl_box_total_amount = localStorage.getItem('addtl_box_total_amount');
    var addtl_box_name = localStorage.getItem('addtl_box_name');
    if (storedAddtlBoxAmount !== null && !isNaN(storedAddtlBoxAmount)) {
        
        document.getElementById('additional-box-row').innerHTML = '<div class="summary-row"><h2>Additional Boxes</h2>' +
            '<h2 id="box-quantity-row">$' + parseFloat(addtl_box_total_amount).toFixed(2) + '</h2>' +
            '<input type="hidden" name="addtl_box_name" id="addtl_box_name" value="' + addtl_box_name + '" />' +
            '<input type="hidden" name="addtl_box_amount" id="addtl_box_amount" value="' + parseFloat(storedAddtlBoxAmount).toFixed(2) + '" />' +
            '<input type="hidden" name="addtl_box_total_amount" id="addtl_box_total_amount" value="' + parseFloat(addtl_box_total_amount).toFixed(2) + '" />' +
            '<input type="hidden" name="addtl_box_quantity" id="addtl_box_quantity" value="' + addtl_box_quantity + '" /></div>';
    } else {
        console.error('Invalid storedAddtlBoxAmount value:', addtl_box_total_amount);
    }

    var storedFormData = localStorage.getItem('formData');
    var localFormData = storedFormData ? JSON.parse(storedFormData) : {};

    var is_storage_additional_item = localFormData.is_storage_additional_item;
    var is_storage_car_in_may = localFormData.is_storage_car_in_may;
    var is_storage_vehicle_in_may = localFormData.is_storage_vehicle_in_may;
    var is_summer_school = localFormData.is_summer_school;
    
}

document.addEventListener('DOMContentLoaded', displayStoredData);

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
    var storedData = localStorage.getItem('studentData');
    var localData = storedData ? JSON.parse(storedData) : {};

    var storedFormData = localStorage.getItem('formData');
    var localFormData = storedFormData ? JSON.parse(storedFormData) : {};

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
    
    var combinedData = { ...formData, ...localData, ...localFormData };


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
            });
            return;
        }
    
        if (!termsCheckbox.checked) {
            Swal.fire({
                title: "Warning",
                text: "Please accept the terms and conditions!",
                icon: "error"
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
            });
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
            localStorage.clear();
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
        await handlePaymentMethodSubmission(event, card);
    });
}); 

$(document).ready(function() {
    
    $(".continue-btn").click(function(e) {
        e.preventDefault();
        $('#card-button').click();
    });
});