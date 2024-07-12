<?php
session_start();

// Check if user is logged in, redirect if not
if (!isset($_SESSION['name'])) {
    header('Location: login.php');
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch items from the database
$sql = "SELECT * FROM items";
$result = $conn->query($sql);
$featuredProducts = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $featuredProducts[] = $row;
    }
}

// Add to cart functionality
if (isset($_POST['add_to_cart'])) {
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];
    
    $sql = "SELECT * FROM items WHERE id=$item_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $item = $result->fetch_assoc();
        $product_name = $item['name'];
        $price = $item['price'];
        
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        if (isset($_SESSION['cart'][$item_id])) {
            $_SESSION['cart'][$item_id]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$item_id] = [
                "name" => $product_name,
                "price" => $price,
                "quantity" => $quantity,
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Overload - Premium Gym Equipment</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&family=Oswald:wght@400;700&display=swap');

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

        .cta-button {
            display: inline-block;
            background-color: var(--primary-color);
            color: var(--light-color);
            padding: 1rem 2rem;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .cta-button:hover {
            background-color: #ff4757;
        }

        .category-nav {
            background-color: var(--secondary-color);
            padding: 1rem 0;
            position: sticky;
            top: 60px;
            z-index: 100;
        }

        .category-nav ul {
            display: flex;
            justify-content: center;
            list-style: none;
        }

        .category-nav li {
            margin: 0 1rem;
        }

        .category-icon {
            color: var(--dark-color);
            text-decoration: none;
            font-weight: bold;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: color 0.3s ease;
        }

        .category-icon i {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .category-icon:hover {
            color: var(--light-color);
        }

        .featured-products {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .featured-products h2 {
            font-size: 2.5rem;
            margin-bottom: 2rem;
            text-align: center;
            color: var(--dark-color);
            font-family: 'Oswald', sans-serif;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .product-item {
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .product-item:hover {
            transform: translateY(-5px);
        }

        .product-image-container {
            position: relative;
            overflow: hidden;
        }

        .product-image-container img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-item:hover .product-image-container img {
            transform: scale(1.1);
        }

        .quick-view {
            position: absolute;
            bottom: -50px;
            left: 0;
            right: 0;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 0.5rem;
            text-align: center;
            transition: bottom 0.3s ease;
        }

        .product-item:hover .quick-view {
            bottom: 0;
        }

        .view-details {
            color: var(--light-color);
            text-decoration: none;
            font-weight: bold;
        }

        .product-info {
            padding: 1.5rem;
        }

        .product-info h3 {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
            color: var(--dark-color);
        }

        .rating {
            color: #f39c12;
            margin-bottom: 0.5rem;
        }

        .product-info p {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .product-price {
            font-size: 1.2rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .add-to-cart {
            display: block;
            background-color: var(--primary-color);
            color: var(--light-color);
            padding: 0.5rem 1rem;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .add-to-cart:hover {
            background-color: #ff4757;
        }

        .benefits {
            background-color: var(--secondary-color);
            padding: 4rem 0;
        }

        .benefits-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            text-align: center;
        }

        .benefit-item {
            background-color: var(--light-color);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .benefit-item i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .benefit-item h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--dark-color);
        }

        .testimonials {
            padding: 4rem 0;
            background-color: var(--light-color);
        }

        .testimonials-content {
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
        }

        .testimonials h2 {
            font-size: 2.5rem;
            margin-bottom: 2rem;
            color: var(--dark-color);
            font-family: 'Oswald', sans-serif;
        }

        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .testimonial-item {
            background-color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .testimonial-item img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 1rem;
        }

        .testimonial-item p {
            font-style: italic;
            margin-bottom: 1rem;
        }

        .testimonial-item .client-name {
            font-weight: bold;
            color: var(--primary-color);
        }

        footer {
            background-color: var(--dark-color);
            color: var(--light-color);
            padding: 2rem 0;
            margin-top: 2rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            padding: 0 1rem;
        }

        .newsletter-signup {
            flex-basis: 100%;
            margin-bottom: 2rem;
        }

        .newsletter-signup h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .newsletter-signup form {
            display: flex;
        }

        .newsletter-signup input[type="email"] {
            flex-grow: 1;
            padding: 0.5rem;
            border: none;
            border-radius: 4px 0 0 4px;
        }

        .newsletter-signup button {
            background-color: var(--primary-color);
            color: var(--light-color);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .newsletter-signup button:hover {
            background-color: #ff4757;
        }

        .social-links {
            display: flex;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .social-icon {
            color: var(--light-color);
            font-size: 1.5rem;
            margin: 0 0.5rem;
            transition: color 0.3s ease;
        }

        .social-icon:hover {
            color: var(--primary-color);
        }

        .footer-links {
            list-style: none;
            display: flex;
            justify-content: center;
            margin-top: 1rem;
        }

        .footer-links li {
            margin: 0 1rem;
        }

        .footer-links a {
            color: var(--light-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .navbar-content {
                flex-direction: column;
                align-items: flex-start;
            }

            .nav-menu {
                margin-top: 1rem;
            }

            .nav-menu li {
                margin-left: 0;
                margin-right: 1rem;
            }

            .hero h1 {
                font-size: 2.5rem;
            }
            .hero p {
                font-size: 1.2rem;
            }

            .product-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }

            .benefits-content {
                grid-template-columns: 1fr;
            }

            .testimonial-grid {
                grid-template-columns: 1fr;
            }

            .footer-content {
                flex-direction: column;
                align-items: center;
            }

            .newsletter-signup {
                text-align: center;
                margin-bottom: 2rem;
            }

            .footer-links {
                flex-direction: column;
                align-items: center;
            }

            .footer-links li {
                margin: 0.5rem 0;
            }
        }
    </style>
</head>
<body>
    <header class="navbar">
        <div class="navbar-content">
            <div class="logo">
                <a href="index.php">Fitness Overload</a>
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

    <section class="hero">
        <video autoplay muted loop id="myVideo">
            <source src="https://videos.pexels.com/video-files/4812848/4812848-uhd_2560_1440_25fps.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="hero-content">
            <h1>Forge Your Fitness Journey, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h1>
            <p>Elevate your workout with premium fitness equipment.</p>
            <a href="#featured-products" class="cta-button">Explore Equipment</a>
        </div>
    </section>

    <nav class="category-nav">
        <ul>
            <li><a href="#" class="category-icon" data-category="treadmills"><i class="fas fa-running"></i> Treadmills</a></li>
            <li><a href="#" class="category-icon" data-category="weights"><i class="fas fa-dumbbell"></i> Weights</a></li>
            <li><a href="#" class="category-icon" data-category="cardio"><i class="fas fa-heartbeat"></i> Cardio</a></li>
            <li><a href="#" class="category-icon" data-category="yoga"><i class="fas fa-spa"></i> Yoga</a></li>
            <li><a href="#" class="category-icon" data-category="accessories"><i class="fas fa-cog"></i> Accessories</a></li>
        </ul>
    </nav>

    <section class="featured-products" id="featured-products">
        <h2>Featured Equipment</h2>
        <div class="product-grid">
            <?php foreach ($featuredProducts as $product): ?>
                <div class="product-item" data-category="<?php echo htmlspecialchars($product['category'], ENT_QUOTES); ?>">

                    <div class="product-image-container">
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <div class="quick-view">
                            <a href="#" class="view-details">Quick View</a>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <div class="rating">
                            <?php 
                            $rating = isset($product['rating']) ? intval($product['rating']) : 0;
                            $rating = max(0, min(5, $rating)); // Ensure rating is between 0 and 5
                            for ($i = 1; $i <= 5; $i++): 
                            ?>
                                <i class="fas fa-star<?php echo ($i <= $rating) ? '' : '-o'; ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <p><?php echo htmlspecialchars($product['description']); ?></p>
                        <p class="product-price">$<?php echo number_format($product['price'], 2); ?></p>
                        <form method="post" action="">
                            <input type="hidden" name="item_id" value="<?php echo $product['id']; ?>">
                            <input type="number" name="quantity" value="1" min="1" style="width: 50px;">
                            <input type="submit" name="add_to_cart" value="Add to Cart" class="add-to-cart">
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="benefits">
        <div class="benefits-content">
            <div class="benefit-item">
                <i class="fas fa-truck"></i>
                <h3>Free Shipping</h3>
                <p>On orders over $500</p>
            </div>
            <div class="benefit-item">
                <i class="fas fa-undo"></i>
                <h3>30-Day Returns</h3>
                <p>Hassle-free return policy</p>
            </div>
            <div class="benefit-item">
                <i class="fas fa-headset"></i>
                <h3>24/7 Support</h3>
                <p>Expert assistance anytime</p>
            </div>
        </div>
    </section>

    <section class="testimonials">
        <div class="testimonials-content">
            <h2>What Our Customers Say</h2>
            <div class="testimonial-grid">
                <div class="testimonial-item">
                    <img src="https://library.sportingnews.com/styles/crop_style_16_9_desktop/s3/2023-04/Alex%20Pereira%20130423%20%282%29.jpg?h=d1f72a4a&itok=bj-iScYj" alt="Alex Pereira">
                    <p>"Chama"</p>
                    <span class="client-name">Alex Pereira</span>
                </div>
                <div class="testimonial-item">
                    <img src="https://www.mmaweekly.com/.image/ar_1:1%2Cc_fill%2Ccs_srgb%2Cfl_progressive%2Cq_auto:good%2Cw_1200/MjAwMzE4MzkyNzE5MTIzODMy/max-holloway-ufc276weigh-in-1600.jpg" alt="Jane Smith">
                    <p>"I'm very satisfied with my purchase."</p>
                    <span class="client-name">Max Holloway</span>
                </div>
                <div class="testimonial-item">
                    <img src="https://i.ytimg.com/vi/iMzXPmWtMAw/maxresdefault.jpg" alt="Islam Makhachev">
                    <p>"The variety of products is impressive."</p>
                    <span class="client-name">Islam makhachev</span>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <div class="newsletter-signup">
                <h3>Get Weekly Fitness Tips</h3>
                <form action="subscribe.php" method="post">
                    <input type="email" name="email" placeholder="Your email" required>
                    <button type="submit">Subscribe</button>
                </form>
            </div>
            <div class="social-links">
                <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
            </div>
            <p>&copy; 2024 Fitness Overload Equipment. All rights reserved.</p>
            <ul class="footer-links">
                <li><a href="privacy.php">Privacy Policy</a></li>
                <li><a href="terms.php">Terms of Service</a></li>
            </ul>
        </div>
    </footer>

    <script>
        // Category filter functionality
        document.querySelectorAll('.category-icon').forEach(icon => {
            icon.addEventListener('click', function(e) {
                e.preventDefault();
                const category = this.dataset.category;
                document.querySelectorAll('.product-item').forEach(item => {
                    if (category === 'all' || item.dataset.category === category) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });

        // Smooth scroll for internal links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>