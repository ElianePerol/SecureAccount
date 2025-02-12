<?php
include_once "../common/session-start.php";
include_once "../common/header.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$email = $_SESSION['email'];
?>

<body class="d-flex align-items-center justify-content-center vh-100 bg-light">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-body p-5">
                        <h1 class="text-success fw-bold mb-3">
                            🎉 Bravo, <?php echo htmlspecialchars($username); ?> ! 🎉
                        </h1>
                        <p class="fs-5 text-muted">
                            Vous êtes connecté à votre session !
                        </p>

                        <div class="mt-4 text-muted">
                            <p><strong>Nom d'utilisateur :</strong> <?php echo htmlspecialchars($username); ?></p>
                            <p><strong>Adresse e-mail :</strong> <?php echo htmlspecialchars($email); ?></p>
                        </div>

                        <div class="mt-4">
                            <a href="../common/logout.php" class="btn btn-danger btn-lg">  <i class="bi bi-box-arrow-right"></i> Déconnexion
                            </a>
                            <a href="index.php" class="btn btn-outline-secondary btn-lg">
                                <i class="bi bi-house-door"></i> Retour à l'accueil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<?php include_once "../common/footer.php"; ?>