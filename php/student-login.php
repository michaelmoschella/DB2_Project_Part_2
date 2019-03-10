<?php
  $s_email = $_POST['Student_Email_Login']; 
  $s_pass = $_POST['Student_Pass_Login']; 

  $myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysqli_error());
  $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');

  # determine next available id
  $get_pass_query = "SELECT password, username FROM User WHERE email = \"{$s_email}\" AND uID IN 
  (SELECT sID FROM Student);";
  $result1 = mysqli_query($myconnection, $get_pass_query) or die ('Query failed: ' . mysqli_error($myconnection));
  $row = mysqli_fetch_row($result1);
  if ($row){
    $s_stored_pass = $row[0];
    $s_username = $row[1];
    if ($s_stored_pass == $s_pass) {
        echo("Hello {$s_username}");
    } else {
        echo('The provided password is incorrect.');
    }
  } else {
    echo('This email is not registered to a student in our Database.');
  }
  mysqli_free_result($result1);
  mysqli_close($myconnection);

  exit;
?>

