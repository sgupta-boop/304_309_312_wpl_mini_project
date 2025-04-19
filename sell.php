<?php include 'header.php'; ?>

<?php 
include 'db.php'; 
// session_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Generate CSRF token if not exists
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Get all cars listed by current user
$user_email = $_SESSION['user'];
$user_cars = [];
$result = $conn->query("
    SELECT c.*, l.asking_price, l.list_date 
    FROM car c
    JOIN listings l ON c.numberplate = l.numberplate
    WHERE l.seller_email = '$user_email'
    ORDER BY l.list_date DESC
");

if ($result && $result->num_rows > 0) {
    $user_cars = $result->fetch_all(MYSQLI_ASSOC);
}

// Display messages
if (isset($_SESSION['error'])) {
    echo '<div class="alert error" style="padding: 15px; background: #f44336; color: white; margin-bottom: 20px; border-radius: 5px;">'
        . htmlspecialchars($_SESSION['error']) . 
        '</div>';
    unset($_SESSION['error']);
}

if (isset($_SESSION['message'])) {
    echo '<div class="alert success" style="padding: 15px; background: #4CAF50; color: white; margin-bottom: 20px; border-radius: 5px;">'
        . htmlspecialchars($_SESSION['message']) . 
        '</div>';
    unset($_SESSION['message']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sell a Car</title>
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
        
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }
        
        .form-container {
            background: var(--card-bg);
            padding: 2rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            border: 1px solid var(--border);
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        
        input, select, textarea {
            width: 100%;
            padding: 0.75rem;
            background: var(--secondary);
            border: 1px solid var(--border);
            border-radius: 5px;
            color: var(--text-light);
            font-family: 'Montserrat', sans-serif;
        }
        
        .btn {
            background: var(--accent);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn:hover {
            background: #d13354;
            transform: translateY(-2px);
        }
        
        .form-row {
            display: flex;
            gap: 1.5rem;
        }
        
        .form-row .form-group {
            flex: 1;
        }
        
        .cars-list {
            margin-top: 2rem;
        }
        
        .car-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 1rem;
        }
        
        .car-card {
            background: var(--card-bg);
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid var(--border);
            transition: all 0.3s;
        }
        
        .car-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.3);
        }
        
        .car-image {
            height: 180px;
            background-size: cover;
            background-position: center;
            background-color: #ddd;
        }
        
        .car-details {
            padding: 1.5rem;
        }
        
        .car-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .car-info {
            color: #b8c2cc;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        .car-price {
            color: var(--accent);
            font-weight: 700;
            font-size: 1.3rem;
        }
        
        .car-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }
        
        .car-actions .btn {
            flex: 1;
            padding: 0.5rem;
            font-size: 0.9rem;
        }
        
        .section-title {
            color: var(--accent);
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--accent);
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Sell a Car</h1>
    </div>
    
    <div class="nav">
         <a href="home.php">Home</a>
        <a href="buy.php">Buy a Car</a>
        <a href="sell.php" class="active">Sell a Car</a>
        <a href="compare.php">Compare Cars</a>
        
    </div>
    
    <div class="container">
        <div class="form-container">
            <h2 class="section-title">List a New Car</h2>
            <form action="process_sell.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="brand">Brand</label>
                        <input type="text" id="brand" name="brand"   
                               value="<?= isset($_SESSION['form_data']) ? htmlspecialchars($_SESSION['form_data']['brand']) : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="model">Model</label>
                        <input type="text" id="model" name="model"  
                               value="<?= isset($_SESSION['form_data']) ? htmlspecialchars($_SESSION['form_data']['model']) : '' ?>">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="year">Year</label>
                        <input type="number" id="year" name="year" min="1900" max="<?= date('Y') + 1 ?>"  
                               value="<?= isset($_SESSION['form_data']) ? htmlspecialchars($_SESSION['form_data']['year']) : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="price">Asking Price (₹)</label>
                        <input type="number" id="price" name="price" min="0" step="0.01"  
                               value="<?= isset($_SESSION['form_data']) ? htmlspecialchars($_SESSION['form_data']['price']) : '' ?>">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="mileage">Mileage (km)</label>
                        <input type="number" id="mileage" name="mileage" min="0"  
                               value="<?= isset($_SESSION['form_data']) ? htmlspecialchars($_SESSION['form_data']['mileage']) : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="fuel_type">Fuel Type</label>
                        <select id="fuel_type" name="fuel_type"  >
                            <option value="Petrol" <?= isset($_SESSION['form_data']) && $_SESSION['form_data']['fuel_type'] === 'Petrol' ? 'selected' : '' ?>>Petrol</option>
                            <option value="Diesel" <?= isset($_SESSION['form_data']) && $_SESSION['form_data']['fuel_type'] === 'Diesel' ? 'selected' : '' ?>>Diesel</option>
                            <option value="Electric" <?= isset($_SESSION['form_data']) && $_SESSION['form_data']['fuel_type'] === 'Electric' ? 'selected' : '' ?>>Electric</option>
                            <option value="Hybrid" <?= isset($_SESSION['form_data']) && $_SESSION['form_data']['fuel_type'] === 'Hybrid' ? 'selected' : '' ?>>Hybrid</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="transmission">Transmission</label>
                    <select id="transmission" name="transmission"  >
                        <option value="Manual" <?= isset($_SESSION['form_data']) && $_SESSION['form_data']['transmission'] === 'Manual' ? 'selected' : '' ?>>Manual</option>
                        <option value="Automatic" <?= isset($_SESSION['form_data']) && $_SESSION['form_data']['transmission'] === 'Automatic' ? 'selected' : '' ?>>Automatic</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4"><?= isset($_SESSION['form_data']) ? htmlspecialchars($_SESSION['form_data']['description']) : '' ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="images">Car Images (Multiple allowed, max 5MB each)</label>
                    <input type="file" id="images" name="images[]" multiple accept="image/jpeg, image/png, image/gif">
                </div>
                
                <button type="submit" class="btn">List My Car</button>
            </form>
            <?php unset($_SESSION['form_data']); ?>
        </div>
        
        <div class="cars-list">
            <h2 class="section-title">Your Listed Cars</h2>
            
            <?php if (count($user_cars) > 0): ?>
                <div class="car-grid">
                    <?php foreach ($user_cars as $car): 
                        // Find first image for this car
                        $image_path = null;
                        if (file_exists("car_images/")) {
                            $files = scandir("car_images/");
                            foreach ($files as $file) {
                                if (strpos($file, $car['numberplate']) === 0) {
                                    $image_path = "car_images/" . $file;
                                    break;
                                }
                            }
                        }
                    ?>
                        <div class="car-card">
                            <div class="car-image" style="background-image: url('<?= $image_path ?: 'car_images/default.jpg' ?>')"></div>
                            <div class="car-details">
                                <div class="car-title"><?= htmlspecialchars($car['brand']) ?> <?= htmlspecialchars($car['model']) ?></div>
                                <div class="car-info"><?= htmlspecialchars($car['year']) ?> • <?= htmlspecialchars($car['numberplate']) ?></div>
                                <div class="car-info"><?= number_format($car['mileage']) ?> km • <?= htmlspecialchars($car['fuel_type']) ?></div>
                                <div class="car-price">₹<?= number_format($car['asking_price'], 2) ?></div>
                                <div class="car-actions">
                                    <a href="purchase.php?plate=<?= $car['numberplate'] ?>&price=<?= $car['asking_price'] ?>" class="btn">View</a>
                                    <a href="edit_car.php?plate=<?= $car['numberplate'] ?>" class="btn" style="background: var(--secondary);">Edit</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>You haven't listed any cars yet.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>