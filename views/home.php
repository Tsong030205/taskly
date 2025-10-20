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
        <section class="hero-section">
            <div class="container">
                <div class="hero-content">
                    <h1 class="hero-title">
                        Organisez votre vie avec <span class="text-primary">Taskly</span>
                    </h1>
                    <p class="hero-description">
                        L'application de gestion de tâches simple, moderne et efficace pour booster votre productivité.
                    </p>
                    <div class="hero-actions">
                        <?php if (!$user): ?>
                            <a href="<?php echo BASE_URL; ?>/auth/register" class="btn btn-primary btn-large">
                                Commencer gratuitement
                            </a>
                            <a href="<?php echo BASE_URL; ?>/auth/login" class="btn btn-secondary btn-large">
                                Se connecter
                            </a>
                        <?php else: ?>
                            <a href="<?php echo BASE_URL; ?>/tasks" class="btn btn-primary btn-large">
                                Voir mes tâches
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="hero-visual">
                    <div class="task-card-preview">
                        <div class="task-card">
                            <div class="task-header">
                                <h3>✨ Tâche exemple</h3>
                                <span class="priority-badge priority-high">Haute</span>
                            </div>
                            <p>Créer ma première tâche dans Taskly</p>
                            <div class="task-footer">
                                <span class="due-date">📅 Aujourd'hui</span>
                                <button class="btn-complete">✓</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="features-section">
            <div class="container">
                <h2 class="section-title">Pourquoi choisir Taskly ?</h2>
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">🚀</div>
                        <h3>Rapide & Simple</h3>
                        <p>Interface intuitive pour une prise en main immédiate.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">📱</div>
                        <h3>Responsive</h3>
                        <p>Accédez à vos tâches depuis n'importe quel appareil.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">🔒</div>
                        <h3>Sécurisé</h3>
                        <p>Vos données sont protégées et privées.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include VIEW_PATH . 'partials/footer.php'; ?>
</body>
</html>