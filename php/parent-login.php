<?php
/********************************************** 
parent-login.php

Check that parent entered correct email and password
and start session holding their uID
***********************************************/
    session_start();
    $p_email = $_POST['Parent_Email_Login'];
    $p_pass = $_POST['Parent_Pass_Login'];

    $myconnection = mysqli_connect('localhost', 'root', '')
    or die ('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');

    $get_pass_query = "SELECT password, username, uID FROM User WHERE email = \"{$p_email}\" AND uID IN
    (SELECT pID FROM Parent);";
    $result1 = mysqli_query($myconnection, $get_pass_query) or die ('Query failed: ' . mysqli_error($myconnection));
    $row = mysqli_fetch_row($result1);
    if ($row){
        $p_stored_pass = $row[0];
        $p_username = $row[1];
        if ($p_stored_pass == $p_pass) {
            $_SESSION["active_ID"] = $row[2];
            echo("<h1>Welcome {$p_username}, you have successfully logged in!</h1>
                <h3><a href='./parent-dashboard.php'>Click here to go to your parent dashboard</a></h3>
                <h5><a href='./logout.php'>Logout</a></h5>");
        } else {
            echo("<h1>Sorry, the provided password does not match the account for {$p_email}</h1>
            <h3><a href='../Phase2.html'>Back to main page</a></h3>");
        }
    } else {
        echo("<h1>Sorry, the email address {$p_email} is not registered to a parent in our Database</h1>
            <h3><a href='../Phase2.html'>Back to main page</a></h3>");
    }
    mysqli_free_result($result1);

    mysqli_close($myconnection);
    exit;
?>
