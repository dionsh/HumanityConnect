<?php
session_start();
include_once('config.php');

// Getting values from SESSION
$user_id = $_SESSION['id'];
$activity_id = $_SESSION['activity_id'];

// Getting POST values from details.php form
$user_name = $_POST['name'];
$user_surname = $_POST['surname'];
$user_email = $_POST['email'];
$date = $_POST['date'];
$time = $_POST['time'];

// Inserting the new data into database
$sql = "INSERT INTO events (user_id, activity_id, user_name, user_surname, user_email, date, time)
        VALUES (:user_id, :activity_id, :user_name, :user_surname, :user_email, :date, :time)";
$insertEvent = $conn->prepare($sql);

$insertEvent->bindParam(":user_id", $user_id);
$insertEvent->bindParam(":activity_id", $activity_id);
$insertEvent->bindParam(":user_name", $user_name);
$insertEvent->bindParam(":user_surname", $user_surname);
$insertEvent->bindParam(":user_email", $user_email);
$insertEvent->bindParam(":date", $date);
$insertEvent->bindParam(":time", $time);

$insertEvent->execute();

// Get the last inserted booking ID
$event_id = $conn->lastInsertId();

// Redirect to thank you page
header("Location: thankyou.php?id=" . $event_id);
exit;
?>
