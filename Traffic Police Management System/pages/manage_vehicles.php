<?php include "../includes/auth.inc.php"; ?>
<?php include "../includes/header.php"; ?>

<h2>Manage Vehicles</h2>
<div class="card mt-4">
    <div class="card-body">
        <h5 class="card-title">Add  </h5>
        <form id="vehicleForm">
            <div class="mb-3">
                <label for="registration" class="form-label">Vehicle Plate</label>
                <input type="text" class="form-control" name="Vehicle_plate" required>
            </div>
            <div class="mb-3">
                <label for="make" class="form-label">Vehicle Colour</label>
                <input type="text" class="form-control" name="Vehicle_colour" required>
            </div>
            <div class="mb-3">
                <label for="model" class="form-label">Model</label>
                <input type="text" class="form-control" name="Vehicle_model" required>
            </div>
            <div class="mb-3">
                <label for="model" class="form-label">Vehicle Name</label>
                <input type="text" class="form-control" name="Vehicle_make" required>
            </div>
            <button type="submit" class="btn btn-primary mb-3">Add Vehicle</button>
        </form>

        <!-- Table for Vehicle Details -->
        <table id="vehicleTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Plate</th>
                    <th>Colour</th>
                    <th>Model</th>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody>
                <!-- Vehicle details will be dynamically added here -->
            </tbody>
        </table>
        <!-- Include jQuery and DataTables -->
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <script>
            $(document).ready(function () {
    // Initialize DataTable for Vehicles
    let vehicleTable = $('#vehicleTable').DataTable();

    // Function to load all vehicle data
        function loadVehicles() {
            vehicleTable.clear();
            $.ajax({
                url: '../actions/get_vehicles.php', // Endpoint to fetch all vehicles
                type: 'POST',
                data: { action: 'null',type:'datatable' },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        response.data.forEach(vehicle => {
                            vehicleTable.row.add([
                                vehicle.Vehicle_ID,
                                vehicle.Vehicle_plate,
                                vehicle.Vehicle_colour,
                                vehicle.Vehicle_model,
                                vehicle.Vehicle_make
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

    // Load all vehicles on page load
    loadVehicles();

                // Add Vehicle Form Submission
                $('#vehicleForm').submit(function (event) {
                    event.preventDefault(); // Prevent default form submission

                    // Get form data
                    const formData = $(this).serialize();

                    // Submit data using AJAX
                    $.ajax({
                        url: '../actions/add_vehicle.php', // Endpoint to add a vehicle
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                alert('Vehicle added successfully!');
                                loadVehicles(); // Refresh the vehicle list
                                $('#vehicleForm')[0].reset(); // Reset the form
                            } else {
                                alert('Error: ' + response.message);
                            }
                        },
                        error: function () {
                            alert('An error occurred while adding the vehicle.');
                        }
                    });
                });
            });

        </script>
    </div>
</div>
<?php include "../includes/footer.php"; ?>
