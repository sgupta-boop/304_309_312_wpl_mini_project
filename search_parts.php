<?php
include 'db.php';

if (isset($_GET['fetch']) && $_GET['fetch'] === 'parts') {
    $b = $_GET['brand'];
    $m = $_GET['model'];
    $y = $_GET['year'];
    $res = $conn->query("SELECT part_name, part_price FROM parts WHERE car_maker='$b' AND model_line='$m' AND year='$y'");
    while($row = $res->fetch_assoc()) {
        echo "<div style='border:1px solid #ccc;padding:10px;margin:10px 0;'>
                <strong>{$row['part_name']}</strong> - ₹{$row['part_price']}
              </div>";
    }
    exit;
}

$brand = $_GET['brand'];
$model = $_GET['model'] ?? null;

if (!$model) {
    $res = $conn->query("SELECT DISTINCT model FROM car WHERE brand='$brand'");
    $models = [];
    while($row = $res->fetch_assoc()) $models[] = $row['model'];
    echo json_encode(['models' => $models]);
} else {
    $res = $conn->query("SELECT DISTINCT year FROM car WHERE brand='$brand' AND model='$model'");
    $years = [];
    while($row = $res->fetch_assoc()) $years[] = $row['year'];
    echo json_encode(['years' => $years]);
}
