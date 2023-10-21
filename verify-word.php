<?php
header('Content-Type: application/json; charset=utf-8');
session_start();

if (!isset($_SESSION['user'])) {
    session_destroy();
    echo json_encode(["status" => "error", "message" => "401 Unauthorized"]);
    die();
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (!isset($_POST['id']) || !isset($_POST['translate'])) {
        echo json_encode(["status" => "error", "message" => "400 Bad Request"]);
        die();
    }

    $wordID = $_POST['id'];
    $userTranslation = $_POST['translate'];

    $json = file_get_contents("./dbjson/words.json");
    $words = json_decode($json);

    $wordResult = null;

    foreach ($words as $word) {
        if ($word->id === $wordID) {
            $translateExplode = explode("/", $word->translate);
            $baseExploded = explode("/", $word->base);

            $translateWithTrim = array_map(function ($x) {
                return trim($x);
            }, $translateExplode);

            $baseWithTrim = array_map(function ($x) {
                return trim($x);
            }, $baseExploded);
            $wordResult = ["id" => $word->id, "word" => $word->word, "translate" => $word->translate, "base" => $word->base, "allTranslations" => [...$translateWithTrim, ...$baseWithTrim]];
            break;
        }
    };

    if (!is_null($wordResult)) {
        $userTranslationIsCorrect = false;
        foreach ($wordResult['allTranslations'] as $translation) {
            if ($translation === $userTranslation) {
                $userTranslationIsCorrect = true;
            }
        }
        echo json_encode(["user-translation-is-correct" => $userTranslationIsCorrect]);
        die();
    };
}
