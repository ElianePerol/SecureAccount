<?php
include_once "../common/header.php";
include_once "../assets/authentication.php";

$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
unset($_SESSION['errors']);
?>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h2 class="card-title text-center mb-4">Connexion</h2>

                        <!-- Affichage des erreurs -->
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <?php foreach ($errors as $error): ?>
                                        <li><?= htmlspecialchars($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form id="loginForm" action="login.php" method="POST">
                            <div class="mb-3">
                                <label for="usernameOrEmail" class="form-label">Nom d'utilisateur ou E-mail</label>
                                <input type="text" class="form-control" id="usernameOrEmail" name="usernameOrEmail" required>
                                <div id="usernameOrEmailError" class="error"></div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <div id="passwordError" class="error"></div>
                            </div>

                            <?php if ($show2FAField): ?>
                            <div class="mb-3">
                                <label for="otp" class="form-label">Code 2FA</label>
                                <input type="text" class="form-control" id="otp" name="otp" 
                                       inputmode="numeric" pattern="[0-9]*" maxlength="6" required>
                                <div class="invalid-feedback">
                                    Veuillez entrer votre code 2FA
                                </div>
                            </div>
                            <?php endif; ?>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Se connecter</button>
                            </div>
                        </form>

                        <div class="text-center mt-3">
                            <small class="text-muted">Pas encore de compte ? 
                                <a href="create-account.php" class="text-decoration-none">Créez un compte</a>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include_once "../common/footer.php" ?>
