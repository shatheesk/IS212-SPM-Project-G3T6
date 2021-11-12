import unittest
import flask_testing
import json
from app import app, db, course, employee, cohort, badges, enrollment, enrollmentRequest, chapter, question, options, materials, materialStatus, userAttempt

class TestApp(flask_testing.TestCase):
    app.config['SQLALCHEMY_DATABASE_URI'] = "sqlite://"
    app.config['SQLALCHEMY_ENGINE_OPTIONS'] = {}
    app.config['TESTING'] = True

    def create_app(self):
        return app

    def setUp(self):
        db.create_all()

    def tearDown(self):
        db.session.remove()
        db.drop_all()


# Charles Yap
class TestSetEnrollmentPeriod(TestApp):
    def test_set_enrollment_period(self):

        enrolperiod1 = cohort (
            courseName='Introduction to life', 
            cohortName="G0", 
            enrollmentStartDate="02 Sep 1998", 
            enrollmentStartTime="00:01", 
            enrollmentEndDate="27 Oct 1998", 
            enrollmentEndTime="23:55", 
            cohortStartDate="01 Nov 1998", 
            cohortStartTime="08:00", 
            cohortEndDate="30 Nov 1998", 
            cohortEndTime="20:00", 
            trainerName="Marcus", 
            cohortSize=30, 
            slotLeft=25
        )

        db.session.add(enrolperiod1)
        db.session.commit()

        response = self.client.get("/setEnrollmentPeriod/Introduction to life/G0/01 Sep 1998/00:00/28 Oct 1998/23:59",
                            content_type='application/json')

        enrolperiodResult = cohort.query.filter_by(courseName='Introduction to life', cohortName="G0").first()
        self.assertEqual(enrolperiodResult.get_dict(), {
            "courseName" : "Introduction to life", 
            "cohortName" :"G0", 
            "enrollmentStartDate":"01 Sep 1998", 
            "enrollmentStartTime": "00:00", 
            "enrollmentEndDate":"28 Oct 1998", 
            "enrollmentEndTime":"23:59", 
            "cohortStartDate":"01 Nov 1998", 
            "cohortStartTime":"08:00", 
            "cohortEndDate" :"30 Nov 1998", 
            "cohortEndTime":"20:00", 
            "trainerName" :"Marcus", 
            "cohortSize":30, 
            "slotLeft":25

        })


# Charles Yap
class TestRetrieveQualifiedLearners(TestApp):
    def test_retrieve_qualified_learners(self):
        course1 = course (
                    courseName="Introduction to HTML", 
                    courseImage="images/course_4.jpg", 
                    courseDescription="This course introduces learners to HTML", 
                    prerequisite="Introduction to python")

        cohort1 = cohort (
                    courseName='Introduction to HTML', 
                    cohortName="G1", 
                    enrollmentStartDate="01 Sep 2021", 
                    enrollmentStartTime="00:00", 
                    enrollmentEndDate="28 Oct 2021", 
                    enrollmentEndTime="23:59", 
                    cohortStartDate="01 Dec 2021", 
                    cohortStartTime="08:00", 
                    cohortEndDate="30 Dec 2021", 
                    cohortEndTime="20:00", 
                    trainerName="Marcus", 
                    cohortSize=30, 
                    slotLeft=25
        )
    
        employee1 = employee (
            employeeName="OGH", 
            userName="OGH_01", 
            currentDesignation="Learner", 
            department="Operations"
        )

        employee2 = employee (
            employeeName="Felix", 
            userName="Felix_01", 
            currentDesignation="Learner", 
            department="Operations"
        )

        badge_ogh = badges (
            employeeName="OGH",
            badges = "Introduction to python",
            cohortName = "G0"
        )


        db.session.add(employee1)
        db.session.add(employee2)
        db.session.add(course1)
        db.session.add(cohort1)
        db.session.add(badge_ogh)
        db.session.commit()

        response = self.client.get("/retrieveQualifiedLearners/Introduction to HTML/G1",
                                   content_type='application/json')


        self.assertEqual(response.json,{
            "code" : 200,
            "QualifiedLearners" : [
                "OGH"
            ]
        })


