<?php
    session_start();

    $sec_ID = (isset($_GET['secID']) ? $_GET['secID'] : null); # get parameter from link
    $c_ID = (isset($_GET['cID']) ? $_GET['cID'] : null); # get parameter from link
    $class_name = (isset($_GET['classname']) ? $_GET['classname'] : null);
    $mentor_req = (isset($_GET['mentorRequire']) ? $_GET['mentorRequire'] : null);
    echo(
        "<h1>{$sec_ID}</h1><br>"
    );

    echo(
        "<h1>{$c_ID}</h1><br>"
    );
    echo(
        "<h1>{$mentor_req}</h1>"
    );
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



    $get_info_query = "SELECT User.uID, User.name, Student.grade FROM User, Student WHERE role = 'Mentor' AND Student.sID = User.uID AND Student.grade >= $mentor_req;";
    $result1 = mysqli_query($myconnection, $get_info_query) or die ('Query failed: ' . mysqli_error($myconnection));
    #$row = mysqli_fetch_row($result1);
    #mysqli_free_result($result1);

    while ($row = mysqli_fetch_row($result1)){
        $html_string .=   "
      <tr>
        <td>$row[0]</td>
        <td>$row[1]</td>
        <td>$row[2]</td>
        <td>Assign</td>
      </tr>"; }

    $html_string .=   "<label>
    </table>";

/*
    echo("
        <h1>Change Your Child's Profile as Parent User</h1>

        <form action='c-profile-altered.php' method='POST'>
            <input type='hidden' name='c_ID' value='{$c_ID}'/>
            <label>
                Name:
                <input placeholder='{$row[0]}' type='text' name='Parents_Children_Name'><br>
            <label>
            <label>
                Username:
                <input placeholder='{$row[1]}' type='text' name='c_username'><br>
            </label>
            <label>
                PWD:
                <input placeholder='New Password' type='password' name='Parents_Children_Pass'><br>
            </label>
            <label>
                Confirm:
                <input placeholder='Confirm password' type='password' name='Parents_Children_Confirm_Pass'><br>
            </label>
            <label>
                Phone:
                <input placeholder='{$row[4]}' type='text' name='Parent_Children_Phone_Number'><br>
            </label>
            <label>
                Email:
                <input placeholder='{$row[3]}' type='text' name='c_Email'><br>
            </label>
            <label>
                Role:
                <select name='c_role'>
                    <option value='None'>None</option>
                    <option value='Mentor'>Moderator</option>
                    <option value='Mentee'>Mentee</option>
                    <option value='Both'>Both</option>
                </select><br>
            </label>

          <button>Submit Changes</button>
        </form>
    ");

    echo("<h3><a href='parent-dashboard.php'>Back to dashboard</a></h3>");
    echo("<h3><a href='logout.php'>Logout</a><h3>");
*/

echo($html_string);
    mysqli_close($myconnection);
    exit;
?>
