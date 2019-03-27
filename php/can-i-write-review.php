<?php
    session_start();
    
    $myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');
    
    $active_id = $_SESSION['active_ID'];

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
        </head>
   
        <h1> You are eligible to write reviews for the following mentors that you have studied with: </h1>
        <table style='width:25%' style='height:15%'>
        <tr>
            <th>Username</th>
            <th>Name</th>
            <th>Course</th>
            <th>Section</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Action</th>
        </tr>";

    $todays_date = new DateTime(date("Y-m-d"));
    
    $count = 0;
    $get_recent_mentor_query = "SELECT orID, secID, cID FROM Teaches NATURAL JOIN Learns WHERE eeID = {$active_id};";
    $result1 = mysqli_query($myconnection, $get_recent_mentor_query) or die ('Query failed: ' . mysqli_error($myconnection));
    while ($row = mysqli_fetch_row($result1)) {
        $get_end_date_query = "SELECT endDate, startDate From Section Where secID={$row[1]} AND cID={$row[2]};";
            $result2 = mysqli_query($myconnection, $get_end_date_query) or die ('Query failed: ' . mysqli_error($myconnection));
            $row2 = mysqli_fetch_row($result2);
            mysqli_free_result($result2);
            $sec_end_date = new DateTime($row2[0]);
            if ($sec_end_date < $todays_date) {
                $already_written_query = "SELECT COUNT(*) FROM Review WHERE orID=$row[0] AND eeID=$active_id AND secID={$row[1]} AND cID={$row[2]};";
                    $result3 = mysqli_query($myconnection, $already_written_query) or die ('Query failed: ' . mysqli_error($myconnection));
                    $row3 = mysqli_fetch_row($result3);
                    mysqli_free_result($result3);
            if (!$row3[0]) {
                $count++;
                $get_or_info_query = "SELECT username, `name` FROM User WHERE uID=$row[0];";
                $result4 = mysqli_query($myconnection, $get_or_info_query) or die ('Query failed: ' . mysqli_error($myconnection));
                $row4 = mysqli_fetch_row($result4);
                mysqli_free_result($result4);
                $get_class_info_query = "SELECT title, `name` FROM Course NATURAL JOIN Section WHERE secID=$row[1] AND cID=$row[2];";
                $result5 = mysqli_query($myconnection, $get_class_info_query) or die ('Query failed: ' . mysqli_error($myconnection));
                $row5 = mysqli_fetch_row($result5);
                mysqli_free_result($result5);
                
                $html_string .= "   
                    <tr>
                        <td>{$row4[0]}</td>
                        <td>{$row4[1]}</td>
                        <td>{$row5[0]}</td>
                        <td>{$row5[1]}</td>
                        <td>{$row2[1]}</td>
                        <td>{$row2[0]}</td>
                        <td><a href='write-review.php?orID=".$row[0]."&&eeID=".$active_id."&&secID=".$row[1]."&&cID=".$row[2].
                            "&&name=".$row4[1]."&&title=".$row5[0]."&&section=$row5[1]'>Write Review</a></td>
                    </tr>
                ";
            }
        }
    }
    mysqli_free_result($result1);
    if ($count) {
        $html_string .= "
            </table>
            ";
    } else {
        $html_string = "<h1>You are not currently eligible to write reviews for any mentors.</h1>"; 
    }
    
    echo($html_string);

    echo('<h3><a href="student-dashboard.php">Back to dashboard</a></h3>');
    echo('<h3><a href="logout.php">Logout</a></h3>');

    mysqli_close($myconnection);
    exit;
?>
