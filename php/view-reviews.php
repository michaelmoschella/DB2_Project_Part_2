<?php
    session_start();
    $or_ID = $_GET['orID'];
    $or_name = $_GET['orName'];

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
        <td colspan = '8' style = 'text-align: center;'><h2>Reviews for $or_name</h2></td>
        </tr>
        <tr>
            <th>Reviewers Name</th>
            <th>Reviewers Username</th>
            <th>Course</th>
            <th>Section</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Rating</th>
            <th>Comment</th>
        </tr>";

    $get_reviews_query = "SELECT eeID, secID, cID, rating, comment FROM Review WHERE orID=$or_ID AND verified=1"; 
    $result1 = mysqli_query($myconnection, $get_reviews_query) or die ('Query failed: ' . mysqli_error($myconnection));
    
    while ($row = mysqli_fetch_row($result1)) {
        $get_mentee_info_query = "SELECT `name`, username from User WHERE uID=$row[0];"; 
        $result2 = mysqli_query($myconnection, $get_mentee_info_query) or die ('Query failed: ' . mysqli_error($myconnection));
        $row2 = mysqli_fetch_row($result2);

        $get_class_info_query = "SELECT title, `name`, startDate, endDate FROM Course NATURAL JOIN Section WHERE secID=$row[1] AND cID=$row[2];";
        $result3 = mysqli_query($myconnection, $get_class_info_query) or die ('Query failed: ' . mysqli_error($myconnection));
        $row3 = mysqli_fetch_row($result3);

            $html_string .="
                <tr>
                    <td>{$row2[0]}</td>
                    <td>{$row2[1]}</td>
                    <td>{$row3[0]}</td>
                    <td>{$row3[1]}</td>
                    <td>{$row3[2]}</td>
                    <td>{$row3[3]}</td>
                    <td>{$row[3]}</td>
                    <td>{$row[4]}</td>
                </tr>";
    }

    $html_string .= "
            </table>
       ";
    
    echo($html_string);

    
    echo('<h3><a href="view-mentor-reviews.php">See reviews for other mentors</a></h3>');
    echo('<h3><a href="student-dashboard.php">Back to dashboard</a></h3>');
    echo('<h3><a href="logout.php">Logout</a></h3>');

    mysqli_close($myconnection);
    exit;
?>
