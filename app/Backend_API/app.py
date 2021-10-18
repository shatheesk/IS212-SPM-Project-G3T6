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

    def get_prerequisite(self):
        return self.prerequisite.split(',')


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

    def get_employeeName(self):
        return self.employeeName


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

    def get_employeeName(self):
        return self.employeeName


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
        ), 200

    return jsonify(
        {
            "code": 404,
            "message": "Error occured while retrieving employee's designation"
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
        ), 200

    return jsonify(
        {
            "code": 404,
            "message": "Error occured while viewing all courses"
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
            "message": "Error occured while retrieving employee's badges"
        }
    ), 404


# completed courses (learner view)    
@app.route("/viewBadgesCohort/<string:employeeName>")
def viewBadgesCohort(employeeName):
    result = badges.query.filter_by(employeeName=employeeName)

    if result:
        return jsonify(
            {
                "code": 200,
                "badges_cohort": [element.get_badges_cohort() for element in result]
            }
        ), 200

    return jsonify(
        {
            "code": 404,
            "message": "Error occured while retrieving employee's badges"
        }
    ), 404


#enrolled courses (learner view)
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
        ), 200

    return jsonify(
        {
            "code": 404,
            "message": "Error occured while retrieving all enrolled courses"
        }
    ), 404


#pendin courses (learner view)
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
        ), 200

    return jsonify(
        {
            "code": 404,
            "message": "Error occured while retrieving all requests"
        }
    ), 404

#view all requests (admin view)
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
        ), 200

    return jsonify(
        {
            "code": 404,
            "message": "Error occured while retrieving all requests"
        }
    ), 404


#withdraw (learner), reject learner (admin)
@app.route("/delete/<string:learnerName>/<string:courseNameRequest>/<string:cohortNameRequest>", methods=['DELETE'])
def delete_request(learnerName, courseNameRequest, cohortNameRequest):

    request = enrollmentRequest.query.filter_by(learnerName=learnerName, courseNameRequest=courseNameRequest, cohortNameRequest=cohortNameRequest).first()

    if request:
        try:
            db.session.delete(request)
            db.session.commit()
            
            return jsonify(
                {
                    "code": 200,
                    "message": 'Request Deleted Successfully'
                }
            )

        except:
            return jsonify(
                {
                    "code": 404,
                    "message": "Error occured while deleting enrollment request"
                }
            ), 404

    return jsonify(
        {
            "code": 404,
            "message": "Error occured while deleting enrollment request"
        }
    ), 404


#courses page (learner)
@app.route("/viewAllCohort/<string:courseName>")
def viewAllCohort(courseName):
    result = cohort.query.filter_by(courseName=courseName)

    if result:
        return jsonify(
            {
                "code": 200,
                "cohorts": [element.get_cohort_info() for element in result]
            }
        ), 200

    return jsonify(
        {
            "code": 404,
            "message": "Error occured while retrieving all cohort records."
        }
    ), 404


# approve a learner's request (admin view)
@app.route("/processRequest/<string:learnerName>/<string:courseName>/<string:cohortName>", methods=['DELETE'])
def processRequest(learnerName, courseName, cohortName):
    result = enrollmentRequest.query.filter_by(learnerName = learnerName, courseNameRequest= courseName, cohortNameRequest=cohortName).first()

    if result:
        cohortResult = cohort.query.filter_by(courseName=courseName, cohortName=cohortName).first()
        slotLeft = cohortResult.get_slotLeft()

        if slotLeft > 0:
            try:
                # update slot
                slotLeft -= 1
                cohortResult.slotLeft = slotLeft
                db.session.commit()
                
                # # # delete from request table
                requests = enrollmentRequest.query.filter_by(learnerName = learnerName, courseNameRequest=courseName)

                for request in requests:
                    db.session.delete(request)
                    db.session.commit()

                if slotLeft == 0:
                    requests = enrollmentRequest.query.filter_by(courseNameRequest=courseName, cohortNameRequest=cohortName)

                    for request in requests:
                        db.session.delete(request)
                        db.session.commit()

                # add into enrollment
                enrollment_info = enrollment(learnerName, courseName, cohortName)

                db.session.add(enrollment_info)
                db.session.commit()
                
                return jsonify(
                    {
                        "code": 200,
                        "message": "Successfully processed request."
                    }
                ), 200

            except:
                return jsonify(
                    {
                        "code": 404,
                        "message": "Error occured while processing request."
                    }
                ), 404

    return jsonify(
        {
            "code": 404,
            "message": "Error occured while processing request."
        }
    ), 404

#self-enrol request (learner)
@app.route("/self_enrol_request/<string:courseName>/<string:cohortName>/<string:learnerName>")
def self_enrol_request(courseName, cohortName, learnerName):
    request = enrollmentRequest(courseName, cohortName, learnerName)

    try:
        db.session.add(request)
        db.session.commit()

        return jsonify(
            {
                "code": 200,
                "message": "Enrollment request created successfully."
            }
        ), 200

    except:
        return jsonify( 
            {
                "code": 404,
                "message": "Error occured while creating enrollment request."
            }
        ), 404

