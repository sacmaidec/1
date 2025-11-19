<?php
session_start();      // start or resume session
session_unset();      // remove all session variables
session_destroy();    // destroy the session

// Redirect back to homepage
header("Location: index.php");
exit();
?>
