<!DOCTYPE html>
<html lang="en">
<head>
    <title>About HumanityConnect</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


     <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
<link rel="manifest" href="images/site.webmanifest">
    <link rel="icon" type="image/ico"  href="images/favicon.ico">
    
    <style>
        :root {
            --primary-blue: #0d6efd;
            --light-grey: #f8f9fa;
            --dark-text: #333;
            --shadow-light: rgba(0, 0, 0, 0.05);
            --shadow-medium: rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light-grey);
            color: var(--dark-text);
            line-height: 1.6;
        }

        .navbar-brand {
            font-family: 'Inter', sans-serif; 
            font-weight: 700;
            font-size: 1.5rem; 
        }

        .hero-section {
            background: linear-gradient(135deg, #0d6efd, #0a58ca);
            color: white;
            padding: 100px 20px; 
            text-align: center;
            position: relative;
            overflow: hidden; 
        }

        .hero-section h1 {
            font-family: 'Playfair Display', serif; 
            font-size: 4.2rem; 
            font-weight: 800;
            margin-bottom: 20px; 
            letter-spacing: -0.05rem; 
            text-shadow: 0 4px 10px rgba(0,0,0,0.2); 
        }

        .hero-section p {
            font-size: 1.35rem; 
            max-width: 800px; 
            margin: 0 auto 40px auto; 
            opacity: 0.95; 
        }

        .section-heading {
            font-family: 'Playfair Display', serif; 
            font-weight: 700;
            font-size: 2.8rem; 
            margin-bottom: 2.5rem; 
            color: #212529; 
        }

        .values-section {
            background-color: white;
            border-radius: 15px; 
            padding: 50px 40px; 
            box-shadow: 0 8px 30px var(--shadow-light); 
            margin-bottom: 5rem; 
        }

        .values-section h5 {
            color: var(--primary-blue);
            font-weight: 700; 
            font-size: 1.3rem; 
            margin-bottom: 15px; 
        }
        
        .values-section p {
            font-size: 1.05rem; 
            color: #555;
        }

        .testimonial {
            background-color: #fff;
            padding: 2rem; 
            border-left: 5px solid var(--primary-blue); 
            margin-bottom: 2rem;
            border-radius: 0.75rem; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.06); 
            transition: transform 0.2s ease, box-shadow 0.2s ease; 
        }

        .testimonial:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .testimonial p {
            font-style: italic;
            margin-bottom: 1rem; 
            font-size: 1.1rem; 
            color: #444;
        }

        .testimonial small {
            font-weight: 600;
            color: var(--primary-blue);
            display: block; 
            margin-top: 10px; 
        }

        .company-logo-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 40px; 
        }

        .company-logo {
            width: 300px; 
            height: 200px; 
            object-fit: contain; 
            background-color: white;
            padding: 25px; 
            border-radius: 15px; 
            box-shadow: 0 5px 20px rgba(0,0,0,0.08); 
            transition: transform 0.2s ease, box-shadow 0.2s ease; 
        }

        .company-logo:hover {
            transform: translateY(-8px) scale(1.02); 
            box-shadow: 0 12px 35px rgba(0,0,0,0.15); 
        }

        .btn-primary {
            padding: 15px 40px; 
            border-radius: 35px; 
            font-size: 1.1rem; 
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            background-color: #0a58ca;
        }

        h2 {
            font-family: 'Playfair Display', serif; 
            font-weight: 700;
            font-size: 2.8rem;
        }

        h3 {
            font-family: 'Playfair Display', serif; 
            font-weight: 700;
            font-size: 2.2rem; 
        }

        main.container {
            padding-top: 6rem; 
            padding-bottom: 6rem; 
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero-section h1 {
                font-size: 3rem;
            }
            .hero-section p {
                font-size: 1.1rem;
            }
            .section-heading {
                font-size: 2rem;
            }
            .company-logo {
                width: 250px;
                height: 180px;
                padding: 20px;
            }
            .company-logo-container {
                gap: 20px;
            }
        }

        @media (max-width: 576px) {
            .hero-section h1 {
                font-size: 2.5rem;
            }
            .hero-section p {
                font-size: 1rem;
            }
            .company-logo {
                width: 100%; 
                height: auto;
                max-width: 280px; 
            }
        }

         /* Buttoni per me ba scroll nalt */
        #scrollTopBtn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            display: none;
            background-color: #0d6efd;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 50%;
            font-size: 1.2rem;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            cursor: pointer;
            z-index: 999;
        }

        #scrollTopBtn:hover {
            background-color: #0b5ed7;
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

