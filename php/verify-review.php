<?php
    session_start();

    $or_ID = $_GET['orID']; # get parameter from link
    $ee_ID = $_GET['eeID']; 
    $sec_ID = $_GET['secID']; 
    $c_ID = $_GET['cID']; 
    $ee_name = $_GET['mentee']; 
    $email = $_GET['eeEmail']; 


  
    $myconnection = mysqli_connect('localhost', 'root', '')
    or die ('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');

    $get_comment_query = "SELECT comment FROM Review WHERE orId=$or_ID AND eeID=$ee_ID AND secID=$sec_ID AND cID=$c_ID"; 
    $result1 = mysqli_query($myconnection, $get_comment_query) or die ('Query failed: ' . mysqli_error($myconnection));
    $row = mysqli_fetch_row($result1);
    $html_string =  "<h1>Does this comment seem acceptable to you?</h1>

    <h4>{$row[0]}</h4>

    <form action='review-verified.php' method='POST'>
        <input type='hidden' name='c_ID' value='{$c_ID}'/>
        <input type='hidden' name='sec_ID' value='{$sec_ID}'/>
        <input type='hidden' name='ee_ID' value='{$ee_ID}'/>
        <input type='hidden' name='or_ID' value='{$or_ID}'/>
        <input type='hidden' name='mentee' value='{$ee_name}'/>
        <input type='hidden' name='email' value='{$email}'/>

        <label>
            Verify:
            <select name='verify'>
                <option value=1>Yes</option>
                <option value=0>No</option>
            </select>
        </label>
        <br/>
      <button>Submit</button>
    </form>";

  
    echo($html_string);
    echo("<h3><a href='parent-dashboard.php'>Back to dashboard</a></h3>");
    echo("<h3><a href='logout.php'>Logout</a><h3>");

    mysqli_close($myconnection);
    exit;
?>
