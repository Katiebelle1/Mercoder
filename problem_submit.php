<?php 
    session_start();
    $problemId = $_GET['id'];
    require_once 'prob_pop.php';
    $row = getProbDetails($problemId);
    require_once 'sub_pop.php';
    $table = getSubs($problemId);
    require_once('fill_locations.php');
    //Geocode API Key for function params
    $api_key = 'AIzaSyAV2jXEkwfKvpehW3TGhQMu8FXQrZ16sNQ';
    $mapmarkers = getSubmissions($problemId, $api_key);

    ?>
  
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Problems</title>
  <!-- Favicon-->
  <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
  <!-- Font Awesome icons (free version)-->
  <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
  <!-- Simple line icons-->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.5.5/css/simple-line-icons.min.css" rel="stylesheet" />
  <!-- Google fonts-->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css" />
  <!-- Core theme CSS (includes Bootstrap)-->
  <link href="/mercoder/css/styles.css" rel="stylesheet" />


</head>

<body style="background-color:#FFFF ;">

  <body id="page-top">
      <!-- Navigation-->
      <a class="menu-toggle rounded" href="#"><i class="fas fa-bars"></i></a>
      <nav id="sidebar-wrapper">
            <ul class="sidebar-nav">
                
            <?php
                    //if they are not logged in or have not been assigned a token
                    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == 0) { 
                        echo '<li class="sidebar-brand"><a href="/mercoder/index.php">Home</a></li>
                        <li class="sidebar-nav-item"><a href="/mercoder/PHP/index.php">Login</a></li>
                        <li class="sidebar-nav-item"><a href="/mercoder/index.php#about">About</a></li>
                        <li class="sidebar-nav-item"><a href="/mercoder/PHP/prob_landing.php">Problems</a></li>';
                    } else {   //else they are logged in
                        if($_SESSION['loggedin'] == 2){     //Teacher menu
                            echo '<li class="sidebar-brand"><a href="/mercoder/index.php">Home</a></li>
                            <li class="sidebar-nav-item"><a href="/mercoder/PHP/logout.php">Logout</a></li>
                            <li class="sidebar-nav-item"><a href="/mercoder/index.php#about">About</a></li>
                            <li class="sidebar-nav-item"><a href="/mercoder/PHP/prob_landing.php">Problems</a></li>
                            <li class="sidebar-nav-item"><a href="/mercoder/PHP/problem_form.php">New Problem</a></li>
                            <li class="sidebar-nav-item"><a href="/mercoder/PHP/user_profile.php">View Account</a></li>';
                        } else {    //Student menu
                            echo '<li class="sidebar-brand"><a href="/mercoder/index.php">Home</a></li>
                            <li class="sidebar-nav-item"><a href="/mercoder/PHP/logout.php">Logout</a></li>
                            <li class="sidebar-nav-item"><a href="/mercoder/index.php#about">About</a></li>
                            <li class="sidebar-nav-item"><a href="/mercoder/PHP/prob_landing.php">Problems</a></li>
                            <li class="sidebar-nav-item"><a href="/mercoder/PHP/user_profile.php">View Account</a></li>';
                    }
                    }
                ?>
            </ul>
            
        </nav>
  <!-- ======= Header ======= -->
  <!-- End #header -->

  <main id="main">

