<?php
/********************************************** 
view-students.php

Displays a list of all students and their 
contact info as well as their parents
***********************************************/
    session_start();
    
    $myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');

    $html_string = "
    <head>
        <style>
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            td, th {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }
            tr:nth-child(even) {
               background-color: #dddddd;
            }
        </style>
    </head>";

    $get_students_query = "SELECT User.name, User.username, User.email, User.phone, Student.grade, User.uID FROM User, Student
    WHERE User.uID = Student.sID;";
    $result1 = mysqli_query($myconnection, $get_students_query) or die ('Query failed: ' . mysqli_error($myconnection));
    $html_string .=     
        "<label>
        <table style='width:25%' style='height:15%'>
        <tr>
        <td colspan = '5' style = 'text-align: center;'><h2>List of Students</h2></td>
        </tr>
        <tr>
        <th>Name</th>
        <th>Username</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Grade</th>
        </tr>";
    
    while ($row = mysqli_fetch_row($result1)) {
        $html_string .="
        <tr>
        <td>{$row[0]}</td>
        <td>{$row[1]}</td>
        <td><a href =''>{$row[2]}</a></td>
        <td>{$row[3]}</td>
        <td>{$row[4]}</td>
        </tr>";
        
        $html_string .= "  <tr>
            <td colspan = '5' style = 'text-align: center;'>$row[0]'s Parents</td>
            </tr>";
        $get_students_parents_query = "SELECT User.name, User.username, User.email, User.phone uID FROM User, Family
        WHERE Family.sID = $row[5] AND Family.pID = User.uID;";
        $result2 = mysqli_query($myconnection, $get_students_parents_query) or die ('Query failed: ' . mysqli_error($myconnection));
        while ($row2 = mysqli_fetch_row($result2)) {
            $html_string .= "
                <tr>
                    <td>$row2[0]</td>
                    <td>$row2[1]</td>
                    <td><a href=''>$row2[2]</a></td>
                    <td>$row2[3]</td>
                    <td></td>
                </tr>";
        }
        $html_string .= "  
        <tr>
            <td colspan = '5' style = 'text-align: center;'></td>
        </tr>
        <tr>
            <td colspan = '5' style = 'text-align: center;'></td>
        </tr>
        <tr>
            <td colspan = '5' style = 'text-align: center;'></td>
        </tr>
        <tr>
            <td colspan = '5' style = 'text-align: center;'></td>
        </tr>";
    }
    $html_string .= "
            </table>
        <label>";
    
    echo($html_string);

    echo('<h3><a href="parent-dashboard.php">Back to dashboard</a></h3>');
    echo('<h3><a href="logout.php">Logout</a></h3>');

    mysqli_close($myconnection);
    exit;
?>