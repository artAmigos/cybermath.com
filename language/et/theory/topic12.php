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
    <title>Ebavõrdsused - CyberMath</title>
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
        
        .method-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .method-title {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
        }
    </style>
</head>
<body class="container py-5 position-relative">

    <?php for ($i = 0; $i < 15; $i++): ?>
        <div class="emoji" style="left: <?= rand(0, 100) ?>%; top: <?= rand(10, 100) ?>px; animation-delay: <?= rand(0, 10) ?>s;">
            <?= ['≠','≤','≥','<','>','📊','🧮','🔍'][rand(0, 7)] ?>
        </div>
    <?php endfor; ?>

<div class="card mx-auto" style="max-width: 900px;">
    <h1 class="mb-4 text-center">≠ Ebavõrdsused</h1>

    <p><strong>Ebavõrdsus</strong> on matemaatiline avaldis, mis näitab, et üks väärtus on suurem või väiksem kui teine. Erinevalt võrranditest võivad ebavõrdsustel olla mitmed lahendid, mis moodustavad täisvahemikke.</p>

    <div class="alert alert-success">
        Ebavõrdsuste näited:
        <ul>
            <li>\( 3x + 2 > 8 \)</li>
            <li>\( x^2 - 5x ≤ 6 \)</li>
            <li>\( \frac{1}{x} ≥ 2 \)</li>
        </ul>
    </div>

    <div class="method-card">
        <div class="method-title">📌 Ebavõrdsuste tüübid</div>
        <p>Peamised ebavõrdsuste tüübid:</p>
        <ul>
            <li><strong>Lineaarne</strong>: \( ax + b > 0 \)</li>
            <li><strong>Kvadratiivne</strong>: \( ax^2 + bx + c ≤ 0 \)</li>
            <li><strong>Fraktsionaalne</strong>: \( \frac{P(x)}{Q(x)} > 0 \)</li>
            <li><strong>Irratsionaalne</strong>: \( \sqrt{f(x)} ≥ g(x) \)</li>
        </ul>
    </div>

    <div class="method-card">
        <div class="method-title">🔢 Ebavõrdsuste põhijooned</div>
        <ol>
            <li>Kui \( a > b \), siis \( b < a \)</li>
            <li>Kui \( a > b \) ja \( b > c \), siis \( a > c \)</li>
            <li>Kui \( a > b \), siis \( a + c > b + c \)</li>
            <li>Kui \( a > b \) ja \( c > 0 \), siis \( ac > bc \)</li>
            <li>Kui \( a > b \) ja \( c < 0 \), siis \( ac < bc \) (märk muutub!)</li>
        </ol>
    </div>

    <div class="method-card">
        <div class="method-title">📊 Ebavõrdsuste lahendamise meetodid</div>
        <p><strong>1. Intervallide meetod</strong> (ratsionaalsete ebavõrdsuste jaoks):</p>
        <ol>
            <li>Leidke numeraatori ja nimetaja nullpunktid</li>
            <li>Paigaldage need arvulisele sirgele</li>
            <li>Määrake iga intervalli märk</li>
            <li>Valige sobivad intervallid sõltuvalt ebavõrdsuse märgist</li>
        </ol>
        
        <p><strong>2. Graafiline meetod</strong>:</p>
        <p>Joonistage üles vasak ja parem pool ebavõrdsusest ja määrake, kus kehtib võrdlus.</p>
    </div>

    <div class="alert alert-warning">
        <strong>Oluline!</strong> Kui korrutate/võite ebavõrdsust negatiivse arvuga, muutub ebavõrdsuse märk vastupidiseks.
        <br>Näide: \( -2x > 6 \) ⇒ \( x < -3 \)
    </div>

    <p>🧠 Nõuanne: Kontrollige alati äärmisi punkte ja nimetajaid ebavõrdsustes — need võivad olla katkestuspunktid!</p>

    <p class="text-center mt-4">
        <a href="../tasks/topic12.php" class="btn btn-primary btn-lg fw-bold">Liigu ülesannete juurde 🚀</a>
    </p>
</div>

<!-- Lisame MathJaxi matemaatiliste valemite kuvamiseks -->
<script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
<script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
</body>
</html>
