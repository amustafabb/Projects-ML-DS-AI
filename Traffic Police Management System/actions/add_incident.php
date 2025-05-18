<?php
 include "../includes/db.inc.php";

// Get form data
$Incident_Report = $_POST['Incident_Report'] ?? '';
$Offense = $_POST['Offense'] ?? '';
$Incident_Date = $_POST['Incident_Date'] ?? '';
$person = $_POST['person'] ?? '';
$Vehicle_ID = $_POST['plate'] ?? '';

// Validate inputs
if (empty($Incident_Report) || empty($Offense) || empty($Incident_Date) || empty($person) || empty($Vehicle_ID)) {
    echo json_encode(['status' => 'failed', 'message' => 'All fields are required.']);
    exit;
}
$decodedData = json_decode($Offense, true); 
// Accessing values
 $offenceId = $decodedData['Offence_ID'];
  $Offence_maxPoints = $decodedData['Offence_maxPoints'];
   $offenceMaxFine = $decodedData['Offence_maxFine'];
// Insert into database
$sql="INSERT INTO `incident`( `Vehicle_ID`, `People_ID`, `Incident_Date`, `Incident_Report`, `Offence_ID`) VALUES ('".$Vehicle_ID."','".$person."','".$Incident_Date."','".$Incident_Report."','".$offenceId."')";

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    $sql1="INSERT INTO `fines`(`Fine_Amount`, `Fine_Points`, `Incident_ID`) VALUES ('".$offenceMaxFine."','".$Offence_maxPoints."','".$last_id."')";
    $conn->query($sql1);
    
    echo json_encode(['status' => 'success', 'message' => 'Record inserted.']);
} else {
    echo json_encode(['status' => "failed", 'message' => 'Error: ' . $conn->error]);
}

// Close connection
$conn->close();
?>
