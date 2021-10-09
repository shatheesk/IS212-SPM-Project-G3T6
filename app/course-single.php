<?php
  $code = $_GET['code'];
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
      "prereq" => ['PF1', 'PF2'], 
      "stddte" => '01 Dec 2021', 
      "enddte" => '01 Mar 2022',
      "eligible" => FALSE
    ],
    "IF1" => [
      "img" => 'images/course_4.jpg',
      "code" => 'IF1', 
      "title" => 'Ink Concepts', 
      "desc" => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Similique accusantium ipsam.', 
      "prereq" => [], 
      "stddte" => '01 Sep 2021', 
      "enddte" => '01 Oct 2021',
      "eligible" => TRUE
    ]
  ];

  $classes = [
    "PF1G0" => [
      "code" => 'G0',
      "regstddte" => '09/12/2021 1800', #mon,dte,yr
      "regenddte" => '09/15/2021 1930',
      "classstddte" => '10-10-2021 1800',
      "classenddte" => '16-10-2021 2359',
      "trainer" => "Charles Leclerc",
      "slotsleft" => 2
    ],
    "PF1G1" => [
      "code" => 'G1',
      "regstddte" => '09/26/2021', #mon,dte,yr
      "regenddte" => '10/01/2021',
      "classstddte" => '10-10-2021',
      "classenddte" => '16-10-2021',
      "trainer" => "George Russell",
      "slotsleft" => 8
    ],
    "PF1G2" => [
      "code" => 'G2',
      "regstddte" => '10/05/2021',
      "regenddte" => '10/08/2021',
      "classstddte" => '15-10-2021',
      "classenddte" => '21-10-2021',
      "trainer" => "Lando Norris",
      "slotsleft" => 10
    ],
    "PF1G3" => [
      "code" => 'G3',
      "regstddte" => '10/20/2021',
      "regenddte" => '10/23/2021',
      "classstddte" => '01-11-2021',
      "classenddte" => '07-11-2021',
      "trainer" => "Carlos Sainz",
      "slotsleft" => 7
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

    <?php include 'navbar.php'; ?>
    
    <div class="site-section ftco-subscribe-1 site-blocks-cover pb-4" style="background-image: url('images/bg_1.jpg')">
        <div class="container">
          <div class="row align-items-end">
            <div class="col-lg-7">
              <h2 class="mb-4"><?php echo $courses[$code]['title'];?></h2>
              <!-- <p>Lorem ipsum dolor sit amet consectetur adipisicing.</p> -->
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
        <span class="current"><?php echo $courses[$code]['title'];?></span>
      </div>
    </div>

    <div class="site-section">
        <div class="container">
        <?php if ($user == 'charles'){ ?>
          <div class = "row">
            <div class="col-lg-12 col-md-12 mb-4">
            <a href="create-edit-class.php" class="btn btn-primary rounded-0 px-4" style="float: right">Create a class!</a>
            </div>
          </div>
          <?php
          }
          ?>
          <div class="row">
            <div class="col-md-6 mb-4">
              <p>
                <img src="<?php echo $courses[$code]['img'];?>" alt="Image" class="img-fluid">
              </p>
            </div>

            <div class="col-lg-5 ml-auto align-self-top">
              <h2 class="section-title-underline mb-5">
                  <span>Course Details</span>
              </h2>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. At itaque dolore libero corrupti! Itaque, delectus? Lorem ipsum dolor sit amet consectetur adipisicing elit. At itaque dolore libero corrupti! Itaque, delectus? Lorem ipsum dolor sit amet consectetur adipisicing elit. At itaque dolore libero corrupti! Itaque, delectus? </p>
              <h5>Prerequisites: 
                <?php if (!$courses[$code]['prereq']) {
                    echo 'NIL';
                  }
                  else {
                    $pr = '';
                    foreach ($courses[$code]['prereq'] as $prereq){
                      $pr .= $prereq;
                      $pr .= ', ';
                    }
                    echo substr_replace($pr, "", -2);
                  }?>
              </h5>
            </div>
          </div>

          <div class="row mt-4">
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

              <tbody>
                <?php
                  $today = date("Y-m-d");
                  $today = date("Y-m-d", strtotime($today));

                  foreach ($classes as $class){
                    $regstd = date('Y-m-d', strtotime($class['regstddte']));
                    $regend = date('Y-m-d', strtotime($class['regenddte']));
                    echo "<tr>
                      <td>{$class['code']}</td>
                      <td>{$class['regstddte']} to {$class['regenddte']}</td>
                      <td>{$class['classstddte']} to {$class['classenddte']}</td>
                      <td>{$class['trainer']}</td>";
                    if ($user == 'marcus' || $user == "vera"){
                      if ($today > $regend){
                        echo "<td><i>class full</i></td>";
                      }
                      elseif (($today >= $regstd) && ($today <= $regend)){
                        
                        echo "<td><a class='btn btn-primary rounded-5 px-4' href='#' onclick=","document.getElementById('enroll-class-dialog').style.display='block'"," >Enroll</a></td>";
                      }
                      else{
                        echo "<td><i>coming soon!</i></td>";
                      }
                    }
                    elseif ($user == 'charles'){
                      echo "<td><a class='btn btn-primary rounded-5 px-4' href='#' onclick=","document.getElementById('enroll-class-dialog').style.display='block'"," >Edit</a>   <a class='btn btn-primary rounded-5 px-4' href='#' onclick=","document.getElementById('enroll-class-dialog').style.display='block'"," >Remove</a></td>";
                    }
                    echo "</tr>";
                  }
                ?>
              </tbody>
            </table>
          </div>

        </div>
    </div>
    
    <!-- dialog box for enrolling into class -->
    <!-- <div id="enroll-class-dialog" class="enroll-class-modal">
      <span onclick="document.getElementById('enroll-class-dialog').style.display='none'" class="close" title="Close">&times;</span>
      <form class="enroll-class-modal-content" action="/action_page.php">
        <div class="container">
          <h1>Delete Course</h1>
          <p>Are you sure you want to delete this course?</p>

          <div class="clearfix">
            <button type="button" class="cancelbtn">Cancel</button>
            <button type="button" class="deletebtn">Delete</button>
          </div>
        </div>
      </form>
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