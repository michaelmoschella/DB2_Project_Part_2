<?php
/********************************************** 
view-mentor-reviews.php

Provides a list of all mentors that have verified
reviews as well as some overall stats about those 
reviews.
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

    $html_string .=     "
        <table style='width:25%' style='height:15%'>
        <tr>
        <td colspan = '7' style = 'text-align: center;'><h2>List of Mentors with Reviews</h2></td>
        </tr>
        <tr>
            <th>Name</th>
            <th>Username</th>
            <th>Max. Rating</th>
            <th>Min. Rating</th>
            <th>Avg. Rating</th>
            <th>Number of Reviews</th>
            <th>View-Reviews</th
        </tr>";

    /* Get stats for all mentors that have verified reviewed */
    $get_stats_query = "SELECT orID, AVG(rating), MAX(rating), MIN(rating), COUNT(rating) FROM Review WHERE verified=1 GROUP BY orID;"; 
    $result1 = mysqli_query($myconnection, $get_stats_query) or die ('Query failed: ' . mysqli_error($myconnection));
    
    while ($row = mysqli_fetch_row($result1)) {
        $get_mentor_info_query = "SELECT `name`, username from User WHERE uID=$row[0];"; 
        $result2 = mysqli_query($myconnection, $get_mentor_info_query) or die ('Query failed: ' . mysqli_error($myconnection));
        $row2 = mysqli_fetch_row($result2);
            $html_string .="
                <tr>
                    <td>{$row2[0]}</td>
                    <td>{$row2[1]}</td>
                    <td>{$row[2]}</td>
                    <td>{$row[3]}</td>
                    <td>{$row[1]}</td>
                    <td>{$row[4]}</td>
                    <td><a href ='view-reviews.php?orID=".$row[0]."&&orName=".$row2[0]."'>See all reviews</a></td>
                </tr>";
    }
    $html_string .= "
            </table>
       ";
    echo($html_string);

    echo('<h3><a href="student-dashboard.php">Back to dashboard</a></h3>');
    echo('<h3><a href="logout.php">Logout</a></h3>');

    mysqli_close($myconnection);
    exit;
?>

