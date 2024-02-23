// ========================= Hightlight current section of accordion =========================
$('#headingCustomerCheckoutForm').addClass('currentAccordionSection');
var currentSection = 'info';

$('#headingCustomerCheckoutForm').click(function () {
    if (currentSection == 'info') {
        $('#headingCustomerCheckoutForm').removeClass('currentAccordionSection');
        currentSection = 'none';
    } else {
        $('#headingCustomerCheckoutForm').addClass('currentAccordionSection');
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
        $('#headingCustomerCheckoutForm').removeClass('currentAccordionSection');
        $('#paymentAccordion #headingReviewOrder').css('border-radius', '0');
        currentSection = 'review';
    }
});

// ========================= Clicking the [Next] buttons of the accordion =========================
// Customer Checkout Form [Next] button

if (validCustomerForm) {
    // show next section
    $('#collapseCustomerCheckoutForm').collapse('hide');
    $('#collapseReviewOrder').collapse('show');

    // updating headings highlights
    currentSection = 'review';
    $('#headingCustomerCheckoutForm').removeClass('currentAccordionSection');
    $('#headingReviewOrder').addClass('currentAccordionSection');
    $('#paymentAccordion #headingReviewOrder').css('border-radius', '0');
}

// ========================= Saving the receipt as pdf button =========================
$('#downloadPDF').click(function () {
    let element = document.getElementById('receiptList');
    element.style.maxHeight = "100%";
    const opt = {
        filename: "Receipt.pdf",
        margin: 10,
        image: { type: "png", quality: 0.95 },
        html2canvas: { scale: 2, scrollX: 0, scrollY: 0 }
    };
    html2pdf().set(opt).from(element).toPdf().get('pdf').then(function (pdf) {
        window.open(pdf.output('bloburl'), '_blank');
    });
});
