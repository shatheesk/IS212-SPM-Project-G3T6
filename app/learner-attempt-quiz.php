<script>
    var current_designation = sessionStorage.getItem('designation');
    var emp_name = sessionStorage.getItem('emp_name');
    console.log(current_designation)
    console.log(emp_name)
    
    var url_string = window.location.href
    var url = new URL(url_string);
    var cname = url.searchParams.get("cname");
    var cohname = url.searchParams.get("cohname");
    var chapter = url.searchParams.get("chapter");

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
    

    <!-- <div class="custom-breadcrumns border-bottom">
        <div class="container">
            <a href="index.php">Home</a>
            <span class="mx-3 icon-keyboard_arrow_right"></span>
            <a href="teaching-courses.php">Teaching Courses</a>
            <span class="mx-3 icon-keyboard_arrow_right"></span>
            <a href="" id="cNamecohName"></a>
            <span class="mx-3 icon-keyboard_arrow_right"></span>
            <span class="current" id="chap"></span>
        </div>
    </div> -->

    <div class="site-section">
        <div class="container">

            <div class="row mb-4">
                <div id="countdownTimer">
                    
                </div>
            </div>
            
            <div class="row">
                <div id="questionPopulate">
                    
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
    let questions;
    
    // document.getElementById('cNamecohName').href = `trainer-view-cohort.php?cname=${cname}&cohname=${cohname}`
    // document.getElementById('cNamecohName').innerText = cname + ' - ' + cohname
    if (chapter != -1) {
        // document.getElementById('chap').innerText = 'Ungraded Quiz Chapter ' + chapter
        document.getElementById('mainTitle').innerText = `Attempt Ungraded Quiz`
    }
    else {
        // document.getElementById('chap').innerText = 'Final Quiz'
        document.getElementById('mainTitle').innerText = `Attempt Final Quiz`
    }

    const request = new XMLHttpRequest();
    url = 'http://192.168.50.80:5000/viewQuiz/' + cname + '/' + cohname + '/' + chapter
    
    request.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200){
        let response = JSON.parse(this.responseText);
        let duration = response.chapter_content.duration
        let chapterContent = response.chapter_content
        questions = chapterContent.questions
        html = ''
        // console.log(duration)
        // console.log(chapterContent)    
        // console.log(questions)

        //countdownTimer
        function startTimer(duration) {
          // console.log(typeof duration)
          var timer = duration, minutes, seconds;
          setInterval(function () {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            document.getElementById('countdownTimer').innerHTML = `<center><h3>Time Remaining: ${minutes}:${seconds}</h3></center>`

            if (--timer < 0) {
                // timer = duration;
                console.log('time is up')
                document.getElementById("submitQuiz").click()
            }
          }, 1000);
        }

        window.onload = function () {
          duration = duration * 60
          startTimer(duration);
        };

        //questionPopulate
        for (qn in questions) {
          html += `
          <div class='card'>
            <div class='card-header'>
              ${questions[qn].questionText}
            </div>
            <div class='card-body'>`
          optList = questions[qn].optionsList  

          for (option in optList) {
            html += `
            <div class='row'>
              <div class='col-1' style='padding-top: 10px;'>
                <input type='radio' name='solution${questions[qn].questionID}' value='${optList[option].optionID}'>
              </div>
              <div class='col'> 
                ${optList[option].optionText}
              </div>
            </div>
            `
          }


          html+=  `</div>
          </div>
          `
        }
        html += `<a class="btn btn-primary rounded-2 px-4 mt-4" href='#' onclick="submitQuizAttempt()" id="submitQuiz">Submit</a>`
        document.getElementById('questionPopulate').innerHTML = html;

      }

      else if (this.status == 404) {
        console.log('its a 404')
      }
    }
    request.open("GET", url, false);
    request.send();


    function submitQuizAttempt(){
      qnList = []
      counter = 0;
      for (qn in questions) {
        temp = 'solution' + questions[qn].questionID
        selector = 'input[name="' + temp + '"]:checked'
        // isChecked = 'input[name="' + temp + '"]:checked'
        // console.log(isChecked)
        if ($(selector).length > 0) {
          choiceID = document.querySelector(selector).value
          qnList.push({
            "questionID": questions[qn].questionID,
            "choiceID": choiceID
          })
        }
        else {
          counter +=1;
          // console.log('hey')
        }
      }
      if (counter > 0) {
        alert('Please answer all questions')
        return;
      }

      payload = {
        'employeeName': emp_name,
        "courseName": cname, 
        "cohortName": cohname,
        "chapterID": chapter,
        "questions_list": qnList
      }

      const request1 = new XMLHttpRequest();
        url1 = 'http://192.168.50.80:5000/recordAttempt'
        request1.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 201){
                console.log('success')
                console.log(payload)
                location.href = `learner-view-quiz-attempt.php?cname=${cname}&cohname=${cohname}&chapter=${chapter}&emp_name=${emp_name}`;            
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

</body>


</html>