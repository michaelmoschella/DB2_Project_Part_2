<?php
    session_start();
    $s_email = $_POST['Student_Email_Login'];
    $s_pass = $_POST['Student_Pass_Login'];

    $myconnection = mysqli_connect('localhost', 'root', '')
    or die ('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');

    $get_pass_query = "SELECT password, username, uID FROM User WHERE email = \"{$s_email}\" AND uID IN
    (SELECT sID FROM Student);";
    $result1 = mysqli_query($myconnection, $get_pass_query) or die ('Query failed: ' . mysqli_error($myconnection));
    $row = mysqli_fetch_row($result1);
    if ($row){
        $s_stored_pass = $row[0];
        $s_username = $row[1];
        if ($s_stored_pass == $s_pass) {
            $_SESSION["active_ID"] = $row[2];
            echo("<h1>Welcome {$s_username}, you have successfully logged in!</h1>
                <h3><a href='./student-dashboard.php'>Click here to go to your student dashboard</a></h3>
                <h5><a href='./logout.php'>Logout</a></h5>");

        } else {
            echo("<h1>Sorry, the provided password does not match the account for {$s_email}</h1>
            <h3><a href='../Phase2.html'>Back to main page</a></h3>");
        }
    } else {
        echo("<h1>Sorry, the email address {$s_email} is not registered to a student in our Database</h1>
            <h3><a href='../Phase2.html'>Back to main page</a></h3>");
    }
    mysqli_free_result($result1);

    mysqli_close($myconnection);
    exit;
?>
