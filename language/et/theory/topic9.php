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
    <title>Liinvõrrandid - CyberMath</title>
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
    </style>
</head>
<body class="container py-5 position-relative">

    <?php for ($i = 0; $i < 15; $i++): ?>
        <div class="emoji" style="left: <?= rand(0, 100) ?>%; top: <?= rand(10, 100) ?>px; animation-delay: <?= rand(0, 10) ?>s;">
            <?= ['🔢','✨','🧠','=','x','➕','➖','🧮'][rand(0, 7)] ?>
        </div>
    <?php endfor; ?>

<div class="card mx-auto" style="max-width: 900px;">
    <h1 class="mb-4 text-center">📘 Liinvõrrandid</h1>

    <p><strong>Liinvõrrand</strong> on võrrand kujul ax + b = 0, kus x on muutujaks, a ja b on koefitsiendid. Selliste võrrandite lahendamine on algebra aluseks ja vajalik keerukamate matemaatiliste probleemide lahendamiseks.</p>

    <div class="alert alert-success">
        Näide: 2x + 4 = 0 → x = <strong>-2</strong>
    </div>

    <p><strong>Lahendamise algoritm:</strong></p>
    <ol>
        <li>Liiguta kõik x-ga seotud liikmed ühele poole, arvud teisele poole</li>
        <li>Liiguta sarnased liitmikud kokku</li>
        <li>Jagage mõlemad pooled x-iga koefitsiendi järgi</li>
    </ol>

    <p><strong>Eri juhud:</strong></p>
    <div class="alert alert-warning">
        <ul>
            <li>Kui a = 0 ja b = 0 → <strong>lõputult palju lahendusi</strong></li>
            <li>Kui a = 0 ja b ≠ 0 → <strong>pole lahendusi</strong></li>
        </ul>
    </div>

    <p>🔍 Samm-sammult lahendamine:</p>
    <p>Lahendame võrrandi: 3x - 6 = x + 2</p>
    <ol>
        <li>Liigutame: 3x - x = 2 + 6</li>
        <li>Lihtsustame: 2x = 8</li>
        <li>Jagame: x = 4</li>
    </ol>

    <p>📌 Kus neid kasutatakse:</p>
    <ul>
        <li>Füüsikas (kiiruste ja kauguste arvutamine)</li>
        <li>Majanduses (tulude ja kulude arvutamine)</li>
        <li>Programmeerimises (algotitmid, tingimused)</li>
        <li>Igas päevas: ajajuhtimine, rahaga seotud arvutused</li>
    </ul>

    <p>🧠 Nõuanne: Kontrollige alati oma lahendust, asendades leitud x tagasi võrrandisse!</p>

    <p class="text-center mt-4">
        <a href="../tasks/topic9.php" class="btn btn-primary btn-lg fw-bold">Liigu näidete juurde 🚀</a>
    </p>
</div>
</body>
</html>
