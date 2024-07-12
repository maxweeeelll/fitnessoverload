<?php
session_start();

// Check if user is logged in, redirect if not
if (!isset($_SESSION['name'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Overload Equipment</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&family=Oswald:wght@400;700&display=swap');

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family:  'Roboto', sans-serif;`
            line-height: 1.6;
            color:  #2c3e50;
            background-color: #ecf0f1;
        }

        .navbar {
            background-color: #2c3e50;
            color: #ecf0f1;
            padding: 1rem;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-menu a:hover {
            color: #ff6b6b;
        }

        .logout-btn {
            background-color: #ff6b6b;
            color: #fff;
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
            background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('gym-equipment.jpg');
            background-size: cover;
            background-position: center;
            height: 80vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
        }

        .hero h1 {
            font-size: 4rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .hero p {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            max-width: 600px;
        }

        .cta-button {
            background-color: #ff6b6b;
            color: #fff;
            padding: 1rem 2rem;
            text-decoration: none;
            font-size: 1.2rem;
            border-radius: 50px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(255, 107, 107, 0.4);
        }

        .features {
            display: flex;
            justify-content: space-around;
            padding: 4rem 2rem;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .feature {
            text-align: center;
            max-width: 300px;
            padding: 2rem;
            border-radius: 10px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .feature:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .feature i {
            font-size: 3rem;
            color: #ff6b6b;
            margin-bottom: 1rem;
        }

        .feature h2 {
            margin-bottom: 1rem;
            color: #333;
        }

        .feature p {
            color: #666;
        }

        .equipment-showcase {
            padding: 4rem 2rem;
            background-color: #f9f9f9;
        }

        .equipment-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .equipment-item {
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .equipment-item:hover {
            transform: translateY(-5px);
        }

        .equipment-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .equipment-info {
            padding: 1rem;
        }

        .equipment-info h3 {
            margin-bottom: 0.5rem;
            color: #333;
        }

        .equipment-info p {
            color: #666;
            font-size: 0.9rem;
        }

        footer {
            background-color: #1a1a1a;
            color: #fff;
            text-align: center;
            padding: 2rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-links {
            display: flex;
            list-style: none;
        }

        .footer-links li {
            margin-left: 1rem;
        }

        .footer-links a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: #ff6b6b;
        }

        .social-icons {
            display: flex;
        }

        .social-icons a {
            color: #fff;
            font-size: 1.5rem;
            margin-left: 1rem;
            transition: color 0.3s ease;
        }

        .social-icons a:hover {
            color: #ff6b6b;
        }
    </style>
</head>
<body>
    <header class="navbar">
        <div class="navbar-content">
            <div class="logo">
                <a href="home.php">Fitness Overload</a>
            </div>
            <nav>
                <ul class="nav-menu">
                    <li><a href="home.php">Home</a></li>
                    <li><a href="products.php">Products</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="cart.php">Cart</a></li>
                    
                </ul>
            </nav>
            <div class="user-actions">
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
        </div>
    </header>

    <main>
        <section class="hero">
            <h1>Welcome to Fitness Overload, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h1>

            <p>Discover premium gym equipment to power your workouts and achieve your goals</p>
            <a href="products.php" class="cta-button">Explore Equipment</a>
        </section>

        <section class="features">
            <div class="feature">
                <i class="fas fa-shield-alt"></i>
                <h2>Premium Quality</h2>
                <p>Top-tier materials and craftsmanship for lasting durability.</p>
            </div>
            <div class="feature">
                <i class="fas fa-truck"></i>
                <h2>Fast Shipping</h2>
                <p>Quick delivery to get you started on your fitness journey ASAP.</p>
            </div>
            <div class="feature">
                <i class="fas fa-headset"></i>
                <h2>Expert Support</h2>
                <p>Knowledgeable team ready to assist with your equipment needs.</p>
            </div>
        </section>

        <section class="equipment-showcase">
            <h2 style="text-align: center; margin-bottom: 2rem;">Featured Equipment</h2>
            <div class="equipment-grid">
                <div class="equipment-item">
                    <img src="https://pngimg.com/d/treadmill_PNG114.png" alt="Treadmill">
                    <div class="equipment-info">
                        <h3>Pro Runner Treadmill</h3>
                        <p>High-performance treadmill with advanced features for all fitness levels.</p>
                    </div>
                </div>
                <div class="equipment-item">
                    <img src="https://t4.ftcdn.net/jpg/06/54/34/49/360_F_654344994_q7YLNLvHbSCzKvr5G5M96rMPwFkeFgZY.jpg" alt="Dumbbells">
                    <div class="equipment-info">
                        <h3>Adjustable Dumbbells Set</h3>
                        <p>Versatile weight set for strength training and muscle building.</p>
                    </div>
                </div>
                <div class="equipment-item">
                    <img src="https://www.jbsports.com.ph/__resources/webdata/images/products/327.jpg" alt="Exercise Bike">
                    <div class="equipment-info">
                        <h3>Spin Master Exercise Bike</h3>
                        <p>Indoor cycling bike for intense cardio workouts and endurance training.</p>
                    </div>
                </div>
                <div class="equipment-item">
                    <img src="https://gym-mikolo.com/cdn/shop/files/mikolo-power-rack-k6-b-1.png?v=1712113702&width=2000" alt="Power Rack">
                    <div class="equipment-info">
                        <h3>Ultimate Power Rack</h3>
                        <p>Comprehensive strength training station for serious lifters.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <p>&copy; 2024 Fitness Overload Equipment. All rights reserved.</p>
            <ul class="footer-links">
                <li><a href="privacy.php">Privacy Policy</a></li>
                <li><a href="terms.php">Terms of Service</a></li>
            </ul>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
            </div>
        </div>
    </footer>
</body>
</html>