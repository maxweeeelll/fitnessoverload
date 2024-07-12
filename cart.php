<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
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
$items = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $items[$row['id']] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'price' => $row['price'],
            'image_url' => $row['image_url'],
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
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

        .container {
            width: 80%;
            margin: 80px auto 20px;
            overflow: hidden;
            padding: 20px;
        }

        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .cart-table th, .cart-table td {
            text-align: left;
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }

        .cart-table th {
            background-color: #4ecdc4;
            color: var(--light-color);
        }

        .cart-table tr:hover {
            background-color: #f5f5f5;
        }

        .item-image {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }

        .checkout-form {
            background: #fff;
            padding: 20px;
            margin-top: 20px;
            border-radius: 5px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .checkout-form h2 {
            color: var(--dark-color);
            margin-bottom: 20px;
        }

        .checkout-form label {
            display: block;
            margin: 10px 0 5px;
        }

        .checkout-form input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .checkout-form input[type="submit"] {
            display: inline-block;
            background: var(--primary-color);
            color: var(--light-color);
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .checkout-form input[type="submit"]:hover {
            background-color: #ff4757;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: var(--dark-color);
            text-decoration: none;
        }

        .back-link:hover {
            color: var(--primary-color);
        }

        .empty-cart {
            text-align: center;
            margin-top: 50px;
            font-size: 18px;
            color: #777;
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
                    <li><a href="index.php">Home</a></li>
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

    <div class="container">
        <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
            <table class="cart-table">
                <tr>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Image</th>
                </tr>
                <?php 
                $total = 0;
                foreach ($_SESSION['cart'] as $item_id => $item): 
                    $total += $item['price'] * $item['quantity'];
                    
                    // Fetch the image URL from the $items array
                    $image_url = isset($items[$item_id]['image_url']) ? $items[$item_id]['image_url'] : '';
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                    <td>
                        <?php if (!empty($image_url)): ?>
                            <img src="<?php echo htmlspecialchars($image_url); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="item-image">
                        <?php else: ?>
                            <span>No image available</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td><strong>$<?php echo number_format($total, 2); ?></strong></td>
                    <td></td>
                </tr>
            </table>

            <form class="checkout-form" method="post" action="">
                <h2>Checkout</h2>
                <label for="customer_name">Name:</label>
                <input type="text" id="customer_name" name="customer_name" required>
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>
                <input type="submit" name="checkout" value="Complete Purchase">
            </form>
        <?php else: ?>
            <p class="empty-cart">Your cart is empty. <a href="products.php">Continue shopping</a></p>
        <?php endif; ?>
        
        <a href="products.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Shop
        </a>
    </div>
</body>
</html>
