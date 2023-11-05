-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2023 at 10:39 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uni_course_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `staff_id` varchar(5) NOT NULL,
  `role` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_code` varchar(4) NOT NULL,
  `title` varchar(100) NOT NULL,
  `desciption` text NOT NULL,
  `credit_value` int(11) NOT NULL,
  `level` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_code`, `title`, `desciption`, `credit_value`, `level`) VALUES
('C001', 'Quantum physics', 'Quantum mechanics is a fundamental theory in physics that describes the behavior of nature at the scale of atoms and subatomic particles. It is the foundation of all quantum physics including quantum chemistry, quantum field theory, quantum technology, and quantum information science.', 5, 'undergraduate');

-- --------------------------------------------------------

--
-- Table structure for table `course_material`
--

CREATE TABLE `course_material` (
  `material_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `format` varchar(10) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `course_code` varchar(4) DEFAULT NULL,
  `instructor_id` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `co_requisite`
--

CREATE TABLE `co_requisite` (
  `course_code` varchar(4) NOT NULL,
  `requested_course` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` varchar(5) NOT NULL,
  `department_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `department_name`) VALUES
('DEP01', 'Department of physics');

-- --------------------------------------------------------

--
-- Table structure for table `enroll`
--

CREATE TABLE `enroll` (
  `semester_id` varchar(8) NOT NULL,
  `course_code` varchar(4) NOT NULL,
  `student_id` varchar(10) NOT NULL,
  `enrollment_status` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grade`
--

CREATE TABLE `grade` (
  `student_id` varchar(10) NOT NULL,
  `course_code` varchar(4) NOT NULL,
  `instructor_id` varchar(5) NOT NULL,
  `grade_value` varchar(2) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `instructor`
--

CREATE TABLE `instructor` (
  `instructor_id` varchar(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `department_id` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `instructor_contact`
--

CREATE TABLE `instructor_contact` (
  `instructor_id` varchar(5) NOT NULL,
  `contact` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `instructor_subject`
--

CREATE TABLE `instructor_subject` (
  `instructor_id` varchar(5) NOT NULL,
  `subject` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prerequisite`
--

CREATE TABLE `prerequisite` (
  `course_code` varchar(4) NOT NULL,
  `requested_course` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `semester_id` varchar(8) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`semester_id`, `start_date`, `end_date`) VALUES
('SEM/23/1', '2023-06-01', '2023-10-31');

-- --------------------------------------------------------

--
-- Table structure for table `semester_course`
--

CREATE TABLE `semester_course` (
  `semester_id` varchar(8) NOT NULL,
  `course_code` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` varchar(10) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `acedmic_program` varchar(50) DEFAULT NULL,
  `advisor` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `name`, `dob`, `acedmic_program`, `advisor`) VALUES
('ST/22/0001', 'Kalpa Madhushan Suraweera', '2002-10-15', 'Bachelor\'s', 'Albert Einstein');

-- --------------------------------------------------------

--
-- Table structure for table `student_contact`
--

CREATE TABLE `student_contact` (
  `student_id` varchar(10) NOT NULL,
  `contact` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teaching`
--

CREATE TABLE `teaching` (
  `instructor_id` varchar(5) NOT NULL,
  `course_code` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_code`);

--
-- Indexes for table `course_material`
--
ALTER TABLE `course_material`
  ADD PRIMARY KEY (`material_id`),
  ADD KEY `course_code` (`course_code`),
  ADD KEY `instructor_id` (`instructor_id`);

--
-- Indexes for table `co_requisite`
--
ALTER TABLE `co_requisite`
  ADD PRIMARY KEY (`course_code`,`requested_course`),
  ADD KEY `requested_course` (`requested_course`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `enroll`
--
ALTER TABLE `enroll`
  ADD PRIMARY KEY (`semester_id`,`course_code`,`student_id`),
  ADD KEY `course_code` (`course_code`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `grade`
--
ALTER TABLE `grade`
  ADD PRIMARY KEY (`student_id`,`course_code`,`instructor_id`),
  ADD KEY `course_code` (`course_code`),
  ADD KEY `instructor_id` (`instructor_id`);

--
-- Indexes for table `instructor`
--
ALTER TABLE `instructor`
  ADD PRIMARY KEY (`instructor_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `instructor_contact`
--
ALTER TABLE `instructor_contact`
  ADD PRIMARY KEY (`instructor_id`,`contact`);

--
-- Indexes for table `instructor_subject`
--
ALTER TABLE `instructor_subject`
  ADD PRIMARY KEY (`instructor_id`,`subject`);

--
-- Indexes for table `prerequisite`
--
ALTER TABLE `prerequisite`
  ADD PRIMARY KEY (`course_code`,`requested_course`),
  ADD KEY `requested_course` (`requested_course`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`semester_id`);

--
-- Indexes for table `semester_course`
--
ALTER TABLE `semester_course`
  ADD PRIMARY KEY (`semester_id`,`course_code`),
  ADD KEY `fk_semester_course_course_code` (`course_code`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `student_contact`
--
ALTER TABLE `student_contact`
  ADD PRIMARY KEY (`student_id`,`contact`);

--
-- Indexes for table `teaching`
--
ALTER TABLE `teaching`
  ADD PRIMARY KEY (`instructor_id`,`course_code`),
  ADD KEY `course_code` (`course_code`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course_material`
--
ALTER TABLE `course_material`
  ADD CONSTRAINT `course_material_ibfk_1` FOREIGN KEY (`course_code`) REFERENCES `course` (`course_code`),
  ADD CONSTRAINT `course_material_ibfk_2` FOREIGN KEY (`instructor_id`) REFERENCES `instructor` (`instructor_id`);

--
-- Constraints for table `co_requisite`
--
ALTER TABLE `co_requisite`
  ADD CONSTRAINT `co_requisite_ibfk_1` FOREIGN KEY (`course_code`) REFERENCES `course` (`course_code`),
  ADD CONSTRAINT `co_requisite_ibfk_2` FOREIGN KEY (`requested_course`) REFERENCES `course` (`course_code`);

--
-- Constraints for table `enroll`
--
ALTER TABLE `enroll`
  ADD CONSTRAINT `enroll_ibfk_1` FOREIGN KEY (`semester_id`) REFERENCES `semester` (`semester_id`),
  ADD CONSTRAINT `enroll_ibfk_2` FOREIGN KEY (`course_code`) REFERENCES `course` (`course_code`),
  ADD CONSTRAINT `enroll_ibfk_3` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `grade`
--
ALTER TABLE `grade`
  ADD CONSTRAINT `grade_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `grade_ibfk_2` FOREIGN KEY (`course_code`) REFERENCES `course` (`course_code`),
  ADD CONSTRAINT `grade_ibfk_3` FOREIGN KEY (`instructor_id`) REFERENCES `instructor` (`instructor_id`);

--
-- Constraints for table `instructor`
--
ALTER TABLE `instructor`
  ADD CONSTRAINT `instructor_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`);

--
-- Constraints for table `instructor_contact`
--
ALTER TABLE `instructor_contact`
  ADD CONSTRAINT `instructor_contact_ibfk_1` FOREIGN KEY (`instructor_id`) REFERENCES `instructor` (`instructor_id`);

--
-- Constraints for table `instructor_subject`
--
ALTER TABLE `instructor_subject`
  ADD CONSTRAINT `instructor_subject_ibfk_1` FOREIGN KEY (`instructor_id`) REFERENCES `instructor` (`instructor_id`);

--
-- Constraints for table `prerequisite`
--
ALTER TABLE `prerequisite`
  ADD CONSTRAINT `prerequisite_ibfk_1` FOREIGN KEY (`course_code`) REFERENCES `course` (`course_code`),
  ADD CONSTRAINT `prerequisite_ibfk_2` FOREIGN KEY (`requested_course`) REFERENCES `course` (`course_code`);

--
-- Constraints for table `semester_course`
--
ALTER TABLE `semester_course`
  ADD CONSTRAINT `fk_semester_course_course_code` FOREIGN KEY (`course_code`) REFERENCES `course` (`course_code`),
  ADD CONSTRAINT `fk_semester_course_semester_id` FOREIGN KEY (`semester_id`) REFERENCES `semester` (`semester_id`);

--
-- Constraints for table `student_contact`
--
ALTER TABLE `student_contact`
  ADD CONSTRAINT `student_id` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `teaching`
--
ALTER TABLE `teaching`
  ADD CONSTRAINT `teaching_ibfk_1` FOREIGN KEY (`instructor_id`) REFERENCES `instructor` (`instructor_id`),
  ADD CONSTRAINT `teaching_ibfk_2` FOREIGN KEY (`course_code`) REFERENCES `course` (`course_code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
