<?php
include 'EATASAP.php';

function validateName($first_name) {
    return preg_match('/^[a-zA-Z ]+$/', $first_name);
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validatePhone($phone) {
    return preg_match('/^\d{10}$/', $phone);
}

function validateMessage($message) {
    return strlen(trim($message)) > 0;
}

$registration_status_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];
   // Validation
   if (validateName($first_name) && validateName($last_name) && validateEmail($email) && validatePhone($phone) && validateMessage($message)) {
    $sql = "INSERT INTO contact_submissions (first_name, last_name, email, phone, message) VALUES (?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssss", $first_name, $last_name, $email, $phone, $message);

        if ($stmt->execute()) {
            $registration_status_message = "Message has been successfully sent!";
                ///////// add to a file
                $data = [
                    'email' => $email,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'phone' => $phone,
                    'message' => $message,     
                ]; 

                $file = 'data.txt';
                $formattedData = "";
                foreach ($data as $key => $value) {
                    $formattedData .= htmlspecialchars($key) . " : " . htmlspecialchars($value) . "\n";
                }
                file_put_contents($file, $formattedData, FILE_APPEND | LOCK_EX); // Append to file and lock the file while writing
                
                
            } else {
                $registration_status_message = $stmt->error;
            }

            $stmt->close();
        } else {
            $registration_status_message = $conn->error;
        }
    } else {
        $registration_status_message = "Invalid input data.";
    }


    //send an email

    // // Email content
    // $to = $email;
    // $subject = "Thank you for contacting us!";
    // $body = "Hello " . $first_name . ",\n\nThank you for your message. We will get back to you shortly.\n\nMessage received:\n" . $message;
    // $headers = "From: m_gichunts@yahoo.com";

    // // Send the email
    // if (mail($to, $subject, $body, $headers)) {
    //     echo "Email sent successfully to " . $email;
    // } else {
    //     echo "Email sending failed.";
    // }



}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template Page</title>
    <!-- Icon -->
    <link rel="icon" type="image/x-icon" href="../assets/icons/Logo.svg" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- CSS -->
    <link href="contactus-styles.css" rel="stylesheet" />
    <script src="https://maps.googleapis.com/maps/api/js?sensor=false&callback=myMap"></script>
    <!-- JS -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"
        defer></script>
    <!-- CSS -->
    <link href="common-styles.css" rel="stylesheet" />
    <!--google map api-->
    <!--
      <script async src="https://maps.googleapis.com/maps/api/js?key=&callback=console.debug&libraries=maps,marker&v=beta">
    </script>
    <style>
      
      gmp-map {
        height: 50%;
        width: 50%;
      margin: 20px auto;
      } -->
</head>

<body>
    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="../../index.html"><img src="../assets/icons/Logo.svg" alt="logo"
                    style="height: 50px;"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 w-100 justify-content-center">
                    <li class="nav-item text-center px-4 mx-5">
                        <a class="nav-link active" aria-current="page" href="../index.html">Home</a>
                    </li>
                    <li class="nav-item text-center px-5 mx-5">
                        <a class="nav-link" href="aboutus.html">About</a>
                    </li>
                    <li class="nav-item text-center px-5 mx-5">
                        <a class="nav-link" href="contactus.html">Contact</a>
                    </li>
                    <li class="nav-item text-center px-5 mx-5">
                        <a class="nav-link" href="../signup.html">Add Your Restaurant</a>
                    </li>
                    <li class="nav-item text-center px-5 mx-5">
                        <a class="nav-link" href="./signin.html">Sign In</a>
                    </li>
                </ul>

            </div>
            <a class="navbarIcons">
                <i class="fa fa-globe"></i>
            </a>
        </div>
    </nav>
    <main>
        <div class="team-contact-section">
            <section class="team">
                <!-- Team member profiles -->
                <div class="profile">
                    <img src="../assets/pictures/profile4.jpeg" alt="Team Member"> 
                    
              
                    <p><b> Sleiman Abou-Antoun</b> <br>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed diam
                        nonummy nibh</p>
                </div>
                <div class="profile">
                    <img src="../assets/pictures/profile1.jpg" alt="Team Member"> 
                    
                    <p><b> Chen Yue</b> <br>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed diam nonummy
                        nibh</p>
                </div>
                <div class="profile">
                    <img src="../assets/pictures/profile2.png" alt="Team Member"> 
                    
                    <p><b> Kawthar Mashkour</b><br>bLorem ipsum dolor sit amet, consectetur adipiscing elit, sed diam
                        nonummy nibh</p>
                </div>
                <div class="profile">
                    <img src="../assets/pictures/profile3.png" alt="Team Member"> 
                    
                    <p><b>Ashot Harutyunyan</b><br>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed diam
                        nonummy nibh</p>
                </div>
            </section>

        </div>
        <section class="contact-info">
            <div class="contact-us-card">
                <div class="contact-form">
                    <h2>CALL US</h2>
                    <p>(+1)-450-110-1010</p>
                </div>
                <div class="location">
                    <div class="icon location-icon"></div>
                    <h2>LOCATION</h2>
                    <p>21 275 Rue Lakeshore Road, Sainte-Anne-de-Bellevue, QC H9X 3L9</p>
                </div>
                <div class="business-hours">
                    <div class="icon clock-icon"></div>
                    <h2>BUSINESS HOURS</h2>
                    <div class="hours">
                        <div class="day">
                            <p>MONDAY</p>
                            <p>10AM - 8PM</p>
                        </div>
                        <div class="day">
                            <p>TUESDAY</p>
                            <p>10AM - 8PM</p>
                        </div>
                        <div class="day">
                            <p>WEDNESDAY</p>
                            <p>10AM - 8PM</p>
                        </div>
                        <div class="day">
                            <p>FRIDAY</p>
                            <p>10AM - 8PM</p>
                        </div>
                        <div class="day">
                            <p>SATURDAY</p>
                            <p>10AM - 9PM</p>
                        </div>
                        <div class="day">
                            <p>SUNDAY</p>
                            <p>CLOSE</p>
                        </div>
                    </div>
                </div>
            </div>

