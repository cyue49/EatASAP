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
        <div class="editUserInfo">
            <div class="editUserInfoHeader">
                <h3>Edit your profile information</h3>
            </div>
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="editUserInfoForm">
                <fieldset>
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
                    <input type="number" id="phoneNumber" name="phoneNumber" oninput="if(this.value.length>13) this.value = this.value.substr(0, 13);" value="<?php echo $phoneNumber; ?>">
                    <span class="error"> <?php echo $phoneNumberErr ?></span><br><br>
                    <!-- Email Address -->
                    <label for="emailAddress">Email</label><br>
                    <input type="text" id="emailAddress" name="emailAddress" oninput="if(this.value.length>50) this.value = this.value.substr(0, 50);" value="<?php echo $emailAddress; ?>">
                    <span class="error"> <?php echo $emailAddressErr ?></span><br><br>
                </fieldset>
                <!-- Submit -->
                <div class="formButtons">
                    <button class="buttonVar1" type="submit" name="editProfileInfoDone" id="editProfileInfoDone">Done</button>
                    <button class="buttonVar2" type="button" id="editProfileInfoCancel" onclick="window.location.href ='userprofile.php'">Cancel</button>
                </div>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>Eat Asap &copy 2024</p>
    </footer>
</body>

</html>