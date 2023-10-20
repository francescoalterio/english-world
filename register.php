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
</head>

<body>
    <h1>Register</h1>
    <form action="" method="POST">
        <p id="error" style="display: <?= $error ? "block" : "none" ?>"><?= $error ?></p>
        <label for="username">
            Username
        </label>
        <input id="username" type="text" name="username" require>
        <label for="email">
            Email
        </label>
        <input id="email" type="email" name="email" require>
        <label for="password">
            Password
        </label>
        <input id="password" type="password" name="password" require>
        <label for="repeat-password">
            Repeat Password
        </label>
        <input id="repeat-password" type="password" name="repeat-password" require>
        <button type="submit">Register</button>
    </form>
    <script src="./js/register-validation.js"></script>
</body>

</html>