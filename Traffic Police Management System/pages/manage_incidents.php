<?php include "../includes/auth.inc.php"; ?>
<?php include "../includes/db.inc.php"; ?>
<?php include "../includes/header.php"; ?>

<h2>Manage Incidents</h2>
<div class="card mt-4">
    <div class="card-body">
        <h5 class="card-title">File Incident</h5>
        
        
            <form id="incident-form" action="../actions/add_incident.php" method="POST">
                <div class="mb-3">
                    <label for="statement" class="form-label">Statement</label>
                    <textarea class="form-control" name="Incident_Report" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="offense" class="form-label">Offense</label>
                    <select class="form-select searchable-select" name="Offense">
                    <?php
                    $result = $conn->query("SELECT `Offence_ID`, `Offence_description`, `Offence_maxFine`, `Offence_maxPoints` FROM `offence`");

                    // Check for errors in the query
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Escape output to prevent XSS attacks
                            $offenceId = htmlspecialchars($row['Offence_ID']);
                            $offenceDescription = htmlspecialchars($row['Offence_description']);
                            $Offence_maxFine = htmlspecialchars($row['Offence_maxFine']);
                            $Offence_maxPoints = htmlspecialchars($row['Offence_maxPoints']);

                             $offenceData = 
                             array( "Offence_ID" => $offenceId, 
                             "Offence_maxPoints" => $Offence_maxPoints, 
                             "Offence_maxPoints" => $Offence_maxPoints ); 

                             $jsonData = json_encode($offenceData); 
                            
                            echo "<option value='{$jsonData}'>{$offenceDescription} / Fine: {$offenceMaxFine}</option>";
                        }
                    } else {
                        echo "<option value=''>No offences available</option>";
                    }
                ?>

                    </select>
                </div>
                <div class="mb-3">
                    <div class="mb-3">
                        <label for="make" class="form-label">Vehicle Make</label>
                        <select class="form-select" id="make" name="make" required>
                            <option value="">Select Make</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="model" class="form-label">Vehicle Model</label>
                        <select class="form-select" id="model" name="model" disabled required>
                            <option value="">Select Model</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="colour" class="form-label">Vehicle Colour</label>
                        <select class="form-select" id="colour" name="colour" disabled required>
                            <option value="">Select Colour</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="plate" class="form-label">Vehicle Plate</label>
                        <select class="form-select" id="plate" name="plate" disabled required>
                            <option value="">Select Plate</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="person" class="form-label">Person Involved</label>
                    <select class="form-select searchable-select" name="person">
                        <?php
                        $result = $conn->query("SELECT People_ID,People_name  FROM people");
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['People_ID']}'>{$row['People_name']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="person" class="form-label">Incident_Date</label>
                    <input type="date" name="Incident_Date"   class="form-select">
                </div>
                <button type="submit" class="btn btn-primary">File Incident</button>
            </form>
            <div id="response-message" class="mt-3"></div>
            <table id="incidentTable" class="table table-bordered table-striped">
                <thead >
                    <tr>
                        <th>Statement</th>
                        <th>Vehicle</th>
                        <th>Model</th>
                        <th>Colour</th>
                        <th>Reg. no.</th>
                        <th>People name</th>
                        <th>Offence Description</th>
                        <th>Fine</th>
                        <th>Maxpoint</th>
                        <th>Incident Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Add table rows with corresponding data here -->
                </tbody>
            </table>

            <script>
            $(document).ready(function () {
                // Load Vehicle Makes on page load
                $.ajax({
                    url: '../actions/get_vehicles.php',
                    type: 'POST',
                    data: { action: 'getMakes' },
                    success: function (response) {
                        $('#make').html('<option value="">Select Make</option>' + response);
                    }
                });

                // Load Models based on Make selection
                $('#make').change(function () {
                    const make = $(this).val();
                    
                    if (make) {
                        $.ajax({
                            url: '../actions/get_vehicles.php',
                            type: 'POST',
                            data: { action: 'getMakes', make: make },
                            success: function (response) {
                                $('#model').html('<option value="">Select Model</option>' + response).prop('disabled', false);
                            }
                        });
                    } else {
                        $('#model, #colour, #plate').html('<option value="">Select Option</option>').prop('disabled', true);
                    }
                });

                // Load Colours based on Model selection
                $('#model').change(function () {
                    const model = $(this).val();
                    var make =$("#model").val();
                    if (model) {
                        $.ajax({
                            url: '../actions/get_vehicles.php',
                            type: 'POST',
                            data: { action: 'getColours', model: model ,make: make},
                            success: function (response) {
                                $('#colour').html('<option value="">Select Colour</option>' + response).prop('disabled', false);
                            }
                        });
                    } else {
                        $('#colour, #plate').html('<option value="">Select Option</option>').prop('disabled', true);
                    }
                });

                // Load Plates based on Colour selection
                $('#colour').change(function () {
                    const colour = $(this).val();
                    var make =$("#make").val();
                    var model =$("#model").val();
                    if (colour) {
                        $.ajax({
                            url: '../actions/get_vehicles.php',
                            type: 'POST',
                            data: { action: 'getPlates', colour: colour,make:make,model:model },
                            success: function (response) {
                                $('#plate').html('<option value="">Select Plate</option>' + response).prop('disabled', false);
                            }
                        });
                    } else {
                        $('#plate').html('<option value="">Select Option</option>').prop('disabled', true);
                    }
                });
            });
            </script>
            <script>
                $(document).ready(function () {
                    $('#incident-form').on('submit', function (e) {
                        e.preventDefault(); // Prevent the default form submission
                        
                        // Serialize form data
                        const formData = $(this).serialize();

                        // Perform the AJAX request
                        $.ajax({
                            url: '../actions/add_incident.php',
                            type: 'POST',
                            data: formData,
                            success: function (response) {
                                
                                // Assuming response is in JSON format
                                try {
                                    const res = JSON.parse(response);
                                    console.log(response);
                                    // Check for success or error
                                    if (res.status === 'success') {
                                        $('#response-message')
                                            .html('<div class="alert alert-success">' + res.message + '</div>')
                                            .fadeIn()
                                            .delay(3000)
                                            .fadeOut();
                                        $('#incident-form')[0].reset(); // Reset the form
                                    } else {
                                        $('#response-message')
                                            .html('<div class="alert alert-danger">' + res.message + '</div>')
                                            .fadeIn()
                                            .delay(3000)
                                            .fadeOut();
                                    }
                                } catch (error) {
                                    $('#response-message')
                                        .html('<div class="alert alert-danger">Unexpected error occurred.</div>')
                                        .fadeIn()
                                        .delay(3000)
                                        .fadeOut();
                                }
                            },
                            error: function (xhr, status, error) {
                                // Handle AJAX errors
                                $('#response-message')
                                    .html('<div class="alert alert-danger">An error occurred: ' + error + '</div>')
                                    .fadeIn()
                                    .delay(3000)
                                    .fadeOut();
                            }
                        });
                    });
                });

            </script>
            <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <script>
            loadincidents();
            
                
                function loadincidents() {
                    let incidentTable = $('#incidentTable').DataTable(); 
                    incidentTable.clear();
                    $.ajax({
                        url: '../actions/get_incidents.php', // Endpoint to fetch all vehicles
                        type: 'POST',
                        data: {type:'datatable' },
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                response.data.forEach(incident => {
                                    incidentTable.row.add([
                                        incident.Incident_Report,
                                        incident.Vehicle_make,
                                        incident.Vehicle_model,
                                        incident.Vehicle_colour,
                                        incident.Vehicle_plate,
                                        incident.People_name,
                                        incident.Offence_description,
                                        incident.Offence_maxFine,
                                        incident.Offence_maxPoints,
                                        incident.Incident_Date,
                                        `<button class="btn btn-primary btn-sm" onclick="editIncident(${incident.Incident_ID})">Edit</button>
                                         <button class="btn btn-danger btn-sm" onclick="deleteIncident(${incident.Incident_ID})">Delete</button>`
                                    ]).draw();
                                });
                            } else {
                                alert('No vehicles found: ' + response.message);
                            }
                        },
                        error: function () {
                            alert('An error occurred while loading vehicles.');
                        }
                    });
                }
            </script>


    </div>
</div>
<?php include "../includes/footer.php"; ?>
