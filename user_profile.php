<?php
session_start();
$username = $_SESSION['username'];
require_once 'database_op.php';
//gathers details for user profile
$sql = "SELECT city, school
        FROM (
          SELECT city, school
          FROM student_login
          WHERE username = ?
          UNION
          SELECT city, school
          FROM teacher_login
          WHERE username = ?
        ) combined_login
        LIMIT 1";

$stmt = $con->prepare($sql);
$stmt->bind_param("ss", $username, $username);
// Execute the statement
$stmt->execute();

// Bind the result to variables
$stmt->bind_result($city, $school);
// Fetch the result
if ($stmt->fetch()) {
    // The city and school variables are bound here
  } else {
    // No result found
  }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>MERCODER</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Simple line icons-->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.5.5/css/simple-line-icons.min.css" rel="stylesheet" />
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="../css/styles.css" rel="stylesheet" />
    </head>

<style>
body{
    background:#eee;
}

.card{
    border:none;

    position:relative;
    overflow:hidden;
    border-radius:8px;
    cursor:pointer;

}

.card:before{
    
    content:"";
    position:absolute;
    left:0;
    top:0;
    width:4px;
    height:100%;
    background-color:#F5CEB5;
    transform:scaleY(1);
    transition:all 0.5s;
    transform-origin: bottom
}

.card:after{
    
    content:"";
    position:absolute;
    left:0;
    top:0;
    width:4px;
    height:100%;
    background-color:#CB5307;
    transform:scaleY(0);
    transition:all 0.5s;
    transform-origin: bottom
}

.card:hover::after{
    transform:scaleY(1);
}

.container {

  width: auto;
  position: absolute;
  top: 40%;
  left: 50%;
  transform: translate(-50%, -50%)
}

.fonts{
    font-size:15px;
}

.social-list{
    display:flex;
    list-style:none;
    justify-content:center;
    padding:0;
}

.social-list li{
    padding:10px;
    color:#CB5307;
    font-size:19px;
}


.buttons button:nth-child(1){
       border:1px solid #CB5307 !important;
       color:#CB5307;
       height:40px;
}

.buttons button:nth-child(1):hover{
       border:1px solid #CB5307 !important;
       color:#fff;
       height:40px;
       background-color:#CB5307;
}

.buttons button:nth-child(2){
       border:1px solid #CB5307 !important;
       background-color:#CB5307;
       color:#fff;
        height:40px;
}
</style>
</head>
<body>
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
                        <li class="sidebar-nav-item"><a href="/mercoder/PHP/prob_landing.php">All Problems</a></li>';
                    } else {   //else they are logged in
                        if($_SESSION['loggedin'] == 2){     //Teacher menu
                            echo '<li class="sidebar-brand"><a href="/mercoder/index.php">Home</a></li>
                            <li class="sidebar-nav-item"><a href="/mercoder/PHP/logout.php">Logout</a></li>
                            <li class="sidebar-nav-item"><a href="/mercoder/index.php#about">About</a></li>
                            <li class="sidebar-nav-item"><a href="/mercoder/PHP/prob_landing.php">All Problems</a></li>
                            <li class="sidebar-nav-item"><a href="/mercoder/PHP/problem_form.php">New Problem</a></li>
                            <li class="sidebar-nav-item"><a href="/mercoder/PHP/user_profile.php">View Account</a></li>';
                        } else {    //Student menu
                            echo '<li class="sidebar-brand"><a href="/mercoder/index.php">Home</a></li>
                            <li class="sidebar-nav-item"><a href="/mercoder/PHP/logout.php">Logout</a></li>
                            <li class="sidebar-nav-item"><a href="/mercoder/index.php#about">About</a></li>
                            <li class="sidebar-nav-item"><a href="/mercoder/PHP/prob_landing.php">All Problems</a></li>
                            <li class="sidebar-nav-item"><a href="/mercoder/PHP/user_profile.php">View Account</a></li>';
                    }
                    }
                ?>
            </ul>
            
        </nav>
<div class="container mt-0">
    
    <div class="row d-flex justify-content-center">
        
        <div class="col-md-5">
            
            <div class="card p-12 py-4 mx-auto">

                <div class="text-center">
                    <img src="../assets/favicon.ico" width="100">
                </div>
                
                <div class="text-center mt-3">

                <?php
                    if(isset($_SESSION['username'])) { 
                        echo '<h5 class="mt-0 mb-0" style="font-size:25px;">'. $_SESSION['username'] .'</h5>
                        <div class="px-2 mt-2">';
                    }
                    if($_SESSION['loggedin'] == 2){     //Teacher menu
                        echo '<span style="font-size:20px; -top:5px;">Teacher</span>';
                    } else {    //Student menu
                            echo '<span style="font-size:20px; -top:5px;">Student</span>';
                    }

                    if (!empty($school)){

                        echo '<p class="fonts mt-2">' . $school . '</p>';
                    }
                    echo '<p class="fonts mt-2">' . $city . '</p>';

                    ?>
                    </div>
                    
                    <div class="buttons mt-5">
                        
                    <a class="btn btn-good btn-xl" href="/mercoder/PHP/update_form.php">Edit Profile</a>
                    <a class="btn btn-good btn-xl ms-3" href="/mercoder/index.php">Home</a>
                    </div>
                    
                    
                </div>
                
               
                
                
            </div>
            
        </div>
        
    </div>

</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="../js/scripts.js"></script>
</body>
</html>
