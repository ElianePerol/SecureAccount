<?php
    session_start();
    session_destroy();

    // Supprimer le cookie de session
    setcookie("session_id", "", [
        'expires' => time() - 3600, // Expiration dans le passé
        'httponly' => true,
        'secure' => true,
        'samesite' => 'Strict'
    ]);

    header('Location: ../pages/login.php');
    exit;
?>