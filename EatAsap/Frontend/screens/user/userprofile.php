<?php
// include php file
include_once("../../../Backend/session.php");
include("../../../Backend/screens/user/customeruser.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile</title>
    <!-- Icon -->
    <link rel="icon" type="image/x-icon" href="../../assets/icons/Logo.svg" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js" defer></script>
    <!-- Bootstrap stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous" defer></script>
    <!-- CSS -->
    <link href="../../constents/common-styles.css" rel="stylesheet" />
    <link href="css/user-profile-styles.css" rel="stylesheet" />
    <!-- JS -->
    <script src="js/userprofile-scripts.js" defer></script>
</head>

<body>
    <!--Navbar-->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="../../index.html"><img src=" ../../assets/icons/Logo.svg" alt="logo" style="height: 50px;"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                    <li class="nav-item text-center px-5 mx-5">
                        <a class="nav-link" href="../../index.html">Sign Out</a>
                    </li>
                </ul>

            </div>
            <a class="navbarIcons">
                <i class="fa fa-globe"></i>
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <div class="mainContentBox">
            <!-- User Information Section -->
            <div class="profileHeader">
                <div id="profilePic">
                    <img src="../../assets/pictures/userProfilePic.png" alt="User profile picture">
                </div>
                <div class="infoBox">
                    <span class="infoLineHeader">
                        <h2><?php echo $firstName . " " . $lastName; ?></h2><a href="edituserprofile.php"><i class="fa fa-edit"></i></a>
                    </span>
                    <span class="infoLine"><i class="fa fa-envelope"></i>
                        <p><?php echo $emailAddress; ?></p>
                    </span>
                    <span class="infoLine"><i class="fa fa-phone"></i>
                        <p><?php echo $phoneNumber; ?></p>
                    </span>
                </div>
                <div class="infoBox">
                    <span class="infoLineHeader">
                        <h2>Payment Information</h2><a href="edituserpayment.php"><i class="fa fa-edit"></i></a>
                    </span>
                    <span class="infoLine"><i class="fa fa-cc-visa"></i></i>
                        <p>Payment Method: <?php echo $paymentMethod; ?></p>
                    </span>
                    <span class="infoLine"><i class="fa fa-credit-card"></i>
                        <p>Card Number: <?php echo "************" . substr($cardNumber, 12);; ?></p>
                    </span>
                </div>
            </div>
            <hr class="separatorLine">
            <!-- Order History Section -->
            <div class="orderHistorySection">
                <h2>Order History</h2>
                <!-- orders -->
                <?php
                $orders = getOrderIds();
                foreach ($orders as $orderID) {
                ?>
                    <div class="orderHistory">
                        <?php printAnOrderHistoryHeader($orderID); ?>
                        <p class="orderHistoryMoreLink">
                            <a data-bs-toggle="collapse" href="#collapsedHistory" role="button" aria-expanded="false" aria-controls="collapsedHistory">
                                <i class="fa fa-angle-down"></i>
                                <i class="fa fa-angle-up"></i>
                            </a>
                        </p>
                        <div class="collapse" id="collapsedHistory">
                            <div class="card card-body">
                                <?php printAnOrderHistoryItems($orderID); ?>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>Eat Asap &copy 2024</p>
    </footer>
</body>

</html>