-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2025 at 05:52 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `care_compass_hospitals`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `appointment_date` datetime DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `status` enum('pending','confirmed','completed') DEFAULT 'pending',
  `doctor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `patient_id`, `appointment_date`, `reason`, `status`, `doctor_id`) VALUES
(18, 1, '2025-02-27 00:03:00', 'General check-up', 'pending', 1),
(19, 2, '2025-02-26 14:04:00', 'Specialist consultation ', 'pending', 6),
(21, 5, '2025-02-06 14:08:00', 'Physiotherapy session', 'pending', 1),
(22, 6, '2025-02-28 15:32:00', 'Vaccination', 'pending', 1),
(24, 4, '2025-03-06 14:20:00', 'Dental Check-up', 'pending', 9);

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `doctor_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `specialty` varchar(255) DEFAULT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`doctor_id`, `name`, `specialty`, `contact_number`, `email`) VALUES
(1, 'Dr.N. Perera', 'General Physicians', '1234567890', 'perera@gmail.com'),
(6, 'Dr. I. Wijemanna', 'cardiologist', '+94778978969', 'Wijemanna@gmail.com'),
(7, 'Dr. Darshan De Silva', 'Dermatology', '+94768978976', 'Darshana@gmail.com'),
(8, 'Dr. Anula Wijesundere', 'Neurologist', '+9478657899', 'Anula@gmail.com'),
(9, 'Dr. Chandana Kanakaratne', 'Dentist', '+94789897678', 'Chandana@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `feedback_text` text DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `patient_id`, `feedback_text`, `rating`, `submitted_at`) VALUES
(6, 1, '\"The medical care was good, but the waiting time was too long. It would be great if the appointment scheduling system could be improved.\"', 3, '2025-02-23 17:43:32'),
(10, 2, 'The care I received was good, but the wait times were longer than expected. I understand that emergencies can affect scheduling, but I would appreciate more timely communication about delays.\"', 3, '2025-02-23 17:45:18'),
(12, 4, '\"My stay at the hospital was smooth and reassuring. The nurses were kind and attentive, always checking on me. The facility was clean and well-organized, and I felt at ease throughout the process.\"\r\n', 5, '2025-02-23 18:02:23'),
(13, 5, 'The hospital personnel was amiable and really professional.  I felt well taken care of when the doctors took the time to explain my issue.', 5, '2025-02-24 18:22:47');

-- --------------------------------------------------------

--
-- Table structure for table `medical_reports`
--

CREATE TABLE `medical_reports` (
  `report_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `report_date` datetime NOT NULL,
  `report_details` text DEFAULT NULL,
  `status` enum('pending','completed','in_progress') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medical_reports`
--

INSERT INTO `medical_reports` (`report_id`, `patient_id`, `report_date`, `report_details`, `status`) VALUES
(3, 1, '2025-02-21 09:11:02', 'To diagnose skin conditions like rashes, , acne', 'pending'),
(5, 4, '2025-02-25 06:15:38', 'Medical History\r\nKnown Allergies: Penicillin\r\nChronic Conditions: Hypertension, Type 2 Diabetes\r\nPrevious Surgeries: Appendectomy (2015)\r\nMedications: Metformin, Amlodipine\r\n', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `patient_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`patient_id`, `username`, `password`, `email`, `phone`, `name`) VALUES
(1, 'Dinithi', '$2y$10$uHSUT0reRJ.9BUBkQ6vN0usSE6CS4tt10QF20K4oRnHd9PV6KAfia', 'Dinithi@gmail.com', '0718819658', 'Dinithi'),
(2, 'mishara', '$2y$10$Cjyz/lQoTOm9Fie4cbaTbOymoIfKA8UZoLf/HkS75jKicIjt.8GP2', 'mishara0205@gmail.com', '0718819658', 'Mishara Dahamini'),
(4, 'samadhi', '$2y$10$PkKQ3bPwqcHaU6UhRexHD.Iv82h/YvavpY6emkQ7LI0NyhRtNKLR2', 'samadhi@gmail.com', '0765463458', 'Nethma Samadhi'),
(5, 'Shehani', '$2y$10$FLibRA//Ey7xDbosZF4WD.AZWlPLRztzBFXgQ50sILqnsD99zVSAa', 'shehani@gmail.com', '07767867855', 'shehani hashara'),
(6, 'Shanuri', '$2y$10$2HLJpnjxdIlCVjCWMnZ72OouJ17sZlJm0xVSl4bcaHl/8nUuWg9jC', 'shanuri@gmail.com', '0775678903', 'Shanuri ');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` datetime NOT NULL,
  `status` enum('pending','completed','failed') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `patient_id`, `amount`, `payment_date`, `status`) VALUES
(2, 1, 1200.00, '2025-02-21 09:41:02', 'completed'),
(3, 2, 1500.00, '2025-02-21 17:47:05', 'pending'),
(4, 1, 100000.00, '2025-02-23 18:37:45', 'pending'),
(5, 1, 1000000.00, '2025-02-23 18:38:00', 'pending'),
(6, 1, 50000.00, '2025-02-23 18:38:18', 'pending'),
(7, 4, 70000.00, '2025-02-23 19:02:54', 'pending'),
(8, 4, 80000.00, '2025-02-24 18:58:49', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff') NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`, `name`, `email`, `phone`, `created_at`, `updated_at`) VALUES
(5, 'Tharushi', '$2y$10$mKgUNu2/7M0tqRvCXhq22OHWcHPEjaTdDTbLQltwGNr2pEhlSQttq', 'staff', 'Tharushi Dissanayake', 'tharushi@gmail.com', '+94768909877', '2025-02-23 17:29:03', '2025-02-23 17:29:03'),
(6, 'Staff', '$2y$10$G0hQwpEmZlS3k6GKXpFXDu.6i7tWtwdacQPMN0Lz47K0XbYi0B7dC', 'staff', 'Mishara', 'mishara@gmail.com', '+94778798765', '2025-02-24 19:21:47', '2025-02-24 19:23:00'),
(7, 'Admin', '$2y$10$m3oxYSZoyLYsD9kzuc6CAeRmp5vuuAx2Lufk48y4ehaspbcYovA.e', 'admin', '', 'admin@gmail.com', '0718819658', '2025-02-24 19:23:52', '2025-02-24 19:23:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `fk_doctor` (`doctor_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`doctor_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `medical_reports`
--
ALTER TABLE `medical_reports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`patient_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `medical_reports`
--
ALTER TABLE `medical_reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`),
  ADD CONSTRAINT `fk_doctor` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`) ON DELETE CASCADE;

--
-- Constraints for table `medical_reports`
--
ALTER TABLE `medical_reports`
  ADD CONSTRAINT `medical_reports_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`) ON DELETE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
