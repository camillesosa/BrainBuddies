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
		// You might want to instead pull from the sql db or even just use a session
		// I'll put the php code below for using the session variable user_id
	</script>
	<?php
		// Getting the phone number from the session
		if(isset($_SESSION['user_id'])){
	        $userPhoneNumber = "{$_SESSION['user_id']}";
		}
		// Now you can use $userPhoneNumber
	?>

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
		<iframe id="video" width="540" height="345" src = "<?php echo $videoLink; ?>" frameborder="0" allow = "accelerometer; autoplay" allowfullscreen>
			</iframe>
			<br><br>			
			<a href="finish.html" class="submit">Finish!</a>
		</div>
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
	  <a href="matches.html" class="navBar">Matches</a>
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

