<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: /admin/admin_login.php');
    exit;
}

// Обработка удаления темы
if (isset($_GET['delete_topic'])) {
    $topicNum = (int)$_GET['delete_topic'];
    
    // Удаляем файл теории
    $theoryFile = "../language/ru/theory/topic{$topicNum}.php";
    if (file_exists($theoryFile)) {
        unlink($theoryFile);
    }
    
    // Удаляем файл задач (если есть)
    $taskFile = "../language/ru/tasks/topic{$topicNum}.php";
    if (file_exists($taskFile)) {
        unlink($taskFile);
    }
    
    // Удаляем связанные изображения
    $images = glob("../assets/images/topic{$topicNum}_*.*");
    foreach ($images as $image) {
        if (file_exists($image)) {
            unlink($image);
        }
    }
    
    // Обновляем список тем в index.php
    $theoryIndexFile = "../language/ru/theory/index.php";
    if (file_exists($theoryIndexFile)) {
        $content = file_get_contents($theoryIndexFile);
        
        // Удаляем тему из массива
        if (preg_match('/\$topics\s*=\s*\[([^\]]+)\]/s', $content, $matches)) {
            $topicsArray = explode("\n", trim($matches[1]));
            $newTopics = [];
            
            foreach ($topicsArray as $line) {
                if (!str_contains($line, "\"{$topicNum}\" =>") && !str_contains($line, "'{$topicNum}' =>")) {
                    $newTopics[] = $line;
                }
            }
            
            $content = str_replace(
                $matches[0], 
                '$topics = [' . "\n    " . implode("\n    ", $newTopics) . "\n];", 
                $content
            );
        }
        
        file_put_contents($theoryIndexFile, $content);
    }
    
    header("Location: create_topic.php?deleted={$topicNum}");
    exit;
}

// Обработка удаления задач
if (isset($_GET['delete_task'])) {
    $taskNum = (int)$_GET['delete_task'];
    $taskFile = "../language/ru/math_tasks/topic{$taskNum}.php";
    
    if (file_exists($taskFile)) unlink($taskFile);
    
    // Обновляем список задач в index.php
    $tasksIndexFile = "../language/ru/math_tasks/index.php";
    $content = file_get_contents($tasksIndexFile);
    
    // Удаляем задачу из массива $topics
    if (preg_match('/\$topics\s*=\s*\[([^\]]+)\]/s', $content, $matches)) {
        $topicsArray = explode("\n", trim($matches[1]));
        $newTopics = [];
        
        foreach ($topicsArray as $line) {
            if (!str_contains($line, "$taskNum =>")) {
                $newTopics[] = $line;
            }
        }
        
        $content = str_replace(
            $matches[0], 
            '$topics = [' . "\n    " . implode("\n    ", $newTopics) . "\n];", 
            $content
        );
    }
    
    // Удаляем задачу из массива $tasksCount
    if (preg_match('/\$tasksCount\s*=\s*\[([^\]]+)\]/s', $content, $matches)) {
        $tasksCountArray = explode("\n", trim($matches[1]));
        $newTasksCount = [];
        
        foreach ($tasksCountArray as $line) {
            if (!str_contains($line, "$taskNum =>")) {
                $newTasksCount[] = $line;
            }
        }
        
        $content = str_replace(
            $matches[0], 
            '$tasksCount = [' . "\n    " . implode("\n    ", $newTasksCount) . "\n];", 
            $content
        );
    }
    
    file_put_contents($tasksIndexFile, $content);
    
    header("Location: create_topic.php?deleted_task={$taskNum}");
    exit;
}

// список существующих тем
$theoryFiles = glob("../language/ru/theory/topic*.php");
$topicsList = [];

foreach ($theoryFiles as $file) {
    $num = (int)preg_replace('/[^0-9]/', '', basename($file));
    $content = file_get_contents($file);
    if (preg_match('/<title>(.*?)<\/title>/', $content, $matches)) {
        $title = str_replace(' - CyberMath', '', $matches[1]);
        $topicsList[$num] = [
            'title' => $title,
            'theory_file' => $file
        ];
    }
}

