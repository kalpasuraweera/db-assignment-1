-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2023 at 06:11 AM
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

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`staff_id`, `role`) VALUES
('SF001', 'Deputy Registrar'),
('SF002', 'Senior Assistant Registrar'),
('SF003', 'Assistant Registrar'),
('SF004', 'Deputy Bursar'),
('SF005', 'Senior Assistant Bursar'),
('SF006', 'Assistant Bursar'),
('SF007', 'Head of the Department'),
('SF008', 'Lecturer'),
('SF009', 'Senior Lecturer'),
('SF010', 'Assistant Network Manager');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_code` varchar(4) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `credit_value` int(11) NOT NULL,
  `level` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_code`, `title`, `description`, `credit_value`, `level`) VALUES
('C001', 'Quantum physics', 'Quantum mechanics is a fundamental theory in physics that describes the behavior of nature at the scale of atoms and subatomic particles. It is the foundation of all quantum physics including quantum chemistry, quantum field theory, quantum technology, and quantum information science.', 3, 'Undergraduate'),
('C002', 'Physics', 'Physics is the natural science of matter, involving the study of matter, its fundamental constituents, its motion and behavior through space and time, and the related entities of energy and force. Physics is one of the most fundamental scientific disciplines, with its main goal being to understand how the universe behaves. A scientist who specializes in the field of physics is called a physicist.', 2, 'Undergraduate'),
('C003', 'Computer Systems', 'In its most basic form, a computer system is a programmable electronic device that can accept input; store data; and retrieve, process and output information.', 2, 'Undergraduate'),
('C004', 'Discrete Mathematics I', 'This course module covers topics like sets, relations, and functions, including Union and Intersection. It introduces basic logic, including truth tables, predicate logic, and propositional logic. The course also discusses different proof techniques such as equivalence and contradiction. The aim is to help students understand these concepts and apply them in their studies.', 2, 'Undergraduate'),
('C005', 'Neural Computing ', 'Neural computing refers to the process of information processing performed by networks of neurons. It’s a field that’s closely related to the philosophical tradition known as the Computational theory of mind, also referred to as computationalism. This theory proposes that neural computation is the key to understanding cognition.', 3, 'Undergraduate'),
('C006', 'Probability and Statistics', 'This course provides the theoretical foundation and understanding of random variables, probability, and various discrete and continuous distributions. It aims to equip students with the ability to apply this knowledge and the tools of probability to solve real-world problems.', 2, 'Undergraduate'),
('C007', 'Machine Learning', 'Machine Learning (ML) is a branch of artificial intelligence that focuses on the use of data and algorithms to mimic the way humans learn, gradually improving its accuracy. It involves the development and study of statistical algorithms that can effectively perform tasks without explicit instructions. Recently, generative artificial neural networks have been able to surpass many previous approaches in performance.', 3, 'Undergraduate');

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

--
-- Dumping data for table `course_material`
--

INSERT INTO `course_material` (`material_id`, `title`, `format`, `link`, `course_code`, `instructor_id`) VALUES
(1, '2022 Past Paper', 'pdf', 'https://getsamplefiles.com/download/pdf/sample-1.pdf', 'C001', 'IN001'),
(2, 'Physics Syllabus', 'pdf', 'https://srilankaphysics.blogspot.com/2011/09/physics-syllabus.html', 'C001', 'IN001'),
(3, 'Memory Organization', 'pdf', 'https://ugvle.ucsc.cmb.ac.lk/pluginfile.php/27013/mod_resource/content/0/Lec%204.1.1.pdf', 'C003', 'IN003'),
(4, 'Set Theory', 'pdf', 'https://ugvle.ucsc.cmb.ac.lk/pluginfile.php/13427/mod_resource/content/1/Sets.pdf', 'C004', 'IN002'),
(5, 'Neural Computing', 'pptx', 'https://www.slideshare.net/leonardjessesuccesslord/neural-computing-88965611', 'C005', 'IN001');

-- --------------------------------------------------------

--
-- Table structure for table `co_requisite`
--

