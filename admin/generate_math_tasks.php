<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: /admin/admin_login.php');
    exit;
}

// Константы для загрузки изображений
define('MAX_IMAGE_SIZE', 2 * 1024 * 1024); // 2MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/gif']);
define('MATH_TASKS_IMAGES_DIR', '../language/ru/math_tasks/images');

function createMathTasksFile($path, $content) {
    $file = fopen($path, 'w');
    fwrite($file, $content);
    fclose($file);
}

function generateRandomValue($min, $max) {
    return rand($min, $max);
}

function calculateAnswer($formula, $values) {
    extract($values);
    return eval("return $formula;");
}

function validateAndSaveImage($file, $targetDir, $baseName) {
    // проверка
    if (!is_array($file) || !isset($file['error'])) {
        throw new Exception("Некорректные данные файла");
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("Ошибка загрузки файла: " . $file['error']);
    }

    // Проверка типа файла
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mime, ALLOWED_IMAGE_TYPES)) {
        throw new Exception("Недопустимый тип файла. Разрешены только JPG, PNG и GIF.");
    }

    // Проверка размера файла
    if ($file['size'] > MAX_IMAGE_SIZE) {
        throw new Exception("Файл слишком большой. Максимальный размер: 2MB.");
    }

    // Проверка на реальный тип изображения
    if (!getimagesize($file['tmp_name'])) {
        throw new Exception("Файл не является изображением.");
    }

    // Создаем папку, если ее нет
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    // Генерируем уникальное имя файла
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $imageName = $baseName . '.' . $extension;
    $imagePath = "$targetDir/$imageName";

    // Перемещаем файл
    if (!move_uploaded_file($file['tmp_name'], $imagePath)) {
        throw new Exception("Не удалось сохранить файл.");
    }

    return $imageName;
}

function updateMathTasksIndex($topicId, $topicName, $taskCount) {
    $indexFile = "../language/ru/math_tasks/index.php";
    
    // Читаем текущее содержимое файла
    $content = file_get_contents($indexFile);
    
    // Обновляем массив тем
    if (preg_match('/\$topics\s*=\s*\[([^\]]+)\]/s', $content, $matches)) {
        $newTopics = $matches[1] . "\n    $topicId => \"$topicName\",";
        $content = str_replace($matches[0], '$topics = [' . $newTopics . "\n];", $content);
    }
    
    // Обновляем массив с количеством задач
    if (preg_match('/\$tasksCount\s*=\s*\[([^\]]+)\]/s', $content, $matches)) {
        $newTasksCount = $matches[1] . "\n    $topicId => $taskCount,";
        $content = str_replace($matches[0], '$tasksCount = [' . $newTasksCount . "\n];", $content);
    }
    
    file_put_contents($indexFile, $content);
}

$success = false;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $topicName = trim($_POST['topic_name']);
        $tasks = $_POST['tasks'];
        
        // Находим следующий номер темы
        $existing = glob("../language/ru/math_tasks/topic*.php");
        $nextNumber = count($existing) + 1;
        
        // Создаем папку для изображений задач, если ее нет
        if (!file_exists(MATH_TASKS_IMAGES_DIR)) {
            mkdir(MATH_TASKS_IMAGES_DIR, 0755, true);
        }
        
        // Генерируем задачи
        $tasksArrayContent = "[\n";
        $taskIndex = 1;
        
        foreach ($tasks as $i => $taskData) {

        // Обработка изображения для задачи
        $taskImageHtml = '';
            if (!empty($_FILES['tasks']['name'][$i]['task_image'])) {
            // Правильно формируем массив с данными файла
            $fileData = [
                'name' => $_FILES['tasks']['name'][$i]['task_image'],
                'type' => $_FILES['tasks']['type'][$i]['task_image'],
                'tmp_name' => $_FILES['tasks']['tmp_name'][$i]['task_image'],
                'error' => $_FILES['tasks']['error'][$i]['task_image'],
                'size' => $_FILES['tasks']['size'][$i]['task_image']
            ];
    
            $imageName = validateAndSaveImage(
                $fileData, // Передаём полный массив с данными файла
                MATH_TASKS_IMAGES_DIR,
                "topic{$nextNumber}_task{$taskIndex}"
            );
            $taskImageHtml = "<div class='text-center mb-3'><img src='images/$imageName' class='img-fluid rounded' alt='Иллюстрация к задаче'></div>";
        }
            
            $values = [
                'x' => generateRandomValue($taskData['min_value'], $taskData['max_value']),
                'y' => generateRandomValue($taskData['min_value'], $taskData['max_value']),
                'z' => generateRandomValue($taskData['min_value'], $taskData['max_value'])
            ];
            
            $question = $taskData['question_template'];
            foreach ($values as $key => $value) {
                $question = str_replace("{" . $key . "}", $value, $question);
            }
            
            $answer = calculateAnswer($taskData['answer_formula'], $values);
            
            $fullQuestion = $taskImageHtml . $question;
            
            $tasksArrayContent .= "    $taskIndex => [\n";
            $tasksArrayContent .= "        'question' => \"" . addslashes($fullQuestion) . "\",\n";
            $tasksArrayContent .= "        'answer' => \"" . $answer . "\",\n";
            $tasksArrayContent .= "        'formula' => \"" . addslashes($taskData['answer_formula']) . "\",\n";
            $tasksArrayContent .= "        'values' => " . var_export($values, true) . "\n";
            $tasksArrayContent .= "    ],\n";
            
            $taskIndex++;
        }
        
        $tasksArrayContent .= "];";
        
        $mathTasksContent = <<<PHP
