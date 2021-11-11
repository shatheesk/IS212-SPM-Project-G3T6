import unittest
import flask_testing
import json
from app import app, db, course, employee, cohort, badges, enrollment, enrollmentRequest, materials, materialStatus

# Shi ting
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

# Shi ting
class TestViewAllCourses(TestApp):
    def test_viewAllCourses(self):
        course1 = course(courseName="Big questions",
                         courseImage="images/course_4.jpg",
                         courseDescription="This course introduces learners to the biggest questions in life",
                         prerequisite="Finance and accounting")
        course2 = course(courseName="Introduction to python",
                         courseImage="images/course_4.jpg",
                         courseDescription="This course introduces learners to the python langauge",
                         prerequisite="")
        course3 = course(courseName="Finance and accounting",
                         courseImage="images/course_4.jpg",
                         courseDescription="This course introduces learners to the world of money",
                         prerequisite="Introduction to HTML")
        course4 = course(courseName="Introduction to HTML",
                         courseImage="images/course_4.jpg",
                         courseDescription="This course introduces learners to HTML",
                         prerequisite="Introduction to python")

        db.session.add(course1)
        db.session.add(course2)
        db.session.add(course3)
        db.session.add(course4)
        db.session.commit()

        response = self.client.get("/viewAllCourses",
                                   content_type='application/json')

        self.assertEqual(response.json, {
            'code': 200,
            'courses': [{
                'courseDescription': 'This course introduces learners to the biggest questions in life',
                'courseImage': 'images/course_4.jpg',
                'courseName': 'Big questions',
                'prerequisite': ['Finance and accounting']
            }, {
                'courseDescription': 'This course introduces learners to the python langauge',
                'courseImage': 'images/course_4.jpg',
                'courseName': 'Introduction to python',
                'prerequisite': [
                    ''
                ]
            }, {
                'courseDescription': 'This course introduces learners to the world of money',
                'courseImage': 'images/course_4.jpg',
                'courseName': 'Finance and accounting',
                'prerequisite': ['Introduction to HTML']
            }, {
                'courseDescription': 'This course introduces learners to HTML',
                'courseImage': 'images/course_4.jpg',
                'courseName': 'Introduction to HTML',
                'prerequisite': ['Introduction to python']
            }]
        })

# added done
    def test_viewAllCourses_emptyresult(self):

        response = self.client.get("/viewAllCourses",
                                   content_type='application/json')
        
        self.assertEqual(response.json, {'code': 404, 'message': 'Error occured while retrieving all courses'})

# Shi ting
class TestViewAllCohort(TestApp):
    def test_view_all_cohort(self):
        cohort1 = cohort(courseName='Introduction to life',
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
                         slotLeft=25)

        cohort2 = cohort(courseName='Introduction to life',
                         cohortName="G1",
                         enrollmentStartDate='08 Oct 2021',
                         enrollmentStartTime="00:00",
                         enrollmentEndDate="28 Oct 1998",
                         enrollmentEndTime="23:59",
                         cohortStartDate="01 Nov 1998",
                         cohortStartTime="08:00",
                         cohortEndDate="30 Nov 1998",
                         cohortEndTime="20:00",
                         trainerName="Charles",
                         cohortSize=30,
                         slotLeft=25)

        db.session.add(cohort1)
        db.session.add(cohort2)
        db.session.commit()

        response = self.client.get("/viewAllCohort/Introduction to life",
                                   content_type='application/json')

        self.assertEqual(response.json, {
            "code": 200,
            "cohorts": [{
                "cohortEndDate": "30 Nov 1998",
                "cohortEndTime": "20:00",
                "cohortName": "G0",
                "cohortSize": 30,
                "cohortStartDate": "01 Nov 1998",
                "cohortStartTime": "08:00",
                "courseName": "Introduction to life",
                "enrollmentEndDate": "28 Oct 1998",
                "enrollmentEndTime": "23:59",
                "enrollmentStartDate": "01 Sep 1998",
                "enrollmentStartTime": "00:00",
                "slotLeft": 25,
                "trainerName": "Marcus"
            }, {
                "cohortEndDate": "30 Nov 1998",
                "cohortEndTime": "20:00",
                "cohortName": "G1",
                "cohortSize": 30,
                "cohortStartDate": "01 Nov 1998",
                "cohortStartTime": "08:00",
                "courseName": "Introduction to life",
                "enrollmentEndDate": "28 Oct 1998",
                "enrollmentEndTime": "23:59",
                "enrollmentStartDate": "08 Oct 2021",
                "enrollmentStartTime": "00:00",
                "slotLeft": 25,
                "trainerName": "Charles"
            }]
        })

