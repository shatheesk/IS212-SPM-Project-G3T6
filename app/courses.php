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
    
    <?php include 'navbar.php';?>
    
    <div class="site-section ftco-subscribe-1 site-blocks-cover pb-4" style="background-image: url('images/bg_1.jpg')">
        <div class="container">
          <div class="row align-items-end">
            <div class="col-lg-7">
              <h2 class="mb-4">Courses</h2>
              <!-- <p>Lorem ipsum dolor sit amet consectetur adipisicing.</p> -->
            </div>
          </div>
        </div>
      </div> 
    
    <div class="custom-breadcrumns border-bottom">
      <div class="container">
        <a href="index.php">Home</a>
        <span class="mx-3 icon-keyboard_arrow_right"></span>
        <span class="current">Courses</span>
      </div>
    </div>

    <div class="site-section">
      <div class="container">

        <!-- <div class = "row">
          <div class="col-lg-12 col-md-12 mb-4">
            <a href="create-edit-course.php" class="btn btn-primary rounded-2 px-4" style="float: right">Create a course!</a>
          </div>
        </div> -->
        
        <div class="row" id="allCourses">
          
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
    var totalCourses = ''
    var prereqs = []
    const request = new XMLHttpRequest();
    url = 'http://192.168.50.80:5000/viewAllCourses'
    
    request.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200){
        let response = JSON.parse(this.responseText);
        let courses = response.courses
        totalCourses = courses
        
        html = ''

        for (c in courses) {
          prereqs.push(courses[c].prerequisite)
          html += `
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="course-1-item">

              <figure class="thumnail">
                <a><img src="${courses[c].courseImage}" alt="Image" class="img-fluid"></a>
                <div class="category"><h3>${courses[c].courseName}</h3></div>   
              </figure>

              <div class="course-1-content pb-4">
                <p class="desc mb-4">
                  ${courses[c].courseDescription}
                </p>

                <p class="">
                  <h2>Prerequisites:` 
                  if ([courses[c].prerequisite][0] == ''){
                    html += `<br>NIL`
                  }
                  else {
                    for (p in courses[c].prerequisite) {
                      html += `<br> ${courses[c].prerequisite[p]}`
                      html += `, `
                    }
                    html = html.substring(0, html.length - 2);
                  }
                  html += 
                  `</h2>
                  <div id="eligibility${c}">

                  </div>
                </p>
              </div>

            </div>
          </div>
          `
        }
        document.getElementById('allCourses').innerHTML = html
      }
      else if (this.status == 404) {
        console.log('its a 404')
      }
    }
    request.open("GET", url, false);
    request.send();

    if (current_designation == 'Learner' || current_designation == 'trainer'){
      const request = new XMLHttpRequest();
      url2 = 'http://192.168.50.80:5000/viewAllBadges/' + emp_name
      
      request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200){
          let response = JSON.parse(this.responseText);
          let completedCourses = response.badges
          
          function isTrue(arr, arr2){
            return arr.every(i => arr2.includes(i));
          }

          for (course in totalCourses) {
            if (current_designation == 'Learner') {
              idname = 'eligibility' + course
              prereqCheck = isTrue(prereqs[course], completedCourses)

              if (completedCourses.includes(totalCourses[course].courseName)) {
                document.getElementById(idname).innerHTML = '<h4><i>Completed</i></h4>'
              }
              else if (prereqs[course][0] == ''){
                document.getElementById(idname).innerHTML = `<a href="course-single.php?cname=${totalCourses[course].courseName}" class="btn btn-primary rounded-2 px-4">Enroll In This Course</a>`
              }
              else if (prereqCheck) {
                document.getElementById(idname).innerHTML = `<a href="course-single.php?cname=${totalCourses[course].courseName}" class="btn btn-primary rounded-2 px-4">Enroll In This Course</a>`
              }
              else {
                document.getElementById(idname).innerHTML = '<h4><i>Ineligible to enrol</i></h4>'
              }
            }
            else if(current_designation == 'trainer') {
              var isTeacher = false
              const request = new XMLHttpRequest();
              url4 = 'http://192.168.50.80:5000/viewAllCohort/' + totalCourses[course].courseName
              
              request.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200){
                  let response = JSON.parse(this.responseText);
                  let cohorts = response.cohorts
                  console.log(cohorts)
                  
                  for (coh in cohorts) {
                    if (cohorts[coh].trainerName == emp_name) {
                      isTeacher = true
                    }
                  }
                }
                else if (this.status == 404) {
                  console.log('its a 404')
                }
              }
              request.open("GET", url4, false);
              request.send();

              idname = 'eligibility' + course
              prereqCheck = isTrue(prereqs[course], completedCourses)

              if (isTeacher) {
                document.getElementById(idname).innerHTML = '<h4><i>Currently teaching this course</i></h4>'
              }
              else if (completedCourses.includes(totalCourses[course].courseName)) {
                document.getElementById(idname).innerHTML = '<h4><i>Completed</i></h4>'
              }
              else if (prereqs[course][0] == ''){
                document.getElementById(idname).innerHTML = `<a href="course-single.php?cname=${totalCourses[course].courseName}" class="btn btn-primary rounded-2 px-4">Enroll In This Course</a>`
              }
              else if (prereqCheck) {
                document.getElementById(idname).innerHTML = `<a href="course-single.php?cname=${totalCourses[course].courseName}" class="btn btn-primary rounded-2 px-4">Enroll In This Course</a>`
              }
              else {
                document.getElementById(idname).innerHTML = '<h4><i>Ineligible to enrol</i></h4>'
              }
            }
            
            
          }
        }
        else if (this.status == 404) {
          console.log('its a 404')
        }
      }
      request.open("GET", url2, false);
      request.send();
    }

    if (current_designation == 'Learner'){
      const request = new XMLHttpRequest();
      url3 = 'http://192.168.50.80:5000/viewAllEnrolledCourses/' + emp_name
      
      request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200){
          let response = JSON.parse(this.responseText);
          let enrolledCourses = response.enrollments

          for (course in totalCourses) {
            idname = 'eligibility' + course

            for (c in enrolledCourses){
              if (enrolledCourses[c].courseName == totalCourses[course].courseName) {
                document.getElementById(idname).innerHTML = '<h4><i>Currently enrolled</i></h4>'
              }
            }
          }
        }
        else if (this.status == 404) {
          console.log('its a 404')
        }
      }
      request.open("GET", url3, false);
      request.send();
    }
    
  </script>

</body>

</html>