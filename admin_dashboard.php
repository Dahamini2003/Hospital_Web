<?php
include('db_config.php');
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Delete user
if (isset($_GET['delete_user'])) {
    $user_id = $_GET['delete_user'];

    $sql = "DELETE FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        $success_message = "User deleted successfully!";
    } else {
        $error = "Error deleting user.";
    }
}

// Delete appointment
if (isset($_GET['delete_appointment'])) {
    $appointment_id = $_GET['delete_appointment'];

    $sql = "DELETE FROM appointments WHERE appointment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $appointment_id);

    if ($stmt->execute()) {
        $success_message = "Appointment deleted successfully!";
    } else {
        $error = "Error deleting appointment.";
    }
}

// Fetch users
$sql = "SELECT * FROM users";
$users_result = $conn->query($sql);

// Fetch doctors
$sql = "SELECT * FROM doctors";
$doctors_result = $conn->query($sql);

// Fetch appointments
$sql = "SELECT * FROM appointments";
$appointments_result = $conn->query($sql);

if ($appointments_result === false) {
    die("Error: Could not execute the query. " . $conn->error);
}

// Update appointment status
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $appointment_id = $_POST['appointment_id'];
    $status = $_POST['status'];

    $sql = "UPDATE appointments SET status = ? WHERE appointment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $appointment_id);

    if ($stmt->execute()) {
        $success_message = "Appointment status updated successfully!";
    } else {
        $error = "Error updating appointment status.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Care Compass Hospitals</title>
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
                    <a href="add_users.php" class="btn btn-primary me-2">Add User</a>
                </li>
                <li>
                <a href="add_doctor.php" class="btn btn-success me-3">Add Doctor</a>
                </li>
                <li>
                <a href="index.php" class="btn btn-danger">Logout</a>
                </li>
                
               
            </ul>
        </div>
    </div>
</nav>

    <div class="container my-5">
        <h2 class="text-center">Admin Dashboard</h2>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <h3 class="my-4">Existing Users</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $users_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['user_id']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['role']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td>
                            <a href="admin_dashboard.php?delete_user=<?php echo $row['user_id']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Appointments Table -->
        <h3 class="my-4">Appointments</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Appointment ID</th>
                    <th>Patient ID</th>
                    <th>Appointment Date</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Doctor ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($appointments_result->num_rows > 0): ?>
                    <?php while ($appointment = $appointments_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $appointment['appointment_id']; ?></td>
                            <td><?php echo $appointment['patient_id']; ?></td>
                            <td><?php echo $appointment['appointment_date']; ?></td>
                            <td><?php echo $appointment['reason']; ?></td>
                            <td><?php echo $appointment['status']; ?></td>
                            <td><?php echo $appointment['doctor_id']; ?></td>
                            <td>
                                <a href="admin_dashboard.php?delete_appointment=<?php echo $appointment['appointment_id']; ?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No appointments available.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Update Appointment Status -->
        <h3 class="my-4">Update Appointment Status</h3>
        <form method="POST" action="admin_dashboard.php">
            <div class="mb-3">
                <label for="appointment_id" class="form-label">Appointment ID</label>
                <select class="form-select" name="appointment_id" required>
                    <option value="">Select Appointment</option>
                    <?php 

                    $appointments_result = $conn->query("SELECT * FROM appointments");
                    while ($appointment = $appointments_result->fetch_assoc()): ?>
                        <option value="<?php echo $appointment['appointment_id']; ?>">
                            Appointment ID: <?php echo $appointment['appointment_id']; ?> - Patient ID: <?php echo $appointment['patient_id']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" name="status" required>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="completed">Completed</option>
                </select>
            </div>

            <button type="submit" name="update_status" class="btn btn-primary">Update Status</button>
        </form>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4">
        <p>&copy; 2025 Care Compass Hospitals. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
