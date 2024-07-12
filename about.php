<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - Fitness Overload</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Oswald:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        :root {
            --primary-color: #ff6b6b;
            --secondary-color: #4ecdc4;
            --dark-color: #2c3e50;
            --light-color: #ecf0f1;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Roboto', sans-serif;
            line-height: 1.6;
            color: var(--dark-color);
            background-color: var(--light-color);
        }

        .navbar {
            background-color: var(--dark-color);
            color: var(--light-color);
            padding: 1rem;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .navbar-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo a {
            color: var(--light-color);
            text-decoration: none;
            font-size: 1.8rem;
            font-weight: bold;
            font-family: 'Oswald', sans-serif;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .nav-menu {
            display: flex;
            list-style: none;
        }

        .nav-menu li {
            margin-left: 1.5rem;
        }

        .nav-menu a {
            color: var(--light-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-menu a:hover {
            color: var(--primary-color);
        }

        .logout-btn {
            background-color: var(--primary-color);
            color: var(--light-color);
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #ff4757;
        }

        .hero {
            height: 100vh;
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: var(--light-color);
        }

        .hero video {
            position: absolute;
            top: 50%;
            left: 50%;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            transform: translateX(-50%) translateY(-50%);
            z-index: -1;
        }

        .hero-content {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 2rem;
            border-radius: 10px;
        }

        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            font-family: 'Oswald', sans-serif;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .hero p {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            max-width: 600px;
        }

        .container {
            width: 80%;
            margin: 80px auto 20px;
            overflow: hidden;
            padding: 20px;
        }

        .about-section {
            background-color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .about-section h1 {
            color: var(--primary-color);
            margin-bottom: 2rem;
            font-size: 2.5rem;
            text-align: center;
            color: var(--dark-color);
            font-family: 'Oswald', sans-serif;
        }

        .about-section p {
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .about-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 2rem;
        }

        .mission-vision {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
            gap: 2rem;
        }

        .mission {
            flex-basis: 48%;
            background-color: var(--primary-color);
            padding: 1.5rem;
            border-radius: 10px;
            color: var(--light-color);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .vision {
            flex-basis: 48%;
            background-color: var(--secondary-color);
            padding: 1.5rem;
            border-radius: 10px;
            color: var(--light-color);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .mission h2, .vision h2 {
            margin-bottom: 1rem;
            font-size: 1.5rem;
            text-align: center;
            border-bottom: 2px solid var(--light-color);
            padding-bottom: 0.5rem;
        }

        .mission ul, .vision ul {
            margin-left: 1.5rem;
            margin-bottom: 1rem;
        }

        .mission p, .vision p {
            font-style: italic;
            text-align: center;
            margin-top: 1rem;
        }

        .team-section {
            margin-top: 3rem;
        }

        .team-section h2 {
            text-align: center;
            margin-bottom: 2rem;
            color: var(--dark-color);
        }

        .team-members {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .team-member {
            flex-basis: 30%;
            text-align: center;
            margin-bottom: 2rem;
        }

        .team-member img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 1rem;
            border: 3px solid var(--primary-color);
        }

        .team-member h3 {
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .team-member p {
            color: var(--secondary-color);
        }

        .values {
            margin-top: 3rem;
        }

        .values h2 {
            text-align: center;
            margin-bottom: 2rem;
            color: var(--dark-color);
        }

        .value-items {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .value-item {
            flex-basis: 22%;
            text-align: center;
            margin-bottom: 2rem;
        }

        .value-item i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .value-item h3 {
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .testimonial {
            background-color: var(--secondary-color);
            color: var(--light-color);
            padding: 2rem;
            border-radius: 10px;
            margin-top: 3rem;
            text-align: center;
        }

        .testimonial p {
            font-style: italic;
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }

        .testimonial .author {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-content">
            <div class="logo">
                <a href="#">Fitness Overload</a>
            </div>
            <ul class="nav-menu">
                <li><a href="home.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="cart.php">Cart</a></li>
                
            </ul>
            <button class="logout-btn">Logout</button>
        </div>
    </nav>

    <section class="hero">
        <video autoplay muted loop id="myVideo">
            <source src="https://videos.pexels.com/video-files/4920813/4920813-hd_1920_1080_25fps.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="hero-content">
            <h1>About Fitness Overload</h1>
            <p>Empowering your fitness journey with top-quality equipment and expert guidance.</p>
        </div>
    </section>

    <div class="container">
        <div class="about-section">
            <p>Welcome to Fitness Overload, your ultimate destination for premium gym equipment. Founded in 2010, we've been committed to helping fitness enthusiasts and professionals achieve their goals with top-quality gear.</p>
            
            <div class="mission-vision">
                <div class="mission">
                    <h2>Our Mission</h2>
                    <p>To empower individuals on their fitness journey by providing:</p>
                    <ul>
                        <li>Cutting-edge, high-quality equipment</li>
                        <li>Innovative fitness solutions</li>
                        <li>Expert guidance and support</li>
                    </ul>
                    <p>Together, we strive to unlock your full potential and pave the way to a healthier, stronger you.</p>
                </div>
                <div class="vision">
                    <h2>Our Vision</h2>
                    <p>To revolutionize the fitness landscape by:</p>
                    <ul>
                        <li>Being the go-to source for premium fitness gear</li>
                        <li>Fostering a global community of health enthusiasts</li>
                        <li>Inspiring positive lifestyle changes worldwide</li>
                    </ul>
                    <p>We aspire to create a world where everyone has the tools and motivation to achieve their wellness goals.</p>
                </div>
            </div>

            <p>At Fitness Overload, we pride ourselves on curating the best selection of gym equipment from trusted brands, offering expert advice, providing excellent customer service, and staying up-to-date with the latest fitness trends and technologies.</p>

            <div class="values">
                <h2>Our Core Values</h2>
                <div class="value-items">
                    <div class="value-item">
                        <i class="fas fa-medal"></i>
                        <h3>Quality</h3>
                        <p>We never compromise on the quality of our products.</p>
                    </div>
                    <div class="value-item">
                        <i class="fas fa-handshake"></i>
                        <h3>Integrity</h3>
                        <p>We conduct our business with honesty and transparency.</p>
                    </div>
                    <div class="value-item">
                        <i class="fas fa-users"></i>
                        <h3>Customer Focus</h3>
                        <p>Our customers' satisfaction is our top priority.</p>
                    </div>
                    <div class="value-item">
                        <i class="fas fa-lightbulb"></i>
                        <h3>Innovation</h3>
                        <p>We continuously seek new ways to improve and evolve.</p>
                    </div>
                </div>
            </div>

            <div class="team-section">
                <h2>Meet Our Team</h2>
                <div class="team-members">
                    <div class="team-member">
                        <img src="https://scontent.fmnl33-2.fna.fbcdn.net/v/t39.30808-6/427949302_7129309950493225_3188446905764732933_n.jpg?stp=cp6_dst-jpg&_nc_cat=103&ccb=1-7&_nc_sid=a5f93a&_nc_ohc=tzUzgrrYNHgQ7kNvgHVhkZP&_nc_ht=scontent.fmnl33-2.fna&oh=00_AYAygMDoG-jwumcrXf-STliill1Qnq7h_ZGPO0VOCtLGqA&oe=668F65B5" alt="John Doe">
                        <h3>Louize Noval</h3>
                        <p>Founder & CEO</p>
                    </div>
                    <div class="team-member">
                        <img src="https://scontent.fmnl33-6.fna.fbcdn.net/v/t39.30808-6/431955582_1168050504566682_1805999593395284543_n.jpg?stp=cp6_dst-jpg&_nc_cat=106&ccb=1-7&_nc_sid=6ee11a&_nc_ohc=JzpUUqGf2oAQ7kNvgFvwyCT&_nc_ht=scontent.fmnl33-6.fna&oh=00_AYBSoF5QzbU0aXIX9d4cceQVS2qhhDo-uvuv4pYU8NS9sA&oe=668F4613" alt="Jane Smith">
                        <h3>Russ Lacson</h3>
                        <p>Scammer</p>
                    </div>
                </div>
            </div>

            <div class="testimonial">
                <p>"f you want to lift weights then do it. If you want to get big and muscly the go for it. If you want to run and get faster then do it. If you want to dance then do it. Stop living (or NOT living) to please others and start living to please YOU!"</p>
                <p class="author">- Rendon Labrador</p>
            </div>
        </div>
    </div>
</body>
</html>