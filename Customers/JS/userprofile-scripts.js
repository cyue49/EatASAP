// Toggle between up and down arrows for order history collapsible
$(".fa-angle-down").on('click', function (event) {
    $(this).next().css("display", "block");
    $(this).css("display", "none");
});

$(".fa-angle-up").on('click', function (event) {
    $(this).prev().css("display", "block");
    $(this).css("display", "none");
});

// Edit user info & payment info popups
$('#editUserInfoPopupButton').click(function () {
    $('#userInfoEditPopup').css("display", "flex");
});

$('#editPaymentMethodPopupButton').click(function () {
    $('#paymentInfoEditPopup').css("display", "flex");
});

$('#closeUserInfoPopup').click(function () {
    $('#userInfoEditPopup').css("display", "none");
});

$('#closePaymentInfoPopup').click(function () {
    $('#paymentInfoEditPopup').css("display", "none");
});