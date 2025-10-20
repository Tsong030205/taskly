<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include VIEW_PATH . 'partials/header.php'; ?>
    
    <main class="main-content">
        <div class="container">
            <div class="page-header">
                <h1>Mon Profil</h1>
                <a href="<?php echo BASE_URL; ?>/tasks" class="btn btn-secondary">Retour aux tâches</a>
            </div>
            
            <?php include VIEW_PATH . 'partials/flash-messages.php'; ?>
            
            <div class="profile-layout">
                <!-- Section Statistiques -->
                <div class="profile-section">
                    <h2>📊 Mes Statistiques</h2>
                    <div class="stats-grid detailed">
                        <div class="stat-card">
                            <div class="stat-number"><?php echo $stats['total_tasks']; ?></div>
                            <div class="stat-label">Tâches totales</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number"><?php echo $stats['completed_tasks']; ?></div>
                            <div class="stat-label">Terminées</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number"><?php echo $stats['pending_tasks']; ?></div>
                            <div class="stat-label">En attente</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number"><?php echo $stats['overdue_tasks']; ?></div>
                            <div class="stat-label">En retard</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number"><?php echo $stats['high_priority_tasks']; ?></div>
                            <div class="stat-label">Priorité haute</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number"><?php echo round(($stats['completion_rate'] ?? 0) * 100, 1); ?>%</div>
                            <div class="stat-label">Taux de complétion</div>
                        </div>
                    </div>
                </div>
                
                <!-- Section Informations personnelles -->
                <div class="profile-section">
                    <h2>👤 Informations personnelles</h2>
                    <form method="POST" action="<?php echo BASE_URL; ?>/profile/update" class="profile-form">
                        <?php if (isset($errors['general'])): ?>
                            <div class="alert alert-error">
                                <?php echo $errors['general']; ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="username" class="form-label">Nom d'utilisateur</label>
                                <input 
                                    type="text" 
                                    id="username" 
                                    name="username" 
                                    class="form-input <?php echo isset($errors['username']) ? 'error' : ''; ?>" 
                                    value="<?php echo htmlspecialchars($user['username']); ?>"
                                    required
                                >
                                <?php if (isset($errors['username'])): ?>
                                    <span class="error-message"><?php echo $errors['username']; ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="form-group">
                                <label for="email" class="form-label">Adresse email</label>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    class="form-input <?php echo isset($errors['email']) ? 'error' : ''; ?>" 
                                    value="<?php echo htmlspecialchars($user['email']); ?>"
                                    required
                                >
                                <?php if (isset($errors['email'])): ?>
                                    <span class="error-message"><?php echo $errors['email']; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Mettre à jour le profil</button>
                        </div>
                    </form>
                </div>
                
                <!-- Section Changement de mot de passe -->
                <div class="profile-section">
                    <h2>🔒 Changer le mot de passe</h2>
                    <form method="POST" action="<?php echo BASE_URL; ?>/profile/update-password" class="profile-form">
                        <?php if (isset($password_errors['general'])): ?>
                            <div class="alert alert-error">
                                <?php echo $password_errors['general']; ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="form-group">
                            <label for="current_password" class="form-label">Mot de passe actuel</label>
                            <input 
                                type="password" 
                                id="current_password" 
                                name="current_password" 
                                class="form-input <?php echo isset($password_errors['current_password']) ? 'error' : ''; ?>" 
                                required
                            >
                            <?php if (isset($password_errors['current_password'])): ?>
                                <span class="error-message"><?php echo $password_errors['current_password']; ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="new_password" class="form-label">Nouveau mot de passe</label>
                                <input 
                                    type="password" 
                                    id="new_password" 
                                    name="new_password" 
                                    class="form-input <?php echo isset($password_errors['new_password']) ? 'error' : ''; ?>" 
                                    required
                                >
                                <?php if (isset($password_errors['new_password'])): ?>
                                    <span class="error-message"><?php echo $password_errors['new_password']; ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="form-group">
                                <label for="confirm_password" class="form-label">Confirmer le nouveau mot de passe</label>
                                <input 
                                    type="password" 
                                    id="confirm_password" 
                                    name="confirm_password" 
                                    class="form-input <?php echo isset($password_errors['confirm_password']) ? 'error' : ''; ?>" 
                                    required
                                >
                                <?php if (isset($password_errors['confirm_password'])): ?>
                                    <span class="error-message"><?php echo $password_errors['confirm_password']; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Changer le mot de passe</button>
                        </div>
                    </form>
                </div>
                
                <!-- Section Tâches récentes -->
                <?php if (!empty($recent_tasks)): ?>
                <div class="profile-section">
                    <h2>📝 Tâches récentes</h2>
                    <div class="recent-tasks">
                        <?php foreach ($recent_tasks as $task): ?>
                            <div class="recent-task-item <?php echo $task['is_completed'] ? 'completed' : ''; ?>">
                                <div class="recent-task-title">
                                    <?php echo htmlspecialchars($task['title']); ?>
                                    <span class="priority-badge priority-<?php echo $task['priority']; ?>">
                                        <?php 
                                        $priorityLabels = [
                                            'low' => 'Basse',
                                            'medium' => 'Moyenne',
                                            'high' => 'Haute'
                                        ];
                                        echo $priorityLabels[$task['priority']]; 
                                        ?>
                                    </span>
                                </div>
                                <div class="recent-task-meta">
                                    <span class="due-date">📅 <?php echo date('d/m/Y', strtotime($task['due_date'])); ?></span>
                                    <span class="status <?php echo $task['is_completed'] ? 'completed' : 'pending'; ?>">
                                        <?php echo $task['is_completed'] ? '✓ Terminée' : '⏳ En cours'; ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php include VIEW_PATH . 'partials/footer.php'; ?>
</body>
</html>