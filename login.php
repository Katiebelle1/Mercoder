<?php
    require('database_op.php');
    session_start();
    // When form submitted, check and create user session.
    if (isset($_POST['loginusername'])) {
        $username = stripslashes($_REQUEST['loginusername']);    // removes backslashes
        $username = mysqli_real_escape_string($con, $username);
        $password = stripslashes($_REQUEST['loginpassword']);
        $password = mysqli_real_escape_string($con, $password);
        // Check user is exist in the database
        $query  = "SELECT * FROM `teacher_login` WHERE username='$username'
		     AND password='" . md5($password) . "'"; 
	$query2 = "SELECT * FROM `student_login` WHERE username='$username'
		     AND password='" . md5($password) . "'";
	$result = mysqli_query($con, $query) or die(mysql_error());
	$result2 = mysqli_query($con, $query2);
	$rows = mysqli_num_rows($result);
	$rows2 = mysqli_num_rows($result2);
        if ($rows == 1 xor $rows2 == 1) {
            $_SESSION['username'] = $username;
            if ($rows == 1){
                $_SESSION['loggedin'] = 2;
            }
            else {
                $_SESSION['loggedin'] = 1;
            }
            // $_SESSION['loggedin'] = 1;
            // Redirect to user dashboard page
            header("Location: ../index.php");
        } else {
            echo "error";
            header("Location: index.php");
	}
    }
?>

