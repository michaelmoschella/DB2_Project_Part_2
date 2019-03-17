<?php
    session_start();
    if (session_destroy()) {
        echo ("
            <h1>You have successfully been logged out.</h1>
            <h3><a href='../not_useless.html'>Back to main page</a></h3>
        ");
    } else {
        echo ("
            <h1>An error occurred.</h1>
            <h3><a href='../not_useless.html'>Back to main page</a></h3>
        ");
    }
    exit;
?>
