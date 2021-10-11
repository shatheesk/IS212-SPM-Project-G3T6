<script>
  var current_designation = sessionStorage.getItem('designation');
  var emp_name = sessionStorage.getItem('emp_name');
  console.log(current_designation)
  console.log(emp_name)
</script>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>All-In-One</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


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
              <h2 class="mb-4" id="cTitle"></h2> 
            </div>
          </div>
        </div>
      </div> 
    

    <div class="custom-breadcrumns border-bottom">
      <div class="container">
        <a href="index.php">Home</a>
        <span class="mx-3 icon-keyboard_arrow_right"></span>
        <a href="courses.php">Courses</a>
        <span class="mx-3 icon-keyboard_arrow_right"></span>
        <span class="current" id="cTitle1"></span>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <!-- <div class = "row">
          <div class="col-lg-12 col-md-12 mb-4">
            <a href="create-edit-class.php" class="btn btn-primary rounded-0 px-4" style="float: right">Create a class!</a>
          </div>
        </div> -->
        
        <div class="row" id="course">
          
        </div>

        <div class="row mt-4" id="cohort">
  
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

  <script src="js/main.js"></script>

  <script>
    var url_string = window.location.href
    var url = new URL(url_string);
    var cname = url.searchParams.get("cname");
    document.getElementById('cTitle').innerText = cname
    document.getElementById('cTitle1').innerText = cname

    const request = new XMLHttpRequest();
    url = 'http://10.124.2.10:5000/viewAllCourses'
    
    request.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200){
        let response = JSON.parse(this.responseText);
        let courses = response.courses
        html = ''

        for (c in courses){
          if (courses[c].courseName == cname) {
            html += `
              <div class="col-md-6 mb-4">
                <p>
                  <img src="${courses[c].courseImage}" alt="Image" class="img-fluid">
                </p>
              </div>

              <div class="col-lg-5 ml-auto align-self-top">
                <h2 class="section-title-underline mb-5">
                    <span>Course Details</span>
                </h2>
                <p>
                  ${courses[c].courseDescription}
                </p>
                <h5>Prerequisites:` 
                if ([courses[c].prerequisite][0] == ''){
                  html += ``
                }
                else {
                  for (p in courses[c].prerequisite) {
                    html += `<br> ${courses[c].prerequisite[p]}`
                    html += `, `
                  }
                  html = html.substring(0, html.length - 2);
                }
                html+=`</h5>
              </div>`
          }
        }
        document.getElementById('course').innerHTML = html
      }

      else if (this.status == 404) {
        console.log('its a 404')
      }
    }
    request.open("GET", url, false);
    request.send();


    const request1 = new XMLHttpRequest();
    url2 = 'http://10.124.2.10:5000/viewAllCohort/' + cname
    
    request1.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200){
        let response = JSON.parse(this.responseText);
        let cohorts = response.cohorts
        html2 = ''
        html2 = `
        <h2 class="section-title-underline mb-5">
          <span>Cohort Details</span>
        </h2>

        <table class="table">
          <thead>
            <tr>
              <th scope="col">Cohort</th>
              <th scope="col">Enrollment Period</th>
              <th scope="col">Class Period</th>
              <th scope="col">Trainer</th>
              <th scope="col">Enroll</th>
            </tr>
          </thead>
          <tbody>`

        for (c in cohorts) {
          html2 += `
          <tr>
          <td>${cohorts[c].cohortName}</td>
          <td>${cohorts[c].enrollmentStartDate} ${cohorts[c].enrollmentStartTime} to ${cohorts[c].enrollmentEndDate} ${cohorts[c].enrollmentEndTime}</td>
          <td>${cohorts[c].cohortStartDate} ${cohorts[c].cohortStartTime} to ${cohorts[c].cohortEndDate} ${cohorts[c].cohortEndTime}</td>
          <td>${cohorts[c].trainerName}</td>`
          compare1 = new Date(cohorts[c].enrollmentStartDate)
          compare2 = new Date(cohorts[c].enrollmentEndDate)
          today = new Date()

          if (today > compare2) {
            html2+= `<td><i>closed</i></td>`
          }
          else if (today < compare1) {
            html2+= `<td><i>coming soon</i></td>`
          }
          else {
            if (cohorts[c].slotLeft == 0){
              html2 += `<td><i>cohort full</i></td>`
            }
            else{
              const request2 = new XMLHttpRequest();
              url3 = 'http://10.124.2.10:5000/viewAllRequests/' + emp_name

              request2.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200){
                  let response = JSON.parse(this.responseText);
                  let existingReq = response.requests
                  let counter = 0
                  for (r in existingReq) {
                    if (existingReq[r].courseName == cname && existingReq[r].cohortName == cohorts[c].cohortName) {
                      html2 += `<td><a href="#" class="btn btn-secondary rounded-0 px-4">Withdraw</a></td>`
                      break
                    }
                    else{
                      counter +=1
                      if (counter == existingReq.length){
                        html2 += `<td><a href="#" class="btn btn-primary rounded-0 px-4">Enroll</a></td>`
                      }
                    }
                  }
                }
                else if (this.status == 404) {
                  console.log('its a 404')
                } 
              }
              request2.open("GET", url3, false);
              request2.send();
            }
          }
          html2 += `</tr>`
        }
        
        html2 += `</tbody>
          </table>`
        document.getElementById('cohort').innerHTML = html2
      }

      else if (this.status == 404) {
        console.log('its a 404')
      }
    }
    request1.open("GET", url2, false);
    request1.send();

  </script>

</body>

</html>