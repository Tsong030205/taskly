<?php
// Charger la configuration
require_once 'config/config.php';
require_once 'config/database.php';

// Gestion des erreurs
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    error_log("Erreur PHP [$errno]: $errstr dans $errfile à la ligne $errline");
    
    if (DEBUG_MODE) {
        echo "<div style='background: #fee; border: 1px solid #fcc; padding: 10px; margin: 10px;'>";
        echo "<strong>Erreur:</strong> $errstr<br>";
        echo "<strong>Fichier:</strong> $errfile<br>";
        echo "<strong>Ligne:</strong> $errline";
        echo "</div>";
    } else {
        http_response_code(500);
        loadView('errors/500');
        exit;
    }
});

// Router simple
$url = $_GET['url'] ?? 'home';
$url = rtrim($url, '/');
$urlParts = explode('/', $url);

// Déterminer le contrôleur et l'action
$controllerName = $urlParts[0] ?? 'home';
$action = $urlParts[1] ?? 'index';

try {
    // Routeur simple
    switch ($controllerName) {
        case 'home':
            require_once CONTROLLER_PATH . 'HomeController.php';
            homeIndex();
            break;
        case 'auth':
            require_once CONTROLLER_PATH . 'AuthController.php';
            if ($action === 'login') {
                authLogin();
            } elseif ($action === 'register') {
                authRegister();
            } elseif ($action === 'logout') {
                authLogout();
            } else {
                redirect('/auth/login');
            }
            break;
        case 'tasks':
            require_once CONTROLLER_PATH . 'TaskController.php';
            if ($action === 'index' || $action === '') {
                taskIndex();
            } elseif ($action === 'create') {
                taskCreate();
            } elseif ($action === 'store') {
                taskStore();
            } elseif ($action === 'edit') {
                taskEdit($urlParts[2] ?? null);
            } elseif ($action === 'update') {
                taskUpdate($urlParts[2] ?? null);
            } elseif ($action === 'delete') {
                taskDelete($urlParts[2] || null);
            } elseif ($action === 'toggle') {
                taskToggle($urlParts[2] ?? null);
            } else {
                redirect('/tasks');
            }
            break;
        case 'profile':
            require_once CONTROLLER_PATH . 'ProfileController.php';
            if ($action === 'index' || $action === '') {
                profileIndex();
            } elseif ($action === 'update') {
                profileUpdate();
            } elseif ($action === 'update-password') {
                profileUpdatePassword();
            } else {
                redirect('/profile');
            }
            break;
        default:
            // Page 404
            http_response_code(404);
            loadView('errors/404');
            break;
    }
} catch (Exception $e) {
    error_log("Erreur: " . $e->getMessage());
    
    if (DEBUG_MODE) {
        echo "<div style='background: #fee; border: 1px solid #fcc; padding: 10px; margin: 10px;'>";
        echo "<strong>Exception:</strong> " . $e->getMessage() . "<br>";
        echo "<strong>Fichier:</strong> " . $e->getFile() . "<br>";
        echo "<strong>Ligne:</strong> " . $e->getLine() . "<br>";
        echo "<strong>Trace:</strong><pre>" . $e->getTraceAsString() . "</pre>";
        echo "</div>";
    } else {
        http_response_code(500);
        loadView('errors/500');
    }
}
?>