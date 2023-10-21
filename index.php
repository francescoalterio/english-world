<?php
session_start();

if (!isset($_SESSION['user'])) {
    session_destroy();
    header("Location: login.php");
    return;
}

$user = $_SESSION['user'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>English World</title>
</head>

<body>

    <?php if (!is_null($user)) : ?>
        <h1><?= $user['username'] ?></h1>
        <a href="logout.php">Logout</a>
    <?php endif ?>

    <main>
        <div id="game-container">
            <button id="start">Start</button>
        </div>
    </main>
</body>

<script src="./js/index.js" type="module"></script>

</html>