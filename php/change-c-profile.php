<?php
    session_start();

    $c_ID = $_GET['cID']; # get parameter from link
  
    $myconnection = mysqli_connect('localhost', 'root', '')
    or die ('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');

    $active_id = $_SESSION['active_ID'];

    $get_info_query = "SELECT name, username, password, email, phone, role FROM User WHERE {$c_ID} = uID;";
    $result1 = mysqli_query($myconnection, $get_info_query) or die ('Query failed: ' . mysqli_error($myconnection));
    $row = mysqli_fetch_row($result1);
    mysqli_free_result($result1);

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

    mysqli_close($myconnection);
    exit;
?>
