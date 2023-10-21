<?php
session_start();

if (!isset($_SESSION['user'])) {
    session_destroy();
    echo json_encode(["status" => "error", "message" => "401 Unauthorized"]);
    die();
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $json = file_get_contents("./dbjson/words.json");
    $words = json_decode($json);
    $wordsLength = count($words);

    $limit = 10;

    if (isset($_GET['limit'])) {
        if (!is_numeric($_GET['limit'])) {
            echo json_encode(["status" => "error", "message" => "limit format must be numeric"]);
            die();
        }
        $numeric = (int) $_GET['limit'];
        if ($numeric <= $wordsLength) {
            $limit = $numeric;
        } else {
            echo json_encode(["status" => "error", "message" => "limit must be less than: $wordsLength"]);
            die();
        }
    }

    $ids = [];

    while (count($ids) < $limit) {
        $randomNumber = rand(0, 999);
        if (!in_array($randomNumber, $ids)) {
            array_push($ids, $randomNumber);
        }
    }

    $result = [];

    foreach ($ids as $id) {
        $word = $words[$id];
        array_push($result, ["id" => $word->id, "word" => $word->word]);
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($result);
    die();
}
