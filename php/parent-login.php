<?php
  $p_email = $_POST['Parent_Email_Login']; 
  $p_pass = $_POST['Parent_Pass_Login']; 

  $myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysqli_error());
  $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');

  # determine next available id
  $get_pass_query = "SELECT password, username FROM User WHERE email = \"{$p_email}\" AND uID IN 
  (SELECT pID FROM Parent);";
  $result1 = mysqli_query($myconnection, $get_pass_query) or die ('Query failed: ' . mysqli_error($myconnection));
  $row = mysqli_fetch_row($result1);
  if ($row){
    $p_stored_pass = $row[0];
    $p_username = $row[1];
    if ($p_stored_pass == $p_pass) {
        echo("Hello {$p_username}");
    } else {
        echo('The provided password is incorrect');
    }
  } else {
    echo('This email is not registered to a parent in our Database');
  }
  mysqli_free_result($result1);
  mysqli_close($myconnection);

  exit;
?>