<div class = "container">
  
    <section class="content-section" id="submit">
        <div class="container px-4 px-lg-5">
        <div class="content-section-heading text-center">
          <!-- <h2 class="mb-5">Problem title</h2> -->
        <h2 class="mb-5"><?php echo nl2br($row['title']); ?></h2>
        </div>
        <div class="text">

        <div class="container d-flex flex-column align-items-left mb-4">
          <h2>Description</h2>
          <div class="mt-2">
            <div style="font-size:25px;">
              <?php echo nl2br($row['description']); ?>
            </div>
          </div>
        </div>

        <div class="container d-flex flex-column align-items-left mb-4">
          <h2>Description Input</h2>
          <div class="mt-2">
            <div style="font-size:25px;">
              <?php echo nl2br($row['description_input']); ?>
            </div>
          </div>
        </div>

        <div class="container d-flex flex-column align-items-left mb-4">
          <h2>Sample Input</h2>
          <div class="mt-2">
            <div style="font-size:25px;">
              <?php echo nl2br($row['sample_input']); ?>
            </div>
          </div>
        </div>

        <div class="container d-flex flex-column align-items-left mb-4">
          <h2>Description Output</h2>
          <div class="mt-2">
            <div style="font-size:25px;">
              <?php echo $row['description_output']; ?>
            </div>
          </div>
        </div>

        <div class="container d-flex flex-column align-items-left mb-4">
          <h2>Sample Output</h2>
          <div class="mt-2">
            <div style="font-size:25px;">
              <?php echo nl2br($row['sample_output']); ?>
            </div>
          </div>
        </div>

      </div>


        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8">
                    <h2 class="text-white mb-4"></h2>
                    <div id="googleMap" style="width:100%;height:650px;"></div>

                    <?php
                      echo '<script> 
                          var locations = [];
                          locations = ' . $mapmarkers . ';
                          console.log(locations);
                        </script>';
                      ?>
                      <script>
                      
                    function myMap() {
                        
                        var mapProp= {
                          center:new google.maps.LatLng(32.840694,-83.632401),
                          zoom:5,
                        };
                        var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

                        var i, myLatLng, message, marker;
                        if (locations.length !== 0) {

                          for (var i = 0; i < locations.length; i++) {
                          console.log(locations[i].location);
                          console.log(locations[i].lat);
                          console.log(locations[i].lng);
                          }

                            // Function that runs the amount of times that there are items in the array
                            // This allows each marker to get it's own listeniers as well as be plotted on the map.  
                            locations.forEach(function(location, index) {
                                myLatLng = {lat: location.lat, lng:location.lng}
                                marker = new google.maps.Marker({
                                    position: myLatLng, 
                                    map: map, 
                                    title:"Location " + (index + 1)
                                });

                               
                                var infoWindow = new google.maps.InfoWindow({
                                    content:location.location
                                });
                                
                                var markerListener = function() {
                                    infoWindow.open(map, this);
                                    var pos = map.getZoom();
                                    map.setZoom(12);
                                    map.setCenter(this.getPosition());
                                    window.setTimeout(function() {
                                        map.setZoom(pos);
                                    },5000);
                                };
                                

                                marker.addListener('click', markerListener);
                                
                                marker.setMap(map);
                            });
                        }

                        
                        }
                    </script>
                    
        </div>
        
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBfhDoPuP4Hkf_nis_oKqwol7Tk5TuzJA8&callback=myMap"></script>
   </section>

  <?php
    
      //if they are not logged in or have not been assigned a token
      if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1) {   //Student View
        include_once('add_submission.php');
          echo '<div class="row justify-content-center">
          <div class="col-lg-8">
              <form action="add_submission.php" method="post">
                  <div class="form-floating mb-3">
                      <input class="form-control" id="link" name="link" type="text" placeholder="Link" required />
                      <label form="link">Your Answer / Link</label>
                  </div>
                  <input type="hidden" name="problemId" value="' . $problemId . '">
                  <div class="d-grid"><button class="btn btn-primary btn-xl" type="submit">Submit</button></div>
              </form>
          </div>
        </div>';
        }
      if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 2){     //Teacher View
          echo $table;
            }
  ?>
  </main>
  <!-- End #main -->

  <!-- Footer-->
  <footer class="footer text-center">
            <div class="container px-4 px-lg-5">
            <?php
            if(isset($_SESSION['username'])) { 
                echo '<p>'. $_SESSION['username'] .'<p>';
            }
            ?>
                <p class="text-muted small mb-0">Copyright &copy; Table of Lords</p>
            </div>
        </footer>
        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="/mercoder/js/scripts.js"></script>

        
    </body>
</html>
