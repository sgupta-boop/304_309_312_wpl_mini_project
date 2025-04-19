<?php include 'db.php'; session_start(); ?>


<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <style>
        :root {
            --primary: #1a1a2e;
            --secondary: #16213e;
            --accent: #0f3460;
            --text: #e94560;
            --light: #f1f1f1;
        }
        
        body {
            background: var(--primary);
            font-family: 'Montserrat', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: var(--light);
        }
        
        .form-container {
            background: var(--secondary);
            padding: 2.5rem;
            border-radius: 15px;
            width: 400px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            transform: translateY(0);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .form-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
        }
        
        h2 {
            color: var(--text);
            text-align: center;
            margin-bottom: 1.5rem;
            font-weight: 600;
            letter-spacing: 1px;
        }
        
        input {
            width: 100%;
            padding: 12px 15px;
            margin: 10px 0;
            border: none;
            border-radius: 8px;
            background: rgba(255,255,255,0.1);
            color: var(--light);
            font-size: 16px;
            transition: all 0.3s;
        }
        
        input::placeholder {
            color: rgba(255,255,255,0.5);
        }
        
        input:focus {
            outline: none;
            background: rgba(255,255,255,0.2);
            box-shadow: 0 0 0 2px var(--text);
        }
        
        button {
            background: var(--text);
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 1rem;
            transition: all 0.3s;
            letter-spacing: 1px;
        }
        
        button:hover {
            background: #d13354;
            transform: translateY(-2px);
        }
        
        a {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            color: var(--light);
            text-decoration: none;
            transition: all 0.3s;
        }
        
        a:hover {
            color: var(--text);
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="form-container">
    <h2>CREATE ACCOUNT</h2>
    <form method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="signup">SIGN UP</button>
    </form>
    <a href="login.php">Already have an account? Login</a>
</div>

<?php
if (isset($_POST['signup'])) {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($check->num_rows > 0) {
        echo "<script>alert('User already exists. Please log in.');</script>";
    } else {
        $conn->query("INSERT INTO users (email, password) VALUES ('$email', '$password')");
        echo "<script>alert('Registration successful! Please login.'); window.location.href='login.php';</script>";
    }
}
?>
</body>
</html>