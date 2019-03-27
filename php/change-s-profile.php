<?php
/********************************************** 
change-p-profile.php

Gives inputs for student to change their 
profile information
***********************************************/
    session_start();
    
    $myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');
    
    $active_id = $_SESSION['active_ID'];
    
    /* Get students current profile information*/
    $get_info_query = "SELECT name, username, password, email, phone, role FROM User WHERE {$active_id} = uID;";
    $result1 = mysqli_query($myconnection, $get_info_query) or die ('Query failed: ' . mysqli_error($myconnection));
    $row = mysqli_fetch_row($result1);
    mysqli_free_result($result1);
    
    echo('<h1>Change Your Profile as a Student User</h1>');
    
    $html_string = "<form action='s-profile-altered.php' method='POST'>
            <label>
                Name:
                <input placeholder='{$row[0]}' type='text' name='Student_Name'><br>
            <label>
            <label>
                Username:
                <input placeholder='{$row[1]}' type='text' name='s_username'><br>
            </label>
            <label>
                PWD:
                <input placeholder='New Password' type='password' name='Student_Pass'><br>
            </label>
            <label>
                Confirm:
                <input placeholder='Confirm password' type='password' name='Student_Confirm_Pass'><br>
            </label>
            <label>
                Phone:
                <input placeholder='{$row[4]}' type='text' name='Student_Phone_Number'><br>
            </label>
            <label>
                Email:
                <input placeholder='{$row[3]}' type='text' name='s_Email'><br>
            </label>
            <label>
                Role:
                <select name='s_role'>
                    <option value='Both'>Both</option>
                    <option value='Mentor'>Mentor</option>
                    <option value='Mentee'>Mentee</option>
                    <option value='None'>None</option>
                </select><br>
            </label>
            <button>Submit Changes</button>
        </form>";

    echo($html_string);
    echo("<h3><a href='student-dashboard.php'>Back to dashboard</a></h3>");
    echo("<h3><a href='logout.php'>Logout</a><h3>");

    mysqli_close($myconnection);
    exit;
?>
