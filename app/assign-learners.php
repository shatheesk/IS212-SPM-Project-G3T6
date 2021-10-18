<script>
    var current_designation = sessionStorage.getItem('designation');
    var emp_name = sessionStorage.getItem('emp_name');
    console.log(current_designation)
    console.log(emp_name)

    function searchFunction() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
                } else {
                tr[i].style.display = "none";
                }
            }
        }
    }
    
    var url_string = window.location.href
    var url = new URL(url_string);
    var cname = url.searchParams.get("cname");
    var cohname = url.searchParams.get("cohname");
    var slotLeft = url.searchParams.get("SL");
    slotLeft = Number(slotLeft)
    var noSelected = 0
    var selectedLearners = []

    function handleChange(checkbox, learnerName) {
        if(checkbox.checked == true){
            selectedLearners.push(learnerName.id)
            slotLeft -= 1
            noSelected += 1
            learnerName.style.display = "block"
        }
        else{
            let i = selectedLearners.indexOf(learnerName.id)
            selectedLearners.splice(i, 1)
            slotLeft += 1
            noSelected -= 1
            learnerName.style.display = "none" 
        }

        if (noSelected == 0) {
            document.getElementById('condition').disabled = true
        }
        else {
            document.getElementById('condition').disabled = false
        }
        document.getElementById('slotsRemaining').innerText = 'Slots Remaining: ' + slotLeft
        document.getElementById('noSelected').innerText = 'No of learners selected: ' + noSelected
        console.log(selectedLearners)
    }

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

    <style>
        #myInput {
        /* background-image: url('images/searchicon.png'); Add a search icon to input */
        /* background-position: 10px 12px; Position the search icon */
        /* background-repeat: no-repeat; Do not repeat the icon image */
        width: 100%; /* Full-width */
        font-size: 16px; /* Increase font-size */
        padding: 12px 20px 12px 12px; /* Add some padding */
        border: 1px solid #ddd; /* Add a grey border */
        margin-bottom: 12px; /* Add some space below the input */
        }

        #myTable {
        border-collapse: collapse; /* Collapse borders */
        width: 100%; /* Full-width */
        border: 1px solid #ddd; /* Add a grey border */
        font-size: 18px; /* Increase font-size */
        }

        #myTable th, #myTable td {
        text-align: left; /* Left-align text */
        padding: 12px; /* Add padding */
        }

        #myTable tr {
        /* Add a bottom border to all table rows */
        border-bottom: 1px solid #ddd;
        }

        #myTable tr.header, #myTable tr:hover {
        /* Add a grey background color to the table header and on hover */
        background-color: #f1f1f1;
        }
    </style>

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
              <h2 class="mb-4">Assign Learners</h2> 
            </div>
          </div>
        </div>
      </div> 
    

    <div class="custom-breadcrumns border-bottom">
        <div class="container">
            <a href="index.php">Home</a>
            <span class="mx-3 icon-keyboard_arrow_right"></span>
            <a href="assign.php">Assign</a>
            <span class="mx-3 icon-keyboard_arrow_right"></span>
            <span class="current" id="cNamecohName"></span>
        </div>
    </div>

    <div class="site-section">
      <div class="container">
        <!-- <div class = "row">
          <div class="col-lg-12 col-md-12 mb-4">
            <a href="create-edit-class.php" class="btn btn-primary rounded-2 px-4" style="float: right">Create a class!</a>
          </div>
        </div> -->

        <div class="row">
            <div class="col-lg-12 col-md-12 mb-4">
                <h3 id="slotsRemaining"></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9 col-md-9 mb-4">
                <h3 id="noSelected"></h3>
            </div>
            <div class="col-lg-3 col-md-3 mb-4">
                <button id="condition" type="button" class="btn btn-primary " style="float:right;" disabled onclick="assignNow()">Assign</button>
            </div>
        </div>

        

        <div class="row">
            <div class="col-lg-8 col-md-8 mb-4" id="search">
                test
            </div>
            <div class="col-lg-4 col-md-4 mb-4">
                <h4>
                    <span>Selected Learners</span>
                    <br><br>
                    <div>
                        <ul id = "selectedLearners">

                        </ul>
                    </div>
                </h4>   
            </div>
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
    
    document.getElementById('cNamecohName').innerText = cname + ' - ' + cohname
    document.getElementById('slotsRemaining').innerText = 'Slots Remaining: ' + slotLeft
    document.getElementById('noSelected').innerText = 'No of learners selected: ' + noSelected

    const request = new XMLHttpRequest();
    url = 'http://192.168.50.80:5000/retrieveQualifiedLearners/' + cname + '/' + cohname
    
    request.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200){
        let response = JSON.parse(this.responseText);
        let qualifiedLearners = response.QualifiedLearners
        console.log(qualifiedLearners)
        html = ''
        html2 = ''
        

        html += `
        <input type="text" id="myInput" onkeyup="searchFunction()" placeholder="Search for learners..">

        <table id="myTable">
            <tr class="header">
                <th style="width:60%; text-align:center;" >Name</th>
                <th style="width:40%; text-align:center;">Select</th>
            </tr>`
        for (qL in qualifiedLearners){
            html += `
            <tr>
                <td style="text-align:center;">${qualifiedLearners[qL]}</td>
                <td style="text-align:center;">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" onchange='handleChange(this, ${qualifiedLearners[qL]});'>
                </td>
            </tr>`
            html2 += `
            <li style="display:none;" class="pt-2" id=${qualifiedLearners[qL]}>
                ${qualifiedLearners[qL]}
            </li>`
        }
        html+=`</table>`
        
        document.getElementById('search').innerHTML = html ;
        document.getElementById('selectedLearners').innerHTML = html2 ;
        
      }

      else if (this.status == 404) {
        console.log('its a 404')
      }
    }
    request.open("GET", url, false);
    request.send();

    function assignNow() {
        const request1 = new XMLHttpRequest();
        url1 = 'http://192.168.50.80:5000/assignLearners'

        request1.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 201){
                console.log('success')
                location.href = "assign.php";            
            }

            else if (this.status == 404) {
                console.log('its a 404')
            }
        }

        request1.open("POST", url1, false);
        request1.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        request1.send(JSON.stringify({
            "cohortNameRequest" : cohname,
            "courseNameRequest" : cname,
            "selectedLearners" : selectedLearners
        }));

    }

  </script>

</body>

</html>