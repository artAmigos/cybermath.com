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
    <title>Pythagorase teoreem - CyberMath</title>
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
        
        .triangle-img {
            max-width: 300px;
            margin: 20px auto;
            display: block;
        }
    </style>
</head>
<body class="container py-5 position-relative">

    <?php for ($i = 0; $i < 15; $i++): ?>
        <div class="emoji" style="left: <?= rand(0, 100) ?>%; top: <?= rand(10, 100) ?>px; animation-delay: <?= rand(0, 10) ?>s;">
            <?= ['📐','△','🔺','📏','🧮','🔢','✨','🧠'][rand(0, 7)] ?>
        </div>
    <?php endfor; ?>

    <div class="card mx-auto" style="max-width: 900px;">
        <h1 class="mb-4 text-center">📐 Pythagorase teoreem</h1>

        <p><strong>Pythagorase teoreem</strong> on üks geomeetria põhiväiteid, mis seob ristkülikukujulise kolmnurga külgede pikkuseid. See teoreem on äärmiselt oluline arhitektuuris, ehituses, navigatsioonis ja paljudes teistes valdkondades.</p>

        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d2/Pythagorean.svg/300px-Pythagorean.svg.png" alt="Ristkülikukujuline kolmnurk" class="triangle-img">

        <div class="alert alert-success">
            <strong>Valem:</strong> Ristkülikukujulises kolmnurgas on hüpotenuusi ruut külgede ruutude summaga võrdelne.<br>
            c² = a² + b²
        </div>

        <p>Kus:</p>
        <ul>
            <li><strong>a, b</strong> — küljed (külgedel, mis moodustavad täisnurga)</li>
            <li><strong>c</strong> — hüpotenuus (külg, mis on vastupidine täisnurga nurk)</li>
        </ul>

        <p>🔍 <strong>Näide rakendamisest:</strong> Kui üks küljest on 3 cm ja teine 4 cm, siis hüpotenuus on:</p>
        <div class="alert alert-warning">
            c² = 3² + 4² = 9 + 16 = 25<br>
            c = √25 = 5 cm
        </div>

        <p>📌 <strong>Ajalooline fakt:</strong> Kuigi teoreem kannab nime Vana-Kreeka matemaatiku Pythagorase järgi, oli see teada ja kasutusel juba enne teda Mesopotaamias, Egiptuses ja Indias.</p>

        <p>🧠 <strong>Praktiline rakendus:</strong></p>
        <ul>
            <li>Kauguste arvutamine tasapinnal</li>
            <li>Õige nurga kontrollimine ehituses</li>
            <li>Õigekandil oleva diagonaali pikkuse määramine</li>
            <li>Navigation ja marsuutide arvutamine</li>
        </ul>

        <p>⚠️ <strong>Oluline meeles pidada:</strong> Teoreem kehtib ainult ristkülikukujuliste kolmnurkade jaoks! Teiste kolmnurkade jaoks on olemas muud külgede vaheline suhted.</p>

        <p class="text-center mt-4">
            <a href="../tasks/topic17.php" class="btn btn-primary btn-lg fw-bold">Läbige näited 🚀</a>
        </p>
    </div>
</body>
</html>
