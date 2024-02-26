<?php
// include php file
include("../../../Backend/screens/cart/order.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <!-- Icon -->
    <link rel="icon" type="image/x-icon" href="../../assets/icons/Logo.svg" />
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js" defer></script>
    <!-- Bootstrap stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous" defer></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                        <a id="checkoutSignedInOut" class="nav-link" href="../../signin.html">Sign In</a>
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
                <!-- Order Summary -->
                <div class="orderSummary">
                    <h2>Order Summary</h2>
                    <table id="orderSummaryTable">
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Price Per Unit</th>
                            <th>Edit</th>
                        </tr>
                        <?php
                        foreach ($cartItems as $item) {
                            echo "<tr>" .
                                "<td>" . $item["itemName"] . "</td>" .
                                "<td>" . $item["quantity"] . "</td>" .
                                "<td>" . $item["itemPrice"] . "$</td>" .
                                "<td class='editDelete'>" .
                                "<a href='myorders.php?additem=" . $item['itemID'] . "'><i class='fa fa-plus'></i></a>" .
                                "<a href='myorders.php?minitem=" . $item['itemID'] . "'><i class='fa fa-minus'></i></a>" .
                                "<a href='myorders.php?delitem=" . $item['itemID'] . "'><i class='fa fa-trash-o'></i></a>" .
                                "</td>" .
                                "</tr>";
                        }
                        echo '<tr class="subtotal">' .
                            '<td>Subtotal</td>' .
                            '<td></td>' .
                            '<td></td>' .
                            '<td>' . $subtotal . '$</td>' .
                            '</tr>';
                        echo '<tr class="tax">' .
                            '<td>GST</td>' .
                            '<td></td>' .
                            '<td></td>' .
                            '<td>' . $gst . '$</td>' .
                            '</tr>';
                        echo '<tr class="tax">' .
                            '<td>QST</td>' .
                            '<td></td>' .
                            '<td></td>' .
                            '<td>' . $qst . '$</td>' .
                            '</tr>';
                        echo '<tr class="total">' .
                            '<td>Total</td>' .
                            '<td></td>' .
                            '<td></td>' .
                            '<td>' . $total . '$</td>' .
                            '</tr>';
                        ?>
                    </table>
                    <button class="buttonVar2" id="modifyOrder" onclick="window.location.href ='../menu/menu.html'">Continue
                        ordering</button>
                </div>
            </div>
        </div>
        <!-- Right Side -->
        <div class="rightContent">
            <!-- Payment Accordion -->
            <div class="accordion" id="paymentAccordion">
                <!-- Customer Information -->
                <div id="accordionItemFirst" class="accordion-item">
                    <a class="accordion-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseCustomerCheckoutForm" aria-expanded="false" aria-controls="collapseCustomerCheckoutForm">
                        <h3 class="accordion-header" id="headingCustomerCheckoutForm">
                            Enter Your Information
                        </h3>
                    </a>
                    <div id="collapseCustomerCheckoutForm" class="accordion-collapse collapse show" aria-labelledby="headingCustomerCheckoutForm" data-bs-parent="#paymentAccordion">
                        <div id="customerCheckoutFormBody" class="accordion-body">
                            <span class="error"> <?php echo $generalError ?></span>
                            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <fieldset>
                                    <legend>Customer Information</legend>
                                    <!-- First Name -->
                                    <label for="firstName">First Name</label><br>
                                    <input type="text" name="firstName" id="firstName" oninput="if(this.value.length>20) this.value = this.value.substr(0, 20);" value="<?php echo $firstName; ?>">
                                    <span class="error"> <?php echo $firstNameErr ?></span><br><br>
                                    <!-- Last Name -->
                                    <label for="lastName">Last Name</label><br>
                                    <input type="text" name="lastName" id="lastName" oninput="if(this.value.length>20) this.value = this.value.substr(0, 20);" value="<?php echo $lastName; ?>">
                                    <span class="error"> <?php echo $lastNameErr ?></span><br><br>
                                    <!-- Phone Number -->
                                    <label for="phoneNumber">Phone Number</label><br>
                                    <input type="number" id="phoneNumber" name="phoneNumber" placeholder="5141234567" oninput="if(this.value.length>13) this.value = this.value.substr(0, 13);" value="<?php echo $phoneNumber; ?>">
                                    <span class="error"> <?php echo $phoneNumberErr ?></span><br><br>
                                    <!-- Email Address -->
                                    <label for="emailAddress">Email</label><br>
                                    <input type="text" id="emailAddress" name="emailAddress" oninput="if(this.value.length>50) this.value = this.value.substr(0, 50);" value="<?php echo $emailAddress; ?>">
                                    <span class="error"> <?php echo $emailAddressErr ?></span><br><br>
                                </fieldset>
                                <fieldset>
                                    <legend>Payment Method</legend>
                                    <div id="paymentRadioSelect">
                                        <div>
                                            <i class="fa fa-cc-visa"></i>
                                            <input type="radio" name="paymentMethod" id="visa" value="Visa" <?php if ((isset($_POST['paymentMethod']) || $paymentMethod == "Visa") && $paymentMethod == "Visa") echo "checked"; ?>>
                                            <label for="visa">Visa</label><br>
                                        </div>
                                        <div>
                                            <i class="fa fa-cc-mastercard"></i>
                                            <input type="radio" name="paymentMethod" id="mastercard" value="MasterCard" <?php if ((isset($_POST['paymentMethod']) || $paymentMethod == "MasterCard") && $paymentMethod == "MasterCard") echo "checked"; ?>>
                                            <label for="mastercard">MasterCard</label><br>
                                        </div>
                                    </div>
                                    <br><span class="error"> <?php echo $paymentMethodErr ?></span><br>
                                </fieldset>
                                <fieldset>
                                    <legend>Payment Information</legend>
                                    <!-- Card Number -->
                                    <label for="cardNumber">Card Number</label><br>
                                    <input type="number" id="cardNumber" name="cardNumber" maxlength="16" oninput="if(this.value.length>16) this.value = this.value.substr(0, 16);" value="<?php echo $cardNumber; ?>">
                                    <span class="error"> <?php echo $cardNumberErr ?></span><br><br>
                                    <!-- CVV -->
                                    <label for="cvv">CVV/CVC</label><br>
                                    <input type="number" id="cvv" name="cvv" maxlength="3" oninput="if(this.value.length>3) this.value = this.value.substr(0, 3);" value="<?php echo $cvv; ?>">
                                    <span class="error"> <?php echo $cvvErr ?></span><br><br>
                                    <!-- Expiration Date -->
                                    <label for="expirationDate">Expiration Date</label><br>
                                    <input type="month" id="expirationDate" name="expirationDate" value="<?php echo $expirationDate; ?>">
                                    <span class="error"> <?php echo $expirationDateErr ?></span><br><br>
                                </fieldset>
                                <!-- Submit -->
                                <button class="buttonVar1" type="submit" name="formSubmit" id="formSubmit">Next</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Review and Confirm Order -->
                <div class="accordion-item">
                    <a class="accordion-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseReviewOrder" aria-expanded="false" aria-controls="collapseReviewOrder">
                        <h3 class="accordion-header" id="headingReviewOrder">
                            Review and Place Order
                        </h3>
                    </a>
                    <div id="collapseReviewOrder" class="accordion-collapse collapse" aria-labelledby="headingReviewOrder" data-bs-parent="#paymentAccordion">
                        <div class="accordion-body">
                            Please confirm the following order summary, then click on <em>Confrim Order</em> to place
                            your order.
                            <table id="reviewPlaceOrderTable">
                                <?php
                                echo '<tr>' .
                                    '<td>Subtotal</td>' .
                                    '<td></td>' .
                                    '<td>' . $subtotal . '$</td>' .
                                    '</tr>';
                                echo '<tr>' .
                                    '<td>GST</td>' .
                                    '<td></td>' .
                                    '<td>' . $gst . '$</td>' .
                                    '</tr>';
                                echo '<tr>' .
                                    '<td>QST</td>' .
                                    '<td></td>' .
                                    '<td>' . $qst . '$</td>' .
                                    '</tr>';
                                echo '<tr>' .
                                    '<td>Total</td>' .
                                    '<td></td>' .
                                    '<td>' . $total . '$</td>' .
                                    '</tr>';
                                ?>
                            </table>
                            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <button class="buttonVar1" type="submit" name="confirmOrder" id="confirmOrder">Confirm Order</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Quick Checkout Button -->
            <div class="buttonsGroup">
                <button id="quickOrderSignInButton" class="buttonVar1" onclick="window.location.href ='../../signin.php?redirect=screens/cart/myorders.php'">Sign In for Quick
                    Order</button>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>Eat Asap &copy 2024</p>
    </footer>
</body>

</html>