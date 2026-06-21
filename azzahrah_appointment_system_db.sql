-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3302
-- Generation Time: Jun 21, 2026 at 04:19 PM
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
-- Database: `azzahrah_appointment_system_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `appointment_id` varchar(15) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(255) NOT NULL,
  `appointment_type` varchar(255) NOT NULL,
  `patient_remark` text DEFAULT NULL,
  `doctor_remark` text DEFAULT NULL,
  `time_slot_id` varchar(10) NOT NULL,
  `patient_id` varchar(15) NOT NULL,
  `staff_id` varchar(15) NOT NULL,
  `follow_up_appointment_id` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`appointment_id`, `date`, `status`, `appointment_type`, `patient_remark`, `doctor_remark`, `time_slot_id`, `patient_id`, `staff_id`, `follow_up_appointment_id`) VALUES
('AP001', '2026-05-30', 'Completed', 'Consultation', 'Chest pain for two days', 'Patient needs ECG check.', 'TS001', 'P001', 'S001', 'AP009'),
('AP002', '2026-05-31', 'Scheduled', 'Consultation', 'Tooth pain on left side', 'Possible cavity issue', 'TS003', 'P002', 'S002', NULL),
('AP003', '2026-06-01', 'Scheduled', 'Consultation', 'Regular child checkup', 'Healthy condition', 'TS004', 'P003', 'S002', NULL),
('AP004', '2026-06-20', 'Scheduled', 'Consultation', 'Allergic', 'Needs a follow-up appointment.', 'TS004', 'P004', 'S003', NULL),
('AP005', '2026-06-20', 'Scheduled', 'Checkup', '', 'Needs to reduce sugar consumption.', 'TS003', 'P004', 'S003', NULL),
('AP007', '2026-06-21', 'Scheduled', 'Consultation', 'This is a test remark', NULL, 'TS002', 'P004', 'S001', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `article_id` varchar(9) NOT NULL,
  `title` varchar(30) NOT NULL,
  `content` text NOT NULL,
  `publish_datetime` datetime NOT NULL,
  `status` varchar(10) NOT NULL CHECK (`status` in ('Pending','Approved','Rejected')),
  `staff_id` varchar(15) NOT NULL,
  `admin_staff_id` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`article_id`, `title`, `content`, `publish_datetime`, `status`, `staff_id`, `admin_staff_id`) VALUES
('A001', 'Heart Health', 'Exercise regularly and avoid smoking. Also avoid fast food.', '2026-06-20 18:06:03', 'Approved', 'S001', 'S003'),
('A002', 'Dental Care', 'Brush teeth twice daily and reduce sugar.', '2026-06-20 18:06:19', 'Approved', 'S003', 'S003'),
('A004', 'Diabetes', 'Diabetes is a kind of critical disease caused by too much sugar in our blood.', '2026-06-20 04:06:51', 'Pending', 'S001', 'S003');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` varchar(8) NOT NULL,
  `department_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `department_name`, `description`, `location`) VALUES
('D001', 'Cardiology', 'Heart specialist department', 'Level 2'),
('D002', 'Dental', 'Dental treatment department', 'Level 1'),
('D003', 'Pediatrics', 'Children healthcare department', 'Level 3');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `patient_id` varchar(15) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `ic_number` varchar(12) NOT NULL,
  `phone_no` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`patient_id`, `name`, `email`, `date_of_birth`, `ic_number`, `phone_no`, `password`, `profile_picture`) VALUES
('P001', 'Adam Amsyar', 'adam@gmail.com', '2004-06-15', '123456789', '01122334455', 'adam123', NULL),
('P002', 'Nur Aina', 'aina@gmail.com', '2003-11-20', '987654321', '0129988776', 'aina123', NULL),
('P003', 'Jason Tan', 'jason@gmail.com', '2000-01-10', '456789123', '0131122334', 'jason123', NULL),
('P004', 'Test Patient', 'testpatient@example.com', '2006-01-27', '0', '0123456789', '$2y$10$AjcvoYPuXdaSHgOtnSY67.YFeD9.fLGrx82rjVFnXxMdZqgSWe13q', '');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` varchar(15) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` char(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_no` varchar(20) NOT NULL,
  `specialty` varchar(255) NOT NULL,
  `bio` text DEFAULT NULL,
  `department_id` varchar(8) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `name`, `role`, `email`, `phone_no`, `specialty`, `bio`, `department_id`, `password`, `profile_picture`) VALUES
('S001', 'Dr Ahmad', 'Doctor', 'ahmad@gmail.com', '0123456789', 'Cardiologist', NULL, 'D001', '$2y$10$AjcvoYPuXdaSHgOtnSY67.YFeD9.fLGrx82rjVFnXxMdZqgSWe13q', NULL),
('S002', 'Dr Sarah', 'Doctor', 'sarah@gmail.com', '0134567890', 'Dentist', NULL, 'D002', '$2y$10$AjcvoYPuXdaSHgOtnSY67.YFeD9.fLGrx82rjVFnXxMdZqgSWe13q', NULL),
('S003', 'Admin Ali', 'Admin', 'admin@gmail.com', '0145678901', 'Head of Cardiologist', NULL, 'D001', '$2y$10$AjcvoYPuXdaSHgOtnSY67.YFeD9.fLGrx82rjVFnXxMdZqgSWe13q', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `time_slot`
--

CREATE TABLE `time_slot` (
  `time_slot_id` varchar(10) NOT NULL,
  `time` time NOT NULL,
  `status` varchar(10) NOT NULL,
  `staff_id` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `time_slot`
--

INSERT INTO `time_slot` (`time_slot_id`, `time`, `status`, `staff_id`) VALUES
('TS001', '09:00:00', 'Active', 'S001'),
('TS002', '10:30:00', 'Active', 'S001'),
('TS003', '14:00:00', 'Active', 'S003'),
('TS004', '09:00:00', 'Active', 'S003'),
('TS005', '16:45:00', 'Active', 'S001'),
('TS006', '00:00:00', 'Inactive', 'S003'),
('TS007', '00:00:00', 'Inactive', 'S001');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `time_slot_id` (`time_slot_id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`article_id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `admin_staff_id` (`admin_staff_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`),
  ADD UNIQUE KEY `department_name` (`department_name`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`patient_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `ic_number` (`ic_number`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone_no` (`phone_no`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `time_slot`
--
ALTER TABLE `time_slot`
  ADD PRIMARY KEY (`time_slot_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`time_slot_id`) REFERENCES `time_slot` (`time_slot_id`),
  ADD CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`),
  ADD CONSTRAINT `appointment_ibfk_3` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`);

--
-- Constraints for table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`),
  ADD CONSTRAINT `article_ibfk_2` FOREIGN KEY (`admin_staff_id`) REFERENCES `staff` (`staff_id`);

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`);

--
-- Constraints for table `time_slot`
--
ALTER TABLE `time_slot`
  ADD CONSTRAINT `time_slot_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
