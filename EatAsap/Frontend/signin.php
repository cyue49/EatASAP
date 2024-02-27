<?php
// include php file
include_once("../Backend/session.php");
include("../Backend/usersignin.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <!-- Icon -->
    <link rel="icon" type="image/x-icon" href="./assets/icons/Logo.svg" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- CSS -->
    <link href="./constents/common-styles.css" rel="stylesheet" />
    <link href="./index.css" rel="stylesheet" />
    <!-- JS -->
    <script src="./index.js"></script>
    <!--Bootstrap CSS & JS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <style>
        main {
            flex-flow: column;
            justify-content: flex-start;
            align-items: center;
            padding: 3em;
            gap: 3em;
            box-sizing: border-box;
        }

        h1 {
            margin: 1em 0 2em 0;
        }

        form {
            display: flex;
            flex-flow: column wrap;
            justify-content: flex-start;
            gap: 1em;
        }

        form div {
            display: flex;
            flex-flow: column wrap;
            gap: 0.5em;
        }

        input {
            margin: 0.5em 0 0 0;
            padding: 0.7em 1em;
            border-radius: 15px;
            border: 1px solid #3d3d3d;
            width: 40%;
            min-width: 250px;
        }

        select {
            padding: 0.7em 1em;
            border-radius: 20px;
            border: 1px solid #3d3d3d;
            width: 40%;
            min-width: 250px;
        }

        .requiredAsterisk {
            color: red;
        }

        .error {
            color: red;
            font-size: 12px;
        }

        .showPassword {
            display: flex;
            flex-flow: row nowrap;
            align-items: center;
            gap: 1em;
        }

        .sign-in-form {
            border-radius: 25px;
            padding: 2em 4em 4em 4em;
        }
    </style>
</head>

<body>
    <!--Navbar-->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="./index.html"><img src="./assets/icons/Logo.svg" alt="logo" style="height: 50px;"></a>
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

        <div class="sign-in-form">

            <h1>Sign In</h1>

            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <!-- Role -->
                <div>
                    <label for="role">Sign in as<span class="requiredAsterisk">*</span>:</label>
                    <select id="role" name="role">
                        <option value="">Select</option>
                        <option value="owner" <?php if (isset($_POST['role']) && $role == "owner") echo "selected"; ?>>Restaurant Owner</option>
                        <option value="customer" <?php if (isset($_POST['role']) && $role == "customer") echo "selected"; ?>>Customer</option>
                    </select>
                    <span class="error"> <?php echo $roleErr ?></span>
                </div>
                <!-- Email -->
                <div>
                    <label for="email">Email<span class="requiredAsterisk">*</span>:</label>
                    <input type="text" id="email" name="email" value="<?php echo $email; ?>">
                    <span class="error"> <?php echo $emailErr ?></span>
                </div>
                <!-- Password -->
                <div>
                    <label for="pswd">Password<span class="requiredAsterisk">*</span>:</label>
                    <div class="showPassword">
                        <input type="password" id="pswd" name="pswd" value="<?php echo $pswd; ?>">
                        <i class="fa fa-eye"></i>
                    </div>
                    <span class="error"> <?php echo $pswdErr ?></span>
                </div>
                <!-- Submit -->
                <button type="submit" class="buttonVar1" name="signinButton">Sign In</button>
                <span class="error"> <?php echo $loginErr ?></span>
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

        function showPswd() {
            var x = document.getElementById("pswd");
            if (x.type == "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>

</html>