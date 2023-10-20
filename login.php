<?php

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['email']) || !isset($_POST['password'])) {
        echo "The email and password fields are required";
        die();
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "The email is invalid";
    } elseif (strlen($password) < 6 || strlen($password) > 12) {
        $error = "The password must be between 6 and 12 characters";
    } else {
        require_once("./services/database.php");
        try {
            $db = new Database();
            $data = $db->getUserByEmailAndPassword($email, $password);
            if ($data['status'] === "error") {
                $error = $data['message'];
            } else {
                var_dump($data);
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
    <title>Login | English World</title>
</head>

<body>
    <h1>Login</h1>
    <form action="" method="POST">
        <p id="error" style="display: <?= $error ? "block" : "none" ?>"><?= $error ?></p>
        <label for="email">
            Email
        </label>
        <input id="email" type="email" name="email">
        <label for="password">
            Password
        </label>
        <input id="password" type="password" name="password">
        <button type="submit">Login</button>
    </form>
    <script src="./js/login-validation.js"></script>
</body>

</html>