// список существующих задач
$taskFiles = glob("../language/ru/math_tasks/topic*.php");
$tasksList = [];

foreach ($taskFiles as $file) {
    $num = (int)preg_replace('/[^0-9]/', '', basename($file));
    $content = file_get_contents($file);
    if (preg_match('/<title>Задачи: (.*?) - CyberMath<\/title>/', $content, $matches)) {
        $title = $matches[1];
        $tasksList[$num] = [
            'title' => $title,
            'task_file' => $file,
            'task_count' => substr_count($content, "'question' =>")
        ];
    }
}

ksort($topicsList);
ksort($tasksList);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Создание новой темы - CyberMath</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .btn-outline-primary {
            --bs-btn-color: #00b894;
            --bs-btn-border-color: #00b894;
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: #00b894;
            --bs-btn-hover-border-color: #00b894;
            --bs-btn-focus-shadow-rgb: 13, 110, 253;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: #00b894;
            --bs-btn-active-border-color: #00b894;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: #00b894;
            --bs-btn-disabled-bg: transparent;
            --bs-btn-disabled-border-color: #00b894;
            --bs-gradient: none;
        }

        .btn-outline-secondary{
            --bs-btn-color: #6c5ce7;
            --bs-btn-border-color:rgb(124, 111, 224);
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: #6c5ce7;
            --bs-btn-hover-border-color: #6c5ce7;
            --bs-btn-focus-shadow-rgb: 108,117,125;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: #6c5ce7;
            --bs-btn-active-border-color: #6c5ce7;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: #6c5ce7;
            --bs-btn-disabled-bg: transparent;
            --bs-btn-disabled-border-color: #6c5ce7;
            --bs-gradient: none;
        }

        .form-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 20px;
        }
        .task-item {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }
        .topics-list {
            max-height: 500px;
            overflow-y: auto;
        }
        .topic-item {
            transition: all 0.2s;
        }
        .topic-item:hover {
            background-color: #f8f9fa;
        }
        .delete-topic {
            opacity: 0;
            transition: opacity 0.2s;
        }
        .topic-item:hover .delete-topic {
            opacity: 1;
        }
        .admin-nav {
            margin-bottom: 20px;
        }
        .nav-tabs .nav-link.active {
            font-weight: bold;
            border-bottom: 3px solid #6c5ce7;
        }
        .tab-content {
            padding: 20px 0;
        }
        .img-preview {
            max-width: 150px;
            max-height: 150px;
            margin-top: 10px;
            display: none;
            border-radius: 5px;
        }
    </style>
