<?php
  $p_email = $_POST['Parent_Email']; 
  $p_pass = $_POST['Parent_Pass'];
  $p_pass_confirm  = $_POST['Parent_Confirm_Pass'];
  $p_role = $_POST['p_role'];
  $p_name = $_POST['Parent_Name'];
  $p_phone = $_POST['Parent_Phone_Number'];
  $p_username = $_POST['p_username'];

  $myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysqli_error());
  $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');

  # determine next available id
  $max_id_query = "SELECT MAX(uID) FROM User";
  $result1 = mysqli_query($myconnection, $max_id_query) or die ('Query failed: ' . mysqli_error($myconnection));
  $row = mysqli_fetch_row($result1);
  if ($row){
    $p_id = $row[0] + 1;
  } else {
    $p_id = 1;
  }
  mysqli_free_result($result1);

  # insert into user table
  $insert_user_query = "INSERT INTO User VALUES ({$p_id}, \"{$p_name}\", \"{$p_email}\", \"{$p_phone}\", \"{$p_username}\", \"{$p_pass}\", \"{$p_role}\");";
  $result2 = mysqli_query($myconnection, $insert_user_query) or die ('Query failed: ' . mysqli_error($myconnection));
  
  #inser into parent table
  $insert_parent_query = "INSERT INTO Parent VALUES ({$p_id});";
  $result2 = mysqli_query($myconnection, $insert_parent_query) or die ('Query failed: ' . mysqli_error($myconnection));
  
  # insert into moderator table
  if ($p_role === 'Moderator') {
    $insert_moderator_query = "INSERT INTO Moderator VALUES($p_id);";
    $result3 = mysqli_query($myconnection, $insert_moderator_query) or die ('Query failed: ' . mysqli_error($myconnection));
  }
  
  mysqli_close($myconnection);

  # this points the browser back to useless.html, we may need to use echo instead
  # or figure out another way to indicate to the user that the registration was successful. 
  header('location: ../useless.html');
  exit;
?>
