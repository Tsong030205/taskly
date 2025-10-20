<?php
function authRegister() {
    $pageTitle = "Inscription - " . APP_NAME;
    
    // Traitement du formulaire d'inscription
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        
        // Validation des données
        $errors = [];
        
        if (empty($username) || strlen($username) < 3) {
            $errors['username'] = 'Le nom d\'utilisateur doit contenir au moins 3 caractères';
        }
        
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Adresse email invalide';
        }
        
        if (empty($password) || strlen($password) < 6) {
            $errors['password'] = 'Le mot de passe doit contenir au moins 6 caractères';
        }
        
        if ($password !== $confirm_password) {
            $errors['confirm_password'] = 'Les mots de passe ne correspondent pas';
        }
        
        // Si pas d'erreurs, créer l'utilisateur
        if (empty($errors)) {
            require_once MODEL_PATH . 'UserModel.php';
            $result = createUser($username, $email, $password);
            
            if ($result['success']) {
                setFlashMessage('success', 'Compte créé avec succès ! Vous pouvez maintenant vous connecter.');
                redirect('/auth/login');
            } else {
                $errors['general'] = $result['message'];
            }
        }
    }
    
    $data = [
        'pageTitle' => $pageTitle,
        'errors' => $errors ?? [],
        'old' => $_POST ?? []
    ];
    
    loadView('auth/register', $data);
}

function authLogin() {
    $pageTitle = "Connexion - " . APP_NAME;
    
    // Traitement du formulaire de connexion
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        
        $errors = [];
        
        if (empty($email) || empty($password)) {
            $errors['general'] = 'Veuillez remplir tous les champs';
        }
        
        if (empty($errors)) {
            require_once MODEL_PATH . 'UserModel.php';
            $result = verifyUser($email, $password);
            
            if ($result['success']) {
                // Connexion réussie
                $_SESSION['user'] = $result['user'];
                setFlashMessage('success', 'Connexion réussie ! Bienvenue ' . $result['user']['username']);
                redirect('/');
            } else {
                $errors['general'] = $result['message'];
            }
        }
    }
    
    $data = [
        'pageTitle' => $pageTitle,
        'errors' => $errors ?? [],
        'old' => $_POST ?? []
    ];
    
    loadView('auth/login', $data);
}

function authLogout() {
    session_destroy();
    setFlashMessage('success', 'Vous avez été déconnecté avec succès.');
    redirect('/');
}
?>