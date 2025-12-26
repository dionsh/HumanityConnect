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
    <link rel="icon" type="image/ico"  href="images/favicon.ico">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .form-floating {
            margin-bottom: 20px;
        }
        .buttonidsh {
            color: white;
            background: #1877F2;
            width: 200px;
            height: 45px;
            font-size: 16px;
            border-radius: 5px;
            border: none;
        }
        select.form-select {
            height: calc(3.5rem + 2px);
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

<header class="navbar navbar-expand-lg navbar-dark shadow-sm " style="background-color:black;">
    <div class="container">
        <a class="navbar-brand" href="adminHome.php">
            <strong class="text-white">HumanityConnect</strong>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
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
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="row g-0">
                    <div class="col-md-5 text-center p-3">
                        <img src="images/<?php echo $activity_data['activity_image']; ?>" 
                             class="img-fluid rounded" alt="<?php echo $activity_data['activity_name']; ?>">
                    </div>
                    <div class="col-md-7 p-4">
                        <h3 class="mb-3"><?php echo $activity_data['activity_name']; ?></h3>
                        <p class="text-muted"><?php echo $activity_data['activity_desc']; ?></p>
                        <form action="join.php" method="post">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                                <label for="name">Name</label>
                            </div>
                             <div class="form-floating">
                                <input type="text" class="form-control" id="surname" name="surname" placeholder="Surname" required>
                                <label for="name">Surname</label>
                            </div>
                            <div class="form-floating">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                                <label for="name">Email</label>
                            </div>

                           <div class="form-floating">
                                <input type="date" class="form-control" id="date" name="date" required>
                                <label for="date">Date</label>
                            </div>

                            
                            <div class="form-floating">
                                <select class="form-select" name="time" required>
                                    <option value="" disabled selected>Select a time</option>
                                    <option value="8:00 - 11:00">8:00 - 11:00</option>
                                    <option value="12:00 - 15:00">12:00 - 15:00</option>
                                    <option value="16:00 - 19:00">16:00 - 19:00 </option>
                                    
                                  
                                </select>
                                <label for="time">Select Time</label>
                            </div>
                            <button class="w-100 btn btn-primary btn-lg" type="submit" name="submit">Join</button>
                        </form>
                        <div class="text-center mt-4">
                            <a href="adminHome.php">
                                <button class="buttonidsh">⬅ Go Back</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
