document.addEventListener("DOMContentLoaded", function () {
    restaurantinformation();
  console.log("restaurantInformation.js loaded");
});

// JavaScript code for handling button click and status change
// $(document).ready(function () {
//     $("#unsubscribeBtn").click(function () {
//         // Perform AJAX request to update plan status to "Basic"
//         // Update UI accordingly
//     });
// });

function goBack() {
    window.history.back();
}

// Ajax func. to retrieve restaurant information
function restaurantinformation() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '../../../Backend/screens/user/restaurantInformation.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            text = JSON.parse(xhr.responseText);
            document.getElementById("first_name").value = text.first_name;
            document.getElementById("last_name").value = text.last_name;
            document.getElementById("email").value = text.email;
            document.getElementById("user_password").value = text.user_password;
            document.getElementById("phone_number").value = text.phone_number;
            document.getElementById("restaurant_name").value = text.restaurant_name;
            document.getElementById("brand_name").value = text.brand_name;
            document.getElementById("website").value = text.website;
            document.getElementById("restaurant_phone_number").value = text.restaurant_phone_number;
            document.getElementById("restaurant_email").value = text.restaurant_email;
            document.getElementById("address").value = text.address;
            document.getElementById("payment_method").value = text.payment_method;
            document.getElementById("card_number").value = text.card_number;
            document.getElementById("expiration_date").value = text.expiration_date;
            alert(text.restaurant_name);
            // Select the image element by its id
           // var restaurantImage = document.getElementById("restaurant-image");

            // Change the src attribute
           // restaurantImage.src = text.logo_url;
           
            // $response['expiration_date'] = $row['expiration_date'];//for card

        }
    };
    xhr.send();
}