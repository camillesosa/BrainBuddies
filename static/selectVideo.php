<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$animeGamesVideo = $artsVideo = $foodMusicVideo = $outdoorsVideo = $sportsVideo = 0;
$selectedVideo = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['hobbies'])) {
        // Get the selected hobbies
        $selectedHobbies = $_POST['hobbies'];

        foreach ($selectedHobbies as $hobby) {
            // Increment the corresponding video tag for certain hobbies
            if ($hobby == 'anime' || 'cosplay' || 'larping' || 'videogames') {
                $animeGamesVideo = $animeGamesVideo + 1;
            }
            if ($hobby == 'arts-crafts' || 'collecting' || 'fashion' || 'photography') {
                $artsVideo = $artsVideo + 1;
            }
            if ($hobby == 'dancing' || 'exercise' || 'outdoors') {
                $outdoorsVideo = $outdoorsVideo + 1;
            }
            if ($hobby == 'sports' || 'extreme-sports') {
                $sportsVideo = $sportsVideo + 1;
            }
            if ($hobby == 'food' || 'gardening' || 'literature' || 'movies' || 'music') {
                $foodMusicVideo = $foodMusicVideo + 1;
            }
        }
    } else {
        echo "No hobbies selected.";
    }

    if (isset($_POST['bud-hobbies'])) {
        // Get the selected hobbies
        $selectedBudHobbies = $_POST['bud-hobbies'];

        foreach ($selectedBudHobbies as $bhobby) {
            // Increment the corresponding video tag for certain hobbies
            if ($bhobby == 'banime' || 'bcosplay' || 'blarping' || 'bvideogames') {
                $animeGamesVideo = $animeGamesVideo + 1;
            }
            if ($bhobby == 'barts-crafts' || 'bcollecting' || 'bfashion' || 'bphotography') {
                $artsVideo = $artsVideo + 1;
            }
            if ($bhobby == 'bdancing' || 'bexercise' || 'boutdoors') {
                $outdoorsVideo = $outdoorsVideo + 1;
            }
            if ($bhobby == 'bsports' || 'bextreme-sports') {
                $sportsVideo = $sportsVideo + 1;
            }
            if ($bhobby == 'bfood' || 'bgardening' || 'bliterature' || 'bmovies' || 'bmusic') {
                $foodMusicVideo = $foodMusicVideo + 1;
            }
        }
    } else {
        echo "No hobbies selected.";
    }

    // Compare the int video values and pick the highest one
    $maxValue = max($animeGamesVideo, $artsVideo, $foodMusicVideo, $outdoorsVideo, $sportsVideo);

    // If there is a tie, it'll pick the video it encounters first
    if ($maxValue == $animeGamesVideo) {
        $selectedVideo = 'animeGamesVideo';
    } elseif ($maxValue == $artsVideo) {
        $selectedVideo = 'artsVideo';
    } elseif ($maxValue == $foodMusicVideo) {
        $selectedVideo = 'foodMusicVideo';
    } elseif ($maxValue == $outdoorsVideo) {
        $selectedVideo = 'outdoorsVideo';
    } elseif ($maxValue == $sportsVideo) {
        $selectedVideo = 'sportsVideo';
    }

}





    // Prepare a select statement
    $sql = "INSERT INTO users VALUES (name, phone, gender, age, seeking, seekGender, seekAge) = ?";


?>