<?php 
include_once('config.php');

$sql = "SELECT * FROM activities";
$selectActivities = $conn->prepare($sql);
$selectActivities->execute();
$activities_data = $selectActivities->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home - HumanityConnect</title>

    <!-- Bootstrap + Inter font + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
    <link rel="manifest" href="images/site.webmanifest">

    <style>
        :root{
            --hc-blue: #0069F2; /* slightly cooler blue */
            --hc-orange: #FF7A1A; /* slightly softer orange */
            --muted: #6c757d;
            --bg: #f6f8fb;
            --card-shadow: 0 10px 25px rgba(3, 23, 54, 0.08);
        }

        html,body{height:100%;}
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: #0b1220;
            -webkit-font-smoothing:antialiased;
            -moz-osx-font-smoothing:grayscale;
        }

        /* Top navbar */
        header.navbar {
            background: linear-gradient(90deg, var(--hc-blue), var(--hc-orange));
            border-bottom: 1px solid rgba(255,255,255,0.06);
            box-shadow: 0 6px 24px rgba(7,17,36,0.06);
        }
        .navbar .navbar-brand { font-weight: 800; color: #fff !important; letter-spacing: .2px; }
        .navbar .nav-link{ color: rgba(255,255,255,0.95) !important; font-weight:600; }

        /* REVERTED HERO (kept same as original you provided) */
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

        /* FEATURES  */
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

        /* Activities */
        .album .card{ border:none; border-radius:12px; overflow:hidden; transition: transform .22s ease, box-shadow .22s ease; box-shadow: 0 6px 18px rgba(9,30,66,0.06); }
        .album .card:hover{ transform: translateY(-8px); box-shadow: 0 18px 40px rgba(9,30,66,0.09); }
        .album .card img{ height:220px; object-fit: cover; width:100%; }
        .card .card-body{ padding: 1.15rem; }
        .card .card-title{ font-weight:700; margin-bottom:6px; color:#071124; }
        .card .card-text{ color: var(--muted); font-size: 0.95rem; }

        .card .btn-outline-primary { border-radius: 999px; padding: .45rem .9rem; font-weight:700; color: var(--hc-blue); border-color: rgba(0,117,255,0.18); background: white; transition: all .25s ease; }
        .card .btn-outline-primary:hover {
    background: var(--hc-blue); /* solid blue */
    color: white !important;
    border-color: var(--hc-blue);
    box-shadow: 0 6px 20px rgba(0,117,255,0.25);
    transform: translateY(-2px);
}


        .chip{ display:inline-block; padding:.25rem .6rem; border-radius:999px; font-size:.78rem; font-weight:600; border:1px solid rgba(11,18,32,0.06); background:#ffffff; }

        /* Card overlay badge */
        .ribbon{ position:absolute; left:12px; top:12px; background:linear-gradient(90deg,var(--hc-blue),var(--hc-orange)); color:white; padding:6px 10px; border-radius:8px; font-weight:700; font-size:.78rem; box-shadow:0 8px 22px rgba(3,23,54,0.12); }
        .card-wrap{ position:relative; }

        /* Search & controls */
        .controls{ display:flex; gap:.75rem; align-items:center; justify-content:space-between; margin-bottom:1rem; }
        .search-input{ flex:1; min-width:180px; }
        .sort-select{ width:190px; }

        /* Footer */
        footer{ background: linear-gradient(180deg,#071124,#001122); color: rgba(255,255,255,0.9); padding-top: 2.2rem; }
        .footer-link, .footer-social-link { color: rgba(255,255,255,0.75); }
        .footer-link:hover, .footer-social-link:hover { color: white; text-decoration: none; }

        /* Scroll button */
        #scrollTopBtn{
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

        /* subtle entrance animation */
        .stagger{ opacity:0; transform:translateY(8px) scale(.995); transition: all 420ms cubic-bezier(.2,.9,.2,1); }
        .stagger.show{ opacity:1; transform:none; }




.activity-location {
    font-size: 1.05rem;
    font-weight: 600;
    color: #071124;
}


        
    </style>
</head>
<body>

<header class="navbar navbar-expand-lg navbar-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">HumanityConnect</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
        <li class="nav-item"><a class="nav-link active" href="home.php">Home</a></li>
        <li class="nav-item"><a class="nav-link active" href="dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link active" href="#activity1">Activities</a></li>
        <li class="nav-item"><a class="nav-link active" href="events.php">My Events</a></li>
        <li class="nav-item"><a class="nav-link active" href="certificates1.php">Certificates</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">Sign Out</a></li>
      </ul>
    </div>
  </div>
</header>

<!-- HERO -->
<section class="hero">
    <div class="container">
        <div class="hero-inner">
            <div class="logo">
                
                <img src="images/humanityconnectlogo.png" alt="HumanityConnect Logo" style="max-width:100%; max-height:100%; display:block;">
            </div>

            <div style="max-width:900px;">
                <h1>Connecting People. Empowering Communities.</h1>
                <p class="lead">Doing Good Deeds — HumanityConnect helps volunteers, organizations and local businesses come together to create meaningful community impact. Discover activities, join events, and earn certificates for your contributions.</p>

                <div class="cta text-center">
                    <a href="#activity1" class="btn btn-join me-2">Join Now</a>
                    <a href="learnmore.php" class="btn btn-outline-learn">Learn More</a>
                </div>
            </div>
        </div>

        <!-- Quote box  -->
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


<section class="container mb-5">
    <div class="row align-items-center g-4">
        <div class="col-lg-6">
            <h2 class="fw-bold">How HumanityConnect Works</h2>
            <p class="text-muted">A simple 3-step process to find activities, join, and get recognized for your contribution.</p>

            <div class="d-flex gap-3 align-items-start mb-3">
                <div class="p-3 rounded bg-white" style="box-shadow:var(--card-shadow); width:64px; height:64px; display:flex; align-items:center; justify-content:center;">
                    <i class="bi bi-search fs-4" style="color:var(--hc-blue);"></i>
                </div>
                <div>
                    <h5 class="mb-1">1. Discover Activities</h5>
                    <p class="mb-0 text-muted">Use the search to quickly find activities near you or by interest.</p>
                </div>
            </div>

            <div class="d-flex gap-3 align-items-start mb-3">
                <div class="p-3 rounded bg-white" style="box-shadow:var(--card-shadow); width:64px; height:64px; display:flex; align-items:center; justify-content:center;">
                    <i class="bi bi-calendar-check fs-4" style="color:var(--hc-orange);"></i>
                </div>
                <div>
                    <h5 class="mb-1">2. Join & Participate</h5>
                    <p class="mb-0 text-muted">Sign up for events and track your commitments with automatic reminders.</p>
                </div>
            </div>

            <div class="d-flex gap-3 align-items-start mb-3">
                <div class="p-3 rounded bg-white" style="box-shadow:var(--card-shadow); width:64px; height:64px; display:flex; align-items:center; justify-content:center;">
                    <i class="bi bi-award fs-4" style="color:#34c38f;"></i>
                </div>
                <div>
                    <h5 class="mb-1">3. Earn Recognition</h5>
                    <p class="mb-0 text-muted">Receive certificates and build your volunteer profile as you contribute.</p>
                </div>
            </div>

            <a href="#activity1" class="btn btn-join mt-2">Find Activities</a>
        </div>

        <div class="col-lg-6 d-none d-lg-block">
            <div style="background:linear-gradient(135deg, rgba(0,117,255,0.08), rgba(255,138,0,0.05)); border-radius:12px; padding:24px; box-shadow:var(--card-shadow); height:100%; display:flex; align-items:center; justify-content:center;">
                <img src="images/humanityconnectlogo.png" alt="How it works illustration" style="max-width:80%; opacity:0.95;">
            </div>
        </div>
    </div>
</section>


<!-- Activities / business cards -->
<section id="activity1" class="mb-5">
<div class="container album py-4">
    <div class="d-flex controls mb-3">
        <div class="search-input input-group">
            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
            <input id="activitySearch" type="search" class="form-control" placeholder="Search activities by name, location or description...">
        </div>
        <select id="sortSelect" class="form-select sort-select">
            <option value="default">Sort: Default</option>
            <option value="name">Sort: Name A → Z</option>
            <option value="location">Sort: Location</option>
        </select>
        <div class="ms-auto d-flex gap-2 align-items-center">
            <button id="toggleTheme" class="btn btn-sm btn-outline-light">Toggle Theme</button>
        </div>
    </div>

    <h1 class="text-center fw-bold mb-4" style="color:#071124;">Our Activities</h1>

    <div class="row g-4" id="activitiesGrid">
        <?php foreach ($activities_data as $activity_data) { ?>
            <div class="col-sm-6 col-md-4 stagger" data-title="<?php echo htmlspecialchars(strtolower($activity_data['activity_name'])); ?>" data-location="<?php echo htmlspecialchars(strtolower($activity_data['activity_location'])); ?>" data-desc="<?php echo htmlspecialchars(strtolower($activity_data['activity_desc'])); ?>">
                <div class="card h-100 card-wrap">
                    <div class="ribbon"><?php echo htmlspecialchars($activity_data['activity_quality']); ?></div>
                    <img src="images/<?php echo $activity_data['activity_image']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($activity_data['activity_name']); ?>">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo htmlspecialchars($activity_data['activity_name']); ?></h5>
                        <p class="card-text flex-grow-1"><?php echo htmlspecialchars($activity_data['activity_desc']); ?></p>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <a href="details.php?id=<?php echo $activity_data['id'];?>" class="btn btn-sm btn-outline-primary">View</a>
                            <div class="text-muted small text-end">
                                <div class="activity-location"><i class="bi bi-geo-alt-fill"></i> <?php echo htmlspecialchars($activity_data['activity_location']); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
</section>

<!-- Scroll to top -->
<button id="scrollTopBtn" title="Scroll to top">↑</button>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Quote script -->
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

    // reveal animation for cards
    setTimeout(() => {
        document.querySelectorAll('.stagger').forEach((el, i) => setTimeout(() => el.classList.add('show'), i * 80));
    }, 120);
});
</script>

<script>
// Scroll-to-top logic
const scrollTopBtn = document.getElementById("scrollTopBtn");
window.onscroll = function() {
    scrollTopBtn.style.display = (document.body.scrollTop > 120 || document.documentElement.scrollTop > 120) ? "block" : "none";
};
scrollTopBtn.onclick = function() { window.scrollTo({ top: 0, behavior: 'smooth' }); };

// Simple client-side search filter (keeps logic frontend-only)
const searchInput = document.getElementById('activitySearch');
searchInput.addEventListener('input', function(){
    const q = this.value.trim().toLowerCase();
    document.querySelectorAll('#activitiesGrid .stagger').forEach(card => {
        const title = card.dataset.title || '';
        const loc = card.dataset.location || '';
        const desc = card.dataset.desc || '';
        const visible = (title + ' ' + loc + ' ' + desc).includes(q);
        card.style.display = visible ? '' : 'none';
    });
});

// Simple client-side sort (reorders DOM nodes)
const sortSelect = document.getElementById('sortSelect');
sortSelect.addEventListener('change', function(){
    const grid = document.getElementById('activitiesGrid');
    const items = Array.from(grid.children);
    if(this.value === 'name'){
        items.sort((a,b) => a.querySelector('.card-title').textContent.trim().localeCompare(b.querySelector('.card-title').textContent.trim()));
    } else if(this.value === 'location'){
        items.sort((a,b) => (a.dataset.location || '').localeCompare(b.dataset.location || ''));
    } else { items.sort((a,b) => 0); /* default: original order — no-op */ }
    // re-append
    items.forEach(i => grid.appendChild(i));
});

// Theme toggle
const toggleTheme = document.getElementById('toggleTheme');
toggleTheme.addEventListener('click', () => {
    const html = document.documentElement;
    if(html.getAttribute('data-theme') === 'dark') html.removeAttribute('data-theme');
    else html.setAttribute('data-theme','dark');
});
</script>

<footer class="bg-dark text-light pt-5 pb-4 mt-5">
    <div class="container text-center">
        <h5 class="fw-bold mb-4">Connect with Us</h5>
        <div class="mb-4">
            <a href="https://instagram.com" target="_blank" class="text-light mx-3 footer-social-link"><i class="bi bi-instagram fs-4 me-1"></i> Instagram</a>
            <a href="https://facebook.com" target="_blank" class="text-light mx-3 footer-social-link"><i class="bi bi-facebook fs-4 me-1"></i> Facebook</a>
            <a href="mailto:humanityconnect@info.com" class="text-light mx-3 footer-social-link"><i class="bi bi-envelope-fill fs-4 me-1"></i> Email</a>
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
