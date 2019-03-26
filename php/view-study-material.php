<?php
    session_start();
  
    $myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');
    
    $c_id = $_GET['cID'];
    $sec_id = $_GET['secID'];
    $ses_id = $_GET['sesID'];
    $c_title = $_GET['cTitle'];
    $sec_name = $_GET['secName'];
    $ses_name = $_GET['sesName'];
    
    $html_string = "
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
        <h1>{$c_title} {$sec_name}</h1>
        <label>
        <table style='width:25%' style='height:15%'>
            <tr>
                <td colspan = '7' style = 'text-align: center;'><h4>{$ses_name} Study Material</h4></td>
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
                
                $get_session_material_query = "SELECT SessionMat.assigned, SessionMat.due, SessionMat.notes, Material.author, Material.type, Material.URL, Material.title FROM SessionMat, Material 
        WHERE SessionMat.sesID = {$ses_id} AND SessionMat.secID = {$sec_id} AND SessionMat.cId = {$c_id} AND SessionMat.matID = Material.matID";
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
    echo($html_string);
    echo('<h3><a href="student-view-sessions.php">Back to view sessions</a></h3>');
    echo('<h3><a href="student-dashboard.php">Back to dashboard</a></h3>');
    echo('<h3><a href="logout.php">Logout</a></h3>');

    mysqli_close($myconnection);
    exit;
?>
