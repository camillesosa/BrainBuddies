<?php
	$videoLink = $_GET['video'];
?>

<!DOCTYPE html>
<html>
    <head>
		<meta charset="utf-8"/>
    	<link href="styles.css" rel="stylesheet"/>
    	<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
		<script src="https://code.jquery.com/jquery-3.6.0.js"
		     integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    </head>
    <body>

	<script>
		// Retrieve the phone number from local storage
		var userPhoneNumber = localStorage.getItem('userPhoneNumber');
	</script>

	<script>
		function play_start(){
			$.post("/open_api/play_movie", { "data":"somedata", "any":"data", "user_id": userPhoneNumber },
				function(data, textStatus) {
					//this gets called when browser receives response from server
					console.log(data);
				}, "json").fail( function(response) {
					//this gets called if the server throws an error
					console.log("error");
				console.log(response);});
		}

	</script>

	<script>
		function play_stop(){
			$.post("/open_api/stop_movie", { "data":"somedata", "any":"data", "user_id": userPhoneNumber },
				function(data, textStatus) {
					//this gets called when browser receives response from server
					console.log(data);
				}, "json").fail( function(response) {
					//this gets called if the server throws an error
					console.log("error");
				console.log(response);});
		}

	</script>

	<div class="content-container" style="display: flex; flex-direction: row-reverse; justify-content: center;">
		<div style="position: absolute; top: 200px;">
		<video id="video" width="320" height="240" controls>
		<?php
		    echo "<source src='$videoLink' type='video/mp4'>";
		?>
				Your browser does not support the video tag.
		</video>
		</div>
		<a href="finish.html" class="submit" style="position: absolute; top: 500px; right: 40vw;">Finish!</a>
	</div>
	<header>
    	<h1 id="title">Your Brain Buddy Profile!</h1>
		<label for="prog" style="position: fixed; left: 40vw">Progress:</label>
		<progress id="prog" value="75" max="100" style="text-align: center;"> 75% </progress>
		<br><br>
	</header>
	<nav>
	  <a href="home.html" class="navBar">Home</a>
	  <a href="faq.html" class="navBar">FAQ</a>
	  <a href="contact.html" class="navBar">Contact Us</a>
	</nav>


	<script>
		video.addEventListener("play", (event) => {
			play_start();
		});
		video.addEventListener("pause", (event) => {
			play_stop();
		});
	</script>

    </body>
</html>

