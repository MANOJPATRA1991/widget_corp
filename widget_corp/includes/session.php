<?php
    //start a new session
    session_start();

    //display the message as to whether creating a subject is a success or a failure
    function message() {
        if (isset($_SESSION["message"])) {
            $output = "<div class=\"message\">";
            $output .= htmlentities($_SESSION["message"]);
            $output .= "</div>";
            
            // clear message after use
            $_SESSION["message"] = null;
            return $output;
        }
    }

    //returns errors in form validation as an array
    function errors() {
        if (isset($_SESSION["errors"])) {
            $errors = $_SESSION["errors"];
            // clear message after use
            $_SESSION["errors"] = null;
            return $errors;
        }
    }
?>