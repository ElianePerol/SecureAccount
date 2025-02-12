<?php
session_start(); // Démarrer la session pour accéder aux informations

include_once "../common/header.php"; // Inclure l'en-tête de la page
?>

<body class="d-flex align-items-center justify-content-center vh-100 bg-light">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-body p-5">
                        <h1 class="text-success fw-bold mb-3">
                            🎉 Félicitations, <?= htmlspecialchars($_SESSION['username']) ?> ! 🎉
                        </h1>
                        <p class="fs-5 text-muted">
                            Votre compte a été créé avec succès. Voici vos informations :
                        </p>

                        <div class="mt-4">
                            <p><strong>Nom d'utilisateur :</strong> <?= htmlspecialchars($_SESSION['username']) ?></p>
                            <p><strong>Adresse e-mail :</strong> <?= htmlspecialchars($_SESSION['email']) ?></p>
                        </div>

                        <div class="mt-4">
                            <a href="login.php" class="btn btn-primary btn-lg">
                                <i class="bi bi-box-arrow-in-right"></i> Connexion
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

<?php include_once "../common/footer.php"; ?>
