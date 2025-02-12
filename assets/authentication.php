<?php
declare(strict_types=1);

require_once "../classes/db-connection.php";
require_once "../classes/user.php";
require_once "../classes/user-repository.php";
require_once "../classes/authentication-service.php"; 

use App\{DatabaseConnection, UserRepository, AuthenticationService};

$dbConnection = DatabaseConnection::getInstance();
$userRepository = new UserRepository($dbConnection);
$authenticationService = new AuthenticationService($userRepository);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usernameOrEmail = trim($_POST["usernameOrEmail"]);
    $password = $_POST["password"];

    $result = $authenticationService->authenticate($usernameOrEmail, $password);

    if ($result["success"]) {
        header("Location: dashboard.php");
        exit();
    } else {
        session_start();

        if (!isset($result['errors']) || !is_array($result['errors'])) {
            $result['errors'] = [];
        }

        $_SESSION["errors"] = $result["errors"];

        // header("Location: login.php");
        // exit();
    }
}
?>

