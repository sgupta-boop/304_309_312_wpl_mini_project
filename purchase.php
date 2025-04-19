<?php 
include 'db.php'; 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$plate = $_GET['plate'] ?? '';
$price = $_GET['price'] ?? 0;

// Get car details
$car = $conn->query("SELECT * FROM car WHERE numberplate = '$plate'")->fetch_assoc();

// Get listing details
$listing = $conn->query("SELECT * FROM listings WHERE numberplate = '$plate'")->fetch_assoc();

// Get all images for this car
$images = [];
if (file_exists("car_images/")) {
    $files = scandir("car_images/");
    foreach ($files as $file) {
        if (strpos($file, $plate) === 0) {
            $images[] = "car_images/" . $file;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Purchase - <?= htmlspecialchars($car['brand'] ?? 'Car') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1a1a2e;
            --secondary: #16213e;
            --accent: #e94560;
            --text-light: #f1f1f1;
            --card-bg: #0f3460;
            --border: #2a3a5e;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            background: var(--primary);
            color: var(--text-light);
        }

        .header {
            background: var(--secondary);
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }

        .nav {
            display: flex;
            justify-content: center;
            background: var(--secondary);
            padding: 1rem;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .nav a {
            color: var(--text-light);
            margin: 0 1.5rem;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .nav a:hover, .nav a.active {
            background: var(--accent);
            transform: translateY(-2px);
        }

        .purchase-container {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 2rem;
        }

        .car-summary {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border);
        }

        .image-gallery {
            flex: 1;
            min-width: 300px;
        }

        .main-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 1rem;
        }

        .thumbnail-container {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .thumbnail {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .thumbnail:hover {
            transform: scale(1.1);
        }

        .car-details {
            flex: 1;
            min-width: 300px;
        }

        .car-title {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--accent);
        }

        .car-specs {
            margin: 1rem 0;
        }

        .car-spec {
            display: flex;
            margin-bottom: 0.5rem;
        }

        .spec-label {
            font-weight: 500;
            width: 120px;
        }

        .car-price {
            font-size: 2rem;
            font-weight: bold;
            color: var(--accent);
            margin: 1.5rem 0;
        }

        .car-description {
            background: var(--secondary);
            padding: 1rem;
            border-radius: 5px;
            margin: 1rem 0;
        }

        .payment-methods {
            margin: 2rem 0;
        }

        .payment-card {
            display: flex;
            align-items: center;
            padding: 1rem;
            background: var(--secondary);
            border-radius: 8px;
            margin-bottom: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            border: 1px solid var(--border);
        }

        .payment-card:hover {
            border-color: var(--accent);
        }

        .payment-card.selected {
            border: 2px solid var(--accent);
            background: rgba(233, 69, 96, 0.1);
        }

        .payment-icon {
            font-size: 2rem;
            margin-right: 1rem;
            color: var(--accent);
        }

        .payment-info h4 {
            margin: 0 0 0.25rem 0;
        }

        .payment-info p {
            margin: 0;
            color: #b8c2cc;
            font-size: 0.9rem;
        }

        .btn {
            background: var(--accent);
            color: white;
            border: none;
            padding: 1rem;
            width: 100%;
            border-radius: 5px;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 1.5rem;
        }

        .btn:hover {
            background: #d13354;
            transform: translateY(-2px);
        }

        .add-payment {
            text-align: center;
            margin-top: 1rem;
        }

        .add-payment a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
        }

        .not-found {
            text-align: center;
            padding: 2rem;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Complete Purchase</h1>
    </div>

    <div class="nav">
        <a href="buy.php">Buy a Car</a>
        <a href="sell.php">Sell a Car</a>
        <a href="compare.php">Compare Cars</a>
        <a href="purchase.php" class="active">Purchase</a>
    </div>

    <div class="purchase-container">
        <?php if ($car): ?>
            <div class="car-summary">
                <div class="image-gallery">
                    <?php if (!empty($images)): ?>
                        <img id="main-image" src="<?= $images[0] ?>" class="main-image" alt="Car Image">
                        <div class="thumbnail-container">
                            <?php foreach ($images as $index => $image): ?>
                                <img src="<?= $image ?>" class="thumbnail" 
                                     onclick="document.getElementById('main-image').src = '<?= $image ?>'" 
                                     alt="Car Thumbnail <?= $index + 1 ?>">
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <img src="car_images/default.jpg" class="main-image" alt="No Image Available">
                    <?php endif; ?>
                </div>

                <div class="car-details">
                    <h1 class="car-title"><?= htmlspecialchars($car['brand']) ?> <?= htmlspecialchars($car['model']) ?></h1>
                    <div class="car-specs">
                        <div class="car-spec">
                            <span class="spec-label">Year:</span>
                            <span><?= htmlspecialchars($car['year']) ?></span>
                        </div>
                        <div class="car-spec">
                            <span class="spec-label">Plate:</span>
                            <span><?= htmlspecialchars($car['numberplate']) ?></span>
                        </div>
                        <div class="car-spec">
                            <span class="spec-label">Mileage:</span>
                            <span><?= number_format($car['mileage']) ?> km</span>
                        </div>
                        <div class="car-spec">
                            <span class="spec-label">Fuel Type:</span>
                            <span><?= htmlspecialchars($car['fuel_type']) ?></span>
                        </div>
                        <div class="car-spec">
                            <span class="spec-label">Transmission:</span>
                            <span><?= htmlspecialchars($car['transmission']) ?></span>
                        </div>
                    </div>

                    <?php if (!empty($car['description'])): ?>
                        <div class="car-description">
                            <h3>Description</h3>
                            <p><?= nl2br(htmlspecialchars($car['description'])) ?></p>
                        </div>
                    <?php endif; ?>

                    <div class="car-price">₹<?= number_format($price, 2) ?></div>
                </div>
            </div>

            <h2>Select Payment Method</h2>
            <div class="payment-methods">
                <div class="payment-card" onclick="selectPayment(this, 1)">
                    <div class="payment-icon">💳</div>
                    <div class="payment-info">
                        <h4>Credit Card</h4>
                        <p>**** **** **** 4242</p>
                        <p>Expires 12/25</p>
                    </div>
                </div>

                <div class="payment-card" onclick="selectPayment(this, 2)">
                    <div class="payment-icon">🏦</div>
                    <div class="payment-info">
                        <h4>Debit Card</h4>
                        <p>**** **** **** 5555</p>
                        <p>Expires 06/24</p>
                    </div>
                </div>

                <div class="payment-card" onclick="selectPayment(this, 3)">
                    <div class="payment-icon">📱</div>
                    <div class="payment-info">
                        <h4>UPI Payment</h4>
                        <p>user@upi</p>
                    </div>
                </div>
            </div>

            <div class="add-payment">
                <a href="add_payment.php">+ Add New Payment Method</a>
            </div>

            <form method="post">
                <input type="hidden" name="complete" value="1">
                <button class="btn" type="submit">Complete Purchase</button>
            </form>

            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['complete'])) {
                // Remove from listings
                $conn->query("DELETE FROM listings WHERE numberplate = '$plate'");
                echo "<script>alert('Purchase completed successfully!'); window.location.href = 'home.php';</script>";
            }
            ?>
            
        <?php else: ?>
            <div class="not-found">
                <h2>Car Not Found</h2>
                <p>The car you're looking for doesn't exist or has been removed.</p>
                <a href="buy.php" class="btn" style="display: inline-block; width: auto; padding: 0.5rem 1.5rem;">
                    Browse Available Cars
                </a>
            </div>
        <?php endif; ?>
    </div>

    <script>
        let selectedPayment = null;

        function selectPayment(card, paymentId) {
            document.querySelectorAll('.payment-card').forEach(el => {
                el.classList.remove('selected');
            });
            card.classList.add('selected');
            selectedPayment = paymentId;
        }
    </script>
</body>
</html>
