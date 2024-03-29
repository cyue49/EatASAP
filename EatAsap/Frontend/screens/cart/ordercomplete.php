<?php
include_once("../../../Backend/session.php");
//session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <!-- Icon -->
    <link rel="icon" type="image/x-icon" href="../../assets/icons/Logo.svg" />
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js" defer></script>
    <!-- Bootstrap stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"
        defer></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- html2pdf -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- CSS -->
    <link href="../../constents/common-styles.css" rel="stylesheet" />
    <link href="css/orders-styles.css" rel="stylesheet" />
    <!-- JS -->
    <script src="js/orders-scripts.js" defer></script>
</head>

<body>
    <!--Navbar-->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="../../index.html"><img src=" ../../assets/icons/Logo.svg" alt="logo"
                style="height: 50px;"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 w-100 justify-content-center">
                    <li class="nav-item text-center px-4 mx-5">
                        <a class="nav-link active" aria-current="page" href="../../index.html">Home</a>
                    </li>
                    <li class="nav-item text-center px-5 mx-5">
                        <a class="nav-link" href="../aboutus.html">About</a>
                    </li>
                    <li class="nav-item text-center px-5 mx-5">
                        <a class="nav-link" href="../contactus.html">Contact</a>
                    </li>
                    <!-- Log in or log out -->
                    <?php if (!isUserLoggedIn()) { ?>
                    <li class="nav-item text-center px-5 mx-5">
                        <a id="checkoutSignedInOut" class="nav-link" href="../../signin.php">Log In</a>
                    </li>
                    <?php } else { ?>
                        <li class="nav-item text-center px-5 mx-5">
                        <a id="checkoutSignedInOut" class="nav-link" href="../../../Backend/logout.php">Log Out</a>
                    </li>
                    <?php } ?>
                    </li>
                </ul>

            </div>
            <a class="navbarIcons">
                <i class="fa fa-globe"></i>
            </a>
        </div>
    </nav>

    <main>
        <!-- Left Side -->
        <div class="leftContent">
            <div class="mainContentBox">
                <!-- Restaurant Logo & Name -->
                <div class="restaurantLogoName">
                    <img src="../../assets/pictures/restaurantExampleLogo.png" alt="Restaurant Logo">
                    <h1>Restaurant</h1>
                </div>
                <hr class="separatorLine">
                <!-- Order Number -->
                <div id="orderNumber">
                    <h2>Your Order has been placed!</h2>
                    <p>Please note down your order number: </p>
                    <div class="orderInfo">
                        <h1><?php echo $_SESSION["orderNumber"]; ?></h1>
                    </div>
                    <br>
                    <p>Your are the 9-th in queue, your estimated waiting time is:</p>
                    <div class="orderInfo">
                        <h1>23 minutes</h1>
                    </div>
                    <h2>Thank you for ordering with us!</h2>
                </div>
            </div>
        </div>
        <!-- Right Side -->
        <div class="rightContent">
            <div id="receiptSummary">
                <h2>Receipt Summary</h2>
                <span>
                    <hr class="separatorLine">
                </span>
                <div id="receiptList">
                    <p id="orderDate"><?php echo $_SESSION["orderTime"]; ?></p>
                    <p>ORDER FOR: 
                        <span id="customerName"><?php echo $_SESSION["user_name"]; ?></span>
                        <span id="customerPhoneNumber"><?php echo $_SESSION["customerPhone"]; ?></span>
                        <span id="customerEmail"><?php echo $_SESSION["customerEmail"]; ?></span>
                    </p>
                    <p>ORDER NUMBER: <?php echo $_SESSION["orderNumber"]; ?></p>
                    <p>ITEMS: </p>
                    <ul id="receiptItems">
                        <?php 
                            foreach($_SESSION["orderItems"] as $item){
                                echo $item['itemName'] . " (" . $item['itemPrice'] . "$)". " x" . $item['quantity'] . "<br>";
                            }
                        ?>
                    </ul>
                    <p>SUBTOTAL: <span id="receiptSubtotal"><?php echo $_SESSION["subtotal"]; ?></span></p>
                    <p>GST: <span id="receiptGST"><?php echo $_SESSION["gst"]; ?></span></p>
                    <p>QST: <span id="receiptQST"><?php echo $_SESSION["qst"]; ?></span></p>
                    <p>TOTAL: <span id="receiptTotal"><?php echo $_SESSION["total"]; ?></span></p>
                    <p>PAID BY: 
                        <span id="customerPaymentMethod"><?php echo $_SESSION["paymentMethod"]; ?></span>
                        <span id="customerCardNum"><?php echo $_SESSION["cardNum"]; ?></span>
                    </p>
                </div>
            </div>
            <!-- Buttons -->
            <div class="buttonsGroup">
                <button class="buttonVar1" id="downloadPDF">Download a PDF file of my receipt</button>
                <button class="buttonVar1">Send me a copy of the receipt by email</button>
                <button class="buttonVar1">Notify me by phone when my order is ready</button>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>Eat Asap &copy 2024</p>
    </footer>
</body>

</html>