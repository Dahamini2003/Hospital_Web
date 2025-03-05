<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'staff') {
    header("Location: login.php");
    exit();
}

include('db_config.php');

$success_message = "";
$error_message = "";

// Update payment status
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $payment_id = $_POST['payment_id'];
    $status = $_POST['status'];

    $sql = "UPDATE payment SET status = ? WHERE payment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $payment_id);

    if ($stmt->execute()) {
        $success_message = "Payment status updated successfully!";
    } else {
        $error_message = "Error updating payment status.";
    }
}

// Fetch all payments
$sql = "SELECT * FROM payment ORDER BY payment_date DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Payments - Care Compass Hospitals</title>
    <link rel="stylesheet" type="text/css" href="styles.css?<?php echo time(); ?>" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light position-sticky top-0">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Care Compass Hospitals</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="staff_dashboard.php"><< Back To Staff Dashboard</a>
                </li>
                
            </ul>
        </div>
    </div>
</nav>

    <!-- Manage Payments Section -->
    <div class="container mt-5 pt-5">
        <h2 class="text-center">Manage Payments</h2>

        <?php if ($success_message): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Payments Table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Payment ID</th>
                    <th>Patient ID</th>
                    <th>Amount</th>
                    <th>Payment Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($payment = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($payment['payment_id']); ?></td>
                            <td><?php echo htmlspecialchars($payment['patient_id']); ?></td>
                            <td><?php echo htmlspecialchars($payment['amount']); ?></td>
                            <td><?php echo htmlspecialchars($payment['payment_date']); ?></td>
                            <td><?php echo htmlspecialchars($payment['status']); ?></td>
                            <td>
                                <!-- Form to update the status -->
                                <form method="POST" action="manage_payments.php" style="display:inline;">
                                    <input type="hidden" name="payment_id" value="<?php echo $payment['payment_id']; ?>">
                                    <select name="status" class="form-select" required>
                                        <option value="pending" <?php echo ($payment['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                        <option value="completed" <?php echo ($payment['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                                        <option value="failed" <?php echo ($payment['status'] == 'failed') ? 'selected' : ''; ?>>Failed</option>
                                    </select>
                                    <button type="submit" name="update_status" class="btn btn-primary btn-sm mt-2">Update</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No payments found.</td>
                    </tr>
                <?php endif; ?>
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
