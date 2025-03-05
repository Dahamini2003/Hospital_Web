<?php

session_start();


if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}

include('db_config.php');

$appointment_date = "";
$reason = "";
$doctor_id = "";
$error = "";
$success_message = "";

// Fetch the available doctors from the database
$doctor_sql = "SELECT doctor_id, name, specialty FROM doctors";
$doctor_result = $conn->query($doctor_sql);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $appointment_date = $_POST['appointment_date'];
    $reason = $_POST['reason'];
    $doctor_id = $_POST['doctor_id'];

    if (empty($appointment_date) || empty($reason) || empty($doctor_id)) {
        $error = "All fields are required.";
    } else {
        // Insert the appointment into the database
        $patient_id = $_SESSION['patient_id'];
        $insert_sql = "INSERT INTO appointments (patient_id, appointment_date, reason, doctor_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("isss", $patient_id, $appointment_date, $reason, $doctor_id);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Your appointment has been successfully added!";
            header("Location: add_appointment.php"); 
            exit();
        } else {
            $error = "Error adding appointment. Please try again.";
        }
    }
}


if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Appointment - Care Compass Hospitals</title>
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

    <!-- Add Appointment Form -->
    <div class="container my-5">
        <h2 class="text-center">Request an Appointment</h2>
        
        <?php if ($success_message != ""): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="add_appointment.php">
            <div class="mb-3">
                <label for="appointment_date" class="form-label">Appointment Date and Time</label>
                <input type="datetime-local" class="form-control" id="appointment_date" name="appointment_date" value="<?php echo htmlspecialchars($appointment_date); ?>" required>
            </div>
            <div class="mb-3">
                <label for="reason" class="form-label">Reason for Appointment</label>
                <textarea class="form-control" id="reason" name="reason" rows="3" required><?php echo htmlspecialchars($reason); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="doctor" class="form-label">Select Doctor</label>
                <select class="form-control" id="doctor" name="doctor_id" required>
                    <option value="">Choose a doctor</option>
                    <?php

                    if ($doctor_result->num_rows > 0) {
                        while ($doctor = $doctor_result->fetch_assoc()) {
                            echo "<option value='" . $doctor['doctor_id'] . "'>" . $doctor['name'] . " - " . $doctor['specialty'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>


            <?php if ($error != ""): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary">Submit Appointment Request</button>
        </form>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4">
        <p>&copy; 2025 Care Compass Hospitals. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
