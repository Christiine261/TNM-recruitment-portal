SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `users` (
    `user_id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `firstname` varchar(20) NOT NULL,
    `lastname` varchar(20) NOT NULL,
    `phone_number` varchar(10) NOT NULL,
    `gender` enum('male', 'female') NOT NULL,
    `dob` date NOT NULL,
    `email` varchar(30) NOT NULL,
    `password` varchar(20) NOT NULL,
    `nationality` varchar(20) NOT NULL,
    `profile_picture` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




CREATE TABLE `HR_Details` (
  `HR_id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `fullname` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(20) NOT NULL,
  `profile_picture` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE `interviewers` (
  `interviewer_id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `fullname` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(20) NOT NULL,
  `department` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE `admins` (
  `admin_id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `fullname` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(20) NOT NULL,
  `profile_picture` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




CREATE TABLE `jobs` (
  `job_id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `job_title` varchar(100) NOT NULL,
  `job_description` text NOT NULL,
  `email` varchar(30) NOT NULL,
  `qualifications` text NOT NULL,
  `responsibilities` text NOT NULL,
  `deadline_date` datetime NOT NULL,
  `is_active` enum('0', '1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE `applications` (
  `application_id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `references` varchar(500) NOT NULL,
  `upload_CV` varchar(500) NOT NULL,
  `cover_letter` varchar(500) NOT NULL,
  `addition_info` text NOT NULL,
  `user_id` int(10) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(user_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE `shortlisted` (
  `shortlisted_id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `job_id` int(10) NOT NULL,
  FOREIGN KEY (job_id) REFERENCES jobs(job_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




CREATE TABLE `offer_details` (
  `offer_id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(10) NOT NULL,
  `job_id`  int(10) NOT NULL,
  `offer_status` enum('accepted', 'declined') NOT NULL,
  `offer_expiration_date` datetime NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(user_id),
  FOREIGN KEY (job_id) REFERENCES jobs(job_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE `intervier_scheduling` (
  `scheduling_id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(10) NOT NULL,
  `job_id` int(10) NOT NULL,
  `interview_date` datetime NOT NULL,
  `interview_type` varchar(20) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(user_id),
  FOREIGN KEY (job_id) REFERENCES jobs(job_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `notifications` (
  `notification_id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `content` varchar(20) NOT NULL,
  `receiver` varchar(20) NOT NULL,
  `job_id` int(10) NOT NULL,
  FOREIGN KEY (job_id) REFERENCES jobs(job_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




CREATE TABLE `contact_us` (
  `contact_id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `subject` int(10) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
 