<?php
/********************************************** 
student-view-sections.php

Get a list of all sections and determine whether
student is eligible to enroll or not.
***********************************************/
    session_start();

    https://codereview.stackexchange.com/questions/45784/test-2-time-ranges-to-see-if-they-overlap
    /* Ensures that 2 time ranges dont overlap, works for dates and times*/ 
    function rangeNoOverlap($start_time1,$end_time1,$start_time2,$end_time2){
        $utc = new DateTimeZone('UTC');

        $start1 = new DateTime($start_time1,$utc);
        $end1 = new DateTime($end_time1,$utc);

        $start2 = new DateTime($start_time2,$utc);
        $end2 = new DateTime($end_time2,$utc);

        return ($end1 <= $start2) || ($end2 <= $start1);
    }
        
    $myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');
    $todays_date = new DateTime(date("Y-m-d"));
    $active_id = $_SESSION['active_ID'];

    /* Get logged in students information */
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

    /* Get courses and section and dates the student has already enrolled */
    $get_students_courses_query = "SELECT Section.cID, Section.startDate, Section.endDate From Learns, Section
        WHERE $active_id = Learns.eeID AND Learns.secID = Section.secID  AND Learns.cID = Section.cID;";
    $result3 = mysqli_query($myconnection, $get_students_courses_query) or die ('Query failed: ' . mysqli_error($myconnection));
    $courses = array();
    while ($row = mysqli_fetch_row($result3)){
        $end_date = new DateTime($row[2]);
        /* Determine if they already ended or not */
        if ($todays_date < $end_date){
            /* Used to ensure students only enroll as a mentee in one section of 
            a course at the same time */
            array_push($courses, array($row[0], $row[1], $row[2]) );
        }
    }
    mysqli_free_result($result3);
    /* Get section information */
    $get_section_info_query = "SELECT Course.title, Course.orReq, Course.eeReq,
        Section.name, Section.tuition, Section.startDate, Section.endDate,
        Schedule.startTime, Schedule.endTime, Schedule.days,
        Course.cID, Section.SecID,
        Section.mentorCap, Section.menteeCap, Course.description 
        FROM Course, Section, Schedule 
        WHERE Course.cID = Section.cID AND
            Section.schedID = Schedule.schedID;";
    $result1 = mysqli_query($myconnection, $get_section_info_query) or die ('Query failed: ' . mysqli_error($myconnection));

    /* Used to eliminate time conflicts */
    $get_busy_times_query = "SELECT Schedule.startTime, Schedule.endTime, Section.startDate, Section.endDate, Section.cID From Schedule, Teaches, Section
        WHERE $active_id = Teaches.orID AND Teaches.secID = Section.secID AND Teaches.cID = Section.cID AND Schedule.schedID = Section.SchedID 
            UNION
        SELECT Schedule.startTime, Schedule.endTime, Section.startDate, Section.endDate, Section.cID From Schedule, Learns, Section
            WHERE $active_id = Learns.eeID AND Learns.secID = Section.secID  AND Learns.cID = Section.cID AND Schedule.schedID = Section.SchedID;";
    $result3 = mysqli_query($myconnection, $get_busy_times_query) or die ('Query failed: ' . mysqli_error($myconnection));
    
    $busy = array();
    while ($row = mysqli_fetch_row($result3)){
        $end_date = new DateTime($row[3]);
        if ($todays_date < $end_date){
            /* store time ranges that are not available */
            array_push($busy, array($row[0], $row[1], $row[2], $row[3]));
        }
    }
    mysqli_free_result($result3);

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
                <th>Description</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Time Slot</th>
                <th>Mentor Req</th>
                <th>Mentee Req</th>
                <th>Enrolled Mentor</th>
                <th>Enrolled Mentee</th>
                <th>Teach as Mentor</th>
                <th>Enroll as Mentee</th>
            </tr>";
                    
            while ($row = mysqli_fetch_row($result1)){
                /* Determine if student is already mentoring the section*/
                $is_mentor_query="SELECT COUNT(*) FROM Teaches WHERE orID = $active_id AND secID = $row[11] AND cID = $row[10];";
                $result2 = mysqli_query($myconnection, $is_mentor_query) or die ('Query failed: ' . mysqli_error($myconnection));
                $teaching = mysqli_fetch_row($result2);
                
                /* Determine if student is already a mentee in section*/
                $is_mentee_query="SELECT COUNT(*) FROM Learns WHERE eeID = $active_id AND secID = $row[11] AND cID = $row[10];";
                $result2 = mysqli_query($myconnection, $is_mentee_query) or die ('Query failed: ' . mysqli_error($myconnection));
                $learning = mysqli_fetch_row($result2);
                
                /* Get number of mentor in the section too check if full*/
                $get_mentor_count_query = "SELECT count(*) FROM Teaches 
                    WHERE Teaches.secID = {$row[11]} AND Teaches.cID = {$row[10]};";
                $result3 = mysqli_query($myconnection, $get_mentor_count_query) or die ('Query failed: ' . mysqli_error($myconnection));
                $row1 = mysqli_fetch_row($result3);
                mysqli_free_result($result3);
                
                /* Get number of meentees in the section too check if full*/
                $get_mentee_count_query = "SELECT COUNT(*) FROM Learns 
                    WHERE Learns.secID = {$row[11]} AND Learns.cID = {$row[10]};";
                $result4 = mysqli_query($myconnection, $get_mentee_count_query) or die ('Query failed: ' . mysqli_error($myconnection));
                $row2 = mysqli_fetch_row($result4);
                mysqli_free_result($result4);

                $section_flag = false;
                for ($i = 0; $i < count($courses); $i++) {
                    if($courses[$i][0] == $row[10]
                        && !rangeNoOverlap($courses[$i][1], $courses[$i][2], $row[5], $row[6])) {
                            $section_flag = true;
                    }
                }
                $end_date = new DateTime($row[6]);
                $html_string .= "
                <tr>
                    <td>$row[0]</td>
                    <td>$row[3]</td>
                    <td>$row[14]</td>
                    <td>$row[5]</td>
                    <td>$row[6]</td>
                    <td>$row[7] - $row[8]</td>
                    <td>$row[1]</td>
                    <td>$row[2]</td>
                    <td>$row1[0]/$row[12]</td>
                    <td>$row2[0]/$row[13]</td>";
                if ($s_grade >= $row[1] && $mentor && $todays_date < $end_date && !$learning[0]){
                    if (!$teaching[0]) {
                        if($row1[0] < $row[12]){
                            $time_conflict = false;
                            for ($i=0; $i<count($busy); $i++) {
                                $start_time = $busy[$i][0];
                                $end_time = $busy[$i][1];
                                $start_date = $busy[$i][2];
                                $ending_date = $busy[$i][3];
                                if (!rangeNoOverlap($start_date, $ending_date, $row[5], $row[6])) {
                                    if (!rangeNoOverlap($start_time, $end_time, $row[7], $row[8])){
                                        $time_conflict = true;
                                    }
                                }
                            }
                            if (!$time_conflict) {
                                $html_string .= "
                                <td><a href='enroll-mentor.php?cID=".$row[10]."&&secID=".$row[11]."'>Teach</a></td>
                                ";
                            } else {
                                $html_string .= "<td>Time Conflict</td>";
                            } 
                    
                        } else {
                            $html_string .= "<td>Section Full</td>";
                        }
                    } else {
                        $html_string .= "<td>Currently Teaching</td>"; 
                    }
                } else {
                    $html_string .= "<td>N/A</td>";
                }
                if ($s_grade >= $row[2] && $mentee && $todays_date < $end_date && !$teaching[0]){
                    if(!$learning[0]) {
                        if($row2[0] < $row[12]) {
                            if ($section_flag) {
                                $html_string .= "<td>Enrolled in different section for this course</td>";
                            } else {
                                $time_conflict = false;
                                for ($i=0; $i<count($busy); $i++) {
                                    $start_time = $busy[$i][0];
                                    $end_time = $busy[$i][1];
                                    $start_date = $busy[$i][2];
                                    $ending_date = $busy[$i][3];
                                    if (!rangeNoOverlap($start_date, $ending_date, $row[5], $row[6])) {
                                        if (!rangeNoOverlap($start_time, $end_time, $row[7], $row[8])){
                                            $time_conflict = true;
                                        } 
                                    }
                                }
                                if (!$time_conflict) {
                                    $html_string .= "<td><a href='enroll-mentee.php?cID=".$row[10]."&&secID=".$row[11]."'>Enroll</a></td>";
                                } else {
                                    $html_string .= "<td>Time Conflict</td>";
                                }
                            }
                        } else {    
                            $html_string .= "<td>Section Full</td>";
                        } 
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

    echo('<h3><a href="student-dashboard.php">Back to dashboard</a></h3>');
    echo('<h3><a href="logout.php">Logout</a></h3>');

    mysqli_close($myconnection);
    exit;
?>
