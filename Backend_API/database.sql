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
  PRIMARY KEY (courseName)
);

DROP TABLE IF EXISTS prerequisites;
CREATE TABLE prerequisites (
  courseName varchar(100) NOT NULL,
  prerequisite varchar(100) NOT NULL,
  PRIMARY KEY (courseName, prerequisite),
  foreign key (prerequisite) references course(courseName)
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
('Charles', 'Charles_03', 'trainer', 'Operations');

INSERT INTO course(courseName, courseImage, courseDescription) VALUES
('Introduction to python', 'images/course_1.jpg', 'This course introduces learners to the python langauge'),
('Introduction to HTML', 'images/course_2.jpg', 'This course introduces learners to HTML'),
('Finance and accounting', 'images/course_3.jpg', 'This course introduces learners to the world of money'),
('Big questions', 'images/course_4.jpg', 'This course introduces learners to the biggest questions in life');

INSERT INTO prerequisites(courseName, prerequisite) VALUES
('Introduction to HTML', 'Introduction to python'),
('Introduction to HTML', 'Finance and accounting'),
('Introduction to python', 'Big questions');

INSERT INTO cohort(courseName, cohortName, enrollmentStartDate, enrollmentStartTime, enrollmentEndDate, enrollmentEndTime, cohortStartDate, cohortStartTime, cohortEndDate, cohortEndTime, trainerName, cohortSize, slotLeft) VALUES
('Introduction to python', 'G1', '08|10|1998', '00:00', '18|10|1998', '23:59', '01|11|1998', '08:00', '30|11|1998', '20:00', 'Charles', '30', 5),
('Introduction to python', 'G2', '08|10|2019', '00:00', '18|10|2019', '23:59', '01|11|2019', '08:00', '30|11|2019', '20:00', 'Charles', '30', 30),
('Introduction to python', 'G3', '08|10|2021', '00:00', '18|10|2021', '23:59', '01|11|2021', '08:00', '30|11|2021', '20:00', 'Charles', '30', 30),
('Introduction to HTML', 'G1', '08|10|2021', '00:00', '18|10|2021', '23:59', '01|11|2021', '08:00', '30|11|2021', '20:00', 'Charles', '30', 30),
('Finance and accounting', 'G1', '08|10|2021', '00:00', '18|10|2021', '23:59', '01|11|2021', '08:00', '30|11|2021', '20:00', 'Charles', '30', 30),
('Big questions', 'G1', '08|10|2021', '00:00', '18|10|2021', '23:59', '01|11|2021', '08:00', '30|11|2021', '20:00', 'Charles', '30', 30);


INSERT INTO badges(employeeName, badges, cohortName) VALUES
('Alice', 'Introduction to python', 'G1');