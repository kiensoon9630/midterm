<?php
session_start();
if (!isset($_SESSION["email"]) && !isset($_SESSION["password"])) {
    echo "<script>alert('Please Login')</script>";
    echo "<script>window.location.href = 'login.php'</script>";
}
include('dbconnect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles/mystyle.css">
    <title>My Clinic</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }

        .full-screen-image {
            position: relative;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        .full-screen-image img {
            width: 100%;
            height: 120%;
            object-fit: cover;
        }

        .header-container {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            background-color: #92bdf7; /* Indigo color */
        }

        .header-container h1 {
            font-size: calc(8px + 4vw);
            font-family: monospace;
            margin: 0;
        }

        .header-buttons {
            display: flex;
            gap: 20px;
            margin-left: auto;
            margin-right: auto;
        }

        .header-buttons a {
            padding: 20px 30px;
            font-size: 18px; /* Adjust the font size */
            font-family: monospace; /* Change the font family to Monospace */
            font-weight: bold; /* Make the font bold */
            color: black;
            text-decoration: none;
            border-radius: 4px;
        }

        .header-buttons a:hover {
            background-color: black; /* Darker blue-gray on hover */
            color: white; /* Change text color on hover */
        }

        .text-overlay {
            position: absolute;
            top: 50%;
            left: 10%;
            transform: translateY(-50%);
            width: 80%;
            text-align: left;
            color: black;
        }

        .text-overlay h2 {
            font-size: 2.5em;
            font-weight: bold;
            font-family: monospace;
            margin-bottom: 10px;
        }

        .text-overlay h5 {
            font-size: 1.5em;
            font-family: Times;
            font-style: italic;
        }
        .custom-bg-2 {
            background-color: #92bdf7 ;
        }
    </style>
</head>

<body>
    <div class="header-container">
        <h1>MYCLINIC</h1>
        <div class="header-buttons">
            <a href="newpatient.php" class="w3-bar-item w3-button">New Patient</a>
            <a href="services.php" class="w3-bar-item w3-button">Our Services</a>
            <a href="login.php" class="w3-bar-item w3-button">Logout</a>
           
        </div>
    </div>
    <div class="full-screen-image">
        <img src="doctor.jpg" alt="Doctor Image">
        <div class="text-overlay">
            <h2>Providing Best Online </h2>
            <h2>Clinic to get</h2>
            <h2>Solutions in hand</h2>
            <h5>Good health is state of mental, physical,</h5>
            <h5>and social well-being and it done lot</h5>
        </div>
    </div>
    <footer class=" w3-container w3-center custom-bg-2">
        <p>Copyright MyClinic&copy</p>
    </footer>
</body>

</html>
