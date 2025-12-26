<?php 

	include_once('config.php');
	


	if (isset($_POST['submit1'])) {
		$id = $_POST['id'];
		$activity_name = $_POST['activity_name'];
		$activity_desc = $_POST['activity_desc'];
		$activity_quality = $_POST['activity_quality'];
		  $activity_location=$_POST['activity_location'];
		

		$sql = "UPDATE activities SET id=:id,  activity_name=:activity_name, activity_desc=:activity_desc, activity_quality=:activity_quality, activity_location=:activity_location WHERE id=:id";

		$prep = $conn->prepare($sql);
		$prep->bindParam(':id',$id);
		$prep->bindParam(':activity_name',$activity_name);
		$prep->bindParam(':activity_desc',$activity_desc);
		$prep->bindParam(':activity_quality',$activity_quality);
		$prep->bindParam(':activity_location',$activity_location);
		
		$prep->execute();
		header("Location: adminHome.php");
	}
 ?>