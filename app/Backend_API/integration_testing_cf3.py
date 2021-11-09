import unittest
import flask_testing
import json
from app import app, db, badges, enrollment, chapter, question, options, materials, materialStatus, userAttempt

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

# Shathees
# Assumption 1; employee is enrolled to specified course and cohort
# Assumption 2; materialstatus is filled for all learning materials
# Notes; 
# quizStatus == 1: quiz attempted 
# quizStatus == 2: learning materials for chapter not completed
# quizStatus == 0: learning materials for chapter completed and quiz not yet attempted
# chapterID = -1: last chapter with no learning materials; meant for graded quiz  
class TestViewMaterials(TestApp):
    def test_view_materials(self):
        # chapter
        chapter1 = chapter(
            courseName="Introduction to life",
            cohortName="G1",
            chapterID=1,
            duration=30,
            graded=0
        )

        chapter2 = chapter(
            courseName="Introduction to life",
            cohortName="G1",
            chapterID=2,
            duration=30,
            graded=0
        )

        chapter3 = chapter(
            courseName="Introduction to life",
            cohortName="G1",
            chapterID=-1,
            duration=60,
            graded=0
        )

        # materials
        material1 = materials(
            courseName="Introduction to life",
            cohortName="G1",
            chapterID=1,
            materialID=1,
            materialURL= "url_1"
        )
        
        material2 = materials(
            courseName="Introduction to life",
            cohortName="G1",
            chapterID=1,
            materialID=2,
            materialURL= "url_2"
        )

        material3 = materials(
            courseName="Introduction to life",
            cohortName="G1",
            chapterID=2,
            materialID=1,
            materialURL= "url_3"
        )

        # materialStatus
        materialStatus1 = materialStatus(
            courseName="Introduction to life",
            cohortName="G1",
            chapterID=1,
            materialID=1,
            employeeName='Bob',
            done = 1
        )

        materialStatus2 = materialStatus(
            courseName="Introduction to life",
            cohortName="G1",
            chapterID=1,
            materialID=2,
            employeeName='Bob',
            done = 1
        )

        materialStatus3 = materialStatus(
            courseName="Introduction to life",
            cohortName="G1",
            chapterID=2,
            materialID=1,
            employeeName='Bob',
            done = 0
        )

        userAttempt1 = userAttempt(
            employeeName = "Bob",
            courseName="Introduction to life",
            cohortName="G1",
            chapterID= 1,
            questionID= 1,
            choiceID= 1,
            marks = 1
        )
          
        # commit to database
        
        db.session.add(chapter1)
        db.session.add(chapter2)
        db.session.add(chapter3)
        db.session.add(material1)
        db.session.add(material2)
        db.session.add(material3)
        db.session.add(materialStatus1)
        db.session.add(materialStatus2)    
        db.session.add(materialStatus3)    
        db.session.add(userAttempt1)

        db.session.commit()

        # call the route
        response = self.client.get("/viewMaterials/Introduction to life/G1/Bob",
                            content_type='application/json')

        self.assertEqual(response.json, {
            "code": 200,
            "materials": [{
                "chapterID": 1,
                "materials": [{
                    "done": 1,
                    "materialID": 1,
                    "materialURL": "url_1"
                }, {
                    "done": 1,
                    "materialID": 2,
                    "materialURL": "url_2"
                }],
                "quizStatus": 1
            }, {
                "chapterID": 2,
                "materials": [{
                    "done": 0,
                    "materialID": 1,
                    "materialURL": "url_3"
                }],
                "quizStatus": 2
            }, {
                "chapterID": -1,
                "materials": [],
                "quizStatus": 0
            }]
        })

# Shathees
# Note1: update material status only checks the learning material. Learning material cannot be unchecked.
# Note2: update material status only checks one learning material at a time.
# Assumption 1; employee is enrolled to specified course and cohort
# Assumption 2; materialstatus is filled for all learning materials
class TestUpdateMaterial(TestApp):
    def test_update_material_status(self):
        # add material status
        materialStatus1 = materialStatus(
            courseName="Introduction to life",
            cohortName="G1",
            chapterID=1,
            materialID=1,
            employeeName='Bob',
            done = 0
        )

        db.session.add(materialStatus1)
        db.session.commit()

        # update material status
        response = self.client.get("/updateMaterialStatus/Introduction to life/G1/1/1/Bob",
                            content_type='application/json')
        
        # check material status
        materialStatusResult = materialStatus.query.filter_by(courseName="Introduction to life", cohortName="G1", chapterID=1, materialID=1, employeeName="Bob").first()
        self.assertEqual(materialStatusResult.get_status(), 1)

