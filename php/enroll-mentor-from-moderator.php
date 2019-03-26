<?php
    session_start();

    $myconnection = mysqli_connect('localhost', 'root', '')
    or die ('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');

    $c_id = $_GET['c_ID'];
    $sec_id = $_GET['sec_ID'];
    $ses_id = $_GET['ses_ID'];
    $uid = $_GET['uID'];
      $name = $_GET['the_name'];

    $insert_mentor_query = "INSERT INTO SessTeach VALUES ({$ses_id}, {$sec_id}, {$c_id}, {$uid});";
    $result2 = mysqli_query($myconnection, $insert_mentor_query) or die ('Query failed: ' . mysqli_error($myconnection));

    echo("<h1>Congratulations {$name}, you have successfully enrolled as a Mentor!</h1>");
    echo('<h3><a href="parent-moderate-section-session.php">Back to moderation list</a></h3>');
    echo('<h3><a href="parent-dashboard.php">Back to dashboard</a></h3>');
    echo('<h3><a href="logout.php">Logout</a></h3>');

    mysqli_close($myconnection);
    exit;
?>
