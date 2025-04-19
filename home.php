<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) header("Location: index.php");
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home - Car Site</title>
    <style>
        :root {
            --primary: #1a1a2e;
            --secondary: #16213e;
            --accent: #0f3460;
            --text: #e94560;
            --light: #f1f1f1;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            background: var(--primary);
            color: var(--light);
        }

        nav {
            background: var(--secondary);
            padding: 1.5rem;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            align-items: center;
        }

        nav a, nav form button {
            color: var(--light);
            margin: 0;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            letter-spacing: 1px;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        nav a:hover, nav form button:hover {
            background: var(--accent);
            color: var(--text);
            transform: translateY(-2px);
        }

        .container {
            max-width: 1200px;
            margin: 160px auto 2rem;
            padding: 2rem;
        }

        h2 {
            color: var(--text);
            margin-bottom: 2rem;
            font-weight: 600;
            letter-spacing: 1px;
            position: relative;
            padding-bottom: 10px;
        }

        h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100px;
            height: 3px;
            background: var(--text);
        }

        select, button {
            padding: 12px 15px;
            margin: 0 10px 10px 0;
            border: none;
            border-radius: 8px;
            background: var(--secondary);
            color: var(--light);
            font-size: 16px;
            transition: all 0.3s;
        }

        select {
            min-width: 200px;
        }

        select:focus {
            outline: none;
            box-shadow: 0 0 0 2px var(--text);
        }

        button {
            background: var(--text);
            font-weight: 600;
            cursor: pointer;
            letter-spacing: 1px;
        }

        button:hover {
            background: #d13354;
            transform: translateY(-2px);
        }

        #results {
            margin-top: 2rem;
        }

        .part-card {
            background: var(--secondary);
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            transition: all 0.3s;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .part-card:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .part-name {
            font-weight: 500;
            font-size: 18px;
        }

        .part-price {
            color: var(--text);
            font-weight: 600;
            font-size: 20px;
        }

        form select[name="rating"] {
            background: var(--secondary);
            color: var(--light);
            border-radius: 8px;
            padding: 10px;
            font-size: 16px;
            margin-right: 10px;
        }

        #ratingForm button {
            background: var(--accent);
            color: var(--light);
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
        }

        #ratingForm button:hover {
            background: var(--text);
            transform: translateY(-2px);
        }

        #ratingMessage {
            margin-top: 10px;
            font-weight: 500;
        }

        .welcome {
            text-align: center;
            margin-top: 100px;
            font-size: 18px;
            font-weight: 500;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<?php include 'header.php'; ?>

<nav>
    <a href="buy.php">Buy a Car</a>
    <a href="sell.php">Sell a Car</a>
    <a href="compare.php">Compare Cars</a>
    <form method="post" action="logout.php" style="display:inline;">
        <button type="submit">Logout</button>
    </form>
</nav>

<!-- Welcome Message -->


<div class="container">
    <h2>Search Car Parts</h2>
    <select id="brand">
        <option value="">Select Brand</option>
        <?php
        $res = $conn->query("SELECT DISTINCT brand FROM car");
        while($row = $res->fetch_assoc()) {
            echo "<option value='{$row['brand']}'>{$row['brand']}</option>";
        }
        ?>
    </select>

    <select id="model">
        <option value="">Select Model</option>
    </select>

    <select id="year">
        <option value="">Select Year</option>
    </select>

    <button onclick="searchParts()">Search</button>

    <div id="results"></div>

    <h2>Rate Our Website</h2>
    <form id="ratingForm" method="post" action="submit_rating.php">
        <select name="rating" required>
            <option value="">Select a rating</option>
            <option value="1">⭐ - Very Bad</option>
            <option value="2">⭐⭐ - Bad</option>
            <option value="3">⭐⭐⭐ - Okay</option>
            <option value="4">⭐⭐⭐⭐ - Good</option>
            <option value="5">⭐⭐⭐⭐⭐ - Excellent</option>
        </select>
        <button type="submit">Submit Rating</button>
    </form>
    <div id="ratingMessage"></div>
</div>

<script>
document.getElementById('brand').onchange = function() {
    fetch('search_parts.php?brand=' + this.value)
        .then(res => res.json())
        .then(data => {
            let model = document.getElementById('model');
            model.innerHTML = '<option value="">Select Model</option>';
            data.models.forEach(m => model.innerHTML += `<option value="${m}">${m}</option>`);
        });
};

document.getElementById('model').onchange = function() {
    const brand = document.getElementById('brand').value;
    fetch('search_parts.php?brand=' + brand + '&model=' + this.value)
        .then(res => res.json())
        .then(data => {
            let year = document.getElementById('year');
            year.innerHTML = '<option value="">Select Year</option>';
            data.years.forEach(y => year.innerHTML += `<option value="${y}">${y}</option>`);
        });
};

function searchParts() {
    const brand = document.getElementById('brand').value;
    const model = document.getElementById('model').value;
    const year = document.getElementById('year').value;

    fetch(`search_parts.php?brand=${brand}&model=${model}&year=${year}&fetch=parts`)
        .then(res => res.text())
        .then(data => document.getElementById('results').innerHTML = data);
}

document.getElementById('ratingForm').onsubmit = function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch('submit_rating.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(msg => document.getElementById('ratingMessage').innerText = msg)
    .catch(err => console.error('Error:', err));
};
</script>

</body>
</html>
