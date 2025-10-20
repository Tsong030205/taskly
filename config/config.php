<?php
// Configuration de l'application
define('APP_NAME', 'Taskly');
define('APP_VERSION', '1.0.0');
define('BASE_URL', 'http://localhost/taskly');
define('DEBUG_MODE', true); // Mettre à false en production

// Configuration des chemins
define('ROOT_PATH', __DIR__ . '/../');
define('CONTROLLER_PATH', ROOT_PATH . 'controllers/');
define('MODEL_PATH', ROOT_PATH . 'models/');
define('VIEW_PATH', ROOT_PATH . 'views/');
define('ASSETS_PATH', BASE_URL . '/assets');

// Démarrer la session
session_start();

// Fonction pour charger les vues
function loadView($view, $data = []) {
    extract($data);
    require VIEW_PATH . $view . '.php';
}

// Fonction pour rediriger
function redirect($url) {
    header("Location: " . BASE_URL . $url);
    exit;
}

// Fonction pour afficher les messages flash
function setFlashMessage($type, $message) {
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message
    ];
}

function getFlashMessage() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

// Fonction de sécurisation des données
function sanitize($data) {
    if (is_array($data)) {
        return array_map('sanitize', $data);
    }
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Vérifier si l'utilisateur est connecté
function isLoggedIn() {
    return isset($_SESSION['user']);
}

// Vérifier si l'utilisateur est propriétaire de la tâche
function isTaskOwner($taskId) {
    if (!isLoggedIn()) return false;
    
    require_once MODEL_PATH . 'TaskModel.php';
    $task = getTaskById($taskId, $_SESSION['user']['id']);
    return $task !== null;
}
?>