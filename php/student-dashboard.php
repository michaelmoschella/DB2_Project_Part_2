<?php
    session_start();
    
    $myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');
    
    $active_id = $_SESSION['active_ID'];
    
    $get_info_query = "SELECT name, role, grade FROM User, Student WHERE {$active_id} = uID AND Student.sID = User.uID;";
    $result1 = mysqli_query($myconnection, $get_info_query) or die ('Query failed: ' . mysqli_error($myconnection));
    $row = mysqli_fetch_row($result1);
    mysqli_free_result($result1);
    
    echo('<h1>Your Dashboard</h1>');
    echo("
        <h3>Your grade is {$row[2]}</h3>
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
        </head>
        <table style='width:25%' style='height:15%'>
        <tr>
            <th>User</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        <tr>
            <td>{$row[0]}</td>
            <td>Student</td>
            <td><a href='change-s-profile.php'>Change Your Profile</a></td>
        </tr>
        <tr>
            <td>Student</td>
            <td>Section</td>
            <td><a href=''>View Sections</a></td>
        </tr>
        <tr>
            <td>Mentor</td>
            <td>Mentor</td>
            <td><a href=''>View Mentor</a></td>
        </tr>
        <tr>
            <td>Mentee</td>
            <td>Mentee</td>
            <td><a href=''>View Mentee</td>
        </tr>
        </table>
    ");

        
 /*       
    $get_children_query = "SELECT name, role, uid FROM User, Family WHERE Family.pID = {$active_id} AND Family.sID = User.uID;"; 
    $result2 = mysqli_query($myconnection, $get_children_query) or die ('Query failed: ' . mysqli_error($myconnection));
    while ($row = mysqli_fetch_row($result2)) {
        # pass childs uID through link
        $html_string .= " <tr>
        <td>{$row[0]}</td>
        <td>Student</td>
        <td><a href='change-c-profile.php?cID=".$row[2]."'>Change Your Child's Profile</a></td>
        </tr> ";
    }
    mysqli_free_result($result2);
    echo($html_string);
    */
    echo('<h3><a href="logout.php">Logout</a></h3>');


    mysqli_close($myconnection);
    exit;
?>