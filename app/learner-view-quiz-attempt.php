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
    

        <div class="custom-breadcrumns border-bottom">
            <div class="container">
                <a href="index.php">Home</a>
                <span class="mx-3 icon-keyboard_arrow_right"></span>
                <a href="enrolled-courses.php">Enrolled Courses</a>
                <span class="mx-3 icon-keyboard_arrow_right"></span>
                <a href="#" id="courseAndCohort"></a>
                <span class="mx-3 icon-keyboard_arrow_right"></span>
                <span class="current" id="chapterName"></span>
            </div>
        </div>

    <div class="site-section">
        <div class="container">
            
            <div class="row">
                <div id="answersPopulate">
                    
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
    console.log(chapter)
    if (chapter != -1) {
        // document.getElementById('chap').innerText = 'Ungraded Quiz Chapter ' + chapter
        document.getElementById('mainTitle').innerText = `View Ungraded Quiz Attempt`
        document.getElementById('courseAndCohort').innerText = cname + ' - ' + cohname
        document.getElementById('courseAndCohort').href = `learner-view-cohort.php?cname=${cname}&cohname=${cohname}`
        document.getElementById('chapterName').innerText = 'Chapter ' + chapter + ' - Ungraded Quiz Attempt '
    }
    else {
        // document.getElementById('chap').innerText = 'Final Quiz'
        document.getElementById('mainTitle').innerText = `View Final Quiz Attempt`
        document.getElementById('courseAndCohort').innerText = cname + ' - ' + cohname
        document.getElementById('courseAndCohort').href = `learner-view-cohort.php?cname=${cname}&cohname=${cohname}`
        document.getElementById('chapterName').innerText = 'Final Quiz Attempt'
    }

    const request = new XMLHttpRequest();
    url = 'http://10.124.2.10:5000/retrieveQuizResult/' + cname + '/' + cohname + '/' + chapter + '/' + emp_name
    console.log(url)
    request.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200){
        let response = JSON.parse(this.responseText);
        questions = response.quiz_result.questions
        console.log(response)
        console.log(questions)
        var html = '';
        var totalPoints = 0;

        for (qn in questions) {
          html += `
          <div class='card'>
            <div class='card-header'>`
            if (questions[qn].choiceRight == 1) {
              totalPoints += 1;
              if (response.quiz_result.chapterID != -1) {
                html+= `${questions[qn].questionText} <span style="float: right;"> 1 / 1 point</span>`
              }
              else {
                html+= `${questions[qn].questionText}`
              }
            }
            else {
              if (response.quiz_result.chapterID != -1) {
                html+= `${questions[qn].questionText} <span style="float: right;">0 / 1 point</span>`
              }
              else {
                html+= `${questions[qn].questionText}`
              }
            }
           html+= `</div>
            <div class='card-body'>`
          optList = questions[qn].optionsList  

          for (option in optList) {
            html += `
            <div class='row'>
              <div class='col-1' style='padding-top: 10px;'>`
              if (optList[option].optionID == questions[qn].choiceID){
                html += `<input type='radio' checked disabled>`
              }
              else {
                html += `<input type='radio' disabled>`
              }
              
            html+= `</div>
              <div class='col'>` 
              if (response.quiz_result.chapterID != -1){
                if (optList[option].isRight == 1) {
                  html +=  `${optList[option].optionText}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img src='images/svg/check.svg' width=17 height=17>`
                }
                else {
                  html +=  `${optList[option].optionText}`
                }
              }
              else {
                html +=  `${optList[option].optionText}`
              }
              
             html+= `</div>
            </div>
            `
          }
        html += `</div></div>`

      }

      if (response.quiz_result.chapterID != -1){
        html += `<span style = "float: right; margin-top: 20px;">Total points: ${totalPoints} / ${questions.length}</span>`
      }
      else {
        percentage = totalPoints/questions.length
        if (percentage < 0.85) {
          html += `<h5 style = "float: right; margin-top: 20px;">Attempt failed. Please try again.</h5>`
        }
        else {
          html += `<h5 style = "float: right; margin-top: 20px;">Congratulations, you have passed the course with a score of ${percentage *100}%!</h5>`
          const request1 = new XMLHttpRequest();
          url1 = 'http://10.124.2.10:5000/completedCourse/' + cname + '/' + cohname + '/' + emp_name

          request1.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200){
              console.log('success')
            }
            else if (this.status == 404) {
              console.log('its a 404')
            }
          }
          
          request1.open("GET", url1, false);
          request1.send();
        }
      }

      document.getElementById('answersPopulate').innerHTML = html;
      }

      else if (this.status == 404) {
        console.log('its a 404')
      }
    }
    request.open("GET", url, false);
    request.send();
  
  
  </script>

</body>


</html>