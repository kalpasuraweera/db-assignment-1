<?php
function handleLogout()
{
    session_unset();
    session_destroy();
    header("Location: ../index.php");
    exit();
}

?>