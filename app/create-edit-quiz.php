<script>
    var current_designation = sessionStorage.getItem('designation');
    var emp_name = sessionStorage.getItem('emp_name');

    var url_string = window.location.href
    var url = new URL(url_string);
    var cname = url.searchParams.get("cname");
    var cohname = url.searchParams.get("cohname");
    var chapter = url.searchParams.get("chapter");
    var action = url.searchParams.get("action");
    html = ''
    qnCounter = 1
    questionsList = []
    indexxx = 0
    indexOfEdit = 0;

    function populateQnMode() {
        var type = document.getElementById("questionType").value;
        code = ''
        if (type == 'TorF') {
            code += `
            <div class="row">
                <div class="col-lg-6 col-md-6 mb-4">
                    Options:
                </div>
                <div class="col-lg-2 col-md-2 mb-4">
                    Correct?
                </div>
            </div>
            <div class="row">
                <div class="col">
                    True
                </div>
                <div class="col" style="margin-top: 5px;">
                    <input type="radio" name="solution" value="True" style="height: 17px; width: 17px; margin-left: 25px;">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    False
                </div>
                <div class="col" style="margin-top: 5px;">
                    <input type="radio" name="solution" value="False" style="height: 17px; width: 17px; margin-left: 25px;">
                </div>
            </div>
            `
        }
        else {
            code += `
            <div class="row">
                <div class="col-lg-6 col-md-6 mb-4">
                    Options:
                </div>
                <div class="col-lg-3 col-md-2 mb-4">
                    Correct?
                </div>
                <div class="col-lg-3 col-md-2 mb-4">
                    <input type="button" value="Add Option" onclick="addOptionMCQ()">
                </div>
            </div>
            `
        }

        document.getElementById('questionMode').innerHTML = code;
        indexxx = 0
    }

    function addOptionMCQ() {
        code2 = ''
        code2 += `
        <div class="row" id="optionRow${indexxx}">
            <div class="col-lg-6 col-md-6 mb-4">
                <input type="text" style="width: 100%;" name="mcqOptionValue" id="${indexxx}" value="">
            </div>
            <div class="col-lg-3 col-md-2 mb-4" style="margin-top: 10px;">
                <input type="radio" name="solution" value="${indexxx}" style="height: 17px; width: 17px; margin-left: 25px;">
            </div>
            <div class="col-lg-3 col-md-2 mb-4" style="margin-top: 10px;">
                <img src="images/svg/x.svg" style="cursor: pointer; height: 17px; width: 17px;" onclick="removeOptionMCQ('${indexxx}')">
            </div>
        </div>
        `
        document.getElementById('questionMode').innerHTML += code2;
        indexxx += 1
    }

    // function removeOptionMCQ(ind) {
    //     document.getElementById('optionRow' + ind).innerHTML = '';
    //     indexxx -= 1;
    // }

    function addQuestionCard() {
       
        code3 = ''
        question = document.getElementById('question').value;

        if (document.getElementById('questionType').value == 'TorF') {
            code3 += `
            <div id="card${qnCounter}">
            <div class="card" >
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            ${question}
                        </div>
                        <div class="col">
                            <img src="images/svg/trash.svg" width="20" height = "20" style="float:right; cursor: pointer;" onclick="deleteQuestion('${qnCounter}')">
                            <img src="images/svg/pencil.svg" width="20" height = "20" style="float:right; margin-right: 20px; cursor: pointer;" onclick="editQuestion('${qnCounter}')" data-toggle="modal" data-target="#questionModal">
                        </div>
                    </div>
                </div>
                <div class="card-body">`
            if (document.querySelector('input[name="solution"]:checked').value == "True"){
                code3 += `
                <div class="row">
                    <div class="col">
                        True
                    </div>
                    <div class="col">
                        <img src="images/svg/check.svg" width="20" height = "20">
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        False
                    </div>
                </div>`

                questionsList.push({
                    "questionID" : qnCounter, 
                    "questionText" : question,
                    "optionsList" : [
                        {
                            "optionID": 1,
                            "optionText": "True",
                            "isRight": 1
                        },
                        {
                            "optionID": 2,
                            "optionText": "False",
                            "isRight": 0
                        }
                    ]
                })
            }
            else{
                code3 += `
                <div class="row">
                    <div class="col">
                        True
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        False
                    </div>
                    <div class="col">
                        <img src="images/svg/check.svg" width="20" height = "20">
                    </div>
                </div>`

                questionsList.push({
                    "questionID" : qnCounter, 
                    "questionText" : question,
                    "optionsList" : [
                        {
                            "optionID": 1,
                            "optionText": "True",
                            "isRight": 0
                        },
                        {
                            "optionID": 2,
                            "optionText": "False",
                            "isRight": 1
                        }
                    ]
                })
            }
            
            code3+=`</div>
            </div>
            </div>
            `
        }
        else {
            var elements = document.querySelectorAll('input[name$="mcqOptionValue"]');
            var selectedIndex = document.querySelector('input[name="solution"]:checked').value
            var tempOptions = []

            code3 += `
            <div id="card${qnCounter}">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            ${question}
                        </div>
                        <div class="col">
                            <img src="images/svg/trash.svg" width="20" height = "20" style="float:right; cursor: pointer;" onclick="deleteQuestion('${qnCounter}')">
                            <img src="images/svg/pencil.svg" width="20" height = "20" style="float:right; margin-right: 20px; cursor: pointer;" onclick="editQuestion('${qnCounter}')" data-toggle="modal" data-target="#questionModal">
                        </div>
                    </div>
                </div>
                <div class="card-body">`
            
            elements.forEach((element, i) => {
                isRightOrNot = 0
                code3 += `  
                <div class="row">
                    <div class="col">
                        ${element.value}
                    </div>
                    <div class="col">`
                if (i == selectedIndex){
                    code3 += `<img src="images/svg/check.svg" width="20" height = "20">`
                    isRightOrNot = 1
                }
                code3+=`</div>
                </div>`

                tempOptions.push({
                    "optionID": i+1,
                    "optionText": element.value,
                    "isRight": isRightOrNot
                })
            }); 

            code3+=`</div>
            </div>
            </div>
            `
            questionsList.push({
                "questionID" : qnCounter, 
                "questionText" : question,
                "optionsList" : tempOptions
            })
        }
        qnCounter += 1;
        document.getElementById('questionPopulate').innerHTML += code3;
        document.getElementById('question').value = '';
        document.getElementById('qnTypeSelection').innerHTML = `
        <select name="questionType" id="questionType" onchange="populateQnMode()">
            <option value="" disabled selected hidden>Choose question type</option>                                        
            <option value="TorF">True/False</option>
            <option value="MCQ">MCQ</option>
        </select>
        `;

        document.getElementById('questionMode').innerHTML = '';
    }

    function closeModal() {
        document.getElementById('question').value = '';
        document.getElementById('qnTypeSelection').innerHTML = `
        <select name="questionType" id="questionType" onchange="populateQnMode()">
            <option value="" disabled selected hidden>Choose question type</option>                                        
            <option value="TorF">True/False</option>
            <option value="MCQ">MCQ</option>
        </select>
        `;
        document.getElementById('questionMode').innerHTML = '';
    }

    function deleteQuestion(qnCounter) {
        let confirmAction = confirm("Are you sure to delete this question?");
        if (confirmAction) {
            qnCounter = Number(qnCounter)
            var indexOfDelete = questionsList.findIndex(element => element.questionID === qnCounter);
            questionsList.splice(indexOfDelete, 1)
            document.getElementById('card' + qnCounter).innerHTML = '';
        }
    }

    function editQuestion(qnCounter) {
        document.getElementById('forCreate').style.display = "none";
        document.getElementById('forEdit').style.display = "block";
        qnCounter = Number(qnCounter)
        indexOfEdit = questionsList.findIndex(element => element.questionID === qnCounter);
        var question = questionsList[indexOfEdit];
        document.getElementById('question').value = question.questionText
        if (question.optionsList[0].optionText == 'True') {
            $('#questionType').val('TorF')
            editCode = ''

            editCode += `
            <div class="row">
                <div class="col-lg-6 col-md-6 mb-4">
                    Options:
                </div>
                <div class="col-lg-2 col-md-2 mb-4">
                    Correct?
                </div>
            </div>
            <div class="row">
                <div class="col">
                    True
                </div>
                <div class="col" style="margin-top: 5px;">`
            if (question.optionsList[0].isRight == 1){
                editCode+= `<input type="radio" name="solution" value="True" checked style="height: 17px; width: 17px; margin-left: 25px;">`
            }
            else {
                editCode+= `<input type="radio" name="solution" value="True" style="height: 17px; width: 17px; margin-left: 25px;">`
            }
            
            editCode+=`</div>
            </div>
            <div class="row">
                <div class="col">
                    False
                </div>
                <div class="col" style="margin-top: 5px;">`
                if (question.optionsList[1].isRight == 1){
                    editCode+= `<input type="radio" name="solution" value="False" checked style="height: 17px; width: 17px; margin-left: 25px;">`
                }
                else {
                    editCode+= `<input type="radio" name="solution" value="False" style="height: 17px; width: 17px; margin-left: 25px;">`
                }

            editCode+=`</div>
            </div>
            `

            document.getElementById('questionMode').innerHTML = editCode
        }
        else {
            $('#questionType').val('MCQ')
            editCode = ''
            editCode += `
            <div class="row">
                <div class="col-lg-6 col-md-6 mb-4">
                    Options:
                </div>
                <div class="col-lg-2 col-md-2 mb-4">
                    Correct?
                </div>
                <div class="col-lg-2 col-md-2 mb-4">
                    <input type="button" value="Add Option" onclick="addOptionMCQ()">
                </div>
            </div>
            `
            for (op in question.optionsList) {
                option = question.optionsList[op]
                editCode += `
                <div class="row">
                    <div class="col-lg-6 col-md-6 mb-4">
                        <input type="text" style="width: 100%;" name="mcqOptionValue" id="${op}" value="${option.optionText}">
                    </div>
                    <div class="col-lg-2 col-md-2 mb-4" style="margin-top: 10px;">`
                if (option.isRight == 1) {
                    editCode += `<input type="radio" name="solution" value="${op}" checked style="height: 17px; width: 17px; margin-left: 25px;">`
                }
                else {
                    editCode += `<input type="radio" name="solution" value="${op}" style="height: 17px; width: 17px; margin-left: 25px;">`
                }
                editCode += `</div>
                    <div class="col-lg-2 col-md-2 mb-4">
                    </div>
                </div>
                `
            }
            document.getElementById('questionMode').innerHTML = editCode
        }

    }
    
    function editQuestionCard() {
        var tempQuestionList = []
        editCode3 = ''
        question = document.getElementById('question').value;

        if (document.getElementById('questionType').value == 'TorF') {
            editCode3 += `
            <div class="card" >
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            ${question}
                        </div>
                        <div class="col">
                            <img src="images/svg/trash.svg" width="20" height = "20" style="float:right; cursor: pointer;" onclick="deleteQuestion('${indexOfEdit+1}')">
                            <img src="images/svg/pencil.svg" width="20" height = "20" style="float:right; margin-right: 20px; cursor: pointer;" onclick="editQuestion('${indexOfEdit+1}')" data-toggle="modal" data-target="#questionModal">
                        </div>
                    </div>
                </div>
                <div class="card-body">`
            if (document.querySelector('input[name="solution"]:checked').value == "True"){
                editCode3 += `
                <div class="row">
                    <div class="col">
                        True
                    </div>
                    <div class="col">
                        <img src="images/svg/check.svg" width="20" height = "20">
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        False
                    </div>
                </div>`

                questionsList[indexOfEdit] = {
                    "questionID" : indexOfEdit+1, 
                    "questionText" : question,
                    "optionsList" : [
                        {
                            "optionID": 1,
                            "optionText": "True",
                            "isRight": 1
                        },
                        {
                            "optionID": 2,
                            "optionText": "False",
                            "isRight": 0
                        }
                    ]
                }
            }
            else{
                editCode3 += `
                <div class="row">
                    <div class="col">
                        True
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        False
                    </div>
                    <div class="col">
                        <img src="images/svg/check.svg" width="20" height = "20">
                    </div>
                </div>`

                questionsList[indexOfEdit] = {
                    "questionID" : indexOfEdit+1, 
                    "questionText" : question,
                    "optionsList" : [
                        {
                            "optionID": 1,
                            "optionText": "True",
                            "isRight": 0
                        },
                        {
                            "optionID": 2,
                            "optionText": "False",
                            "isRight": 1
                        }
                    ]
                }
            }
            
            
            editCode3+=`</div>
            </div>
            `
        }
        else {
            var elements = document.querySelectorAll('input[name$="mcqOptionValue"]');
            var selectedIndex = document.querySelector('input[name="solution"]:checked').value
            var tempEditOptions = []

            editCode3 += `
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            ${question}
                        </div>
                        <div class="col">
                            <img src="images/svg/trash.svg" width="20" height = "20" style="float:right; cursor: pointer;" onclick="deleteQuestion('${indexOfEdit+1}')">
                            <img src="images/svg/pencil.svg" width="20" height = "20" style="float:right; margin-right: 20px; cursor: pointer;" onclick="editQuestion('${indexOfEdit+1}')" data-toggle="modal" data-target="#questionModal">
                        </div>
                    </div>
                </div>
                <div class="card-body">`
            
            elements.forEach((element, i) => {
                isRightOrNot = 0
                editCode3 += `  
                <div class="row">
                    <div class="col">
                        ${element.value}
                    </div>
                    <div class="col">`
                if (i == selectedIndex){
                    editCode3 += `<img src="images/svg/check.svg" width="20" height = "20">`
                    isRightOrNot = 1
                }
                editCode3+=`</div>
                </div>`

                tempEditOptions.push({
                    "optionID": i+1,
                    "optionText": element.value,
                    "isRight": isRightOrNot
                })
            });
 

            editCode3+=`</div>
            </div>
            `
            questionsList[indexOfEdit] = {
                "questionID" : indexOfEdit+1, 
                "questionText" : question,
                "optionsList" : tempEditOptions
            }

        }
        document.getElementById('card' + (indexOfEdit+1)).innerHTML = editCode3;
        document.getElementById('question').value = '';
        document.getElementById('qnTypeSelection').innerHTML = `
        <select name="questionType" id="questionType" onchange="populateQnMode()">
            <option value="" disabled selected hidden>Choose question type</option>                                        
            <option value="TorF">True/False</option>
            <option value="MCQ">MCQ</option>
        </select>
        `;

        document.getElementById('questionMode').innerHTML = '';
    }

    function addNewQuestion(){
        document.getElementById('forCreate').style.display = "block";
        document.getElementById('forEdit').style.display = "none";
    }
    
    function createNow() {
        if (action == 'edit') {
            const request = new XMLHttpRequest();
            url = 'http://192.168.50.80:5000/deleteQuiz/' + cname + '/' + cohname + '/' + chapter
            
            request.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200){
                    let response = JSON.parse(this.responseText);
                    console.log(response)
                }
                else if (this.status == 404) {
                    console.log('its a 404')
                }

            }
            request.open("GET", url, false);
            request.send();
        }

        if (chapter == -1) {
            var grade = 1 
        }
        else {
            var grade = 0 
        }
        var dura = document.getElementById('duration').value;

        var payload = {
            "chapterID" : chapter,
            "cohortName": cohname,
            "courseName": cname,
            "duration": dura,
            "graded": grade,
            "questions": questionsList
        }

        const request1 = new XMLHttpRequest();
        url1 = 'http://192.168.50.80:5000/createNewQuiz'
        request1.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200){
                console.log('success')
                console.log(payload)
                // location.href = `trainer-view-cohort.php?cname=${cname}&cohname=${cohname}`;            
            }
            else if (this.status == 404) {
                console.log('its a 404')
            }
        }

        request1.open("POST", url1, false);
        request1.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        request1.send(JSON.stringify(payload));

    }
    
    
