<?php

session_start();

if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}

include('db_config.php');

$feedback_text = "";
$rating = 5; 
$error = "";
$success_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $feedback_text = $_POST['feedback_text'];
    $rating = $_POST['rating'];

    if (empty($feedback_text)) {
        $error = "Feedback text is required.";
    } else {
        // Insert the feedback into the database
        $patient_id = $_SESSION['patient_id'];
        $insert_sql = "INSERT INTO feedback (patient_id, feedback_text, rating) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("isi", $patient_id, $feedback_text, $rating);

        if ($stmt->execute()) {

            $success_message = "Your feedback has been successfully submitted!";
            $feedback_text = "";
        } else {
            $error = "Error submitting feedback. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Feedback - Care Compass Hospitals</title>
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

    <!-- Feedback Form -->
    <div class="container my-5">
        <h2 class="text-center">Submit Your Feedback</h2>

        <?php if ($success_message != ""): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <?php if ($error != ""): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="feedback.php">
            <div class="mb-3">
                <label for="feedback_text" class="form-label">Your Feedback</label>
                <textarea class="form-control" id="feedback_text" name="feedback_text" rows="4" required><?php echo htmlspecialchars($feedback_text); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="rating" class="form-label">Rating (1-5)</label>
                <select class="form-select" id="rating" name="rating" required>
                    <option value="1" <?php if ($rating == 1) echo "selected"; ?>>1</option>
                    <option value="2" <?php if ($rating == 2) echo "selected"; ?>>2</option>
                    <option value="3" <?php if ($rating == 3) echo "selected"; ?>>3</option>
                    <option value="4" <?php if ($rating == 4) echo "selected"; ?>>4</option>
                    <option value="5" <?php if ($rating == 5) echo "selected"; ?>>5</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Submit Feedback</button>
        </form>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4">
        <p>&copy; 2025 Care Compass Hospitals. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