# CF 2

# Set enrollment period for a specific cohort under a course
@app.route("/setEnrollmentPeriod/<string:courseName>/<string:cohortName>/<string:enrollmentStartDate>/<string:enrollmentStartTime>/<string:enrollmentEndDate>/<string:enrollmentEndTime>")
def setEnrollmentPeriod(courseName,cohortName, enrollmentStartDate, enrollmentStartTime, enrollmentEndDate, enrollmentEndTime):
    result = cohort.query.filter_by(courseName=courseName, cohortName=cohortName).first()
    if result:
        try:
            # update 6 fields
            result.enrollmentStartDate = enrollmentStartDate
            result.enrollmentStartTime = enrollmentStartTime
            result.enrollmentEndDate = enrollmentEndDate
            result.enrollmentEndTime = enrollmentEndTime
            db.session.commit()

            return jsonify(
                {
                    "code": 200,
                    "message": "Successfully set enrollment period."
                }
            ), 200

        except:
            return jsonify(
                {
                    "code": 404,
                    "message": "Error occured while setting enrollment period."
                }
            ), 404

    return jsonify(
        {
            "code": 404,
            "message": "Error occured while setting enrollment period."
        }
    ), 404

#Retrieve list of qualified learners
@app.route("/retrieveQualifiedLearners/<string:courseName>/<string:cohortName>")
def retrieveQualifiedLearners(courseName,cohortName):

    try:
        # list of learners + badges
        learners = {}
        
        learners_result = employee.query.all()

        for learner in learners_result:
            designation = learner.get_designation()
            learner = learner.get_employeeName()

            if designation['currentDesignation'] != 'Admin':
                badges_result = badges.query.filter_by(employeeName=learner)
                learners[learner] = [badge.get_badges() for badge in badges_result]

        # prerequisite of the course
        prerequisite_result = course.query.filter_by(courseName=courseName).first()
        prerequisite_list = prerequisite_result.get_prerequisite()

        if prerequisite_list == ['']:
            prerequisite_list = []

        # list of learners that are enrolled in the course
        enrolled_learners = []
        enrolled_learners_result = enrollment.query.filter_by(courseNameEnrolled=courseName)
        
        for element in enrolled_learners_result:
            learner = element.get_employeeName()
            enrolled_learners.append(learner)        

        remove_list = set()
        
        for learner in learners:
            badges_list = learners[learner]

            # Never Fulfill prerequisites
            check = False
            for prerequisite in prerequisite_list:
                if prerequisite not in badges_list:
                    check = True

            if check:
                remove_list.add(learner)

            # Completed course
            if courseName in badges_list:
                remove_list.add(learner)
            
            # Enrolled
            if learner in enrolled_learners:
                remove_list.add(learner)
        
        for learner in remove_list:
            del learners[learner]

        output = []
        for learner in learners:
            output.append(learner)

        return jsonify(
            {
                "code": 200,
                "QualifiedLearners": output
            }
        ), 200

    except:
        return jsonify(
            {
                "code": 404,
                "message": "Error occured while retrieving the list of qualified learners."
            }
        ), 404

# Enroll a list of selected learners into a specific cohort under a course
@app.route("/assignLearners", methods=['POST'])
def assignLearners():
    data = request.get_json()

    cohortName = data['cohortNameRequest']
    courseName = data['courseNameRequest']
    selectedlearners = data['selectedLearners']

    # check if have sufficient slots
    number_learners = len(selectedlearners)

    cohortResult = cohort.query.filter_by(courseName=courseName, cohortName=cohortName).first()
    slotLeft = cohortResult.get_slotLeft()

    if slotLeft < number_learners:
        return jsonify(
            {
                "code": 404,
                "message": "Insufficient number of slots"
            }
        ), 404

    try:
        for learners in selectedlearners:
            enrollment_obj = enrollment(learners, courseName, cohortName)
            db.session.add(enrollment_obj)
            db.session.commit()

        slotLeft -= number_learners
        cohortResult.slotLeft = slotLeft
        db.session.commit()

        return jsonify(
            {
                "code": 201,
                "message": "Sucessfully assigned learners to course"
            }
        ), 201

    except Exception:
        return jsonify(
            {
                "code": 404,
                "message": "An error occurred while assigning learners."
            }
        ), 404

#Retrieve a list of enrolled learners under a specific cohort of a course
@app.route("/viewAllEnrolledLearners/<string:courseName>/<string:cohortName>")
def viewAllEnrolledLearners(courseName, cohortName):
    result = enrollment.query.filter_by(courseNameEnrolled=courseName, cohortNameEnrolled=cohortName)

    if result:
        return jsonify(
            {
                "code": 200,
                "EnrolledLearners": [element.get_employeeName() for element in result]
            }
        ), 200

    return jsonify(
        {
            "code": 404,
            "message": "Error occured while retrieving all enrolled learners"
        }
    ), 404


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)
