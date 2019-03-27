<?php
/********************************************** 
change-p-profile.php

Gives inputs for parent to change their 
profile information
***********************************************/
    session_start();
    
    $myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');
    
    $active_id = $_SESSION['active_ID'];
    
    /*Get parents current information from user table*/
    $get_info_query = "SELECT name, username, password, email, phone, role FROM User WHERE {$active_id} = uID;";
    $result1 = mysqli_query($myconnection, $get_info_query) or die ('Query failed: ' . mysqli_error($myconnection));
    $row = mysqli_fetch_row($result1);
    mysqli_free_result($result1);
    
    echo('<h1>Change Your Profile as a Parent User</h1>');
    
    $html_string = "<form action='p-profile-altered.php' method='POST'>
        <label>
            Name:
            <input placeholder='{$row[0]}' type='text' name='Parent_Name'><br>
        <label>

        <label>
            Username:
            <input placeholder='{$row[1]}' type='text' name='p_username'><br>
        </label>
        
        <label>
            PWD:
            <input placeholder='New Password' type='password' name='Parent_Pass'><br>
        </label>

        <label>
            Confirm:
            <input placeholder='Confirm password' type='password' name='Parent_Confirm_Pass'><br>
        </label>

        <label>
            Phone:
            <input placeholder='{$row[4]}' type='text' name='Parent_Phone_Number'><br>
        </label>
        <label>
            Email:
            <input placeholder='{$row[5]}' type='text' name='Parent_Email'><br>
        </label>
        <label>
            Role:
            <select name='p_role'>
                <option value='None'>None</option>
                <option value='Moderator'>Moderator</option>
            </select><br>
        </label>
            <button>Submit Changes</button>
        </form>";

    echo($html_string);
    echo("<h3><a href='parent-dashboard.php'>Back to dashboard</a></h3>");
    echo("<h3><a href='logout.php'>Logout</a><h3>");

    mysqli_close($myconnection);
    exit;
?>