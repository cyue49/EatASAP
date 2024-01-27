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
        currentSection= 'payment'
    }
});

$('#headingCustomerInformation').click(function () {
    if (currentSection == 'info') {
        $('#headingCustomerInformation').removeClass('currentAccordionSection');
        currentSection = 'none';
    } else {
        $('#headingCustomerInformation').addClass('currentAccordionSection');
        $('#headingPaymentMethod').removeClass('currentAccordionSection');
        $('#headingReviewOrder').removeClass('currentAccordionSection');
        currentSection= 'info'
    }
});

$('#headingReviewOrder').click(function () {
    if (currentSection == 'review') {
        $('#headingReviewOrder').removeClass('currentAccordionSection');
        currentSection = 'none';
    } else {
        $('#headingReviewOrder').addClass('currentAccordionSection');
        $('#headingPaymentMethod').removeClass('currentAccordionSection');
        $('#headingCustomerInformation').removeClass('currentAccordionSection');
        currentSection= 'review'
    }
});