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
    prerequisite = db.Column(db.String(500), nullable=False)

    def __init__(self, courseName, courseImage, courseDescription, prerequisite):
        self.courseName = courseName
        self.courseImage = courseImage
        self.courseDescription = courseDescription
        self.prerequisite = prerequisite

    def get_course_info(self):
        prerequisites = self.prerequisite.split(',')

        return {
            "courseName": self.courseName,
            "courseImage": self.courseImage,
            "courseDescription": self.courseDescription,
            "prerequisite": prerequisites
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

    def get_cohort_info(self):
        return {
            'courseName': self.courseName,
            'cohortName': self.cohortName,
            'enrollmentStartDate': self.enrollmentStartDate,
            'enrollmentStartTime': self.enrollmentStartTime,
            'enrollmentEndDate': self.enrollmentEndDate,
            'enrollmentEndTime': self.enrollmentEndTime,
            'cohortStartDate': self.cohortStartDate,
            'cohortStartTime': self.cohortStartTime,
            'cohortEndDate': self.cohortEndDate,
            'cohortEndTime': self.cohortEndTime,
            'trainerName': self.trainerName,
            'cohortSize': self.cohortSize,
            'slotLeft': self.slotLeft
        }

    def get_enrollment_info(self):
        return {
            'courseName': self.courseName,
            'cohortName': self.cohortName,
            'cohortStartDate': self.cohortStartDate,
            'cohortStartTime': self.cohortStartTime,
            'cohortEndDate': self.cohortEndDate,
            'cohortEndTime': self.cohortEndTime,
            'trainerName': self.trainerName,
            'cohortSize': self.cohortSize,
            'slotLeft': self.slotLeft
        }

    def get_slotLeft(self):
        return self.slotLeft

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
        return self.badges

    def get_badges_cohort(self):
        return {
            'badges': self.badges,
            'cohortName': self.cohortName
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
    
    def get_enrollment_info(self):
        return {
            'courseNameEnrolled' : self.courseNameEnrolled,
            'cohortNameEnrolled' : self.cohortNameEnrolled
        }

class enrollmentRequest(db.Model):
    __tablename__ = 'enrollmentRequest'

    courseNameRequest = db.Column(db.String(100), db.ForeignKey(cohort.courseName), nullable=False, primary_key=True)
    cohortNameRequest = db.Column(db.String(100), db.ForeignKey(cohort.cohortName), nullable=False, primary_key=True)
    learnerName = db.Column(db.String(100), db.ForeignKey(employee.employeeName), nullable=False, primary_key=True)

    def __init__(self, courseNameRequest, cohortNameRequest, learnerName):
        self.courseNameRequest = courseNameRequest
        self.cohortNameRequest = cohortNameRequest
        self.learnerName = learnerName
    
    def get_request_info(self):
        return {
            'courseNameRequest' : self.courseNameRequest,
            'cohortNameRequest' : self.cohortNameRequest,
            'learnerName' : self.learnerName
        }

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

    if courses:
        return jsonify(
            {
                "code": 200,
                "courses": [element.get_course_info() for element in courses]
            }
        )

    return jsonify(
        {
            "code": 404,
            "message": "Courses not found"
        }
    ), 404

@app.route("/viewAllBadges/<string:employeeName>")
def viewAllBadges(employeeName):
    result = badges.query.filter_by(employeeName=employeeName)

    if result:
        return jsonify(
            {
                "code": 200,
                "badges": [element.get_badges() for element in result]
            }
        )

    return jsonify(
        {
            "code": 404,
            "message": "EmployeeName does not exist in database"
        }
    ), 404
    
@app.route("/viewBadgesCohort/<string:employeeName>")
def viewBadgesCohort(employeeName):
    result = badges.query.filter_by(employeeName=employeeName)

    if result:
        return jsonify(
            {
                "code": 200,
                "badges_cohort": [element.get_badges_cohort() for element in result]
            }
        )

    return jsonify(
        {
            "code": 404,
            "message": "EmployeeName does not exist in database"
        }
    ), 404

@app.route("/viewAllEnrolledCourses/<string:employeeName>")
def viewAllEnrolledCourses(employeeName):
    result = enrollment.query.filter_by(employeeName=employeeName)

    if result:
        output = []

        enrollment_info = [element.get_enrollment_info() for element in result]
        
        for element in enrollment_info:
            courseName = element['courseNameEnrolled']
            cohortName = element['cohortNameEnrolled']

            result = cohort.query.filter_by(courseName=courseName, cohortName=cohortName).first()
            output.append(result.get_enrollment_info())
            
        return jsonify(
            {
                "code": 200,
                "enrollments": output
            }
        )

    return jsonify(
        {
            "code": 404,
            "message": "No enrollments"
        }
    ), 404

@app.route("/viewAllRequests/<string:learnerName>")
def viewAllRequests(learnerName):
    result = enrollmentRequest.query.filter_by(learnerName=learnerName)

    if result:
        output = []

        request_info = [element.get_request_info() for element in result]
        
        for element in request_info:
            courseName = element['courseNameRequest']
            cohortName = element['cohortNameRequest']

            result = cohort.query.filter_by(courseName=courseName, cohortName=cohortName).first()
            output.append(result.get_cohort_info())
            
        return jsonify(
            {
                "code": 200,
                "requests": output
            }
        )

    return jsonify(
        {
            "code": 404,
            "message": "No requests"
        }
    ), 404

@app.route("/adminViewAllRequests")
def adminViewAllRequests():
    result = enrollmentRequest.query.all()

    if result:
        output = []

        request_info = [element.get_request_info() for element in result]
        
        for element in request_info:
            courseName = element['courseNameRequest']
            cohortName = element['cohortNameRequest']
            learnerName = element['learnerName']

            result = cohort.query.filter_by(courseName=courseName, cohortName=cohortName).first()
            result = result.get_cohort_info()
            result['learnerName'] = learnerName
            output.append(result)

        result = {}

        for element in output:
            courseName = element['courseName']
            
            if courseName not in result:
                result[courseName] = []

            result[courseName].append(element)
            
        return jsonify(
            {
                "code": 200,
                "requests": result
            }
        )

    return jsonify(
        {
            "code": 404,
            "message": "No requests"
        }
    ), 404


@app.route("/delete/<string:learnerName>/<string:courseNameRequest>/<string:cohortNameRequest>", methods=['DELETE'])
def delete_request(learnerName, courseNameRequest, cohortNameRequest):

    request = enrollmentRequest.query.filter_by(learnerName=learnerName, courseNameRequest=courseNameRequest, cohortNameRequest=cohortNameRequest).first()

    if request:
        db.session.delete(request)
        db.session.commit()
        
        return jsonify(
            {
                "code": 200,
                "message": 'Request Deleted Sucessfully'
            }
        )

    return jsonify(
        {
            "code": 404,
            "message": "Request not found"
        }
    ), 404


@app.route("/viewAllCohort/<string:courseName>")
def viewAllCohort(courseName):
    result = cohort.query.filter_by(courseName=courseName)

    if result:
        return jsonify(
            {
                "code": 200,
                "badges": [element.get_cohort_info() for element in result]
            }
        )

    return jsonify(
        {
            "code": 404,
            "message": "No Cohort available"
        }
    ), 404

@app.route("/processRequest/<string:learnerName>/<string:courseName>/<string:cohortName>", methods=['DELETE'])
def processRequest(learnerName, courseName, cohortName):
    result = enrollmentRequest.query.filter_by(learnerName = learnerName, courseNameRequest= courseName, cohortNameRequest=cohortName).first()

    if result:
        cohortResult = cohort.query.filter_by(courseName=courseName, cohortName=cohortName).first()
        slotLeft = cohortResult.get_slotLeft()

        if slotLeft > 0:
            # update slot
            slotLeft -= 1
            cohortResult.slotLeft = slotLeft
            db.session.commit()
            db.session.close()
            
            # # # delete from request table
            request = enrollmentRequest.query.filter_by(learnerName = learnerName, courseNameRequest=courseName, cohortNameRequest=cohortName).first()
            db.session.delete(request)
            db.session.commit()

            # add into enrollment
            enrollment_info = enrollment(learnerName, courseName, cohortName)

            db.session.add(enrollment_info)
            db.session.commit()

        return jsonify(
            {
                "code": 200,
                'message': "Request approved"
            }
        )

    return jsonify(
        {
            "code": 404,
            "message": "Unable to Process Request"
        }
    ), 404

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)
