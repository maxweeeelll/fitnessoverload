<?php
// Start the session (if not already started)
session_start();

// Check if user is logged in, redirect if not
if (!isset($_SESSION['name'])) {
    header('Location: login.php');
    exit();
}

// Database connection (you may need to adjust these details)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message_content = $_POST['message'];
    
    // Here you would typically process the form data, such as sending an email or storing in database
    // For this example, we'll just set a success message
    $message = "Thank you for your message. We'll get back to you soon!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Fitness Overload</title>
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
            height: 50vh;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: var(--light-color);
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

        .contact-section {
            background-color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .contact-section h1 {
            color: var(--primary-color);
            margin-bottom: 2rem;
            font-size: 2.5rem;
            text-align: center;
            color: var(--dark-color);
            font-family: 'Oswald', sans-serif;
        }

        .contact-form {
            display: grid;
            gap: 1rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        .form-group input,
        .form-group textarea {
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group textarea {
            height: 150px;
        }

        .submit-btn {
            background-color: var(--primary-color);
            color: var(--light-color);
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #ff4757;
        }

        .contact-info {
            margin-top: 2rem;
            text-align: center;
        }

        .contact-info h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .contact-info p {
            margin-bottom: 0.5rem;
        }

        .success-message {
            background-color: var(--secondary-color);
            color: white;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
            text-align: center;
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
        <div class="hero-content">
            <h1>Contact Fitness Overload</h1>
            <p>We're here to assist you on your fitness journey.</p>
        </div>
    </section>

    <div class="container">
        <div class="contact-section">
            <h1>Get in Touch</h1>
            
            <?php if ($message): ?>
                <div class="success-message"><?php echo $message; ?></div>
            <?php endif; ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="contact-form">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="subject">Subject:</label>
                    <input type="text" id="subject" name="subject" required>
                </div>
                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" required></textarea>
                </div>
                <button type="submit" class="submit-btn">Send Message</button>
            </form>

            <div class="contact-info">
                <h3>Contact Information</h3>
                <p><i class="fas fa-phone"></i> Phone: +639 12390412</p>
                <p><i class="fas fa-envelope"></i> Email: info@fitnessoverload.ph</p>
                <p><i class="fas fa-map-marker-alt"></i> Address: 123 Fitness Street, Makati City, Philippines</p>
            </div>
        </div>
    </div>
</body>
</html>