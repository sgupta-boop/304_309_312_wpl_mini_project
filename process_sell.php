<?php
include 'db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// CSRF protection
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $_SESSION['error'] = "Invalid CSRF token.";
    header("Location: sell.php");
    exit;
}

// Save form data for repopulation
$_SESSION['form_data'] = $_POST;

// Extract and validate fields
$fields = ['brand', 'model', 'year', 'price', 'mileage', 'fuel_type', 'transmission', 'description'];
foreach ($fields as $field) {
    if (empty($_POST[$field])) {
        $_SESSION['error'] = "Please fill in all fields.";
        header("Location: sell.php");
        exit;
    }
}

if (!isset($_FILES['images']) || $_FILES['images']['error'][0] === 4) {
    $_SESSION['error'] = "Please upload at least one image.";
    header("Location: sell.php");
    exit;
}

// Sanitize inputs
$brand = $conn->real_escape_string($_POST['brand']);
$model = $conn->real_escape_string($_POST['model']);
$year = (int)$_POST['year'];
$price = (float)$_POST['price'];
$mileage = (int)$_POST['mileage'];
$fuel_type = $conn->real_escape_string($_POST['fuel_type']);
$transmission = $conn->real_escape_string($_POST['transmission']);
$description = $conn->real_escape_string($_POST['description']);
$email = $_SESSION['user'];

// Generate unique number plate (you may want a better system)
$numberplate = strtoupper(substr(md5(uniqid()), 0, 8));

// Insert into car table
$insertCar = $conn->prepare("INSERT INTO car (numberplate, brand, model, year, mileage, fuel_type, transmission, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$insertCar->bind_param("sssissss", $numberplate, $brand, $model, $year, $mileage, $fuel_type, $transmission, $description);
$insertCar->execute();

// Insert into listings table
$insertListing = $conn->prepare("INSERT INTO listings (numberplate, seller_email, asking_price, list_date) VALUES (?, ?, ?, NOW())");
$insertListing->bind_param("ssd", $numberplate, $email, $price);
$insertListing->execute();

// Handle file uploads
$uploadDir = "car_images/";
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
$max_size = 5 * 1024 * 1024; // 5MB

foreach ($_FILES['images']['tmp_name'] as $i => $tmp_name) {
    $file_type = $_FILES['images']['type'][$i];
    $file_size = $_FILES['images']['size'][$i];
    $file_error = $_FILES['images']['error'][$i];

    if ($file_error === 0 && in_array($file_type, $allowed_types) && $file_size <= $max_size) {
        $extension = pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION);
        $file_name = $uploadDir . $numberplate . "_" . $i . "." . $extension;
        move_uploaded_file($tmp_name, $file_name);
    }
}

// Cleanup
unset($_SESSION['form_data']);
$_SESSION['message'] = "Car listed successfully!";
header("Location: sell.php");
exit;
