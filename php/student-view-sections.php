<?php
    session_start();
    
    $myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');
    
    $active_id = $_SESSION['active_ID'];
    $get_student_info_query = "SELECT role, grade, FROM User, Student WHERE {$active_id} = uID AND {$active_id} = sID;";
    $result2 = mysqli_query($myconnection, $get_student_info_query) or die ('Query failed: ' . mysqli_error($myconnection));
    $row = mysqli_fetch_row($result2);
    $role = $row[0];
    $grade = $row[1];
    
    $get_section_info_query = "SELECT Course.title, Course.orReq, Course.eeReq,
        Section.name, Section.capacity, Section.startDate, Section.endDate,
        Schedule.startTime, Schedule.endTime, Schedule.days 
        FROM Course, Section, Schedule 
        WHERE Course.cID = Section.cID AND
            Section.schedID = Schedule.schedID;";
    $result1 = mysqli_query($myconnection, $get_section_info_query) or die ('Query failed: ' . mysqli_error($myconnection));
    echo("<h1>Before While</h1>");
    
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
                    <td>0</td>
                    <td>N/A</td>
                    <td>N/A</td>
                </tr>
                ";
            }
    mysqli_free_result($result1);
    $html_string .= "</table>";
    echo("<h1>After While</h1>");
    echo($html_string);
   /* $get_info_query = "SELECT name, role, grade FROM User, Student WHERE {$active_id} = uID AND Student.sID = User.uID;";
   $result2 = mysqli_query($myconnection, $get_info_query) or die ('Query failed: ' . mysqli_error($myconnection));
   mysqli_free_result($result2);
   */

  
  echo('<h3><a href="logout.php">Logout</a></h3>');
  
  
  mysqli_close($myconnection);
  exit;
/*
Schedule.startTime, Schedule.endTime, Schedule.days 
, Schedule 
AND
            Section.schedID = Schedule.schedID;
*/
?>
