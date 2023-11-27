<?php 

    session_start();
    session_unset();
    session_destroy();

    header("Location: ../UserHome/UserHome.html?logout=true");
    die();
?>