<div class="task-card <?php echo $task['is_completed'] ? 'completed' : ''; ?>">
    <div class="task-header">
        <h3><?php echo htmlspecialchars($task['title']); ?></h3>
        <div class="task-actions">
            <button class="btn-toggle" data-task-id="<?php echo $task['id']; ?>">
                <?php echo $task['is_completed'] ? '✓' : '○'; ?>
            </button>
            <a href="<?php echo BASE_URL; ?>/tasks/edit/<?php echo $task['id']; ?>" class="btn-edit">✏️</a>
            <a href="<?php echo BASE_URL; ?>/tasks/delete/<?php echo $task['id']; ?>" class="btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?')">🗑️</a>
        </div>
    </div>
    
    <?php if (!empty($task['description'])): ?>
        <p class="task-description"><?php echo htmlspecialchars($task['description']); ?></p>
    <?php endif; ?>
    
    <div class="task-footer">
        <div class="task-meta">
            <span class="due-date">📅 <?php echo date('d/m/Y', strtotime($task['due_date'])); ?></span>
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
        <div class="task-date">
            <small>Créé le <?php echo date('d/m/Y', strtotime($task['created_at'])); ?></small>
        </div>
    </div>
</div>