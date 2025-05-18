<?php include "../includes/auth.inc.php"; ?>
<?php include "../includes/header.php"; ?>
<?php include "../includes/db.inc.php"; ?>

<h2>Manage Users</h2>
<div class="card mt-4">
    <div class="card-body">
        <h5 class="card-title">Add New User</h5>
        <form id="addUserForm" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" id="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select name="role" id="role" class="form-control">
                    <option value="">Please Select</option>
                    <option value="admin">Admin</option>
                    <option value="user">USER</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add User</button>
        </form>
    </div>
</div>

<div class="mt-4">
    <h4>Existing Users</h4>
    <table class="table" id="usersTable">
        <thead>
            <tr>
                <th>Username</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be dynamically loaded here -->
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    // Function to load users
    function loadUsers() {
        $.ajax({
            url: '../actions/manage_user.php',
            method: 'GET',
            success: function (response) {
                $('#usersTable tbody').html(response);
            }
        });
    }

    // Load users initially
    loadUsers();

    // Handle form submission for adding a user
    $('#addUserForm').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: '../actions/manage_user.php',
            method: 'POST',
            data: $(this).serialize() + '&action=add',
            success: function (response) {
                alert(response);
                $('#addUserForm')[0].reset();
                loadUsers();
            }
        });
    });

    // Handle user deletion
    $(document).on('click', '.delete-user', function () {
        const userId = $(this).data('id');
        if (confirm('Are you sure you want to delete this user?')) {
            $.ajax({
                url: '../actions/manage_user.php',
                method: 'POST',
                data: { id: userId ,action:'delete'},
                success: function (response) {
                    alert(response);
                    loadUsers();
                }
            });
        }
    });

    // Handle user edit
    $(document).on('click', '.edit-user', function () {
        const userId = $(this).data('id');
        const username = $(this).data('username');
        const role = $(this).data('role');

        const newUsername = prompt('Edit Username:', username);
        const newRole = prompt('Edit Role:', role);

        if (newUsername && newRole) {
            $.ajax({
                url: '../actions/edit_user.php',
                method: 'POST',
                data: { id: userId, username: newUsername, role: newRole },
                success: function (response) {
                    alert(response);
                    loadUsers();
                }
            });
        }
    });
});
</script>

<?php include "../includes/footer.php"; ?>
