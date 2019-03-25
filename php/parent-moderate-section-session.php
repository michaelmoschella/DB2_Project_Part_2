<?php
    session_start();

    $myconnection = mysqli_connect('localhost', 'root', '')
    or die ('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');

  #  $active_id = $_SESSION['active_ID'];
  #  $get_student_info_query = "SELECT grade, role FROM User, Student WHERE {$active_id} = uID AND {$active_id} = sID;";
  #  $result2 = mysqli_query($myconnection, $get_student_info_query) or die ('Query failed: ' . mysqli_error($myconnection));
  #  $row = mysqli_fetch_row($result2);
  #  $s_grade = $row[0];
  #  $s_role = $row[1];
  #  if ($s_role == 'Both') {
  #      $mentor = true;
  #      $mentee = false;
  #  } else if ($s_role == 'Mentor') {
  #      $mentor = true;
  #      $mentee = false;
  #  } else if ($s_role == 'Mentee') {
  #      $mentor = false;
  #      $mentee = true;
  #  } else {
  #      $mentor = false;
  #      $mentee = false;
  #  }

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
                <th>Capacity</th>
                <th>Mentor Req</th>
                <th>Mentee Req</th>
                <th>Enrolled Mentor</th>
                <th>Enrolled Mentee</th>
                <th>Moderate as Moderator</th>
            </tr>";



            while ($row = mysqli_fetch_row($result1)){
                $get_mentor_count_query = "SELECT count(*) FROM Teaches 
                    WHERE Teaches.secID = {$row[11]} AND Teaches.cID = {$row[10]};";
                $result3 = mysqli_query($myconnection, $get_mentor_count_query) or die ('Query failed: ' . mysqli_error($myconnection));
                $a_row1 = mysqli_fetch_row($result3);
                mysqli_free_result($result3);
                
                $get_mentee_count_query = "SELECT COUNT(*) FROM Learns 
                    WHERE Learns.secID = {$row[11]} AND Learns.cID = {$row[10]};";
                $result4 = mysqli_query($myconnection, $get_mentee_count_query) or die ('Query failed: ' . mysqli_error($myconnection));
                $a_row2 = mysqli_fetch_row($result4);
                mysqli_free_result($result4);

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
                    <td>$a_row1[0]/$row[12]</td>
                    <td>$a_row2[0]/$row[13]</td>
                    <td><form method='get' action='mentor-candidate-list.php'>
                    <input type='hidden' value='".$row[1]."' name='mentorRequire'>
                    <input type='hidden' value='".$row[0]."' name='classname'>
                    <input type='hidden' value='".$row[10]."' name='cID'>
                    <button type='submit' value='".$row[11]."' name='secID'>Assign Mentor

                    </form></td></tr>";
                    $get_section_info_query_two = "SELECT Session.announcement, Session.sesID, Session.name, Session.theDate
                        FROM Session, Section
                        WHERE Session.cID = Section.cID AND Session.secID = Section.secID AND Session.cID = $row[10] AND Session.secID = $row[11];";
                    $result2 = mysqli_query($myconnection, $get_section_info_query_two) or die ('Query failed: ' . mysqli_error($myconnection));

                    $count=0;
                    while ($row2 = mysqli_fetch_row($result2)){

                      if($count==0){$html_string .=  "<tr>
                          <th colspan='4' style = 'text-align: center;''>Session Info</th>
                          <th colspan = '2'>Session ID</th>
                          <th colspan = '2'>Session Name</th>
                          <th colspan = '2'>Date</th>
                          <th></th>
                        </tr>";}
                        $count++;


                        $html_string .= "<tr>
                          <td colspan='4' style = 'text-align: center;''>$row2[0]</th>
                          <td colspan = '2'>$row2[1]</th>
                          <td colspan = '2'>$row2[2]</th>
                          <td colspan = '2'>$row2[3]</th>
                          <td><form method='get' action='post-materials.php'>
                          <input type='hidden' value='".$row[1]."' name='mentorRequire'>
                          <input type='hidden' value='".$row[0]."' name='classname'>
                          <input type='hidden' value='".$row[10]."' name='cID'>
                          <button type='submit' value='".$row[11]."' name='secID'>Post

                          </form></td>
                    </tr>";}
          ##      if ($s_grade >= $row[1] && $mentor){
              ##      $html_string .= "
            ##            <td><button onClick=''>Teach</button></td>
            ##        ";
          ##      } else {
          #          $html_string .= "<td>N/A</td>";
          #      }
          #      if ($s_grade >= $row[2] && $mentee){
          #          $html_string .= "<td><a href='enroll-mentee.php?cID=".$row[10]."&&secID=".$row[11]."'>Enroll</a></td>";
          #      } else {
          #          $html_string .= "<td>N/A</td>";
          #      }
          #      $html_string .= "</tr>";
            }
    mysqli_free_result($result1);
    $html_string .= "</table>";
    echo($html_string);
   /* $get_info_query = "SELECT name, role, grade FROM User, Student WHERE {$active_id} = uID AND Student.sID = User.uID;";
   $result2 = mysqli_query($myconnection, $get_info_query) or die ('Query failed: ' . mysqli_error($myconnection));
   mysqli_free_result($result2);
   */

    echo('<h3><a href="parent-dashboard.php">Back to dashboard</a></h3>');
    echo('<h3><a href="logout.php">Logout</a></h3>');


    mysqli_close($myconnection);
    exit;
?>
