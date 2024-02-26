<?php

$firstNameError = $lastNameError = $emailError = $passwordError = $retypePasswordError = $storeAddressError = $storeNameError = $brandNameError = $businessTypeError = $phoneNumberError = "";
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty(trim($_POST["firstName"]))) {
    $firstNameError = "First Name is required.";
} elseif (!preg_match("/^[a-zA-Z-' ]*$/", $_POST["firstName"])) {
    $firstNameError = "Only letters and white space allowed.";
}
if (empty(trim($_POST["lastName"]))) {
  $lastNameError = "Last Name is required.";
} elseif (!preg_match("/^[a-zA-Z-' ]*$/", $_POST["lastName"])) {
  $lastNameError = "Only letters, hyphens, and spaces are allowed.";
} elseif (strlen($_POST["lastName"]) > 30) { // Assuming the max length is 30
  $lastNameError = "Last Name cannot be longer than 30 characters.";
}
if (empty(trim($_POST["email"]))) {
  $emailError = "Email is required.";
} elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
  $emailError = "Invalid email format.";
}

// Check if address is empty
if (empty($storeAddress)) {
  $storeAddressError = "Store address is required.";
// Validate address length
} elseif (strlen($storeAddress) > 255) { // Example limit, adjust based on your database schema
  $storeAddressError = "Store address cannot exceed 255 characters.";
// Basic pattern check (adjust regex as needed)
} elseif (!preg_match("/^[a-zA-Z0-9\s,\.]*$/", $storeAddress)) {
  $storeAddressError = "Invalid characters in address.";
}

