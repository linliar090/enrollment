-- Course Enrollment System - database setup
-- Run this in phpMyAdmin (SQL tab) or with the MySQL CLI.

CREATE DATABASE IF NOT EXISTS enrollment_db
    CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE enrollment_db;

-- Student master table
CREATE TABLE IF NOT EXISTS student (
    student_id VARCHAR(10)  PRIMARY KEY,
    name       VARCHAR(100) NOT NULL,
    programme  VARCHAR(50),
    email      VARCHAR(100)
);

-- Course master table
CREATE TABLE IF NOT EXISTS course (
    course_code  VARCHAR(10)  PRIMARY KEY,
    course_title VARCHAR(100) NOT NULL,
    credits      INT,
    faculty_name VARCHAR(100)
);

-- Enrollment table (links students to courses)
CREATE TABLE IF NOT EXISTS enrollment (
    enroll_id   INT AUTO_INCREMENT PRIMARY KEY,
    student_id  VARCHAR(10) NOT NULL,
    course_code VARCHAR(10) NOT NULL,
    semester    VARCHAR(10),
    enroll_date DATE,
    FOREIGN KEY (student_id)  REFERENCES student(student_id),
    FOREIGN KEY (course_code) REFERENCES course(course_code)
);

-- Sample students (INSERT IGNORE so the script can be re-run safely)
INSERT IGNORE INTO student (student_id, name, programme, email) VALUES
('S101', 'Anjali Menon',   'MSc CS', 'anjali@example.com'),
('S102', 'Rahul Nair',     'MSc CS', 'rahul@example.com'),
('S103', 'Fathima Rasheed','MCA',    'fathima@example.com'),
('S104', 'Arjun Thomas',   'MCA',    'arjun@example.com'),
('S105', 'Sneha Joseph',   'BSc CS', 'sneha@example.com');

-- Sample courses
INSERT IGNORE INTO course (course_code, course_title, credits, faculty_name) VALUES
('CS201', 'Database Management Systems', 4, 'Dr. Priya Varghese'),
('CS202', 'Web Programming',             3, 'Mr. Kiran Kumar'),
('CS203', 'Data Structures',             4, 'Dr. Suresh Babu'),
('CS204', 'Operating Systems',           3, 'Ms. Divya George'),
('CS205', 'Computer Networks',           3, 'Dr. Manoj Pillai');
