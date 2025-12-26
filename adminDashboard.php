<?php 
session_start();



 


if (!isset($_SESSION['id']) || $_SESSION['is_admin'] !== 'true') {
    
    header("Location: login.php"); 
    exit(); 
}




include_once('config.php');



if (empty($_SESSION['username'])) {
    header("Location: adminLogin.php");
    
}






$sql = "SELECT * FROM users";
$selectUsers = $conn->prepare($sql);
$selectUsers->execute();
$users_data = $selectUsers->fetchAll();


// Calculate additional stats for the new section
$total_users = count($users_data);
$admin_count = 0;
$user_count = 0;
foreach ($users_data as $user) {
    if ($user['is_admin'] === 'true') {
        $admin_count++;
    } else {
        $user_count++;
    }
}



?>



<!DOCTYPE html>
<html>
<head>
    <title>ADMIN Dashboard - HumanityConnect</title>
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
            color: #0f0f0f; /* Ngjyra zeze */
        }
        .sidebar .nav-link.active {
            background-color: #eb604d;                            /* Ngjyra kaltert : #0d6efd*/
            color: white !important;                               /* Ngjyra e zeze :  #0f0f0f */
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
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2">ADMIN Dashboard</h1>
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
                                                <a href="editUsers.php?id=<?= $user_data['id']; ?>" class="btn btn-sm btn-outline-primary">Update</a>
                                            </td>
                                            <td>
                                                <a href="deleteUsers.php?id=<?= $user_data['id']; ?>" class="btn btn-sm btn-outline-danger">Delete</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <br>
             <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title">Total Users</h5>
                            <p class="display-6"><?php echo $total_users; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title">Admins</h5>
                            <p class="display-6 text-success"><?php echo $admin_count; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title">Regular Users</h5>
                            <p class="display-6 text-info"><?php echo $user_count; ?></p>
                        </div>
                    </div>
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
