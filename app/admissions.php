<script>
  var current_designation = sessionStorage.getItem('designation');
  var emp_name = sessionStorage.getItem('emp_name');
  console.log(current_designation)
  console.log(emp_name)

  function accept(learnerName, courseName, cohortName) {
    const request6 = new XMLHttpRequest();
    url6 = 'http://192.168.50.80:5000/processRequest/' + learnerName + '/' + courseName + '/' + cohortName

    
    request6.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200){
        location.reload();
      }

      else if (this.status == 404) {
        console.log('its a 404')
      }
    }
    // requests.put(url, params={key: value}, args)

    request6.open("GET", url6, false);
    request6.send();  
  }

  function withdraw(learnerName, courseName, cohortName) {
    const request5 = new XMLHttpRequest();
    url5 = 'http://192.168.50.80:5000/delete/' + learnerName + '/' + courseName + '/' + cohortName
    
    request5.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200){
        location.reload();
      }

      else if (this.status == 404) {
        console.log('its a 404')
      }
    }
    request5.open("GET", url5, false);
    request5.send();
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
<center><h1>Course List</h1></center>
<br>

<div class="container" id="here">
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
    // let cName= "Introduction to python";
    url = 'http://192.168.50.80:5000/adminViewAllRequests' 
    
    request.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200){
        let response = JSON.parse(this.responseText);
        let courseRequest = response.requests;
        html = ''
        
        let counter = 0; 
        let index = 0;
        for (course in courseRequest){
          // accordian set 
          
          //when there are more than we request for a course
          if (courseRequest[course].length > 1){
            counter += 1;
            html += `         
            <div class="accordion-item">
              
              <h2 class="accordion-header" id="panelsStayOpen-heading${counter}">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse${counter}" aria-expanded="false" aria-controls="panelsStayOpen-collapse${counter}">
                    ${course}&nbsp;&nbsp;
                    <span class="badge badge-info"> ${courseRequest[course].length}</span>
                </button>
              </h2>
              
              <div id="panelsStayOpen-collapse${counter}" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-heading${counter}">
                <div class="accordion-body" id="insert">
                  <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Cohort</th>
                      <th scope="col">Learner</th>
                      <th scope="col">Approve</th>
                      <th scope="col">Reject</th>
                    </tr>
                  </thead>
                  <tbody>`

            // loop the rows in the same accordian
            for (cohort in courseRequest[course]) {
              html += `                       
              <tr>
                <td>${courseRequest[course][cohort].cohortName} </td>
                <td>${courseRequest[course][cohort].learnerName}</td>
                <td><button type="button" class="btn btn-primary" onclick="accept('${courseRequest[course][index].learnerName}', '${courseRequest[course][index].courseName}', '${courseRequest[course][index].cohortName}');">Accept</button></td>
                <td><button type="button" class="btn btn-danger" onclick="withdraw('${courseRequest[course][index].learnerName}', '${courseRequest[course][index].courseName}', '${courseRequest[course][index].cohortName}');">Reject</button></td>
              </tr>`
            }

            //end table for the specific course
            html+=`
                </tbody>
                </table>
                
                </div>
              </div>
            </div>`  
          }

          //this is for one request per course
          else{
            for (index in courseRequest[course]){
              counter += 1; //number of course
              html+= `
              <div class="accordion-item">
                
                <h2 class="accordion-header" id="panelsStayOpen-heading${counter}">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse${counter}" aria-expanded="false" aria-controls="panelsStayOpen-collapse${counter}">
                      ${course}&nbsp;&nbsp;
                      <span class="badge badge-info"> ${courseRequest[course].length}</span>
                  </button>
                </h2>
                  
                <div id="panelsStayOpen-collapse${counter}" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-heading${counter}">
                  <div class="accordion-body" id="insert">
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">Cohort</th>
                          <th scope="col">Learner</th>
                          <th scope="col">Approve</th>
                          <th scope="col">Reject</th>
                        </tr>
                      </thead>

                      <tbody>
                        <tr>
                          <td>${courseRequest[course][index].cohortName} </td>
                          <td>${courseRequest[course][index].learnerName}</td>
                          <td><button type="button" class="btn btn-primary" onclick="accept('${courseRequest[course][index].learnerName}', '${courseRequest[course][index].courseName}', '${courseRequest[course][index].cohortName}');">Accept</button></td>
                          <td><button type="button" class="btn btn-danger" onclick="withdraw('${courseRequest[course][index].learnerName}', '${courseRequest[course][index].courseName}', '${courseRequest[course][index].cohortName}');">Reject</button></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>`
            }//end for    
          } //end else
        }//end all the course in courseRequest
    
           document.getElementById('here').innerHTML = html ;
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