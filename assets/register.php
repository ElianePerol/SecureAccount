<?php
declare(strict_types=1);

require_once "../classes/db-connection.php";
require_once "../classes/user.php";
require_once "../classes/user-validator.php";
require_once "../classes/user-repository.php";
require_once "../classes/registration-service.php";

use App\{DatabaseConnection, UserValidator, UserRepository, RegistrationService};

// Initialisation des services
$dbConnection = DatabaseConnection::getInstance();
$userRepository = new UserRepository($dbConnection);
$userValidator = new UserValidator();
$registrationService = new RegistrationService($userValidator, $userRepository);

// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    // Tentative d'inscription
    $result = $registrationService->register($username, $email, $password, $confirmPassword);

    if ($result["success"]) {
        session_start();

        $_SESSION["username"] = $username;
        $_SESSION["email"] = $email;

        header("Location: success.php");
        exit();
    } else {
        session_start();
        
        $_SESSION["errors"] = $result["errors"];
        header("Location: create-account.php");
        exit();
    }
}
?>