CREATE TABLE `co_requisite` (
  `course_code` varchar(4) NOT NULL,
  `requested_course` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `co_requisite`
--

INSERT INTO `co_requisite` (`course_code`, `requested_course`) VALUES
('C002', 'C001'),
('C004', 'C001'),
('C005', 'C003');

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
('DEP01', 'Department of Physics'),
('DEP02', 'Department of Statistics'),
('DEP03', 'Department of Computation and Intelligent Systems'),
('DEP04', 'Department of Communication and Media Technologies'),
('DEP05', 'Department of Information Systems Engineering');

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

--
-- Dumping data for table `enroll`
--

INSERT INTO `enroll` (`semester_id`, `course_code`, `student_id`, `enrollment_status`) VALUES
('SEM/23/1', 'C001', 'ST/22/0001', 'Registered'),
('SEM/23/1', 'C002', 'ST/22/0001', 'Waitlisted');

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

--
-- Dumping data for table `grade`
--

INSERT INTO `grade` (`student_id`, `course_code`, `instructor_id`, `grade_value`, `date`) VALUES
('ST/22/0001', 'C001', 'IN001', '55', '2023-11-06'),
('ST/22/0001', 'C002', 'IN002', '80', '2023-11-06'),
('ST/22/0002', 'C002', 'IN001', '65', '2023-11-12'),
('ST/22/0003', 'C003', 'IN003', '76', '2023-10-24'),
('ST/22/0005', 'C006', 'IN005', '75', '2023-10-20');

-- --------------------------------------------------------

--
-- Table structure for table `instructor`
--

CREATE TABLE `instructor` (
  `instructor_id` varchar(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `department_id` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instructor`
--

INSERT INTO `instructor` (`instructor_id`, `name`, `department_id`) VALUES
('IN001', 'T.N.B Wijethilake', 'DEP01'),
('IN002', 'S.V Hamsavasini', 'DEP02'),
('IN003', 'L.A.S.M Gunathilaka', 'DEP02'),
('IN004', 'K.D.C.I Thathsarani', 'DEP03'),
('IN005', 'R.K.N.D Jayawardhane', 'DEP04');

-- --------------------------------------------------------

--
-- Table structure for table `instructor_contact`
--

CREATE TABLE `instructor_contact` (
  `instructor_id` varchar(5) NOT NULL,
  `contact` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instructor_contact`
--

INSERT INTO `instructor_contact` (`instructor_id`, `contact`) VALUES
('IN001', '0776597896'),
('IN002', '0718965411'),
('IN003', '0771254237'),
('IN004', '0764538273'),
('IN005', '0711698221');

-- --------------------------------------------------------

--
-- Table structure for table `instructor_subject`
--

CREATE TABLE `instructor_subject` (
  `instructor_id` varchar(5) NOT NULL,
  `subject` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instructor_subject`
--

INSERT INTO `instructor_subject` (`instructor_id`, `subject`) VALUES
('IN001', 'Quantum Physics'),
('IN001', 'Thermodynamics'),
('IN002', 'Relativity'),
('IN003', 'Artificial Intelligence'),
('IN004', 'Middleware Architecture'),
('IN005', 'Cybersecurity');

-- --------------------------------------------------------

--
-- Table structure for table `prerequisite`
--

CREATE TABLE `prerequisite` (
  `course_code` varchar(4) NOT NULL,
  `requested_course` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prerequisite`
--

INSERT INTO `prerequisite` (`course_code`, `requested_course`) VALUES
('C003', 'C001'),
('C006', 'C004'),
('C007', 'C006');

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
('SEM/23/1', '2023-06-01', '2023-10-31'),
('SEM/23/2', '2023-11-20', '2024-05-17'),
('SEM/23/3', '2024-06-03', '2024-10-27'),
('SEM/23/4', '2024-11-18', '2025-05-16');

-- --------------------------------------------------------

--
-- Table structure for table `semester_course`
--

CREATE TABLE `semester_course` (
  `semester_id` varchar(8) NOT NULL,
  `course_code` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `semester_course`
--

INSERT INTO `semester_course` (`semester_id`, `course_code`) VALUES
('SEM/23/1', 'C001'),
('SEM/23/1', 'C002'),
('SEM/23/1', 'C003'),
('SEM/23/1', 'C004'),
('SEM/23/2', 'C006'),
('SEM/23/4', 'C005'),
('SEM/23/4', 'C007');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` varchar(10) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `academic_program` varchar(50) DEFAULT NULL,
  `advisor` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `name`, `dob`, `academic_program`, `advisor`) VALUES
('ST/22/0001', 'H.D.K.M Suraweera', '2002-10-15', 'Bachelor', 'Dr. C.I. Keppitiyagama'),
('ST/22/0002', 'T.K.O Mendis', '2002-04-23', 'Bachelor', 'Dr. A.R. Weerasinghe'),
('ST/22/0003', 'H.M.I Tashmika', '2001-05-15', 'Bachelor', 'Dr. H.E.M.H.B. Ekanayake'),
('ST/22/0004', 'A.S Thalagalage', '2002-02-20', 'Bachelor', 'Dr. M.D.R.N. Dayarathna'),
('ST/22/0005', 'J.A.D.A.D JAYALATH ', '2023-02-15', 'Bachelor', 'Dr. P. Gunaratne');

-- --------------------------------------------------------

--
-- Table structure for table `student_contact`
--

CREATE TABLE `student_contact` (
  `student_id` varchar(10) NOT NULL,
  `contact` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_contact`
--

INSERT INTO `student_contact` (`student_id`, `contact`) VALUES
('ST/22/0001', '0762234614'),
('ST/22/0002', '0770154856'),
('ST/22/0003', '0785632455'),
('ST/22/0004', '0763278439'),
('ST/22/0005', '0721982739');

-- --------------------------------------------------------

--
-- Table structure for table `teaching`
--

CREATE TABLE `teaching` (
  `instructor_id` varchar(5) NOT NULL,
  `course_code` varchar(4) NOT NULL,
  `semester_id` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teaching`
--

INSERT INTO `teaching` (`instructor_id`, `course_code`, `semester_id`) VALUES
('IN001', 'C001', 'SEM/23/1'),
('IN002', 'C002', 'SEM/23/1'),
('IN003', 'C003', 'SEM/23/1'),
('IN004', 'C006', 'SEM/23/2'),
('IN005', 'C005', 'SEM/23/4');

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
  ADD PRIMARY KEY (`instructor_id`,`course_code`,`semester_id`),
  ADD KEY `course_code` (`course_code`),
  ADD KEY `teaching_ibfk_3` (`semester_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course_material`
--
ALTER TABLE `course_material`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  ADD CONSTRAINT `teaching_ibfk_2` FOREIGN KEY (`course_code`) REFERENCES `course` (`course_code`),
  ADD CONSTRAINT `teaching_ibfk_3` FOREIGN KEY (`semester_id`) REFERENCES `semester` (`semester_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
