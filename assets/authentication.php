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

$show2FAField = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $usernameOrEmail = trim($_POST["usernameOrEmail"]);
    $password = $_POST["password"];
    $otp = $_POST['otp'] ?? null;

    $result = $authenticationService->authenticate($usernameOrEmail, $password, $otp);

    if (!$result['success']) {
        $errors = $result['errors'];
        if (isset($result['errors']) && in_array('Code 2FA requis', $result['errors'])) {
            $show2FAField = true;
        }
    } else {
        header('Location: dashboard.php');
        exit();
    }
}
?>

