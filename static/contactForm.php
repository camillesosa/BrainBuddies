<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$name = $email = $issue = "";


$name = trim($_POST["name"]);
$email = trim($_POST["email"]);
$issue = trim($_POST["issue"])


    // Prepare a select statement
    $sql = "INSERT INTO issues VALUES ('$name', '$email', '$issue');";
    //input all entered values into the db

    // Attempt to execute the prepared statement
    $mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($mysqli->connect_error){
	    die("Connection failed: ".$mysqli->connect_error);
    }
	$stmt = $mysqli->prepare($sql);
             //Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to home
                header("location: home.html");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
		        header("location: error.html");
            }

    $mysqli->close();

?>