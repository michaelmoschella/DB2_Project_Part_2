<?php
    session_start();

    $parent_role = $_GET['parent_role']; # get parameter from link
    echo(
        "<h1>{$parent_role}</h1>"
    );

$active_id = $_SESSION['active_ID'];

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
                <th>Enrolled Mentee</th>";
                if($parent_role=='Moderator'){
                  $html_string .= "
                <th>Moderate as Moderator</th>"; }

            $html_string .= "</tr>";

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
                    <td>0</td>";
                    if($parent_role=='Moderator'){


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
                    if($test==0){
                      $html_string .= "
                    <td><form method='get' action='add-moderator.php'><input type='hidden' value='".$row[10]."' name='c__ID'>
                    <button type='submit' value='".$row[11]."' name='sec__ID'>Moderate
                    </form>";
                    #  <td><button onClick=''>Moderate</button>";
                    #<a href='enroll-mentee.php?cID=".$row[10]."&&secID=".$row[11]."'>
                  } else if($test==1) {
                    $html_string .= "
                <td>Moderating Section</button>";
              } else {
                $html_string .= "
            <td>Moderated by user: $row0[3]</button>";
              }
                  }

                  $html_string .= "</td>";
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


    echo('<h3><a href="logout.php">Logout</a></h3>');


    mysqli_close($myconnection);
    exit;
?>
