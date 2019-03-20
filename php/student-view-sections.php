<?php
    session_start();
    
    $myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');
    $todays_date = new DateTime(date("Y-m-d"));
    $active_id = $_SESSION['active_ID'];
    $get_student_info_query = "SELECT grade, role FROM User, Student WHERE {$active_id} = uID AND {$active_id} = sID;";
    $result2 = mysqli_query($myconnection, $get_student_info_query) or die ('Query failed: ' . mysqli_error($myconnection));
    $row = mysqli_fetch_row($result2);
    $s_grade = $row[0];
    $s_role = $row[1];
    if ($s_role == 'Both') {
        $mentor = true;
        $mentee = true;
    } else if ($s_role == 'Mentor') {
        $mentor = true;
        $mentee = false;
    } else if ($s_role == 'Mentee') {
        $mentor = false;
        $mentee = true;
    } else {
        $mentor = false;
        $mentee = false;
    }

    $get_section_info_query = "SELECT Course.title, Course.orReq, Course.eeReq,
        Section.name, Section.capacity, Section.startDate, Section.endDate,
        Schedule.startTime, Schedule.endTime, Schedule.days,
        Course.cID, Section.SecID 
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
                <th>Capacity</th>
                <th>Mentor Req</th>
                <th>Mentee Req</th>
                <th>Enrolled Mentor</th>
                <th>Enrolled Mentee</th>
                <th>Teach as Mentor</th>
                <th>Enroll as Mentee</th>
            </tr>";
                    
            while ($row = mysqli_fetch_row($result1)){
                $is_mentor_query="SELECT COUNT(*) FROM Teaches WHERE orID = $active_id AND secID = $row[11] AND cID = $row[10];";
                $result2 = mysqli_query($myconnection, $is_mentor_query) or die ('Query failed: ' . mysqli_error($myconnection));
                $teaching = mysqli_fetch_row($result2);
                
                $is_mentee_query="SELECT COUNT(*) FROM Learns WHERE eeID = $active_id AND secID = $row[11] AND cID = $row[10];";
                $result2 = mysqli_query($myconnection, $is_mentee_query) or die ('Query failed: ' . mysqli_error($myconnection));
                $learning = mysqli_fetch_row($result2);

                $start_date = new DateTime($row[5]);
                $html_string .= "
                <tr>
                    <td>$row[0]</td>
                    <td>$row[3]</td>
                    <td>$row[5]</td>
                    <td>$row[6]</td>
                    <td>$row[7] - $row[8]</td>
                    <td>$row[4]</td>
                    <td>$row[1]</td>
                    <td>$row[2]</td>
                    <td>0</td>
                    <td>0</td>";
                if ($s_grade >= $row[1] && $mentor && $todays_date < $start_date && !$learning[0]){
                    if (!$teaching[0]) {
                        $html_string .= "
                            <td><a href='enroll-mentor.php?cID=".$row[10]."&&secID=".$row[11]."'>Teach</a></td>
                        ";
                    } else {
                        $html_string .= "<td>Currently Teaching</td>"; 
                    }
                } else {
                    $html_string .= "<td>N/A</td>";
                }
                if ($s_grade >= $row[2] && $mentee && $todays_date < $start_date && !$teaching[0]){
                    if(!$learning[0]) {
                        $html_string .= "<td><a href='enroll-mentee.php?cID=".$row[10]."&&secID=".$row[11]."'>Enroll</a></td>";
                    } else {
                        $html_string .= "<td>Currently Enrolled</td>";
                    }
                } else {
                    $html_string .= "<td>N/A</td>";
                }
                $html_string .= "</tr>";
            }
    mysqli_free_result($result1);
    $html_string .= "</table>";
    echo($html_string);

    echo('<h3><a href="logout.php">Logout</a></h3>');

    mysqli_close($myconnection);
    exit;
?>
