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
define('THEORY_IMAGES_DIR', '../language/ru/theory/images');
define('TASK_IMAGES_DIR', '../language/ru/tasks/images');

function createPHPFile($path, $content) {
    $file = fopen($path, 'w');
    fwrite($file, $content);
    fclose($file);
}

function getRandomEmoji() {
    $emojis = ['📚', '🧮', '🔢', '➕', '➖', '✖️', '➗', '💡', '🎯', '🧠', '📝', '📊', '🔍', '✅', '📖', '📘'];
    return $emojis[array_rand($emojis)];
}

function escapeForArray($value) {
    if (is_numeric($value)) {
        return $value;
    }
    return '"' . addslashes(trim($value)) . '"';
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

$success = false;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $topicName = trim($_POST['topic_name']);
        $theoryText = trim($_POST['theory_text']);
        $tasks = $_POST['tasks'];
        
        // Находим следующий номер темы
        $existing = glob("../language/ru/theory/topic*.php");
        $nextNumber = count($existing) + 1;
        
        // Обработка изображения для теории
        $theoryImageName = null;
        if (!empty($_FILES['theory_image']['name'])) {
            $theoryImageName = validateAndSaveImage(
                $_FILES['theory_image'],
                THEORY_IMAGES_DIR,
                "topic{$nextNumber}_theory"
            );
        }

            // Обработка изображений для заданий
        $taskImages = [];
        foreach ($tasks as $i => $task) {
            if (!empty($_FILES['tasks']['name'][$i]['image'])) {
            // Правильно формируем массив с данными файла
                $fileData = [
                    'name' => $_FILES['tasks']['name'][$i]['image'],
                    'type' => $_FILES['tasks']['type'][$i]['image'],
                    'tmp_name' => $_FILES['tasks']['tmp_name'][$i]['image'],
                    'error' => $_FILES['tasks']['error'][$i]['image'],
                    'size' => $_FILES['tasks']['size'][$i]['image']
            ];
        
            $taskImages[$i] = validateAndSaveImage(
                $fileData,  // Теперь передаём полный массив с данными файла
                TASK_IMAGES_DIR,
                "topic{$nextNumber}_task" . ($i + 1)
            );
        }
    }

        // Генерируем теорию
        $emoji = getRandomEmoji();
        $theoryImageHtml = $theoryImageName 
            ? "<div class='text-center my-4'><img src='images/$theoryImageName' class='img-fluid rounded' alt='Иллюстрация'></div>" 
            : "";

        $theoryContent = <<<HTML
<?php
session_start();
require_once '../../../db.php';

if (!isset(\$_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>{$topicName} - CyberMath</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            position: relative;
            overflow-x: hidden;
        }
        h1 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #2c3e50;
        }
        .card {
            background: #ffffffcc;
            border: none;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .emoji {
            position: absolute;
            font-size: 2rem;
            animation: float 10s infinite linear;
            opacity: 0.8;
        }
        @keyframes float {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% { opacity: 0.8; }
            100% {
                transform: translateY(-200px) rotate(360deg);
                opacity: 0;
            }
        }
        .btn-primary {
            background-color: #6c5ce7;
            border: none;
        }
        .btn-primary:hover {
            background-color: #5a4bd1;
        }
        .img-fluid {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin: 15px 0;
        }
    </style>
</head>
<body class="container py-5 position-relative">

    <?php for (\$i = 0; \$i < 15; \$i++): ?>
        <div class="emoji" style="left: <?= rand(0, 100) ?>%; top: <?= rand(10, 100) ?>px; animation-delay: <?= rand(0, 10) ?>s;">
            <?= ['🔢','✨','🧠','➕','➖','📘','🚀','🧮'][rand(0, 7)] ?>
        </div>
    <?php endfor; ?>

    <div class="card mx-auto" style="max-width: 900px;">
        <h1 class="mb-4 text-center">{$emoji} {$topicName}</h1>
        
        {$theoryImageHtml}
        
        <div class="theory-content">
            {$theoryText}
        </div>

        <p class="text-center mt-4">
            <a href="../tasks/topic{$nextNumber}.php" class="btn btn-primary btn-lg fw-bold">Перейти к примерам 🚀</a>
        </p>
    </div>
</body>
</html>
HTML;

        // Генерация задач
        $tasksArrayContent = "[\n";
        foreach ($tasks as $i => $task) {
            $question = addslashes($task['question']);
            $options = array_map('trim', explode(',', $task['options']));
            
            // Добавляем изображение к вопросу, если есть
            $questionImageHtml = isset($taskImages[$i]) 
                ? "<div class='text-center mb-3'><img src='images/{$taskImages[$i]}' class='img-fluid rounded' alt='Иллюстрация к заданию'></div>" 
                : "";
            
            $questionWithImage = $questionImageHtml . $question;
            
            // Формируем массив options
            $optionsArray = "[" . implode(", ", array_map('escapeForArray', $options)) . "]";
            
            $answer = escapeForArray($task['answer']);
            
            $tasksArrayContent .= "    [\n";
            $tasksArrayContent .= "        'question' => \"{$questionWithImage}\",\n";
            $tasksArrayContent .= "        'options' => {$optionsArray},\n";
            $tasksArrayContent .= "        'answer' => {$answer}\n";
            $tasksArrayContent .= "    ],\n";
        }
        $tasksArrayContent .= "];";
        
        $tasksContent = <<<PHP
<?php
session_start();
require_once '../../../db.php';

if (!isset(\$_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

\$user_id = \$_SESSION['user_id'];
\$topic_id = {$nextNumber};

\$tasks = {$tasksArrayContent}

\$show_result = false;
\$score = 0;
\$user_answers = [];
\$earned_bonus = false;

if (\$_SERVER['REQUEST_METHOD'] === 'POST') {
    \$show_result = true;

    foreach (\$tasks as \$i => \$task) {
        \$user_answer = \$_POST['q' . \$i] ?? null;
        \$user_answers[\$i] = \$user_answer;

        if (\$user_answer == \$task['answer']) {
            \$score++;
        }
    }

    if (\$score === count(\$tasks)) {
        // Проверка, проходил ли пользователь эту тему ранее
        \$stmt = \$pdo->prepare("SELECT COUNT(*) FROM user_topics WHERE user_id = ? AND topic_id = ?");
        \$stmt->execute([\$user_id, \$topic_id]);
        \$already_completed = \$stmt->fetchColumn();

        if (\$already_completed == 0) {
            // Засчитываем прохождение темы (триггер сам начислит 50 монет)
            \$insert = \$pdo->prepare("INSERT INTO user_topics (user_id, topic_id) VALUES (?, ?)");
            \$insert->execute([\$user_id, \$topic_id]);

            \$earned_bonus = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Задачи: {$topicName}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #f9f9f9, #eef3f7);
            font-family: 'Segoe UI', sans-serif;
        }
        .task-card {
            animation: fadeInUp 0.5s ease;
            transition: transform 0.3s;
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .task-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 14px rgba(0,0,0,0.15);
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animated-alert {
            animation: fadeIn 0.8s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .btn-success {
            transition: background-color 0.3s;
        }
        .btn-success:hover {
            background-color: #218838;
        }
        .img-fluid {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin: 15px 0;
        }
    </style>
</head>
<body class="container py-5">
    <h1 class="mb-4 text-center">🧠 {$topicName}</h1>

    <?php if (\$show_result): ?>
        <div class="alert alert-info animated-alert text-center fs-5">
            Вы правильно решили <?= \$score ?> из <?= count(\$tasks) ?> задач!
            <?php if (\$score === count(\$tasks) && \$earned_bonus): ?>
                <br><strong class="text-success">+50 монет 💰</strong>
            <?php elseif (\$score === count(\$tasks)): ?>
                <br><em class="text-muted">(уже пройдено ранее)</em>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <?php foreach (\$tasks as \$index => \$task): ?>
            <div class="mb-4 p-4 task-card">
                <h5><?= (\$index + 1) . ') ' . \$task['question'] ?></h5>
                <?php foreach (\$task['options'] as \$opt): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="q<?= \$index ?>" value="<?= \$opt ?>"
                            <?= isset(\$user_answers[\$index]) && \$user_answers[\$index] == \$opt ? 'checked' : '' ?> 
                            <?= \$show_result ? 'disabled' : '' ?>>
                        <label class="form-check-label"><?= \$opt ?></label>
                    </div>
                <?php endforeach; ?>

                <?php if (\$show_result): ?>
                    <?php if (!isset(\$user_answers[\$index])): ?>
                        <div class="mt-2 text-warning">❌ Нет ответа</div>
                    <?php elseif (\$user_answers[\$index] == \$task['answer']): ?>
                        <div class="mt-2 text-success">✅ Правильно!</div>
                    <?php else: ?>
                        <div class="mt-2 text-danger">❌ Неправильно. Правильный ответ: <?= \$task['answer'] ?></div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <div class="text-center mt-4">
            <?php if (!\$show_result): ?>
                <button type="submit" class="btn btn-success btn-lg px-5">Показать результат</button>
            <?php elseif (\$score < count(\$tasks)): ?>
                <a href="" class="btn btn-warning btn-lg px-5">Попробовать снова</a>
            <?php endif; ?>
        </div>
    </form>

    <div class="text-center mt-4">
        <a href="../theory/index.php" class="btn btn-outline-secondary">← Назад к темам</a>
    </div>
</body>
</html>
PHP;

        // Создаем файлы
        $theoryPath = "../language/ru/theory/topic{$nextNumber}.php";
        $taskPath = "../language/ru/tasks/topic{$nextNumber}.php";
        
        createPHPFile($theoryPath, $theoryContent);
        createPHPFile($taskPath, $tasksContent);
        
        // Обновляем список тем
        $topicsFile = "../language/ru/theory/index.php";
        $topicsContent = file_get_contents($topicsFile);
        
        if (preg_match('/\$topics\s*=\s*\[([^\]]+)\]/', $topicsContent, $matches)) {
            $currentTopics = $matches[1];
            $newTopics = rtrim($currentTopics) . "\n    \"" . addslashes($topicName) . "\",";
            $topicsContent = str_replace($currentTopics, $newTopics, $topicsContent);
            file_put_contents($topicsFile, $topicsContent);
        }
        
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
    <title>Генерация темы - CyberMath</title>
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
                <h2 class="text-success mb-4">✅ Тема успешно создана!</h2>
                <p class="mb-4">Тема "<?= htmlspecialchars($topicName) ?>" была сохранена как тема №<?= $createdNumber ?>.</p>
                
                <div class="d-flex justify-content-center gap-3 mb-4">
                    <a href="/cybermath.com/language/ru/theory/topic<?= $createdNumber ?>.php" 
                       class="btn btn-primary" target="_blank">
                        Открыть теорию
                    </a>
                    <a href="/cybermath.com/language/ru/tasks/topic<?= $createdNumber ?>.php" 
                       class="btn btn-success" target="_blank">
                        Открыть задачи
                    </a>
                </div>
            <?php else: ?>
                <h2 class="text-danger mb-4">❌ Ошибка при создании темы</h2>
                <p>Не удалось создать тему. <?= $error ? "Причина: $error" : "Пожалуйста, попробуйте снова." ?></p>
            <?php endif; ?>
            
            <div class="mt-4">
                <a href="create_topic.php" class="btn btn-outline-primary me-2">Создать новую тему</a>
                <a href="dashboard.php" class="btn btn-outline-secondary">Вернуться в админку</a>
            </div>
        </div>
    </div>
</body>
</html>