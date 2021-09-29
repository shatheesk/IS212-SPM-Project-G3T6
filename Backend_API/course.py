from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS

app = Flask(__name__)

app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql'\
    '+mysqlconnector://root@localhost:3306/Course'

app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
app.config['SQLALCHEMY_ENGINE_OPTIONS'] = {'pool_recycle': 299}

db = SQLAlchemy(app)
CORS(app)


class course_info(db.Model):
    __tablename__ = 'Course'

    course_id = db.Column(db.Integer, primary_key=True)
    course_name = db.Column(db.String(100), nullable=False)
    course_description = db.Column(db.String(100), nullable=False)

    def __init__(self, course_id, course_name, course_description):
        self.course_id = course_id
        self.course_name = course_name
        self.course_description = course_description

    def json(self):
        return {
            "course_id": self.course_id,
            "course_name": self.course_name,
            "course_description": self.course_description
        }


class class_info(db.Model):
    __tablename__ = 'Class'

    class_id = db.Column(db.Integer, primary_key=True)
    start_date = db.Column(db.String(30), nullable=False)
    end_date = db.Column(db.String(30), nullable=False)
    course_id = db.Column(db.Integer, nullable=False)
    trainer_id = db.Column(db.Integer, nullable=False)

    def __init__(self, class_id, start_date, end_date, course_id, trainer_id):
        self.class_id = class_id
        self.start_date = start_date
        self.end_date = end_date
        self.course_id = course_id
        self.trainer_id = trainer_id

    def json(self):
        return {
            "class_id": self.class_id,
            "start_date": self.start_date,
            "end_date": self.end_date,
            "course_id": self.course_id,
            "trainer_id": self.trainer_id
        }


class prerequisite_info(db.Model):
    __tablename__ = 'Prerequisite'

    course_id = db.Column(db.Integer, primary_key=True)
    prereq_id = db.Column(db.Integer, primary_key=True)

    def __init__(self, course_id, prereq_id):
        self.course_id = course_id
        self.prereq_id = prereq_id

    def json(self):
        return {"course_id": self.course_id, "prereq_id": self.prereq_id}


@app.route("/course")
def course_all():
    course_list = course_info.query.all()
    if len(course_list):
        return jsonify(
            {
                "code": 200,
                "data": {
                    "Courses": [course.json() for course in course_list]
                }
            }
        )

    return jsonify(
        {
            "code": 404,
            "message": "There are no courses available."
        }
    ), 404


@app.route("/course/<string:course_id>")
def find_course(course_id):
    course = course_info.query.filter_by(course_id=course_id).first()
    if course:
        return jsonify(
            {
                "code": 200,
                "data": course.json()
            }
        )

    return jsonify(
        {
            "code": 404,
            "message": "Course cannot be found"
        }
    ), 404


@app.route("/create_course", methods=['POST'])
def create_course():
    data = request.get_json()
    course = course_info(**data)

    try:
        db.session.add(course)
        db.session.commit()

    except Exception:
        return jsonify(
            {
                "code": 500,
                "message": "An error occurred while creating the course."
            }
        ), 500

    return jsonify(
        {
            "code": 201,
            "data": course.json()
        }
    ), 201


@app.route("/class")
def class_all():
    class_list = class_info.query.all()
    if len(class_list):
        return jsonify(
            {
                "code": 200,
                "data": {
                    "Class": [classes.json() for classes in class_list]
                }
            }
        )

    return jsonify(
        {
            "code": 404,
            "message": "There are no classes available."
        }
    ), 404


@app.route("/class/<string:class_id>")
def find_class(class_id):
    a_class = class_info.query.filter_by(class_id=class_id).first()
    if a_class:
        return jsonify(
            {
                "code": 200,
                "data": a_class.json()
            }
        )

    return jsonify(
        {
            "code": 404,
            "message": "Specific class cannot be found",
            'data': class_id
        }
    ), 404


@app.route("/create_class", methods=['POST'])
def create_class():
    data = request.get_json()
    classes = class_info(**data)

    try:
        db.session.add(classes)
        db.session.commit()

    except Exception:
        return jsonify(
            {
                "code": 500,
                "message": "An error occurred while creating the class."
            }
        ), 500

    return jsonify(
        {
            "code": 201,
            "data": classes.json()
        }
    ), 201


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)
