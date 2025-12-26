<?php 
session_start();
include_once('config.php');

if (!isset($_GET['id'])) {
    header("Location: home.php");
    exit;
}

$event_id = $_GET['id'];


$sql = "SELECT e.*, u.username, a.activity_name 
        FROM events e
        JOIN users u ON e.user_id = u.id
        JOIN activities a ON e.activity_id = a.id
        WHERE e.id = :event_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam("event_id", $event_id);
$stmt->execute();
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
    echo "Event not found!";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thank You - Event Confirmed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
<link rel="manifest" href="images/site.webmanifest">
    <link rel="icon" type="image/ico"  href="images/favicon.ico">
    <style>
        /* Animated checkmark */
        .checkmark-circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: inline-block;
            position: relative;
            box-shadow: inset 0px 0px 0px green;
            animation: circle-fill 0.5s ease-in-out forwards;
        }

        .checkmark {
            width: 50px;
            height: 25px;
            border-left: 5px solid green;
            border-bottom: 5px solid green;
            transform: rotate(-45deg);
            position: absolute;
            top: 25px;
            left: 25px;
            opacity: 0;
            animation: check-draw 0.5s ease-in-out 0.5s forwards;
        }

        @keyframes circle-fill {
            from { box-shadow: inset 0px 0px 0px green; }
            to   { box-shadow: inset 0px 0px 0px 5px green; }
        }

        @keyframes check-draw {
            from { opacity: 0; transform: scale(0) rotate(-45deg); }
            to   { opacity: 1; transform: scale(1) rotate(-45deg); }
        }

        .booking-details p {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }
        .booking-details strong {
            font-size: 1.25rem;
        }
    </style>
</head>
<body class="bg-light">

<div class="container text-center py-5">
    <div class="card shadow-sm p-5">
        
        <!-- Animated checkmark -->
        <div class="d-flex justify-content-center mb-4">
            <div class="checkmark-circle">
                <div class="checkmark"></div>
            </div>
        </div>

        <h1 class="mt-3 text-success">Thank You for joining this Event!</h1>
        <p class="lead">Your participation has been successfully confirmed.</p>
        
        <hr>
        <h4 class="mb-3">Event Details</h4>
        <div class="booking-details text-start d-inline-block">
           <p><strong>Name:</strong> <?php echo htmlspecialchars($event['user_name']); ?></p>
<p><strong>Surname:</strong> <?php echo htmlspecialchars($event['user_surname']); ?></p>
            <p><strong>Activity:</strong> <?php echo htmlspecialchars($event['activity_name']); ?></p>
         <p><strong>Date:</strong> <?php echo htmlspecialchars($event['date']); ?></p>
<p><strong>Time:</strong> <?php echo htmlspecialchars($event['time']); ?></p>
        </div>
        
        <div class="mt-4">
            <a href="events.php" class="btn btn-secondary btn-lg mx-2">Your Events</a>
            <a href="home.php" class="btn btn-primary btn-lg mx-2">Back to Home</a>
        </div>
    </div>
</div>

</body>
</html>
