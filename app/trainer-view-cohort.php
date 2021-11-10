<script>
    var current_designation = sessionStorage.getItem('designation');
    var emp_name = sessionStorage.getItem('emp_name');
    console.log(current_designation)
    console.log(emp_name)
    
    var url_string = window.location.href
    var url = new URL(url_string);
    var cname = url.searchParams.get("cname");
    var cohname = url.searchParams.get("cohname");

</script>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>All-In-One</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Latest compiled and minified CSS -->
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
              <h2 class="mb-4" id="mainTitle">Assign Learners</h2> 
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
            <span class="current" id="cNamecohName"></span>
        </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div id="chaptersContent">

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
    
    document.getElementById('mainTitle').innerText = cname + ' - ' + cohname
    document.getElementById('cNamecohName').innerText = cname + ' - ' + cohname

    const request = new XMLHttpRequest();
    url = 'http://10.124.2.10:5000/getAllChapters/' + cname + '/' + cohname
    
    request.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200){
        let response = JSON.parse(this.responseText);
        console.log(response)
        let chapters = response.chapters
        html = ''   
        
        for (chap in chapters) {
            if (chapters[chap].chapterID != -1) {
                let materials = chapters[chap].materials
                html += `
                <div class="card">
                    <div class="card-header">
                        <b>Chapter ${chapters[chap].chapterID}</b>
                    </div>
                    <div class="card-body">`
                    if (chapters[chap].duration > 0) {
                      html += `
                      <div class="row">
                        <div class="col-lg-4 col-md-4" style="padding-bottom:0px;">
                          <a href="trainer-view-quiz.php?cname=${cname}&cohname=${cohname}&chapter=${chapters[chap].chapterID}" style="text-decoration:underline; padding-right:50px;">View ungraded quiz</a>
                        </div>
                        <div class="col-lg-4 col-md-4" style="padding-bottom:0px;">
                          <a class="btn btn-primary rounded-2 px-4" href="#" style="padding-right:50px; width:217px;">Add Chapter Materials</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                        <div class="col-lg-4 col-md-4" style="padding-bottom:0px;">
                          <a class="btn btn-info rounded-2 px-4" href="create-edit-quiz.php?cname=${cname}&cohname=${cohname}&chapter=${chapters[chap].chapterID}&action=edit" style="padding-right:50px; width:217px;">Edit Ungraded Quiz</a>
                        </div>
                      </div>
                      `
                      for (m in materials) {
                        html += `
                        <div class="row">
                          <div class = "col">
                            Chapter Material ${chapters[chap].chapterID}.${materials[m].materialID} 
                            <a href="${materials[m].materialURL}" target="_blank"><img src="images/svg/eye.svg" height="15px" width="15px" style="margin-left: 8px; margin-bottom: 4px;"></a>
                          </div>
                        </div>`
                      }
                    }
                    else {
                      html += `
                      <div class="row">
                        <div class="col-lg-4 col-md-4" style="padding-bottom:0px;">
                          <i style="padding-right:50px;">Ungraded quiz not created yet</i>
                        </div>
                        <div class="col-lg-4 col-md-4" style="padding-bottom:0px;">
                          <a class="btn btn-primary rounded-2 px-4" href="#" style="padding-right:50px; width:217px;">Add Chapter Materials</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                        <div class="col-lg-4 col-md-4" style="padding-bottom:0px;">
                          <a class="btn btn-info rounded-2 px-4" href="create-edit-quiz.php?cname=${cname}&cohname=${cohname}&chapter=${chapters[chap].chapterID}&action=create" style="padding-right:50px; width:217px;">Create Ungraded Quiz</a>
                        </div>
                      </div>
                      `
                      for (m in materials) {
                        html += `
                        <div class="row">
                          <div class = "col">
                            Chapter Material ${chapters[chap].chapterID}.${materials[m].materialID} 
                            <a href="${materials[m].materialURL}" target="_blank"><img src="images/svg/eye.svg" height="15px" width="15px" style="margin-left: 8px; margin-bottom: 4px;"></a>
                          </div>
                        </div>`
                      }
                    }
                html+=`</div>
                </div>
                `
            }
        }

        for (chap in chapters) {
            if (chapters[chap].chapterID == -1) {
                html += `
                <div class="card">
                    <div class="card-header">
                      <b>Final Quiz</b>
                    </div>
                    <div class="card-body">`
                    if (chapters[chap].duration > 0) {
                        html += `
                        <div class="row">
                          <div class="col-lg-4 col-md-4" style="padding-bottom:0px;">
                            <a href="trainer-view-quiz.php?cname=${cname}&cohname=${cohname}&chapter=${chapters[chap].chapterID}" style="text-decoration:underline; padding-right:50px;">View final quiz</a>
                          </div>
                          <div class="col-lg-8 col-md-4" style="padding-bottom:0px;">
                            <a class="btn btn-info rounded-2 px-4" href="create-edit-quiz.php?cname=${cname}&cohname=${cohname}&chapter=${chapters[chap].chapterID}&action=edit" style="padding-right:50px; width:217px;">Edit Final Quiz</a>
                          </div>
                        </div>
                        `
                    }
                    else {
                        html += `
                        <div class="row">
                          <div class="col-lg-4 col-md-4" style="padding-bottom:0px;">
                            <i style="padding-right:50px;">Final quiz not created yet</i>
                          </div>
                          <div class="col-lg-8 col-md-4" style="padding-bottom:0px;">
                            <a class="btn btn-info rounded-2 px-4" href="create-edit-quiz.php?cname=${cname}&cohname=${cohname}&chapter=${chapters[chap].chapterID}&action=create" style="padding-right:50px; width:217px;">Create Final Quiz</a>
                          </div>
                        </div>
                        `
                    }

                html+=`</div>
                </div>
                `
            }
        }
        document.getElementById('chaptersContent').innerHTML = html;
        
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