<?php
    session_start();
    
    $myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysqli_error());
    $mydb = mysqli_select_db ($myconnection, 'DB2') or die ('Could not select database');
    
    $active_id = $_SESSION['active_ID'];

    $get_section_info = "SELECT Course.title, Course.orReq, Course.eeReq,
        Section.name, Section.capacity, Section.startDate, Section.endDate,
        Schedule.startTime, Schedule.endTime, Schedule.days 
        FROM Course, Section, Schedule 
        Where Course.cID = Section.cID AND
            Section.schedID = Schedule.schedID;"
    
    $get_info_query = "SELECT name, role, grade FROM User, Student WHERE {$active_id} = uID AND Student.sID = User.uID;";
    $result1 = mysqli_query($myconnection, $get_info_query) or die ('Query failed: ' . mysqli_error($myconnection));
    $row = mysqli_fetch_row($result1);
    mysqli_free_result($result1);
    

        
    echo('<h3><a href="logout.php">Logout</a></h3>');


    mysqli_close($myconnection);
    exit;
?>