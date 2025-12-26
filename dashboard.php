<?php 
session_start();
include_once('config.php');

if (empty($_SESSION['username'])) {
    header("Location: login.php");
}

// Fetch kejt userat
$sql = "SELECT * FROM users";
$selectUsers = $conn->prepare($sql);
$selectUsers->execute();
$users_data = $selectUsers->fetchAll();







// Fetch rzervimet(bookings) per userin qe u ba log in
$user_id = $_SESSION['id'];

$sql = "SELECT activities.activity_name FROM events 
        INNER JOIN activities ON events.activity_id = activities.id 
        WHERE events.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$user_id]);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);




// Calculate total points user earned
$sql_points = "SELECT SUM(activities.activity_points) as total_points
               FROM events
               INNER JOIN activities ON events.activity_id = activities.id
               WHERE events.user_id = ?";
$stmt_points = $conn->prepare($sql_points);
$stmt_points->execute([$user_id]);
$total_points = $stmt_points->fetchColumn();
if ($total_points === null) {
    $total_points = 0;
}


// njeh totalin e rezervimeve
$total_events = count($events);

// Determinon loyalty tier per user
if ($total_events >= 6) {
    $loyalty_tier = "Platinum Member";
} elseif ($total_events >= 3) {
    $loyalty_tier = "Gold Member";
} else {
    $loyalty_tier = "Silver Member";
}

// Kalkulon destinacionin e preferuar
$destination_counts = [];
foreach ($events as $event) {
    $name = $event['activity_name'];
    if (!isset($destination_counts[$name])) {
        $destination_counts[$name] = 1;
    } else {
        $destination_counts[$name]++;
    }
}

if (empty($destination_counts)) {
    $favorite_destination = "-";
} else {
    arsort($destination_counts);
    $favorite_destination = array_key_first($destination_counts);
}








// Simulated recent activity for demonstration
$recent_time = [
    ['time' => '2 minutes ago', 'timespent' => 'You logged in successfully.'],
    ['time' => '2 hours ago', 'timespent' => 'You updated your profile information.'],
    ['time' => 'Yesterday', 'timespent' => ' New Activity was made.'],
    ['time' => '2 days ago', 'timespent' => 'Password changed successfully.'],
    
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - HumanityConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

     <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
<link rel="manifest" href="images/site.webmanifest">
    <link rel="icon" type="image/ico"  href="images/favicon.ico">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .sidebar .nav-link {
            color: #0f0f0f; /*  Ngjyra zeze -  */
        }
        .sidebar .nav-link.active {
            background-color: #eb604d;
            color: white !important;
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


        /* Styling veq per Recent Activity card */
        .recent-activity-card {
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            overflow: hidden;
            background-color: #fff;
        }
        .recent-activity-card .card-header {
            background: linear-gradient(90deg, #198754, #28a745);
            color: white;
            font-weight: 600;
            font-size: 1.25rem;
            padding: 1rem 1.5rem;
            border-bottom: none;
            border-radius: 12px 12px 0 0;
        }
        .recent-activity-card .card-body {
            padding: 0;
        }
        .recent-activity-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .recent-activity-list li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e9ecef;
            font-size: 1rem;
            color: #212529;
            cursor: default;
            transition: background-color 0.3s ease;
        }
        .recent-activity-list li:last-child {
            border-bottom: none;
        }
        .recent-activity-list li:hover {
            background-color: #e6f4ea;
        }
        .recent-activity-list small {
            font-size: 0.85rem;
            color: #6c757d;
            white-space: nowrap;
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
</head>
<body>

<header class="navbar navbar-dark sticky-top  flex-md-nowrap p-0 shadow" style="background-color:black;">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#"><?php echo "Welcome to dashboard, " . $_SESSION['username']; ?></a>
    <input class="form-control form-control-primary w-50" type="text" placeholder="Search" aria-label="Search">
    <div class="navbar-nav">
        <div class="nav-item text-nowrap">
            <a class="nav-link px-3" href="logout.php">Sign out</a>
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
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
            </div>

            <?php if ($_SESSION['is_admin'] == 'true') { ?>
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0">Users</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Update</th>
                                        <th scope="col">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users_data as $user_data) { ?>
                                        <tr>
                                            <td><?php echo $user_data['id']; ?></td>
                                            <td><?php echo $user_data['name']; ?></td>
                                            <td><?php echo $user_data['username']; ?></td>
                                            <td><?php echo $user_data['email']; ?></td>
                                            <td>
                                                <a href="editUsersU.php?id=<?= $user_data['id']; ?>" class="btn btn-sm btn-outline-primary">Update</a>
                                            </td>
                                            <td>
                                                <a href="deleteUsersU.php?id=<?= $user_data['id']; ?>" class="btn btn-sm btn-outline-danger">Delete</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <!-- Statistika  -->
          <div class="row mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h5 class="card-title">Events</h5>
                <p class="display-6"><?php echo $total_events; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h5 class="card-title">Total Points</h5>
                <p class="display-6 text-success"><?php echo $total_points; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h5 class="card-title">Favorite Activity</h5>
                <p class="display-6 text-info"><?php echo $favorite_destination; ?></p>
            </div>
        </div>
    </div>
</div>



            <!-- New: Friendly Tip Card -->
            <div class="card mb-4 shadow-sm border-start border-success border-3">
                <div class="card-body">
                    <h5 class="card-title text-success">👋 Welcome, <?php echo $_SESSION['username']; ?>!</h5>
                    <p class="card-text">Thanks for being a part of our platform. Don’t forget to keep your profile updated and check your activities regularly for the best experience.</p>
                    <p class="text-muted small mb-0">Tip: Use the sidebar to quickly navigate between Home, Dashboard, Certificates and more!</p>
                </div>
            </div>

            <!-- New: Recent Activity Section -->
            <div class="card mb-4 shadow-sm recent-activity-card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Activity</h5>
                </div>
                <div class="card-body">
                    <ul class="recent-activity-list list-group list-group-flush">
                        <?php foreach ($recent_time as $timespent) { ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo htmlspecialchars($timespent['timespent']); ?>
                                <small class="text-muted"><?php echo $timespent['time']; ?></small>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>

        </main>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


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
