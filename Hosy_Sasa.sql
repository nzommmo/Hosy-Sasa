-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 05, 2024 at 09:32 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hosy_sasa`
--

-- --------------------------------------------------------

--
-- Table structure for table `Doctors`
--

CREATE TABLE `Doctors` (
  `doctor_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `speciality` varchar(255) DEFAULT NULL,
  `Room_No` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Doctors`
--

INSERT INTO `Doctors` (`doctor_id`, `user_id`, `first_name`, `last_name`, `speciality`, `Room_No`) VALUES
(2, 9, 'john', 'NZOMO', NULL, NULL),
(3, 11, 'Patel', 'vishar', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lab_results`
--

CREATE TABLE `lab_results` (
  `result_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `test_date` date NOT NULL,
  `test_name` varchar(100) DEFAULT NULL,
  `result_value` varchar(100) DEFAULT NULL,
  `Prescription` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab_results`
--

INSERT INTO `lab_results` (`result_id`, `patient_id`, `doctor_id`, `test_date`, `test_name`, `result_value`, `Prescription`) VALUES
(13, 2, 3, '2024-05-15', 'Malaria', 'Positive', 'Panadol'),
(14, 2, 3, '2024-05-15', 'Malaria', 'Positive', 'Panadol'),
(15, 2, 3, '2024-05-15', 'Malaria', 'Positive', 'Panadol'),
(16, 2, 3, '2024-05-15', 'Malaria', 'Positive', 'Panadol'),
(17, 2, 3, '2024-05-15', 'Malaria', 'Positive', 'Panadol'),
(18, 2, 3, '2024-05-17', 'Malaria', 'Positive', 'Panadol'),
(19, 2, 3, '2024-05-17', 'Malaria', 'Positive', 'Panadol'),
(20, 2, 3, '2024-05-17', 'Malaria', 'Positive', 'Panadol'),
(21, 2, 3, '2024-05-17', 'Malaria', 'Positive', 'Panadol'),
(22, 2, 3, '2024-05-17', 'Malaria', 'Positive', 'Panadol'),
(23, 2, 3, '2024-05-17', 'Malaria', 'Positive', 'Panadol'),
(24, 2, 3, '2024-05-17', 'Malaria', 'Positive', 'Panadol'),
(25, 2, 3, '2024-05-17', 'Malaria', 'Positive', 'Panadol'),
(26, 2, 3, '2024-05-17', 'Malaria', 'Positive', 'Panadol'),
(27, 2, 3, '2024-05-17', 'Malaria', 'Positive', 'Panadol'),
(28, 2, 3, '2024-05-17', 'Malaria', 'Positive', 'Panadol'),
(29, 2, 3, '2024-05-17', 'Malaria', 'Positive', 'Panadol'),
(30, 1, 3, '2024-05-20', 'Malaria', 'Positive', 'Panadol'),
(31, 1, 3, '2024-05-20', 'Malaria', 'Positive', 'Panadol'),
(32, 1, 3, '2024-05-20', 'Malaria', 'Positive', 'Panadol');

-- --------------------------------------------------------

--
-- Table structure for table `medical_records`
--

CREATE TABLE `medical_records` (
  `record_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `record_date` date NOT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `diagnosis` varchar(255) DEFAULT NULL,
  `prescription` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medical_records`
--

INSERT INTO `medical_records` (`record_id`, `patient_id`, `record_date`, `doctor_id`, `diagnosis`, `prescription`) VALUES
(1, 2, '2024-04-04', 9, 'Fever', 'celestamine'),
(2, 2, '2024-05-05', 3, 'Fever', 'Mara Moja'),
(3, 1, '2024-05-05', 3, 'Tuberculosis', 'Cough Syrup');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patient_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patient_id`, `user_id`, `first_name`, `last_name`, `date_of_birth`, `gender`, `address`, `phone_number`) VALUES
(1, 7, 'mary', 'NZOMO', NULL, 'Male', NULL, NULL),
(2, 10, 'ERIC', 'NZOMO', NULL, 'Male', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(30) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime NOT NULL,
  `title` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `patient_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `doctor_id`, `start_datetime`, `end_datetime`, `title`, `description`, `patient_id`) VALUES
(3, 3, '2024-05-15 19:59:00', '2024-04-08 20:48:03', 'Screening', 'MRI SCAN', 2),
(6, 2, '2024-04-14 00:40:49', '2024-04-15 00:40:49', 'Dentist', 'Teeth Whitening', NULL),
(7, 3, '2024-05-05 18:51:00', '2024-05-05 20:48:00', 'Check-Up', 'Full Body Check up', 2),
(8, 3, '2024-05-05 12:54:00', '2024-05-05 14:54:00', 'MRI', 'FULL body scan', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `user_type` enum('Admin','Doctor','Patient') NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `user_type`, `email`, `password_hash`) VALUES
(4, 'Rodgers', 'Kipembe', 'Doctor', 'rodger@gmail.com', '$2y$10$la071hHF2wEEX3C08E2Kiutfcnt4bY6A95hOKbo3hquLsFeAb561a'),
(7, 'mary', 'NZOMO', 'Patient', 'ericnzomo11@gmail.com', '$2y$10$IIffrgJrS3K5GMVRCyVtQ.N4dgUqiEzIK5rSip8T7lB8hvvbtUlia'),
(9, 'john', 'NZOMO', 'Doctor', 'ericnzomo123@gmail.com', '$2y$10$YYH1aFHQuPeAmDzgnFs8KuXo49ewnqa9aI2pt4Q.5l03PKflscK4q'),
(10, 'ERIC', 'NZOMO', 'Patient', 'ericnzomo17@gmail.com', '$2y$10$XI/UIYRCg0CJ87go42CUHuLK..DnJf2bRUGU5SQOMf7K7FsLhgm/S'),
(11, 'Patel', 'vishar', 'Doctor', 'patel@gmail.com', '$2y$10$DIb/etkGW7ax.qPiYVtVtOdjkheZB8to5HnN8Lc9oKsQC.iOYZuge');

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `autofill_doctor_name` AFTER INSERT ON `users` FOR EACH ROW BEGIN
    IF NEW.user_type = 'Doctor' THEN
        INSERT INTO Doctors (user_id, first_name, last_name)
        VALUES (NEW.user_id, NEW.first_name, NEW.last_name);
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `autofill_patient_name` AFTER INSERT ON `users` FOR EACH ROW BEGIN
    IF NEW.user_type = 'Patient' THEN
        INSERT INTO patients (user_id, first_name, last_name)
        VALUES (NEW.user_id, NEW.first_name, NEW.last_name);
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `vital_signs`
--

CREATE TABLE `vital_signs` (
  `sign_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `sign_date` date NOT NULL,
  `sign_name` varchar(100) DEFAULT NULL,
  `sign_value` varchar(100) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vital_signs`
--

INSERT INTO `vital_signs` (`sign_id`, `patient_id`, `sign_date`, `sign_name`, `sign_value`, `doctor_id`) VALUES
(19, 2, '2024-05-25', 'Body Temperature', '29', 3),
(20, 2, '2024-05-25', 'Oxygen Levels', '45', 3),
(21, 2, '2024-05-25', 'Blood Pressure', '89', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Doctors`
--
ALTER TABLE `Doctors`
  ADD PRIMARY KEY (`doctor_id`),
  ADD KEY `fk_doctor_user_id` (`user_id`);

--
-- Indexes for table `lab_results`
--
ALTER TABLE `lab_results`
  ADD PRIMARY KEY (`result_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `fk_doctor_id` (`doctor_id`);

--
-- Indexes for table `medical_records`
--
ALTER TABLE `medical_records`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patient_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `fk_patient_id` (`patient_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vital_signs`
--
ALTER TABLE `vital_signs`
  ADD PRIMARY KEY (`sign_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `fk_doctor_id1` (`doctor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Doctors`
--
ALTER TABLE `Doctors`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lab_results`
--
ALTER TABLE `lab_results`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `medical_records`
--
ALTER TABLE `medical_records`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `vital_signs`
--
ALTER TABLE `vital_signs`
  MODIFY `sign_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Doctors`
--
ALTER TABLE `Doctors`
  ADD CONSTRAINT `fk_doctor_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lab_results`
--
ALTER TABLE `lab_results`
  ADD CONSTRAINT `fk_doctor_id` FOREIGN KEY (`doctor_id`) REFERENCES `Doctors` (`doctor_id`),
  ADD CONSTRAINT `lab_results_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`);

--
-- Constraints for table `medical_records`
--
ALTER TABLE `medical_records`
  ADD CONSTRAINT `medical_records_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`);

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `fk_patient_id` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`),
  ADD CONSTRAINT `schedule_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `Doctors` (`doctor_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vital_signs`
--
ALTER TABLE `vital_signs`
  ADD CONSTRAINT `fk_doctor_id1` FOREIGN KEY (`doctor_id`) REFERENCES `Doctors` (`doctor_id`),
  ADD CONSTRAINT `vital_signs_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;