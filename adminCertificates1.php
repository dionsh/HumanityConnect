<?php
session_start();

if (!isset($_SESSION['id']) || $_SESSION['is_admin'] !== 'true') {
    header("Location: login.php");
    exit();
}

include_once('config.php');

// Fetch only users that have joined an event
$sql = "SELECT 
            events.id AS event_id,
            users.id AS user_id,
            users.name,
            users.surname,
            users.email,
            activities.activity_name,
            activities.activity_points,
            events.is_completed
        FROM events
        INNER JOIN users ON users.id = events.user_id
        INNER JOIN activities ON activities.id = events.activity_id
        ORDER BY events.id DESC";


$stmt = $conn->prepare($sql);
$stmt->execute();
$cert_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Certificates - HumanityConnect</title>
  

     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


    <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
<link rel="manifest" href="images/site.webmanifest">
    <link rel="icon" type="image/ico"  href="images/favicon.ico">




    <style>

 .sidebar .nav-link.active {
            background-color:  #07ab1f;
            color: white;
        }
        .sidebar .nav-link {
            color:  #0f0f0f;
        }

    </style>
</head>

<body>

<header class="navbar navbar-dark sticky-top flex-md-nowrap p-0 shadow" style="background-color:black;">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Welcome Admin</a>
   
    <div class="navbar-nav">
        <a class="nav-link px-3" href="adminLogout.php">Sign out</a>
    </div>
</header>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
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

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

            <h2 class="mt-4 text-primary">Certificate Management</h2>
            <input type="text" id="searchInput" class="form-control mt-3" placeholder="Search users...">


            <div class="table-responsive mt-4">
                <table class="table table-striped" id="certTable">
                    <thead class="table-primary">
                        <tr>
                            <th>Event ID</th>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Surname</th>
                            <th>Email</th>
                            <th>Activity</th>
                            <th>Points</th>
                            <th>Status</th>
                            <th>Certificate</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cert_data as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['event_id']); ?></td>
                                <td><?= htmlspecialchars($row['user_id']); ?></td>
                                <td><?= htmlspecialchars($row['name']); ?></td>
                                <td><?= htmlspecialchars($row['surname']); ?></td>
                                <td><?= htmlspecialchars($row['email']); ?></td>
                                <td><?= htmlspecialchars($row['activity_name']); ?></td>
                                <td><?= htmlspecialchars($row['activity_points']); ?></td>

                               <td>
    <?php if ($row['is_completed'] === "Completed"): ?>
        <span class="badge bg-success">Completed</span>
    <?php else: ?>
        <span class="badge bg-warning text-dark">Pending</span>
    <?php endif; ?>
</td>

                                <td>
    <?php if ($row['is_completed'] === "Completed"): ?>
        <a href="certificates/generate_certificate.php?event_id=<?= $row['event_id']; ?>" class="btn btn-success btn-sm">
            Give Certificate
        </a>
    <?php else: ?>
        <button class="btn btn-secondary btn-sm" disabled>Pending</button>
    <?php endif; ?>
</td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </main>
    </div>
</div>

<script>
// Search Filter for Certificates Table
document.getElementById('searchInput').addEventListener('keyup', function() {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll('#certTable tbody tr');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
});
</script>


</body>
</html>