#added done

    def test_view_all_cohort_emptyresult(self):
        cohort3 = cohort(courseName='Physics',
                         cohortName="G1",
                         enrollmentStartDate='08 Oct 2021',
                         enrollmentStartTime="00:00",
                         enrollmentEndDate="28 Oct 1998",
                         enrollmentEndTime="23:59",
                         cohortStartDate="01 Nov 1998",
                         cohortStartTime="08:00",
                         cohortEndDate="30 Nov 1998",
                         cohortEndTime="20:00",
                         trainerName="Charles",
                         cohortSize=30,
                         slotLeft=25)

        db.session.add(cohort3)
        response = self.client.get("/viewAllCohort/Law",
                                   content_type='application/json')
        #empty white interface
        self.assertEqual(response.json, {'code': 200, 'cohorts': []})
        


# Shi ting
class TestProcessRequest(TestApp):
    def test_process_request(self):
        # add data to course
        course1 = course(courseName="Big questions", courseImage="images/course_4.jpg",
                         courseDescription="This course introduces learners to the biggest questions in life", prerequisite="Finance and accounting")

        # add cohort into course
        cohort1 = cohort(courseName='Big questions',
                         cohortName="G1",
                         enrollmentStartDate="01 Sep 2021",
                         enrollmentStartTime="00:00",
                         enrollmentEndDate="28 Nov 2021",
                         enrollmentEndTime="23:59",
                         cohortStartDate="01 Dec 2021",
                         cohortStartTime="08:00",
                         cohortEndDate="30 Dec 2021",
                         cohortEndTime="20:00",
                         trainerName="Marcus",
                         cohortSize=30,
                         slotLeft=25)

        # add data the enrollment request
        enrollmentRequest1 = enrollmentRequest(
            courseNameRequest="Big questions", cohortNameRequest="G1", learnerName="Shakira")

        db.session.add(course1)
        db.session.add(cohort1)
        db.session.add(enrollmentRequest1)
        db.session.commit()

        # add data to materials
        material1 = materials(
            courseName="Big questions",
            cohortName="G1",
            chapterID=1,
            materialID=1,
            materialURL="abcd"
        )

        material2 = materials(
            courseName="Big questions",
            cohortName="G1",
            chapterID=2,
            materialID=1,
            materialURL="abcde"
        )

        db.session.add(material1)
        db.session.add(material2)

        db.session.commit()

        # send process request
        response = self.client.get("/processRequest/Shakira/Big questions/G1",
                                   content_type='application/json')

        # retrieve enrollment information
        result = enrollment.query.filter_by(
            employeeName="Shakira", courseNameEnrolled="Big questions", cohortNameEnrolled="G1").first()

        # check if courseNameEnrolled and cohortNameEnrolled matches
        self.assertEqual(result.get_enrollment_info(), {
            "courseNameEnrolled": "Big questions",
            "cohortNameEnrolled": "G1",
        })

        # check if name matches
        self.assertEqual(result.get_employeeName(), "Shakira")

        # check update of materialStatus
        materialStatus_result = materialStatus.query.filter_by(
            courseName="Big questions", cohortName="G1", chapterID=1, materialID=1, employeeName='Shakira').first()

        # check
        self.assertEqual(materialStatus_result.get_dict(), {
                         'courseName': 'Big questions', 'cohortName': 'G1', 'chapterID': 1, 'materialID': 1, 'employeeName': 'Shakira', 'done': 0})

        # check update of materialStatus
        materialStatus_result = materialStatus.query.filter_by(
            courseName="Big questions", cohortName="G1", chapterID=2, materialID=1, employeeName='Shakira').first()

        # check
        self.assertEqual(materialStatus_result.get_dict(), {
                         'courseName': 'Big questions', 'cohortName': 'G1', 'chapterID': 2, 'materialID': 1, 'employeeName': 'Shakira', 'done': 0})

