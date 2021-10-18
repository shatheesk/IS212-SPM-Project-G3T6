<script>
  var current_designation = sessionStorage.getItem('designation');
  var emp_name = sessionStorage.getItem('emp_name');
  console.log(current_designation)
  console.log(emp_name)

    // requests.put(url, params={key: value}, args)

  

  
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
              <h2 class="mb-4">Admissions</h2>
            </div>
          </div>
        </div>
      </div> 
    

    <div class="custom-breadcrumns border-bottom">
      <div class="container">
        <a href="index.php">Home</a>
        <span class="mx-3 icon-keyboard_arrow_right"></span>
        <span class="current">Admissions</span>
      </div>
    </div>


<br>
<center><h1>My Teaching Course List</h1></center>
<br>

<div class="container" id="here">
</div>

<br>
<br>

    <!-- <div class="site-section">
      <div class="container">
  
        <div class="accordion" id="accordionPanelsStayOpenExample"> -->

          <!--loop here-->
          <!-- <div class="accordion-item"> -->
            <!--courseName-->
            <!-- <h2 class="accordion-header" id="panelsStayOpen-headingOne">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="false" aria-controls="panelsStayOpen-collapseOne">
                Accordion Item #1
              </button>
            </h2> -->

            <!--cohortName-->

            <!-- <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
              <div class="accordion-body">
              CohortName, learnerName, It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
              </div>
            </div>
          </div> 

          <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                Accordion Item #2
              </button>
            </h2>
            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
              <div class="accordion-body">
                <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>
-->

