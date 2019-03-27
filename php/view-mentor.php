<?php
/********************************************** 
view-mentor.php

Provides a list of all mentors and mentees enrolled
in sections that the logged in student is mentoring
***********************************************/
    session_start();
    
    $myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');
    
    $active_id = $_SESSION['active_ID'];
    
    $html_string = "
    <h1>Section List</h1>

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

    /* Get list of all sections the logged in student is mentoring*/
    $get_sec_info_query = "SELECT Section.name, Course.title, Teaches.secID,Teaches.cID FROM Section, Course, Teaches 
    WHERE {$active_id} = Teaches.orID AND Section.cID = Teaches.cID AND Section.secID = Teaches.secID AND Course.cID = Teaches.cID;";
    $result1 = mysqli_query($myconnection, $get_sec_info_query) or die ('Query failed: ' . mysqli_error($myconnection));
    while ($row = mysqli_fetch_row($result1)) {
        $html_string .=     
            "<label>
                <h2>{$row[1]} {$row[0]}</h2>
                <table style='width:25%' style='height:15%'>
                <tr>
                    <th>Username</th>
                    <th>Grade</th>
                    <th>Email</th>
                </tr>
                <tr>
                    <td colspan = '3' style = 'text-align: center;'>Mentees</td>
                </tr>";
        /* Get list of all mentors enrolled in that section*/
        $get_mentors_query = "SELECT User.username, Student.grade, User.email FROM Teaches, User, Student 
            WHERE Teaches.orID = User.uID AND Teaches.orID = Student.sID AND Teaches.secID = $row[2] AND Teaches.cID = $row[3];";
        $result2 = mysqli_query($myconnection, $get_mentors_query) or die ('Query failed: ' . mysqli_error($myconnection));
        /* Get list of all mentees enrolled in that section*/
        $get_mentees_query = "SELECT User.username, Student.grade, User.email FROM Learns, User, Student 
            WHERE Learns.eeID = User.uID AND Learns.eeID = Student.sid AND Learns.secID = $row[2] AND Learns.cID = $row[3];";
        $result3 = mysqli_query($myconnection, $get_mentees_query) or die ('Query failed: ' . mysqli_error($myconnection));
        while($a_row = mysqli_fetch_row($result3)){
            $html_string .="
                <tr>
                    <td>{$a_row[0]}</td>
                    <td>{$a_row[1]}</td>
                    <td>{$a_row[2]}</td>
                </tr>";
        }
        mysqli_free_result($result3);
        $html_string .= "
                <tr>
                    <td colspan='3' style = 'text-align: center;'>Mentors</td>
                </tr>";
        while($a_row = mysqli_fetch_row($result2)){        
             $html_string .= "   
                <tr>
                    <td>{$a_row[0]}</td>
                    <td>{$a_row[1]}</td>
                    <td>{$a_row[2]}</td>
                </tr>
            ";
        }
        mysqli_free_result($result2);

        $html_string .= "
            </table>
        <label>";
    }
    mysqli_free_result($result1);

    echo($html_string);

    echo('<h3><a href="student-dashboard.php">Back to dashboard</a></h3>');
    echo('<h3><a href="logout.php">Logout</a></h3>');

    mysqli_close($myconnection);
    exit;
?>
