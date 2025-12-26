<?php 
	
	include_once('config.php');

	$id = $_GET['id'];
	$sql = "UPDATE `events` SET `is_completed` = 'Pending' WHERE id=:id";
	$prep = $conn->prepare($sql);
	$prep->bindParam(':id',$id);
	$prep->execute();

	header("Location: adminEvents.php");
 ?>