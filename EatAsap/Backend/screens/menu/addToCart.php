<?php
include_once '../../session.php';


// Function to check if an item with the given ID exists in the cart
function itemExistsInCart($id) {   
    
    $x=0;
    foreach ($_SESSION["cart"] as $item) {
     if ($item["id"]) {
        echo json_encode(array($item));
        if ($item["id"] == $id) {
            return $x;
        }else {
            $x++;
        }
     }
    }
    return false;
}

// Function to add an item to the cart
function addItemToCart($id) {
    // Initialize $_SESSION["cart"] if it's not already set
    if (!isset($_SESSION["cart"])) {
        $_SESSION["cart"] = array();
    }
    // Check if the item already exists in the cart
    $index = itemExistsInCart($id);

    // If the item exists, increment its quantity by 1
    if ($index !== false) {
        $_SESSION["cart"][$index]['quantity']++;
    } else {
        // If the item doesn't exist, add it to the cart with a quantity of 1
        $_SESSION["cart"][] = array('id' => $id, 'quantity' => 1);
    }
    return $_SESSION["cart"];
}
// function addToCart($item_id) {
//     if (!isset($_SESSION['cart']))  {
//         $_SESSION['cart'] = [];
//         $itemToAdd = array(array('id' => $item_id, 'quantity' => 1));
//         array_push($_SESSION['cart'], $itemToAdd);

//     }elseif ($_SESSION['cart']['id'] == $item_id) {
//         $itemToAdd = array(array('id' => $item_id, 'quantity' => 3));
//         array_push($_SESSION['cart'], $itemToAdd);
//     }

//     return $_SESSION['cart'];

// };

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   //$_SESSION["cart"] = array();
    // Retrieve the raw POST data
    $data = file_get_contents("php://input");

    // Decode the JSON string into a PHP object
    $item = json_decode($data);

    // Check if decoding was successful
    if ($item !== null) {
        // Sanitize specific strings if needed
        // For example, if $item->value is a string you want to sanitize:
        // $item->value = htmlspecialchars($item->value);
        //$item = htmlspecialchars($item);
        // Now $item contains the decoded JSON data, safe to use in your application
        $itemAdded = addItemToCart((int)$item);
        echo json_encode(array($itemAdded));
    } else {
        // Handle JSON decoding error
        http_response_code(400); // Bad Request
        echo json_encode(array("error" => "Invalid JSON data"));
    }
}


?>