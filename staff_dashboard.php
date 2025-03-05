<?php
include('db_config.php');

session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'staff') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_report'])) {
    $patient_id = $_POST['patient_id'];
    $report_details = $_POST['report_details'];
    $status = $_POST['status'];
    $report_date = date("Y-m-d H:i:s");

    $sql = "INSERT INTO medical_reports (patient_id, report_date, report_details, status) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $patient_id, $report_date, $report_details, $status);

    if ($stmt->execute()) {
        $success_message = "Report added successfully!";
    } else {
        $error = "Error adding report.";
    }
}

// Read reports (Select all reports)
$sql = "SELECT * FROM medical_reports";
$result = $conn->query($sql);

// Update report
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_report'])) {
    $report_id = $_POST['report_id'];
    $report_details = $_POST['report_details'];
    $status = $_POST['status'];

    $sql = "UPDATE medical_reports SET report_details = ?, status = ? WHERE report_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $report_details, $status, $report_id);

    if ($stmt->execute()) {
        $success_message = "Report updated successfully!";
    } else {
        $error = "Error updating report.";
    }
}

// Delete report
if (isset($_GET['delete_report'])) {
    $report_id = $_GET['delete_report'];

    $sql = "DELETE FROM medical_reports WHERE report_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $report_id);

    if ($stmt->execute()) {
        $success_message = "Report deleted successfully!";
    } else {
        $error = "Error deleting report.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard - Care Compass Hospitals</title>
    <link rel="stylesheet" type="text/css" href="styles.css?<?php echo time(); ?>" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
   

    <nav class="navbar navbar-expand-lg navbar-light position-sticky top-0">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Care Compass Hospitals</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">

                <li>
                <a href="manage_payments.php" class="btn btn-success me-3">Manage Payments</a>
                </li>
                <li>
                <a href="index.php" class="btn btn-danger">Logout</a>
                </li>
                
               
            </ul>
        </div>
    </div>
</nav>

    <!-- Dashboard Content -->
    <div class="container my-5">
        <h2 class="text-center">Medical Reports</h2>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Create Report Form -->
        <h3>Create New Report</h3>
        <form method="POST" action="staff_dashboard.php">
            <div class="mb-3">
                <label for="patient_id" class="form-label">Patient ID</label>
                <input type="number" class="form-control" id="patient_id" name="patient_id" required>
            </div>
            <div class="mb-3">
                <label for="report_details" class="form-label">Report Details</label>
                <textarea class="form-control" id="report_details" name="report_details" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="pending">Pending</option>
                    <option value="completed">Completed</option>
                    <option value="in_progress">In Progress</option>
                </select>
            </div>
            <button type="submit" name="create_report" class="btn btn-primary">Submit Report</button>
        </form>

        <!-- Existing Reports Table -->
        <h3 class="my-4">Existing Reports</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Report ID</th>
                    <th>Patient ID</th>
                    <th>Report Date</th>
                    <th>Details</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['report_id']; ?></td>
                        <td><?php echo $row['patient_id']; ?></td>
                        <td><?php echo $row['report_date']; ?></td>
                        <td><?php echo $row['report_details']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td>
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['report_id']; ?>">Edit</button>
                            <a href="staff_dashboard.php?delete_report=<?php echo $row['report_id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this report?');">Delete</a>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal<?php echo $row['report_id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel">Edit Report</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="staff_dashboard.php">
                                        <input type="hidden" name="report_id" value="<?php echo $row['report_id']; ?>">
                                        <div class="mb-3">
                                            <label for="report_details" class="form-label">Report Details</label>
                                            <textarea class="form-control" name="report_details" rows="4" required><?php echo $row['report_details']; ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-control" name="status" required>
                                                <option value="pending" <?php if ($row['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                                                <option value="completed" <?php if ($row['status'] == 'completed') echo 'selected'; ?>>Completed</option>
                                                <option value="in_progress" <?php if ($row['status'] == 'in_progress') echo 'selected'; ?>>In Progress</option>
                                            </select>
                                        </div>
                                        <button type="submit" name="update_report" class="btn btn-primary w-100">Update Report</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4">
        <p>&copy; 2025 Care Compass Hospitals. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
