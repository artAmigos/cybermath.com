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
    <title>Liitmine ja lahutamine - CyberMath</title>
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
            <?= ['🔢','✨','🧠','➕','➖','📘','🚀','🧮'][rand(0, 7)] ?>
        </div>
    <?php endfor; ?>

<div class="card mx-auto" style="max-width: 900px;">
    <h1 class="mb-4 text-center">📘 Liitmine ja lahutamine</h1>

    <p><strong>Liitmine</strong> on üks põhitehteid matemaatikas, mille abil liidetakse kaks või enam arvu üheks üldiseks summaks. Seda kasutatakse igapäevaselt: poes, retseptides, programmeerimises, raamatupidamises ja mujal.</p>

    <div class="alert alert-success">
        Näide: 3 + 5 = <strong>8</strong>
    </div>

    <p>Liitmine tähendab: <strong>a + b = b + a</strong>. S.o. liidetavate järjekord ei mõjuta tulemust.</p>

    <p>Samuti: <strong>(a + b) + c = a + (b + c)</strong>. See on kasulik, kui liita rohkem kui kaks arvu — võib liita suvalises järjekorras.</p>

    <p><strong>Lahutamine</strong> on liitmise vastand. See näitab, kui palju üks arv on teisest suurem või väiksem. Igapäevaselt kasutatakse lahutamist näiteks raha tagastamisel või erinevuste leidmisel väärtuste vahel.</p>

    <div class="alert alert-warning">
        Näide: 9 - 4 = <strong>5</strong>
    </div>

    <p>Erinevalt liitmisest: <strong>9 - 4 ≠ 4 - 9</strong>.</p>

    <p>🔍 Lahutamise puhul on oluline meeles pidada:</p>
    <ul>
        <li>Kui <strong>vähendatav</strong> on väiksem kui <strong>lahutatav</strong>, siis on tulemus negatiivne.</li>
        <li>Negatiivseid arve kasutatakse päriselus — näiteks kui võlad ületavad vara või temperatuur on alla nulli.</li>
    </ul>

    <p>📌 Mõned lisavõtted:</p>
    <ul>
        <li>12 + 15 = 27</li>
        <li>20 - 7 = 13</li>
        <li>5 - 10 = -5</li>
    </ul>

    <p>🧠 Nõuanne: Harjuta peast liitmist ja lahutamist — see aitab kiiremini mõelda ja paremini numbrites orienteeruda.</p>

    <p class="text-center mt-4">
        <a href="../tasks/topic1.php" class="btn btn-primary btn-lg fw-bold">Mine ülesannete juurde 🚀</a>
    </p>
</div>
</body>
</html>
