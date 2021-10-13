--
-- Database: `Core feature 1`
--

drop database if exists cf1;
create database cf1;
use cf1;

DROP TABLE IF EXISTS course;
CREATE TABLE course (
  courseName varchar(100) NOT NULL,
  courseImage varchar(100) NOT NULL,
  courseDescription varchar(200) NOT NULL,
  prerequisite varchar(500) NOT NULL,
  PRIMARY KEY (courseName)
);

DROP TABLE IF EXISTS employee;
CREATE TABLE employee (
  employeeName varchar(100) NOT NULL,
  userName varchar(100) NOT NULL,
  currentDesignation varchar(100) NOT NULL,
  department varchar(100) NOT NULL,
  PRIMARY KEY (employeeName)
);

DROP TABLE IF EXISTS cohort;
CREATE TABLE cohort (
  courseName varchar(100) NOT NULL,
  cohortName varchar(100) NOT NULL,
  enrollmentStartDate varchar(30) NOT NULL,
  enrollmentStartTime varchar(30) NOT NULL,
  enrollmentEndDate varchar(30) NOT NULL,
  enrollmentEndTime varchar(30) NOT NULL,
  cohortStartDate varchar(30) NOT NULL,
  cohortStartTime varchar(30) NOT NULL,
  cohortEndDate varchar(30) NOT NULL,
  cohortEndTime varchar(30) NOT NULL,
  trainerName varchar(100) NOT NULL,
  cohortSize int NOT NULL,
  slotLeft int NOT NULL,
  PRIMARY KEY (courseName, cohortName),
  foreign key (courseName) references course(courseName),
  foreign key (trainerName) references employee(employeeName)
);

DROP TABLE IF EXISTS badges;
CREATE TABLE badges (
  employeeName varchar(100) NOT NULL,
  badges varchar(100) NOT NULL,
  cohortName varchar(100) NOT NULL,
  PRIMARY KEY (employeeName, badges, cohortName),
  foreign key (employeeName) references employee(employeeName),
  foreign key (badges, cohortName) references cohort(courseName, cohortName)
);

DROP TABLE IF EXISTS enrollment;
CREATE TABLE enrollment (
  employeeName varchar(100) NOT NULL,
  courseNameEnrolled varchar(100) NOT NULL,
  cohortNameEnrolled varchar(100) NOT NULL,
  PRIMARY KEY (employeeName, courseNameEnrolled, cohortNameEnrolled),
  foreign key (employeeName) references employee(employeeName),
  foreign key (courseNameEnrolled, cohortNameEnrolled) references cohort(courseName, cohortName)
);

DROP TABLE IF EXISTS enrollmentRequest;
CREATE TABLE enrollmentRequest (
  courseNameRequest varchar(100) NOT NULL,
  cohortNameRequest varchar(100) NOT NULL,
  learnerName varchar(100) NOT NULL,
  PRIMARY KEY (courseNameRequest, cohortNameRequest, LearnerName),
  foreign key (courseNameRequest, cohortNameRequest) references cohort(courseName, cohortName),
  foreign key (learnerName) references employee(employeeName)
);

INSERT INTO employee(employeeName, userName, currentDesignation, department) VALUES
('Alice', 'Alice_01', 'Admin', 'HR'),
('Bob', 'Bob_02', 'Learner', 'Operations'),
('Vera', 'Vera_04', 'Learner', 'Operations'),
('Charles', 'Charles_03', 'trainer', 'Operations');

INSERT INTO course(courseName, courseImage, courseDescription, prerequisite) VALUES
('Introduction to life', 'images/course_6.jpg', 'This course introduces learners to life', ''),
('Introduction to flask', 'images/course_5.jpg', 'This course introduces learners to the flask langauge', ''),
('Introduction to python', 'images/course_1.jpg', 'This course introduces learners to the python langauge', ''),
('Introduction to HTML', 'images/course_2.jpg', 'This course introduces learners to HTML', 'Introduction to python'),
('Finance and accounting', 'images/course_3.jpg', 'This course introduces learners to the world of money', 'Introduction to HTML' ),
('Big questions', 'images/course_4.jpg', 'This course introduces learners to the biggest questions in life', 'Finance and accounting');

