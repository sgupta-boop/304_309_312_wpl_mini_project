<?php
// Make sure to include the correct path to db_connect.php
include 'db.php'; // Ensure this path is correct

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Step 1: Handle POST (Update logic)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $plate = $_POST['plate'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $price = $_POST['asking_price'];
    $mileage = $_POST['mileage'];
    $fuel = $_POST['fuel_type'];
    $transmission = $_POST['transmission'];
    $description = $_POST['description'];
     // Added seller_email

    // Ensure connection is established before executing any query
    if (isset($conn) && $conn instanceof mysqli) {
        $update = $conn->prepare("UPDATE car SET brand=?, model=?, year=?, asking_price=?, mileage=?, fuel_type=?, transmission=?, description=? WHERE numberplate=?");
        $update->bind_param("ssiddssss", $brand, $model, $year, $price, $mileage, $fuel, $transmission, $description, $plate);

        if ($update->execute()) {
            $_SESSION['message'] = "Car updated successfully!";
            header("Location: sell.php");
            exit;
        } else {
            $error = "Update failed. Please try again.";
        }
    } else {
        $error = "Database connection failed.";
    }
}

// Step 2: Handle GET (Form display)
if (!isset($_GET['plate']) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Invalid request.";
    exit;
}

$plate = $_GET['plate'] ?? $_POST['plate'];
$stmt = $conn->prepare("SELECT * FROM car WHERE numberplate = ?");
$stmt->bind_param("s", $plate);
$stmt->execute();
$result = $stmt->get_result();
$car = $result->fetch_assoc();

if (!$car) {
    echo "Car not found.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Car</title>
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
    </style>
</head>
<body>
    <div class="header">
        <h1>Edit Car Listing</h1>
    </div>

    <div class="nav">
        <a href="home.php">Home</a>
        <a href="buy.php">Buy a Car</a>
        <a href="sell.php" class="active">Sell a Car</a>
        <a href="compare.php">Compare Cars</a>
    </div>

    <div class="container">
        <div class="form-container">
            <h2>Edit Car Details</h2>
            <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
            <form method="post" action="edit_car.php">
                <input type="hidden" name="plate" value="<?= htmlspecialchars($car['numberplate']) ?>">

                <div class="form-row">
                    <div class="form-group">
                        <label>Brand</label>
                        <input type="text" name="brand" value="<?= htmlspecialchars($car['brand']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Model</label>
                        <input type="text" name="model" value="<?= htmlspecialchars($car['model']) ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Year</label>
                        <input type="number" name="year" value="<?= $car['year'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Asking Price</label>
                        <input type="number" step="0.01" name="asking_price" value="<?= $car['asking_price'] ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Mileage</label>
                        <input type="number" name="mileage" value="<?= $car['mileage'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Fuel Type</label>
                        <input type="text" name="fuel_type" value="<?= htmlspecialchars($car['fuel_type']) ?>" required>
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
                        <label>Description</label>
                        <textarea name="description"><?= htmlspecialchars($car['description']) ?></textarea>
                    </div>
                </div>

                
                <button type="submit" class="btn">Update Car</button>
            </form>
        </div>
    </div>
</body>
</html>
