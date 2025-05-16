<?php
session_start();
require_once '../../../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$topic_id = 9;

$tasks = [
    [
        'question' => 'Lahenda võrrand: 2x + 5 = 15',
        'options' => [5, 6, 7, 8],
        'answer' => 5
    ],
    [
        'question' => 'Milline x väärtus rahuldab võrrandit: 3x - 7 = 2x + 4',
        'options' => [11, 12, 13, 14],
        'answer' => 11
    ],
    [
        'question' => 'Mitu lahendit on võrrandil: 0x = 0',
        'options' => ['0', '1', 'Lõpmatult palju', 'Lahend puudub'],
        'answer' => 'Lõpmatult palju'
    ],
    [
        'question' => 'Lahenda võrrand: 4(x - 3) = 20',
        'options' => [5, 6, 7, 8],
        'answer' => 8
    ],
    [
        'question' => 'Millisel võrrandil puudub lahendus?',
        'options' => ['2x = 4', '0x = 5', '3x = 3x', 'x + 1 = 1 + x'],
        'answer' => '0x = 5'
    ],
    [
        'question' => 'Lahenda võrrand: (x + 3)/2 = 5',
        'options' => [4, 5, 6, 7],
        'answer' => 7
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
    <title>Ülesanded: Lineaarsed võrrandid</title>
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
    <h1 class="mb-4 text-center">🧠 Lineaarsed võrrandid</h1>

    <?php if ($show_result): ?>
        <div class="alert alert-info animated-alert text-center fs-5">
            Lahendasid õigesti <?= $score ?> / <?= count($tasks) ?> ülesandest!
            <?php if ($score === count($tasks) && $earned_bonus): ?>
                <br><strong class="text-success">+50 münti 💰</strong>
            <?php elseif ($score === count($tasks)): ?>
                <br><em class="text-muted">(juba varem läbitud)</em>
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
                        <div class="mt-2 text-success">✅ Õige vastus!</div>
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
