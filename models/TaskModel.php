<?php
function getTasksByUserId($userId, $filters = []) {
    $pdo = db_connect();
    
    $sql = "SELECT * FROM tasks WHERE user_id = ?";
    $params = [$userId];
    
    // Gestion des filtres
    if (isset($filters['status'])) {
        if ($filters['status'] === 'completed') {
            $sql .= " AND is_completed = 1";
        } elseif ($filters['status'] === 'active') {
            $sql .= " AND is_completed = 0";
        }
    }
    
    // Gestion du tri
    $sort = $filters['sort'] ?? 'due_date';
    $order = $filters['order'] ?? 'ASC';
    
    $allowedSort = ['due_date', 'priority', 'created_at', 'title'];
    $allowedOrder = ['ASC', 'DESC'];
    
    if (in_array($sort, $allowedSort) && in_array($order, $allowedOrder)) {
        $sql .= " ORDER BY $sort $order";
    } else {
        $sql .= " ORDER BY due_date ASC";
    }
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}

function getTaskById($taskId, $userId) {
    $pdo = db_connect();
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
        $stmt->execute([$taskId, $userId]);
        return $stmt->fetch();
    } catch (PDOException $e) {
        return null;
    }
}

function createTask($userId, $title, $description, $dueDate, $priority) {
    $pdo = db_connect();
    
    try {
        $stmt = $pdo->prepare("INSERT INTO tasks (user_id, title, description, due_date, priority) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$userId, $title, $description, $dueDate, $priority]);
        return ['success' => true, 'task_id' => $pdo->lastInsertId()];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Erreur lors de la création de la tâche: ' . $e->getMessage()];
    }
}

function updateTask($taskId, $userId, $title, $description, $dueDate, $priority) {
    $pdo = db_connect();
    
    try {
        $stmt = $pdo->prepare("UPDATE tasks SET title = ?, description = ?, due_date = ?, priority = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ? AND user_id = ?");
        $stmt->execute([$title, $description, $dueDate, $priority, $taskId, $userId]);
        return ['success' => true];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Erreur lors de la mise à jour de la tâche: ' . $e->getMessage()];
    }
}

function deleteTask($taskId, $userId) {
    $pdo = db_connect();
    
    try {
        $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
        $stmt->execute([$taskId, $userId]);
        return ['success' => true];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Erreur lors de la suppression de la tâche: ' . $e->getMessage()];
    }
}

function toggleTask($taskId, $userId) {
    $pdo = db_connect();
    
    try {
        $stmt = $pdo->prepare("UPDATE tasks SET is_completed = NOT is_completed, updated_at = CURRENT_TIMESTAMP WHERE id = ? AND user_id = ?");
        $stmt->execute([$taskId, $userId]);
        return ['success' => true];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Erreur lors du changement de statut: ' . $e->getMessage()];
    }
}

function getTasksStats($userId) {
    $pdo = db_connect();
    
    try {
        $stmt = $pdo->prepare("
            SELECT 
                COUNT(*) as total,
                SUM(is_completed) as completed,
                COUNT(*) - SUM(is_completed) as active
            FROM tasks 
            WHERE user_id = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetch();
    } catch (PDOException $e) {
        return ['total' => 0, 'completed' => 0, 'active' => 0];
    }
}
?>