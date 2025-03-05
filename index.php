<?php
session_start();

include('db_config.php');

$feedback = [];
$sql = "SELECT feedback.feedback_id, feedback.feedback_text, feedback.rating, feedback.submitted_at, patient.name AS patient_name
        FROM feedback
        JOIN patient ON feedback.patient_id = patient.patient_id
        ORDER BY feedback.submitted_at DESC LIMIT 5"; 
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $feedback[] = $row;
    }
} else {
    $feedback_message = "No feedback available.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Care Compass Hospitals</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles.css?<?php echo time(); ?>" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
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
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#facilities-section">Facilities</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#services-section">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-lg highlight-btn" href="Login.php">Book Appointments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact-section">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary nav-link login-btn" href="Login.php" role="button">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<header class="hero text-white text-center py-5" style="background-image: url('images/hero.png'); background-size: cover; background-position: center;">
    <div class="overlay"></div>
    <div class="container">
        <h1>Welcome to Care Compass Hospitals</h1>
        <p>Your health is our top priority</p>
    </div>
</header>

<!-- Hospital Facilities Section -->
<section id="facilities-section" class="container my-5">
    <h2 class="text-center mb-4">Our Facilities</h2>
    <p class="text-center mb-5">We have state-of-the-art facilities in three major cities: Kandy, Colombo, and Kurunegala.</p>
    <div class="row">
        <div class="col-md-4">
            <div class="card facility-card">
                <img src="images/kandy1.jpg" class="card-img-top" alt="Facility 1">
                <div class="card-body">
                    <h5 class="card-title">Kandy Branch</h5>
                    <p class="card-text">Advanced healthcare services in Kandy.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card facility-card">
                <img src="images/colombo.jpg" class="card-img-top" alt="Facility 2">
                <div class="card-body">
                    <h5 class="card-title">Colombo Branch</h5>
                    <p class="card-text">Top-tier medical treatments in Colombo.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card facility-card">
                <img src="images/kurunagala.jpg" class="card-img-top" alt="Facility 3">
                <div class="card-body">
                    <h5 class="card-title">Kurunegala Branch</h5>
                    <p class="card-text">Comprehensive care at Kurunegala.</p>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Welcome Section -->
<section id="welcome-section" class="container text-center my-5">
    <h2 class="mb-4">Welcome to Care Compass Hospitals</h2>
    <div class="row align-items-center">
        <div class="col-md-6">
            <img src="images/welcome.jpg" alt="Hospital Interior" class="img-fluid rounded">
        </div>
        <div class="col-md-6">
            <p class="welcome-text">
                At <strong>Care Compass Hospitals</strong>, we are committed to delivering world-class healthcare with a 
                compassionate touch. With state-of-the-art facilities, experienced medical professionals, and patient-centered 
                services, we aim to ensure the best medical care for you and your loved ones.
            </p>
            <p>
                Our mission is to provide high-quality, affordable healthcare to the communities we serve. Whether it’s 
                routine check-ups, emergency care, or specialized treatments, our team is here for you every step of the way.
            </p>
            <a href="#services-section" class="btn btn-primary btn-lg mt-3">Explore Our Services</a>
        </div>
    </div>
</section>


<!-- Hospital Services Section -->
<section id="services-section" class="container my-5">
    <h2 class="text-center mb-4">Our Services</h2>
    <p class="text-center mb-5">We offer a wide range of services to meet your healthcare needs.</p>
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card service-card text-center">
                <div class="card-body">
                    <img src="images/emergency.jpg" alt="Emergency Care Icon" class="service-icon mb-3">
                    <h5 class="card-title">Emergency Care</h5>
                    <p class="card-text">Quick and effective care for emergency situations.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card service-card text-center">
                <div class="card-body">
                    <img src="images/mother-and-kids.jpg" alt="Maternity Care Icon" class="service-icon mb-3">
                    <h5 class="card-title">Maternity Care</h5>
                    <p class="card-text">Comprehensive services for mother and child care.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card service-card text-center">
                <div class="card-body">
                    <img src="images/surgical.jpg" alt="Surgical Services Icon" class="service-icon mb-3">
                    <h5 class="card-title">Surgical Services</h5>
                    <p class="card-text">Advanced surgical procedures for various conditions.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card service-card text-center">
                <div class="card-body">
                    <img src="images/mental-health.jpg" alt="Mental Health Services Icon" class="service-icon mb-3">
                    <h5 class="card-title">Mental Health</h5>
                    <p class="card-text">Providing mental health support and therapies.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- View Feedback Section -->
<section class="container my-5">
    <h2 class="text-center mb-4">What Participants Are Saying</h2>
    <p class="text-center mb-5">Providing Exceptional Care to Thousands of Patients</p>
    <?php if (isset($feedback_message)): ?>
        <div class="alert alert-info" role="alert">
            <?php echo $feedback_message; ?>
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($feedback as $fb): ?>
                <div class="col-md-4 mb-4">
                    <div class="card feedback-card text-center">
                        <div class="card-body">
                            <img src="images/user.png" alt="Profile Picture" class="feedback-profile-img mb-3">
                            
                            <div class="d-flex justify-content-center mb-3">
                                <?php for ($i = 0; $i < $fb['rating']; $i++): ?>
                                    <span class="text-warning">&#9733;</span>
                                <?php endfor; ?>
                            </div>
                            
                            <h5 class="card-title"><?php echo htmlspecialchars($fb['patient_name']); ?></h5>
                            
                            <p class="card-text"><?php echo htmlspecialchars($fb['feedback_text']); ?></p>
                            
                            <small class="text-muted"><?php echo date("F j, Y, g:i a", strtotime($fb['submitted_at'])); ?></small>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>


<!-- Contact Section -->
<section id="contact-section" class="container my-5 py-5">
    <h2 class="text-center mb-4">Contact Us</h2>
    <p class="text-center mb-5">Have questions or need assistance? Get in touch with us!</p>
    <div class="row">
        <div class="col-md-6">
            <form action="submit_contact.php" method="POST">
                <div class="mb-4">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control form-control-lg" id="name" name="name" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control form-control-lg" id="email" name="email" required>
                </div>
                <div class="mb-4">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="tel" class="form-control form-control-lg" id="phone" name="phone" required>
                </div>
                <div class="mb-4">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control form-control-lg" id="message" name="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100">Submit</button>
            </form>
        </div>
        <div class="col-md-6">
            <h4 class="mb-4">Visit Us</h4>
            <p>Care Compass Hospitals</p>
            <p>123 Main Street, Colombo, Sri Lanka</p>
            <p>Email: <a href="mailto:contact@carecompass.lk">contact@carecompass.lk</a></p>
            <p>Phone: <a href="tel:+94123456789">+94 123 456 789</a></p>
            
        </div>
    </div>
</section>





<!-- Footer Section -->
<footer class="footer bg-dark text-white pt-5 pb-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="footer-logo">Care Compass Hospitals</h5>
                <p>Delivering quality healthcare with compassion and excellence. Your health is our top priority.</p>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="footer-title">Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#facilities-section">Facilities</a></li>
                    <li><a href="#services-section">Services</a></li>
                    <li><a href="#contact-section">Contact</a></li>
                    <li><a href="Login.php">Book Appointment</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="footer-title">Contact Us</h5>
                <ul class="list-unstyled">
                    <li><i class="fas fa-map-marker-alt"></i> 123 Main Street, Colombo, Sri Lanka</li>
                    <li><i class="fas fa-envelope"></i> <a href="mailto:contact@carecompass.lk">contact@carecompass.lk</a></li>
                    <li><i class="fas fa-phone"></i> <a href="tel:+94123456789">+94 123 456 789</a></li>
                </ul>
            </div>

            <!-- Newsletter & Social Links -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="footer-title">Stay Connected</h5>
                <form action="subscribe.php" method="POST" class="d-flex">
                    <input type="email" name="email" class="form-control me-2" placeholder="Enter your email" required>
                    <button type="submit" class="btn btn-primary">Subscribe</button>
                </form>
                <div class="social-icons mt-3">
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="text-center mt-4">
            <p>&copy; <?php echo date("Y"); ?> Care Compass Hospitals. All rights reserved.</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
