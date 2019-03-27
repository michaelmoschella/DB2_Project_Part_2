<?php
/********************************************** 
review-verified.php

If review is accepted by moderator changes 
verified field from 0 to 1 in Review table 
indicating the review has been verified.
Otherwise the review is removed from the Review table
***********************************************/
    $or_ID = $_POST['or_ID'];
    $ee_ID = $_POST['ee_ID'];
    $c_ID = $_POST['c_ID'];
    $sec_ID = $_POST['sec_ID'];
    $email = $_POST['email'];
    $name = $_POST['mentee'];
    $verified = $_POST['verify'];

    $myconnection = mysqli_connect('localhost', 'root', '')
    or die ('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');

    if ($verified) {
        $update_query = "UPDATE Review 
            SET verified=1 WHERE orId=$or_ID AND eeID=$ee_ID AND secID=$sec_ID AND cID=$c_ID;";
        $result1 = mysqli_query($myconnection, $update_query) or die ('Query failed: ' . mysqli_error($myconnection));
        echo(
            "<h1>Thanks for verifying friend!</h1>"
        );
    } else {
        $update_query = "DELETE FROM Review 
            WHERE orId=$or_ID AND eeID=$ee_ID AND secID=$sec_ID AND cID=$c_ID;";
        $result1 = mysqli_query($myconnection, $update_query) or die ('Query failed: ' . mysqli_error($myconnection));
        echo(
            "<h1>You can email {$name} at {$email} to inform them 
            that their review was rejected</h1>"
        );
    }
    echo("
        <h3><a href='parent-dashboard.php'>Back to dashboard</a></h3>
        <h3><a href='logout.php'>Logout</a>"
    );
    mysqli_close($myconnection);
    exit;
?>


