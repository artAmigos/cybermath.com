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
    <title>Funktsioonide graafikud - CyberMath</title>
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
        
        .graph-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .graph-title {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .graph-img {
            width: 100%;
            border-radius: 8px;
            margin: 10px 0;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="container py-5 position-relative">

    <?php for ($i = 0; $i < 15; $i++): ?>
        <div class="emoji" style="left: <?= rand(0, 100) ?>%; top: <?= rand(10, 100) ?>px; animation-delay: <?= rand(0, 10) ?>s;">
            <?= ['📈','📉','📊','🧮','🔢','📐','🔍','ƒ(x)'][rand(0, 7)] ?>
        </div>
    <?php endfor; ?>

<div class="card mx-auto" style="max-width: 900px;">
    <h1 class="mb-4 text-center">📈 Funktsioonide graafikud</h1>

    <p><strong>Funktsiooni graafik</strong> on visuaalne esitusmuutus, mis näitab muutujatevahelist seost. See võimaldab visuaalselt näha funktsiooni käitumist, omadusi ja eripärasid.</p>

    <div class="alert alert-success">
        Graafiku peamised elemendid:
        <ul>
            <li><strong>Abstsisside telg (OX)</strong> — horisontaalne telg, tavaliselt sõltumatu muutujale</li>
            <li><strong>Ordinaatide telg (OY)</strong> — vertikaalne telg, tavaliselt sõltuvale muutujale</li>
            <li><strong>Graafiku punktid</strong> — paarid (x, f(x))</li>
        </ul>
    </div>

    <div class="graph-card">
        <div class="graph-title">1. Lineaarne funktsioon: y = kx + b</div>
        <img src="/cybermath.com/assets/liniearf.png" alt="Lineaarse funktsiooni graafik" class="graph-img">

        <p>Graafik on sirge joon. <code>k</code> on nurkkoefitsient (kaldenurk), <code>b</code> on lõikepunkt Y-teljega.</p>
        <div class="alert alert-info">
            Näide: y = 2x + 1<br>
            Kaldenurk: 2 (graafik tõuseb 2 ühiku võrra ülespoole iga 1 ühiku liikumise kohta paremale)<br>
            Lõikepunkt Y-teljega: (0, 1)
        </div>
    </div>

    <div class="graph-card">
        <div class="graph-title">2. Ruutfunktsioon: y = ax² + bx + c</div>
        <img src="https://www.mathsisfun.com/algebra/images/quadratic-graph.svg" alt="Ruutfunktsiooni graafik" class="graph-img">
        <p>Graafik on parabool. Kui <code>a > 0</code>, siis harud on ülespoole, kui <code>a < 0</code>, siis harud allapoole.</p>
        <p>Parabooli tipp asub punktis: <code>x = -b/(2a)</code></p>
    </div>

    <div class="graph-card">
        <div class="graph-title">3. Pöördvõrdeline sõltuvus: y = k/x</div>
        <img src="/cybermath.com/assets/revers.png" alt="Pöördvõrdeline graafik" class="graph-img">
        <p>Graafik on hüperbool. Funktsioon ei ole määratud, kui <code>x = 0</code>.</p>
    </div>

    <div class="graph-card">
        <div class="graph-title">4. Eksponentsiaalne funktsioon: y = aˣ</div>
        <img src="/cybermath.com/assets/graph_function.png" alt="Eksponentsiaalse funktsiooni graafik" class="graph-img">
        <p>Kui <code>a > 1</code>, siis funktsioon suureneb, kui <code>0 < a < 1</code>, siis väheneb.</p>
        <p>Graafik läbib alati punkti (0,1), kuna a⁰ = 1.</p>
    </div>

    <h3 class="mt-4">Kuidas joonistada graafikuid?</h3>
    <ol>
        <li>Koosta väärtustabel (x ja y)</li>
        <li>Markeerige punktid koordinaatide tasapinnal</li>
        <li>Ühendage punktid sujuva joontega</li>
        <li>Kontrollige erilisi punkte (lõikepunktid telgedega, tipp-punktid)</li>
    </ol>

    <div class="alert alert-warning">
        <strong>Tähtis!</strong> Pöörake tähelepanu järgmisele:
        <ul>
            <li>Funktsiooni määramispiirkond</li>
            <li>Funktsiooni käitumine lõpmatuses</li>
            <li>Katkestuspunktid ja asümptoodid</li>
        </ul>
    </div>

    <p class="text-center mt-4">
        <a href="../tasks/topic14.php" class="btn btn-primary btn-lg fw-bold">Läbige ülesandeid 🚀</a>
    </p>
</div>
</body>
</html>
