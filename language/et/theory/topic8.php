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
    <title>Logaritmid - CyberMath</title>
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
            <?= ['🔢','✨','🧠','㏒','㏑','∞','∫','≋'][rand(0, 7)] ?>
        </div>
    <?php endfor; ?>

<div class="card mx-auto" style="max-width: 900px;">
    <h1 class="mb-4 text-center">📘 Logaritmid</h1>

    <p><strong>Logaritm</strong> on aste, mille kaudu tuleb baas tõsta, et saada antud arv. Seda kirjutatakse logₐb = c, mis tähendab aᶜ = b.</p>

    <div class="alert alert-success">
        Näide: log₂8 = <strong>3</strong>, kuna 2³ = 8
    </div>

    <p>Logaritmide põhiseadused:</p>
    <ul>
        <li>logₐ(b·c) = logₐb + logₐc</li>
        <li>logₐ(b/c) = logₐb - logₐc</li>
        <li>logₐ(bᶜ) = c·logₐb</li>
        <li>logₐa = 1</li>
        <li>logₐ1 = 0 (kui a > 0, a ≠ 1)</li>
    </ul>

    <p><strong>Eri tüüpi logaritmid:</strong></p>
    <div class="alert alert-warning">
        <ul>
            <li><strong>Kümnendlogaritm</strong> (lg) — baasil 10: lg100 = 2</li>
            <li><strong>Looduslogaritm</strong> (ln) — baasil e (≈2.718): lne = 1</li>
        </ul>
    </div>

    <p>🔍 Valem uue baasi jaoks:</p>
    <p class="text-center">logₐb = logₖb / logₖa</p>

    <p>📌 Rakendused:</p>
    <ul>
        <li>Näitajate lahendamine</li>
        <li>Ajalooliste protsesside analüüs (rahvaarvu kasv, radioaktiivne lagunemine)</li>
        <li>Finantsarvutused (komplekssed intressid)</li>
        <li>Heli intensiivsuse mõõtmine (desibellid)</li>
    </ul>

    <p>🧠 Nõuanne: Püüdke meeles pidada omadusi, kujutledes, et logaritm "lahustab" korrutamise/ jagamise liitmise/ lahutamiseks.</p>

    <p class="text-center mt-4">
        <a href="../tasks/topic8.php" class="btn btn-primary btn-lg fw-bold">Lähme ülesannete juurde 🚀</a>
    </p>
</div>
</body>
</html>