# Shathees
# Assumption1: employee is currently enrolled into specifed course and cohort
# Assumption2: employee has yet to complete specified course and cohort
class TestCompletedCourse(TestApp):
    def test_completed_course(self):
        # add data into enrollment
        
        enrollmentRes1 = enrollment(employeeName="Alice", courseNameEnrolled="Introduction to life", cohortNameEnrolled="G0", recent=3)

        db.session.add(enrollmentRes1)
        db.session.commit()

        # send reqeust
        response = self.client.get("/completedCourse/Introduction to life/G0/Alice",
                            content_type='application/json')

        # check if badge exists in badges
        badge_result = badges.query.filter_by(employeeName="Alice", badges="Introduction to life", cohortName="G0").first()
        badge = badge_result.get_badges()
        self.assertEqual(badge, "Introduction to life")

# Shathees
# note1: only latest userattempt is stored
class TestRecordAttempt(TestApp):
    def test_record_first_attempt(self):
        # post request
        request_body = {
            'employeeName': "Bob",
            "courseName": "Introduction to life", 
            "cohortName": "G0",
            "chapterID": 1,
            "questions_list": [{
                "questionID" : 1,
                "choiceID" : 1 
                },
                {
                "questionID" : 2,
                "choiceID" : 2    
                }
            ]
        }

        response = self.client.post("/recordAttempt",
                                data=json.dumps(request_body),
                                content_type='application/json')
                                
        # retrieve and check userattempt 1 
        user_attempt_result1 = userAttempt.query.filter_by(employeeName="Bob", courseName="Introduction to life", cohortName="G0", chapterID=1, questionID=1).first()
        self.assertEqual(user_attempt_result1.get_dict(), {
            "employeeName": "Bob",
            "courseName": "Introduction to life",
            "cohortName": "G0",
            "chapterID": 1,
            "questionID": 1,
            "choiceID": 1,
            "marks": 1
        })    
        
        # retrieve and check userattempt 2
        user_attempt_result2 = userAttempt.query.filter_by(employeeName="Bob", courseName="Introduction to life", cohortName="G0", chapterID=1, questionID=2).first()
        self.assertEqual(user_attempt_result2.get_dict(), {
            "employeeName": "Bob",
            "courseName": "Introduction to life",
            "cohortName": "G0",
            "chapterID": 1,
            "questionID": 2,
            "choiceID": 2,
            "marks": 1
        })
    
    # Re-attempt chapterID = 1 quiz
    # Attempted chapterID = 2 quiz
    def test_record_attempt_second_attempt(self):
        # create pre-existing attempt
        userAttempt1 = userAttempt(
            employeeName = "Bob",
            courseName="Introduction to life",
            cohortName="G0",
            chapterID= 1,
            questionID= 1,
            choiceID= 2,
            marks = 1
        )
        
        userAttempt2 = userAttempt(
            employeeName = "Bob",
            courseName="Introduction to life",
            cohortName="G0",
            chapterID= 1,
            questionID= 2,
            choiceID= 1,
            marks = 1
        )
        
        userAttempt3 = userAttempt(
            employeeName = "Bob",
            courseName="Introduction to life",
            cohortName="G0",
            chapterID= 2,
            questionID= 1,
            choiceID= 1,
            marks = 1
        )
        
        db.session.add(userAttempt1)
        db.session.add(userAttempt2)
        db.session.add(userAttempt3)
        db.session.commit()

        # post request
        request_body = {
            'employeeName': "Bob",
            "courseName": "Introduction to life", 
            "cohortName": "G0",
            "chapterID": 1,
            "questions_list": [{
                "questionID" : 1,
                "choiceID" : 1 
                },
                {
                "questionID" : 2,
                "choiceID" : 2    
                }
            ]
        }

        response = self.client.post("/recordAttempt",
                                data=json.dumps(request_body),
                                content_type='application/json')
                                
        # retrieve and check userattempt 1 
        user_attempt_result1 = userAttempt.query.filter_by(employeeName="Bob", courseName="Introduction to life", cohortName="G0", chapterID=1, questionID=1).first()
        self.assertEqual(user_attempt_result1.get_dict(), {
            "employeeName": "Bob",
            "courseName": "Introduction to life",
            "cohortName": "G0",
            "chapterID": 1,
            "questionID": 1,
            "choiceID": 1,
            "marks": 1
        })    
        
        # retrieve and check userattempt 2
        user_attempt_result2 = userAttempt.query.filter_by(employeeName="Bob", courseName="Introduction to life", cohortName="G0", chapterID=1, questionID=2).first()
        self.assertEqual(user_attempt_result2.get_dict(), {
            "employeeName": "Bob",
            "courseName": "Introduction to life",
            "cohortName": "G0",
            "chapterID": 1,
            "questionID": 2,
            "choiceID": 2,
            "marks": 1
        })
        
        # check if userattempt3 still exists
        user_attempt_result3 = userAttempt.query.filter_by(employeeName="Bob", courseName="Introduction to life", cohortName="G0", chapterID=2, questionID=1).first()
        self.assertEqual(user_attempt_result3.get_dict(), {
            "employeeName": "Bob",
            "courseName": "Introduction to life",
            "cohortName": "G0",
            "chapterID": 2,
            "questionID": 1,
            "choiceID": 1,
            "marks": 1
        })

