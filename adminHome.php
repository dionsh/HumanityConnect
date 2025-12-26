<?php 

session_start(); 


if (!isset($_SESSION['id']) || $_SESSION['is_admin'] !== 'true') {
    
    header("Location: login.php"); 
    exit(); 
}


include_once('config.php');

$sql = "SELECT * FROM activities";
$selectActivities = $conn->prepare($sql);
$selectActivities->execute();
$activities_data = $selectActivities->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home - HumanityConnect</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap + Inter font + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
<link rel="manifest" href="images/site.webmanifest">
    <link rel="icon" type="image/ico"  href="images/favicon.ico">

    <style>
        :root{
            --hc-blue: #0075FF;
            --hc-orange: #FF8A00;
            --muted: #6c757d;
            --card-shadow: 0 10px 25px rgba(3, 23, 54, 0.08);
            --hc-green: #28a745;
--hc-light-green: #71d67a;

        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f6f8fb;
            color: #1f2937;
        }

        /* Header */
        header.navbar {
            background: linear-gradient(90deg, var(--hc-blue), var(--hc-orange));
            border-bottom: 4px solid rgba(255,255,255,0.06);
        }
        .navbar .navbar-brand {
            font-weight: 800;
            color: white !important;
            letter-spacing: 0.2px;
        }
        .navbar .nav-link {
            color: rgba(255,255,255,0.95) !important;
            font-weight: 600;
        }
        .navbar .nav-link:hover { opacity: 0.95; }

        /* Hero */
        .hero {
            background: linear-gradient(180deg, rgba(0,117,255,0.06), rgba(255,138,0,0.03));
            padding: 4.5rem 0;
            margin-bottom: 1.5rem;
        }
        .hero .hero-inner {
            display: flex;
            gap: 2rem;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
        }
.hero .logo {
    width: 220px;
    height: 220px;
    border-radius: 18px;
    background: white;
    display:flex;
    align-items:center;
    justify-content:center;
    box-shadow: var(--card-shadow);
    padding: 12px;
}

        .hero h1 {
            font-size: 2.25rem;
            margin-bottom: 0.25rem;
            color: #071124;
            font-weight: 800;
        }
        .hero p.lead {
            font-size: 1.05rem;
            color: var(--muted);
            max-width: 720px;
        }
        .hero .cta {
            margin-top: 1rem;
        }

        .cta { width: 100%; }

        .btn-join {
            background: linear-gradient(90deg, var(--hc-blue), var(--hc-orange));
            border: none;
            color: white;
            padding: 0.8rem 1.4rem;
            border-radius: 999px;
            font-weight: 700;
            box-shadow: 0 6px 18px rgba(3,23,54,0.12);
        }
        .btn-outline-learn {
            border-radius: 999px;
            padding: 0.7rem 1.4rem;
            font-weight: 600;
            border: 1px solid var(--hc-blue);
            color: var(--hc-blue);
            background: transparent;
        }

        /* Quote box */
        .quote-box {
            max-width: 920px;
            margin: 1rem auto 2rem;
            padding: 0.9rem 1.2rem;
            border-radius: 12px;
            background: white;
            box-shadow: var(--card-shadow);
            display:flex;
            align-items:center;
            gap:12px;
        }
        .quote-box .icon {
            font-size: 1.6rem;
            color: var(--hc-blue);
        }
        .quote-box .text {
            color: var(--muted);
            margin:0;
            font-size: 0.98rem;
        }

        .features {
    background: white;
    padding: 4rem 1rem;
    border-radius: 14px;
    box-shadow: var(--card-shadow);
    min-height: 320px;
}

        .features h3 { font-weight:700; color:#0b1220; }
        .feature-icon {
            width:74px;
            height:74px;
            border-radius:12px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:1.6rem;
            background: linear-gradient(180deg, rgba(0,117,255,0.10), rgba(255,138,0,0.06));
            color:var(--hc-blue);
            margin-bottom:12px;
        }

        /* Card styles */
        .card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            transition: transform .22s ease, box-shadow .22s ease;
            box-shadow: 0 6px 18px rgba(9,30,66,0.06);
        }
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 18px 40px rgba(9,30,66,0.09);
        }
        .card img {
            height: 220px;
            object-fit: cover;
            width:100%;
        }
        .card .card-body {
            padding: 1.15rem;
        }
        .card .card-title {
            font-weight:700;
            margin-bottom:6px;
            color:#071124;
        }
        .card .card-text {
            color: var(--muted);
            font-size: 0.95rem;
        }
        



        .card .btn-outline-primary {
    border-radius: 999px;
    padding: .45rem .9rem;
    font-weight:700;
    color: var(--hc-blue);
    border-color: rgba(0,117,255,0.18);
    background: white;
    transition: all .25s ease;
}

