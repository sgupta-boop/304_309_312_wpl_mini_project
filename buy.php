<?php 
include 'db.php'; 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php include 'header.php'; ?>


<!DOCTYPE html>
<html>
<head>
    <title>Buy a Car</title>
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
            padding: 2rem;
        }
        
        .section-title {
            color: var(--accent);
            margin-bottom: 2rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--accent);
        }
        
        .car-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
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
        
        .badge {
            background: var(--accent);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.8rem;
            display: inline-block;
            margin-left: 0.5rem;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="header">
        <h1>Buy a Car</h1>
    </div>
    
    <div class="nav">
        <a href="home.php">Home</a>
        <a href="buy.php" class="active">Buy a Car</a>
        <a href="sell.php">Sell a Car</a>
        <a href="compare.php">Compare Cars</a>
        
         
    </div>
    
    <div class="container">
        <h2 class="section-title">Available Cars</h2>
        
        <div class="car-grid">
            <?php
            $res = $conn->query("SELECT * FROM listings WHERE status = 'active' ORDER BY list_date DESC");
            
            if ($res->num_rows > 0) {
                while($row = $res->fetch_assoc()) {
                    // Find first image for this car
                    $image_path = null;
                    if (file_exists("car_images/")) {
                        $files = scandir("car_images/");
                        foreach ($files as $file) {
                            if (strpos($file, $row['numberplate']) === 0) {
                                $image_path = "car_images/" . $file;
                                break;
                            }
                        }
                    }
                    
                    echo '<div class="car-card">';
                    echo '<a href="purchase.php?plate='.$row['numberplate'].'&price='.$row['asking_price'].'">';
                    echo '<div class="car-image" style="background-image: url(\''.($image_path ?: 'car_images/default.jpg').'\')"></div>';
                    echo '<div class="car-details">';
                    echo '<div class="car-title">'.$row['brand'].' '.$row['model'].' <span class="badge">'.$row['listing_type'].'</span></div>';
                    echo '<div class="car-info">'.$row['numberplate'].' • '.number_format($row['mileage']).' km</div>';
                    echo '<div class="car-info">'.$row['fuel_type'].' • '.$row['transmission'].'</div>';
                    echo '<div class="car-price">₹'.number_format($row['asking_price'], 2).'</div>';
                    echo '</div></a></div>';
                }
            } else {
                echo '<p>No cars available for purchase at this time.</p>';
            }
            ?>
        </div>
    </div>
</body>
</html>