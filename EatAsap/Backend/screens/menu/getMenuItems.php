<?php
include_once("../../session.php");

header("Content-Type: application/json");
//$data = json_decode(file_get_contents ("php://input"), true);
$restaurant_id = 1;//intval($_SESSION["userID"]);
$category_id = 1 ;//$data["category_id"];
$item_status = "1";

require_once "../../DB/config.php";

if (/*!empty($data)*/ $restaurant_id == 1) {
    
    // $sql = "SELECT mi.menu_item_id, mi.item_name, mi.picture_url, mi.price, i.ingredient_name
    // FROM menu_items AS mi
    // JOIN item_ingredients AS ii ON mi.menu_item_id = ii.menu_item_id
    // JOIN ingredient AS i ON ii.ingredient_id = i.ingredient_id
    // WHERE mi.restaurant_id = ?
    // AND mi.category_id = ?
    // AND mi.item_status IN ( ? );
    // ";
    $sql = "SELECT mi.menu_item_id, mi.item_name, mi.picture_url, mi.price
    FROM menu_items AS mi
    WHERE mi.restaurant_id = ?
    AND mi.category_id = ?
    AND mi.item_status IN ( ? );";

    $stmt = mysqli_prepare($link, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt,"iis", $restaurant_id, $category_id,$item_status);
        $success = mysqli_stmt_execute($stmt) or die("Update query failed.".mysqli_error($link));
        
        if ($success) {
            $result = mysqli_stmt_get_result($stmt);
            $rowCount = mysqli_num_rows($result); // Get the number of rows
            
            if ($rowCount > 0) {
                $x=0;
	            while($row=mysqli_fetch_assoc($result)){

		            $response[$x]['menu_item_id']= $row['menu_item_id'];
                    $response[$x]['item_name']= $row['item_name'];
                    $response[$x]['price']= $row['price'];
                    $response[$x]['picture_url']= $row['picture_url'];
                    //$response[$x]['ingredient_name']= $row['ingredient_name'];
		            $x++;
		        }
                //echo json_encode (array("message" => "All correct before prinitng.", "status" =>true));
	            echo json_encode ($response, JSON_PRETTY_PRINT);

            } else {
                echo json_encode(array("message" => "No records Found."));
            }
        } else {
            echo json_encode(array("message" => "Update query failed."));
        }
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(array("message" => "Failed to prepare statement."));
    }
} else {
    echo json_encode(array("message" => "No data received."));
}
?>