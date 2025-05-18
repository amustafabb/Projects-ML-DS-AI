<?php
// Database connection
include "../includes/db.inc.php";



// Fetch matching records
$sql = "SELECT People_ID, People_name, People_address, People_licence 
        FROM People ";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode(['success' => true, 'data' => $data]);
} else {
    echo json_encode(['success' => false, 'message' => 'No matching records found.']);
}

// Close connection
$conn->close();
