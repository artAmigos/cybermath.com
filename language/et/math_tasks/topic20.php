<?php
session_start();
require_once '../../../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

const TASK_REWARD = 70;
$user_id = $_SESSION['user_id'];
$topic_id = 20;  // Teema "Sissejuhatus tõenäosusesse"

$tasks = [
    1 => [
        'question' => "Kotikeses on 4 punast palli ja 6 sinist. Mis on tõenäosus, et kotist võetakse punane pall?",
        'answer' => "2/5"
    ],
    2 => [
        'question' => "Petil on 3 punast ja 5 rohelist õuna. Mis on tõenäosus, et Peti valib juhuslikult rohelise õuna?",
        'answer' => "5/8"
    ],
    3 => [
        'question' => "Kastis on 8 palli: 3 punast, 2 sinist ja 3 rohelist. Mis on tõenäosus, et valitud pall on roheline?",
        'answer' => "3/8"
    ],
    4 => [
        'question' => "Ekraanil kuvatakse 10 numbrit: 2 paaris ja 8 paaritut. Mis on tõenäosus, et valitakse paarisnumber?",
        'answer' => "2/10"
    ],
    5 => [
        'question' => "Urnis on 4 valget ja 3 musta palli. Mis on tõenäosus, et võetud pall on valge?",
        'answer' => "4/7"
    ],
    6 => [
        'question' => "20 kaardipakist valitakse juhuslikult üks kaart. Pakis on 5 loomade kujutistega kaarti. Kui suur on tõenäosus, et loomaga kaart valitakse välja?",
        'answer' => "1/4"
    ]
];

// Vormi töötlemine
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
            $_SESSION['success_message'] = "Õige! Te teenisite {$reward} münti.";
        } else {
            $_SESSION['success_message'] = "Õige! Kuid te olete selle ülesande juba lahendanud, münte ei lisatud.";
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
    <title>Ülesanded: Sissejuhatus tõenäosusesse - CyberMath</title>
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
    </style>
</head>
<body class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">🧩 Sissejuhatus tõenäosusesse</h1>
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