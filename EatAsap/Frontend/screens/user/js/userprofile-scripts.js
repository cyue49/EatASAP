// Toggle between up and down arrows for order history collapsible
$(".fa-angle-down").on('click', function (event) {
    $(this).next().css("display", "block");
    $(this).css("display", "none");
});

$(".fa-angle-up").on('click', function (event) {
    $(this).prev().css("display", "block");
    $(this).css("display", "none");
});


// User Information Displayed 
$( document ).ready(function() {
    // get variables from webstorage
    var userFirstName = localStorage.getItem("userFirstName");
    var userLastName = localStorage.getItem("userLastName");
    var userEmailAddress = localStorage.getItem("userEmailAddress");
    var userPhoneNum = localStorage.getItem("userPhoneNum");
    var userPaymentmethod = localStorage.getItem("userPaymentmethod");
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
    if (userPaymentmethod == null){
        userPaymentmethod = "none";
    }

    $('#userFullName').html(userFirstName + " " + userLastName);
    $('#userEmailAddress').html(userEmailAddress);
    $('#userPhoneNum').html(userPhoneNum);
    $('#userPaymentmethod').html(userPaymentmethod);
    $('#userCardNum').html("************" + userCardNum.substr(12,15));
});