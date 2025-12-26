<?php
session_start();
include_once('config.php');

// require login
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

// search query (GET)
$search = isset($_GET['q']) ? trim($_GET['q']) : '';
$searchSql = '';
$params = [':uid' => $user_id];

if ($search !== '') {
    $searchSql = " AND (a.activity_name LIKE :q OR a.activity_desc LIKE :q) ";
    $params[':q'] = '%' . $search . '%';
}

// Fetch starred activities for this user (most recent first)
$sql = "
    SELECT a.*, f.created_at AS starred_at
    FROM favorites f
    JOIN activities a ON a.id = f.activity_id
    WHERE f.user_id = :uid
    {$searchSql}
    ORDER BY f.created_at DESC
";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$starred_activities = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>My Starred Activities - HumanityConnect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
<link rel="manifest" href="images/site.webmanifest">
    <link rel="icon" type="image/ico"  href="images/favicon.ico">


    <style>
        body { background: #f4f6f8; }
        .app-header { background: black; }
        .brand { color: #fff; font-weight: 700; text-decoration: none; }
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

        /* Prevent horizontal scroll */
body {
    overflow-x: hidden;
}

/* Increase card height */
.card {
    min-height: 420px; /* adjust as needed */
}



        .sidebar a { color: #333; display: block; padding: 10px 18px; border-radius: 6px; margin: 4px 8px; text-decoration: none; }
        .sidebar a:hover, .sidebar .active { background: #f4c542; color: white; }
        .content-area { padding: 28px; }

        .card-img-top { height: 240px; object-fit: cover; }

        .favorite-btn {
            background-color: #f4c542;
            color: white;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            transition: 0.15s ease-in-out;
        }
        .favorite-btn:hover { background-color: #e0b53b; color: white; }

        .search-input {
            max-width: 520px;
        }

        .muted-small { color: #6c757d; font-size: 0.9rem; }
    </style>
</head>
<body>

<!-- Header (same style as your other pages) -->
<nav class="navbar navbar-expand-lg navbar-dark app-header shadow-sm">
    <div class="container">
        <a class="navbar-brand brand" href="home.php">HumanityConnect</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

         <div class="navbar-nav ms-auto">
        <div class="nav-item text-nowrap">
            <a class="nav-link px-3 text-white" href="logout.php">Sign out</a>
        </div>
    </div>
    </div>
</nav>

<div class="d-flex">
    <!-- Aside navigation (inspired by events.php) -->
    <aside class="sidebar">
        <div class="px-3">

            <a href="home.php"><i class="bi bi-house-door-fill me-2"></i> Home</a>
            <a href="dashboard.php"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
            <a href="events.php"><i class="bi bi-calendar-event-fill me-2"></i>My Events</a>
            <a href="starred.php" class="active"><i class="bi bi-star-fill me-2"></i> My Starred</a>
           <a href="certificates1.php"><i class="bi bi-award me-2"></i> Certificates</a>
            <hr>
            <div class="px-2 muted-small">Quick Links</div>
            <a href="#"><i class="bi bi-plus-circle me-2"></i> Join Activity</a>
        </div>
    </aside>

    <main class="flex-fill">
        <div class="content-area container-fluid">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-0">My Starred Activities</h2>
                    <div class="muted-small">Activities you have starred — only starred items appear here.</div>
                </div>

               
                
            </div>

            <!-- Results -->
            <?php if (empty($starred_activities)): ?>
                <div class="alert alert-info">You haven't starred any activities yet. Browse <a href="home.php">events</a> to star them.</div>
            <?php else: ?>
                <div class="row g-3">
                    <?php foreach ($starred_activities as $act): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm">
                                <?php
                                // image path fallback
                                $imgPath = 'images/' . ($act['activity_image'] ?? 'default.jpg');
                                // if you stored activity images in activity-<id> folder, consider detecting first image in folder
                                ?>
                                <img src="<?php echo htmlspecialchars($imgPath, ENT_QUOTES); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($act['activity_name'], ENT_QUOTES); ?>">

                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title mb-1"><?php echo htmlspecialchars($act['activity_name'], ENT_QUOTES); ?></h5>
                                    <p class="muted-small mb-2">Starred: <?php echo date("M j, Y H:i", strtotime($act['starred_at'])); ?></p>
                                    <p class="card-text text-truncate" title="<?php echo htmlspecialchars($act['activity_desc'], ENT_QUOTES); ?>"><?php echo htmlspecialchars($act['activity_desc'], ENT_QUOTES); ?></p>

                                    <div class="mt-auto d-flex gap-2">
                                        <a href="details.php?id=<?php echo (int)$act['id']; ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-box-arrow-up-right me-1"></i> View
                                        </a>

                                        <!-- Unstar form (toggle) -->
                                        <form action="favorite.php" method="post" class="d-inline">
                                            <input type="hidden" name="activity_id" value="<?php echo (int)$act['id']; ?>">
                                            <button type="submit" class="favorite-btn btn-sm">
                                                <i class="bi bi-star-fill me-1"></i> Unstar
                                            </button>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </main>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
