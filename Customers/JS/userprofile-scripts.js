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
// open popup windows with 'edit' icon
$('#editUserInfoPopupButton').click(function () {
    $('#userInfoEditPopup').css("display", "flex");
});

$('#editPaymentMethodPopupButton').click(function () {
    $('#paymentInfoEditPopup').css("display", "flex");
});

// close popu up windows with 'X' icon
$('#closeUserInfoPopup').click(function () {
    $('#userInfoEditPopup').css("display", "none");
});

$('#closePaymentInfoPopup').click(function () {
    $('#paymentInfoEditPopup').css("display", "none");
});

// submit button
$('#editProfileInfoDone').click(function () {
    $('#userInfoEditPopup').css("display", "none");
});

$('#editPaymentInfoDone').click(function () {
    $('#paymentInfoEditPopup').css("display", "none");
});

// cancel button
$('#editProfileInfoCancel').click(function () {
    $('#userInfoEditPopup').css("display", "none");
});

$('#editPaymentInfoCancel').click(function () {
    $('#paymentInfoEditPopup').css("display", "none");
});