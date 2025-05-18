<?php
// Database connection
 include "../includes/db.inc.php";

// Validate and sanitize input
$name = $conn->real_escape_string($_POST['name'] ?? '');
$address = $conn->real_escape_string($_POST['address'] ?? '');
$license_number = $conn->real_escape_string($_POST['license_number'] ?? '');

if (empty($name) || empty($address) || empty($license_number)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

// Insert into database
$query = "INSERT INTO People (People_name, People_address, People_licence) 
          VALUES ('$name', '$address', '$license_number')";

if ($conn->query($query) === TRUE) {
    echo json_encode(['success' => true, 'message' => 'Person added successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
}

// Close connection
$conn->close();
