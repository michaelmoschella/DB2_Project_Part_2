<?php
/********************************************** 
post-materials.php

Provides form for parent to enter information 
about study material
***********************************************/
    session_start();

    $sec_ID = (isset($_GET['secID']) ? $_GET['secID'] : null); # get parameter from link
    $c_ID = (isset($_GET['cID']) ? $_GET['cID'] : null); # get parameter from link
    $class_name = (isset($_GET['classname']) ? $_GET['classname'] : null);
    $mentor_req = (isset($_GET['mentorRequire']) ? $_GET['mentorRequire'] : null);
    $ses_ID = (isset($_GET['sesID']) ? $_GET['sesID'] : null);
    $date = (isset($_GET['the_date']) ? $_GET['the_date'] : null);
  
    $myconnection = mysqli_connect('localhost', 'root', '')
    or die ('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');

    $active_id = $_SESSION['active_ID'];


    $html_string =  "<h1>Post New Material</h1>

    <form action='materials-added.php' method='POST'>
    <input type='hidden' name='c_ID' value='{$c_ID}'/>
    <input type='hidden' name='sec_ID' value='{$sec_ID}'/>
    <input type='hidden' name='ses_ID' value='{$ses_ID}'/>
    <input type='hidden' name='date' value='{$date}'/>
      <label>
      Material Name:
      <input placeholder='Material Name' type='text' name='Material_Name'><br>
      </label>
      <label>
      Author:
      <input placeholder='Author' type='text' name='Author'><br>
      </label>
      <label>
      Title:
      <input placeholder='Title' type='text' name='Title'><br>
      </label>
      <label>
        Type:
      <input placeholder='Type' type='text' name='Type'><br>
      </label>
      <label>
        Url:
      <input placeholder='Url' type='text' name='Url'><br>
      </label>
      <label>
        Notes:
      <textarea rows='5' cols='45' name='Notes'></textarea><br>
      </label>
      <button>Submit</button>
    </form>";

    $html_string .= "
        <head>
            <style>
                table {
                    font-family: arial, sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                    margin-bottom: 30px;
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
        <label>
        <table style='width:25%' style='height:15%'>
            <tr>
            </tr>
            <tr>
            <th>Title</th>
            <th>Author</th>
                <th>URL</th>
                <th>Type</th>
                <th>Assigned</th>
                <th>Due</th>
                <th>Notes</th>
                </tr>";

  $get_session_material_query = "SELECT SessionMat.assigned, SessionMat.due, SessionMat.notes,
    Material.author, Material.type, Material.URL, Material.title FROM SessionMat, Material
    WHERE SessionMat.cID = {$c_ID} AND SessionMat.secID = {$sec_ID} AND SessionMat.cId = {$c_ID} AND SessionMat.matID = Material.matID";
  $result1 = mysqli_query($myconnection, $get_session_material_query) or die ('Query failed: ' . mysqli_error($myconnection));
  if (mysqli_num_rows($result1)) {
  while ($row = mysqli_fetch_row($result1)) {# href left blank intentionally
  $html_string .= "
  <tr>
  <td>{$row[6]}</td>
  <td>{$row[3]}</td>
  <td><a href=''>{$row[5]}</a></td>
  <td>{$row[4]}</td>
  <td>{$row[0]}</td>
  <td>{$row[1]}</td>
  <td>{$row[2]}</td>
  </tr>
  ";
  }
  } else {
  $html_string .= "
  <tr>
    <td colspan = '7' style = 'text-align: center;'>No study materials have been assigned.</td>
  </tr>
  ";
  }
  $html_string .= "
  </table>
  <label>";


  echo("<h3><a href='parent-dashboard.php'>Back to dashboard</a></h3>");
  echo("<h3><a href='logout.php'>Logout</a><h3>");


echo($html_string);
    mysqli_close($myconnection);
    exit;
?>