<header class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="home.php">Humanity Connect</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                </ul>
        </div>
    </div>
</header>

<section class="hero-section">
    <div class="container">
        <h1>Building a Kinder, Connected World</h1>
        <p>HumanityConnect is a platform dedicated to empowering people through meaningful activities, volunteer opportunities, and community-driven initiatives. We make it easy for individuals to take part, contribute, and make a difference.</p>

        <!-- Added centered large logo -->
        
        <a href="home.php" class="btn btn-light btn-lg rounded-pill px-5 py-3 shadow-sm">Explore Activities</a>
    </div>
</section>

<main class="container py-5">



    <section class="mb-6">
        <img src="images/humanityconnectlogo.png" alt="HumanityConnect Logo" style="width:1000px; height:700px; border-radius:18px; margin:25px auto; display:block; background:white; padding:18px; box-shadow:0 6px 22px rgba(0,0,0,0.12);">
    </section>


    <section class="mb-6">
        <h2 class="text-center section-heading">Our Story, Our Purpose</h2>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <p class="lead text-center mb-4">
                    HumanityConnect was founded to inspire people to do good. Our platform brings communities together by providing easy access to volunteer programs, social activities, and humanitarian initiatives. Every person has the power to help — we simply make the connection effortless.
                </p>
                <p class="text-center">
                    By collaborating with local organizations, youth groups, community leaders, and volunteers, we create a space where anyone can participate in meaningful actions. Whether it’s environmental projects, educational activities, cultural events, or helping those in need, HumanityConnect is here to support every good deed.
                </p>
            </div>
        </div>
    </section>
    <br><br>

    <section class="values-section mb-6">
        <h3 class="text-center mb-5 section-heading">Our Driving Force: Mission, Vision & Core Values</h3>
        <div class="row text-center">
            <div class="col-md-4 mb-4 mb-md-0">
                <h5>🎯 Our Mission</h5>
                <p>To inspire, connect, and empower individuals to take part in acts of kindness and community activities that create real, positive change.</p>
            </div>
            <div class="col-md-4 mb-4 mb-md-0">
                <h5>🌍 Our Vision</h5>
                <p>A world where every person has the opportunity to contribute, help others, and strengthen the communities they live in — one activity at a time.</p>
            </div>
            <div class="col-md-4">
                <h5>💡 Our Values</h5>
                <p>Compassion, unity, transparency, and commitment. We believe in teamwork, accessibility, and the power of helping without expecting anything in return.</p>
            </div>
        </div>
    </section>

    <section class="mb-6">
        <h2 class="text-center section-heading">Hear From Our Community</h2>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="testimonial">
                    <p>"Thanks to HumanityConnect, I joined my first volunteer activity. Everything was clear, organized, and honestly inspiring. I can’t wait for the next one!"</p>
                    <small>– Arta H., Volunteer</small>
                </div>
                <div class="testimonial">
                    <p>"A beautiful platform with a meaningful purpose. It helps you find great activities and connect with amazing people who want to do good."</p>
                    <small>– Blendi K., Community Member</small>
                </div>
                <div class="testimonial">
                    <p>"As an organizer, HumanityConnect has helped us reach more volunteers and manage our activities with much less effort. Truly transformative."</p>
                    <small>– Blerta L., Activity Organizer</small>
                </div>
            </div>
        </div>
    </section>

</main>


<!-- Buttoni per me shku nalt -->
<button id="scrollTopBtn" title="Scroll to top">↑</button>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Scroll-to-top logjika
const scrollTopBtn = document.getElementById("scrollTopBtn");

window.onscroll = function() {
    scrollTopBtn.style.display = (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) ? "block" : "none";
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