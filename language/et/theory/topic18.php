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
    <title>Geomeetrilised kujundid - CyberMath</title>
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
        
        .shape-img {
            max-width: 200px;
            margin: 15px auto;
            display: block;
        }
        
        .shape-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin: 20px 0;
        }
        
        .shape-card {
            width: 30%;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body class="container py-5 position-relative">

    <?php for ($i = 0; $i < 15; $i++): ?>
        <div class="emoji" style="left: <?= rand(0, 100) ?>%; top: <?= rand(10, 100) ?>px; animation-delay: <?= rand(0, 10) ?>s;">
            <?= ['🔺','🔵','◼️','📐','🔶','🔷','🟥','🟦'][rand(0, 7)] ?>
        </div>
    <?php endfor; ?>

    <div class="card mx-auto" style="max-width: 900px;">
        <h1 class="mb-4 text-center">🔷 Geomeetrilised kujundid</h1>

        <p><strong>Geomeetrilised kujundid</strong> on punktide, joonte või pindade kogumid, mis moodustavad suletud kujundeid. Need ümbritsevad meid kõikjal: lihtsatest esemetest kuni keerukate arhitektuuriliste ehitisteni.</p>

        <div class="alert alert-success">
            <strong>Põhilised kujundite liigid:</strong>
            <ul>
                <li>Tasapinnalised (kahemõõtmelised) — eksisteerivad tasapinnal</li>
                <li>Ruumilised (kolmemõõtmelised) — eksisteerivad ruumis</li>
            </ul>
        </div>

        <h3 class="mt-4">🔹 Põhilised tasapinnalised kujundid</h3>
        
        <div class="shape-container">
            <div class="shape-card">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3c/Circle-withsegments.svg/200px-Circle-withsegments.svg.png" alt="Ring" class="shape-img">
                <strong>Ring</strong>
                <p>Kõik punktid tasapinnal, mis on võrdselt kaugel keskpunktist</p>
            </div>
            <div class="shape-card">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/0c/Square_-_black_simple.svg/200px-Square_-_black_simple.svg.png" alt="Ruut" class="shape-img">
                <strong>Ruut</strong>
                <p>Neljnurk, millel on võrdsed küljed ja nurgad</p>
            </div>
            <div class="shape-card">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Regular_triangle.svg/200px-Regular_triangle.svg.png" alt="Kolmnurk" class="shape-img">
                <strong>Kolmnurk</strong>
                <p>Kuju, millel on kolm külge ja kolm nurka</p>
            </div>
        </div>

        <h3 class="mt-4">🔶 Põhilised ruumilised kujundid</h3>
        
        <div class="shape-container">
            <div class="shape-card">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3f/Sphere_-_black_simple.svg/200px-Sphere_-_black_simple.svg.png" alt="Kuup" class="shape-img">
                <strong>Kuup</strong>
                <p>Keha, mille kõik punktid on võrdselt kaugel keskpunktist</p>
            </div>
            <div class="shape-card">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2e/Cube_-_black_simple.svg/200px-Cube_-_black_simple.svg.png" alt="Kuup" class="shape-img">
                <strong>Kuup</strong>
                <p>Õige mitmemõõtmeline keha, millel on 6 ruudukujulist pinda</p>
            </div>
            <div class="shape-card">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/33/Cylinder_-_black_simple.svg/200px-Cylinder_-_black_simple.svg.png" alt="Silinder" class="shape-img">
                <strong>Silinder</strong>
                <p>Keha, mis on piiratud silindrilise pinnaga</p>
            </div>
        </div>

        <div class="alert alert-warning mt-4">
            <strong>Huvitav fakt:</strong> Looduses esinevad sageli ideaalsed geomeetrilised kujundid. Näiteks mesilaste kärjed moodustavad täiuslikke kuuekülgseid kujundeid ja mullid püüdlevad kuuli kuju poole.
        </div>

        <p class="text-center mt-4">
            <a href="../tasks/topic18.php" class="btn btn-primary btn-lg fw-bold">Liigu näidete juurde 🚀</a>
        </p>
    </div>
</body>
</html>
