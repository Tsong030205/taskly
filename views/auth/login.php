<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include VIEW_PATH . 'partials/header.php'; ?>
    
    <main class="main-content">
        <div class="auth-container">
            <div class="auth-card">
                <div class="auth-header">
                    <h1>Se connecter</h1>
                    <p>Accédez à votre espace personnel</p>
                </div>
                
                <?php include VIEW_PATH . 'partials/flash-messages.php'; ?>
                
                <form method="POST" class="auth-form">
                    <?php if (isset($errors['general'])): ?>
                        <div class="alert alert-error">
                            <?php echo $errors['general']; ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Adresse email</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-input <?php echo isset($errors['email']) ? 'error' : ''; ?>" 
                            value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>"
                            required
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-input <?php echo isset($errors['password']) ? 'error' : ''; ?>" 
                            required
                        >
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-full">Se connecter</button>
                </form>
                
                <div class="auth-footer">
                    <p>Pas encore de compte ? <a href="<?php echo BASE_URL; ?>/auth/register" class="auth-link">S'inscrire</a></p>
                </div>
            </div>
        </div>
    </main>

    <?php include VIEW_PATH . 'partials/footer.php'; ?>
</body>
</html>