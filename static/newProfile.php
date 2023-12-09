<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$name = $phone = $gender = $age = $seeking = "";
$seekGender = $seekAge = "";

$name = trim($_POST["name"]);
$phone = trim($_POST["phone"]);
$gender = trim($_POST["gender"]);       // might have to do this one differently
$age = trim($_POST["age"]);
$seeking = trim($_POST["buddy"]);     // might have to do this one differently
$seekGender = trim($_POST["bud-gender"]);   // might have to do this one differently
$seekAge = trim($_POST["bud-age"]);     // might have to do this one differently


    // Prepare a select statement
    $sql = "INSERT INTO users(name, phone, gender, age, seeking, seekGender, seekAge) VALUES ('$name', '$phone', '$gender', '$age', '$seeking', '$seekGender', '$seekAge');";
    //input all entered values into the db

    // Attempt to execute the prepared statement
    $mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($mysqli->connect_error){
	die("Connection failed: ".$mysqli->connect_error);
    }
	$stmt = $mysqli->prepare($sql);
             //Attempt to execute the prepared statement
            if($stmt->execute()){
                // Start a session
                session_start();
                // Using phonenumber as the user id
                $_SESSION["user_id"] = $phone;

                // Redirect to next page
                header("location: /hobbies.html");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
		header("location: /error.html");
            }

    $mysqli->close();
    }

    // Close connection
    mysqli_close($link);
?>