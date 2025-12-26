<?php 
session_start();
include_once('config.php');

$user_id = $_SESSION['id'];

if ($_SESSION['is_admin'] == 'true') {
    $sql = "SELECT activities.activity_name, users.email, events.id, events.date, events.is_completed, events.time FROM activities
            INNER JOIN events ON activities.id = events.activity_id
            INNER JOIN users ON users.id = events.user_id";
    $selectEvents = $conn->prepare($sql);
    $selectEvents->execute();
    $events_data = $selectEvents->fetchAll();
} else {
    $sql = "SELECT activities.activity_name, users.email, events.date, events.is_completed, events.time
            FROM activities INNER JOIN events ON activities.id = events.activity_id 
            INNER JOIN users ON users.id = events.user_id WHERE events.user_id = :user_id";
    $selectEvents = $conn->prepare($sql);
    $selectEvents->bindParam(':user_id', $user_id);
    $selectEvents->execute();
    $events_data = $selectEvents->fetchAll();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Events - HumanityConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


 <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
<link rel="manifest" href="images/site.webmanifest">
    <link rel="icon" type="image/ico"  href="images/favicon.ico">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            background-color: #f8f9fa;
        }
       .sidebar .nav-link.active {
    background-color: #0bbed6 !important;
    color: white !important;
}

        }
        .sidebar .nav-link {
            color: #0f0f0f;
        }

.sidebar {
    min-width: 220px;
    max-width: 220px;
    background: #fff;
    border-right: 1px solid #e9ecef;
    height: calc(100vh - 56px);
    position: sticky;
    top: 56px;
    padding-top: 20px;
}

.sidebar a {
    color: #333;
    display: block;
    padding: 10px 18px;
    border-radius: 6px;
    margin: 4px 8px;
    text-decoration: none;
}

 

    </style>
</head>
<body>
    

<header class="navbar navbar-dark sticky-top  flex-md-nowrap p-0 shadow" style="background-color:black;">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">
        <?php echo "Check out your Events, " . htmlspecialchars($_SESSION['username']); ?>
    </a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-nav ms-auto">
        <div class="nav-item text-nowrap">
            <a class="nav-link px-3 text-white" href="logout.php">Sign out</a>
        </div>
    </div>
</header>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'home.php' ? 'active' : ''; ?>" href="home.php">
                    <i class="bi bi-house-door-fill me-2"></i> Home
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>" href="dashboard.php">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'events.php' ? 'active' : ''; ?>" href="events.php">
                    <i class="bi bi-calendar-event-fill me-2"></i> My Events
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'starred.php' ? 'active' : ''; ?>" href="starred.php">
                    <i class="bi bi-star-fill me-2"></i> My Starred
                </a>
            </li>
            <li class="nav-item">
               <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'certificates1.php' ? 'active' : ''; ?>" href="certificates1.php">
    <i class="bi bi-award me-2"></i> Certificates
</a>

            </li>
        </ul>
    </div>
</nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 text-primary">Events</h1>
            </div>

            <h2 class="text-secondary">Your Events</h2>

            <!-- Kodi per Search Bar -->
            <div class="mb-3">
                <input type="text" id="searchInput" class="form-control" placeholder="Search events...">
            </div>

            <div class="table-responsive">
                <table class="table table-striped" id="bookingsTable">
                    <thead class="table-primary">
                        <tr>
                            <th>Activity Name</th>
                            <th>User Email</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($events_data as $event_data) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($event_data['activity_name']); ?></td>
                                <td><?php echo htmlspecialchars($event_data['email']); ?></td>
                                <td><?php echo htmlspecialchars($event_data['date']); ?></td>
                                <td><?php echo htmlspecialchars($event_data['time']); ?></td>
                                <td><?php echo htmlspecialchars($event_data['is_completed']); ?></td>
                                
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Fixed search filter JS
document.getElementById('searchInput').addEventListener('keyup', function() {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll('#bookingsTable tbody tr');  // corrected here
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
});
</script>








</body>
</html>
