<?php
// include php file
include_once("../Backend/session.php");
include("../Backend/usersignup.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Sign Up</title>
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

    <style>
        body {
            background-color: var(--bg-color);
        }

        main {
            flex-flow: column;
            justify-content: center;
            align-items: center;
            padding: 3em;
            gap: 3em;
            box-sizing: border-box;
        }

        h1 {
            margin: 1em 0 2em 1em;
        }

        form {
            display: flex;
            flex-flow: column wrap;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 0;
        }

        .wholeform {
            width: 70%;
            min-width: fit-content;
            display: flex;
            flex-flow: column wrap;
            justify-content: flex-start;
            gap: 1em;
            background-color: var(--bg-color);
            border-radius: 25px;
            padding: 2em;
        }

        .wholeform div {
            display: flex;
            flex-flow: column wrap;
            gap: 0.5em;
        }

        input {
            margin: 0.5em 0 0 0;
            padding: 0.7em 1em;
            border-radius: 15px;
            border: 1px solid #3d3d3d;
            width: 100%;
            min-width: 250px;
        }

        select {
            padding: 0.7em 1em;
            border-radius: 20px;
            border: 1px solid #3d3d3d;
            width: 100%;
            min-width: 250px;
        }

        .requiredAsterisk {
            color: red;
        }

        .error {
            color: red;
            font-size: 12px;
        }

        #showPassword,
        #showPassword2 {
            display: flex;
            flex-flow: row nowrap;
            align-items: center;
            gap: 1em;
        }

        #showPassword input,
        #showPassword2 input {
            width: 90%;
        }

        i {
            width: min-content;
        }

        .sign-up-form {
            border-radius: 25px;
            padding: 2em 2em 4em 2em;
            background-color: #f7f7f7;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>

<body>
    <!--Navbar-->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="./index.html"><img src="../Frontend/assets/icons/Logo.svg" alt="logo" style="height: 50px;"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                        <a class="nav-link" href="signup.php">Add Your Restaurant</a>
                    </li>
                    <li class="nav-item text-center px-5 mx-5">
                        <a class="nav-link" href="signin.php">Sign In</a>
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
        <div class="sign-up-form">
            <h1>Sign Up as a Customer</h1>
            <form id="validation" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateFormAndNavigate()">
                <div class="wholeform">
                    <h3>User Information</h3>
                    <!-- First Name -->
                    <div>
                        <label for="firstName">First Name<span class="requiredAsterisk">*</span>:</label>
                        <input type="text" id="firstName" name="firstName" value="<?php echo $firstName; ?>">
                        <span class="error"> <?php echo $firstNameErr ?></span>
                    </div>
                    <!-- Last Name -->
                    <div>
                        <label for="lastName">Last Name<span class="requiredAsterisk">*</span>:</label>
                        <input type="text" id="lastName" name="lastName" value="<?php echo $lastName; ?>">
                        <span class="error"> <?php echo $lastNameErr ?></span>
                    </div>
                    <!-- Email -->
                    <div>
                        <label for="email">Email<span class="requiredAsterisk">*</span>:</label>
                        <input type="text" id="email" name="email" value="<?php echo $email; ?>">
                        <span class="error"> <?php echo $emailErr ?></span>
                    </div>
                    <!-- Phone Number -->
                    <div>
                        <label for="phoneNum">Phone Number<span class="requiredAsterisk">*</span>:</label>
                        <input type="number" id="phoneNum" name="phoneNum" value="<?php echo $phoneNum; ?>">
                        <span class="error"> <?php echo $phoneNumErr ?></span>
                    </div>
                    <!-- User Address -->
                    <div>
                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address" value="<?php echo $address; ?>">
                        <span class="error"> <?php echo $addressErr ?></span>
                    </div>
                    <!-- Password -->
                    <div>
                        <label for="password">Password<span class="requiredAsterisk">*</span>:</label>
                        <div id="showPassword">
                            <input type="password" id="password" name="password" value="<?php echo $password; ?>">
                            <i class="fa fa-eye"></i>
                        </div>
                        <span class="error"> <?php echo $passwordErr ?></span>
                    </div>
                    <!-- Retype Password -->
                    <div>
                        <label for="retypePassword">Retype Password<span class="requiredAsterisk">*</span>:</label>
                        <div id="showPassword2">
                            <input type="password" id="retypePassword" name="retypePassword" value="<?php echo $retypePassword; ?>">
                            <i class="fa fa-eye"></i>
                        </div>
                        <span class="error"> <?php echo $retypePasswordErr ?></span>
                    </div>
                </div>
                <br><br><button type="submit" class="buttonVar1" name="signupButton">Sign Up</button>
            </form>

        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>Eat Asap &copy 2024</p>
    </footer>
    <script>
        // show hide password on click on eye icon
        document.getElementsByClassName("fa-eye")[0].addEventListener("click", showPswd);
        document.getElementsByClassName("fa-eye")[1].addEventListener("click", showPswd2);

        function showPswd() {
            var x = document.getElementById("password");
            if (x.type == "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }

        function showPswd2() {
            var x = document.getElementById("retypePassword");
            if (x.type == "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>

</html>