<!-- 287 teaching-courses.php (admin) apis - viewAllEnrolledByCourseCohort (BE) -->
    
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


    //logic: to separate multiple cohort courses and only one cohort course.
    //1. Find multiple cohorts courses 
    //for e in enrolledCourses --> [{"":""},{"":""},{"":""}, ...]

    //trainer's perspective
    const request = new XMLHttpRequest();
    url = 'http://127.0.0.1:5000/viewAllEnrolledCourses/' + emp_name;
    
    request.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200){
        let response = JSON.parse(this.responseText);
        let enrolledCourses = response.enrollments;
        console.log(enrolledCourses);
        html = ''

        let counter = 1;
        let i = 1;
        let singleCohortContainer = {"index": [],"courseName": [],"cohortName": [], "cohortSize": []};
        let multipleCohortContainer = {"index": [], "courseName": [],"cohortName": [], "cohortSize": []};
        
        for (i in enrolledCourses){
            // console.log(e);
            console.log(enrolledCourses[i].courseName); // {},
            console.log(singleCohortContainer.courseName); 
            // var courseName = enrolledCourses[i].courseName; // works
            // console.log(enrolledCourses[2].courseName); // introduction to python
            // console.log(singleCohortContainer[e].courseName);
            // console.log(singleCohortContainer);
            
            if (singleCohortContainer.courseName.includes(enrolledCourses[i].courseName)){
                //store index
                // console.log(singleCohortContainer);
                // console.log(enrolledCourses.courseName); //introduction to life, python,python
                multipleCohortContainer["index"].push(i);
                multipleCohortContainer["courseName"].push(enrolledCourses[i].courseName);
                multipleCohortContainer["cohortName"].push(enrolledCourses[i].cohortName);
                multipleCohortContainer["cohortSize"].push(enrolledCourses[i].cohortSize);
                // console.log(enrolledCourses[0].courseName)

            } 
            else{ 
                //unqiue
                singleCohortContainer["index"].push(i);
                singleCohortContainer["courseName"].push(enrolledCourses[i].courseName);
                singleCohortContainer["cohortName"].push(enrolledCourses[i].cohortName);
                singleCohortContainer["cohortSize"].push(enrolledCourses[i].cohortSize);
            }
        }
    
        // console.log(singleCohortContainer.courseName); // return array
        // console.log(multipleCohortContainer.courseName);
        console.log(multipleCohortContainer);
        // console.log(singleCohortContainer); //{index: Array(3), courseName: Array(3), cohortName: Array(3), cohortSize: Array(3)}
        let completedContainer = {};
        for (e in enrolledCourses){
            // console.log(e); // 0, 1 
            // console.log(multipleCohortContainer); //only have G3    
            

            //@shathees can help me solve this part. 
            //@here they go pass "intro to python agn" becos of first loop... -> so must prevent same courseName in multiple to go in agn. i want to make a container to check the passing of result 
            if (enrolledCourses[e].courseName.includes(multipleCohortContainer.courseName)){
                counter +=1;

                //make use of index.
                if(enrolledCourses[e].courseName == multipleCohortContainer.courseName){
                console.log(enrolledCourses[e].cohortName); // G2, G3
                html += `
                <div class="accordion-item">
                        <!--courseName-->
                        <h2 class="accordion-header" id="panelsStayOpen-heading${counter}">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse${counter}" aria-expanded="false" aria-controls="panelsStayOpen-collapse${counter}">
                            <p>
                    ${enrolledCourses[e].courseName}
                            </p>
                          </button>
                        </h2>
                        <!--cohortName-->
                        <div id="panelsStayOpen-collapse${counter}" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-heading${counter}">
                          <div class="accordion-body" id="insert">
                          <table class="table">
                          <thead>
                            <tr>
                              <th scope="col">Cohort Name</th>
                              <th scope="col">Class Period</th>
                              <th scope="col">Class Size</th>
                              <th scope="col">Class List</th>
                              <th scope="col">Section</th>

                            </tr>
                            </thead>
                            <tr>
                            <td>
                          ${enrolledCourses[e].cohortName} 
                          </td>
                          <td>
                          date
                          </td>
                          <td>
                          ${enrolledCourses[e].cohortSize}
                          </td>
                          <td>
                          <button type="button" class="btn btn-info" onclick="#";">Class Size</button>
                          </td>
                          <td>
                          <button type="button" class="btn btn-primary" onclick="#">Go to Cohort Resources</button>
                          </td>
                          </tr>

                  `
              //loop rows of multipleCohortContainer in the same accordian
                // for (index in multipleCohortContainer){ //only have G3 {index: '',}
                    // console.log(multipleCohortContainer);
                // if(enrolledCourses[e].courseName == multipleCohortContainer.courseName){
                    html+=
                      `
                    <!--data rows-->
                          <tr>
                          <td>
                          ${multipleCohortContainer.cohortName} 
                          </td>
                          <td>
                          date
                          </td>
                          <td>
                          ${multipleCohortContainer.cohortSize}
                          </td>
                          <td>
                          <button type="button" class="btn btn-info" onclick="#";">Class Size</button>
                          </td>
                          <td>
                          <button type="button" class="btn btn-primary" onclick="#">Go to Cohort Resources</button>
                          </td>
                          </tr>
                      `
                }
          
                html+=
                `
                <!--end div-->
                          </table>
                          
                          </div>
                        </div>
                        </div>
                `
            }// end if 
            
            
            else{
            
              // for (e in enrolledCourses){
                html += `
                <div class="accordion-item">
                        <!--courseName-->
                        <h2 class="accordion-header" id="panelsStayOpen-heading${counter}">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse${counter}" aria-expanded="false" aria-controls="panelsStayOpen-collapse${counter}">
                            <p>
                    ${enrolledCourses[e].courseName}
                            </p>
                          </button>
                        </h2>
                        <!--cohortName-->
                        <div id="panelsStayOpen-collapse${counter}" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-heading${counter}">
                          <div class="accordion-body" id="insert">
                          <table class="table">
                          <thead>
                            <tr>
                              <th scope="col">Cohort Name</th>
                              <th scope="col">Class Period</th>
                              <th scope="col">Class Size</th>
                              <th scope="col">Class List</th>
                              <th scope="col">Section</th>

                            </tr>
                          </thead>
                        <!--data rows-->
                          <tr>
                          <td>
                          ${enrolledCourses[e].cohortName} 
                          </td>
                          <td>
                          ${enrolledCourses[e].cohortEndDate}
                          </td>
                          <td>
                          ${enrolledCourses[e].cohortSize}
                          </td>
                          <td>
                          <button type="button" class="btn btn-info" onclick="#";">Class Size</button>
                          </td>
                          <td>
                          <button type="button" class="btn btn-primary" onclick="#">Go to Cohort Resources</button>
                          </td>
                          </tr>

                            <!--end div-->
                          </table>
                          
                          </div>
                        </div>
                        </div>

                `

              
            }// end else
    
        } //end for
        document.getElementById('here').innerHTML = html
      }//200

      else if (this.status == 404) {
        console.log('its a 404')
      }
    }
    request.open("GET", url, false);
    request.send();


   

  </script>

</body>

</html>