import unittest
from app import course, employee, cohort, badges, enrollment, enrollmentRequest, chapter, question, options

class TestCourse(unittest.TestCase):
    def setUp(self):
        self.c1 = course(courseName="Big questions", courseImage="images/course_4.jpg", courseDescription="This course introduces learners to the biggest questions in life", prerequisite="Finance and accounting")

    def tearDown(self):
        self.c1 = None

    def test_get_course_info(self):
        self.assertEqual(self.c1.get_course_info(), {
            "courseName": "Big questions",
            "courseImage": "images/course_4.jpg",
            "courseDescription": "This course introduces learners to the biggest questions in life",
            "prerequisite": ["Finance and accounting"]
        })

    def test_get_prerequisites(self):
        self.assertEqual(self.c1.get_prerequisite(), ["Finance and accounting"])

class TestEmployee(unittest.TestCase):
    def setUp(self):
        self.e1 = employee(employeeName="Alice", userName="Alice_01", currentDesignation="Admin", department="HR")

    def tearDown(self):
        self.e1 = None
    
    def test_get_designation(self):
        self.assertEqual(self.e1.get_designation(), {
            'currentDesignation': "Admin"
        })

    def test_get_employeeName(self):
        self.assertEqual(self.e1.get_employeeName(), "Alice")

class TestCohort(unittest.TestCase):
    def setUp(self):
        self.c2 = cohort(courseName='Introduction to life', 
            cohortName="G0", 
            enrollmentStartDate="01 Sep 1998", 
            enrollmentStartTime="00:00", 
            enrollmentEndDate="28 Oct 1998", 
            enrollmentEndTime="23:59", 
            cohortStartDate="01 Nov 1998", 
            cohortStartTime="08:00", 
            cohortEndDate="30 Nov 1998", 
            cohortEndTime="20:00", 
            trainerName="Marcus", 
            cohortSize=30, 
            slotLeft=25
        )

    def tearDown(self):
        self.c2 = None

    def test_get_dict(self):
        self.assertEqual(self.c2.get_dict(), {
            "courseName": 'Introduction to life', 
            "cohortName": "G0",
            "enrollmentStartDate": "01 Sep 1998",
            "enrollmentStartTime": "00:00", 
            "enrollmentEndDate": "28 Oct 1998", 
            "enrollmentEndTime": "23:59", 
            "cohortStartDate": "01 Nov 1998", 
            "cohortStartTime": "08:00", 
            "cohortEndDate": "30 Nov 1998", 
            "cohortEndTime": "20:00", 
            "trainerName": "Marcus", 
            "cohortSize": 30, 
            "slotLeft": 25
        })

    def test_get_enrollment_info(self):
        self.assertEqual(self.c2.get_enrollment_info(), {
            "courseName": 'Introduction to life', 
            "cohortName": "G0",
            "cohortStartDate": "01 Nov 1998", 
            "cohortStartTime": "08:00", 
            "cohortEndDate": "30 Nov 1998", 
            "cohortEndTime": "20:00", 
            "trainerName": "Marcus", 
            "cohortSize": 30, 
            "slotLeft": 25
        })

    def test_get_slotLeft(self):
        self.assertEqual(self.c2.get_slotLeft(), 25)

    def test_get_trainerName(self):
        self.assertEqual(self.c2.get_trainerName(), "Marcus")  

    def test_reduce_slot(self):
        # initial slot = 25
        self.assertEqual(self.c2.get_slotLeft(), 25)

        # reduce slot
        self.c2.reduce_slot()

        # check if slot reduced by 1; 24
        self.assertEqual(self.c2.get_slotLeft(), 24)

    def test_set_enrollment_details(self):
        # check initial enrollment details
        self.assertEqual(self.c2.get_dict(), {
            "courseName": 'Introduction to life', 
            "cohortName": "G0",
            "enrollmentStartDate": "01 Sep 1998",
            "enrollmentStartTime": "00:00", 
            "enrollmentEndDate": "28 Oct 1998", 
            "enrollmentEndTime": "23:59", 
            "cohortStartDate": "01 Nov 1998", 
            "cohortStartTime": "08:00", 
            "cohortEndDate": "30 Nov 1998", 
            "cohortEndTime": "20:00", 
            "trainerName": "Marcus", 
            "cohortSize": 30, 
            "slotLeft": 25
        })

        # update enrollment details
        self.c2.set_enrollment_details("05 Sep 1998", "12:00", "25 Oct 1998", "23:00")

        # check updated enrollment details
        self.assertEqual(self.c2.get_dict(), {
            "courseName": 'Introduction to life', 
            "cohortName": "G0",
            "enrollmentStartDate": "05 Sep 1998",
            "enrollmentStartTime": "12:00", 
            "enrollmentEndDate": "25 Oct 1998", 
            "enrollmentEndTime": "23:00", 
            "cohortStartDate": "01 Nov 1998", 
            "cohortStartTime": "08:00", 
            "cohortEndDate": "30 Nov 1998", 
            "cohortEndTime": "20:00", 
            "trainerName": "Marcus", 
            "cohortSize": 30, 
            "slotLeft": 25
        })

