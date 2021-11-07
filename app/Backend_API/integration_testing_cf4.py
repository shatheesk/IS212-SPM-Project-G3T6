import unittest
import flask_testing
import json
from app import app, db, chapter, question, options, materials


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


class TestGetAllChapters(TestApp):
    def test_getAllChapters(self):
        chapter1 = chapter(
            chapterID=-1,
            cohortName="G1",
            courseName="Introduction to life",
            duration=0,
            graded=1)

        chapter2 = chapter(
            chapterID=1,
            cohortName="G1",
            courseName="Introduction to life",
            duration=0,
            graded=0)

        # add data to materials
        material1 = materials(
            courseName="Introduction to life",
            cohortName="G1",
            chapterID=1,
            materialID=1,
            materialURL="abcd"
        )

        material2 = materials(
            courseName="Introduction to life",
            cohortName="G1",
            chapterID=1,
            materialID=2,
            materialURL="abcd"
        )

        db.session.add(material1)
        db.session.add(material2)
        db.session.add(chapter1)
        db.session.add(chapter2)
        db.session.commit()

        # run query
        response = self.client.get("/getAllChapters/Introduction to life/G1",
                                   content_type='application/json')

        # check if theres all the chapters that has been added
        self.assertEqual(response.json, {
            "chapters": [{
                "chapterID": -1,
                "cohortName": "G1",
                "courseName": "Introduction to life",
                "duration": 0,
                "graded": 1,
                "materials": []
            }, {
                "chapterID": 1,
                "cohortName": "G1",
                "courseName": "Introduction to life",
                "duration": 0,
                "graded": 0,
                "materials": [{
                    "materialID": 1,
                    "materialURL": "abcd"
                }, {
                    "materialID": 2,
                    "materialURL": "abcd"
                }]
            }],
            "code": 200
        })


class TestCreateNewChapter(TestApp):
    def test_createNewChapter(self):
        request_body = {
            "chapterID": 7,
            "cohortName": "G1",
            "courseName": "Introduction to life",
            "duration": 60,
            "graded": 0
        }

        # run query
        response = self.client.post("/createNewChapter",
                                    data=json.dumps(request_body),
                                    content_type='application/json')

        # get chapters
        chapter1 = chapter.query.filter_by(
            courseName="Introduction to life", cohortName="G1").first()

        # check if chapter is the same as request_body
        self.assertEqual(chapter1.get_dict(), {
            "chapterID": 7,
            "cohortName": "G1",
            "courseName": "Introduction to life",
            "duration": 60,
            "graded": 0
        })


class TestViewQuiz(TestApp):
    def test_viewQuiz(self):
        chapter1 = chapter(
            chapterID=-1,
            cohortName="G1",
            courseName="Introduction to life",
            duration=0,
            graded=1)

        question1 = question(
            chapterID=-1,
            cohortName="G1",
            courseName="Introduction to life",
            questionID=1,
            questionText="How are you?"
        )

        question2 = question(
            chapterID=-1,
            cohortName="G1",
            courseName="Introduction to life",
            questionID=2,
            questionText="How's your day?"
        )

        option1 = options(
            chapterID=-1,
            cohortName="G1",
            courseName="Introduction to life",
            questionID=1,
            optionID=1,
            optionText="Things are good!",
            isRight=1
        )

        option2 = options(
            chapterID=-1,
            cohortName="G1",
            courseName="Introduction to life",
            questionID=1,
            optionID=2,
            optionText="It's been a rough week.",
            isRight=0
        )
        option3 = options(
            chapterID=-1,
            cohortName="G1",
            courseName="Introduction to life",
            questionID=2,
            optionID=1,
            optionText="I've had better days.",
            isRight=0
        )
        option4 = options(
            chapterID=-1,
            cohortName="G1",
            courseName="Introduction to life",
            questionID=2,
            optionID=2,
            optionText="It's been great!",
            isRight=1
        )

        db.session.add(chapter1)
        db.session.add(question1)
        db.session.add(question2)
        db.session.add(option1)
        db.session.add(option2)
        db.session.add(option3)
        db.session.add(option4)
        db.session.commit()

        # run query
        response = self.client.get("/viewQuiz/Introduction to life/G1/-1",
                                   content_type='application/json')

        # check if quiz details same as what was added
        self.assertEqual(response.json, {
            "code": 200,
            "chapter_content": {
                "chapterID": -1,
                "cohortName": "G1",
                "courseName": "Introduction to life",
                "duration": 0,
                "graded": 1,
                "questions": [
                    {"questionID": 1,
                     "questionText": "How are you?",
                     "optionsList": [
                         {
                             "optionID": 1,
                             "optionText": "Things are good!",
                             "isRight": 1
                         },
                         {
                             "optionID": 2,
                             "optionText": "It's been a rough week.",
                             "isRight": 0
                         }
                     ]},
                    {"questionID": 2,
                     "questionText": "How's your day?",
                     "optionsList": [
                         {
                             "optionID": 1,
                             "optionText": "I've had better days.",
                             "isRight": 0
                         },
                         {
                             "optionID": 2,
                             "optionText": "It's been great!",
                             "isRight": 1
                         }
                     ]}
                ]}
        })


class TestDeleteQuiz(TestApp):
    def test_deleteQuiz(self):
        chapter1 = chapter(
            chapterID=-1,
            cohortName="G1",
            courseName="Introduction to life",
            duration=0,
            graded=1)

        question1 = question(
            chapterID=-1,
            cohortName="G1",
            courseName="Introduction to life",
            questionID=1,
            questionText="How are you?"
        )

        option1 = options(
            chapterID=-1,
            cohortName="G1",
            courseName="Introduction to life",
            questionID=1,
            optionID=1,
            optionText="Things are good!",
            isRight=1
        )

        option2 = options(
            chapterID=-1,
            cohortName="G1",
            courseName="Introduction to life",
            questionID=1,
            optionID=2,
            optionText="It's been a rough week.",
            isRight=0
        )

        db.session.add(chapter1)
        db.session.add(question1)
        db.session.add(option1)
        db.session.add(option2)
        db.session.commit()

        # run query
        response = self.client.get("/deleteQuiz/Introduction to life/G1/-1")

        # check if question is still there -- should be empty
        question_aft = question.query.filter_by(
            courseName="Introduction to life", cohortName="G1", chapterID=-1).first()
        self.assertIsNone(question_aft)

        # check if options are still there -- should be empty
        option_aft = options.query.filter_by(
            courseName="Introduction to life", cohortName="G1", chapterID=-1, questionID=1).first()
        self.assertIsNone(option_aft)

        # check if chapter is still there -- should be there
        chapter_aft = chapter.query.filter_by(
            courseName="Introduction to life", cohortName="G1").first()
        self.assertEqual(chapter_aft.get_dict(), {
            "chapterID": -1,
            "cohortName": "G1",
            "courseName": "Introduction to life",
            "duration": 0,
            "graded": 1
        })


if __name__ == '__main__':
    unittest.main()
