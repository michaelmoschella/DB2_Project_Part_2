<?php
/********************************************** 
parent-dashboard.php

Displays various actions as well as notification
for parent user.
***********************************************/
    session_start();

    $myconnection = mysqli_connect('localhost', 'root', '')
    or die ('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');

    $active_id = $_SESSION['active_ID'];

    /*get info of logged in parent*/
    $get_info_query = "SELECT name, role FROM User WHERE {$active_id} = uID;";
    $result1 = mysqli_query($myconnection, $get_info_query) or die ('Query failed: ' . mysqli_error($myconnection));
    $row = mysqli_fetch_row($result1);
    $p_role = $row[1];
    mysqli_free_result($result1);

    echo('<h1>Your Dashboard</h1>');

    $html_string = "<head>
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
            <table style='width:25%' style='height:15%'>
            <tr>
            <th>User</th>
            <th>Role</th>
            <th>Action</th>
            </tr>
        <tr>
            <td>{$row[0]}</td>
            <td>Parent</td>
            <td><a href='change-p-profile.php'>Change Your Profile</a></td>
        </tr>";
        
        /* Get children of logged in parent */
        $get_children_query = "SELECT name, role, uid FROM User, Family WHERE Family.pID = {$active_id} AND Family.sID = User.uID;";
        $result2 = mysqli_query($myconnection, $get_children_query) or die ('Query failed: ' . mysqli_error($myconnection));
        while ($row = mysqli_fetch_row($result2)) {
            # pass childs uID through link
            $html_string .= " <tr>
            <td>{$row[0]}</td>
            <td>Student</td>
            <td><a href='change-c-profile.php?cID=".$row[2]."'>Change Your Child's Profile</a></td>
            </tr> ";
        }
        
        $html_string .= "<tr>
        <td>Parent</td>
      <td>Section</td>
      <td><a href='parent-view-sections.php?parent_role=".$p_role."'>View Sections</a></td>
      </tr>";
      
      if($p_role == 'Moderator'){
      $html_string .= "
      <tr>
      <td>Moderator</td>
      <td>Moderator</td>
      <td><a href='parent-moderate-section-session.php'>View Moderator</a></td>
      </tr>

      ";
    }
    $html_string .= "</table>";

    /* get todays date and calculate date of previous friday */
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

    /* get info of sessions parent is moderating with less than 2 mentors*/
    $get_small_sessions_query = "SELECT Session.name, Section.name, Course.title, Session.theDate, 
            Session.sesId, Session.secID, Session.cID, Course.orReq 
        FROM Session, Section, Course 
        WHERE
            Session.secID = Section.secID AND Session.cID = Section.cID AND
            Session.cId = Course.cID AND 
            Section.cID = Course.cID AND
            (Session.sesId, Session.secID, Session.cID) IN (
                SELECT sesID, secID, cID FROM SessTeach NATURAL JOIN Moderates
                WHERE
                    modID = {$active_id}
                    GROUP BY sesID, secID, cID
                    HAVING COUNT(DISTINCT(orID)) < 2  
                        UNION
                SELECT sesID, secID, cID FROM SessLearn NATURAL JOIN Moderates
                WHERE
                    modID = {$active_id} AND (sesId, secId, cID) NOT IN (
                        SELECT sesID, secID, cID FROM SessTeach
                    )
);";
    $result2 = mysqli_query($myconnection, $get_small_sessions_query) or die ('Query failed: ' . mysqli_error($myconnection));
    $html_string .= "
        <h1>Notifications</h1>
    ";
    $notification_string = "
    <h3>The following sessions need mentors assigned:</h3>
    <table style='width:25%' style='height:15%'>
        <tr>
            <th>Course</th>
            <th>Section</th>
            <th>Session</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    ";
    $note_count = 0;
    while($a_row = mysqli_fetch_row($result2)) {
        $sess_date = new DateTime($a_row[3]);
        /* determine which session are in the coming week */
        if (date_diff($sess_date, $fri_date)->format("%d") < 9){ # assuming week ends on Sunday
            $note_count++;
            $notification_string .= "
            <tr>
                <td>{$a_row[2]}</td>
                <td>{$a_row[1]}</td>  
                <td>{$a_row[0]}</td>
                <td>{$a_row[3]}</td>
                <td><a href='mentor-candidate-list.php?sesID=".$a_row[4]."&&secID=".$a_row[5].
                    "&&cID=".$a_row[6]."&&class_name=".$a_row[2]."&&mentorRequire=".$a_row[7]."'>Assign Mentors</a></td>
            </tr>";
        }
    }
    mysqli_free_result($result2);

    $notification_string .= "</table>";

    $review_string =    "
        <h3>The following reviews need to be verified:</h3>
        <table style='width:25%' style='height:15%'>
            <tr>
                <th>Mentor Name</th>
                <th>Mentee Name</th>
                <th>Mentee Email</th>
                <th>Course</th>
                <th>Section</th>
                <th>Action</th>
            </tr>
        ";
    /* Find reviews from sessions parent moderated that need to be verified */
    $find_reviews_query = "SELECT orID, eeID, secID, cID FROM Review NATURAL JOIN Moderates WHERE modID={$active_id} AND `verified`=0;"; 
    $result2 = mysqli_query($myconnection, $find_reviews_query) or die ('Query failed: ' . mysqli_error($myconnection));
    $review_count = 0;
    while($a_row = mysqli_fetch_row($result2)) {
        $review_count++;
        $get_mentor_info_query = "SELECT `name` FROM User WHERE uID=$a_row[0];";
        $result3 = mysqli_query($myconnection, $get_mentor_info_query) or die ('Query failed: ' . mysqli_error($myconnection));
        $row3 = mysqli_fetch_row($result3);
        
        $get_mentee_info_query = "SELECT `name`, email FROM User WHERE uID=$a_row[1];";
        $result4 = mysqli_query($myconnection, $get_mentee_info_query) or die ('Query failed: ' . mysqli_error($myconnection));
        $row4 = mysqli_fetch_row($result4);

        $get_class_info_query = "SELECT title, `name` FROM Course NATURAL JOIN Section WHERE secID=$a_row[2] AND cID=$a_row[3];";
        $result5 = mysqli_query($myconnection, $get_class_info_query) or die ('Query failed: ' . mysqli_error($myconnection));
        $row5 = mysqli_fetch_row($result5);

        $review_string .= "
            <tr>
                <td>{$row3[0]}</td>
                <td>{$row4[0]}</td>  
                <td>{$row4[1]}</td>
                <td>{$row5[0]}</td>
                <td>{$row5[1]}</td>
                <td><a href='verify-review.php?orID=".$a_row[0]."&&eeID=".$a_row[1]."&&secID=".$a_row[2].
                        "&&cID=".$a_row[3]."&&mentor=".$row3[0]."&&mentee=".$row4[0]."&&eeEmail=".$row4[1]."'>Verify Review</a></td>
            </tr>";
    }
    $review_string .= "</table>";

    echo($html_string);
    if ($note_count) {
        echo($notification_string);
    }
    if ($review_count) {
        echo($review_string);
    }
    if (!$review_count && !$note_count) {
        echo("<h4>No notifications.</h4>");
    }
    echo('<h3><a href="logout.php">Logout</a></h3>');

    mysqli_close($myconnection);
    exit;
?>
