<?php
session_start();
include "config.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['id'];
$activity_id = $_POST['activity_id'];

// Check if already in favorites
$check = $conn->prepare("
    SELECT id FROM favorites 
    WHERE user_id = :uid AND activity_id = :aid
");
$check->execute([
    ":uid" => $user_id,
    ":aid" => $activity_id
]);

if ($check->rowCount() > 0) {
    // Exists → Unfavorite (delete)
    $delete = $conn->prepare("
        DELETE FROM favorites 
        WHERE user_id = :uid AND activity_id = :aid
    ");
    $delete->execute([
        ":uid" => $user_id,
        ":aid" => $activity_id
    ]);
} else {
    // Does NOT exist → Favorite (insert)
    $insert = $conn->prepare("
        INSERT INTO favorites (user_id, activity_id) 
        VALUES (:uid, :aid)
    ");
    $insert->execute([
        ":uid" => $user_id,
        ":aid" => $activity_id
    ]);
}

header("Location: details.php?id=" . $activity_id);
exit;
?>
