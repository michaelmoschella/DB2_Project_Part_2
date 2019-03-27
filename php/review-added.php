<?php
/********************************************** 
review-added.php

Inserts unverified review written by mentee into
the Review table
***********************************************/
    $or_ID = $_POST['or_ID'];
    $ee_ID = $_POST['ee_ID'];
    $c_ID = $_POST['c_ID'];
    $sec_ID = $_POST['sec_ID'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    $myconnection = mysqli_connect('localhost', 'root', '')
    or die ('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');

    /* 0 indicates unverified */
    $update_query = "INSERT INTO Review 
    VALUES ({$or_ID}, {$ee_ID}, ${sec_ID}, ${c_ID}, {$rating}, '{$comment}', 0);";
    $result1 = mysqli_query($myconnection, $update_query) or die ('Query failed: ' . mysqli_error($myconnection));
    
    echo(
        "<h1>Thanks for writing a review friend!</h1>
        <h3><a href='student-dashboard.php'>Back to dashboard</a></h3>
        <h3><a href='logout.php'>Logout</a>"
    );

    mysqli_close($myconnection);
    exit;
?>

