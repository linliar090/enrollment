-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 23, 2026 at 10:56 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `enrollment_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
  `course_code` varchar(10) NOT NULL,
  `course_title` varchar(100) NOT NULL,
  `credits` int DEFAULT NULL,
  `faculty_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`course_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_code`, `course_title`, `credits`, `faculty_name`) VALUES
('CS501', 'Data Structures', 4, 'Dr. Mathew'),
('CS502', 'Database Systems', 3, 'Dr. Priya'),
('CS503', 'Web Programming', 3, 'Mr. Arun'),
('CS504', 'Operating Systems', 4, 'Dr. Lekha Nair'),
('CS505', 'Computer Networks', 3, 'Mr. Joseph Kurian'),
('CS506', 'Machine Learning', 4, 'Dr. Bindu Thomas'),
('CS507', 'Python Programming', 3, 'Ms. Reshma Ali'),
('CS508', 'Software Engineering', 3, 'Dr. Sanjay Menon'),
('CS509', 'Cloud Computing', 3, 'Mr. Vivek Raj'),
('CS510', 'Artificial Intelligence', 4, 'Dr. Anitha George'),
('CS511', 'Cyber Security', 3, 'Mr. Faisal Ahmed'),
('CS512', 'Data Mining', 3, 'Dr. Priya');

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

DROP TABLE IF EXISTS `enrollment`;
CREATE TABLE IF NOT EXISTS `enrollment` (
  `enroll_id` int NOT NULL AUTO_INCREMENT,
  `student_id` varchar(10) NOT NULL,
  `course_code` varchar(10) NOT NULL,
  `semester` varchar(10) DEFAULT NULL,
  `enroll_date` date DEFAULT NULL,
  PRIMARY KEY (`enroll_id`),
  KEY `fk_enrollment_student` (`student_id`),
  KEY `fk_enrollment_course` (`course_code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `enrollment`
--

INSERT INTO `enrollment` (`enroll_id`, `student_id`, `course_code`, `semester`, `enroll_date`) VALUES
(1, 'S109', 'CS511', 'S3', '2026-11-18');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `student_id` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `programme` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `name`, `programme`, `email`) VALUES
('S101', 'Anu Joseph', 'MSc CS', 'anu@gmail.com'),
('S102', 'Rahul Menon', 'MSc CS', 'rahul@gmail.com'),
('S103', 'Neha Thomas', 'MCA', 'neha.thomas@gmail.com'),
('S104', 'Arjun Nair', 'MSc CS', 'arjun.nair@gmail.com'),
('S105', 'Fathima Rasheed', 'MCA', 'fathima.r@gmail.com'),
('S106', 'Kevin Mathew', 'BSc CS', 'kevin.mathew@gmail.com'),
('S107', 'Sneha Pillai', 'MSc CS', 'sneha.pillai@gmail.com'),
('S108', 'Adithya Krishnan', 'BCA', 'adithya.k@gmail.com'),
('S109', 'Meera Varghese', 'MCA', 'meera.v@gmail.com'),
('S110', 'Mohammed Shafi', 'BSc CS', 'shafi.m@gmail.com'),
('S111', 'Gopika Suresh', 'MSc CS', 'gopika.s@gmail.com'),
('S112', 'Alan George', 'BCA', 'alan.george@gmail.com'),
('S113', 'Divya Ramesh', 'MCA', 'divya.ramesh@gmail.com'),
('S114', 'Nikhil Das', 'BSc CS', 'nikhil.das@gmail.com'),
('S115', 'Ann Maria Jose', 'MSc CS', 'annmaria.jose@gmail.com'),
('S123', 'Amit Andalat Ajithkumar', 'MCsCS', 'amitandalat@gmail.com');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD CONSTRAINT `fk_enrollment_course` FOREIGN KEY (`course_code`) REFERENCES `course` (`course_code`),
  ADD CONSTRAINT `fk_enrollment_student` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
