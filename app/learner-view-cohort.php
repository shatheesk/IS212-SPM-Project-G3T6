<script>
    var current_designation = sessionStorage.getItem('designation');
    var emp_name = sessionStorage.getItem('emp_name');
    console.log(current_designation)
    console.log(emp_name)

    var url_string = window.location.href
    var url = new URL(url_string);
    var cname = url.searchParams.get("cname");
    var cohname = url.searchParams.get("cohname");
    var from = url.searchParams.get("from");

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
        <span id="breadCrumb"></span>
        <span class="mx-3 icon-keyboard_arrow_right"></span>
        <span class="current" id="courseAndCohort"></span>
      </div>
    </div>

      <div class="container" style="margin-top: 70px;" id="chaptersAccord">

      </div>
      <br>
      <br>

    
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

  document.getElementById('mainTitle').innerText = cname + ' - ' + cohname
  document.getElementById('courseAndCohort').innerText = cname + ' - ' + cohname
  if (from == 'enrolled') {
    document.getElementById('breadCrumb').innerHTML = `<a href="enrolled-courses.php">Enrolled Courses</a>`
  }
  else {
    document.getElementById('breadCrumb').innerHTML = `<a href="completed-courses.php">Completed Courses</a>`
  }

  const request = new XMLHttpRequest();
  url = 'http://10.124.2.10:5000/viewMaterials/' +  cname + '/' + cohname + '/' + emp_name
  
  var html = '';
  var counter = 0;
  
  request.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200){
      let response = JSON.parse(this.responseText);
      chapters = response.materials
      console.log(response)

      for (chapter in chapters) {
        if (chapters[chapter].chapterID != -1) {
          chapterMaterials = chapters[chapter].materials
          html += `
          <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-heading${counter}">`
            if (chapter != 1) {
              if (chapters[chapter-1].quizStatus != 1) {
                html += `<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse hide" data-bs-target="#panelsStayOpen-collapse${counter}" aria-expanded="false" aria-controls="panelsStayOpen-collapse${counter}">
                <span style="color: lightgrey;">Chapter ${chapters[chapter].chapterID}</span>`
              }
              else {
                html += `<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse${counter}" aria-expanded="false" aria-controls="panelsStayOpen-collapse${counter}">
                Chapter ${chapters[chapter].chapterID}`
              }
            }
            else {
              html += `<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse${counter}" aria-expanded="false" aria-controls="panelsStayOpen-collapse${counter}">
              Chapter ${chapters[chapter].chapterID}`
            }
            html+= `
              </button>
            </h2>
            
            <div id="panelsStayOpen-collapse${counter}" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-heading${counter}">
              <div class="accordion-body">
              `
            for (material in chapterMaterials) {
              html += `
              <div class="row">
                <div class = "col">
                  Chapter Material ${chapters[chapter].chapterID}.${chapterMaterials[material].materialID} 
                  <a href="${chapterMaterials[material].materialURL}" target="_blank"><img src="images/svg/eye.svg" height="15px" width="15px" style="margin-left: 8px; margin-bottom: 4px;"></a>
                </div>
                <div class = "col">`
                if (chapterMaterials[material].done == 1) {
                  html += `<input type="checkbox" id="checkbox${chapters[chapter].chapterID}${chapterMaterials[material].materialID}" onclick="updateMaterialStatus('${chapters[chapter].chapterID}', '${chapterMaterials[material].materialID}')" checked disabled> I have completed this`
                }
                else {
                  html += `<input type="checkbox" id="checkbox${chapters[chapter].chapterID}${chapterMaterials[material].materialID}" onclick="updateMaterialStatus('${chapters[chapter].chapterID}', '${chapterMaterials[material].materialID}')"> I have completed this`
                }
              
              html += `</div>
              </div>
              `
            }
            html += `
              <div class="row mt-3" id="materialUpdate${chapters[chapter].chapterID}">`

              // havent complete materials  
              if (chapters[chapter].quizStatus == 2) {
                html += 
                `<div class="col">
                  Ungraded Quiz ${chapters[chapter].chapterID}
                </div>
                <div class="col">
                Materials not completed yet</div>`
              }
              // havent take quiz
              else if (chapters[chapter].quizStatus == 0) {
                html += `
                <div class="col">
                  <a href="learner-attempt-quiz.php?cname=${cname}&cohname=${cohname}&chapter=${chapters[chapter].chapterID}" >Ungraded Quiz ${chapters[chapter].chapterID}</a>
                </div>
                <div class="col">
                Not attempted yet</div>`
              }
              //completed
              else if (chapters[chapter].quizStatus == 1) {
                html += `
                <div class="col">
                  <a href="learner-attempt-quiz.php?cname=${cname}&cohname=${cohname}&chapter=${chapters[chapter].chapterID}" >Ungraded Quiz ${chapters[chapter].chapterID}</a>
                </div>
                <div class="col">
                Completed</div>
                <div class= "row">
                  <div class="col mt-0"><a class="btn btn-primary rounded-2 px-4 mt-4" href='learner-view-quiz-attempt.php?cname=${cname}&cohname=${cohname}&chapter=${chapter}&emp_name=${emp_name}'>View latest attempt</a></div></div>`
              }
              html+=  `
              </div>
            `
                html+=`</div></div></div>`
          counter += 1
        }
      }

      for (chapter in chapters) {
        if (chapters[chapter].chapterID == -1) {
          html += `
          <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-heading${counter}">`
            if (chapters[chapters.length-1].quizStatus != 1) {
              html += `<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse hide" data-bs-target="#panelsStayOpen-collapse${counter}" aria-expanded="false" aria-controls="panelsStayOpen-collapse${counter}">
              <span style="color: lightgrey;">Final Quiz</span>`
            }
            else {
              html += `<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse${counter}" aria-expanded="false" aria-controls="panelsStayOpen-collapse${counter}">
              Final Quiz`
            }

            html+=  `
              </button>
            </h2>
            
            <div id="panelsStayOpen-collapse${counter}" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-heading${counter}">
              <div class="accordion-body">`

            // haven't take quiz
            if (chapters[chapter].quizStatus == 2 || chapters[chapter].quizStatus == 0) {
              html += `Please attempt the final quiz below. You will need at least 85% to pass the course.<br><br>
              <a href="learner-attempt-quiz.php?cname=${cname}&cohname=${cohname}&chapter=${chapters[chapter].chapterID}" style="padding-right: 100px;">Go To Final Quiz</a> <i>Not attempted yet</i>`
            }
            //completed
            else if (chapters[chapter].quizStatus == 1) {
              const request1 = new XMLHttpRequest();
              url1 = 'http://10.124.2.10:5000/retrieveQuizResult/' + cname + '/' + cohname + '/' + chapters[chapter].chapterID + '/' + emp_name

              request1.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200){
                  let response1 = JSON.parse(this.responseText);
                  marks = response1.quiz_result.marks
                  total = response1.quiz_result.total
                  percentage = marks/total
                  if (percentage < 0.85) {
                    html += `Please attempt the final quiz below. You will need at least 85% to pass the course.<br><br>
                    <a href="learner-attempt-quiz.php?cname=${cname}&cohname=${cohname}&chapter=${chapters[chapter].chapterID}" style="padding-right: 100px;">Go To Final Quiz</a> <i>Previous attempt failed. Please try again.</i><br>
                    <a class="btn btn-primary rounded-2 px-4 mt-4" href='learner-view-quiz-attempt.php?cname=${cname}&cohname=${cohname}&chapter=${chapters[chapter].chapterID}&emp_name=${emp_name}'>View latest attempt</a>`
                  }
                  else {
                    html += `You have attempted and passed the final quiz.<br><br>
                    <a href="learner-attempt-quiz.php?cname=${cname}&cohname=${cohname}&chapter=${chapters[chapter].chapterID}" style="padding-right: 100px;">Go To Final Quiz</a> <i>Previous attempt passed with a score of ${percentage * 100}%.</i><br>
                    <a class="btn btn-primary rounded-2 px-4 mt-4" href='learner-view-quiz-attempt.php?cname=${cname}&cohname=${cohname}&chapter=${chapters[chapter].chapterID}&emp_name=${emp_name}'>View latest attempt</a>`
                  }

                }

                else if (this.status == 404) {
                  console.log('its a 404')
                }
              }
              
              request1.open("GET", url1, false);
              request1.send();


              
            }

          html+=`</div></div></div>`
          counter += 1
        }
      }

      document.getElementById('chaptersAccord').innerHTML = html ;
      
    }

    else if (this.status == 404) {
      console.log('its a 404')
    }
  }
  request.open("GET", url, false);
  request.send();


  function updateMaterialStatus(chapname, materialname) {
    document.getElementById('checkbox'+ chapname+materialname).disabled = true;
    const request1 = new XMLHttpRequest();
    url1 = 'http://10.124.2.10:5000/updateMaterialStatus/' + cname + '/' + cohname + '/' + chapname + '/' + materialname + '/' + emp_name

    
    request1.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200){
        const request2 = new XMLHttpRequest();
        url2 = 'http://10.124.2.10:5000/viewMaterials/' +  cname + '/' + cohname + '/' + emp_name

        request2.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200){
            let response = JSON.parse(this.responseText);
            chapters = response.materials 
            code = '';     
            // havent complete materials  
            if (chapters[chapname].quizStatus == 2) {
              code += 
              `<div class="col">
                Ungraded Quiz ${chapters[chapname].chapterID}
              </div>
              <div class="col">
              Materials not completed yet`
            }
            // havent take quiz
            else if (chapters[chapname].quizStatus == 0) {
              code += `
              <div class="col">
                <a href="learner-attempt-quiz.php?cname=${cname}&cohname=${cohname}&chapter=${chapname}" >Ungraded Quiz ${chapters[chapname].chapterID}</a>
              </div>
              <div class="col">
              Not attempted yet`
            }
            //completed
            else if (chapters[chapname].quizStatus == 1) {
              code += `
              <div class="col">
                <a href="learner-attempt-quiz.php?cname=${cname}&cohname=${cohname}&chapter=${chapname}" >Ungraded Quiz ${chapters[chapname].chapterID}</a>
              </div>
              <div class="col">
              Completed`
            }
            document.getElementById('materialUpdate'+chapname).innerHTML = code;
          

          }

          else if (this.status == 404) {
            console.log('its a 404')
          }
        }

        request2.open("GET", url2, false);
        request2.send();  
        
      }

      else if (this.status == 404) {
        console.log('its a 404')
      }
    }

    request1.open("GET", url1, false);
    request1.send();  
  }

  </script>

</body>

</html>