// Check if the store name is empty
if (empty($storeName)) {
  $storeNameError = "Store name is required.";
// Validate store name length
} elseif (strlen($storeName) > 60) { // Example: limiting the name length to 60 characters
  $storeNameError = "Store name cannot exceed 60 characters.";
// Validate allowable characters in the store name
} elseif (!preg_match("/^[a-zA-Z0-9\s\-_&]*$/", $storeName)) {
  $storeNameError = "Store name contains invalid characters.";
}
if (empty($brandName)) {
  $brandNameError = "Brand name is required.";
}
// Validate brand name length
elseif (strlen($brandName) > 60) { // Example: Limiting the name length to 60 characters
  $brandNameError = "Brand name cannot exceed 60 characters.";
}
// Validate allowable characters in the brand name
elseif (!preg_match("/^[a-zA-Z0-9\s\-]*$/", $brandName)) {
  $brandNameError = "Brand name contains invalid characters. Only letters, numbers, spaces, and hyphens are allowed.";
}

    // Collect and sanitize input
    $firstName = $conn->real_escape_string($_POST['firstName']);
    $lastName = $conn->real_escape_string($_POST['lastName']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']); // Hash this password
    $phoneNumber = $conn->real_escape_string($_POST['phoneNumber']);

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
    
    if (empty($firstNameError) && empty($lastNameError) && empty($emailError) && empty($passwordError) && empty($retypePasswordError) && empty($storeAddressError) && empty($storeNameError) && empty($brandNameError) && empty($businessTypeError) && empty($phoneNumberError)) {
      // Prepare an insert statement
    $sql = $conn->prepare("INSERT INTO user (first_name, last_name, email, user_password, phone_number, user_role) VALUES (?, ?, ?, ?, ?, ?)");
    $sql->bind_param("ssssss", $firstName, $lastName, $email, $hashedPassword, $phoneNumber);

    // Execute the statement
    if ($sql->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    // Close statement
    $sql->close();
  }
    

    
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <!-- Icon -->
    <link rel="icon" type="image/x-icon" href="Assets/Icons/Logo.svg" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- CSS -->
    <link href="../Frontend/constents/common-styles.css" rel="stylesheet" />
    <link href="../Frontend/index.css" rel="stylesheet" />
    <!-- JS -->
    <script src="../Frontend/index.js"></script>
<!--Bootstrap CSS & JS-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</head>

<body>
   <!--Navbar-->
   <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="./index.html"><img src="../Frontend/assets/icons/Logo.svg" alt="logo" style="height: 50px;"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" >
        <span class="navbar-toggler-icon"></span>
      </button>
      
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 w-100 justify-content-center">
          <li class="nav-item text-center px-4 mx-5">
            <a class="nav-link active" aria-current="page" href="./index.html">Home</a>
          </li>
          <li class="nav-item text-center px-5 mx-5">
            <a class="nav-link" href="./screens/aboutus.html">About</a>
          </li>
          <li class="nav-item text-center px-5 mx-5">
            <a class="nav-link" href="./screens/contactus.html">Contact</a>
          </li>
          <li class="nav-item text-center px-5 mx-5">
            <a class="nav-link" href="./signup.html">Add Your Restaurant</a>
          </li>
          <li class="nav-item text-center px-5 mx-5">
            <a class="nav-link" href="./signin.html">Sign In</a>
          </li>
          
          <!--<li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Menu
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Home</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </li>-->
        </ul>
        
      </div>
      <a class="navbarIcons">
        <i class="fa fa-globe"></i>
    </a>
    </div>
  </nav>

    <!-- Main Content -->
    
    <main >
        <div class="sign-up-form">
          <form id="validation" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return validateFormAndNavigate()"> 
            <h1>Add Your Restaurant</h1>
            <br><br><br><br><br>
            <input type="text" name="firstName" placeholder="First Name" required minlength="2" maxlength="30"><br><br>
            <!--first name-->
            <div class="error-message"><?php echo $firstNameError;?></div>
            <input type="text" name="lastName" placeholder="Last Name" required minlength="2" maxlength="30"><br><br>
            <!--last name-->
            <div class="error-message"><?php echo $lastNameError;?></div>
            <input type="email" name="email" placeholder="Email" required minlength="6" maxlength="60"><br><br>
            <!--email-->
            <div class="error-message"><?php echo $emailError;?></div>
            <input type="password" name="password" id="password" placeholder="Password" required
            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{8,32}"
            title="Password should be between 8 and 32 characters and must contain at least one number, one uppercase letter, 
            one lowercase letter, and one special character.  Length: 8-32 characters."><br><br>
            <!--first name-->
            <div class="error-message"><?php echo $firstNameError;?></div>
            <input value="NA" type="password" name="retypepassword" id="retypePassword" placeholder="Retype Password" required minlength="8" maxlength="32"> <br><br>
            <!--first name-->
            <div class="error-message"><?php echo $firstNameError;?></div>
            <input value="NA" type="address" name="address" placeholder="Store Address" required minlength="6" maxlength="60"> <br><br>
            <!--first name-->
            <div class="error-message"><?php echo $firstNameError;?></div>
            <input value="NA" type="number" name="floorSuite" placeholder="Floor/Suite (Optional)" minlength="1" maxlength="12"><br><br>
            <!--first name-->
            <div class="error-message"><?php echo $firstNameError;?></div>
            <input value="restaurantName" type="text" name="restaurantName"
             placeholder="Store Name On Eat Asap" required minlength="2" maxlength="60"><br><br>
            <!--first name-->
            <div class="error-message"><?php echo $firstNameError;?></div>
            <input value="Brand-Name" type="text" name="brandName" placeholder="Brand Name" required minlength="2" maxlength="60"><br><br>
            <!--first name-->
            <div class="error-message"><?php echo $firstNameError;?></div>
            <select name="businessType" required>
              <option value="NA" disabled selected>Select business type</option>
              <option value="fast_food">Fast Food</option>
              <option value="casual_dining">Casual Dining</option>
              <option value="fine_dining">Fine Dining</option>
              <option value="cafe">Café</option>
              <option value="buffet">Buffet</option>
              <option value="food_truck">Food Truck</option>
              <option value="pop_up">Pop-Up Restaurant</option>
              <option value="fast_casual">Fast Casual</option>
              <option value="bistro">Bistro</option>
              <option value="pub">Pub</option>
              <option value="diner">Diner</option>
              <option value="family_style">Family Style</option>
              <option value="theme">Theme Restaurant</option>
              <option value="steakhouse">Steakhouse</option>
              <option value="seafood">Seafood Restaurant</option>
              <option value="vegetarian_vegan">Vegetarian / Vegan</option>
              <option value="ethnic">Ethnic Cuisine</option>
              <option value="bakery">Bakery</option>
              <option value="deli">Deli</option>
              <option value="pizzeria">Pizzeria</option>
            </select>
            <br><br>
            <input type="number" name="phoneNumber" placeholder="Phone Number" minlength="6" maxlength="18"><br><br>
            <!--first name-->
            <div class="error-message"><?php echo $firstNameError;?></div>
            
            <br><br><button type="submit" class="buttonVar1">Sign Up</button>
          
          </form>
              
        </div>
    </main>

    <!-- Footer -->
    <footer>
      <p>Eat Asap &copy 2024</p>
  </footer>
</body>

</html>