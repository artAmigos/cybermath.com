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
    <title>Koordinaatide tasand - CyberMath</title>
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
            <?= ['📊','📍','📐','➕','➖','📘','🚀','🧮'][rand(0, 7)] ?>
        </div>
    <?php endfor; ?>

<div class="card mx-auto" style="max-width: 900px;">
    <h1 class="mb-4 text-center">📘 Koordinaatide tasand</h1>

    <p><strong>Koordinaatide tasand</strong> on kahemõõtmeline tasand, mille moodustavad kaks risti olevat telge: horisontaalne (X-telg) ja vertikaalne (Y-telg). Telgede ristumiskohta nimetatakse koordinaatide alguspunktiks (0,0).</p>

    <div class="alert alert-success">
        Näide: Punkt A(3, 2) asub 3 ühiku võrra paremal ja 2 ühiku võrra kõrgemal alguspunktist
    </div>

    <p><strong>Põhielemendid:</strong></p>
    <ul>
        <li><strong>Abstsisside telg (X)</strong> — horisontaalne telg</li>
        <li><strong>Ordinatiivide telg (Y)</strong> — vertikaalne telg</li>
        <li><strong>Punkti koordinaadid</strong> — kaht numbrit (x, y), mis määravad punkti asukoha</li>
        <li><strong>Koordinaatide tasandi kvadrandid</strong> — 4 ala, kuhu teljed jagavad tasandi</li>
    </ul>

    <p><strong>Koordinaatide tasandi kvadrandid:</strong></p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kvadrant</th>
                <th>Koordinaatide märgid</th>
                <th>Näide</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>I</td>
                <td>(+, +)</td>
                <td>(2, 3)</td>
            </tr>
            <tr>
                <td>II</td>
                <td>(-, +)</td>
                <td>(-1, 4)</td>
            </tr>
            <tr>
                <td>III</td>
                <td>(-, -)</td>
                <td>(-3, -2)</td>
            </tr>
            <tr>
                <td>IV</td>
                <td>(+, -)</td>
                <td>(5, -1)</td>
            </tr>
        </tbody>
    </table>

    <p><strong>Kuidas joonistada punkti koordinaatide järgi:</strong></p>
    <ol>
        <li>Leia x väärtus X-teljel</li>
        <li>Leia y väärtus Y-teljel</li>
        <li>Tõmba perpendikulaarid nende punktide kaudu</li>
        <li>Punktide lõikepunkt on soovitud punkt</li>
    </ol>

    <div class="alert alert-warning">
        <strong>Punktide vaheline kaugus:</strong><br>
        Punktide A(x₁, y₁) ja B(x₂, y₂) puhul:<br>
        d = √[(x₂ - x₁)² + (y₂ - y₁)²]
    </div>

    <p>📌 Kus kasutatakse:</p>
    <ul>
        <li>Funktsioonide graafikutel</li>
        <li>Arvutigraafikas</li>
        <li>Navigeerimises ja kaardistamises</li>
        <li>Füüsikas liikumise kirjeldamiseks</li>
    </ul>

    <p>🧠 Nõuanne: Koordinaatide järjekorra meeldejätmiseks kasuta fraasi "Ehk Y, alguses mööda koridori, siis mööda treppe".</p>

    <p class="text-center mt-4">
        <a href="../tasks/topic16.php" class="btn btn-primary btn-lg fw-bold">Liigu ülesannete juurde 🚀</a>
    </p>
</div>
</body>
</html>
