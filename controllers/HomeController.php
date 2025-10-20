<?php
function homeIndex() {
    $pageTitle = "Accueil - " . APP_NAME;
    $user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
    
    $data = [
        'pageTitle' => $pageTitle,
        'user' => $user,
        'flashMessage' => getFlashMessage()
    ];
    
    loadView('home', $data);
}
?>