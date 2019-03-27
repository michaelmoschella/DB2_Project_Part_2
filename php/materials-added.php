<?php
/********************************************** 
materials-added.php

Adds study material to the Material table which
stores info about the study material itself,
 and the SessionMat table which stores information
 relevant to the session the material was 
 assigned to.
***********************************************/
    $c_ID = $_POST['c_ID'];
    $sec_ID = $_POST['sec_ID'];
    $ses_ID = $_POST['ses_ID'];
    $material_name = $_POST['Material_Name'];
    $author_ = $_POST['Author'];
    $type_ = $_POST['Type'];
    $url_ = $_POST['Url'];
    $title_ = $_POST['Title'];
    $Notes_ = $_POST['Notes'];
    $date = $_POST['date'];
    $todays_date = date("Y-m-d");

    $myconnection = mysqli_connect('localhost', 'root', '')
    or die ('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');

    # determine next available id
    $max_id_query = "SELECT MAX(matID) FROM Material";
    $result1 = mysqli_query($myconnection, $max_id_query) or die ('Query failed: ' . mysqli_error($myconnection));
    $row = mysqli_fetch_row($result1);
    if ($row){
        $matID = $row[0] + 1;
    } else {
        $matID = 1;
    }
    mysqli_free_result($result1);

    $update_query = "INSERT INTO Material VALUES
  (  '${matID}',    '${author_}',  '${type_}','${url_}','${title_}');";

    $result1 = mysqli_query($myconnection, $update_query) or die ('Query failed: ' . mysqli_error($myconnection));
    echo(
        "<h1>You successfully posted materials!</h1>
        <h3><a href='parent-dashboard.php'>Back to dashboard</a></h3>
        <h3><a href='logout.php'>Logout</a>"
    );

    $update_query = "INSERT INTO sessionmat VALUES
  (  '${ses_ID}',    '${sec_ID}',  '${c_ID}','${matID}','${todays_date}','${date}','${Notes_}');";

    $result1 = mysqli_query($myconnection, $update_query) or die ('Query failed: ' . mysqli_error($myconnection));
    echo(
        "<h1>You successfully posted materials!</h1>
        <h3><a href='parent-dashboard.php'>Back to dashboard</a></h3>
        <h3><a href='logout.php'>Logout</a>"
    );

    mysqli_close($myconnection);
    exit;
?>
