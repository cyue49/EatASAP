// Hightlight current section of accordion
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

// Clicking the [Next] buttons of the accordion

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

// Webstorage

// Add user order information to webstorage 
$('#paymentSubmit').click(function () {
    // payment method
    var paymentMthd = $('input[name="paymentMethod"]').val();
    sessionStorage.setItem("paymentmethod", paymentMthd);
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

// Add to order summary table
let userOrder = "Tomato Salad,1,6.00;Chicken Noodle Soup,1,6.00;Egg Sandwich,1,6.50;Apple Juice,2,2.50;Croissant,4,4.50";

let subtotal = 0;
let gst = 0;
let qst = 0;
let total = 0;
let orderTable = document.getElementById('orderSummaryTable');

// add ordered items to order summary
function addToOrderSummary() {
    let orderItem = userOrder.split(';');
    for (let i = 0; i < orderItem.length; i++) {
        let orderItemArr = orderItem[i].split(',');
        // get each values
        let menuItem = orderItemArr[0];
        let itemQuantity = orderItemArr[1];
        let itemPrice = orderItemArr[2];

        // add item price to subtotal
        subtotal += parseFloat(itemPrice);

        // adding ordered items to order summary table
        let newTr = document.createElement("tr");

        let newTd1 = document.createElement("td");
        newTd1.appendChild(document.createTextNode(menuItem));

        let newTd2 = document.createElement("td");
        newTd2.appendChild(document.createTextNode(itemQuantity));

        let newTd3 = document.createElement("td");
        newTd3.appendChild(document.createTextNode(itemPrice + "$"));

        newTr.appendChild(newTd1);
        newTr.appendChild(newTd2);
        newTr.appendChild(newTd3);
        orderTable.appendChild(newTr);
    }
}

function DisplayPrices() {
    // Subtotal
    let newTr = document.createElement("tr");
    newTr.setAttribute("class", "subtotal");

    let newTd1 = document.createElement("td");
    newTd1.appendChild(document.createTextNode("Subtotal"));

    let newTd2 = document.createElement("td");

    let newTd3 = document.createElement("td");
    newTd3.appendChild(document.createTextNode(subtotal.toFixed(2) + "$"));

    newTr.appendChild(newTd1);
    newTr.appendChild(newTd2);
    newTr.appendChild(newTd3);
    orderTable.appendChild(newTr);

    // GST
    gst = 0.05 * subtotal;
    newTr = document.createElement("tr");
    newTr.setAttribute("class", "tax");

    newTd1 = document.createElement("td");
    newTd1.appendChild(document.createTextNode("GST"));

    newTd2 = document.createElement("td");

    newTd3 = document.createElement("td");
    newTd3.appendChild(document.createTextNode(gst.toFixed(2) + "$"));

    newTr.appendChild(newTd1);
    newTr.appendChild(newTd2);
    newTr.appendChild(newTd3);
    orderTable.appendChild(newTr);

    // QST
    qst = 0.09975 * subtotal;

    newTr = document.createElement("tr");
    newTr.setAttribute("class", "tax");

    newTd1 = document.createElement("td");
    newTd1.appendChild(document.createTextNode("QST"));

    newTd2 = document.createElement("td");

    newTd3 = document.createElement("td");
    newTd3.appendChild(document.createTextNode(qst.toFixed(2) + "$"));

    newTr.appendChild(newTd1);
    newTr.appendChild(newTd2);
    newTr.appendChild(newTd3);
    orderTable.appendChild(newTr);

    // Total
    total = subtotal + gst + qst;

    newTr = document.createElement("tr");
    newTr.setAttribute("class", "total");

    newTd1 = document.createElement("td");
    newTd1.appendChild(document.createTextNode("Total"));

    newTd2 = document.createElement("td");

    newTd3 = document.createElement("td");
    newTd3.appendChild(document.createTextNode(total.toFixed(2) + "$"));

    newTr.appendChild(newTd1);
    newTr.appendChild(newTd2);
    newTr.appendChild(newTd3);
    orderTable.appendChild(newTr);
}

addToOrderSummary();
DisplayPrices();