</head>
<body class="container py-5">
    <?php if (isset($_GET['deleted'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Тема №<?= htmlspecialchars($_GET['deleted']) ?> успешно удалена!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="admin-nav">
        <a href="dashboard.php" class="btn btn-outline-secondary bg-purple-600 me-2">← В админку</a>
        <a href="/cybermath.com/language/ru/theory/index.php" class="btn btn-outline-primary" target="_blank">
            Просмотр списка тем
        </a>
        <a href="/cybermath.com/language/ru/math_tasks/index.php" class="btn btn-outline-primary" target="_blank">
            Просмотр списка задач
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="form-container">
                <h1 class="text-center mb-4">📝 Создание новой темы</h1>
                
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="theory-tab" data-bs-toggle="tab" data-bs-target="#theory" type="button" role="tab" aria-controls="theory" aria-selected="true">
                            Теория и примеры
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tasks-tab" data-bs-toggle="tab" data-bs-target="#tasks" type="button" role="tab" aria-controls="tasks" aria-selected="false">
                            Математические задачи
                        </button>
                    </li>
                </ul>
                
                <!-- Вкладка "Теория и примеры" -->
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="theory" role="tabpanel" aria-labelledby="theory-tab">
                        <form method="POST" action="generate_topic.php" enctype="multipart/form-data">
                            <div class="mb-4">
                                <label class="form-label">Название темы:</label>
                                <input type="text" name="topic_name" class="form-control" required>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label">Подробная теория:</label>
                                <textarea name="theory_text" class="form-control" rows="8" required></textarea>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label">Изображение для теории (необязательно):</label>
                                <input type="file" name="theory_image" class="form-control" accept="image/*" id="theory-image-input">
                                <small class="text-muted">Максимальный размер: 2MB. Допустимые форматы: JPG, PNG, GIF</small>
                                <img id="theory-image-preview" class="img-preview">
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Задания:</label>
                                <div id="tasks-container" class="mb-3">
                                    
                                </div>
                                <button type="button" onclick="addTask()" class="btn btn-outline-primary">
                                    + Добавить задание
                                </button>
                            </div>
                            
                            <div class="text-center">
                                <button type="submit" class="btn btn-success px-4 py-2">
                                    Сгенерировать тему 🚀
                                </button>
                                <a href="dashboard.php" class="btn btn-secondary px-4 py-2">Отмена</a>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Вкладка "Математические задачи" -->
                    <div class="tab-pane fade" id="tasks" role="tabpanel" aria-labelledby="tasks-tab">
                        <form method="POST" action="generate_math_tasks.php" enctype="multipart/form-data">
                            <div class="mb-4">
                                <label class="form-label">Название темы задач:</label>
                                <input type="text" name="topic_name" class="form-control" required>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label">Количество задач:</label>
                                <input type="number" name="task_count" class="form-control" min="1" max="20" value="5" required id="task-count">
                            </div>
                            
                            <div id="math-tasks-container">
                                <!-- Здесь будут динамически добавляться формы для задач -->
                            </div>
                            
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary px-4 py-2">
                                    Сгенерировать задачи 🚀
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="dual-card-container">
                <div class="card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">📚 Список существующих тем</h5>
                        <span class="badge bg-light text-dark"><?= count($topicsList) ?></span>
                    </div>
                    <div class="card-body topics-list p-0">
                        <?php if (!empty($topicsList)): ?>
                            <div class="list-group list-group-flush">
                                <?php foreach ($topicsList as $num => $topic): ?>
                                    <div class="list-group-item topic-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <a href="/cybermath.com<?= str_replace('..', '', $topic['theory_file']) ?>" 
                                               target="_blank" 
                                               class="text-decoration-none">
                                                <span class="fw-bold">Тема <?= $num ?>:</span>
                                                <span><?= htmlspecialchars($topic['title']) ?></span>
                                            </a>
                                        </div>
                                        <div>
                                            <a href="?delete_topic=<?= $num ?>" 
                                               class="delete-topic btn btn-sm btn-outline-danger"
                                               onclick="return confirm('Вы уверены, что хотите удалить тему <?= $num ?>?')">
                                                Удалить
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="p-3 text-center text-muted">
                                Нет созданных тем
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">📝 Список существующих задач</h5>
                        <span class="badge bg-light text-dark"><?= count($tasksList) ?></span>
                    </div>
                    <div class="card-body topics-list p-0">
                        <?php if (!empty($tasksList)): ?>
                            <div class="list-group list-group-flush">
                                <?php foreach ($tasksList as $num => $task): ?>
                                    <div class="list-group-item topic-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <a href="/cybermath.com<?= str_replace('..', '', $task['task_file']) ?>" 
                                               target="_blank" 
                                               class="text-decoration-none">
                                                <span class="fw-bold">Задачи <?= $num ?>:</span>
                                                <span><?= htmlspecialchars($task['title']) ?></span>
                                                <span class="badge bg-info ms-2"><?= $task['task_count'] ?> задач</span>
                                            </a>
                                        </div>
                                        <div>
                                            <a href="?delete_task=<?= $num ?>" 
                                               class="delete-topic btn btn-sm btn-outline-danger"
                                               onclick="return confirm('Вы уверены, что хотите удалить задачи темы <?= $num ?>?')">
                                                Удалить
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="p-3 text-center text-muted">
                                Нет созданных задач
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Для теории и примеров
        function addTask() {
            const container = document.getElementById('tasks-container');
            const index = container.children.length;
            
            const taskDiv = document.createElement('div');
            taskDiv.className = 'task-item';
            taskDiv.innerHTML = `
                <h5>Задание ${index + 1}</h5>
                <div class="mb-3">
                    <label class="form-label">Вопрос:</label>
                    <input type="text" name="tasks[${index}][question]" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Изображение для задания (необязательно):</label>
                    <input type="file" name="tasks[${index}][image]" class="form-control" accept="image/*">
                    <img id="task-image-preview-${index}" class="img-preview">
                </div>
                <div class="mb-3">
                    <label class="form-label">Варианты ответов (через запятую):</label>
                    <input type="text" name="tasks[${index}][options]" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Правильный ответ:</label>
                    <input type="text" name="tasks[${index}][answer]" class="form-control" required>
                </div>
                <button type="button" onclick="this.parentNode.remove()" class="btn btn-outline-danger btn-sm">
                    Удалить задание
                </button>
            `;
            container.appendChild(taskDiv);
            
            // Добавляем обработчик предпросмотра для нового поля загрузки изображения
            const imageInput = taskDiv.querySelector('input[type="file"]');
            const preview = taskDiv.querySelector('.img-preview');
            
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        preview.src = event.target.result;
                        preview.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                } else {
                    preview.style.display = 'none';
                }
            });
        }
        
        // Для математических задач
        document.getElementById('task-count').addEventListener('change', function() {
            const container = document.getElementById('math-tasks-container');
            container.innerHTML = '';
            const count = parseInt(this.value);
            
            for (let i = 0; i < count; i++) {
                const taskDiv = document.createElement('div');
                taskDiv.className = 'task-item mb-4 p-3 border rounded';
                taskDiv.innerHTML = `
                    <h5>Задача ${i+1}</h5>
                    <div class="mb-3">
                        <label class="form-label">Шаблон вопроса:</label>
                        <textarea name="tasks[${i}][question_template]" class="form-control" rows="3" required></textarea>
                        <small class="text-muted">Используйте {x}, {y}, {z} для переменных</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Изображение для задачи (необязательно):</label>
                        <input type="file" name="tasks[${i}][task_image]" class="form-control" accept="image/*">
                        <img id="math-task-image-preview-${i}" class="img-preview">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Формула для ответа:</label>
                        <input type="text" name="tasks[${i}][answer_formula]" class="form-control" required>
                        <small class="text-muted">Например: x + y - z</small>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="form-label">Минимальное значение:</label>
                            <input type="number" name="tasks[${i}][min_value]" class="form-control" value="1" required>
                        </div>
                        <div class="col">
                            <label class="form-label">Максимальное значение:</label>
                            <input type="number" name="tasks[${i}][max_value]" class="form-control" value="10" required>
                        </div>
                    </div>
                `;
                container.appendChild(taskDiv);
                
                // Добавляем обработчик предпросмотра для изображения задачи
                const imageInput = taskDiv.querySelector('input[type="file"]');
                const preview = taskDiv.querySelector('.img-preview');
                
                imageInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            preview.src = event.target.result;
                            preview.style.display = 'block';
                        }
                        reader.readAsDataURL(file);
                    } else {
                        preview.style.display = 'none';
                    }
                });
            }
        });

        // Предпросмотр изображения для теории
        document.getElementById('theory-image-input').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('theory-image-preview');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    preview.src = event.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        });

        // Инициализация при загрузке
        document.addEventListener('DOMContentLoaded', function() {
            // Добавляем первое задание
            addTask();
            
            // Инициализируем математические задачи
            document.getElementById('task-count').dispatchEvent(new Event('change'));
        });
    </script>
</body>
</html>