# Charles Yap
class TestAssignLearners(TestApp):
    def test_assign_learners(self):
        # add data to materials
        material1 = materials(
            courseName="Introduction to HTML",
            cohortName="G1",
            chapterID=1,
            materialID=1,
            materialURL= "abcd"
        )

        material2 = materials(
            courseName="Introduction to HTML",
            cohortName="G1",
            chapterID=2,
            materialID=1,
            materialURL= "abcde"
        )

        db.session.add(material1)
        db.session.add(material2)

        db.session.commit()

        cohort1 = cohort(courseName='Introduction to HTML', 
            cohortName="G1", 
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
        
        db.session.add(material1)
        db.session.add(material2)
        db.session.add(cohort1)
        db.session.commit()


        request_body = {
            "courseNameRequest": "Introduction to HTML",
            "cohortNameRequest": "G1",
            "selectedLearners": [
                "Bob",
                "Vera"
            ]

        }
        
        response = self.client.post("/assignLearners",
                                data=json.dumps(request_body),
                                content_type='application/json')
        
        enrolmentResult1 = enrollment.query.filter_by(employeeName="Bob", courseNameEnrolled="Introduction to HTML",cohortNameEnrolled="G1").first()
        self.assertEqual(enrolmentResult1.get_dict(), {
            "employeeName" : "Bob",
            "courseNameEnrolled" : "Introduction to HTML",
            "cohortNameEnrolled" : "G1",
            "recent" : 1
        })
           
        enrolmentResult1 = enrollment.query.filter_by(employeeName="Vera", courseNameEnrolled="Introduction to HTML",cohortNameEnrolled="G1").first()
        self.assertEqual(enrolmentResult1.get_dict(), {
            "employeeName" : "Vera",
            "courseNameEnrolled" : "Introduction to HTML",
            "cohortNameEnrolled" : "G1",
            "recent" : 1
        })

        # check update of materialStatus
        materialStatus_result = materialStatus.query.filter_by(courseName="Introduction to HTML", cohortName = "G1", chapterID=1, materialID=1, employeeName='Bob').first()

        # check
        self.assertEqual(materialStatus_result.get_dict(), {'courseName': 'Introduction to HTML', 'cohortName': 'G1', 'chapterID': 1, 'materialID': 1, 'employeeName': 'Bob', 'done': 0})

        # check update of materialStatus
        materialStatus_result = materialStatus.query.filter_by(courseName="Introduction to HTML", cohortName = "G1", chapterID=2, materialID=1, employeeName='Bob').first()

        # check
        self.assertEqual(materialStatus_result.get_dict(), {'courseName': 'Introduction to HTML', 'cohortName': 'G1', 'chapterID': 2, 'materialID': 1, 'employeeName': 'Bob', 'done': 0})

        # check update of materialStatus
        materialStatus_result = materialStatus.query.filter_by(courseName="Introduction to HTML", cohortName = "G1", chapterID=1, materialID=1, employeeName='Vera').first()

        # check
        self.assertEqual(materialStatus_result.get_dict(), {'courseName': 'Introduction to HTML', 'cohortName': 'G1', 'chapterID': 1, 'materialID': 1, 'employeeName': 'Vera', 'done': 0})

        # check update of materialStatus
        materialStatus_result = materialStatus.query.filter_by(courseName="Introduction to HTML", cohortName = "G1", chapterID=2, materialID=1, employeeName='Vera').first()

        # check
        self.assertEqual(materialStatus_result.get_dict(), {'courseName': 'Introduction to HTML', 'cohortName': 'G1', 'chapterID': 2, 'materialID': 1, 'employeeName': 'Vera', 'done': 0})


# Charles Yap
class TestViewAllEnrolledLearners(TestApp):
    def test_view_all_enrolled_learners(self):
        enrollment1 = enrollment (
            employeeName = "OGH",
            courseNameEnrolled = "Introduction to HTML",
            cohortNameEnrolled = "G1",
            recent = 1

        )

        enrollment2 = enrollment (
            employeeName = "Datta",
            courseNameEnrolled = "Introduction to HTML",
            cohortNameEnrolled = "G1",
            recent = 1

        )

        db.session.add(enrollment1)
        db.session.add(enrollment2)
        db.session.commit()

        response = self.client.get("/viewAllEnrolledLearners/Introduction to HTML/G1",
                                   content_type='application/json')

        self.assertEqual(response.json, {
            "EnrolledLearners": [
                    "OGH",
                    "Datta"
            ],
            "code": 200
        })


if __name__ == '__main__':
    unittest.main()
