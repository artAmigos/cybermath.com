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
    <title>Korrutamine ja jagamine - CyberMath</title>
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
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 0.8; }
            100% { transform: translateY(-200px) rotate(360deg); opacity: 0; }
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
            <?= ['✖️','➗','🧠','📘','📐','🧮','🔥','🚀'][rand(0, 7)] ?>
        </div>
    <?php endfor; ?>

    <div class="card mx-auto" style="max-width: 900px;">
        <h1 class="mb-4 text-center">📘 Korrutamine ja jagamine</h1>

        <p><strong>Korrutamine</strong> tähendab ühe ja sama arvu korduvalt liitmist. Näiteks 3 × 4 tähendab, et liidame 3 neli korda: 3 + 3 + 3 + 3 = 12.</p>

        <div class="alert alert-success">
            Näide: 6 × 7 = <strong>42</strong>
        </div>

        <p>Korrutamise põhiomadused:</p>
        <ul>
            <li><strong>Vahetuvus:</strong> a × b = b × a</li>
            <li><strong>Koonduvus:</strong> (a × b) × c = a × (b × c)</li>
        </ul>

        <p><strong>Jagamine</strong> on korrutamise vastandtehe. See näitab, mitmeks võrdseks osaks saab mingi arvu jagada.</p>

        <div class="alert alert-warning">
            Näide: 12 ÷ 3 = <strong>4</strong>
        </div>

        <p>Kui jagatav on väiksem kui jagaja, on tulemus väiksem kui 1 (või täisarvudes võrdub 0).</p>

        <p>💡 Nõuanne: Korrutustabel on sinu parim sõber! Õpi see pähe, et saaksid kiiremini ülesandeid lahendada.</p>

        <p class="text-center mt-4">
            <a href="../tasks/topic2.php" class="btn btn-primary btn-lg fw-bold">Mine ülesannete juurde 🚀</a>
        </p>
    </div>
</body>
</html>
