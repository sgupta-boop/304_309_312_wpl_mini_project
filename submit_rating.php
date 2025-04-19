<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'db.php';

if (!isset($_SESSION['user'])) {
    echo "You must be logged in to submit a rating.";
    exit;
}

$user = $_SESSION['user'];
$rating = isset($_POST['rating']) ? (int) $_POST['rating'] : 0;

if ($rating < 1 || $rating > 5) {
    echo "Invalid rating value.";
    exit;
}

// Check if the user has already rated
$check = $conn->prepare("SELECT * FROM rating WHERE user = ?");
$check->bind_param("s", $user);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    // Update previous rating
    $update = $conn->prepare("UPDATE rating SET rating = ?, created_at = NOW() WHERE user = ?");
    $update->bind_param("is", $rating, $user);
    if ($update->execute()) {
        echo "Your rating has been updated!";
    } else {
        echo "Failed to update rating.";
    }
} else {
    // Insert new rating
    $stmt = $conn->prepare("INSERT INTO rating (user, rating, created_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("si", $user, $rating);
    if ($stmt->execute()) {
        echo "Thank you for your rating!";
    } else {
        echo "Failed to submit rating.";
    }
}
?>
