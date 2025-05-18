<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "../includes/db.inc.php";

    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $role = $_POST['role'];
        
        if ($conn->query("INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')")) {
            echo "User added successfully.";
        } else {
            echo "Error: " . $conn->error;
        }
    } elseif ($action === 'delete') {
        $id = $_POST['id'];

        if ($conn->query("DELETE FROM users WHERE id = $id")) {
            echo "User deleted successfully.";
        } else {
            echo "Error: " . $conn->error;
        }
    } 
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    include "../includes/db.inc.php";

    $result = $conn->query("SELECT * FROM users");
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['username']}</td>
            <td>{$row['role']}</td>
            <td>
                
                <button class='btn btn-danger delete-user' data-id='{$row['id']}'>Delete</button>
            </td>
        </tr>";
    }
    exit;
}