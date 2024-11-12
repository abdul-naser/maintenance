<?php
session_start(); // Start or resume the session

// Unset specific session variables

//School Login
unset($_SESSION['logged_in']);
unset($_SESSION['school_code']);
unset($_SESSION['nameSchool']);
unset($_SESSION['civil_no']);

// Section Login 
unset($_SESSION['logged_section']);
unset($_SESSION['section']);
unset($_SESSION['SectionID']);



//admin Login
unset($_SESSION['logged_admin']);
unset($_SESSION['nameAdmin']);


// Optionally destroy the session if you want to end the session completely
// session_destroy();

// Redirect to the login page or another page
header("Location: index.php");
exit(); // Stop further script execution after redirection
?>