#added done
    def test_process_request_does_not_exist(self):
  
        response = self.client.get("/processRequest/lisa/Introduction to python/G1",
                                   content_type='application/json')
        
        self.assertEqual(response.json, {'code': 404, 'message': 'Enrollment request does not exist.'})


# Shi ting
class TestDeleteRequest(TestApp):
    def test_delete_request(self):
        # add data to course
        course1 = course(courseName="Big questions", courseImage="images/course_4.jpg",
                         courseDescription="This course introduces learners to the biggest questions in life", prerequisite="Finance and accounting")

        # add cohort into course
        cohort1 = cohort(courseName='Big questions',
                         cohortName="G1",
                         enrollmentStartDate="01 Sep 2021",
                         enrollmentStartTime="00:00",
                         enrollmentEndDate="28 Nov 2021",
                         enrollmentEndTime="23:59",
                         cohortStartDate="01 Dec 2021",
                         cohortStartTime="08:00",
                         cohortEndDate="30 Dec 2021",
                         cohortEndTime="20:00",
                         trainerName="Marcus",
                         cohortSize=30,
                         slotLeft=25)

        # add data the enrollment request
        enrollmentRequest1 = enrollmentRequest(
            courseNameRequest="Big questions", cohortNameRequest="G1", learnerName="Shakira")

        db.session.add(course1)
        db.session.add(cohort1)
        db.session.add(enrollmentRequest1)
        db.session.commit()

        # send delete request
        response = self.client.get("/delete/Shakira/Big questions/G1",
                                   content_type='application/json')

        # check if request is deleted
        result = enrollmentRequest.query.filter_by(
            courseNameRequest="Big questions", cohortNameRequest="G1", learnerName="Shakira").first()

        self.assertEqual(result, None)

#added done
    def test_failed_delete_non_existence(self):
      # add data to course
        course1 = course(courseName="Big questions", courseImage="images/course_4.jpg",
                         courseDescription="This course introduces learners to the biggest questions in life", prerequisite="Finance and accounting")

        # add cohort into course
        cohort1 = cohort(courseName='Big questions',
                         cohortName="G1",
                         enrollmentStartDate="01 Sep 2021",
                         enrollmentStartTime="00:00",
                         enrollmentEndDate="28 Nov 2021",
                         enrollmentEndTime="23:59",
                         cohortStartDate="01 Dec 2021",
                         cohortStartTime="08:00",
                         cohortEndDate="30 Dec 2021",
                         cohortEndTime="20:00",
                         trainerName="Marcus",
                         cohortSize=30,
                         slotLeft=25)

        # add data the enrollment request
        enrollmentRequest1 = enrollmentRequest(
            courseNameRequest="Big questions", cohortNameRequest="G1", learnerName="Shakira")

        db.session.add(course1)
        db.session.add(cohort1)
        db.session.add(enrollmentRequest1)
        db.session.commit()

        response = self.client.get("/delete/shakira/big question/g2",
                                   content_type='application/json')
        
        self.assertEqual(response.json, {'code': 404, 'message': 'Enrollment request does not exist'})


