<?php include 'db.php'; if (session_status() === PHP_SESSION_NONE) {
    session_start();
} ?>
<?php include 'header.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Compare Cars</title>
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
        
        .compare-form {
            display: flex;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .compare-selector {
            flex: 1;
            background: var(--card-bg);
            padding: 1.5rem;
            border-radius: 10px;
            border: 1px solid var(--border);
        }
        
        select {
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
            display: block;
            margin: 0 auto;
        }
        
        .btn:hover {
            background: #d13354;
            transform: translateY(-2px);
        }
        
        .comparison-table {
            width: 100%;
            border-collapse: collapse;
            background: var(--card-bg);
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid var(--border);
        }
        
        .comparison-table th {
            background: var(--secondary);
            padding: 1rem;
            text-align: left;
        }
        
        .comparison-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--border);
        }
        
        .comparison-table tr:nth-child(even) {
            background: rgba(255,255,255,0.05);
        }
        
        .highlight {
            font-weight: bold;
            color: var(--accent);
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Compare Cars</h1>
    </div>
    
    <div class="nav">
        <a href="home.php">Home</a>
        <a href="buy.php">Buy a Car</a>
        <a href="sell.php">Sell a Car</a>
        <a href="compare.php" class="active">Compare Cars</a>
         
    </div>
    
    <div class="container">
        <form method="post">
            <div class="compare-form">
                <div class="compare-selector">
                    <h3>Car 1</h3>
                    <select name="car1" required>
                        <option value="">Select Car</option>
                        <?php
                        $cars = $conn->query("SELECT id, brand, model, year FROM car");
                        while($row = $cars->fetch_assoc()) {
                            echo '<option value="'.$row['id'].'">'.$row['brand'].' '.$row['model'].' ('.$row['year'].')</option>';
                        }
                        ?>
                    </select>
                </div>
                
                <div class="compare-selector">
                    <h3>Car 2</h3>
                    <select name="car2" required>
                        <option value="">Select Car</option>
                        <?php
                        $cars = $conn->query("SELECT id, brand, model, year FROM car");
                        while($row = $cars->fetch_assoc()) {
                            echo '<option value="'.$row['id'].'">'.$row['brand'].' '.$row['model'].' ('.$row['year'].')</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            
            <button type="submit" name="compare" class="btn">Compare Now</button>
        </form>
        
        <?php
        if (isset($_POST['compare'])) {
            $car1 = $conn->query("SELECT * FROM car WHERE id=".$_POST['car1'])->fetch_assoc();
            $car2 = $conn->query("SELECT * FROM car WHERE id=".$_POST['car2'])->fetch_assoc();
            
            echo '<div style="margin-top: 3rem;">
                    <h2>Comparison Results</h2>
                    <table class="comparison-table">
                        <tr>
                            <th>Feature</th>
                            <th>'.$car1['brand'].' '.$car1['model'].'</th>
                            <th>'.$car2['brand'].' '.$car2['model'].'</th>
                        </tr>
                        <tr>
                            <td>Year</td>
                            <td>'.$car1['year'].'</td>
                            <td>'.$car2['year'].'</td>
                        </tr>
                        <tr>
                            <td>Price</td>
                            <td class="'.($car1['asking_price'] < $car2['asking_price'] ? 'highlight' : '').'">₹'.number_format($car1['asking_price'], 2).'</td>
                            <td class="'.($car2['asking_price'] < $car1['asking_price'] ? 'highlight' : '').'">₹'.number_format($car2['asking_price'], 2).'</td>
                        </tr>
                        <tr>
                            <td>Mileage</td>
                            <td class="'.($car1['mileage'] > $car2['mileage'] ? 'highlight' : '').'">'.$car1['mileage'].' km</td>
                            <td class="'.($car2['mileage'] > $car1['mileage'] ? 'highlight' : '').'">'.$car2['mileage'].' km</td>
                        </tr>
                        <tr>
                            <td>Fuel Type</td>
                            <td>'.$car1['fuel_type'].'</td>
                            <td>'.$car2['fuel_type'].'</td>
                        </tr>
                        <tr>
                            <td>Transmission</td>
                            <td>'.$car1['transmission'].'</td>
                            <td>'.$car2['transmission'].'</td>
                        </tr>
                    </table>
                  </div>';
        }
        ?>
    </div>
</body>
</html>