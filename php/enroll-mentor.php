<?php
/********************************************** 
enroll-mentor.php

Puts mentor id and section info in the Teaches
table which stores which mentors are enrolled
in which sections.
***********************************************/
    session_start();
  
    $myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');
    
    $active_id = $_SESSION['active_ID'];
    $c_id = $_GET['cID'];
    $sec_id = $_GET['secID'];

    $get_student_info_query = "INSERT INTO Teaches VALUES ({$sec_id}, {$c_id}, {$active_id});";
    $result2 = mysqli_query($myconnection, $get_student_info_query) or die ('Query failed: ' . mysqli_error($myconnection));

    echo('<h1>Congratulations you have successfully enrolled as a Mentor!</h1>');
    echo('<h3><a href="student-view-sections.php">Back to view sections</a></h3>');
    echo('<h3><a href="student-dashboard.php">Back to dashboard</a></h3>');
    echo('<h3><a href="logout.php">Logout</a></h3>');

    mysqli_close($myconnection);
    exit;
?>


