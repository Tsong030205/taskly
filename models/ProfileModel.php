<?php
function updateUserProfile($userId, $username, $email) {
    $pdo = db_connect();
    
    try {
        // Vérifier si l'email ou le username existe déjà pour un autre utilisateur
        $stmt = $pdo->prepare("SELECT id FROM users WHERE (email = ? OR username = ?) AND id != ?");
        $stmt->execute([$email, $username, $userId]);
        
        if ($stmt->fetch()) {
            return ['success' => false, 'message' => 'Email ou nom d\'utilisateur déjà utilisé'];
        }
        
        // Mettre à jour le profil
        $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
        $stmt->execute([$username, $email, $userId]);
        
        return ['success' => true];
        
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Erreur lors de la mise à jour du profil: ' . $e->getMessage()];
    }
}

function updateUserPassword($userId, $currentPassword, $newPassword) {
    $pdo = db_connect();
    
    try {
        // Récupérer le mot de passe actuel
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();
        
        if (!$user || !password_verify($currentPassword, $user['password'])) {
            return ['success' => false, 'message' => 'Mot de passe actuel incorrect'];
        }
        
        // Hasher le nouveau mot de passe
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        // Mettre à jour le mot de passe
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$hashedPassword, $userId]);
        
        return ['success' => true];
        
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Erreur lors du changement de mot de passe: ' . $e->getMessage()];
    }
}

function getUserStats($userId) {
    $pdo = db_connect();
    
    try {
        // Statistiques avancées
        $stmt = $pdo->prepare("
            SELECT 
                COUNT(*) as total_tasks,
                SUM(is_completed) as completed_tasks,
                COUNT(*) - SUM(is_completed) as pending_tasks,
                AVG(is_completed) as completion_rate,
                COUNT(CASE WHEN due_date < CURDATE() AND is_completed = 0 THEN 1 END) as overdue_tasks,
                COUNT(CASE WHEN priority = 'high' THEN 1 END) as high_priority_tasks,
                MIN(created_at) as first_task_date
            FROM tasks 
            WHERE user_id = ?
        ");
        $stmt->execute([$userId]);
        $stats = $stmt->fetch();
        
        // Tâches récentes
        $stmt = $pdo->prepare("
            SELECT title, due_date, is_completed, priority 
            FROM tasks 
            WHERE user_id = ? 
            ORDER BY created_at DESC 
            LIMIT 5
        ");
        $stmt->execute([$userId]);
        $recent_tasks = $stmt->fetchAll();
        
        return [
            'stats' => $stats,
            'recent_tasks' => $recent_tasks
        ];
        
    } catch (PDOException $e) {
        return [
            'stats' => [
                'total_tasks' => 0,
                'completed_tasks' => 0,
                'pending_tasks' => 0,
                'completion_rate' => 0,
                'overdue_tasks' => 0,
                'high_priority_tasks' => 0
            ],
            'recent_tasks' => []
        ];
    }
}
?>