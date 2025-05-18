<?php include "../includes/auth.inc.php"; ?>
<?php include "../includes/header.php"; ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <?php //print_r($_SESSION); ?>
            <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
            <p class="lead">This is your dashboard for managing police records.</p>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>

    <div class="row mt-5">
        
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Manage People</h5>
                    <p class="card-text">Add or view details of individuals.</p>
                    <a href="manage_people.php" class="btn btn-light">Go to People</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Manage Vehicles</h5>
                    <p class="card-text">Add or view vehicle details.</p>
                    <a href="manage_vehicles.php" class="btn btn-light">Go to Vehicles</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Manage Incidents</h5>
                    <p class="card-text">File or view incident reports.</p>
                    <a href="manage_incidents.php" class="btn btn-light">Go to Incidents</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-3">
            <div class="card text-white bg-secondary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Audit Trail</h5>
                    <p class="card-text">View logs of system activities.</p>
                    <a href="audit_trail.php" class="btn btn-light">Go to Audit</a>
                </div>
            </div>
        </div>
        <?php 
        if($_SESSION["role"]=="admin"){
        
        ?>
        <div class="col-md-3">
            <div class="card text-white  mb-3" style="background-color: #062a51;">
                <div class="card-body">
                    <h5 class="card-title">Users</h5>
                    <p class="card-text">View Users.</p>
                    <a href="manage_users.php" class="btn btn-light">Manage User</a>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    
</div>
<?php include "../includes/footer.php"; ?>
