<?php
session_start();
require_once '../../../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Sissetulek tõenäosusse - CyberMath</title>
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
        
        .probability-box {
            background-color: #f8f9fa;
            border-left: 4px solid #6c5ce7;
            padding: 15px;
            margin: 15px 0;
            border-radius: 0 5px 5px 0;
        }
        
        .example-img {
            max-width: 300px;
            margin: 15px auto;
            display: block;
        }
    </style>
</head>
<body class="container py-5 position-relative">


    <?php for ($i = 0; $i < 15; $i++): ?>
        <div class="emoji" style="left: <?= rand(0, 100) ?>%; top: <?= rand(10, 100) ?>px; animation-delay: <?= rand(0, 10) ?>s;">
            <?= ['🎲','📊','🎯','🧮','🔮','📈','🎰','🤔'][rand(0, 7)] ?>
        </div>
    <?php endfor; ?>

    <div class="card mx-auto" style="max-width: 900px;">
        <h1 class="mb-4 text-center">🎲 Sissetulek tõenäosusse</h1>

        <p><strong>Tõenäosus</strong> on arvu määratlus, mis näitab, kui tõenäoline on mõne sündmuse juhtumine. Seda mõõdetakse vahemikus 0 (võimatu sündmus) kuni 1 (kindel sündmus) või vahemikus 0% kuni 100%.</p>

        <div class="probability-box">
            <strong>Tõenäosuse valem:</strong><br>
            P(A) = Soositud tulemuste arv / Kõikide võimalike tulemuste arv<br>
            Kus P(A) on sündmuse A tõenäosus
        </div>

        <h3 class="mt-4">🔹 Põhimõisted</h3>
        <ul>
            <li><strong>Kindel sündmus</strong> — sündmus, mis kindlasti juhtub (P = 1)</li>
            <li><strong>Võimatu sündmus</strong> — sündmus, mis ei saa kunagi juhtuda (P = 0)</li>
            <li><strong>Juhuslik sündmus</strong> — sündmus, mis võib juhtuda või ei pruugi juhtuda (0 < P < 1)</li>
        </ul>

        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/4f/Probability_scale.png/300px-Probability_scale.png" alt="Tõenäosuse skaala" class="example-img">

        <h3 class="mt-4">🎯 Tõenäosuse näited</h3>
        <div class="alert alert-success">
            <strong>Näide 1:</strong> Tõenäosus saada kulli mündiviske puhul<br>
            P = 1/2 = 0.5 (või 50%)
        </div>

        <div class="alert alert-warning">
            <strong>Näide 2:</strong> Tõenäosus saada 6 silma täringul<br>
            P = 1/6 ≈ 0.1667 (või ≈16.67%)
        </div>

        <div class="alert alert-info">
            <strong>Näide 3:</strong> Tõenäosus tõmmata äss 36 kaardiga pakist<br>
            P = 4/36 = 1/9 ≈ 0.1111 (või ≈11.11%)
        </div>

        <h3 class="mt-4">📊 Kus kasutatakse tõenäosust?</h3>
        <ul>
            <li>Hasartmängudes ja loteriides</li>
            <li>Kindlustuses ja rahanduses</li>
            <li>Ilmaprognoosides</li>
            <li>Meditsiinis ja bioloogias</li>
            <li>Arvutialgoritmides</li>
        </ul>

        <div class="probability-box mt-4">
            <strong>Soovitus:</strong> Tõenäosust saab väljendada murdudena (1/6), kümnendmurruna (0.1667) või protsentidena (16.67%). Kõik kolm vormi on võrdsed.
        </div>

        <p class="text-center mt-4">
            <a href="../tasks/topic20.php" class="btn btn-primary btn-lg fw-bold">Mine näidetele 🚀</a>
        </p>
    </div>
</body>
</html>
