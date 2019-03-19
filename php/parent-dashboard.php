<?php
    session_start();

    $myconnection = mysqli_connect('localhost', 'root', '')
    or die ('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');

    $active_id = $_SESSION['active_ID'];

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

    if($p_role == 'Moderator'){
      $html_string .= "<tr>
        <td>Parent</td>
        <td>Section</td>
        <td><a href='parent-view-sections.php'>View Sections</a></td>
      </tr>
      <tr>
        <td>Moderator</td>
        <td>Moderator</td>
        <td><a href='parent-moderate-section-session.php'>View Moderator</a></td>
      </tr>
      ";
    }

    mysqli_free_result($result2);
    echo($html_string);
    echo('<h3><a href="logout.php">Logout</a></h3>');

    mysqli_close($myconnection);
    exit;
?>
