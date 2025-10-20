<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page non trouvée - <?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include VIEW_PATH . 'partials/header.php'; ?>
    
    <main class="main-content">
        <div class="container">
            <div class="error-page">
                <div class="error-code">404</div>
                <h1>Page non trouvée</h1>
                <p>Désolé, la page que vous recherchez n'existe pas.</p>
                <a href="<?php echo BASE_URL; ?>" class="btn btn-primary">Retour à l'accueil</a>
            </div>
        </div>
    </main>

    <?php include VIEW_PATH . 'partials/footer.php'; ?>
</body>
</html>