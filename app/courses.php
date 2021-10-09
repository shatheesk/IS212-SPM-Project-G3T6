<?php
  // $user = 'charles'; # HR
  // $user = 'vera'; # trainer
  $user = 'marcus'; # learner
  $courses = [
    "PF1" => [
      "img" => "images/course_1.jpg",
      "code" => 'PF1',
      "title" => 'Printer Fundamentals',
      "desc" => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Similique accusantium ipsam.',
      "prereq" => [],
      "stddte" => '01 Sep 2021',
      "enddte" => '01 Oct 2021',
      "eligible" => TRUE
    ],
    "PF2" => [
      "img" => 'images/course_2.jpg',
      "code" => 'PF2',
      "title" => 'Printer Concepts',
      "desc" => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Similique accusantium ipsam.', 
      "prereq" => ['PF1'], 
      "stddte" => '01 Nov 2021',
      "enddte" => '01 Feb 2022',
      "eligible" => FALSE
    ],
    "PF3" => [
      "img" => 'images/course_3.jpg',
      "code" => 'PF3', 
      "title" => 'Printer Advanced Concepts', 
      "desc" => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Similique accusantium ipsam.', 
      "prereq" => ['PF1', 'PF2','PF1'], 
      "stddte" => '01 Dec 2021', 
      "enddte" => '01 Mar 2022',
      "eligible" => FALSE
    ],
    "IF1" => [
      "img" => 'images/course_4.jpg',
      "code" => 'IF1', 
      "title" => 'Ink Fundamentals', 
      "desc" => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Similique accusantium ipsam.', 
      "prereq" => [], 
      "stddte" => '01 Sep 2021', 
      "enddte" => '01 Oct 2021',
      "eligible" => TRUE
    ]
  ];
?>


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

    <!-- <div class="site-mobile-menu site-navbar-target">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div> -->

    <div class="py-2 bg-light">
      <!-- <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-9 d-none d-lg-block">
            <a href="#" class="small mr-3"><span class="icon-question-circle-o mr-2"></span> Have a questions?</a> 
            <a href="#" class="small mr-3"><span class="icon-phone2 mr-2"></span> 10 20 123 456</a> 
            <a href="#" class="small mr-3"><span class="icon-envelope-o mr-2"></span> info@mydomain.com</a> 
          </div>
          <div class="col-lg-3 text-right">
            <a href="login.php" class="small mr-3"><span class="icon-unlock-alt"></span> Log In</a>
            <a href="register.php" class="small btn btn-primary px-4 py-2 rounded-0"><span class="icon-users"></span> Register</a>
          </div>
        </div>
      </div> -->
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

        <?php if ($user == 'charles'){ ?>
        <div class = "row">
          <div class="col-lg-12 col-md-12 mb-4">
            <a href="create-edit-course.php" class="btn btn-primary rounded-0 px-4" style="float: right">Create a course!</a>
          </div>
        </div>
        <?php } ?>
        
        <div class="row">
          <?php foreach ($courses as $course => $details) { ?>
              <div class="col-lg-4 col-md-6 mb-4">
                <div class="course-1-item">
                  <figure class="thumnail">
                    <a><img src="<?php echo $details['img']?>" alt="Image" class="img-fluid"></a>
                    <!-- <div class="price"><?php echo $details['code']?></div> -->
                    <div class="category"><h3><?php echo $details['title']?></h3></div>   
                  </figure>

                  <div class="course-1-content pb-4">
                    <p class="desc mb-4">
                      <?php echo $details['desc']?>
                    </p>

                    <p class="">
                      <h2>Prerequisites: 
                        <?php if (!$details['prereq']) {
                          echo 'NIL';
                        }
                        else {
                          $pr = '';
                          foreach ($details['prereq'] as $prereq){
                            $pr .= $prereq;
                            $pr .= ', ';
                          }
                          echo substr_replace($pr, "", -2);
                        }?>
                      </h2>

                      <!-- <h2>
                        Course Start Date: <?php echo $details['stddte']?> <br> Course End Date: <?php echo $details['enddte']?>
                      </h2> -->
                      
                      <?php
                      if ($user == 'vera' || $user == 'marcus'){
                        if ($details['eligible']) {?>
                          <a href="course-single.php?code=<?php echo $details['code']?>" class="btn btn-primary rounded-0 px-4">Enroll In This Course</a>
                        <?php
                        }
                        else{?>
                          <h4><i>Ineligible to enroll</i></h4>
                        <?php
                        }
                      }
                      else { ?>
                        <a href="create-course.php?code=<?php echo $details['code']?>" class="btn btn-primary rounded-0 px-4">Edit</a>
                        <a class="btn btn-primary rounded-0 px-4" href="#" onclick="document.getElementById('remove-dialog').style.display='block'" >Remove</a>
                      <?php
                      }
                      ?>
                    </p>
                  </div>
                </div>
              </div>
            <?php } ?>
        </div>
      </div>
    </div>

    <!-- <div class="section-bg style-1" style="background-image: url('images/hero_1.jpg');">
        <div class="container">
          <div class="row">
            <div class="col-lg-4 col-md-6 mb-5 mb-lg-0">
              <span class="icon flaticon-mortarboard"></span>
              <h3>Our Philosphy</h3>
              <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reiciendis recusandae, iure repellat quis delectus ea? Dolore, amet reprehenderit.</p>
            </div>
            <div class="col-lg-4 col-md-6 mb-5 mb-lg-0">
              <span class="icon flaticon-school-material"></span>
              <h3>Academics Principle</h3>
              <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reiciendis recusandae, iure repellat quis delectus ea?
                Dolore, amet reprehenderit.</p>
            </div>
            <div class="col-lg-4 col-md-6 mb-5 mb-lg-0">
              <span class="icon flaticon-library"></span>
              <h3>Key of Success</h3>
              <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reiciendis recusandae, iure repellat quis delectus ea?
                Dolore, amet reprehenderit.</p>
            </div>
          </div>
        </div>
      </div> -->
      
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

</body>

</html>