# Shi ting
class TestSendEnrollRequest(TestApp):
    def test_send_enroll_request(self):
        response = self.client.get("/self_enrol_request/Big questions/G1/Shakira",
                content_type='application/json')
       # check for enrollment request
        result = enrollmentRequest.query.filter_by(
            courseNameRequest="Big questions", cohortNameRequest="G1", learnerName="Shakira").first()
        self.assertEqual(result.get_dict(), {
            "courseNameRequest": "Big questions",
            "cohortNameRequest": "G1",
            "learnerName": "Shakira"
        })

#added done
    def test_send_enroll_failedrequest(self):
        response = self.client.get("/self_enrol_request/Big questions/G1/shathees",
                content_type='application/json')
       # check for enrollment request
        result = enrollmentRequest.query.filter_by(
            courseNameRequest="Big questions", cohortNameRequest="G1", learnerName="Sarah").first()
        self.assertEqual(result, None )

# Shi ting
class TestViewAllBadges(TestApp):
    def test_view_all_badges(self):
        # add badges to database
        badges1 = badges(employeeName="Alice",
                         badges="Introduction to life", cohortName="G0")
        badges2 = badges(employeeName="Alice",
                         badges="Introduction to python", cohortName="G0")
        badges3 = badges(employeeName="Alice",
                         badges="Introduction to HTML", cohortName="G0")

        db.session.add(badges1)
        db.session.add(badges2)
        db.session.add(badges3)

        db.session.commit()

        # send view all badges request
        response = self.client.get("/viewAllBadges/Alice",
                                   content_type='application/json')

        self.assertEqual(response.json, {
            "badges": ["Introduction to HTML", "Introduction to life", "Introduction to python"],
            "code": 200
        })

#added done
    def test_view_all_badges_empty_badges(self):
      
        # add badges to database
        badges1 = badges(employeeName="Alice",
                         badges="Introduction to life", cohortName="G0")
        badges2 = badges(employeeName="Alice",
                         badges="Introduction to python", cohortName="G0")
        badges3 = badges(employeeName="Alice",
                         badges="Introduction to HTML", cohortName="G0")

        db.session.add(badges1)
        db.session.add(badges2)
        db.session.add(badges3)

        db.session.commit()

        response = self.client.get("/viewAllBadges/James",
                                   content_type='application/json')

        self.assertEqual(response.json, {
           'badges': [], 'code': 200
        })


# Marcus
# Assumption, all employeeName are valid employees
class TestViewBadgesCohort(TestApp):
    def test_viewBadgesCohort(self):
        # add badges to database
        badges1 = badges(employeeName="Alice",
                         badges="Introduction to life", cohortName="G0")
        badges2 = badges(employeeName="Alice",
                         badges="Introduction to python", cohortName="G0")
        badges3 = badges(employeeName="Alice",
                         badges="Introduction to HTML", cohortName="G0")

        db.session.add(badges1)
        db.session.add(badges2)
        db.session.add(badges3)

        db.session.commit()

        # send view all badges request
        response = self.client.get("/viewBadgesCohort/Alice",
                                   content_type='application/json')

        self.assertEqual(response.json, {
            "badges_cohort": [{
                "badges": "Introduction to HTML",
                "cohortName": "G0"
            }, {
                "badges": "Introduction to life",
                "cohortName": "G0"
            }, {
                "badges": "Introduction to python",
                "cohortName": "G0"
            }],
            "code": 200
        })
        
    def test_viewBadgesCohort_no_enrolled_courses(self):
        badges1 = badges(employeeName="Alice",
                         badges="Introduction to life", cohortName="G0")
        badges2 = badges(employeeName="Alice",
                         badges="Introduction to python", cohortName="G0")

        db.session.add(badges1)
        db.session.add(badges2)

        db.session.commit()
        
        # send view all badges request
        response = self.client.get("/viewBadgesCohort/Marcus",
                                   content_type='application/json')
        
        self.assertEqual(response.json, {'badges_cohort': [], 'code': 200})

