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
    <title>Protsendid - CyberMath</title>
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
            <?= ['🔢','✨','🧠','%','💰','📈','📉','🧮'][rand(0, 7)] ?>
        </div>
    <?php endfor; ?>

<div class="card mx-auto" style="max-width: 900px;">
    <h1 class="mb-4 text-center">📘 Protsendid</h1>

    <p><strong>Protsent</strong> on ühe sajandiku osa arvust. Seda tähistatakse % märgiga. Protsente kasutatakse igapäevaelus laialdaselt: pangaarvestustes, allahindlustes, statistikas ja paljus muus.</p>

    <div class="alert alert-success">
        Näide: 1% 200-st = <strong>2</strong> (sest 200 ÷ 100 = 2)
    </div>

    <p>Põhiteadmised:</p>
    <ul>
        <li><strong>Protsent</strong> — üks sajandik (1% = 1/100 = 0,01)</li>
        <li><strong>Baasarv</strong> — number, mille põhjal protsendid arvutatakse</li>
        <li><strong>Protsendiväärtus</strong> — protsendi arvutamise tulemus baasarvust</li>
    </ul>

    <p><strong>Peamised protsentülesannete tüübid:</strong></p>
    <ol>
        <li>Leida protsent arvust</li>
        <li>Leida number protsendi järgi</li>
        <li>Leida protsentuaalne suhe kahe arvu vahel</li>
    </ol>

    <div class="alert alert-warning">
        Protsendi leidmise valem: <strong>number × protsent / 100</strong><br>
        Näide: 15% 300-st = 300 × 15 / 100 = 45
    </div>

    <p>🔍 Kasulikud nõuanded:</p>
    <ul>
        <li>Arvu suurendamiseks protsendi võrra tuleb seda korrutada (1 + protsent/100)</li>
        <li>Arvu vähendamiseks protsendi võrra tuleb seda korrutada (1 - protsent/100)</li>
        <li>Protsente saab liita ja lahutada ainult ühe ja sama baasarvu puhul</li>
    </ul>

    <p>📌 Näited igapäevaelust:</p>
    <ul>
        <li>Allahindlus 20% toote hinnast 50 €: 50 × 0.20 = 10 € (uus hind: 40 €)</li>
        <li>Pangakonto intress 5% aastas summalt 1000 €: 1000 × 0.05 = 50 € tulu aastas</li>
        <li>Maks 15% sissetulekult 2000 €: 2000 × 0.15 = 300 €</li>
    </ul>

    <p>🧠 Nõuanne: Mõnede protsentide kiireks arvutamiseks saab kasutada murde: 50% = ½, 25% = ¼, 10% = 1/10 jne.</p>

    <p class="text-center mt-4">
        <a href="../tasks/topic5.php" class="btn btn-primary btn-lg fw-bold">Mine näidete juurde 🚀</a>
    </p>
</div>
</body>
</html>
