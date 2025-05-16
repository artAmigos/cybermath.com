<?php
session_start();
require_once '../../../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

const TASK_REWARD = 70;
$user_id = $_SESSION['user_id'];
$topic_id = 16; // Määrame teema numbri 16, nagu sinu näites

$tasks = [
    1 => [
        'question' => "Mis on punkti koordinaadid tasandil?",
        'answer' => "Punkti koordinaadid on tema asukoht kahemõõtmelises koordinaatide süsteemis, väljendatuna arvudega (x, y).",
        'choices' => [
            "Punkti koordinaadid on tema asukoht kolmemõõtmelises koordinaatide süsteemis, väljendatuna arvudega (x, y, z).",
            "Punkti koordinaadid on tema asukoht kahemõõtmelises koordinaatide süsteemis, väljendatuna arvudega (x, y).",
            "Punkti koordinaadid on kaugus koordinaatide alguspunktist."
        ]
    ],
    2 => [
        'question' => "Kuidas leida kahe punkti vaheline kaugus tasandil?",
        'answer' => "Kaugus punktide A(x1, y1) ja B(x2, y2) vahel arvutatakse valemiga: √((x2 - x1)² + (y2 - y1)²).",
        'choices' => [
            "Kaugus punktide A(x1, y1) ja B(x2, y2) vahel arvutatakse valemiga: √((x2 - x1)² + (y2 - y1)²).",
            "Kaugus punktide A(x1, y1) ja B(x2, y2) vahel on (x2 - x1) + (y2 - y1).",
            "Kaugus tasandil olevate punktide vahel sõltub telgede vahelistest nurkadest."
        ]
    ],
    3 => [
        'question' => "Mis on sirged koordinaattasandil?",
        'answer' => "Sirge tasandil on punktide hulk, mis rahuldab lineaarvõrrandit kujul ax + by + c = 0.",
        'choices' => [
            "Sirge tasandil on punktide hulk, mis rahuldab lineaarvõrrandit kujul ax + by + c = 0.",
            "Sirge tasandil on kõigi võimalike punktide kogum, millel on samad x-koordinaadid.",
            "Sirge tasandil on geomeetriline kujund lõpmatute otstega."
        ]
    ],
    4 => [
        'question' => "Mis on sirge kaldenurk?",
        'answer' => "Sirge kaldenurk on väärtus, mis näitab sirge kalduvust võrreldes abstsissiteljega (x).",
        'choices' => [
            "Sirge kaldenurk on väärtus, mis näitab sirge kalduvust võrreldes abstsissiteljega (x).",
            "Sirge kaldenurk on nurk sirge ja ordinaattelje (y) vahel.",
            "Sirge kaldenurk on kaugus koordinaatide alguspunktist sirgeni."
        ]
    ],
    5 => [
        'question' => "Kuidas määrata kahe sirge lõikepunkt?",
        'answer' => "Kahe sirge lõikepunkt tasandil on punkt, mis rahuldab mõlema sirge võrrandeid.",
        'choices' => [
            "Kahe sirge lõikepunkt tasandil on punkt, mis rahuldab mõlema sirge võrrandeid.",
            "Kahe sirge lõikepunkt tasandil on punkt, millel on mõlema sirge jaoks samad koordinaadid.",
            "Kahe sirge lõikepunkt asub alati koordinaatsüsteemi keskel."
        ]
    ],
    6 => [
        'question' => "Kuidas leida sirge võrrand kahe punkti järgi?",
        'answer' => "Sirge võrrand, mis läbib kahte punkti (x1, y1) ja (x2, y2), on kujul: y - y1 = m(x - x1), kus m on kaldenurk.",
        'choices' => [
            "Sirge võrrand, mis läbib kahte punkti (x1, y1) ja (x2, y2), on kujul: y - y1 = m(x - x1), kus m on kaldenurk.",
            "Sirge võrrand on alati kujul y = mx + c, kus m on kaldenurk ja c on vaba liige.",
            "Sirge võrrandi saab väljendada kahe punkti x-koordinaatide summaga."
        ]
    ],
    7 => [
        'question' => "Kuidas arvutada nurk kahe sirge vahel koordinaattasandil?",
        'answer' => "Nurk kahe sirge vahel arvutatakse valemiga: tg(θ) = |(m1 - m2) / (1 + m1 * m2)|, kus m1 ja m2 on sirgete kaldenurgad.",
        'choices' => [
            "Nurk kahe sirge vahel arvutatakse valemiga: tg(θ) = |(m1 - m2) / (1 + m1 * m2)|, kus m1 ja m2 on sirgete kaldenurgad.",
            "Nurk sirgete vahel võrdub nende kaldenurkade vahega.",
            "Nurk sirgete vahel on alati 90 kraadi."
        ]
    ],
];

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
    <title>Ülesanded: Koordinaattasand - CyberMath</title>
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
        <h1 class="text-primary">🧩 Koordinaattasand</h1>
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
                <select class="form-control" id="answer" name="answer" required>
                    <?php foreach ($tasks[$current_task]['choices'] as $choice): ?>
                        <option value="<?= htmlspecialchars($choice) ?>"><?= htmlspecialchars($choice) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Saada vastus</button>
            </div>
        </form>
    </div>
</body>
</html>