<section class="contact">
    <div class="contact-container">
        <form class="contact-form" action="submit_contact.php" method="post">
            <h2>Contact US</h2>
            <div class="input-group">
                <input type="text" id="first-name" name="first_name" pattern="[a-zA-Z]+" required  >
                <label for="first-name">First Name</label>
            </div>
            <div class="input-group">
                <input type="text" id="last_name" name="last_name" pattern="[a-zA-Z]+" required>
                <label for="last_name">Last Name</label>
            </div>
            <div class="input-group">
                <input type="email" id="email" name="email" required>
                <label for="email">Enter a valid email address</label>
            </div>
            <div class="input-group">
                <input type="tel" id="phone" name="phone" pattern="\d{10}" required>
                <label for="phone">Phone Number</label>
            </div>
            <div class="input-group">
                <textarea id="message" name="message" rows="4"  maxlength="500" required></textarea>
                <label for="message">Enter your message</label>
            </div>
            <button type="submit">SUBMIT</button>
        </form>
    </div>
</section>

        <!-- <iframe src="https://www.google.com/maps/d/u/0/embed?mid=1-VlXsvMWMr8EotfMcIwYKt-1SrI" width="320" height="350" ></iframe> -->
        <iframe class="iframe" width="355" height="300" 
            loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade"
            src="https://www.google.com/maps?q=John+Abbott+College,+21+275+Rue+Lakeshore+Road,+Sainte-Anne-de-Bellevue,+QC&output=embed">
        </iframe>
        <!-- <gmp-map center="45.40653991699219,-73.94169616699219" zoom="14" map-id="DEMO_MAP_ID">
    <gmp-advanced-marker position="45.40653991699219,-73.94169616699219" title="My location"></gmp-advanced-marker>
  </gmp-map>     -->
    </main>

    <footer>
        <p>Eat Asap &copy 2024</p>
    </footer>

    <script>
        const form = document.querySelector('.contact-form');
        const firstName = document.getElementById('first-name');
        const lastName = document.getElementById('last_name');
        const firstNameError = document.createElement('span');
        firstNameError.style.color = 'red';
        firstName.parentNode.insertBefore(firstNameError, firstName.nextSibling);

        form.addEventListener('submit', function(event) {
            if (firstName.value.trim() === ''|| lastName.value.trim() === '') {
                firstNameError.textContent = 'First name and last name are required.';
                event.preventDefault();
            } else if (!/^[a-zA-Z ]+$/.test(firstName.value) || !/^[a-zA-Z ]+$/.test(lastName.value)) {
                firstNameError.textContent = 'First and last name can only contain letters and spaces.';
                event.preventDefault();
            } else {
                firstNameError.textContent = '';
            }
           
        });
    </script>
</body>

</html>