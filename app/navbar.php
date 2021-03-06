<script>
  var current_designation = sessionStorage.getItem('designation');
  var emp_name = sessionStorage.getItem('emp_name');
</script>

<?php
  $page_name = basename($_SERVER['PHP_SELF']);
  $page_name = substr($page_name, 0, -4);

  $page_navcat = '';
  if (in_array($page_name,['courses', 'course-single','completed-courses','enrolled-courses','pending-courses'])){
    $page_navcat = 'courses';
  }
  elseif (in_array($page_name, ['index'])){
    $page_navcat = 'home';
  }
  elseif (in_array($page_name, ['admissions'])){
    $page_navcat = 'admissions';
  }
  elseif (in_array($page_name, ['assign', 'assign-learners'])){
    $page_navcat = 'assign';
  }
  elseif (in_array($page_name, ['teaching-courses'])){
    $page_navcat = 'teaching-courses';
  }
?>

<header class="site-navbar py-4 js-sticky-header site-navbar-target" role="banner">
    <div class="container">
        <div class="d-flex align-items-center">

          <div class="site-logo">
            <a href="index.php" class="d-block">
              <img src="images/AIOlogo.png" style="width: 160px; height: 50px !important;" alt="Image" class="img-fluid">
            </a>
          </div>

          <div class="mr-auto">
            <nav class="site-navigation position-relative text-right" role="navigation">
              
              <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">
                <li <?php if ($page_navcat == 'home') { ?> class="active" <?php } ?> >
                  <a href="index.php" class="nav-link text-left">Home</a>
                </li>
                
                <!-- <li>
                  <a href="#" class="nav-link text-left">About Us</a>
                </li> -->

                <li <?php if ($page_navcat == 'courses') { ?> class="active" <?php } ?> >
                  <a href="courses.php" class="nav-link text-left">Courses</a>
                </li>
                
                <li>
                  <a href="#" class="nav-link text-left">Contact</a>
                </li>
                
                <li id='admissions' <?php if ($page_navcat == 'admissions') { ?> class="active" <?php } ?> >

                </li>

                <li id='assign' <?php if ($page_navcat == 'assign') { ?> class="active" <?php } ?> >

                </li>

                <li id='teaching-courses' <?php if ($page_navcat == 'teaching-courses') { ?> class="active" <?php } ?> >

                </li>

              </ul>
              
            </nav>
          </div>

          <div class="ml-auto" >
            <nav class="site-navigation position-relative text-right" role="navigation" id="login_or_user">

            </nav>
          </div>
    
        </div>
    </div>

    <script>
      if (current_designation == 'Admin') {
        document.getElementById('admissions').innerHTML = `<a href="admissions.php" class="nav-link text-left">Admissions</a>`
        document.getElementById('assign').innerHTML = `<a href="assign.php" class="nav-link text-left">Assign</a>`
      }

      if (current_designation == 'trainer') {
        document.getElementById('teaching-courses').innerHTML = `<a href="teaching-courses.php" class="nav-link text-left">Teaching Courses</a>`
      }

      if (emp_name) {
        let result = 
        `<ul class="site-menu main-menu js-clone-nav ml-auto d-none d-lg-block">
          <li class="has-children">
            <a class="nav-link text-left">${emp_name}</a>
            <ul class="dropdown">
              <li><a href="#">Profile</a></li>`
              
        if (current_designation == 'Learner' || current_designation == 'trainer'){
          result +=`<li><a href="enrolled-courses.php">Enrolled Courses</a></li>
              <li><a href="pending-courses.php">Pending Courses</a></li>
              <li><a href="completed-courses.php">Completed Courses</a></li>`
        }
        
        result += `  <li><a onclick="logout()">Log Out</a></li>
                        </ul>
                      </li>
                    </ul>`
        document.getElementById('login_or_user').innerHTML = result
      }
      else {
        document.getElementById('login_or_user').innerHTML = `<a href="login.php" class="small mr-3"><span class="icon-unlock-alt"></span> Log In</a>`
      }

      function logout() {
        sessionStorage.clear();
        location.href = "index.php";
      }
    </script>

</header>


