<?php
function taskIndex() {
    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['user'])) {
        setFlashMessage('error', 'Vous devez être connecté pour accéder à cette page.');
        redirect('/auth/login');
    }
    
    $pageTitle = "Mes Tâches - " . APP_NAME;
    $userId = $_SESSION['user']['id'];
    
    // Récupérer les filtres
    $filters = [
        'status' => $_GET['status'] ?? null,
        'sort' => $_GET['sort'] ?? 'due_date',
        'order' => $_GET['order'] ?? 'ASC'
    ];
    
    require_once MODEL_PATH . 'TaskModel.php';
    $tasks = getTasksByUserId($userId, $filters);
    $stats = getTasksStats($userId);
    
    $data = [
        'pageTitle' => $pageTitle,
        'tasks' => $tasks,
        'stats' => $stats,
        'filters' => $filters,
        'flashMessage' => getFlashMessage()
    ];
    
    loadView('tasks/index', $data);
}

function taskCreate() {
    if (!isset($_SESSION['user'])) {
        setFlashMessage('error', 'Vous devez être connecté pour accéder à cette page.');
        redirect('/auth/login');
    }
    
    $pageTitle = "Nouvelle Tâche - " . APP_NAME;
    
    $data = [
        'pageTitle' => $pageTitle,
        'errors' => [],
        'old' => []
    ];
    
    loadView('tasks/create', $data);
}

function taskStore() {
    if (!isset($_SESSION['user']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirect('/tasks');
    }
    
    $userId = $_SESSION['user']['id'];
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $dueDate = $_POST['due_date'] ?? '';
    $priority = $_POST['priority'] ?? 'medium';
    
    $errors = [];
    
    if (empty($title)) {
        $errors['title'] = 'Le titre est obligatoire';
    }
    
    if (empty($dueDate)) {
        $errors['due_date'] = 'La date d\'échéance est obligatoire';
    } elseif (strtotime($dueDate) < strtotime('today')) {
        $errors['due_date'] = 'La date d\'échéance ne peut pas être dans le passé';
    }
    
    if (empty($errors)) {
        require_once MODEL_PATH . 'TaskModel.php';
        $result = createTask($userId, $title, $description, $dueDate, $priority);
        
        if ($result['success']) {
            setFlashMessage('success', 'Tâche créée avec succès !');
            redirect('/tasks');
        } else {
            $errors['general'] = $result['message'];
        }
    }
    
    // Si erreur, réafficher le formulaire avec les erreurs
    $pageTitle = "Nouvelle Tâche - " . APP_NAME;
    $data = [
        'pageTitle' => $pageTitle,
        'errors' => $errors,
        'old' => $_POST
    ];
    
    loadView('tasks/create', $data);
}

function taskEdit($taskId) {
    if (!isset($_SESSION['user']) || !$taskId) {
        redirect('/tasks');
    }
    
    $userId = $_SESSION['user']['id'];
    require_once MODEL_PATH . 'TaskModel.php';
    $task = getTaskById($taskId, $userId);
    
    if (!$task) {
        setFlashMessage('error', 'Tâche non trouvée.');
        redirect('/tasks');
    }
    
    $pageTitle = "Modifier la Tâche - " . APP_NAME;
    $data = [
        'pageTitle' => $pageTitle,
        'task' => $task,
        'errors' => []
    ];
    
    loadView('tasks/edit', $data);
}

function taskUpdate($taskId) {
    if (!isset($_SESSION['user']) || !$taskId || $_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirect('/tasks');
    }
    
    $userId = $_SESSION['user']['id'];
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $dueDate = $_POST['due_date'] ?? '';
    $priority = $_POST['priority'] ?? 'medium';
    
    $errors = [];
    
    if (empty($title)) {
        $errors['title'] = 'Le titre est obligatoire';
    }
    
    if (empty($dueDate)) {
        $errors['due_date'] = 'La date d\'échéance est obligatoire';
    } elseif (strtotime($dueDate) < strtotime('today')) {
        $errors['due_date'] = 'La date d\'échéance ne peut pas être dans le passé';
    }
    
    if (empty($errors)) {
        require_once MODEL_PATH . 'TaskModel.php';
        $result = updateTask($taskId, $userId, $title, $description, $dueDate, $priority);
        
        if ($result['success']) {
            setFlashMessage('success', 'Tâche mise à jour avec succès !');
            redirect('/tasks');
        } else {
            $errors['general'] = $result['message'];
        }
    }
    
    // Si erreur, réafficher le formulaire avec les erreurs
    $pageTitle = "Modifier la Tâche - " . APP_NAME;
    $data = [
        'pageTitle' => $pageTitle,
        'errors' => $errors,
        'task' => [
            'id' => $taskId,
            'title' => $title,
            'description' => $description,
            'due_date' => $dueDate,
            'priority' => $priority
        ]
    ];
    
    loadView('tasks/edit', $data);
}

function taskDelete($taskId) {
    if (!isset($_SESSION['user']) || !$taskId) {
        redirect('/tasks');
    }
    
    $userId = $_SESSION['user']['id'];
    require_once MODEL_PATH . 'TaskModel.php';
    $result = deleteTask($taskId, $userId);
    
    if ($result['success']) {
        setFlashMessage('success', 'Tâche supprimée avec succès !');
    } else {
        setFlashMessage('error', $result['message']);
    }
    
    redirect('/tasks');
}

function taskToggle($taskId) {
    if (!isset($_SESSION['user']) || !$taskId) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Non autorisé']);
        return;
    }
    
    $userId = $_SESSION['user']['id'];
    require_once MODEL_PATH . 'TaskModel.php';
    $result = toggleTask($taskId, $userId);
    
    if ($result['success']) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $result['message']]);
    }
}
?>