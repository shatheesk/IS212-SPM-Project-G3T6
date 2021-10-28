<script>
  var current_designation = sessionStorage.getItem('designation');
  var emp_name = sessionStorage.getItem('emp_name');
  console.log(current_designation)
  console.log(emp_name)

  Date.prototype.monthNames = [
  "January", "February", "March",
  "April", "May", "June",
  "July", "August", "September",
  "October", "November", "December"
  ];

  Date.prototype.getMonthName = function() {
      return this.monthNames[this.getMonth()];
  };
  Date.prototype.getShortMonthName = function () {
      return this.getMonthName().substr(0, 3);
  };

  function setEnrollmentPeriod(courseName, cohortName, index) {
    let stddte = document.getElementById('eStdDte'+index).value;
    let stdtime = document.getElementById('eStdTime'+index).value;
    let enddte = document.getElementById('eEndDte'+index).value;
    let endtime = document.getElementById('eEndTime'+index).value;

    let SD_Y = new Date(stddte).getFullYear()
    let SD_M = new Date(stddte).getShortMonthName()
    let SD_D = new Date(stddte).getDate()
    if (SD_D < 10) {
      SD_D = '0' + SD_D
    }
    let SD = SD_D + ' ' + SD_M + ' ' + SD_Y

    let ED_Y = new Date(enddte).getFullYear()
    let ED_M = new Date(enddte).getShortMonthName()
    let ED_D = new Date(enddte).getDate()
    if (ED_D < 10) {
      ED_D = '0' + SD_D
    }
    let ED = ED_D + ' ' + ED_M + ' ' + ED_Y

    const request3 = new XMLHttpRequest();
    url3 = 'http://192.168.50.80:5000/setEnrollmentPeriod/' + courseName + '/' + cohortName + '/' + SD + '/' + stdtime + '/' + ED + '/' + endtime
    
    request3.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200){
        location.reload();
      }

      else if (this.status == 404) {
        console.log('its a 404')
      }
    }
    request3.open("GET", url3, false);
    request3.send();
  }

  function setDateForEnd(index) {
    console.log(document.getElementById("eEndDte"+index))
    // $('#eEndDte'+index).datepicker({ 
    //   startDate: 0
    // });
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
              <h2 class="mb-4">Assign</h2>
            </div>
          </div>
        </div>
      </div> 
    

    <div class="custom-breadcrumns border-bottom">
      <div class="container">
        <a href="index.php">Home</a>
        <span class="mx-3 icon-keyboard_arrow_right"></span>
        <span class="current">Assign</span>
      </div>
    </div>


    <br>
        <center><h1>Course List</h1></center>
    <br>

      <div class="container" id="coursesAccord">

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
  const request = new XMLHttpRequest();
    url = 'http://192.168.50.80:5000/viewAllCourses' 
    
    request.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200){
        let response = JSON.parse(this.responseText);
        let courses = response.courses;
        html = ''
        let counter = 0; 
        let index = 0;
        let index1 = 0;
        // html += `<div class="accordion" id="accordionPanelsStayOpenExample">`

        for (c in courses){
          html += `
          <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-heading${counter}">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse${counter}" aria-expanded="false" aria-controls="panelsStayOpen-collapse${counter}">
                ${courses[c].courseName}
              </button>
            </h2>
            
            <div id="panelsStayOpen-collapse${counter}" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-heading${counter}">
              <div class="accordion-body">
                <p>Prerequisites: `
                if (courses[c].prerequisite[0] == '') {
                  html += `NIL`
                }
                else {
                  let temp = ''
                  for (p in courses[c].prerequisite) {
                    temp += `${courses[c].prerequisite[p]}, `
                  }
                  temp = temp.substring(0, temp.length - 2);
                  html += temp
                }
                
                html+=`</p>
                  <table class="table">
                  <thead>
                    <tr>
                      <th style="text-align:center" scope="col">Cohort</th>
                      <th style="text-align:center" scope="col">Enrollment Period</th>
                      <th style="text-align:center" scope="col">Class Period</th>
                      <th style="text-align:center" scope="col">Trainer</th>
                      <th style="text-align:center" scope="col">Slots Left</th>
                      <th style="text-align:center" scope="col">Classlist</th>
                      <th style="text-align:center" scope="col">Set Enrollment Period</th>
                      <th style="text-align:center" scope="col">Assign?</th>
                    </tr>
                  </thead>
                    <tbody>`

                const request1 = new XMLHttpRequest();
                url1 = 'http://192.168.50.80:5000/viewAllCohort/' + courses[c].courseName

                request1.onreadystatechange = function () {
                  if (this.readyState == 4 && this.status == 200) {
                    let response = JSON.parse(this.responseText);
                    let cohorts = response.cohorts;
                    today = new Date();

                    for (coh in cohorts) {
                      html += `<tr>
                        <td style="text-align:center">${cohorts[coh].cohortName}</td>
                        <td style="text-align:center">${cohorts[coh].enrollmentStartDate} ${cohorts[coh].enrollmentStartTime} <br>to<br> ${cohorts[coh].enrollmentEndDate} ${cohorts[coh].enrollmentEndTime}</td>
                        <td style="text-align:center">${cohorts[coh].cohortStartDate} ${cohorts[coh].cohortStartTime} <br>      to<br> ${cohorts[coh].cohortEndDate} ${cohorts[coh].cohortEndTime}</td>
                        <td style="text-align:center">${cohorts[coh].trainerName}</td>
                        <td style="text-align:center">${cohorts[coh].slotLeft}</td>
                        <td style="text-align:center"><a href="#" style="text-decoration:underline" data-toggle="modal" data-target="#classlistModal${index}">Classlist</a></td>`

                        compare = new Date(cohorts[coh].cohortStartDate)
                        if (today >= compare) {
                          html += `<td colspan=2 style="text-align:center"><i>Cohort has started or ended</i></td>
                                  </tr>`
                        }
                        else {
                          html += `<td style="text-align:center"><a href="#" style="text-decoration:underline" data-toggle="modal" data-target="#ePeriodModal${index}">Set Enrolment Period</a></td>
                                      <td style="text-align:center"><a class="btn btn-secondary rounded-2 px-4" href="assign-learners.php?cname=${courses[c].courseName}&cohname=${cohorts[coh].cohortName}&SL=${cohorts[coh].slotLeft}">Assign</a></td>
                                  </tr>`
                        }

                      html += ` 
                      <div class="modal fade" id="classlistModal${index}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLongTitle">Enrolled Learners</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button> 
                            </div>
                            <div class="modal-body">`
                      
                      const request2 = new XMLHttpRequest();
                      url2 = 'http://192.168.50.80:5000/viewAllEnrolledLearners/' + courses[c].courseName + '/' + cohorts[coh].cohortName
                      
                      request2.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200){
                          let response = JSON.parse(this.responseText);
                          let enrolledLearners = response.EnrolledLearners;

                          if (enrolledLearners.length > 0){
                            for (eL in enrolledLearners){
                              html += `${enrolledLearners[eL]} <br>`
                            }
                          }
                          else{
                            html += `<i>No learners enrolled</i>`
                          }
                          
                        }

                        else if (this.status == 404) {
                          console.log('its a 404')
                        }
                      }
                      request2.open("GET", url2, false);
                      request2.send();
                      
                      html+= `</div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                      </div>`


                      html += ` 
                      <div class="modal fade" id="ePeriodModal${index}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLongTitle">Set Enrollment Period</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button> 
                            </div>

                            <div class="modal-body">
                              <div>
                                <label for="eStdDte">Start Date</label>
                                <input type="date" id="eStdDte${index}" class="form-control form-control-lg" onchange="setDateForEnd('${index}')">

                                <label for="eStdTime">Start Time</label>
                                <input type="time" id="eStdTime${index}" class="form-control form-control-lg">

                                <label for="eEndDte">End Date</label>
                                <input type="date" id="eEndDte${index}" class="form-control form-control-lg">

                                <label for="eEndTime">End Time</label>
                                <input type="time" id="eEndTime${index}" class="form-control form-control-lg">
                              </div>
                            </div>
                            
                            <div class="modal-footer">
                              <button type="button" class="btn btn-primary" onClick="setEnrollmentPeriod('${courses[c].courseName}', '${cohorts[coh].cohortName}', '${index}')">Set</button>
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                      </div>`
                      index += 1
                    }
                  }
                  else if (this.status == 404) {
                    console.log('its a 404')
                  }
                }
                request1.open("GET", url1, false);
                request1.send();

                      html+=`
                    </tbody>
                  </table>                    
                </div>
              </div>
          </div>`
          counter += 1
            
        }

        // html += `</div>`
           document.getElementById('coursesAccord').innerHTML = html ;
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