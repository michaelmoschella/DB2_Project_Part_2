<?php
/********************************************** 
parent-view-sections.php

Displays a list of all the sections displaying
who is currently moderating or providing option
to moderate.
***********************************************/
    session_start();

    $parent_role = $_GET['parent_role']; # get parameter from link
    echo(
    "<h1>{$parent_role}</h1>"
    );

    $active_id = $_SESSION['active_ID'];

    $myconnection = mysqli_connect('localhost', 'root', '')
    or die ('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');

    $todays_date = new DateTime(date("Y-m-d"));

    /* get section info */
    $get_section_info_query = "SELECT Course.title, Course.orReq, Course.eeReq,
        Section.name, Section.tuition, Section.startDate, Section.endDate,
        Schedule.startTime, Schedule.endTime, Schedule.days,
        Course.cID, Section.SecID,
        Section.mentorCap, Section.menteeCap
        FROM Course, Section, Schedule
        WHERE Course.cID = Section.cID AND
        Section.schedID = Schedule.schedID;";
    $result1 = mysqli_query($myconnection, $get_section_info_query) or die ('Query failed: ' . mysqli_error($myconnection));

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
        </head>
        <table style='width:75%' style='height:15%'>
        <tr>
        <th>Course Title</th>
        <th>Section Name</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Time Slot</th>

        <th>Mentor Req</th>
        <th>Mentee Req</th>
        <th>Enrolled Mentor</th>
        <th>Enrolled Mentee</th>";

    if($parent_role=='Moderator'){
        $html_string .= "
        <th>Moderate as Moderator</th>"; 
    }

    $html_string .= "</tr>";

    while ($row = mysqli_fetch_row($result1)){
      /* Get number of mentors enrolled in section */
        $get_mentor_count_query = "SELECT count(*) FROM Teaches 
        WHERE Teaches.secID = {$row[11]} AND Teaches.cID = {$row[10]};";
        $result3 = mysqli_query($myconnection, $get_mentor_count_query) or die ('Query failed: ' . mysqli_error($myconnection));
        $row1 = mysqli_fetch_row($result3);
        mysqli_free_result($result3);

        /* Get number of mentees enrolled in section */
        $get_mentee_count_query = "SELECT COUNT(*) FROM Learns 
        WHERE Learns.secID = {$row[11]} AND Learns.cID = {$row[10]};";
        $result4 = mysqli_query($myconnection, $get_mentee_count_query) or die ('Query failed: ' . mysqli_error($myconnection));
        $row2 = mysqli_fetch_row($result4);
        mysqli_free_result($result4);

        $end_date = new DateTime($row[6]);
        $html_string .= "
        <tr>
        <td>$row[0]</td>
        <td>$row[3]</td>
        <td>$row[5]</td>
        <td>$row[6]</td>
        <td>$row[7] - $row[8]</td>
        <td>$row[1]</td>
        <td>$row[2]</td>
        <td>$row1[0]/$row[12]</td>
        <td>$row2[0]/$row[13]</td>";
        if($parent_role=='Moderator'){
          /* Get info for which parent is moderating which course */
            $get_info_query = "SELECT Moderates.secID, Moderates.cID, Moderates.modID, User.name FROM Moderates, User WHERE Moderates.modID = User.uID;";
            $result0 = mysqli_query($myconnection, $get_info_query) or die ('Query failed: ' . mysqli_error($myconnection));

            while ($row0 = mysqli_fetch_row($result0)){
                $test = 0;
                if($row0[0]==$row[11] && $row0[1]==$row[10]){
                    if($row0[2]==$active_id){
                        $test = 1;
                        break;
                    } else {
                        $test=2;
                        break;
                    }
                }
            }
            /* Determine if section already ended */
            if ($todays_date > $end_date) {
                $html_string .= "<td>Section has ended</td>";
            } else {
                if($test==0){
                    $html_string .= "
                    <td><form method='get' action='add-moderator.php'><input type='hidden' value='".$row[10]."' name='c__ID'>
                    <button type='submit' value='".$row[11]."' name='sec__ID'>Moderate
                    </form>";
                } else if($test==1) {
                    $html_string .= "
                    <td>Moderating Section</button>";
                } else {
                    $html_string .= "
                    <td>Moderated by user: $row0[3]</button>";
                }
            }
            $html_string .= "</td>";
        }
    }
    mysqli_free_result($result1);
    $html_string .= "</table>";
    echo($html_string);

    echo('<h3><a href="parent-dashboard.php">Back to dashboard</a></h3>');
    echo('<h3><a href="logout.php">Logout</a></h3>');


    mysqli_close($myconnection);
    exit;
?>
