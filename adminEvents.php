<?php
session_start();


if (!isset($_SESSION['id']) || $_SESSION['is_admin'] !== 'true') {
   
    header("Location: login.php"); // I dergon ne nje  non-admin page, e.g., home.php or login.php
    exit(); 
}



include_once('config.php');

 

$user_id = $_SESSION['id'];



if ($_SESSION['is_admin'] == 'true') {
    $sql = "SELECT activities.activity_name, users.email, users.name, events.id, events.date, events.is_completed, events.time 
        FROM activities
        INNER JOIN events ON activities.id = events.activity_id
        INNER JOIN users ON users.id = events.user_id";

    $selectEvents = $conn->prepare($sql);
    $selectEvents->execute();
    $events_data = $selectEvents->fetchAll();
} else {
    $sql = "SELECT activities.activity_name, users.email, users.name, events.date, events.is_completed, events.time
        FROM activities 
        INNERJOIN events ON activities.id = events.activity_id 
        INNER JOIN users ON users.id = events.user_id 
        WHERE events.user_id = :user_id";

    $selectEvents = $conn->prepare($sql);
    $selectEvents->bindParam(':user_id', $user_id);
    $selectEvents->execute();
    $events_data = $selectEvents->fetchAll();
}

// Count events from October (10) to March (3)
// Months: 10,11,12,1,2,3
$eventsPerMonth = [
    10 => 0,
    11 => 0,
    12 => 0,
    1  => 0,
    2  => 0,
    3  => 0
];

foreach ($events_data as $event) {
    $month = (int)date('n', strtotime($event['date']));
    if (isset($eventsPerMonth[$month])) {
        $eventsPerMonth[$month]++;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>ADMIN Events - HumanityConnect</title>
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
            background-color: #0bbed6;
            color: white;
        }
        .sidebar .nav-link {
            color: #0f0f0f;
        }

        .footer-link, .footer-social-link {
    color: #ccc;
    transition: color 0.3s ease;
    font-size: 0.95rem;
}

.footer-link:hover, .footer-social-link:hover {
    color: #fff;
    text-decoration: none;
}

.footer-social-link i {
    vertical-align: middle;
}

    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<header class="navbar navbar-dark sticky-top  flex-md-nowrap p-0 shadow" style="background-color:black;">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#"><?php echo "Welcome Admin, " . $_SESSION['username']; ?></a>
  
    <div class="navbar-nav">
        <div class="nav-item text-nowrap">
            <a class="nav-link px-3" href="adminLogout.php">Sign out</a>
        </div>
    </div>
</header>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'adminHome.php' ? 'active' : ''; ?>" href="adminHome.php"> <i class="bi bi-house-door-fill me-2"></i>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'adminDashboard.php' ? 'active' : ''; ?>" href="adminDashboard.php"> <i class="bi bi-speedometer me-2"></i>Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'adminEvents.php' ? 'active' : ''; ?>" href="adminEvents.php"> <i class="bi bi-calendar-event-fill me-2"></i>Events</a>
                    </li>
                      <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'adminStarred.php' ? 'active' : ''; ?>" href="adminStarred.php"> <i class="bi bi-star-fill me-2"></i>Starred</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'adminUsers.php' ? 'active' : ''; ?>" href="adminUsers.php"> <i class="bi bi-people-fill me-2"></i>Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'adminCertificates1.php' ? 'active' : ''; ?>" href="adminCertificates1.php"> <i class="bi bi-award me-2"></i>Certificates</a>
                    </li>
                </ul>
            </div>
        </nav>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 text-primary">Admin Dashboard</h1>
            </div>

            <h2 class="text-secondary"> All User Events</h2>

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
                            <th>Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <?php if ($_SESSION[ 'is_admin'] == 'true') { ?>
                                <th>Actions</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($events_data as $event_data) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($event_data['activity_name']); ?></td>
                                <td><?php echo htmlspecialchars($event_data['email']); ?></td>
                                <td><?php echo htmlspecialchars($event_data['name']); ?></td>
                                <td><?php echo htmlspecialchars($event_data['date']); ?></td>
                                <td><?php echo htmlspecialchars($event_data['time']); ?></td>
                                <td><?php echo htmlspecialchars($event_data['is_completed']); ?></td>
                                <?php if ($_SESSION['is_admin'] == 'true') { ?>
                                    <td>
                                        <a class="btn btn-sm btn-success" href="completed.php?id=<?= $event_data['id']; ?>">Completed</a>
                                        <a class="btn btn-sm btn-warning" href="pending.php?id=<?= $event_data['id']; ?>">Pending</a>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Statisika (charti me line) -->
            <h2 class="text-secondary mt-5">Number of Events Reserved </h2>
            <canvas id="bookingsChart" height="100"></canvas>

        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// JavaScript per search filter
document.getElementById('searchInput').addEventListener('keyup', function() {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll('#bookingsTable tbody tr'); // FIXED ID
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
});

// Chart.js setapi per line chart
const ctx = document.getElementById('bookingsChart').getContext('2d'); // FIXED ID
const eventsChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['October', 'November', 'December', 'January', 'February', 'March'],
        datasets: [{
            label: 'Number of Events',
            data: [
                <?php echo $eventsPerMonth[10]; ?>,
                <?php echo $eventsPerMonth[11]; ?>,
                <?php echo $eventsPerMonth[12]; ?>,
                <?php echo $eventsPerMonth[1]; ?>,
                <?php echo $eventsPerMonth[2]; ?>,
                <?php echo $eventsPerMonth[3]; ?>,
              
            ],
              backgroundColor: 'rgba(11, 190, 214, 0.2)',  // teal/cyan transparent bg
            borderColor: '#0bbed6',                       // teal/cyan border
            borderWidth: 2,
            tension: 0.3,
            fill: true,
            pointBackgroundColor: '#0bbed6'            
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                precision: 0
            }
        }
    }
});

</script>


<footer class="bg-dark text-light pt-5 pb-4 mt-5">
    <div class="container text-center">
        <h5 class="fw-bold mb-4">Connect with Us</h5>
        <div class="mb-4">
            <a href="https://instagram.com" target="_blank" class="text-light mx-3 footer-social-link">
                <i class="bi bi-instagram fs-4 me-1"></i> Instagram
            </a>
            <a href="https://facebook.com" target="_blank" class="text-light mx-3 footer-social-link">
                <i class="bi bi-facebook fs-4 me-1"></i> Facebook
            </a>
            <a href="mailto:humanityconnect@info.com" class="text-light mx-3 footer-social-link">
                <i class="bi bi-envelope-fill fs-4 me-1"></i> Email
            </a>
        </div>
        <p class="mb-2" style="font-size: 1.05rem;"><strong>&copy; 2025 HumanityConnect. All rights reserved.</strong></p>
        <p class="mb-0 small">
            <a href="#" class="footer-link text-decoration-none">Privacy Policy</a> |
            <a href="#" class="footer-link text-decoration-none">Terms of Use</a>
        </p>
    </div>
</footer>

</body>
</html>
