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
              <h2 class="mb-4">Enrolled Courses</h2> 
            </div>
          </div>
        </div>
      </div> 
    

      <div class="custom-breadcrumns border-bottom">
        <div class="container">
          <a href="index.php">Home</a>
          <span class="mx-3 icon-keyboard_arrow_right"></span>
          <span class="current">Enrolled Courses</span>
        </div>
      </div>

    <div class="site-section">
      <div class="container">
        <!-- <div class = "row">
          <div class="col-lg-12 col-md-12 mb-4">
            <a href="create-edit-class.php" class="btn btn-primary rounded-2 px-4" style="float: right">Create a class!</a>
          </div>
        </div> -->
        
        <div class="row" id="enrolledCourses">
          
        </div>

        <!-- <div class="row mt-4" id="cohort">
  
        </div> -->

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

    const request = new XMLHttpRequest();
    url = 'http://192.168.50.80:5000/viewAllEnrolledCourses/' + emp_name
    
    request.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200){
        let response = JSON.parse(this.responseText);
        let enrolledCourses = response.enrollments
        console.log(enrolledCourses)
        html = ''
        html = `
        <h2 class="section-title-underline mb-5">
          <span>Enrolled Courses Details</span>
        </h2>

        <table class="table">
          <thead>
            <tr>
              <th scope="col">Course</th>
              <th scope="col">Cohort</th>
              <th scope="col">Cohort Period</th>
              <th scope="col">Trainer</th>
              <th scope="col">Class Materials</th>
            </tr>
          </thead>
          <tbody>`
        
        
        for (c in enrolledCourses) {
          compare1 = new Date(enrolledCourses[c].cohortStartDate)
          compare2 = new Date(enrolledCourses[c].cohortEndDate)
          today = new Date()
          html += `
          <tr>
          <td>${enrolledCourses[c].courseName}</td>
          <td>${enrolledCourses[c].cohortName}</td>
          <td>${enrolledCourses[c].cohortStartDate} ${enrolledCourses[c].cohortStartTime} to ${enrolledCourses[c].cohortEndDate} ${enrolledCourses[c].cohortEndTime}</td>
          <td>${enrolledCourses[c].trainerName}</td>`
          if (today >= compare1){
            html += `<td><a href="learner-view-cohort.php?cname=${enrolledCourses[c].courseName}&cohname=${enrolledCourses[c].cohortName}&from=enrolled" class="btn btn-info rounded-2 px-4">View Course Materials</a></td>`
          }
          else {
            html += `<td><i>course not yet started</i></td>`
          }
          html+=`</tr>`
        }
        
        html += `</tbody>
          </table>`
        document.getElementById('enrolledCourses').innerHTML = html
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