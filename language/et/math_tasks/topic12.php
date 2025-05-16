<?php
session_start();
require_once '../../../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

const TASK_REWARD = 70;
$user_id = $_SESSION['user_id'];
$topic_id = 12;

$tasks = [
    1 => [
        'question' => "Milline number on suurem: 7 või 9?",
        'answer' => "9"
    ],
    2 => [
        'question' => "Milline number on väiksem: -3 või 2?",
        'answer' => "-3"
    ],
    3 => [
        'question' => "Kui x = 4 ja y = 6, siis milline on suurem: x või y?",
        'answer' => "y"
    ],
    4 => [
        'question' => "Lahenda ebavõrdsus: 5x < 20. Milline on suurim täisarvuline väärtus, mida x võib võtta?",
        'answer' => "3"
    ],
    5 => [
        'question' => "Milline väide on õige: 8 > 10, 10 > 8, 8 = 10?",
        'answer' => "10 > 8"
    ],
];

// Töötlemine vormi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = (int)$_POST['task_id'];
    $given = trim($_POST['given']);
    $solution = trim($_POST['solution']);
    $user_answer = trim($_POST['answer']);

    if (empty($given) || empty($solution) || empty($user_answer)) {
        $_SESSION['error_message'] = "Kõik väljad peavad olema täidetud!";
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
            $_SESSION['success_message'] = "Õige! Olete teeninud {$reward} münti.";
        } else {
            $_SESSION['success_message'] = "Õige! Kuid olete juba selle ülesande lahendanud, mündid ei ole arvestatud.";
        }
    } else {
        $_SESSION['error_message'] = "❌ Vale vastus.";
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
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Ülesanded: Ebavõrdsused - CyberMath</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f5f7fa, #dfe9f3); }
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
            background-color: #6c5ce7;
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
        <h1 class="text-primary">📏 Ebavõrdsused</h1>
        <a href="index.php" class="btn btn-outline-secondary">← Tagasi teemade juurde</a>
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
        <div><span class="task-number">Ülesanne <?= $current_task ?> / <?= count($tasks) ?></span></div>
        <div>
            <?php if ($current_task > 1): ?>
                <a href="topic<?= $topic_id ?>.php?task=<?= $current_task - 1 ?>" class="btn btn-outline-primary btn-sm me-2">← Eelmine</a>
            <?php endif; ?>
            <?php if ($current_task < count($tasks)): ?>
                <a href="topic<?= $topic_id ?>.php?task=<?= $current_task + 1 ?>" class="btn btn-outline-primary btn-sm">Järgmine →</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="task-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Ülesanne <?= $current_task ?></h3>
            <span class="reward-badge">+<?= TASK_REWARD ?> münti</span>
        </div>

        <div class="mb-4">
            <h5><?= htmlspecialchars($tasks[$current_task]['question']) ?></h5>
        </div>

        <form method="post">
            <input type="hidden" name="task_id" value="<?= $current_task ?>">
            <div class="form-section">
                <label for="given" class="form-label">Antud:</label>
                <textarea class="form-control" id="given" name="given" rows="3" required></textarea>
            </div>
            <div class="form-section">
                <label for="solution" class="form-label">Lahendus:</label>
                <textarea class="form-control" id="solution" name="solution" rows="5" required></textarea>
            </div>
            <div class="form-section">
                <label for="answer" class="form-label">Vastus:</label>
                <input type="text" class="form-control" id="answer" name="answer" required>
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary btn-lg px-5">Kontrolli</button>
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
