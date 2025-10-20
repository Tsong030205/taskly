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
                <h1>Modifier la Tâche</h1>
                <a href="<?php echo BASE_URL; ?>/tasks" class="btn btn-secondary">Retour</a>
            </div>
            
            <div class="form-container">
                <form method="POST" action="<?php echo BASE_URL; ?>/tasks/update/<?php echo $task['id']; ?>" class="task-form">
                    <?php if (isset($errors['general'])): ?>
                        <div class="alert alert-error">
                            <?php echo $errors['general']; ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="form-group">
                        <label for="title" class="form-label">Titre *</label>
                        <input 
                            type="text" 
                            id="title" 
                            name="title" 
                            class="form-input <?php echo isset($errors['title']) ? 'error' : ''; ?>" 
                            value="<?php echo htmlspecialchars($task['title']); ?>"
                            required
                        >
                        <?php if (isset($errors['title'])): ?>
                            <span class="error-message"><?php echo $errors['title']; ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="description" class="form-label">Description</label>
                        <textarea 
                            id="description" 
                            name="description" 
                            class="form-textarea <?php echo isset($errors['description']) ? 'error' : ''; ?>" 
                            rows="4"
                        ><?php echo htmlspecialchars($task['description']); ?></textarea>
                        <?php if (isset($errors['description'])): ?>
                            <span class="error-message"><?php echo $errors['description']; ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="due_date" class="form-label">Date d'échéance *</label>
                            <input 
                                type="date" 
                                id="due_date" 
                                name="due_date" 
                                class="form-input <?php echo isset($errors['due_date']) ? 'error' : ''; ?>" 
                                value="<?php echo htmlspecialchars($task['due_date']); ?>"
                                required
                            >
                            <?php if (isset($errors['due_date'])): ?>
                                <span class="error-message"><?php echo $errors['due_date']; ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="form-group">
                            <label for="priority" class="form-label">Priorité</label>
                            <select 
                                id="priority" 
                                name="priority" 
                                class="form-select <?php echo isset($errors['priority']) ? 'error' : ''; ?>"
                            >
                                <option value="low" <?php echo $task['priority'] === 'low' ? 'selected' : ''; ?>>Basse</option>
                                <option value="medium" <?php echo $task['priority'] === 'medium' ? 'selected' : ''; ?>>Moyenne</option>
                                <option value="high" <?php echo $task['priority'] === 'high' ? 'selected' : ''; ?>>Haute</option>
                            </select>
                            <?php if (isset($errors['priority'])): ?>
                                <span class="error-message"><?php echo $errors['priority']; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        <a href="<?php echo BASE_URL; ?>/tasks" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php include VIEW_PATH . 'partials/footer.php'; ?>
</body>
</html>