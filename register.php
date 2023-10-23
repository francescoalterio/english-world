<?php

require "./services/database.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['username']) || !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['repeat-password'])) {
        echo "The username, email, password and repeat-password fields are required";
        die();
    }

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repeatPassword = $_POST['repeat-password'];

    if (strlen($username) < 3 || strlen($username) > 16) {
        $error = "Username must be between 3 and 16 characters";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "The email is invalid or in use";
    } elseif (strlen($password) < 6 || strlen($password) > 12) {
        $error = "The password must be between 6 and 12 characters";
    } elseif ($password !== $repeatPassword) {
        $error = "Passwords do not match";
    } else {
        require_once("./services/database.php");
        try {
            $db = new Database();
            $data = $db->createUser($username, $email, $password);
            if ($data['status'] === "error") {
                $error = $data['message'];
            }
            header("Location: login.php");
        } catch (PDOException $e) {
            $error = "The user could not be created, please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | English World</title>
    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/form.css">
</head>

<body>
    <div class="image-container">
        <img class="presentation-image" src="./assets/signup.svg" alt="">
    </div>
    <div class="info-container">
        <div class="form-container">
            <div class="icon-container">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"></path>
                </svg>
            </div>
            <h1>English World</h1>
            <p class="details">Please enter your details</p>
            <form action="" method="POST">
                <div class="input-container">
                    <p id="error" style="display: <?= $error ? "block" : "none" ?>"><?= $error ?></p>
                    <input placeholder="Username" id="username" type="text" name="username" require>
                    <input placeholder="Email" id="email" type="email" name="email" require>
                    <input placeholder="Password" id="password" type="password" name="password" require>
                    <input placeholder="Repeat Password" id="repeat-password" type="password" name="repeat-password" require>

                </div>

                <div class="submit-container">
                    <button type="submit" class="submit-button">Sign Up</button>
                </div>

            </form>
        </div>
        <div class="redirect-container">
            <p class="redirect-text">Do you already have an account?<a href="login.php" class="redirect-sign">Log In</a></p>
        </div>
    </div>
    <script src="./js/register-validation.js"></script>
</body>

</html>