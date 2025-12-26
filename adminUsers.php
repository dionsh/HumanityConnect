<?php
session_start();

 


if (!isset($_SESSION['id']) || $_SESSION['is_admin'] !== 'true') {
    
    header("Location: login.php"); 
    exit(); 
}



include_once('config.php');



// Merr te dhenat e userave me numrin e bookings
$sql = "SELECT u.id, u.name, u.username, u.email, COUNT(e.id) AS nr_events
        FROM users u
        LEFT JOIN events e ON u.id = e.user_id
        GROUP BY u.id, u.name, u.username, u.email";
$selectUsers = $conn->prepare($sql);
$selectUsers->execute();
$users_data = $selectUsers->fetchAll();

// Count users registered from October to April (10, 11, 12, 1, 2, 3, 4)
$userCountPerMonth = [
    10 => 0,
    11 => 0,
    12 => 0,
    1  => 0,
    2  => 0,
    3  => 0,
    4  => 0
];

$sqlMonth = "SELECT MONTH(created_at) as month, COUNT(*) as count 
             FROM users 
             WHERE MONTH(created_at) IN (10,11,12,1,2,3,4)
             GROUP BY MONTH(created_at)";
$stmtMonth = $conn->prepare($sqlMonth);
$stmtMonth->execute();
$monthlyUsers = $stmtMonth->fetchAll();

foreach ($monthlyUsers as $row) {
    $m = (int)$row['month'];
    if (isset($userCountPerMonth[$m])) {
        $userCountPerMonth[$m] = (int)$row['count'];
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>ADMIN Users - HumanityConnect</title>
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
            background-color:  #814885;
            color: white;
        }
        .sidebar .nav-link {
            color:  #0f0f0f;
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

            <h2 class="text-secondary">Users</h2>

            <!-- Kodi per Search Bar -->
            <div class="mb-3">
                <input type="text" id="searchInput" class="form-control" placeholder="Search users...">
            </div>

            <div class="table-responsive">
                <table class="table table-striped" id="usersTable">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Number of Events User Has Joined</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users_data as $user) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['id']); ?></td>
                                <td><?php echo htmlspecialchars($user['name']); ?></td>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo htmlspecialchars($user['nr_events']); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!--  Kodi per Statistike Line Chart -->
            <h2 class="text-secondary mt-5">Number of Users (October–April)</h2>
            <canvas id="usersChart" height="100"></canvas>

        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
//Kodi per Search filter
document.getElementById('searchInput').addEventListener('keyup', function() {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll('#usersTable tbody tr');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
});

// Chart.js setapi per chart
const ctx = document.getElementById('usersChart').getContext('2d');
const usersChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [' October', 'November', 'December', 'January', 'February', 'March', 'April'],
        datasets: [{
            label: 'Number of Users',
            data: [
                <?php echo $userCountPerMonth[10]; ?>,
                <?php echo $userCountPerMonth[11]; ?>,
                <?php echo $userCountPerMonth[12]; ?>,
                <?php echo $userCountPerMonth[1]; ?>,
                <?php echo $userCountPerMonth[2]; ?>,
                <?php echo $userCountPerMonth[3]; ?>,
                 <?php echo $userCountPerMonth[4]; ?>
               
            ],
            backgroundColor: 'rgba(129, 72, 133, 0.2)',  // 20% opacity of #814885
borderColor: '#814885',
pointBackgroundColor: '#814885',

            borderWidth: 2,
            tension: 0.3,
            fill: true,
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
