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
    // if user edited name
    if ($('#firstName').val() != "" && $('#lastName').val() != ""){
        sessionStorage.setItem("userFirstName", $('#firstName').val());
        sessionStorage.setItem("userLastName", $('#lastName').val());
        $('#userFullName').html(sessionStorage.getItem("userFirstName") + " " + sessionStorage.getItem("userLastName"));
    }
    // if user edited email
    if ($('#emailAddress').val() != ""){
        sessionStorage.setItem("userEmailAddress", $('#emailAddress').val());
        $('#userEmailAddress').html(sessionStorage.getItem("userEmailAddress"));
    }
    // if user edited phone number
    if ($('#phoneNumber').val() != ""){
        sessionStorage.setItem("userPhoneNum", $('#phoneNumber').val());
        $('#userPhoneNum').html(sessionStorage.getItem("userPhoneNum"));
    }
    // close user information edit popup
    $('#userInfoEditPopup').css("display", "none");
});

$('#editPaymentInfoDone').click(function () {
    // if user edited card number
    if ($('#cardNumber').val() != ""){
        sessionStorage.setItem("userCardNum", $('#cardNumber').val());
        $('#userCardNum').html("************" + sessionStorage.getItem("userCardNum").substr(12,15));
    }
    // closer payment information edit popup
    $('#paymentInfoEditPopup').css("display", "none");
});

// cancel button
$('#editProfileInfoCancel').click(function () {
    $('#userInfoEditPopup').css("display", "none");
});

$('#editPaymentInfoCancel').click(function () {
    $('#paymentInfoEditPopup').css("display", "none");
});

// User Information Displayed 
$( document ).ready(function() {
    // get variables from webstorage
    var userFirstName = sessionStorage.getItem("userFirstName");
    var userLastName = sessionStorage.getItem("userLastName");
    var userEmailAddress = sessionStorage.getItem("userEmailAddress");
    var userPhoneNum = sessionStorage.getItem("userPhoneNum");
    var userCardNum = sessionStorage.getItem("userCardNum");

    if (userFirstName == null || userLastName == null){
        userFirstName = "Firstname";
        userLastName = "Lastname";
    }
    if (userEmailAddress == null){
        userEmailAddress = "No email address provided";
    }
    if (userPhoneNum == null){
        userPhoneNum = "No phone number provided";
    }
    if (userCardNum == null){
        userCardNum = "none";
    }

    $('#userFullName').html(userFirstName + " " + userLastName);
    $('#userEmailAddress').html(userEmailAddress);
    $('#userPhoneNum').html(userPhoneNum);
    $('#userCardNum').html("************" + userCardNum.substr(12,15));
});