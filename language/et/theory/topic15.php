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
    <title>Trigonomeetria alused - CyberMath</title>
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
        
        .trig-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .trig-title {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .trig-img {
            width: 100%;
            max-width: 300px;
            border-radius: 8px;
            margin: 10px auto;
            display: block;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="container py-5 position-relative">

    <?php for ($i = 0; $i < 15; $i++): ?>
        <div class="emoji" style="left: <?= rand(0, 100) ?>%; top: <?= rand(10, 100) ?>px; animation-delay: <?= rand(0, 10) ?>s;">
            <?= ['📐','🔺','◢','◣','◥','◤','△','▽'][rand(0, 7)] ?>
        </div>
    <?php endfor; ?>

<div class="card mx-auto" style="max-width: 900px;">
    <h1 class="mb-4 text-center">📐 Trigonomeetria alused</h1>

    <p><strong>Trigonomeetria</strong> on matemaatika haru, mis uurib kolmnurga külgede ja nurkade suhteid, samuti trigonomeetrilisi funktsioone ja nende omadusi.</p>

    <div class="alert alert-success">
        Peamised mõisted:
        <ul>
            <li><strong>Õigekandiline kolmnurk</strong> — kolmnurk, millel on üks nurk 90°</li>
            <li><strong>Hüpotenuus</strong> — külg, mis asub vastas õigeks nurgaks</li>
            <li><strong>Katetid</strong> — kaks muud külge</li>
        </ul>
    </div>

    <div class="trig-card">
        <div class="trig-title">1. Peamised trigonomeetrilised funktsioonid</div>
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/8f/Trigonometry_triangle.svg/600px-Trigonometry_triangle.svg.png" alt="Õigekandiline kolmnurk" class="trig-img">
        <p>Õigekandilisele kolmnurgale nurga α puhul kehtivad järgmised seosed:</p>
        <ul>
            <li><strong>Sünoos</strong>: sin(α) = vastas katet / hüpotenuus</li>
            <li><strong>Kosünoos</strong>: cos(α) = külgne katet / hüpotenuus</li>
            <li><strong>Tangens</strong>: tan(α) = vastas katet / külgne katet</li>
        </ul>
    </div>

    <div class="trig-card">
        <div class="trig-title">2. Peamised trigonomeetrilised identiteedid</div>
        <ul>
            <li>sin²(α) + cos²(α) = 1</li>
            <li>tan(α) = sin(α)/cos(α)</li>
            <li>1 + tan²(α) = 1/cos²(α)</li>
            <li>1 + cot²(α) = 1/sin²(α)</li>
        </ul>
    </div>

    <div class="trig-card">
        <div class="trig-title">3. Väärtused standardnurkade jaoks</div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nurk</th>
                    <th>sin</th>
                    <th>cos</th>
                    <th>tan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>0°</td>
                    <td>0</td>
                    <td>1</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>30°</td>
                    <td>1/2</td>
                    <td>√3/2</td>
                    <td>√3/3</td>
                </tr>
                <tr>
                    <td>45°</td>
                    <td>√2/2</td>
                    <td>√2/2</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>60°</td>
                    <td>√3/2</td>
                    <td>1/2</td>
                    <td>√3</td>
                </tr>
                <tr>
                    <td>90°</td>
                    <td>1</td>
                    <td>0</td>
                    <td>∞</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="alert alert-warning">
        <strong>Oluline!</strong> Trigonomeetria rakendub järgmistes valdkondades:
        <ul>
            <li>Füüsika (võnkumised, lained)</li>
            <li>Inseneriteadus (ehitusarvutused)</li>
            <li>Arvutigraafika</li>
            <li>Navigeerimine ja astronoomia</li>
        </ul>
    </div>

    <p class="text-center mt-4">
        <a href="../tasks/topic15.php" class="btn btn-primary btn-lg fw-bold">Mine ülesannete juurde 🚀</a>
    </p>
</div>
</body>
</html>