# Marcus Goh
# Assumption 1; user has attempted to quiz (userAttempt database filled)
# Note 1; pass >= 85%
class TestRetrieveQuizResult(TestApp):
    def test_retreieve_quiz_result_fail(self):
        # add data into user attempt
        userAttempt1 = userAttempt(
            employeeName = "Bob",
            courseName="Introduction to life",
            cohortName="G1",
            chapterID= 1,
            questionID= 1,
            choiceID= 2,
            marks = 1
        )
        
        userAttempt2 = userAttempt(
            employeeName = "Bob",
            courseName="Introduction to life",
            cohortName="G1",
            chapterID= 1,
            questionID= 2,
            choiceID= 1,
            marks = 1
        )
        
        # add data into chapter
        chapter1 = chapter(
            courseName="Introduction to life",
            cohortName="G1",
            chapterID=1,
            duration=30,
            graded=0
        )

        # add data into questions
        question1 = question(
                courseName="Introduction to life",
                cohortName="G1",
                chapterID=1 ,
                questionID= 1,
                questionText= "The concept of “the meaning of life” is, in common usage, vague and slippery."
                
        )

        question2 = question(
                courseName="Introduction to life",
                cohortName="G1",
                chapterID=1 ,
                questionID= 2,
                questionText= "How many apples he eat?"
                
        )

        # add data into options
        option1 = options(
            courseName="Introduction to life",
            cohortName="G1",
            chapterID=1,
            questionID=1,
            optionID=1,
            optionText="True",
            isRight=1
        )

        option2 = options(
            courseName="Introduction to life",
            cohortName="G1",
            chapterID=1,
            questionID=1,
            optionID=2,
            optionText="False",
            isRight=0
        )

        option3 = options(
            courseName="Introduction to life",
            cohortName="G1",
            chapterID=1,
            questionID=2,
            optionID=1,
            optionText="1",
            isRight=1
        )

        option4 = options(
            courseName="Introduction to life",
            cohortName="G1",
            chapterID=1,
            questionID=2,
            optionID=2,
            optionText="2",
            isRight=0
        )

        db.session.add(userAttempt1)
        db.session.add(userAttempt2)
        db.session.add(chapter1)
        db.session.add(question1)
        db.session.add(question2)
        db.session.add(option1)
        db.session.add(option2)
        db.session.add(option3)
        db.session.add(option4)

        db.session.commit()

        # request
        
        response = self.client.get("/retrieveQuizResult/Introduction to life/G1/1/Bob",
                                content_type='application/json')
                                
        # check
        self.assertEqual(response.json, {
            "code": 200,
            "quiz_result": {
                "chapterID": 1,
                "cohortName": "G1",
                "courseName": "Introduction to life",
                "duration": 30,
                "graded": 0,
                "marks": 1,
                "passingTrue": 0,
                "questions": [{
                    "choiceID": 2,
                    "choiceRight": 0,
                    "optionsList": [{
                        "isRight": 1,
                        "optionID": 1,
                        "optionText": "True"
                    }, {
                        "isRight": 0,
                        "optionID": 2,
                        "optionText": "False"
                    }],
                    "questionID": 1,
                    "questionText": "The concept of “the meaning of life” is, in common usage, vague and slippery."
                }, {
                    "choiceID": 1,
                    "choiceRight": 1,
                    "optionsList": [{
                        "isRight": 1,
                        "optionID": 1,
                        "optionText": "1"
                    }, {
                        "isRight": 0,
                        "optionID": 2,
                        "optionText": "2"
                    }],
                    "questionID": 2,
                    "questionText": "How many apples he eat?"
                }],
                "total": 2
            }
        })


    def test_retreieve_quiz_result_pass(self):
        # add data into user attempt
        userAttempt1 = userAttempt(
            employeeName = "Bob",
            courseName="Introduction to life",
            cohortName="G1",
            chapterID= 1,
            questionID= 1,
            choiceID= 1,
            marks = 1
        )
        
        userAttempt2 = userAttempt(
            employeeName = "Bob",
            courseName="Introduction to life",
            cohortName="G1",
            chapterID= 1,
            questionID= 2,
            choiceID= 1,
            marks = 1
        )
        
        # add data into chapter
        chapter1 = chapter(
            courseName="Introduction to life",
            cohortName="G1",
            chapterID=1,
            duration=30,
            graded=0
        )

        # add data into questions
        question1 = question(
                courseName="Introduction to life",
                cohortName="G1",
                chapterID=1 ,
                questionID= 1,
                questionText= "The concept of “the meaning of life” is, in common usage, vague and slippery."
                
        )

        question2 = question(
                courseName="Introduction to life",
                cohortName="G1",
                chapterID=1 ,
                questionID= 2,
                questionText= "How many apples he eat?"
                
        )

        # add data into options
        option1 = options(
            courseName="Introduction to life",
            cohortName="G1",
            chapterID=1,
            questionID=1,
            optionID=1,
            optionText="True",
            isRight=1
        )

        option2 = options(
            courseName="Introduction to life",
            cohortName="G1",
            chapterID=1,
            questionID=1,
            optionID=2,
            optionText="False",
            isRight=0
        )

        option3 = options(
            courseName="Introduction to life",
            cohortName="G1",
            chapterID=1,
            questionID=2,
            optionID=1,
            optionText="1",
            isRight=1
        )

        option4 = options(
            courseName="Introduction to life",
            cohortName="G1",
            chapterID=1,
            questionID=2,
            optionID=2,
            optionText="2",
            isRight=0
        )

        db.session.add(userAttempt1)
        db.session.add(userAttempt2)
        db.session.add(chapter1)
        db.session.add(question1)
        db.session.add(question2)
        db.session.add(option1)
        db.session.add(option2)
        db.session.add(option3)
        db.session.add(option4)

        db.session.commit()

        # request
        
        response = self.client.get("/retrieveQuizResult/Introduction to life/G1/1/Bob",
                                content_type='application/json')
          
        # check
        self.assertEqual(response.json, {
            "code": 200,
            "quiz_result": {
                "chapterID": 1,
                "cohortName": "G1",
                "courseName": "Introduction to life",
                "duration": 30,
                "graded": 0,
                "marks": 2,
                "passingTrue": 1,
                "questions": [{
                    "choiceID": 1,
                    "choiceRight": 1,
                    "optionsList": [{
                        "isRight": 1,
                        "optionID": 1,
                        "optionText": "True"
                    }, {
                        "isRight": 0,
                        "optionID": 2,
                        "optionText": "False"
                    }],
                    "questionID": 1,
                    "questionText": "The concept of “the meaning of life” is, in common usage, vague and slippery."
                }, {
                    "choiceID": 1,
                    "choiceRight": 1,
                    "optionsList": [{
                        "isRight": 1,
                        "optionID": 1,
                        "optionText": "1"
                    }, {
                        "isRight": 0,
                        "optionID": 2,
                        "optionText": "2"
                    }],
                    "questionID": 2,
                    "questionText": "How many apples he eat?"
                }],
                "total": 2
            }
        })

    def test_retreieve_quiz_result_pass(self):
        pass
    
if __name__ == '__main__':
    unittest.main()
