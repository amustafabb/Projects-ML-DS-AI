<?php
 include "../includes/db.inc.php";

// Get form data
$plate = $_POST['Vehicle_plate'] ?? '';
$colour = $_POST['Vehicle_colour'] ?? '';
$model = $_POST['Vehicle_model'] ?? '';
$make = $_POST['Vehicle_make'] ?? '';

// Validate inputs
if (empty($plate) || empty($colour) || empty($model) || empty($make)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

// Insert into database
$sql = "INSERT INTO vehicle (Vehicle_plate, Vehicle_colour, Vehicle_model, Vehicle_make) 
        VALUES ('$plate', '$colour', '$model', '$make')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
}

// Close connection
$conn->close();
?>