INSERT INTO cohort(courseName, cohortName, enrollmentStartDate, enrollmentStartTime, enrollmentEndDate, enrollmentEndTime, cohortStartDate, cohortStartTime, cohortEndDate, cohortEndTime, trainerName, cohortSize, slotLeft) VALUES
('Introduction to python', 'G1', '08 Oct 1998', '00:00', '18 Oct 1998', '23:59', '01 Nov 1998', '08:00', '30 Nov 1998', '20:00', 'Charles', '30', 5),
('Introduction to python', 'G2', '08 Oct 2019', '00:00', '18 Oct 2019', '23:59', '01 Nov 2019', '08:00', '30 Nov 2019', '20:00', 'Charles', '30', 30),
('Introduction to python', 'G3', '08 Oct 2021', '00:00', '18 Oct 2021', '23:59', '01 Nov 2021', '08:00', '30 Nov 2021', '20:00', 'Charles', '30', 30),
('Introduction to HTML', 'G0', '01 Oct 2021', '00:00', '05 Oct 2021', '23:59', '01 Nov 2021', '08:00', '30 Nov 2021', '20:00', 'Charles', '30', 30),
('Introduction to HTML', 'G1', '08 Oct 2021', '00:00', '18 Oct 2021', '23:59', '01 Nov 2021', '08:00', '30 Nov 2021', '20:00', 'Charles', '30', 30),
('Introduction to HTML', 'G2', '08 Oct 2021', '00:00', '18 Oct 2021', '23:59', '01 Nov 2021', '08:00', '30 Nov 2021', '20:00', 'Charles', '30', 0),
('Introduction to HTML', 'G3', '18 Oct 2021', '00:00', '28 Oct 2021', '23:59', '10 Nov 2021', '08:00', '20 Nov 2021', '20:00', 'Charles', '30', 30),
('Introduction to HTML', 'G4', '08 Oct 2021', '00:00', '28 Oct 2021', '23:59', '10 Nov 2021', '08:00', '20 Nov 2021', '20:00', 'Charles', '30', 1),
('Finance and accounting', 'G1', '08 Oct 2021', '00:00', '18 Oct 2021', '23:59', '01 Nov 2021', '08:00', '30 Nov 2021', '20:00', 'Charles', '30', 30),
('Big questions', 'G1', '08 Oct 2021', '00:00', '18 Oct 2021', '23:59', '01 Nov 2021', '08:00', '30 Nov 2021', '20:00', 'Charles', '30', 30),
('Introduction to flask', 'G1', '08 Oct 2021', '00:00', '18 Oct 2021', '23:59', '01 Nov 2021', '08:00', '30 Nov 2021', '20:00', 'Charles', '30', 30),
('Introduction to life', 'G1', '08 Oct 2021', '00:00', '18 Oct 2021', '23:59', '01 Nov 2021', '08:00', '30 Nov 2021', '20:00', 'Charles', '30', 30);


INSERT INTO enrollment(employeeName, courseNameEnrolled, cohortNameEnrolled) VALUES
('Alice','Introduction to python','G3'),
('Charles', 'Finance and accounting', 'G1'),
('Alice', 'Big questions', 'G1'),
('Bob','Introduction to flask', 'G1');

INSERT INTO badges(employeeName, badges, cohortName) VALUES
('Alice', 'Introduction to python', 'G1'),
('Alice', 'Introduction to HTML', 'G1'),
('Bob', 'Introduction to python', 'G1'),
('Vera', 'Introduction to python', 'G1');

INSERT INTO enrollmentRequest(courseNameRequest, cohortNameRequest, LearnerName) VALUES
('Big questions', 'G1', 'Charles'),
('Finance and accounting', 'G1','Charles'),
('Introduction to HTML', 'G4', 'Bob');