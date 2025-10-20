<?php
function profileIndex() {
    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['user'])) {
        setFlashMessage('error', 'Vous devez être connecté pour accéder à cette page.');
        redirect('/auth/login');
    }
    
    $pageTitle = "Mon Profil - " . APP_NAME;
    $userId = $_SESSION['user']['id'];
    
    require_once MODEL_PATH . 'ProfileModel.php';
    $userData = getUserStats($userId);
    
    $data = [
        'pageTitle' => $pageTitle,
        'user' => $_SESSION['user'],
        'stats' => $userData['stats'],
        'recent_tasks' => $userData['recent_tasks'],
        'flashMessage' => getFlashMessage()
    ];
    
    loadView('profile/index', $data);
}

function profileUpdate() {
    if (!isset($_SESSION['user']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirect('/profile');
    }
    
    $userId = $_SESSION['user']['id'];
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    
    $errors = [];
    
    if (empty($username) || strlen($username) < 3) {
        $errors['username'] = 'Le nom d\'utilisateur doit contenir au moins 3 caractères';
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Adresse email invalide';
    }
    
    if (empty($errors)) {
        require_once MODEL_PATH . 'ProfileModel.php';
        $result = updateUserProfile($userId, $username, $email);
        
        if ($result['success']) {
            // Mettre à jour les informations dans la session
            $_SESSION['user']['username'] = $username;
            $_SESSION['user']['email'] = $email;
            
            setFlashMessage('success', 'Profil mis à jour avec succès !');
        } else {
            $errors['general'] = $result['message'];
        }
    }
    
    // Si erreur, réafficher la page avec les erreurs
    if (!empty($errors)) {
        require_once MODEL_PATH . 'ProfileModel.php';
        $userData = getUserStats($userId);
        
        $data = [
            'pageTitle' => "Mon Profil - " . APP_NAME,
            'user' => $_SESSION['user'],
            'stats' => $userData['stats'],
            'recent_tasks' => $userData['recent_tasks'],
            'errors' => $errors,
            'flashMessage' => getFlashMessage()
        ];
        
        loadView('profile/index', $data);
        return;
    }
    
    redirect('/profile');
}

function profileUpdatePassword() {
    if (!isset($_SESSION['user']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirect('/profile');
    }
    
    $userId = $_SESSION['user']['id'];
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    $errors = [];
    
    if (empty($currentPassword)) {
        $errors['current_password'] = 'Le mot de passe actuel est obligatoire';
    }
    
    if (empty($newPassword) || strlen($newPassword) < 6) {
        $errors['new_password'] = 'Le nouveau mot de passe doit contenir au moins 6 caractères';
    }
    
    if ($newPassword !== $confirmPassword) {
        $errors['confirm_password'] = 'Les mots de passe ne correspondent pas';
    }
    
    if (empty($errors)) {
        require_once MODEL_PATH . 'ProfileModel.php';
        $result = updateUserPassword($userId, $currentPassword, $newPassword);
        
        if ($result['success']) {
            setFlashMessage('success', 'Mot de passe mis à jour avec succès !');
        } else {
            $errors['general'] = $result['message'];
        }
    }
    
    // Si erreur, réafficher la page avec les erreurs
    if (!empty($errors)) {
        require_once MODEL_PATH . 'ProfileModel.php';
        $userData = getUserStats($userId);
        
        $data = [
            'pageTitle' => "Mon Profil - " . APP_NAME,
            'user' => $_SESSION['user'],
            'stats' => $userData['stats'],
            'recent_tasks' => $userData['recent_tasks'],
            'password_errors' => $errors,
            'flashMessage' => getFlashMessage()
        ];
        
        loadView('profile/index', $data);
        return;
    }
    
    redirect('/profile');
}
?>