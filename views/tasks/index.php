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
                <h1>Mes Tâches</h1>
                <a href="<?php echo BASE_URL; ?>/tasks/create" class="btn btn-primary">Nouvelle Tâche</a>
            </div>
            
            <?php include VIEW_PATH . 'partials/flash-messages.php'; ?>
            
            <!-- Statistiques -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number"><?php echo $stats['total']; ?></div>
                    <div class="stat-label">Total</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $stats['active']; ?></div>
                    <div class="stat-label">En cours</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $stats['completed']; ?></div>
                    <div class="stat-label">Terminées</div>
                </div>
            </div>
            
            <!-- Filtres et tri -->
            <div class="tasks-filters">
                <div class="filters-group">
                    <span>Filtrer par :</span>
                    <a href="<?php echo BASE_URL; ?>/tasks?status=active" class="filter-btn <?php echo ($filters['status'] ?? '') === 'active' ? 'active' : ''; ?>">En cours</a>
                    <a href="<?php echo BASE_URL; ?>/tasks?status=completed" class="filter-btn <?php echo ($filters['status'] ?? '') === 'completed' ? 'active' : ''; ?>">Terminées</a>
                    <a href="<?php echo BASE_URL; ?>/tasks" class="filter-btn <?php echo empty($filters['status']) ? 'active' : ''; ?>">Toutes</a>
                </div>
                
                <div class="sort-group">
                    <span>Trier par :</span>
                    <select id="sortSelect" onchange="window.location.href=this.value">
                        <option value="<?php echo BASE_URL; ?>/tasks?sort=due_date&order=ASC" <?php echo ($filters['sort'] ?? 'due_date') === 'due_date' && ($filters['order'] ?? 'ASC') === 'ASC' ? 'selected' : ''; ?>>Date échéance (croissant)</option>
                        <option value="<?php echo BASE_URL; ?>/tasks?sort=due_date&order=DESC" <?php echo ($filters['sort'] ?? 'due_date') === 'due_date' && ($filters['order'] ?? 'ASC') === 'DESC' ? 'selected' : ''; ?>>Date échéance (décroissant)</option>
                        <option value="<?php echo BASE_URL; ?>/tasks?sort=priority&order=DESC" <?php echo ($filters['sort'] ?? 'due_date') === 'priority' && ($filters['order'] ?? 'ASC') === 'DESC' ? 'selected' : ''; ?>>Priorité (haute à basse)</option>
                        <option value="<?php echo BASE_URL; ?>/tasks?sort=priority&order=ASC" <?php echo ($filters['sort'] ?? 'due_date') === 'priority' && ($filters['order'] ?? 'ASC') === 'ASC' ? 'selected' : ''; ?>>Priorité (basse à haute)</option>
                    </select>
                </div>
            </div>
            
            <!-- Liste des tâches -->
            <div class="tasks-grid">
                <?php if (empty($tasks)): ?>
                    <div class="empty-state">
                        <h3>Aucune tâche trouvée</h3>
                        <p>Commencez par créer une nouvelle tâche.</p>
                        <a href="<?php echo BASE_URL; ?>/tasks/create" class="btn btn-primary">Créer une tâche</a>
                    </div>
                <?php else: ?>
                    <?php foreach ($tasks as $task): ?>
                        <?php include VIEW_PATH . 'partials/task-card.php'; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php include VIEW_PATH . 'partials/footer.php'; ?>
    
    <script>
        // JavaScript pour basculer l'état de la tâche
        document.querySelectorAll('.btn-toggle').forEach(button => {
            button.addEventListener('click', function() {
                const taskId = this.getAttribute('data-task-id');
                const taskCard = this.closest('.task-card');
                
                fetch(`<?php echo BASE_URL; ?>/tasks/toggle/${taskId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        taskCard.classList.toggle('completed');
                        this.textContent = taskCard.classList.contains('completed') ? '✓' : '○';
                    } else {
                        alert('Erreur lors de la mise à jour');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Erreur lors de la mise à jour');
                });
            });
        });
    </script>
</body>
</html>