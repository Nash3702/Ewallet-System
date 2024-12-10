<?php
session_start();
include('../includes/session.php');
include('../includes/db.php');

if ($_SESSION['role'] != 'admin') {
    header("Location: ../error.php");
    exit();
}

$result = $conn->query("SELECT * FROM staff");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Staff</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="manage_staff.css">
</head>
<body>
    <div class="manage-staff">
        <div class="header">
            <h1>Manage Staff</h1>
            <p>View, update, or remove staff members.</p>
            <a href="dashboard.php" class="btn btn-back">Back to Dashboard</a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Balance</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($staff = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= htmlspecialchars($staff['staff_id']) ?></td>
                            <td><?= htmlspecialchars($staff['name']) ?></td>
                            <td><?= htmlspecialchars($staff['email']) ?></td>
                            <td>RM <?= number_format($staff['balance'], 2) ?></td>
                            <td>
                                <button class="btn btn-edit" onclick="showEditModal(<?= htmlspecialchars(json_encode($staff)) ?>)">Edit</button>
                                <button class="btn btn-delete" onclick="confirmDelete(<?= htmlspecialchars($staff['staff_id']) ?>, '<?= htmlspecialchars($staff['name']) ?>')">Delete</button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Staff Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="hideModal('addModal')">&times;</span>
            <h2>Add New Staff</h2>
            <form action="add_staff.php" method="POST">
                <label for="name">Name:</label>
                <input type="text" name="name" required>
                <label for="email">Email:</label>
                <input type="email" name="email" required>
                <label for="balance">Initial Balance:</label>
                <input type="number" name="balance" min="0" required>
                <button type="submit" class="btn">Add Staff</button>
            </form>
        </div>
    </div>

<!-- Edit Staff Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="hideModal('editModal')">&times;</span>
        <h2>Edit Staff</h2>
        <form id="editForm" action="update_staff.php" method="POST">
            <input type="hidden" name="staff_id">
            <label for="name">Name:</label>
            <input type="text" name="name" required>
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            <label for="balance">Balance:</label>
            <input type="number" name="balance" min="0" required>
            <button type="submit" class="btn">Update Staff</button>
        </form>
    </div>
</div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="hideModal('deleteModal')">&times;</span>
            <h2>Confirm Deletion</h2>
            <p id="deleteMessage"></p>
            <form id="deleteForm" action="delete_staff.php" method="POST">
                <input type="hidden" name="staff_id">
                <button type="submit" class="btn btn-delete">Confirm</button>
                <button type="button" class="btn btn-cancel" onclick="hideModal('deleteModal')">Cancel</button>
            </form>
        </div>
    </div>

    <script src="manage_staff.js"></script>
</body>
</html>