</script>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>All-In-One</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <link href="https://fonts.googleapis.com/css?family=Muli:300,400,700,900" rel="stylesheet">
  <link rel="stylesheet" href="fonts/icomoon/style.css">

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">

  <link rel="stylesheet" href="css/jquery.fancybox.min.css">

  <link rel="stylesheet" href="css/bootstrap-datepicker.css">

  <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">

  <link rel="stylesheet" href="css/aos.css">
  <link href="css/jquery.mb.YTPlayer.min.css" media="all" rel="stylesheet" type="text/css">

  <link rel="stylesheet" href="css/style.css">

</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">

  <div class="site-wrap">

    <div class="py-2 ">
      
    </div>

    <?php include 'navbar.php'; ?>
    
    <div class="site-section ftco-subscribe-1 site-blocks-cover pb-4" style="background-image: url('images/bg_1.jpg')">
        <div class="container">
          <div class="row align-items-end">
            <div class="col-lg-7">
              <h2 class="mb-4" id="mainTitle"></h2> 
            </div>
          </div>
        </div>
      </div> 
    

    <div class="custom-breadcrumns border-bottom">
        <div class="container">
            <a href="index.php">Home</a>
            <span class="mx-3 icon-keyboard_arrow_right"></span>
            <a href="teaching-courses.php">Teaching Courses</a>
            <span class="mx-3 icon-keyboard_arrow_right"></span>
            <a href="" id="cNamecohName"></a>
            <span class="mx-3 icon-keyboard_arrow_right"></span>
            <span class="current" id="chap"></span>
        </div>
    </div>

    <div class="site-section" style="padding-top: 40px;">
        <div class="container">
            
            <div class="row">
                <div class="col-lg-12 col-md-12 mb-4">
                    <button id="addQn" type="button" class="btn btn-secondary" data-toggle="modal" data-target="#questionModal" onclick="addNewQuestion()" style="float:right; width:127px;">Add Question</button>
                </div>
            </div>

            <div class="row">
                <div id="questionPopulate">
                    
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-lg-9 col-md-9 mb-4">
                    <h4>Duration for quiz (in mins):&nbsp;&nbsp;&nbsp; <input type="number" id="duration" min="1" max="999"></h4>
                </div>
                <div class="col-lg-3 col-md-3 mb-4">
                    <h3><button id="condition" type="button" class="btn btn-primary" style="float:right; width:127px;" onclick="createNow()">Create/Edit</button></h3>
                </div>
            </div>
        
            <div class="modal fade" id="questionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-dialog-centered" role="document"  style="max-width:50%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Create/Edit Question</h5>
                            <button onClick="closeModal()" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button> 
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 mb-4">
                                    Question:
                                </div>
                                <div class="col-lg-9 col-md-9 mb-4">
                                    <input type="text" style="width: 100%;" id="question">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 mb-4">
                                    Type:
                                </div>
                                <div class="col-lg-9 col-md-9 mb-4">
                                    <div id="qnTypeSelection">
                                        <select name="questionType" id="questionType" onchange="populateQnMode()">
                                            <option value="" disabled selected hidden>Choose question type</option>                                        
                                            <option value="TorF">True/False</option>
                                            <option value="MCQ">MCQ</option>
                                        </select>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                            <hr>
                            <div id="questionMode">
                                
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" onClick="addQuestionCard()" data-dismiss="modal" id='forCreate' style="display: block;"> Create</button>
                            <button type="button" class="btn btn-primary" onClick="editQuestionCard()" data-dismiss="modal" id='forEdit' style="display: none;"> Update</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="closeModal()">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
    </div>   
    
    <?php include 'footer.php'; ?>

  </div>
  <!-- .site-wrap -->

  <!-- loader -->
  <div id="loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#51be78"/></svg></div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/jquery.countdown.min.js"></script>
  <script src="js/bootstrap-datepicker.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/jquery.fancybox.min.js"></script>
  <script src="js/jquery.sticky.js"></script>
  <script src="js/jquery.mb.YTPlayer.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <script src="js/main.js"></script>
  
  <script>
    
    document.getElementById('cNamecohName').href = `trainer-view-cohort.php?cname=${cname}&cohname=${cohname}`
    document.getElementById('cNamecohName').innerText = cname + ' - ' + cohname
    if (chapter != -1) {
        document.getElementById('chap').innerText = 'Ungraded Quiz Chapter ' + chapter
        if (action == 'edit') {
            document.getElementById('mainTitle').innerText = `Edit Ungraded Quiz`
        }
        else {
            document.getElementById('mainTitle').innerText = `Create Ungraded Quiz`
        }
    }
    else {
        document.getElementById('chap').innerText = 'Final Quiz'
        if (action == 'edit') {
            document.getElementById('mainTitle').innerText = `Edit Final Quiz`
        }
        else {
            document.getElementById('mainTitle').innerText = `Create Final Quiz`
        }
    }

    

    if (action == 'edit') {
        const request = new XMLHttpRequest();
        url = 'http://192.168.50.80:5000/viewQuiz/' + cname + '/' + cohname + '/' + chapter
        
        request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200){
            let response = JSON.parse(this.responseText);
            let chapterContent = response.chapter_content
            let questions = chapterContent.questions
            html = ''    
            questionsList = questions
            

            for (qn in questions) {
                html += `
                <div id="card${qnCounter}">
                <div class="card">
                    <div class="card-header">
                        
                        <div class="row">
                            <div class="col">
                                ${questions[qn].questionText}
                            </div>
                            <div class="col">
                                <img src="images/svg/trash.svg" width="20" height = "20" style="float:right; cursor: pointer;" onclick="deleteQuestion('${qnCounter}')">
                                <img src="images/svg/pencil.svg" width="20" height = "20" style="float:right; margin-right: 20px; cursor: pointer;" onclick="editQuestion('${qnCounter}')" data-toggle="modal" data-target="#questionModal">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">`

                optList = questions[qn].optionsList

                for (option in optList){
                    html += `
                    <div class="row">
                        <div class="col">
                            ${optList[option].optionText}
                        </div>`
                    if (optList[option].isRight == 1) {
                        html += `
                        <div class="col">
                            <img src="images/svg/check.svg" width="20" height = "20">
                        </div>
                        `
                    }
                    html += `</div>`
                } 
                
                html+=`</div>
                </div>
                </div>
                `
                qnCounter+=1
            }
            document.getElementById('questionPopulate').innerHTML = html;
            document.getElementById('duration').value = chapterContent.duration;

        }

        else if (this.status == 404) {
            console.log('its a 404')
        }
        }
        request.open("GET", url, false);
        request.send();
    }

    if (action == 'edit') {
        document.getElementById('condition').innerText = 'Update'
    }
    else {
        document.getElementById('condition').innerText = 'Create'
    }

  </script>

</body>


</html>