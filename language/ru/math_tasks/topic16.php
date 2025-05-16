<?php
session_start();
require_once '../../../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

const TASK_REWARD = 70;
$user_id = $_SESSION['user_id'];
$topic_id = 16; // Указываем номер топика 16, как в твоем примере

$tasks = [
    1 => [
        'question' => "Что такое координаты точки на плоскости?",
        'answer' => "Координаты точки – это ее положение в двухмерной системе координат, выраженное в числах (x, y).",
        'choices' => [
            "Координаты точки – это ее положение в трехмерной системе координат, выраженное в числах (x, y, z).",
            "Координаты точки – это ее положение в двухмерной системе координат, выраженное в числах (x, y).",
            "Координаты точки – это расстояние от начала координат."
        ]
    ],
    2 => [
        'question' => "Как найти расстояние между двумя точками на плоскости?",
        'answer' => "Расстояние между точками A(x1, y1) и B(x2, y2) вычисляется по формуле: √((x2 - x1)² + (y2 - y1)²).",
        'choices' => [
            "Расстояние между точками A(x1, y1) и B(x2, y2) вычисляется по формуле: √((x2 - x1)² + (y2 - y1)²).",
            "Расстояние между точками A(x1, y1) и B(x2, y2) равно (x2 - x1) + (y2 - y1).",
            "Расстояние между точками на плоскости зависит от углов между осями."
        ]
    ],
    3 => [
        'question' => "Что такое прямые на координатной плоскости?",
        'answer' => "Прямая на плоскости — это множество точек, которые удовлетворяют линейному уравнению вида ax + by + c = 0.",
        'choices' => [
            "Прямая на плоскости — это множество точек, которые удовлетворяют линейному уравнению вида ax + by + c = 0.",
            "Прямая на плоскости — это совокупность всех возможных точек, которые имеют одинаковые x-координаты.",
            "Прямая на плоскости — это геометрическая фигура с бесконечными концами."
        ]
    ],
    4 => [
        'question' => "Что такое угловой коэффициент прямой?",
        'answer' => "Угловой коэффициент прямой – это значение, которое показывает наклон прямой относительно оси абсцисс (x).",
        'choices' => [
            "Угловой коэффициент прямой – это значение, которое показывает наклон прямой относительно оси абсцисс (x).",
            "Угловой коэффициент прямой – это угловое значение между прямой и осью ординат (y).",
            "Угловой коэффициент прямой – это расстояние от начала координат до прямой."
        ]
    ],
    5 => [
        'question' => "Как определить точку пересечения двух прямых?",
        'answer' => "Точка пересечения двух прямых на плоскости — это точка, которая удовлетворяет уравнениям обеих прямых.",
        'choices' => [
            "Точка пересечения двух прямых на плоскости — это точка, которая удовлетворяет уравнениям обеих прямых.",
            "Точка пересечения двух прямых на плоскости — это точка с одинаковыми координатами для обеих прямых.",
            "Точка пересечения двух прямых всегда находится в центре координатной системы."
        ]
    ],
    6 => [
        'question' => "Как найти уравнение прямой по двум точкам?",
        'answer' => "Уравнение прямой, проходящей через две точки (x1, y1) и (x2, y2), имеет вид: y - y1 = m(x - x1), где m — угловой коэффициент.",
        'choices' => [
            "Уравнение прямой, проходящей через две точки (x1, y1) и (x2, y2), имеет вид: y - y1 = m(x - x1), где m — угловой коэффициент.",
            "Уравнение прямой всегда имеет вид y = mx + c, где m — угловой коэффициент, а c — свободный член.",
            "Уравнение прямой можно выразить через сумму всех x-координат двух точек."
        ]
    ],
    7 => [
        'question' => "Как вычислить угол между двумя прямыми на координатной плоскости?",
        'answer' => "Угол между двумя прямыми вычисляется по формуле: tg(θ) = |(m1 - m2) / (1 + m1 * m2)|, где m1 и m2 — угловые коэффициенты прямых.",
        'choices' => [
            "Угол между двумя прямыми вычисляется по формуле: tg(θ) = |(m1 - m2) / (1 + m1 * m2)|, где m1 и m2 — угловые коэффициенты прямых.",
            "Угол между прямыми равен разности их угловых коэффициентов.",
            "Угол между прямыми всегда равен 90 градусам."
        ]
    ],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = (int)$_POST['task_id'];
    $given = trim($_POST['given']);
    $solution = trim($_POST['solution']);
    $user_answer = trim($_POST['answer']);

    if (empty($given) || empty($solution) || empty($user_answer)) {
        $_SESSION['error_message'] = "Все поля должны быть заполнены!";
        header("Location: topic{$topic_id}.php?task={$task_id}");
        exit();
    }

    $is_correct = ($user_answer === $tasks[$task_id]['answer']);
    $reward = 0;

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM user_tasks WHERE user_id = ? AND topic_id = ? AND task_id = ? AND is_correct = 1");
    $stmt->execute([$user_id, $topic_id, $task_id]);
    $already_solved = $stmt->fetchColumn() > 0;

    if ($is_correct) {
        if (!$already_solved) {
            $reward = TASK_REWARD;
            $stmt = $pdo->prepare("UPDATE users SET coins = coins + ? WHERE id = ?");
            $stmt->execute([$reward, $user_id]);
            $_SESSION['success_message'] = "Правильно! Вы заработали {$reward} монет.";
        } else {
            $_SESSION['success_message'] = "Правильно! Но вы уже решали эту задачу, монеты не начислены.";
        }
    } else {
        $_SESSION['error_message'] = "❌ Неправильный ответ.";
    }

    $stmt = $pdo->prepare("INSERT INTO user_tasks (user_id, topic_id, task_id, given, solution, answer, is_correct, reward) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $topic_id, $task_id, $given, $solution, $user_answer, $is_correct, $reward]);

    header("Location: topic{$topic_id}.php?task={$task_id}");
    exit();
}

$current_task = isset($_GET['task']) ? (int)$_GET['task'] : 1;
if (!isset($tasks[$current_task])) {
    $current_task = 1;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Задачи: Координатная плоскость - CyberMath</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f5f7fa, #c3cfe2); }
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
    </style>
</head>
<body class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">🧩 Координатная плоскость</h1>
        <a href="index.php" class="btn btn-outline-secondary">← Назад к темам</a>
    </div>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger mb-4">
        <?= $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success mb-4">
        <?= $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
    </div>
<?php endif; ?>

<div class="task-nav">
    <div><span class="task-number">Задача <?= $current_task ?> из <?= count($tasks) ?></span></div>
    <div>
        <?php if ($current_task > 1): ?>
            <a href="topic<?= $topic_id ?>.php?task=<?= $current_task - 1 ?>" class="btn btn-outline-primary btn-sm me-2">← Предыдущая</a>
        <?php endif; ?>
        <?php if ($current_task < count($tasks)): ?>
            <a href="topic<?= $topic_id ?>.php?task=<?= $current_task + 1 ?>" class="btn btn-outline-primary btn-sm">Следующая →</a>
        <?php endif; ?>
    </div>
</div>

<div class="task-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Задача <?= $current_task ?></h3>
        <span class="reward-badge">+<?= TASK_REWARD ?> монет</span>
    </div>

    <div class="mb-4">
        <h5><?= htmlspecialchars($tasks[$current_task]['question']) ?></h5>
    </div>

    <form method="post">
        <input type="hidden" name="task_id" value="<?= $current_task ?>">
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
            <select class="form-control" id="answer" name="answer" required>
                <?php foreach ($tasks[$current_task]['choices'] as $choice): ?>
                    <option value="<?= htmlspecialchars($choice) ?>"><?= htmlspecialchars($choice) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">Отправить ответ</button>
        </div>
    </form>
</div>
</body>
</html>
