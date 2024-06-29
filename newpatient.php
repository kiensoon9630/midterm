<?php
session_start();
if (!isset($_SESSION["email"]) && !isset($_SESSION["password"])) {
    echo "<script>alert('Please Login')</script>";
    echo "<script>window.location.href = 'login.php'</script>";
}

if (isset($_POST["submit"])) {
    include('dbconnect.php');
    $name = $_POST["name"];
    $icno = $_POST["icno"];
    $phoneno = $_POST["phoneno"];
    $address = $_POST["address"];
    $email = $_POST["email"];
    $sqlregpatient = "INSERT INTO `tbl_patients`(`patient_ic`, `patient_email`, `patient_name`, `patient_phone`, `patient_address`) 
    VALUES ('$icno','$email ','$name','$phoneno','$address')";
    $conn->query($sqlregpatient);
    echo "<script>alert('New Patient Added')</script>";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-  
     awesome/4.7.0/css/font-awesome.min.css">
    <title>My Clinic</title>
    <script>

    function confirmDialog() {
        var r = confirm("Register this patient?");
        if (r == true) {
            return true;
        } else {
            return false;
        }
    }
    </script>
</head>

<body>
    <div class="w3-header w3-container w3-indigo w3-padding-28 w3-center">
        <h1 style="font-size:calc(8px + 4vw);">MYCLINIC</h1>
        <p style="font-size:calc(8px + 1vw);;">We serve the people</p>
    </div>
    <div class="w3-bar w3-blue-gray">
        <a href="index.php" class="w3-bar-item w3-button w3-right">Back</a>
    </div>
    <div style="min-height:100vh;overflow-y: auto;">

        <div class="w3-container">
            <div class="w3-container w3-card" style="max-width:800px;margin:auto;margin-top:10vh;">
                <form class="w3-container w3-padding w3-margin" action="newpatient.php" enctype="multipart/form-data"
                    method="POST" onsubmit="return confirmDialog()" >
                    <h3 class="w3-center">Register New Patient</h3>
                    <label>Patient Name</label>
                    <input class="w3-input w3-border w3-round" type="text" name="name" placeholder="Patient Name"
                        required><br>
                    <label>IC/ID Number</label>
                    <input class="w3-input w3-border w3-round" type="text" name="icno" placeholder="IC Number"
                        required><br>
                    <label>Email</label>
                    <input class="w3-input w3-border w3-round" type="email" name="email" placeholder="Email"
                        required><br>
                    <label>Phone Number</label>
                    <input class="w3-input w3-border w3-round" type="text" name="phoneno" placeholder="Phone Number"
                        required><br>
                    <label>Address</label>
                    <textarea class="w3-input w3-border w3-round" name="address" placeholder="Address" rows="5"
                        required></textarea>
                    <br>
                    <input class="w3-button w3-round w3-indigo" type="submit" name="submit" value="Submit">

                </form>
            </div>
        </div>
    </div>
    <footer class="w3-footer w3-center w3-blue-grey">
        <p>Clinic</p>
    </footer>


</body>

</html>