/* 🔥 New hover effect */
.card .btn-outline-primary:hover {
    background: linear-gradient(90deg, var(--hc-blue), var(--hc-orange));
    color: white !important;
    border-color: transparent;
    box-shadow: 0 6px 20px rgba(0,117,255,0.25);
    transform: translateY(-2px);
}




.card .btn-outline-success {
    border-radius: 999px;
    padding: .45rem .9rem;
    font-weight: 700;
    /* Use the main success variable for text color */
    color: var(--hc-green);
    /* Use a lighter, successful shade for the border */
    border-color: rgba(40, 167, 69, 0.18); /* Using a standard green color placeholder if --hc-green isn't defined */
    background: white;
    transition: all .25s ease;
}

/* 🔥 New hover effect for the green button */
.card .btn-outline-success:hover {
    /* Create a gradient using two shades of green/complementary colors */
    background: linear-gradient(90deg, var(--hc-green), var(--hc-light-green));
    color: white !important;
    border-color: transparent;
    /* Update box-shadow color to match the green theme */
    box-shadow: 0 6px 20px rgba(40, 167, 69, 0.25);
    transform: translateY(-2px);
}




        /* Footer */
        footer {
            background: linear-gradient(180deg,#071124,#001122);
            color: rgba(255,255,255,0.9);
            padding-top: 2.2rem;
        }
        .footer-link, .footer-social-link { color: rgba(255,255,255,0.75); }
        .footer-link:hover, .footer-social-link:hover { color: white; text-decoration: none; }

        /* Scroll button */
        #scrollTopBtn {
            position: fixed;
            bottom: 28px;
            right: 28px;
            display: none;
            background: var(--hc-blue);
            color: white;
            border: none;
            padding: 10px 14px;
            border-radius: 50%;
            font-size: 1.15rem;
            box-shadow: 0 6px 20px rgba(3,23,54,0.18);
            z-index: 999;
        }
        #scrollTopBtn:hover { background: #0063e6; }

        @media (max-width: 768px) {
            .hero h1 { font-size: 1.6rem; }
            .hero .logo { width: 120px; height:120px; }
            .card img { height: 180px; }
        }
    </style>
</head>
<body>

<header class="navbar navbar-expand-lg navbar-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">
      HumanityConnect
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link active" href="adminHome.php">Home</a></li>
        <li class="nav-item"><a class="nav-link active" href="adminDashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link active" href="adminUsers.php">Users</a></li>
        <li class="nav-item"><a class="nav-link active" href="adminEvents.php"> Events</a></li>
        <li class="nav-item"><a class="nav-link active" href="adminCertificates1.php">Certificates</a></li>
        <li class="nav-item"><a class="nav-link" href="adminLogout.php">Sign Out</a></li>
      </ul>
    </div>
  </div>
</header>

<!-- HERO -->
<section class="hero">
    <div class="container">
        <div class="hero-inner">
            <div class="logo">
                <!-- Use the uploaded logo path as provided -->
                <img src="images/humanityconnectlogo.png" alt="HumanityConnect Logo" style="max-width:100%; max-height:100%; display:block;">
            </div>

            <div style="max-width:900px;">
                <h1>Connecting People. Empowering Communities.</h1>
                <p class="lead">Doing Good Deeds — HumanityConnect helps volunteers, organizations and local businesses come together to create meaningful community impact. Discover activities, join events, and earn certificates for your contributions.</p>

                <div class="cta text-center">
                    <a href="adminEvents.php" class="btn btn-join me-2">Events</a>
                    <a href="adminDashboard.php" class="btn btn-outline-learn">Go to Dashboard</a>
                </div>
            </div>
        </div>

        <!-- Quote box (the previous quote script will still insert a quote, but this static container keeps style consistent) -->
        <div class="quote-box mt-4">
            <div class="icon"><i class="bi bi-lightning-charge-fill"></i></div>
            <p class="text"><strong>Quote of the Day:</strong> <span id="quoteText" style="margin-left:8px;"></span></p>
        </div>
    </div>
