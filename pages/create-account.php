<?php 
    include_once "../common/session-start.php";
    include_once "../common/header.php";
    include_once "../assets/register.php";
?>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h2 class="card-title text-center mb-4">Créer un compte</h2>
                        
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

                        <form id="registrationForm" action="create-account.php" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Nom d'utilisateur</label>
                                <input type="text" class="form-control" id="username" name="username"  required>
                                <div id="usernameError" class="error"></div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Adresse e-mail</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <div id="emailError" class="error"></div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <div id="passwordError" class="error"></div>
                            </div>

                            <div class="mb-4">
                                <label for="confirmPassword" class="form-label">Confirmation du mot de passe</label>
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                                <div id="confirmPasswordError" class="error"></div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Créer le compte</button>
                            </div>
                        </form>

                        <div class="text-center mt-3">
                            <small class="text-muted">Vous avez déjà un compte ? 
                                <a href="login.php" class="text-decoration-none">Connectez-vous</a>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include_once "../common/footer.php" ?>