class TestBadges(unittest.TestCase):
    def setUp(self):
        self.b1 = badges(employeeName="Alice", badges="Introduction to life", cohortName="G0")

    def tearDown(self):
        self.b1 = None

    def test_get_badges(self):
        self.assertEqual(self.b1.get_badges(), "Introduction to life")

    def get_badges_cohort(self):
        self.assertEqual(self.b1.get_badges_cohort(), {
            'badges': "Introduction to life",
            'cohortName': "G0"
        })

class TestEnrollment(unittest.TestCase):
    def setUp(self):
        self.e2 = enrollment(employeeName="Alice", courseNameEnrolled="Introduction to life", cohortNameEnrolled="G0", recent=1)

    def tearDown(self):
        self.e2 = None

    def test_get_enrollment_info(self):
        self.assertEqual(self.e2.get_enrollment_info(), {
            'courseNameEnrolled' : "Introduction to life",
            'cohortNameEnrolled' : "G0"
        })

    def test_get_employeeName(self):
        self.assertEqual(self.e2.get_employeeName(), "Alice")

class TestEnrollmentRequest(unittest.TestCase):
    def setUp(self):
        self.e3 = enrollmentRequest(courseNameRequest="Introduction to life", cohortNameRequest="G0", learnerName="Bob")

    def tearDown(self):
        self.e3 = None

    def test_get_dict(self):
        self.assertEqual(self.e3.get_dict(), {
            "courseNameRequest": "Introduction to life",
            "cohortNameRequest": "G0",
            "learnerName": "Bob"
        })

class TestChapter(unittest.TestCase):
    def setUp(self):
        self.c3 = chapter(
            courseName="Introduction to life",
            cohortName="G1",
            chapterID=1,
            duration=60,
            graded=0
        )

    def tearDown(self):
        self.c3 = None

    def test_get_dict(self):
        self.assertEqual(self.c3.get_dict(), {
            "courseName":"Introduction to life",
            "cohortName":"G1",
            "chapterID":1,
            "duration":60,
            "graded":0
        })

    def test_update_chapter_data(self):
        # Initial chapter data; duration = 60, graded=0
        self.assertEqual(self.c3.get_dict(), {
            "courseName":"Introduction to life",
            "cohortName":"G1",
            "chapterID":1,
            "duration":60,
            "graded":0
        })

        # update chapter data; duration = 120, graded= 1
        self.c3.update_chapter_data(duration=120, graded=1)

        # Check if chapter data updated
        self.assertEqual(self.c3.get_dict(), {
            "courseName":"Introduction to life",
            "cohortName":"G1",
            "chapterID":1,
            "duration":120,
            "graded":1
        })

class TestQuestion(unittest.TestCase):
    def setUp(self):
        self.q1 = question(
            courseName="Introduction to life",
            cohortName="G1",
            chapterID=1,
            questionID=1,
            questionText="What is the meaning of our existence?"
        )

    def tearDown(self):
        self.q1 = None

    def test_get_dict(self):
        self.assertEqual(self.q1.get_dict(), {
            "courseName":"Introduction to life",
            "cohortName":"G1",
            "chapterID":1,
            "questionID":1,
            "questionText":"What is the meaning of our existence?"
        })

class TestOptions(unittest.TestCase):
    def setUp(self):
        self.o1 = options(
            courseName="Introduction to life",
            cohortName="G1",
            chapterID=1,
            questionID=1,
            optionID=1,
            optionText="Meaning is like an equation - add or subtract value variables, and you get more or less meaning.",
            isRight=1
        )

    def tearDown(self):
        self.o1 = None

    def test_get_dict(self):
        self.assertEqual(self.o1.get_dict(), {
            "courseName":"Introduction to life",
            "cohortName":"G1",
            "chapterID":1,
            "questionID":1,
            "optionID":1,
            "optionText":"Meaning is like an equation - add or subtract value variables, and you get more or less meaning.",
            "isRight":1
        })

if __name__ == "__main__":
    unittest.main()