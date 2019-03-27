<?php
/********************************************** 
s-profile-altered.php

Makes changes to User table based on what information
the student has altered and adds to Mentee and Mentor
tables if necessary.
***********************************************/
    session_start();

    $s_email = $_POST['s_Email']; 
    $s_pass = $_POST['Student_Pass'];
    $s_pass_confirm = $_POST['Student_Confirm_Pass'];
    $s_role = $_POST['s_role'];
    $s_name = $_POST['Student_Name'];
    $s_phone = $_POST['Student_Phone_Number'];
    $s_username = $_POST['s_username'];
    
    $myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');
    
    if ($s_role == 'None') {
        $s_role = 'Student';
    }
    if ($s_role == 'Mentor' || $s_role == 'Both'  ){
        $check_mentor_query = "SELECT count(*) FROM Mentor WHERE orID={$_SESSION['active_ID']};";
        $result1 = mysqli_query($myconnection, $check_mentor_query) or die ('Query failed: ' . mysqli_error($myconnection));
        $row = mysqli_fetch_row($result1);
        if (!$row[0]) {
            $insert_mentor_query = "INSERT INTO Mentor VALUES({$_SESSION['active_ID']});";
            $result1 = mysqli_query($myconnection, $insert_mentor_query) or die ('Query failed: ' . mysqli_error($myconnection));
        }
    }
    if ($s_role == 'Mentee' || $s_role == 'Both'  ){
        $check_mentee_query = "SELECT count(*) FROM Mentee WHERE eeID={$_SESSION['active_ID']};";
        $result1 = mysqli_query($myconnection, $check_mentee_query) or die ('Query failed: ' . mysqli_error($myconnection));
        $row = mysqli_fetch_row($result1);
        if (!$row[0]) {
            $insert_mentee_query = "INSERT INTO Mentee VALUES({$_SESSION['active_ID']});";
            $result1 = mysqli_query($myconnection, $insert_mentee_query) or die ('Query failed: ' . mysqli_error($myconnection));
        }
    }

    /* Build query based on what information changed */
    $update_query = "UPDATE User SET";
    if ($s_email) {
        $update_query .= " email = '${s_email}',"; 
    }
    if ($s_pass) {
        $update_query .= " password = '${s_pass}',"; 
    }
    if ($s_name) {
        $update_query .= " name = '${s_name}',"; 
    }
    if ($s_username) {
        $update_query .= " username = '${s_username}',"; 
    }
    if ($s_phone) {
        $update_query .= " phone = '${s_phone}',"; 
    }
    if ($s_role) {
        $update_query .= " role = '${s_role}',"; 
    }
    $update_query = substr($update_query, 0, -1); #trim off extra ,
    $update_query .= " WHERE uID = {$_SESSION['active_ID']};";
    $result1 = mysqli_query($myconnection, $update_query) or die ('Query failed: ' . mysqli_error($myconnection));
    echo(
        "<h1>Your profile was successfully updated!</h1>
        <h3><a href='student-dashboard.php'>Back to dashboard</a></h3>
        <h3><a href='logout.php'>Logout</a>"
    );

    mysqli_close($myconnection);
    exit;
?>

