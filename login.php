<?php
session_start();

if (isset($_POST['email']) && isset($_POST['password'])) {
    include 'dbconnect.php';
    $email = $_POST['email'];
    $entered_password = $_POST['password'];
    $hashed_entered_password = sha1($entered_password);

    // Prepare the SQL statement securely to avoid SQL Injection
    $stmt = $conn->prepare("SELECT * FROM `tbl_admins` WHERE `admin_email` = ? AND `admin_password` = ?");
    $stmt->execute([$email, $hashed_entered_password]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION["email"] = $email;
        echo "<script>alert('Login Success')</script>";
        echo "<script>window.location.href = 'index.php'</script>";
    } else {
        echo "<script>alert('Login failed. Incorrect password or email')</script>";
        echo "<script>window.location.href = 'login.php'</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .input-icon {
            position: relative;
        }
        .input-icon > i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
        }
        .input-icon > input {
            padding-left: 30px;
        }
        .custom-bg-1 {
            background-color: #c2ddde;
        }
        .custom-bg-2 {
            background-color: #92bdf7 ;
        }
    </style>
    <script>
        function rememberMe() {
            var email = document.forms["loginForm"]["idemail"].value;
            var pass = document.forms["loginForm"]["idpass"].value;
            var rememberme = document.forms["loginForm"]["idremember"].checked;
            if (rememberme && email != "" && pass != "") {
                setCookies("cemail", email, 5);
                setCookies("cpass", pass, 5);
                setCookies("cremember", rememberme, 5);
                console.log("COOKIES:" + email, pass, rememberme);
                alert("Credential Stored");
            } else {
                setCookies("cemail", "", 5);
                setCookies("cpass", "", 5);
                setCookies("cremember", rememberme, 5);
                document.forms["loginForm"]["idemail"].value = "";
                document.forms["loginForm"]["idpass"].value = "";
                document.forms["loginForm"]["idremember"].checked = false;
                console.log("COOKIES:" + email, pass, rememberme);
                if (email == "" && pass == "") {
                    alert("Please fill in email and password");
                } else {
                    alert("Credential Removed");
                }

            }
        }

        function setCookies(cookiename, cookiedata, exdays) {
            console.log("COOKIES:" + cookiename);
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = cookiename + "=" + cookiedata + ";" + expires + ";path=/";
        }

        function loadCookies() {
            var email = getCookie("cemail");
            var password = getCookie("cpass");
            var rememberme = getCookie("cremember");
            document.forms["loginForm"]["idemail"].value = email;
            document.forms["loginForm"]["idpass"].value = password;
            if (rememberme && email != "" || password != "") {
                document.forms["loginForm"]["idremember"].checked = true;
            } else {
                document.forms["loginForm"]["idremember"].checked = false;
            }
        }

        function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }
    </script>
    <title>MyClinic</title>

</head>

<body onload="loadCookies()">
    <header class="w3-container w3-center custom-bg-2 w3-padding-32">
        <h1>MY CLINIC</h1>
        <p>Welcome to Your One Stop Health Solution</p>
    </header>
    <div class="w3-bar custom-bg-1">
    <a class="w3-bar-item w3-button">Home</a>
</div>
<div style="min-height:100vh;overflow-y: auto;">
    <div class="w3-container w3-padding-64">
        <div class="w3-card w3-round" style="max-width:600px;margin:auto">
            <div class="w3-container custom-bg-1">
                <h4>Login Form</h4>
            </div>
            <form name="loginForm" class="w3-container" action="login.php" method="post">
                <p>
                    <label class=""><b>Email</b></label>
                    <div class="input-icon">
                        <i class="fas fa-user"></i>
                        <input class="w3-input w3-border w3-round" name="email" type="email"
                        placeholder = "Email" id="idemail" required>
                    </div>
                </p>
                <p>
                    <label class=""><b>Password</b></label>
                    <div class="input-icon">
                        <i class="fas fa-lock"></i>
                        <input class="w3-input w3-border w3-round" name="password" type="password"
                        placeholder = "Password" id="idpass" required>
                    </div>
                </p>
                <p>
                    <input class="w3-check" type="checkbox" id="idremember" onclick="rememberMe()">
                    <label>Remember Me</label>
                </p>
                <p>
                    <button class="w3-btn w3-round custom-bg-1 w3-block" name="submit" value="submit">Login</button>
                </p>
            </form>
        </div>
    </div>
</div>

    <div id="cookieNotice" class="w3-right w3-block" style="display: none;">
        <div class="custom-bg-2">
            <h4>Cookie Consent</h4>
            <p>This website uses cookies or similar technologies, to enhance your
                browsing experience and provide personalized recommendations.
                By continuing to use our website, you agree to our
                <a style="color:#115cfa;" href="/privacy-policy">Privacy Policy</a>
            </p>
            <div class="w3-button">
                <button onclick="acceptCookieConsent();">Accept</button>
            </div>
        </div>
    </div>

    <footer class=" w3-container w3-center custom-bg-2">
        <p>Copyright MyClinic&copy</p>
    </footer>
</body>
<script>
let cookie_consent = getCookie("user_cookie_consent");
if (cookie_consent != "") {
    document.getElementById("cookieNotice").style.display = "none";
} else {
    document.getElementById("cookieNotice").style.display = "block";
}

function deleteCookie(cname) {
    const d = new Date();
    d.setTime(d.getTime() + (24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=;" + expires + ";path=/";
}

function acceptCookieConsent() {
    deleteCookie('user_cookie_consent');
    setCookies('user_cookie_consent', 1, 30);
    document.getElementById("cookieNotice").style.display = "none";
}
</script>

</html>