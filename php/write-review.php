<?php
    session_start();

    $or_ID = $_GET['orID']; # get parameter from link
    $ee_ID = $_GET['eeID']; 
    $sec_ID = $_GET['secID']; 
    $c_ID = $_GET['cID']; 
    $or_name = $_GET['name']; 
    $title = $_GET['title']; 
    $section = $_GET['section']; 

  
    $myconnection = mysqli_connect('localhost', 'root', '')
    or die ('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');

    $html_string =  "<h1>Write a review of {$or_name}'s performance in {$title} {$section}</h1>

    <form action='review-added.php' method='POST'>
        <input type='hidden' name='c_ID' value='{$c_ID}'/>
        <input type='hidden' name='sec_ID' value='{$sec_ID}'/>
        <input type='hidden' name='ee_ID' value='{$ee_ID}'/>
        <input type='hidden' name='or_ID' value='{$or_ID}'/>
        <label>
            Rating:
            <select name='rating'>
                <option value=5>5</option>
                <option value=4>4</option>
                <option value=3>3</option>
                <option value=2>2</option>
                <option value=1>1</option>
            </select>
        </label>
        <br/>
        <label>
            Comment:<br/>
            <textarea rows='5' cols='45' name='comment'></textarea><br>
        </label>
      <button>Submit</button>
    </form>";

  
    echo($html_string);
    echo("<h3><a href='student-dashboard.php'>Back to dashboard</a></h3>");
    echo("<h3><a href='logout.php'>Logout</a><h3>");

    mysqli_close($myconnection);
    exit;
?>

