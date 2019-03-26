<?php
    session_start();
    
    $myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');
    
    $active_id = $_SESSION['active_ID'];
    
    $get_info_query = "SELECT name, role, grade, email FROM User, Student WHERE {$active_id} = uID AND Student.sID = User.uID;";
    $result1 = mysqli_query($myconnection, $get_info_query) or die ('Query failed: ' . mysqli_error($myconnection));
    $row = mysqli_fetch_row($result1);
    mysqli_free_result($result1);
    
    echo('<h1>Your Dashboard</h1>');
    echo("
        <h3>Your grade is {$row[2]}</h3>
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
        <table style='width:25%' style='height:15%'>
        <tr>
            <th>User</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        <tr>
            <td>{$row[0]}</td>
            <td>Student</td>
            <td><a href='change-s-profile.php'>Change Your Profile</a></td>
        </tr>
        <tr>
            <td>$row[0]</td>
            <td>Student</td>
            <td><a href='student-view-sections.php'>View Sections</a></td>
        </tr>
        <tr>
            <td>$row[0]</td>
            <td>Mentor</td>
            <td><a href='view-mentor.php'>View Mentor</a></td>
        </tr>
        <tr>
            <td>$row[0]</td>
            <td>$row[1]</td>
            <td><a href='student-view-sessions.php'>View Sessions</td>
        </tr>
        <tr>
            <td>$row[0]</td>
            <td>$row[1]</td>
            <td><a href='view-moderators.php'>View List of Moderators</td>
        </tr>
        </table>
    ");

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

    $get_small_sessions_query = "SELECT Session.name, Section.name, Course.title, Session.theDate 
        FROM Session, Section, Course 
        WHERE
            Session.secID = Section.secID AND Session.cID = Section.cID AND
            Session.cId = Course.cID AND 
            Section.cID = Course.cID AND
            (Session.sesId, Session.secID, Session.cID) IN (
                SELECT sesID, secID, cID FROM SessLearn NATURAL JOIN SessTeach
                WHERE
                    (eeID = {$active_id} OR orID = {$active_id})
                    GROUP BY sesID, secID, cID
                    HAVING COUNT(DISTINCT(eeID)) < 3  
                        UNION
                SELECT sesID, secID, cID FROM SessTeach
                WHERE
                    orID = {$active_id} AND (sesId, secId, cID) NOT IN (
                        SELECT sesID, secID, cID FROM SessLearn
                    )
);";

    $result2 = mysqli_query($myconnection, $get_small_sessions_query) or die ('Query failed: ' . mysqli_error($myconnection));
    $html_string = "
        <h1>Notifications</h1>";
    $notification_string = "
        <h3>The following sessions you signed up for have been cancelled due to low mentee enrollment:</h3>
        <table style='width:25%' style='height:15%'>
            <tr>
                <th>Course</th>
                <th>Section</th>
                <th>Session</th>
                <th>Date</th>
            </tr>
    ";
    $note_count = 0;
    while($a_row = mysqli_fetch_row($result2)) {
        $sess_date = new DateTime($a_row[3]);
        if (date_diff($sess_date, $fri_date)->format("%d") < 9){
            $note_count++;
            $notification_string .= "
            <tr>
                <td>{$a_row[2]}</td>
                <td>{$a_row[1]}</td>  
                <td>{$a_row[0]}</td>
                <td>{$a_row[3]}</td>
            </tr>";
        }
    }
    $notification_string .= "</table>";
    echo($html_string);
    if ($note_count) {
        echo($notification_string);
    } else {
        echo("<h4>No notifications.</h4>");
    }
    echo('<h3><a href="logout.php">Logout</a></h3>');

    mysqli_close($myconnection);
    exit;
?>
