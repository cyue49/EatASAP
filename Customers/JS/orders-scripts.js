// ========================= Hightlight current section of accordion =========================
$('#headingPaymentMethod').addClass('currentAccordionSection');
var currentSection = 'payment';

$('#headingPaymentMethod').click(function () {
    if (currentSection == 'payment') {
        $('#headingPaymentMethod').removeClass('currentAccordionSection');
        currentSection = 'none';
    } else {
        $('#headingPaymentMethod').addClass('currentAccordionSection');
        $('#headingCustomerInformation').removeClass('currentAccordionSection');
        $('#headingReviewOrder').removeClass('currentAccordionSection');
        currentSection = 'payment';
    }
    $('#paymentAccordion #headingReviewOrder').css('border-radius', '0 0 25px 25px');
});

$('#headingCustomerInformation').click(function () {
    if (currentSection == 'info') {
        $('#headingCustomerInformation').removeClass('currentAccordionSection');
        currentSection = 'none';
    } else {
        $('#headingCustomerInformation').addClass('currentAccordionSection');
        $('#headingPaymentMethod').removeClass('currentAccordionSection');
        $('#headingReviewOrder').removeClass('currentAccordionSection');
        currentSection = 'info';
    }
    $('#paymentAccordion #headingReviewOrder').css('border-radius', '0 0 25px 25px');
});

$('#headingReviewOrder').click(function () {
    if (currentSection == 'review') {
        $('#headingReviewOrder').removeClass('currentAccordionSection');
        $('#paymentAccordion #headingReviewOrder').css('border-radius', '0 0 25px 25px');
        currentSection = 'none';
    } else {
        $('#headingReviewOrder').addClass('currentAccordionSection');
        $('#headingPaymentMethod').removeClass('currentAccordionSection');
        $('#headingCustomerInformation').removeClass('currentAccordionSection');
        $('#paymentAccordion #headingReviewOrder').css('border-radius', '0');
        currentSection = 'review';
    }
});

// ========================= Clicking the [Next] buttons of the accordion =========================
// Payment Method [Next] button
$('#paymentSubmit').click(function (e) {
    e.preventDefault();
    // show next section
    $('#collapsePaymentMethod').collapse('hide');
    $('#collapseCustomerInformation').collapse('show');

    // updating headings highlights
    currentSection = 'info';
    $('#headingPaymentMethod').removeClass('currentAccordionSection');
    $('#headingCustomerInformation').addClass('currentAccordionSection');
});

// Customer Information [Next] button
$('#infoSubmit').click(function (e) {
    e.preventDefault();
    // show next section
    $('#collapseCustomerInformation').collapse('hide');
    $('#collapseReviewOrder').collapse('show');

    // updating headings highlights
    currentSection = 'review';
    $('#headingCustomerInformation').removeClass('currentAccordionSection');
    $('#headingReviewOrder').addClass('currentAccordionSection');
    $('#paymentAccordion #headingReviewOrder').css('border-radius', '0');
});


// ========================= Getting and displaying customer order items and totals =========================
var userOrder = "Tomato Salad,1,6.00;Chicken Noodle Soup,1,6.00;Egg Sandwich,1,6.50;Apple Juice,2,2.50;Croissant,4,4.50";
sessionStorage.setItem("customerOrderItems", userOrder);

var subtotal = 0;
var gst = 0;
var qst = 0;
var total = 0;