# Marcus Goh
# Assumption, all employeeName are valid employees
class TestViewAllEnrolledCourses(TestApp):
    def test_viewAllEnrolledCourses(self):
        # add cohort into database
        cohort1 = cohort(courseName='Introduction to life',
                         cohortName="G1",
                         enrollmentStartDate="01 Sep 2021",
                         enrollmentStartTime="00:00",
                         enrollmentEndDate="28 Nov 2021",
                         enrollmentEndTime="23:59",
                         cohortStartDate="01 Dec 2021",
                         cohortStartTime="08:00",
                         cohortEndDate="30 Dec 2021",
                         cohortEndTime="20:00",
                         trainerName="Marcus",
                         cohortSize=30,
                         slotLeft=25)

        cohort2 = cohort(courseName='Introduction to flask',
                         cohortName="G1",
                         enrollmentStartDate="01 Sep 2021",
                         enrollmentStartTime="00:00",
                         enrollmentEndDate="28 Nov 2021",
                         enrollmentEndTime="23:59",
                         cohortStartDate="01 Dec 2021",
                         cohortStartTime="08:00",
                         cohortEndDate="30 Dec 2021",
                         cohortEndTime="20:00",
                         trainerName="Marcus",
                         cohortSize=30,
                         slotLeft=25)

        cohort3 = cohort(courseName='Introduction to python',
                         cohortName="G1",
                         enrollmentStartDate="01 Sep 2021",
                         enrollmentStartTime="00:00",
                         enrollmentEndDate="28 Nov 2021",
                         enrollmentEndTime="23:59",
                         cohortStartDate="01 Dec 2021",
                         cohortStartTime="08:00",
                         cohortEndDate="30 Dec 2021",
                         cohortEndTime="20:00",
                         trainerName="Marcus",
                         cohortSize=30,
                         slotLeft=25)

        db.session.add(cohort1)
        db.session.add(cohort2)
        db.session.add(cohort3)

        # add enrolled course to database
        enrollment1 = enrollment(
            employeeName="Alice", courseNameEnrolled="Introduction to life", cohortNameEnrolled="G1", recent=1)
        enrollment2 = enrollment(
            employeeName="Alice", courseNameEnrolled="Introduction to flask", cohortNameEnrolled="G1", recent=1)
        enrollment3 = enrollment(
            employeeName="Alice", courseNameEnrolled="Introduction to python", cohortNameEnrolled="G1", recent=1)

        db.session.add(enrollment1)
        db.session.add(enrollment2)
        db.session.add(enrollment3)

        db.session.commit()

        # send view all enrolled courses request
        response = self.client.get("/viewAllEnrolledCourses/Alice",
                                   content_type='application/json')

        self.assertEqual(response.json, {
            "code": 200,
            "enrollments": [{
                "cohortEndDate": "30 Dec 2021",
                "cohortEndTime": "20:00",
                "cohortName": "G1",
                "cohortSize": 30,
                "cohortStartDate": "01 Dec 2021",
                "cohortStartTime": "08:00",
                "courseName": "Introduction to flask",
                "slotLeft": 25,
                "trainerName": "Marcus"
            }, {
                "cohortEndDate": "30 Dec 2021",
                "cohortEndTime": "20:00",
                "cohortName": "G1",
                "cohortSize": 30,
                "cohortStartDate": "01 Dec 2021",
                "cohortStartTime": "08:00",
                "courseName": "Introduction to life",
                "slotLeft": 25,
                "trainerName": "Marcus"
            }, {
                "cohortEndDate": "30 Dec 2021",
                "cohortEndTime": "20:00",
                "cohortName": "G1",
                "cohortSize": 30,
                "cohortStartDate": "01 Dec 2021",
                "cohortStartTime": "08:00",
                "courseName": "Introduction to python",
                "slotLeft": 25,
                "trainerName": "Marcus"
            }]
        })
    
    def test_viewAllEnrolledCourses_no_enrolled_courses(self):
        response = self.client.get("/viewAllEnrolledCourses/Alice",
                                   content_type='application/json')
        
        self.assertEqual(response.json, {'code': 200, 'enrollments': []})

