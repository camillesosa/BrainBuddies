<?php
// Include config file
//require_once "config.php";
//$phone = $_SESSION["phone"];

// Define variables and initialize with empty values
$animeGamesVideo = $artsVideo = $foodMusicVideo = $outdoorsVideo = $sportsVideo = 0;
$selectedVideo = "";

    if (isset($_POST['hobbies'])) {
        // Get the selected hobbies
        $selectedHobbies = $_POST['hobbies'];

        foreach ($selectedHobbies as $hobby) {
            // Increment the corresponding video tag for certain hobbies
            if ($hobby == 'anime' || $hobby == 'cosplay' || $hobby == 'larping' || $hobby == 'videogames') {
                $animeGamesVideo = $animeGamesVideo + 1;
            }
            if ($hobby == 'arts-crafts' || $hobby == 'collecting' || $hobby == 'fashion' || $hobby == 'photography') {
                $artsVideo = $artsVideo + 1;
            }
            if ($hobby == 'dancing' || $hobby == 'exercise' || $hobby == 'outdoors') {
                $outdoorsVideo = $outdoorsVideo + 1;
            }
            if ($hobby == 'sports' || $hobby == 'extreme-sports' || $hobby == 'winter-sports') {
                $sportsVideo = $sportsVideo + 1;
            }
            if ($hobby == 'food' || $hobby == 'gardening' || $hobby == 'literature' || $hobby == 'movies' || $hobby == 'music') {
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
            if ($bhobby == 'banime' || $bhobby == 'bcosplay' || $bhobby == 'blarping' || $bhobby == 'bvideogames') {
                $animeGamesVideo = $animeGamesVideo + 1;
            }
            if ($bhobby == 'barts-crafts' || $bhobby == 'bcollecting' || $bhobby == 'bfashion' || $bhobby == 'bphotography') {
                $artsVideo = $artsVideo + 1;
            }
            if ($bhobby == 'bdancing' || $bhobby == 'bexercise' || $bhobby == 'boutdoors') {
                $outdoorsVideo = $outdoorsVideo + 1;
            }
            if ($bhobby == 'bsports' || $bhobby == 'bextreme-sports' || $bhobby == 'bwinter-sports') {
                $sportsVideo = $sportsVideo + 1;
            }
            if ($bhobby == 'bfood' || $bhobby == 'bgardening' || $bhobby == 'bliterature' || $bhobby == 'bmovies' || $bhobby == 'bmusic') {
                $foodMusicVideo = $foodMusicVideo + 1;
            }
        }
    } else {
        echo "No hobbies selected.";
    }

    // Compare the int video values and pick the highest one
    $maxValue = max($animeGamesVideo, $artsVideo, $foodMusicVideo, $outdoorsVideo, $sportsVideo);

   // If there are no responses, pick video with largest variety
    // If there is a tie, the first video encountered will be played
    if($maxValue == 0){
        $selectedVideo = "https://www.youtube.com/embed/E3EPxmCSk4U";
    } else if ($maxValue == $animeGamesVideo) {
        $selectedVideo = "https://www.youtube.com/embed/umEHO6h5-3M";
    } elseif ($maxValue == $artsVideo) {
        $selectedVideo = "https://www.youtube.com/embed/f8AtKjU57UU";
    } elseif ($maxValue == $foodMusicVideo) {
        $selectedVideo = "https://www.youtube.com/embed/E3EPxmCSk4U";
    } elseif ($maxValue == $outdoorsVideo) {
        $selectedVideo = "https://www.youtube.com/embed/cEi1ChHgSYI";
    } elseif ($maxValue == $sportsVideo) {
        $selectedVideo = "https://www.youtube.com/embed/oreUwS1AWFM";
    }

    //header("location: $selectedVideo.html");
    header("location: video.php?video=" . urlencode($selectedVideo));
    exit();


    // If we want to add to the db

    // Prepare insert statement
    //$sql = "INSERT INTO users (video) VALUES $selectedVideo WHERE phone = $phone";

    // Attempt to execute the prepared statement
    //$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    //if ($mysqli->connect_error){
	//    die("Connection failed: ".$mysqli->connect_error);
    //}
	//$stmt = $mysqli->prepare($sql);
    //Attempt to execute the prepared statement
    //if($stmt->execute()){
    //    header("location: video.html");
    //} else{
	//	header("location: error.html");
	//	echo "Oops! Something went wrong. Please try again later.";
    //}

    //$mysqli->close();

?>
