<?php
session_start();
require_once '../../../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$topic_id = 11;

$tasks = [
    [
        'question' => 'Lahenda võrrand: x² - 5x + 6 = 0',
        'options' => ['2 ja 3', '-2 ja -3', '1 ja 6', 'Lahendus puudub'],
        'answer' => '2 ja 3'
    ],
    [
        'question' => 'Mis on võrrandi 2x² - 4x - 6 = 0 diskriminandi väärtus?',
        'options' => [16, 64, -32, 0],
        'answer' => 64
    ],
    [
        'question' => 'Mitu juuri on võrrandil: x² + 4x + 4 = 0?',
        'options' => ['0', '1', '2', 'Õige vastus puudub'],
        'answer' => '1'
    ],
    [
        'question' => 'Millisel võrrandil puuduvad reaalarvulised juured?',
        'options' => ['x² - 9 = 0', 'x² + 9 = 0', 'x² - 6x + 9 = 0', 'x² + x - 6 = 0'],
        'answer' => 'x² + 9 = 0'
    ],
    [
        'question' => 'Lahenda võrrand: 3x² - 12x = 0',
        'options' => ['0 ja 4', '0 ja -4', '4 ja -4', '0'],
        'answer' => '0 ja 4'
    ],
    [
        'question' => 'Kui diskriminant on 25, mitu juuri võrrandil on?',
        'options' => ['0', '1', '2', 'Sõltub kordajatest'],
        'answer' => '2'
    ]
];

$show_result = false;
$score = 0;
$user_answers = [];
$earned_bonus = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $show_result = true;

    foreach ($tasks as $i => $task) {
        $user_answer = $_POST['q' . $i] ?? null;
        $user_answers[$i] = $user_answer;

        if ($user_answer == $task['answer']) {
            $score++;
        }
    }

    if ($score === count($tasks)) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM user_topics WHERE user_id = ? AND topic_id = ?");
        $stmt->execute([$user_id, $topic_id]);
        $already_completed = $stmt->fetchColumn();

        if ($already_completed == 0) {
            $insert = $pdo->prepare("INSERT INTO user_topics (user_id, topic_id) VALUES (?, ?)");
            $insert->execute([$user_id, $topic_id]);
            $earned_bonus = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Ülesanded: Ruutvõrrandid</title>
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
    </style>
</head>
<body class="container py-5">
    <h1 class="mb-4 text-center">🧠 Ruutvõrrandid</h1>

    <?php if ($show_result): ?>
        <div class="alert alert-info animated-alert text-center fs-5">
            Sa lahendasid õigesti <?= $score ?> / <?= count($tasks) ?> ülesandest!
            <?php if ($score === count($tasks) && $earned_bonus): ?>
                <br><strong class="text-success">+50 münti 💰</strong>
            <?php elseif ($score === count($tasks)): ?>
                <br><em class="text-muted">(juba varem lahendatud)</em>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <?php foreach ($tasks as $index => $task): ?>
            <div class="mb-4 p-4 task-card">
                <h5><?= ($index + 1) . ') ' . $task['question'] ?></h5>
                <?php foreach ($task['options'] as $opt): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="q<?= $index ?>" value="<?= $opt ?>"
                            <?= isset($user_answers[$index]) && $user_answers[$index] == $opt ? 'checked' : '' ?> 
                            <?= $show_result ? 'disabled' : '' ?>>
                        <label class="form-check-label"><?= $opt ?></label>
                    </div>
                <?php endforeach; ?>

                <?php if ($show_result): ?>
                    <?php if (!isset($user_answers[$index])): ?>
                        <div class="mt-2 text-warning">❌ Vastus puudub</div>
                    <?php elseif ($user_answers[$index] == $task['answer']): ?>
                        <div class="mt-2 text-success">✅ Õige!</div>
                    <?php else: ?>
                        <div class="mt-2 text-danger">❌ Vale. Õige vastus: <?= $task['answer'] ?></div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <div class="text-center mt-4">
            <?php if (!$show_result): ?>
                <button type="submit" class="btn btn-success btn-lg px-5">Näita tulemust</button>
            <?php elseif ($score < count($tasks)): ?>
                <a href="" class="btn btn-warning btn-lg px-5">Proovi uuesti</a>
            <?php endif; ?>
        </div>
    </form>

    <div class="text-center mt-4">
        <a href="../theory/index.php" class="btn btn-outline-secondary">← Tagasi teemade juurde</a>
    </div>
</body>
</html>