</section>

<!-- FEATURES -->
<section class="container mb-5">
    <div class="row text-center py-4">

        <div class="col-md-4 mb-4">
            <div class="feature-icon mx-auto">🎉</div>
            <h3>Multiple Activities</h3>
            <p>
                Discover a wide range of community-driven activities designed to bring people together. 
                Whether you're looking to volunteer, join events, 
                HumanityConnect helps you participate with just a few clicks.
            </p>
        </div>

        <div class="col-md-4 mb-4">
            <div class="feature-icon mx-auto">🕒</div>
            <h3>Time Management</h3>
            <p>
                Stay organized with automatic reminders, event tracking, and smart scheduling tools. 
                HumanityConnect makes it effortless to plan ahead.
            </p>
        </div>

        <div class="col-md-4 mb-4">
            <div class="feature-icon mx-auto">📜</div>
            <h3>Certificates & Recognition</h3>
            <p>
                Gain official certificates as recognition for your participation and dedication. 
                Build your volunteer profile.
            </p>
        </div>

    </div>
</section>


<!-- Activities / business cards -->
<section id="activity1">
<div class="album py-4">
    <div class="container">
        <h1 class="text-center fw-bold mb-4" style="color:#071124;">Our Activities</h1>

        <div class="row g-4">
            <?php foreach ($activities_data as $activity_data) { ?>
                <div class="col-sm-6 col-md-4">
                    <div class="card h-100">
                        <img src="images/<?php echo $activity_data['activity_image']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($activity_data['activity_name']); ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($activity_data['activity_name']); ?></h5>
                            <p class="card-text flex-grow-1"><?php echo htmlspecialchars($activity_data['activity_desc']); ?></p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <a href="adminDetails.php?id=<?php echo $activity_data['id'];?>" class="btn btn-sm btn-outline-primary">View</a>
                                <a href="edit.php?id=<?php echo $activity_data['id'];?>" class="btn btn-sm btn-outline-success">Edit</a>

                                <div class="text-muted small text-end">
                                    <div><?php echo $activity_data['activity_quality']; ?></div>
                                    <div>Location: <?php echo $activity_data['activity_location']; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
</section>

<!-- Scroll to top -->
<button id="scrollTopBtn" title="Scroll to top">↑</button>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Quote script (keeps the original quotes feature, but now fills the quoteText inside the styled box) -->
<script>
const quotes = [
    "The only way to do great work is to love what you do. – Steve Jobs",
    "Success usually comes to those who are too busy to be looking for it. – Henry David Thoreau",
    "Don't watch the clock; do what it does. Keep going. – Sam Levenson",
    "Whether you think you can or you think you can’t, you’re right. – Henry Ford",
    "Opportunities don't happen. You create them. – Chris Grosser",
    "Discipline is the bridge between goals and accomplishment. – Jim Rohn",
    "Your time is limited, so don't waste it living someone else's life. – Steve Jobs",
    "Success is how high you bounce when you hit bottom. - George S. Patton",
    "The harder you work for something, the greater you'll feel when you achieve it. – Unknown",
    "Believe you can and you're halfway there. – Theodore Roosevelt"
];
const randomQuote = quotes[Math.floor(Math.random() * quotes.length)];
document.addEventListener("DOMContentLoaded", () => {
    document.getElementById('quoteText').textContent = randomQuote;
});
</script>

<script>
// Scroll-to-top logic
const scrollTopBtn = document.getElementById("scrollTopBtn");
window.onscroll = function() {
    scrollTopBtn.style.display = (document.body.scrollTop > 120 || document.documentElement.scrollTop > 120) ? "block" : "none";
};
scrollTopBtn.onclick = function() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
};
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
