<?php 

    session_start();
    session_unset();
    session_destroy();

    header("Location: ../UserLogin/UserLogin.html?logout=true");
    die();
?>