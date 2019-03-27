<?php
/********************************************** 
c-profile-altered.php

makes changes to childs info in User table 
and adds to Mentee and Mentor tables if necessary.
***********************************************/

    $c_ID = $_POST['c_ID'];
    $c_email = $_POST['c_Email'];
    $c_pass = $_POST['Parents_Children_Pass'];
    $c_pass_confirm = $_POST['Parents_Children_Confirm_Pass'];
    $c_role = $_POST['c_role'];
    $c_name = $_POST['Parents_Children_Name'];
    $c_phone = $_POST['Parent_Children_Phone_Number'];
    $c_username = $_POST['c_username'];

    $myconnection = mysqli_connect('localhost', 'root', '')
    or die ('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');

    if ($c_role == 'None') {
        $c_role = 'Student';
    }
    if ($c_role == 'Mentor' || $c_role == 'Both'  ){
        $check_mentor_query = "SELECT count(*) FROM Mentor WHERE orID=$c_ID;";
        $result1 = mysqli_query($myconnection, $check_mentor_query) or die ('Query failed: ' . mysqli_error($myconnection));
        $row = mysqli_fetch_row($result1);
        if (!$row[0]) {
            $insert_mentor_query = "INSERT INTO Mentor VALUES($c_ID);";
            $result1 = mysqli_query($myconnection, $insert_mentor_query) or die ('Query failed: ' . mysqli_error($myconnection));
        }
    }
    if ($c_role == 'Mentee' || $c_role == 'Both'  ){
        $check_mentee_query = "SELECT count(*) FROM Mentee WHERE eeID=$c_ID;";
        $result1 = mysqli_query($myconnection, $check_mentee_query) or die ('Query failed: ' . mysqli_error($myconnection));
        $row = mysqli_fetch_row($result1);
        if (!$row[0]) {
            $insert_mentee_query = "INSERT INTO Mentee VALUES($c_ID);";
            $result1 = mysqli_query($myconnection, $insert_mentee_query) or die ('Query failed: ' . mysqli_error($myconnection));
        }
    }

    /* Build Query based on what fields were changed */
    $update_query = "UPDATE User SET";
    if ($c_email) {
        $update_query .= " email = '${c_email}',";
    }
    if ($c_pass) {
        $update_query .= " password = '${c_pass}',";
    }
    if ($c_name) {
        $update_query .= " name = '${c_name}',";
    }
    if ($c_username) {
        $update_query .= " username = '${c_username}',";
    }
    if ($c_phone) {
        $update_query .= " phone = '${c_phone}',";
    }
    if ($c_role) {
        $update_query .= " role = '${c_role}',";
    }
    $update_query = substr($update_query, 0, -1); #trim off extra comma
    $update_query .= " WHERE uID = {$c_ID};";
    $result1 = mysqli_query($myconnection, $update_query) or die ('Query failed: ' . mysqli_error($myconnection));
    echo(
        "<h1>Your child's profile was successfully updated!</h1>
        <h3><a href='parent-dashboard.php'>Back to dashboard</a></h3>
        <h3><a href='logout.php'>Logout</a>"
    );
    // need to remove from mentor mentee table

    mysqli_close($myconnection);
    exit;
?>
