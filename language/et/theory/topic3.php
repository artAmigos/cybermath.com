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
    <title>Arvude tüübid - CyberMath</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #fdfbfb, #ebedee);
            position: relative;
            overflow-x: hidden;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #2d3436;
        }

        .card {
            background: #ffffffdd;
            border: none;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .emoji {
            position: absolute;
            font-size: 2rem;
            animation: float 12s infinite linear;
            opacity: 0.8;
        }

        @keyframes float {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% { opacity: 0.9; }
            100% {
                transform: translateY(-200px) rotate(360deg);
                opacity: 0;
            }
        }

        .btn-primary {
            background-color: #00b894;
            border: none;
        }

        .btn-primary:hover {
            background-color: #00a383;
        }
    </style>
</head>
<body class="container py-5 position-relative">

    <?php for ($i = 0; $i < 15; $i++): ?>
        <div class="emoji" style="left: <?= rand(0, 100) ?>%; top: <?= rand(50, 500) ?>px; animation-delay: <?= rand(0, 10) ?>s;">
            <?= ['🔢','🔍','📘','➗','➕','🧠','📚','💡'][rand(0, 7)] ?>
        </div>
    <?php endfor; ?>

    <div class="card mx-auto" style="max-width: 900px;">
    <h1 class="mb-4 text-center">📘 Naturaalarvud, täisarvud, ratsionaalsed ja irratsionaalsed arvud</h1>

    <p><strong>Naturaalarvud</strong> — need on positiivsed täisarvud, mida me kasutame loendamiseks: 1, 2, 3, 4, ...</p>

    <p><strong>Täisarvud</strong> — need on naturaalarvud, null ja nende negatiivsed vasted: ..., -3, -2, -1, 0, 1, 2, 3, ...</p>

    <p><strong>Ratsionaalsed arvud</strong> — need on arvud, mida saab väljendada murduna <em>a/b</em>, kus <em>a</em> ja <em>b</em> on täisarvud ning <em>b ≠ 0</em>. Näited: 1/2, -3, 0.75</p>

    <p><strong>Irratsionaalsed arvud</strong> — need on arvud, mida <em>ei saa</em> väljendada murduna. Neil on lõpmatu, kordumatu kümnendsüsteemi esitus. Näited: √2, π</p>

    <div class="alert alert-success">
        💡 Näide:  
        <ul>
            <li>5 — naturaalarv, täisarv ja ratsionaalne arv</li>
            <li>-7 — täisarv ja ratsionaalne arv</li>
            <li>1/3 — ratsionaalne arv</li>
            <li>√2 — irratsionaalne arv</li>
        </ul>
    </div>

    <p>🧠 Nipp: et teha kindlaks arvutüüp — mõtle, kas seda saab väljendada murduna ning kas sellel on lõplik või lõputu korduv kümnendkujuline esitus.</p>

        <p class="text-center mt-4">
            <a href="../tasks/topic3.php" class="btn btn-primary btn-lg fw-bold">Mine näidete juurde 🚀</a>
        </p>
    </div>
</body>
</html>
