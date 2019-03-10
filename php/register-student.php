<?php
  $s_email = $_POST['Student_Email']; 
  $p_email = $_POST['Students_Parent_Email']; 
  $s_pass = $_POST['Student_Pass'];
  $s_pass_confirm  = $_POST['Student_Confirm_Pass'];
  $s_role = $_POST['s_role'];
  $s_name = $_POST['Student_Name'];
  $s_phone = $_POST['Student_Phone_Number'];
  $s_username = $_POST['s_username'];
  $s_grade = $_POST['s_grade'];

  $myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysqli_error());
  $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');

  # determine next available id
  $max_id_query = "SELECT MAX(uID) FROM User";
  $result1 = mysqli_query($myconnection, $max_id_query) or die ('Query failed: ' . mysqli_error($myconnection));
  if ($result1){
    $row = mysqli_fetch_row($result1);
    $s_id = $row[0] + 1;
  } else {
    $s_id = 1;
  }
  mysqli_free_result($result1);

  # search for parent in database by email
  $find_pid_query = "SELECT uID FROM User WHERE email = \"{$p_email}\";";
  $result2 = mysqli_query($myconnection, $find_pid_query);
  if ($result2){
      $row = mysqli_fetch_row($result2);
      $p_id = $row[0];
      
      $insert_user_query = "INSERT INTO User VALUES ({$s_id}, \"{$s_name}\", \"{$s_email}\", \"{$s_phone}\", \"{$s_username}\", \"{$s_pass}\", \"$s_role\");";
      $result3 = mysqli_query($myconnection, $insert_user_query) or die ('Query failed: ' . mysqli_error($myconnection));

      $insert_family_query = "INSERT INTO Family VALUES ({$p_id}, {$s_id});";
      $result7 = mysqli_query($myconnection, $insert_family_query) or die ('Query failed: ' . mysqli_error($myconnection));
      if ($s_role === 'Mentor' || $s_role === 'Both' ) {
        $insert_mentor_query = "INSERT INTO Mentor VALUES ({$s_id});";
        $result4 = mysqli_query($myconnection, $insert_mentor_query) or die ('Query failed: ' . mysqli_error($myconnection));
      }
      if ($s_role ==='Mentee' || $s_role ==='Both') {
        $insert_mentee_query = "INSERT INTO Mentee VALUES({$s_id});";
        $result5 = mysqli_query($myconnection, $insert_mentee_query) or die ('Query failed: ' . mysqli_error($myconnection));
    }
    $insert_student_query = "INSERT INTO Student VALUES ({$s_id}, \"{$s_grade}\");";
    $result6 = mysqli_query($myconnection, $insert_student_query) or die ('Query failed: ' . mysqli_error($myconnection));
  } else {
      # parent not found in database
      echo("Parent not found");
  }
  mysqli_free_result($result2);
  mysqli_close($myconnection);

  # this points the browser back to useless.html, we may need to use echo instead
  # or figure out another way to indicate to the user that the registration was successful. 
  header('location: ../useless.html');
  exit;
?>

