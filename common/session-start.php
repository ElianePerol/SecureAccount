<?php
    session_start();
    $errors = $_SESSION["errors"] ?? [];
    unset($_SESSION["errors"]);
?>