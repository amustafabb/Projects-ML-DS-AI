<?php include "../includes/auth.inc.php"; ?>
<?php include "../includes/header.php"; ?>

<h2>Manage People</h2>
<div class="card mt-4">
    <div class="card-body">
        <h5 class="card-title">Add Person</h5>
        <form id="addPersonForm">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <div class="mb-3">
                <label for="license_number" class="form-label">License Number</label>
                <input type="text" class="form-control" id="license_number" name="license_number" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Person</button>
        </form>

<!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#addPersonForm').submit(function (event) {
                event.preventDefault(); // Prevent default form submission

                // Serialize form data
                const formData = $(this).serialize();

                // Send AJAX POST request
                $.ajax({
                    url: '../actions/add_person.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            alert('Person added successfully!');
                            $('#addPersonForm')[0].reset();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function () {
                        alert('An error occurred. Please try again.');
                    }
                });
            });
        });
    </script>

    </div>
</div>
<div class="mt-4">
    <h4>Search People</h4>
    

<!-- Table to display results -->
<table id="resultsTable" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>License Number</th>
        </tr>
    </thead>
    <tbody>
        <!-- Data will be dynamically added here -->
    </tbody>
</table>

<!-- Include jQuery and DataTables -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script>
    $(document).ready(function () {
    // Initialize DataTable
    let table = $('#resultsTable').DataTable();

    // Function to load data
    function loadData(query = '') {
        // Clear existing DataTable data
        table.clear();

        // Fetch data using AJAX
        $.ajax({
            url: '../actions/search_person.php',
            type: 'GET',
            data: { query: query },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    // Add rows to the DataTable
                    response.data.forEach(person => {
                        table.row.add([
                            person.People_ID,
                            person.People_name,
                            person.People_address,
                            person.People_licence
                        ]).draw();
                    });
                } else {
                    alert('No data found: ' + response.message);
                }
            },
            error: function () {
                alert('An error occurred while loading data.');
            }
        });
    }

    // Load all data by default
    loadData();

    // Search form submission
    $('#searchForm').submit(function (event) {
        event.preventDefault(); // Prevent default form submission

        // Get search query
        const query = $('#searchQuery').val();

        // Load data based on the query
        loadData(query);
    });
});

</script>
</div>
<?php include "../includes/footer.php"; ?>