# Marcus Goh
# Assumption, all employeeName are valid employees
class TestViewAllRequests(TestApp):
    def test_viewAllRequests(self):
        # add cohort into database
        cohort1 = cohort(courseName='Introduction to python',
                         cohortName="G1",
                         enrollmentStartDate="01 Sep 2021",
                         enrollmentStartTime="00:00",
                         enrollmentEndDate="28 Nov 2021",
                         enrollmentEndTime="23:59",
                         cohortStartDate="01 Dec 2021",
                         cohortStartTime="08:00",
                         cohortEndDate="30 Dec 2021",
                         cohortEndTime="20:00",
                         trainerName="Marcus",
                         cohortSize=30,
                         slotLeft=25)

        # add enrollment request to database
        enrollmentRequest1 = enrollmentRequest(
            courseNameRequest="Introduction to python", cohortNameRequest="G1", learnerName="Shakira")

        db.session.add(cohort1)
        db.session.add(enrollmentRequest1)

        db.session.commit()

        # send view all enrollment requests request
        response = self.client.get("/viewAllRequests/Shakira",
                                   content_type='application/json')

        self.assertEqual(response.json, {
            "code": 200,
            "requests": [{
                "cohortEndDate": "30 Dec 2021",
                "cohortEndTime": "20:00",
                "cohortName": "G1",
                "cohortSize": 30,
                "cohortStartDate": "01 Dec 2021",
                "cohortStartTime": "08:00",
                "courseName": "Introduction to python",
                "enrollmentEndDate": "28 Nov 2021",
                "enrollmentEndTime": "23:59",
                "enrollmentStartDate": "01 Sep 2021",
                "enrollmentStartTime": "00:00",
                "slotLeft": 25,
                "trainerName": "Marcus"
            }]
        })
        
    def test_viewAllRequests_no_requests(self):
        response = self.client.get("/viewAllRequests/Shakira",
                                   content_type='application/json')
        
        self.assertEqual(response.json, {'code': 200, 'requests': []})
        
    def test_viewAllRequests_multiple_requests(self):
        # add cohort into database
        cohort1 = cohort(courseName='Introduction to python',
                         cohortName="G1",
                         enrollmentStartDate="01 Sep 2021",
                         enrollmentStartTime="00:00",
                         enrollmentEndDate="28 Nov 2021",
                         enrollmentEndTime="23:59",
                         cohortStartDate="01 Dec 2021",
                         cohortStartTime="08:00",
                         cohortEndDate="30 Dec 2021",
                         cohortEndTime="20:00",
                         trainerName="Marcus",
                         cohortSize=30,
                         slotLeft=25)

        cohort2 = cohort(courseName='Introduction to flask',
                         cohortName="G1",
                         enrollmentStartDate="01 Sep 2021",
                         enrollmentStartTime="00:00",
                         enrollmentEndDate="28 Nov 2021",
                         enrollmentEndTime="23:59",
                         cohortStartDate="01 Dec 2021",
                         cohortStartTime="08:00",
                         cohortEndDate="30 Dec 2021",
                         cohortEndTime="20:00",
                         trainerName="Charles",
                         cohortSize=30,
                         slotLeft=24)
        
        # add enrollment request to database
        enrollmentRequest1 = enrollmentRequest(
            courseNameRequest="Introduction to python", cohortNameRequest="G1", learnerName="Shakira")

        enrollmentRequest2 = enrollmentRequest(
            courseNameRequest="Introduction to flask", cohortNameRequest="G1", learnerName="Shakira")

        db.session.add(cohort1)
        db.session.add(cohort2)
        db.session.add(enrollmentRequest1)
        db.session.add(enrollmentRequest2)

        db.session.commit()

        # send view all enrollment requests request
        response = self.client.get("/viewAllRequests/Shakira",
                                   content_type='application/json')

        self.assertTrue({
                "cohortEndDate": "30 Dec 2021",
                "cohortEndTime": "20:00",
                "cohortName": "G1",
                "cohortSize": 30,
                "cohortStartDate": "01 Dec 2021",
                "cohortStartTime": "08:00",
                "courseName": "Introduction to python",
                "enrollmentEndDate": "28 Nov 2021",
                "enrollmentEndTime": "23:59",
                "enrollmentStartDate": "01 Sep 2021",
                "enrollmentStartTime": "00:00",
                "slotLeft": 25,
                "trainerName": "Marcus"
            } in response.json['requests'])
        
        self.assertTrue({
            'cohortEndDate': '30 Dec 2021',
            'cohortEndTime': '20:00',
            'cohortName': 'G1',
            'cohortSize': 30,
            'cohortStartDate': '01 Dec 2021',
            'cohortStartTime': '08:00',
            'courseName': 'Introduction to flask',
            'enrollmentEndDate': '28 Nov 2021',
            'enrollmentEndTime': '23:59',
            'enrollmentStartDate': '01 Sep 2021',
            'enrollmentStartTime': '00:00',
            'slotLeft': 24,
            'trainerName': 'Charles'
            } in response.json['requests'])

