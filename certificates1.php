<?php
session_start();
require 'config.php';

// Check if logged in
if (!isset($_SESSION['id'])) {    
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

// Fetch certificates for this user
$stmt = $conn->prepare("
    SELECT c.file_path, c.issued_at, a.activity_name
    FROM certificates c
    INNER JOIN activities a ON c.activity_id = a.id
    WHERE c.user_id = ?
    ORDER BY c.issued_at DESC
");
$stmt->execute([$user_id]);
$certificates = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Your Certificates - HumanityConnect</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
    <link rel="manifest" href="images/site.webmanifest">
    <link rel="icon" type="image/ico" href="images/favicon.ico">

    <style>
        .sidebar .nav-link {
            color: #0f0f0f;
        }
        .sidebar .nav-link.active {
            background-color: #07ab1f;
            color: white !important;
        }

        .cert-card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: 0.2s;
        }

        .cert-card:hover {
            transform: scale(1.01);
        }

        #searchInput {
            width: 100%;
            max-width: none;
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

<header class="navbar navbar-dark sticky-top flex-md-nowrap p-0 shadow" style="background-color:black;">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">
        <?php echo "Certificates - " . $_SESSION['username']; ?>
    </a>

    <div class="navbar-nav">
        <div class="nav-item text-nowrap">
            <a class="nav-link px-3" href="logout.php">Sign out</a>
        </div>
    </div>
</header>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
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
        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h2>Your Certificates</h2>
            </div>

            <!-- 🔵 SEARCH BAR MOVED HERE -->
            <div class="mb-4">
                <input id="searchInput" class="form-control" type="text" placeholder="Search certificates...">
            </div>

            <?php if (count($certificates) == 0): ?>
                <p class="text-muted">No certificates issued yet.</p>
            <?php else: ?>

                <div class="row" id="certContainer">
                    <?php foreach ($certificates as $cert): ?>
                        <div class="col-md-6 col-lg-4 mb-4 cert-item">
                            <div class="card cert-card p-3">

                                <h5 class="fw-bold"><?= htmlspecialchars($cert['activity_name']); ?></h5>

                                <p class="text-muted mb-1">
                                    Issued: <?= htmlspecialchars($cert['issued_at']); ?>
                                </p>

                                <a class="btn btn-dark mt-2" href="<?= htmlspecialchars($cert['file_path']); ?>" download>
                                    <i class="bi bi-download"></i> Download
                                </a>

                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php endif; ?>

            <!-- 🔵 ADD HUMANITYCONNECT LOGO UNDER CERTIFICATES -->
            <div class="text-center mt-5 mb-5">
                <img src="images/humanityconnectlogo.png" alt="HumanityConnect Logo" style="width:900px; height: 500px; opacity:0.9;">
            </div>

        </main>
    </div>
</div>

<script>
    // LIVE SEARCH FILTER
    const searchInput = document.getElementById("searchInput");
    const items = document.querySelectorAll(".cert-item");

    searchInput.addEventListener("keyup", function () {
        let filter = searchInput.value.toLowerCase();

        items.forEach(item => {
            let text = item.innerText.toLowerCase();
            item.style.display = text.includes(filter) ? "" : "none";
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
