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
        localStorage.setItem("userFirstName", $('#firstName').val());
        localStorage.setItem("userLastName", $('#lastName').val());
        $('#userFullName').html(localStorage.getItem("userFirstName") + " " + localStorage.getItem("userLastName"));
    }
    // if user edited email
    if ($('#emailAddress').val() != ""){
        localStorage.setItem("userEmailAddress", $('#emailAddress').val());
        $('#userEmailAddress').html(localStorage.getItem("userEmailAddress"));
    }
    // if user edited phone number
    if ($('#phoneNumber').val() != ""){
        localStorage.setItem("userPhoneNum", $('#phoneNumber').val());
        $('#userPhoneNum').html(localStorage.getItem("userPhoneNum"));
    }
    // close user information edit popup
    $('#userInfoEditPopup').css("display", "none");
});

$('#editPaymentInfoDone').click(function () {
    // if user edited card number
    if ($('#cardNumber').val() != ""){
        localStorage.setItem("userCardNum", $('#cardNumber').val());
        $('#userCardNum').html("************" + localStorage.getItem("userCardNum").substr(12,15));
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
    var userFirstName = localStorage.getItem("userFirstName");
    var userLastName = localStorage.getItem("userLastName");
    var userEmailAddress = localStorage.getItem("userEmailAddress");
    var userPhoneNum = localStorage.getItem("userPhoneNum");
    var userCardNum = localStorage.getItem("userCardNum");

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