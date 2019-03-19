<?php
    $s_email = $_POST['Student_Email'];
    $p_email = $_POST['Students_Parent_Email'];
    $s_pass = $_POST['Student_Pass'];
    $s_pass_confirm  = $_POST['Student_Confirm_Pass'];
    $s_role = $_POST['s_role'];
    $s_name = $_POST['Student_Name'];
    $s_phone = $_POST['Student_Phone_Number'];
    $s_username = $_POST['s_username'];
    $s_grade = (int)$_POST['s_grade'];

    $myconnection = mysqli_connect('localhost', 'root', '')
        or die ('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');

    # determine next available id
    $max_id_query = "SELECT MAX(uID) FROM User";
    $result1 = mysqli_query($myconnection, $max_id_query) or die ('Query failed: ' . mysqli_error($myconnection));
    $row = mysqli_fetch_row($result1);
    if ($row){
        $s_id = $row[0] + 1;
    } else {
        $s_id = 1;
    }
    mysqli_free_result($result1);

    # search for parent in database by email
    $find_pid_query = "SELECT uID FROM User WHERE email = \"{$p_email}\";";
    $result2 = mysqli_query($myconnection, $find_pid_query);

    $row = mysqli_fetch_row($result2);
    if ($row){
        $p_id = $row[0];

        if ($s_role == 'None') {
            $s_role = 'Student';
        }
        $insert_user_query = "INSERT INTO User VALUES ({$s_id}, \"{$s_name}\", \"{$s_email}\", \"{$s_phone}\", \"{$s_username}\", \"{$s_pass}\", \"$s_role\");";
        $result3 = mysqli_query($myconnection, $insert_user_query) or die ('Query failed: ' . mysqli_error($myconnection));

        $insert_family_query = "INSERT INTO Family VALUES ({$p_id}, {$s_id});";
        $result7 = mysqli_query($myconnection, $insert_family_query) or die ('Query failed: ' . mysqli_error($myconnection));

        $insert_student_query = "INSERT INTO Student VALUES ({$s_id}, {$s_grade});";
        $result6 = mysqli_query($myconnection, $insert_student_query) or die ('Query failed: ' . mysqli_error($myconnection));

        if ($s_role === 'Mentor' || $s_role === 'Both' ) {
            $insert_mentor_query = "INSERT INTO Mentor VALUES ({$s_id});";
            $result4 = mysqli_query($myconnection, $insert_mentor_query) or die ('Query failed: ' . mysqli_error($myconnection));
        }
        if ($s_role ==='Mentee' || $s_role ==='Both') {
            $insert_mentee_query = "INSERT INTO Mentee VALUES({$s_id});";
            $result5 = mysqli_query($myconnection, $insert_mentee_query) or die ('Query failed: ' . mysqli_error($myconnection));
            # Do we need to handle when one of the queries fails????????????????????????????

            echo("<h1>Congratulations {$s_username}, you have successfully registered!</h1>
            <h3><a href='../useless.html'>Back to main page</a></h3>");
        }
    } else {
        # parent not found in database
        echo("<h1>Parent not found!</h1>
            <h5>As a student your parent must have an account before you can create one.</h5>
            <h3><a href='../not_useless.html'>Back to main page</a></h3>");
    }
    mysqli_free_result($result2);
    mysqli_close($myconnection);


    exit;

?>
