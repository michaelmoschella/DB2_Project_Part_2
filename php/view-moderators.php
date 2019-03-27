<?php
/********************************************** 
view-moderators.php

Displays a list of all moderators and their 
contact info
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

    $get_moderators_query = "SELECT User.name, User.username, User.email, User.phone FROM User, Moderator 
    WHERE User.uID = Moderator.modID";
    $result1 = mysqli_query($myconnection, $get_moderators_query) or die ('Query failed: ' . mysqli_error($myconnection));
    $html_string .=     
        "<label>
        <table style='width:25%' style='height:15%'>
        <tr>
        <td colspan = '4' style = 'text-align: center;'><h2>List of Moderators</h2></td>
        </tr>
        <tr>
        <th>Name</th>
        <th>Username</th>
        <th>Email</th>
        <th>Phone</th
        </tr>";
    
    while ($row = mysqli_fetch_row($result1)) {
            $html_string .="
                <tr>
                    <td>{$row[0]}</td>
                    <td>{$row[1]}</td>
                    <td><a href =''>{$row[2]}</a></td>
                    <td>{$row[3]}</td>
                </tr>";
    }

    $html_string .= "
            </table>
        <label>";
    
    echo($html_string);

    echo('<h3><a href="student-dashboard.php">Back to dashboard</a></h3>');
    echo('<h3><a href="logout.php">Logout</a></h3>');

    mysqli_close($myconnection);
    exit;
?>

