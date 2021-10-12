from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS

app = Flask(__name__)

app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql'\
    '+mysqlconnector://root@localhost:3306/cf1'

app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
app.config['SQLALCHEMY_ENGINE_OPTIONS'] = {'pool_recycle': 299}

db = SQLAlchemy(app)
CORS(app)


class course(db.Model):
    __tablename__ = 'course'

    courseName = db.Column(db.String(100), primary_key=True)
    courseImage = db.Column(db.String(100), nullable=False)
    courseDescription = db.Column(db.String(200), nullable=False)

    def __init__(self, courseName, courseImage, courseDescription):
        self.courseName = courseName
        self.courseImage = courseImage
        self.courseDescription = courseDescription

    def get_course_info(self):
        return {
            "courseName": self.courseName,
            "courseImage": self.courseImage,
            "courseDescription": self.courseDescription
        }


class prerequisites(db.Model):
    __tablename__ = 'prerequisites'

    courseName = db.Column(db.String(100), primary_key=True)
    prerequisite = db.Column(db.String(100), db.ForeignKey(course.courseName), nullable=False, primary_key=True)

    def __init__(self, courseName, prerequisite):
        self.courseName = courseName
        self.prerequisite = prerequisite


    def get_prerequisite(self):
        return {
            "prerequisite": self.prerequisite
        }

    def json(self):
        return {
            "courseName": self.courseName,
            "prerequisite": self.prerequisite
        }

class employee(db.Model):
    __tablename__ = 'employee'

    employeeName = db.Column(db.String(100), primary_key=True)
    userName = db.Column(db.String(100), nullable=False)
    currentDesignation = db.Column(db.String(100), nullable=False)
    department = db.Column(db.String(100), nullable=False)

    def __init__(self, employeeName, userName, currentDesignation, department):
        self.employeeName = employeeName
        self.userName = userName
        self.currentDesignation = currentDesignation
        self.department = department

    def get_designation(self):
        return {
            'currentDesignation': self.currentDesignation
        }

class cohort(db.Model):
    __tablename__ = 'cohort'

    courseName = db.Column(db.String(100), primary_key=True)
    cohortName = db.Column(db.String(100), primary_key=True)
    enrollmentStartDate = db.Column(db.String(30), nullable=False)
    enrollmentStartTime = db.Column(db.String(30), nullable=False)
    enrollmentEndDate = db.Column(db.String(30), nullable=False)
    enrollmentEndTime = db.Column(db.String(30), nullable=False)
    cohortStartDate = db.Column(db.String(30), nullable=False)
    cohortStartTime = db.Column(db.String(30), nullable=False)
    cohortEndDate = db.Column(db.String(30), nullable=False)
    cohortEndTime = db.Column(db.String(30), nullable=False)
    trainerName = db.Column(db.String(100), db.ForeignKey(employee.employeeName), nullable=False)
    cohortSize = db.Column(db.Integer, nullable=False)
    slotLeft = db.Column(db.Integer, nullable=False)

    def __init__(self, courseName, cohortName, enrollmentStartDate, enrollmentStartTime, enrollmentEndDate, enrollmentEndTime, cohortStartDate, cohortStartTime, cohortEndDate, cohortEndTime, trainerName, cohortSize, slotLeft):
        self.courseName = courseName
        self.cohortName = cohortName
        self.enrollmentStartDate = enrollmentStartDate
        self.enrollmentStartTime = enrollmentStartTime
        self.enrollmentEndDate = enrollmentEndDate
        self.enrollmentEndTime = enrollmentEndTime
        self.cohortStartDate = cohortStartDate
        self.cohortStartTime = cohortStartTime
        self.cohortEndDate = cohortEndDate
        self.cohortEndTime = cohortEndTime
        self.trainerName = trainerName
        self.cohortSize = cohortSize
        self.slotLeft = slotLeft

class badges(db.Model):
    __tablename__ = 'badges'

    employeeName = db.Column(db.String(100), primary_key=True)
    badges = db.Column(db.String(100), db.ForeignKey(cohort.courseName), nullable=False, primary_key=True)
    cohortName = db.Column(db.String(100), db.ForeignKey(cohort.cohortName),nullable=False, primary_key=True)

    def __init__(self, employeeName, badges, cohortName):
        self.employeeName = employeeName
        self.badges = badges
        self.cohortName = cohortName

    def get_badges(self):
        return {
            'badges': self.badges
        }

    def json(self):
        return {
            'EmployeeName': self.employeeName,
            'badges': self.badges,
            'cohortName': self.cohortName
        }

class enrollment(db.Model):
    __tablename__ = 'enrollment'

    employeeName = db.Column(db.String(100), primary_key=True)
    courseNameEnrolled = db.Column(db.String(100), db.ForeignKey(cohort.courseName), nullable=False, primary_key=True)
    cohortNameEnrolled = db.Column(db.String(100), db.ForeignKey(cohort.cohortName),nullable=False, primary_key=True)

    def __init__(self, employeeName, courseNameEnrolled, cohortNameEnrolled):
        self.employeeName = employeeName
        self.courseNameEnrolled = courseNameEnrolled
        self.cohortNameEnrolled = cohortNameEnrolled

class enrollmentRequest(db.Model):
    __tablename__ = 'enrollmentRequest'

    courseNameRequest = db.Column(db.String(100), db.ForeignKey(cohort.courseName), nullable=False, primary_key=True)
    cohortNameRequest = db.Column(db.String(100), db.ForeignKey(cohort.cohortName), nullable=False, primary_key=True)
    learnerName = db.Column(db.String(100), db.ForeignKey(employee.employeeName), nullable=False, primary_key=True)

    def __init__(self, courseNameRequest, cohortNameRequest, learnerName):
        self.courseNameRequest = courseNameRequest
        self.cohortNameRequest = cohortNameRequest
        self.learnerName = learnerName

@app.route("/currentDesignation/<string:employeeName>")
def getCurrentDesignation(employeeName):
    result = employee.query.filter_by(employeeName=employeeName).first()

    if result:
        return jsonify(
            {
                "code": 200,
                "data": result.get_designation()
            }
        )

    return jsonify(
        {
            "code": 404,
            "message": "EmployeeName does not exist in database"
        }
    ), 404

@app.route("/viewAllCourses")
def viewAllCourses():
    courses = course.query.all()
    print(courses)
    prerequisites_result = prerequisites.query.all()
    if courses and prerequisites_result:
        return jsonify(
            {
                "code": 200,
                "courses": [element.get_course_info() for element in courses],
                "prerequisites": [element.json() for element in prerequisites_result]
            }
        )

    return jsonify(
        {
            "code": 404,
            "message": "courses or prerequisites not found"
        }
    ), 404

@app.route("/viewAllBadges/<string:employeeName>")
def viewAllBadges(employeeName):
    result = badges.query.filter_by(employeeName=employeeName)

    if result:
        return jsonify(
            {
                "code": 200,
                "data": [element.json() for element in result]
            }
        )

    return jsonify(
        {
            "code": 404,
            "message": "EmployeeName does not exist in database"
        }
    ), 404

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)
