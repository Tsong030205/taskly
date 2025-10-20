<?php
function createUser($username, $email, $password) {
    $pdo = db_connect();
    
    try {
        // Vérifier si l'email existe déjà
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
        $stmt->execute([$email, $username]);
        
        if ($stmt->fetch()) {
            return ['success' => false, 'message' => 'Email ou nom d\'utilisateur déjà utilisé'];
        }
        
        // Hasher le mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Insérer le nouvel utilisateur
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashedPassword]);
        
        return ['success' => true, 'user_id' => $pdo->lastInsertId()];
        
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Erreur lors de la création du compte: ' . $e->getMessage()];
    }
}

function verifyUser($email, $password) {
    $pdo = db_connect();
    
    try {
        $stmt = $pdo->prepare("SELECT id, username, email, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            // Retourner les infos utilisateur sans le mot de passe
            unset($user['password']);
            return ['success' => true, 'user' => $user];
        }
        
        return ['success' => false, 'message' => 'Email ou mot de passe incorrect'];
        
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Erreur de connexion: ' . $e->getMessage()];
    }
}

function getUserById($userId) {
    $pdo = db_connect();
    
    try {
        $stmt = $pdo->prepare("SELECT id, username, email, created_at FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch();
        
    } catch (PDOException $e) {
        return null;
    }
}
?>