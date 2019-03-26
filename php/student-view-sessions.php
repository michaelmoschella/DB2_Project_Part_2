<?php
    session_start();
    
    $myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');
    
    $todays_date = new DateTime(date("Y-m-d"));
    $today = date("D");

    switch ($today) {
        case "Sat":
            $offset = "1 day";
            break;
        case "Sun":
            $offset = "2 days";
            break;
        case "Mon":
            $offset = "3 days";
            break;
        case "Tue":
            $offset = "4 days";
            break;
        case "Wed":
            $offset = "5 days";
            break;
        case "Thu":
            $offset = "6 days";
            break;
        default:
            $offset = "0 days";
    }
    $fri_date = date_sub($todays_date, date_interval_create_from_date_string($offset));

    $active_id = $_SESSION['active_ID'];
    $html_string = "
    <head>
        <style>
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
                margin-bottom: 30px;
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
    <h1> Enroll in sessions as a mentor </h1>";

    $get_sec_info_query = "SELECT Section.name, Course.title, Section.secID, Section.cID FROM Section, Course, Teaches 
    WHERE {$active_id} = Teaches.orID 
    AND Section.secID = Teaches.secID AND Section.cID = Teaches.cID
    AND Course.cID = Teaches.cID;"; 
    $result1 = mysqli_query($myconnection, $get_sec_info_query) or die ('Query failed: ' . mysqli_error($myconnection));
    while ($row = mysqli_fetch_row($result1)) {
        $html_string .= "<label>
        <table style='width:25%' style='height:15%'>
        <tr>
            <td colspan = '7' style = 'text-align: center'><h4>{$row[1]} {$row[0]}</h4></td>
        </tr>
        <tr>
            <th>Session Name</th>
            <th>Date</th>
            <th>Time</th>
            <th>Mentor Count</th>
            <th>Mentee Count</th>
            <th>View Study Material</th>
            <th>Participate</th>
        </tr>";

        $get_sessions_query ="SELECT Session.name, Session.theDate, Schedule.startTime, Schedule.endTime,
                Session.sesID, Session.secID, Session.cID
            FROM Session, Section, Schedule
            WHERE 
                Session.secID = Section.secID AND Session.cID = Section.cID
                And Session.secID = {$row[2]} AND Session.cID = {$row[3]}
                AND Section.schedID = Schedule.schedID;";
        $result2 = mysqli_query($myconnection, $get_sessions_query) or die ('Query failed: ' . mysqli_error($myconnection));
        
        if (mysqli_num_rows($result2)) {
            while($a_row = mysqli_fetch_row($result2)){
                $get_mentor_count_query = "SELECT count(*) FROM SessTeach 
                    WHERE SessTeach.sesID = {$a_row[4]} AND SessTeach.secID = {$a_row[5]} AND SessTeach.cID = {$a_row[6]};";
                $result3 = mysqli_query($myconnection, $get_mentor_count_query) or die ('Query failed: ' . mysqli_error($myconnection));
                $row1 = mysqli_fetch_row($result3);
                mysqli_free_result($result3);
                
                $get_mentee_count_query = "SELECT COUNT(*) FROM SessLearn 
                    WHERE SessLearn.sesID = {$a_row[4]} AND SessLearn.secID = {$a_row[5]} AND SessLearn.cID = {$a_row[6]};";
                $result4 = mysqli_query($myconnection, $get_mentee_count_query) or die ('Query failed: ' . mysqli_error($myconnection));
                $row2 = mysqli_fetch_row($result4);

                $is_mentoring_query = "SELECT COUNT(*) FROM SessTeach 
                    WHERE SessTeach.sesID = {$a_row[4]} AND SessTeach.secID = {$a_row[5]} AND SessTeach.cID = {$a_row[6]}
                            AND SessTeach.orID = $active_id;";
                $result5 = mysqli_query($myconnection, $is_mentoring_query) or die ('Query failed: ' . mysqli_error($myconnection));
                $row3 = mysqli_fetch_row($result5);

                mysqli_free_result($result4);
                $html_string .="
                    <tr>
                        <td>{$a_row[0]}</td>
                        <td>{$a_row[1]}</td>
                        <td>{$a_row[2]}-{$a_row[3]}</td>
                        <td>{$row1[0]}</td>
                        <td>{$row2[0]}</td>
                        <td><a href='view-study-material.php?sesID=".$a_row[4]."&&secID=".$a_row[5]."&&cID=".$a_row[6].
                        "&&cTitle=".$row[1]."&&secName=".$row[0]."&&sesName=".$a_row[0]."'>View Study Materials</a></td>";
                        $sess_date = new DateTime($a_row[1]);
                        if ($sess_date < $todays_date) {
                            $html_string .= "<td>Session ended</td>";
                        } else {
                            if (!$row3[0]) {
                                $html_string .= "<td><a href='enroll-mentor-session.php?cID=".$a_row[6]."&&secID=".$a_row[5].
                                "&&sesID=".$a_row[4]."'>Participate</td>";
                            } else {
                                $html_string .= "<td>Currently Participating</td>";
                            }
                        }
                    $html_string .= "</tr>";
            }
        } else {
            $html_string .= "
                <tr>
                    <td colspan = '7' style = 'text-align: center;'>No sessions have been scheduled.</h4></td>
                </tr>
            ";
        }
        mysqli_free_result($result2);
        $html_string .= "
            </table>
        <label>";
    }
    mysqli_free_result($result1);

    $html_string .= "<h1>Enroll in sessions as a mentee</h1>"; 

    $get_sec_info_query = "SELECT Section.name, Course.title, Section.secID, Section.cID FROM Section, Course, Learns 
    WHERE {$active_id} = Learns.eeID 
    AND Section.secID = Learns.secID AND Section.cID = Learns.cID
    AND Course.cID = Learns.cID;"; 
    $result1 = mysqli_query($myconnection, $get_sec_info_query) or die ('Query failed: ' . mysqli_error($myconnection));
    while ($row = mysqli_fetch_row($result1)) {
        $html_string .=     
            "<label>
                <table style='width:25%' style='height:15%'>
                <tr>
                    <td colspan = '7' style = 'text-align: center;'><h4>{$row[1]} {$row[0]}</h4></td>
                </tr>
                <tr>
                    <th>Session Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Mentor Count</th>
                    <th>Mentee Count</th>
                    <th>View Study Material</th>
                    <th>Participate</th>
                </tr>";
        $get_sessions_query ="SELECT Session.name, Session.theDate, Schedule.startTime, Schedule.endTime,
                Session.sesID, Session.secID, Session.cID
            FROM Session, Section, Schedule
            WHERE 
            Session.secID = Section.secID AND Session.cID = Section.cID
            And Session.secID = {$row[2]} AND Session.cID = {$row[3]}
            AND Section.schedID = Schedule.schedID;";
        $result2 = mysqli_query($myconnection, $get_sessions_query) or die ('Query failed: ' . mysqli_error($myconnection));
        
        if (mysqli_num_rows($result2)){
            while($a_row = mysqli_fetch_row($result2)){
                $get_mentor_count_query = "SELECT count(*) FROM SessTeach 
                    WHERE SessTeach.sesID = {$a_row[4]} AND SessTeach.secID = {$a_row[5]} AND SessTeach.cID = {$a_row[6]};";
                $result3 = mysqli_query($myconnection, $get_mentor_count_query) or die ('Query failed: ' . mysqli_error($myconnection));
                $row1 = mysqli_fetch_row($result3);
                mysqli_free_result($result3);
                
                $get_mentee_count_query = "SELECT COUNT(*) FROM SessLearn 
                    WHERE SessLearn.sesID = {$a_row[4]} AND SessLearn.secID = {$a_row[5]} AND SessLearn.cID = {$a_row[6]};";
                $result4 = mysqli_query($myconnection, $get_mentee_count_query) or die ('Query failed: ' . mysqli_error($myconnection));
                $row2 = mysqli_fetch_row($result4);
                mysqli_free_result($result4);

                $is_mentoring_query = "SELECT COUNT(*) FROM SessLearn 
                    WHERE SessLearn.sesID = {$a_row[4]} AND SessLearn.secID = {$a_row[5]} AND SessLearn.cID = {$a_row[6]}
                            AND SessLearn.eeID = $active_id;";
                $result5 = mysqli_query($myconnection, $is_mentoring_query) or die ('Query failed: ' . mysqli_error($myconnection));
                $row3 = mysqli_fetch_row($result5);
                mysqli_free_result($result5);

                $html_string .="
                    <tr>
                        <td>{$a_row[0]}</td>
                        <td>{$a_row[1]}</td>
                        <td>{$a_row[2]}-{$a_row[3]}</td>
                        <td>{$row1[0]}</td>
                        <td>{$row2[0]}</td>
                        <td><a href='view-study-material.php?sesID=".$a_row[4]."&&secID=".$a_row[5]."&&cID=".$a_row[6].
                        "&&cTitle=".$row[1]."&&secName=".$row[0]."&&sesName=".$a_row[0]."'>View Study Materials</a></td>";

                        $sess_date = new DateTime($a_row[1]);
                        if ($sess_date < $todays_date) {
                            $html_string .= "<td>Session ended</td>";
                        } else {
                            if (!$row3[0]) {
                                if (date_diff($sess_date, $fri_date)->format("%d") < 9){ # assuming weeks start on mon end on Sun
                                    $html_string .= "<td>Missed Thursday Deadline</td>";
                                } else {
                                    $html_string .= "<td><a href='enroll-mentee-session.php?cID=".$a_row[6]."&&secID=".$a_row[5]."&&sesID=".$a_row[4]."'>Participate</td>";
                                }
                            } else {
                                $html_string .= "<td>Currently Participating</td>";
                            }
                        }
                    $html_string .= "</tr>";
            } 
        } else {
            $html_string .= "
                <tr>
                    <td colspan = '6' style = 'text-align: center;'>No sessions have been scheduled.</h4></td>
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
    echo('<h3><a href="student-dashboard.php">Back to your dashboard</a></h3>');
    echo('<h3><a href="logout.php">Logout</a></h3>');

    mysqli_close($myconnection);
    exit;
?>
