<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$videoOne = $videoTwo = $videoThree = $videoFour = $videoFive = 0;
$selectedVideo = "";

$anime = trim($_POST["anime"]);
$cosplay = trim($_POST["cosplay"]);
$larping = trim($_POST["larping"]);
$videogames = trim($_POST["videogames"]);

$arts = trim($_POST["arts-crafts"]);
$collecting = trim($_POST["collecting"]);
$fashion = trim($_POST["fashion"]);
$photo = trim($_POST["photography"]);

$dancing = trim($_POST["dancing"]);
$exercise = trim($_POST["exercise"]);
$outdoors = trim($_POST["outdoors"]);

$sports = trim($_POST["sports"]);
$xtreme = trim($_POST["extreme-sports"]);

$food = trim($_POST["food"]);
$gardening = trim($_POST["gardening"]);
$lit = trim($_POST["literature"]);
$movies = trim($_POST["movies"]);
$music = trim($_POST["music"]);



$banime = trim($_POST["banime"]);
$bcosplay = trim($_POST["bcosplay"]);
$blarping = trim($_POST["blarping"]);
$bvideogames = trim($_POST["bvideogames"]);

$barts = trim($_POST["barts-crafts"]);
$bcollecting = trim($_POST["bcollecting"]);
$bfashion = trim($_POST["bfashion"]);
$bphoto = trim($_POST["bphotography"]);

$bdancing = trim($_POST["bdancing"]);
$bexercise = trim($_POST["bexercise"]);
$boutdoors = trim($_POST["boutdoors"]);

$bsports = trim($_POST["bsports"]);
$bxtreme = trim($_POST["bextreme-sports"]);

$bfood = trim($_POST["bfood"]);
$bgardening = trim($_POST["bgardening"]);
$blit = trim($_POST["bliterature"]);
$bmovies = trim($_POST["bmovies"]);
$bmusic = trim($_POST["bmusic"]);



    // Prepare a select statement
    $sql = "INSERT INTO users VALUES (name, phone, gender, age, seeking, seekGender, seekAge) = ?";


?>