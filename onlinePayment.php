<?php
session_start();

if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}

include('db_config.php');

$amount = "";
$status = "pending"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['make_payment'])) {
    $amount = $_POST['amount'];
    $patient_id = $_SESSION['patient_id']; 
    $payment_date = date("Y-m-d H:i:s"); 

    // Insert payment into the database
    $sql = "INSERT INTO payment (patient_id, amount, payment_date, status) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("idss", $patient_id, $amount, $payment_date, $status);

    if ($stmt->execute()) {
        $success_message = "Payment request submitted successfully!";
    } else {
        $error_message = "Error submitting payment request.";
    }
}

// Fetch the patient's recent payments
$patient_id = $_SESSION['patient_id'];
$payment_sql = "SELECT * FROM payment WHERE patient_id = ? ORDER BY payment_date DESC LIMIT 5"; 
$payment_stmt = $conn->prepare($payment_sql);
$payment_stmt->bind_param("i", $patient_id);
$payment_stmt->execute();
$payment_result = $payment_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Payment - Care Compass Hospitals</title>
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
                    <a class="nav-link active" aria-current="page" href="patient_dashboard.php"><< Back To Patient Dashboard</a>
                </li>
                
            </ul>
        </div>
    </div>
</nav>

    <!-- Payment Section -->
    <div class="container mt-5 pt-5">
        <h2 class="text-center">Make Online Payment</h2>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Payment Form -->
        <form method="POST" action="onlinePayment.php">
            <div class="mb-3">
                <label for="amount" class="form-label">Amount</label>
                <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
            </div>

            <button type="submit" name="make_payment" class="btn btn-primary w-100">Proceed to Payment</button>
        </form>

        <!-- Recent Payments Section -->
        <h3 class="mt-5">Recent Payments</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Payment ID</th>
                    <th>Amount</th>
                    <th>Payment Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($payment_result->num_rows > 0): ?>
                    <?php while ($payment = $payment_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($payment['payment_id']); ?></td>
                            <td><?php echo htmlspecialchars($payment['amount']); ?></td>
                            <td><?php echo htmlspecialchars($payment['payment_date']); ?></td>
                            <td><?php echo htmlspecialchars($payment['status']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No recent payments found.</td>
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