<?php
session_start();
require_once '../../../db.php';

if (!isset(\$_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

const TASK_REWARD = 70;
\$user_id = \$_SESSION['user_id'];
\$topic_id = $nextNumber;

\$tasks = $tasksArrayContent

// Обработка формы
if (\$_SERVER['REQUEST_METHOD'] === 'POST') {
    \$task_id = (int)\$_POST['task_id'];
    \$given = trim(\$_POST['given']);
    \$solution = trim(\$_POST['solution']);
    \$user_answer = trim(\$_POST['answer']);

    if (empty(\$given) || empty(\$solution) || empty(\$user_answer)) {
        \$_SESSION['error_message'] = "Все поля должны быть заполнены!";
        header("Location: topic{\$topic_id}.php?task={\$task_id}");
        exit();
    }

    \$is_correct = (\$user_answer === \$tasks[\$task_id]['answer']);
    \$reward = 0;

    \$stmt = \$pdo->prepare("SELECT COUNT(*) FROM user_tasks WHERE user_id = ? AND topic_id = ? AND task_id = ? AND is_correct = 1");
    \$stmt->execute([\$user_id, \$topic_id, \$task_id]);
    \$already_solved = \$stmt->fetchColumn() > 0;

    if (\$is_correct) {
        if (!\$already_solved) {
            \$reward = TASK_REWARD;
            \$stmt = \$pdo->prepare("UPDATE users SET coins = coins + ? WHERE id = ?");
            \$stmt->execute([\$reward, \$user_id]);
            \$_SESSION['success_message'] = "Правильно! Вы заработали {\$reward} монет.";
        } else {
            \$_SESSION['success_message'] = "Правильно! Но вы уже решали эту задачу, монеты не начислены.";
        }
    } else {
        \$_SESSION['error_message'] = "❌ Неправильный ответ.";
    }

    \$stmt = \$pdo->prepare("INSERT INTO user_tasks (user_id, topic_id, task_id, given, solution, answer, is_correct, reward) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    \$stmt->execute([\$user_id, \$topic_id, \$task_id, \$given, \$solution, \$user_answer, \$is_correct, \$reward]);

    header("Location: topic{\$topic_id}.php?task={\$task_id}");
    exit();
}

\$current_task = isset(\$_GET['task']) ? (int)\$_GET['task'] : 1;
if (!isset(\$tasks[\$current_task])) {
    \$current_task = 1;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Задачи: {$topicName} - CyberMath</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f5f7fa, #c3cfe2); }
        .task-container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            padding: 30px;
            margin-bottom: 20px;
        }
        .form-section {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
        }
        .form-label { font-weight: 500; }
        .reward-badge {
            background-color: #00b894;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: bold;
        }
        .task-nav {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .task-number {
            font-size: 1.2rem;
            font-weight: 500;
        }
        .img-fluid {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin: 15px 0;
        }
        .formula-hint {
            background-color: #f1f1f1;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            font-family: monospace;
        }
    </style>
</head>
<body class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">🧩 {$topicName}</h1>
        <a href="index.php" class="btn btn-outline-secondary">← Назад к темам</a>
    </div>

    <?php if (isset(\$_SESSION['error_message'])): ?>
        <div class="alert alert-danger mb-4">
            <?= \$_SESSION['error_message']; unset(\$_SESSION['error_message']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset(\$_SESSION['success_message'])): ?>
        <div class="alert alert-success mb-4">
            <?= \$_SESSION['success_message']; unset(\$_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>

    <div class="task-nav">
        <div><span class="task-number">Задача <?= \$current_task ?> из <?= count(\$tasks) ?></span></div>
        <div>
            <?php if (\$current_task > 1): ?>
                <a href="topic<?= \$topic_id ?>.php?task=<?= \$current_task - 1 ?>" class="btn btn-outline-primary btn-sm me-2">← Предыдущая</a>
            <?php endif; ?>
            <?php if (\$current_task < count(\$tasks)): ?>
                <a href="topic<?= \$topic_id ?>.php?task=<?= \$current_task + 1 ?>" class="btn btn-outline-primary btn-sm">Следующая →</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="task-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Задача <?= \$current_task ?></h3>
            <span class="reward-badge">+<?= TASK_REWARD ?> монет</span>
        </div>

        <div class="mb-4">
            <?= htmlspecialchars_decode(\$tasks[\$current_task]['question']) ?>
        </div>

        <form method="post">
            <input type="hidden" name="task_id" value="<?= \$current_task ?>">
            <div class="form-section">
                <label for="given" class="form-label">Дано:</label>
                <textarea class="form-control" id="given" name="given" rows="3" required></textarea>
            </div>
            <div class="form-section">
                <label for="solution" class="form-label">Решение:</label>
                <textarea class="form-control" id="solution" name="solution" rows="5" required></textarea>
            </div>
            <div class="form-section">
                <label for="answer" class="form-label">Ответ:</label>
                <input type="text" class="form-control" id="answer" name="answer" required>
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary btn-lg px-5">Проверить</button>
            </div>
        </form>
    </div>

    <script>
        const form = document.querySelector('form');
        const inputs = form.querySelectorAll('input[required], textarea[required]');
        const submitBtn = form.querySelector('button[type="submit"]');
        
        function checkForm() {
            let allFilled = true;
            inputs.forEach(input => {
                if (!input.value.trim()) allFilled = false;
            });
            submitBtn.disabled = !allFilled;
        }

        inputs.forEach(input => input.addEventListener('input', checkForm));
        document.addEventListener('DOMContentLoaded', checkForm);
    </script>
</body>
</html>
PHP;

        // Создаем файл с задачами
        $mathTasksPath = "../language/ru/math_tasks/topic{$nextNumber}.php";
        createMathTasksFile($mathTasksPath, $mathTasksContent);
        
        // Обновляем index.php
        updateMathTasksIndex($nextNumber, $topicName, count($tasks));

        $success = true;
        $createdNumber = $nextNumber;
        
    } catch (Exception $e) {
        $error = $e->getMessage();
        $success = false;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Генерация математических задач - CyberMath</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .img-preview {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
            display: none;
        }
    </style>
</head>
<body class="container py-5">
    <div class="card mx-auto" style="max-width: 800px;">
        <div class="card-body text-center">
            <?php if ($error): ?>
                <div class="alert alert-danger mb-4">
                    <h4 class="alert-heading">Ошибка!</h4>
                    <p><?= htmlspecialchars($error) ?></p>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <h2 class="text-success mb-4">✅ Задачи успешно созданы!</h2>
                <p class="mb-4">Тема "<?= htmlspecialchars($topicName) ?>" была сохранена как тема №<?= $createdNumber ?>.</p>
                <p class="mb-4">Создано <?= count($tasks) ?> задач с изображениями.</p>
                
                <div class="d-flex justify-content-center gap-3 mb-4">
                    <a href="/cybermath.com/language/ru/math_tasks/topic<?= $createdNumber ?>.php" 
                       class="btn btn-primary" target="_blank">
                        Открыть задачи
                    </a>
                </div>
            <?php else: ?>
                <h2 class="text-danger mb-4">❌ Ошибка при создании задач</h2>
                <p>Не удалось создать задачи. <?= $error ? "Причина: $error" : "Пожалуйста, попробуйте снова." ?></p>
            <?php endif; ?>
            
            <div class="mt-4">
                <a href="create_topic.php" class="btn btn-outline-primary me-2">Создать новые задачи</a>
                <a href="dashboard.php" class="btn btn-outline-secondary">Вернуться в админку</a>
            </div>
        </div>
    </div>
</body>
</html>