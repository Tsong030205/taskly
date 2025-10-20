<header class="header">
    <nav class="navbar">
        <div class="container">
            <div class="nav-brand">
                <a href="<?php echo BASE_URL; ?>" class="logo">
                    📝 Taskly
                </a>
            </div>
            
            <!-- Bouton menu mobile -->
            <button class="mobile-menu-button" id="mobileMenuButton">
                <span></span>
                <span></span>
                <span></span>
            </button>
            
            <div class="nav-menu" id="navMenu">
                <?php if (isset($_SESSION['user'])): ?>
                    <span class="nav-welcome">Bonjour, <?php echo htmlspecialchars($_SESSION['user']['username']); ?></span>
                    <a href="<?php echo BASE_URL; ?>/tasks" class="nav-link">Mes Tâches</a>
                    <a href="<?php echo BASE_URL; ?>/profile" class="nav-link">Profil</a>
                    <a href="<?php echo BASE_URL; ?>/auth/logout" class="nav-link">Déconnexion</a>
                <?php else: ?>
                    <a href="<?php echo BASE_URL; ?>/auth/login" class="nav-link">Connexion</a>
                    <a href="<?php echo BASE_URL; ?>/auth/register" class="btn btn-outline">S'inscrire</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>