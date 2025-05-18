<?php
include "../includes/db.inc.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST["type"])){
        $sql = "SELECT i.Incident_ID,i.Incident_Report,i.Incident_Date,v.Vehicle_make,v.Vehicle_model,v.Vehicle_colour,v.Vehicle_plate,p.People_name,o.Offence_description,o.Offence_maxFine,o.Offence_maxPoints FROM incident i JOIN vehicle v ON i.Vehicle_ID = v.Vehicle_ID JOIN people p ON i.People_ID = p.People_ID JOIN offence o ON i.Offence_ID = o.Offence_ID ORDER BY i.Incident_Date DESC;";
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
    
}
?>
