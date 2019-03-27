<?php
/********************************************** 
mentor-candidate-list.php

Gets mentors who are eligible to teach a session
and allows moderator to assign them to that session
***********************************************/
    session_start();

    $sec_ID = (isset($_GET['secID']) ? $_GET['secID'] : null); # get parameter from link
    $c_ID = (isset($_GET['cID']) ? $_GET['cID'] : null); # get parameter from link
    $class_name = (isset($_GET['classname']) ? $_GET['classname'] : null);
    $mentor_req = (isset($_GET['mentorRequire']) ? $_GET['mentorRequire'] : null);
    $sesID = (isset($_GET['sesID']) ? $_GET['sesID'] : null);

    $myconnection = mysqli_connect('localhost', 'root', '')
    or die ('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');

    $active_id = $_SESSION['active_ID'];

    $html_string =  "<h1>Mentor Candidate List</h1>

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
    aqSz
    [P]
        tr:nth-child(even) {
          background-color: #dddddd;
        }
        </style>
    </head>
      <label>
        $class_name
        <table style='width:25%' style='height:15%'>
          <tr>
            <th>Mentor ID</th>
            <th>Student Name</th>
            <th>Student Grade</th>
            <th>Assign</th>
          </tr>";

        /* Get mentors enrolled in section but not enrolled in session */
    $get_info_query = "SELECT orID FROM Teaches WHERE cID = $c_ID AND secID = $sec_ID AND orID NOT IN (SELECT orID FROM SessTeach WHERE cID = $c_ID AND secID = $sec_ID AND SesID = $sesID);";
    $result2 = mysqli_query($myconnection, $get_info_query) or die ('Query failed: ' . mysqli_error($myconnection));

    while ($row2 = mysqli_fetch_row($result2)){
        /* Get info about those mentors */
        $get_info_query = "SELECT User.uID, User.name, Student.grade FROM User, Student WHERE  Student.sID = User.uID AND Student.grade >= $mentor_req  AND User.uID = $row2[0];";
        $result1 = mysqli_query($myconnection, $get_info_query) or die ('Query failed: ' . mysqli_error($myconnection));

        while ($row = mysqli_fetch_row($result1)){
            $html_string .=   "
        <tr>
            <td>$row[0]</td>
            <td>$row[1]</td>
            <td>$row[2]</td>
            <td>
            <form method='get' action='enroll-mentor-from-moderator.php'>
            <input type='hidden' value='".$row[1]."' name='the_name'>
            <input type='hidden' value='".$sesID."' name='ses_ID'>
            <input type='hidden' value='".$sec_ID."' name='sec_ID'>
            <input type='hidden' value='".$c_ID."' name='c_ID'>
            <button type='submit' value='".$row[0]."' name='uID'>Assign</button>
            </form></td>
        </tr>";
        }
    }
    $html_string .=   "<label>
        </table>";

echo($html_string);
    mysqli_close($myconnection);
    exit;
?>
