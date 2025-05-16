<?php
session_start();
require_once '../../../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT topic_id FROM user_topics WHERE user_id = ?");
$stmt->execute([$user_id]);
$completed_ids = $stmt->fetchAll(PDO::FETCH_COLUMN);

$topics = [
    "Liitmine ja lahutamine",
    "Korrutamine ja jagamine",
    "Looduslikud, täisarvud, ratsionaalsed ja irratsionaalsed arvud",
    "Kümnend- ja murrarvud",
    "Protsendid",
    "Aritmeetiline ja geomeetriline progressioon",
    "Potentsid ja juured",
    "Logaritmid",
    "Sirged võrrandid",
    "Sirgete võrrandite süsteemid",
    "Ruutfunktsioonid ja diskriminant",
    "Ebavõrdsused",
    "Muutuja ja funktsioon",
    "Funktsioonide graafikud",
    "Trigonomeetria alused",
    "Koordinaatide tasand",
    "Pythagorase teoreem",
    "Geomeetrilised kujundid",
    "Pindala ja ümbermõõt",
    "Sissejuhatus tõenäosusse"
];
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Õpitud teemad - CyberMath</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg,rgb(255, 255, 255),rgb(104, 231, 195));
            color: #2d3436;
            min-height: 100vh;
        }
        .card {
            background-color: #ffffffcc;
            border: none;
            border-radius: 1rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        .list-group-item {
            background-color: transparent;
            border: none;
            font-weight: 500;
        }
        .list-group-item a {
            color: #6c5ce7;
            text-decoration: none;
        }
        .list-group-item a:hover {
            text-decoration: underline;
        }
        h1 {
            font-weight: 700;
        }
        .btn-secondary {
            background-color: #00cec9;
            border: none;
        }
        .btn-secondary:hover {
            background-color: #00b894;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center py-5">
    <div class="container" style="max-width: 700px;">
        <div class="card p-4">
            <h1 class="text-center mb-4">✅ Õpitud teemad</h1>

            <?php if (count($completed_ids) > 0): ?>
                <ul class="list-group mb-4">
                    <?php foreach ($completed_ids as $id): ?>
                        <?php if (isset($topics[$id - 1])): ?>
                            <li class="list-group-item">
                                <a href="topic<?= $id ?>.php"><?= htmlspecialchars($topics[$id - 1]) ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-muted text-center">Te veel ei ole veel lõpetatud.</p>
            <?php endif; ?>

            <div class="text-center">
                <a href="../profile.php" class="btn btn-secondary">← Tagasi profiili juurde</a>
            </div>
        </div>
    </div>
</body>
</html>
