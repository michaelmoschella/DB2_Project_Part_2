<?php
/********************************************** 
logout.php

Ends session with variable indicating who
was logged in. (logging them out)
***********************************************/
    session_start();
    if (session_destroy()) {
        echo ("
            <h1>You have successfully been logged out.</h1>
            <h3><a href='../Phase2.html'>Back to main page</a></h3>
        ");
    } else {
        echo ("
            <h1>An error occurred.</h1>
            <h3><a href='../Phase2.html'>Back to main page</a></h3>
        ");
    }
    exit;
?>