// Adding customer's order items to order summary table and order review table 
function addToOrderSummary() {
    var orders = sessionStorage.getItem("customerOrderItems");
    var orderItem = orders.split(';');
    for (i = 0; i < orderItem.length; i++) {
        var orderItemArr = orderItem[i].split(',');
        // get each values
        var menuItem = orderItemArr[0];
        var itemQuantity = orderItemArr[1];
        var itemPrice = orderItemArr[2];

        // add item price to subtotal
        subtotal += parseFloat(itemPrice);

        // adding ordered items to order summary table
        $('#orderSummaryTable').append("<tr><td>" + menuItem + "</td><td>" + itemQuantity + "</td><td>" + itemPrice + "$</td></tr>");
    }
    // calculating taxes and totals
    gst = 0.05 * subtotal;
    qst = 0.09975 * subtotal;
    total = subtotal + gst + qst;

    // displaying totals and taxes
    $('#orderSummaryTable').append('<tr class="subtotal"><td>Subtotal</td><td></td><td>' + subtotal.toFixed(2) + '$</td></tr>');
    $('#orderSummaryTable').append('<tr class="tax"><td>GST</td><td></td><td>' + gst.toFixed(2) + '$</td></tr>');
    $('#orderSummaryTable').append('<tr class="tax"><td>QST</td><td></td><td>' + qst.toFixed(2) + '$</td></tr>');
    $('#orderSummaryTable').append('<tr class="total"><td>Total</td><td></td><td>' + total.toFixed(2) + '$</td></tr>');

    // displaying for review and order table in accordion
    $('#reviewPlaceOrderTable').append('<tr><td>Subtotal</td><td></td><td>' + subtotal.toFixed(2) + '$</td></tr>');
    $('#reviewPlaceOrderTable').append('<tr><td>GST</td><td></td><td>' + gst.toFixed(2) + '$</td></tr>');
    $('#reviewPlaceOrderTable').append('<tr><td>QST</td><td></td><td>' + qst.toFixed(2) + '$</td></tr>');
    $('#reviewPlaceOrderTable').append('<tr><td>Total</td><td></td><td>' + total.toFixed(2) + '$</td></tr>');
}

addToOrderSummary();

// ========================= Webstorage =========================
// Add user order information to webstorage 
$('#paymentSubmit').click(function () {
    // payment method
    if ($('#visa').is(':checked')) {
        sessionStorage.setItem("paymentmethod", "Visa");
    }else if ($('#mastercard').is(':checked')) {
        sessionStorage.setItem("paymentmethod", "MasterCard");
    }else if ($('#paypal').is(':checked')){
        sessionStorage.setItem("paymentmethod", "PayPal");
    }
});

$('#infoSubmit').click(function () {
    // first name 
    var firstName = $('#firstName').val();
    sessionStorage.setItem("firstname", firstName);
    // last name 
    var lastName = $('#lastName').val();
    sessionStorage.setItem("lastname", lastName);
    // phone number 
    var phone = $('#phoneNumber').val();
    sessionStorage.setItem("phone", phone);
    // email 
    var email = $('#emailAddress').val();
    sessionStorage.setItem("email", email);
    // card number
    var cardNumber = $('#cardNumber').val().substring(12, 16);
    sessionStorage.setItem("cardnum", cardNumber);
});

$('#confirmOrder').click(function () {
    // date and time of cornfirm order
    var orderDateTime = new Date().toLocaleString();
    sessionStorage.setItem("orderDateTime", orderDateTime);
});

// Get user infromation from webstorage to put on receipt
function addToReceipt() {
    // Order date and time
    var orderDateTime = sessionStorage.getItem("orderDateTime");
    $('#orderDate').html(orderDateTime);
    // Payment method
    var paymentMthd = sessionStorage.getItem("paymentmethod");
    $('#customerPaymentMethod').html(paymentMthd);
    // Full name
    var firstName = sessionStorage.getItem("firstname");
    var lastName = sessionStorage.getItem("lastname");
    $('#customerName').html(firstName + " " + lastName);
    // phone number
    var phone = sessionStorage.getItem("phone");
    $('#customerPhoneNumber').html(phone);
    // email
    var email = sessionStorage.getItem("email");
    $('#customerEmail').html(email);
    // card number
    var cardNumber = sessionStorage.getItem("cardnum");
    $('#customerCardNum').html("************" + cardNumber);
}

addToReceipt();