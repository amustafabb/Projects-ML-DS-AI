<?php
include "../includes/db.inc.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    if(isset($_POST["type"])){
        $sql = "SELECT Vehicle_ID, Vehicle_plate, Vehicle_colour, Vehicle_model, Vehicle_make FROM vehicle";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                $data = [];
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
                echo json_encode(['success' => true, 'data' => $data]);
            } else {
                echo json_encode(['success' => false, 'message' => 'No vehicles found.']);
            }

            // Close connection
            $conn->close();
            return;
    }
    switch ($action) {
        case 'getMakes':
            $query = "SELECT DISTINCT Vehicle_make FROM vehicle";
            break;

        case 'getModels':
            $make = $conn->real_escape_string($_POST['make']);
            $query = "SELECT DISTINCT Vehicle_model FROM vehicle WHERE Vehicle_make = '$make'";
            break;
            $model = $conn->real_escape_string($_POST['model']);
        case 'getColours':
            $model = $conn->real_escape_string($_POST['model']);
            
            $query = "SELECT DISTINCT Vehicle_colour FROM vehicle WHERE Vehicle_model = '$model'";
            break;

        case 'getPlates':
            $colour = $conn->real_escape_string($_POST['colour']);
            $make = $conn->real_escape_string($_POST['make']);
            $model = $conn->real_escape_string($_POST['model']);
           echo  $query = "SELECT Vehicle_ID, Vehicle_plate FROM vehicle WHERE Vehicle_colour = '$colour' and Vehicle_model = '$model' and Vehicle_make = '$make'";
            break;

        default:
            echo "<option value=''>Invalid Action</option>";
            exit;
    }

    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($action === 'getPlates') {
                echo "<option value='{$row['Vehicle_ID']}'>{$row['Vehicle_plate']}</option>";
            } else {
                $value = htmlspecialchars(array_values($row)[0]);
                echo "<option value='{$value}'>{$value}</option>";
            }
        }
    } else {
        echo "<option value=''>No options available</option>";
    }
}
?>