# Marcus Goh
class TestAdminViewAllRequests(TestApp):
    def test_adminViewAllRequests(self):
        # add cohort into database
        cohort1 = cohort(courseName='Introduction to python',
                         cohortName="G1",
                         enrollmentStartDate="01 Sep 2021",
                         enrollmentStartTime="00:00",
                         enrollmentEndDate="28 Nov 2021",
                         enrollmentEndTime="23:59",
                         cohortStartDate="01 Dec 2021",
                         cohortStartTime="08:00",
                         cohortEndDate="30 Dec 2021",
                         cohortEndTime="20:00",
                         trainerName="Marcus",
                         cohortSize=30,
                         slotLeft=25)

        cohort2 = cohort(courseName='Introduction to flask',
                         cohortName="G1",
                         enrollmentStartDate="01 Sep 2021",
                         enrollmentStartTime="00:00",
                         enrollmentEndDate="28 Nov 2021",
                         enrollmentEndTime="23:59",
                         cohortStartDate="01 Dec 2021",
                         cohortStartTime="08:00",
                         cohortEndDate="30 Dec 2021",
                         cohortEndTime="20:00",
                         trainerName="Vera",
                         cohortSize=30,
                         slotLeft=25)

        # add enrollment request to database
        enrollmentRequest1 = enrollmentRequest(
            courseNameRequest="Introduction to python", cohortNameRequest="G1", learnerName="Shakira")
        enrollmentRequest2 = enrollmentRequest(
            courseNameRequest="Introduction to flask", cohortNameRequest="G1", learnerName="Jacob")

        db.session.add(cohort1)
        db.session.add(cohort2)
        db.session.add(enrollmentRequest1)
        db.session.add(enrollmentRequest2)

        db.session.commit()

        # send view all enrollment requests request
        response = self.client.get("/adminViewAllRequests",
                                   content_type='application/json')

        self.assertEqual(response.json, {
            "code": 200,
            "requests": {
                "Introduction to flask": [{
                    "cohortEndDate": "30 Dec 2021",
                    "cohortEndTime": "20:00",
                    "cohortName": "G1",
                    "cohortSize": 30,
                    "cohortStartDate": "01 Dec 2021",
                    "cohortStartTime": "08:00",
                    "courseName": "Introduction to flask",
                    "enrollmentEndDate": "28 Nov 2021",
                    "enrollmentEndTime": "23:59",
                    "enrollmentStartDate": "01 Sep 2021",
                    "enrollmentStartTime": "00:00",
                    "learnerName": "Jacob",
                    "slotLeft": 25,
                    "trainerName": "Vera"
                }],
                "Introduction to python": [{
                    "cohortEndDate": "30 Dec 2021",
                    "cohortEndTime": "20:00",
                    "cohortName": "G1",
                    "cohortSize": 30,
                    "cohortStartDate": "01 Dec 2021",
                    "cohortStartTime": "08:00",
                    "courseName": "Introduction to python",
                    "enrollmentEndDate": "28 Nov 2021",
                    "enrollmentEndTime": "23:59",
                    "enrollmentStartDate": "01 Sep 2021",
                    "enrollmentStartTime": "00:00",
                    "learnerName": "Shakira",
                    "slotLeft": 25,
                    "trainerName": "Marcus"
                }]
            }
        })

    def test_adminViewAllRequests_multiple_requests_under_one_course(self):
        # add cohort into database
        cohort1 = cohort(courseName='Introduction to python',
                         cohortName="G1",
                         enrollmentStartDate="01 Sep 2021",
                         enrollmentStartTime="00:00",
                         enrollmentEndDate="28 Nov 2021",
                         enrollmentEndTime="23:59",
                         cohortStartDate="01 Dec 2021",
                         cohortStartTime="08:00",
                         cohortEndDate="30 Dec 2021",
                         cohortEndTime="20:00",
                         trainerName="Marcus",
                         cohortSize=30,
                         slotLeft=25)

        # add enrollment request to database
        enrollmentRequest1 = enrollmentRequest(
            courseNameRequest="Introduction to python", cohortNameRequest="G1", learnerName="Shakira")
        enrollmentRequest2 = enrollmentRequest(
            courseNameRequest="Introduction to python", cohortNameRequest="G1", learnerName="Jacob")
        
        db.session.add(cohort1)
        db.session.add(enrollmentRequest1)
        db.session.add(enrollmentRequest2)

        db.session.commit()

        # send view all enrollment requests request
        response = self.client.get("/adminViewAllRequests",
                                   content_type='application/json')
        
        # check for first request
        self.assertTrue({
            "cohortEndDate": "30 Dec 2021",
            "cohortEndTime": "20:00",
            "cohortName": "G1",
            "cohortSize": 30,
            "cohortStartDate": "01 Dec 2021",
            "cohortStartTime": "08:00",
            "courseName": "Introduction to python",
            "enrollmentEndDate": "28 Nov 2021",
            "enrollmentEndTime": "23:59",
            "enrollmentStartDate": "01 Sep 2021",
            "enrollmentStartTime": "00:00",
            "learnerName": "Shakira",
            "slotLeft": 25,
            "trainerName": "Marcus"
        } in response.json['requests']['Introduction to python'])

        # check for second request
        self.assertTrue({
            "cohortEndDate": "30 Dec 2021",
            "cohortEndTime": "20:00",
            "cohortName": "G1",
            "cohortSize": 30,
            "cohortStartDate": "01 Dec 2021",
            "cohortStartTime": "08:00",
            "courseName": "Introduction to python",
            "enrollmentEndDate": "28 Nov 2021",
            "enrollmentEndTime": "23:59",
            "enrollmentStartDate": "01 Sep 2021",
            "enrollmentStartTime": "00:00",
            "learnerName": "Jacob",
            "slotLeft": 25,
            "trainerName": "Marcus"
        } in response.json['requests']['Introduction to python'])
        
    def test_adminViewAllRequests_no_requests(self):
        # send view all enrollment requests request
        response = self.client.get("/adminViewAllRequests",
                                   content_type='application/json')
        
        # check for empty requests dictionary
        self.assertEqual(response.json, {'code': 200, 'requests': {}})

if __name__ == '__main__':
    unittest.main()
