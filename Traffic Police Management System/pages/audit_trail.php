<?php include "../includes/auth.inc.php"; ?>
<?php include "../includes/header.php"; ?>

<h2>Audit Trail</h2>
<table class="table">
    <thead>
        <tr>
            <th>User</th>
            <th>Action</th>
            <th>Timestamp</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = $conn->query("SELECT * FROM audit_logs");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['user']}</td>
                <td>{$row['action']}</td>
                <td>{$row['timestamp']}</td>
            </tr>";
        }
        ?>
    </tbody>
</table>
<?php include "../includes/footer.php"; ?>
