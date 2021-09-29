--
-- Database: `Course`
--

drop database if exists Course;
create database Course;
use Course;

DROP TABLE IF EXISTS Course;
CREATE TABLE Course (
  course_id int NOT NULL AUTO_INCREMENT,
  course_name varchar(100) NOT NULL,
  course_description varchar(100) NOT NULL,
  PRIMARY KEY (course_id)
);

DROP TABLE IF EXISTS Prerequisite;
CREATE TABLE Prerequisite (
  course_id int NOT NULL AUTO_INCREMENT,
  pre_req_id int(2) NOT NULL,
  PRIMARY KEY (course_id,pre_req_id),
  foreign key (course_id) references course(course_id)
);

DROP TABLE IF EXISTS Class;
CREATE TABLE Class (
  class_id int NOT NULL AUTO_INCREMENT,
  start_date varchar(30) NOT NULL,
  end_date varchar(30) NOT NULL,
  course_id int NOT NULL,
  trainer_id int NOT NULL, 
  PRIMARY KEY (class_id),
  foreign key (course_id) references course(course_id)
);

--
-- Dumping data for table `Course`
--

INSERT INTO Course(course_id, course_name, course_description) VALUES
(1, 'Course_1', 'Course_1_description'),
(2, 'Course_2', 'Course_2_description'),
(3, 'Course_3', 'Course_3_description');

INSERT INTO Prerequisite (course_id,pre_req_id) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2);

INSERT INTO Class (class_id, start_date, end_date, course_id, trainer_id) VALUES
(1, '10-10-2021', '10-10-2022', 1, 0),
(2, '10-10-2021', '10-10-2022', 1, 0),
(3, '10-10-2021', '10-10-2022', 2, 0);