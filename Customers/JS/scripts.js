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
        currentSection= 'payment';
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
        currentSection= 'info';
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
        currentSection= 'review';
    }
});

// Clicking the [Next] buttons of the accordion

// Payment Method [Next] button
$('#paymentSubmit').click(function(e){
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
$('#infoSubmit').click(function(e){
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