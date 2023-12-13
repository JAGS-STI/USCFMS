<?php 

    ini_set('session.use_only_cookie', 1);
    ini_set('session.use_strict_cookie', 1);
    $host = $_SERVER['HTTP_HOST'];

    if ($host === 'localhost') {
        // Configuration for localhost
        ini_set('session.cookie_domain', 'localhost');
    } else if ($host === $host) {
        // Configuration for 192.168.100.184
        ini_set('session.cookie_domain', $host);
    } else {
        // Default configuration
        $error = "Warning, accessed through unknown domain: " . $host;
        error_log($error);
        echo $error;
        die();
    }

    session_set_cookie_params([
        'lifetime' => 1800,
        'path' => '/',
        'secure' => false,
        'httponly' => false
    ]);

    session_start();

    if(isset($_SESSION["user_id"])) {
        if (!isset($_SESSION["last_regeneration"])) {
            regenerate_session_id_loggedin();
    
        } else {
            $interval = 60 * 60;
            if (time() - $_SESSION["last_regeneration"] >= $interval) {
                regenerate_session_id_loggedin();
            }
        }

    } else {
        if (!isset($_SESSION["last_regeneration"])) {
            regenerate_session_id();
    
        } else {
            $interval = 60 * 60;
            if (time() - $_SESSION["last_regeneration"] >= $interval) {
                regenerate_session_id();
            }
        }
    }

    function regenerate_session_id_loggedin() {
        session_regenerate_id(true);

        $user_id = $_SESSION["user_id"];
        $newSessionId = session_create_id();
        $sessionId = $newSessionId . "_" . $user_id;
        session_id($sessionId);
        
        $_SESSION["last_regeneration"] = time();
    }

    function regenerate_session_id() {
        session_regenerate_id();
        $_SESSION["last_regeneration"] = time();
    }
?>