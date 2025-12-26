<?php 
session_start();
include_once('config.php');

$id = $_GET['id'];
$_SESSION['activity_id'] = $id;

$sql = "SELECT * FROM activities WHERE id=:id";
$selectActivity = $conn->prepare($sql);
$selectActivity->bindParam(":id",$id);
$selectActivity->execute();
$activity_data = $selectActivity->fetch();
?>


<?php
// determine if the logged-in user has favorited this activity
$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
$isFavorited = false;

if ($user_id) {
    $checkFav = $conn->prepare("
        SELECT id FROM favorites 
        WHERE user_id = :uid AND activity_id = :aid
    ");
    $checkFav->execute([
        ":uid" => $user_id,
        ":aid" => $activity_data['id']
    ]);
    $isFavorited = $checkFav->rowCount() > 0;
}
// if no logged-in user, $isFavorited stays false
?>

<!DOCTYPE html>
<html>
<head>
    <title>Join Activity - HumanityConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
    <link rel="manifest" href="images/site.webmanifest">
    <link rel="icon" type="image/ico" href="images/favicon.ico">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        .form-floating { margin-bottom: 20px; }
        .buttonidsh {
            color: white;
            background: #1877F2;
            width: 200px;
            height: 45px;
            font-size: 16px;
            border-radius: 5px;
            border: none;
        }
        select.form-select { height: calc(3.5rem + 2px); }

        .activity-layout {
            display: flex;
            flex-direction: row;
            height: 100%;
        }
        .form-section {
            flex: 1;
            padding: 35px 30px;
            border-right: 1px solid #eee;
        }
        .carousel-section {
            flex: 1;
            background: #f8f9fa;
            padding: 20px;
        }




  .favorite-btn {
    background-color: #f4c542;
    color: white;
    font-weight: 600;
    padding: 10px 20px;
    border-radius: 8px;
    border: none;
    transition: 0.2s ease-in-out;
}

.favorite-btn:hover {
    background-color: #e0b53b;
    color: white;
}

.favorite-btn i {
    color: white;
    font-size: 1.1rem;
}


        @media (max-width: 768px) {
            .activity-layout {
                flex-direction: column;
            }
            .form-section {
                border-right: none;
                border-bottom: 1px solid #eee;
            }
        }



    </style>
</head>

<body>
<header class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background-color:black;">
    <div class="container">
        <a class="navbar-brand" href="home.php">
            <strong class="text-white">HumanityConnect</strong>
        </a>
    </div>
</header>

<section class="py-5 text-center bg-light">
    <div class="container">
        <h1 class="fw-bold">Join Activity</h1>
        <p class="lead text-muted">Fill the form below to join the activity!</p>
    </div>
</section>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">

                <div class="activity-layout">

                    <!-- LEFT SIDE FORM -->
                    <div class="form-section">
                        <h3 class="mb-3"><?php echo $activity_data['activity_name']; ?></h3>
                        <p class="text-muted"><?php echo $activity_data['activity_desc']; ?></p>

                        <form action="join.php" method="post">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="name" name="name" required>
                                <label for="name">Name</label>
                            </div>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="surname" name="surname" required>
                                <label for="surname">Surname</label>
                            </div>
                            <div class="form-floating">
                                <input type="email" class="form-control" id="email" name="email" required>
                                <label for="email">Email</label>
                            </div>
                            <div class="form-floating">
                                <input type="date" class="form-control" id="date" name="date" required>
                                <label for="date">Date</label>
                            </div>
                            <div class="form-floating">
                                <select class="form-select" name="time" required>
                                    <option disabled selected>Select a time</option>
                                    <option value="8:00 - 11:00">8:00 - 11:00</option>
                                    <option value="12:00 - 15:00">12:00 - 15:00</option>
                                    <option value="16:00 - 19:00">16:00 - 19:00</option>
                                </select>
                                <label for="time">Select Time</label>
                            </div>

                            <button class="w-100 btn btn-primary btn-lg" type="submit" name="submit">Join</button>
                        </form>

                        <div class="text-center mt-4">
                            <a href="home.php">
                                <button class="buttonidsh">⬅ Go Back</button>
                            </a>
                        </div>
                    </div>

                    <!-- RIGHT SIDE CAROUSEL -->
                    <div class="carousel-section">

                        <?php
                        // Load all images for the activity folder
                        $activityId = $activity_data['id'];
                        $folder = "images/activity-$activityId/";

                        // Accept multiple formats
                        $images = glob($folder . "*.{jpg,jpeg,png,webp,avif}", GLOB_BRACE);
                        ?>

                        <div id="activityCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">

                                <?php if (!empty($images)): ?>
                                    <?php foreach ($images as $index => $img): ?>
                                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                            <img src="<?php echo $img; ?>" class="d-block w-100 rounded" alt="Activity Image">
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <!-- fallback image -->
                                    <div class="carousel-item active">
                                        <img src="images/<?php echo $activity_data['activity_image']; ?>" 
                                             class="d-block w-100 rounded" 
                                             alt="Activity Image">
                                    </div>
                                <?php endif; ?>

                            </div>

                            <?php if (count($images) > 1): ?>
                            <button class="carousel-control-prev" type="button" data-bs-target="#activityCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#activityCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                            <?php endif; ?>


                            <div class="text-center mt-3">
   <!-- Star Button -->
<form action="favorite.php" method="post" class="mt-3 text-center">
    <input type="hidden" name="activity_id" value="<?php echo $activity_data['id']; ?>">

    <?php if ($isFavorited): ?>
        <!-- Unfavorite Button -->
        <button type="submit" class="btn favorite-btn">
            <i class="bi bi-star-fill me-2"></i> Unstar
        </button>
    <?php else: ?>
        <!-- Favorite Button -->
        <button type="submit" class="btn favorite-btn">
            <i class="bi bi-star me-2"></i> Star
        </button>
    <?php endif; ?>
</form>


</div>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
