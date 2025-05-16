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
    <title>Progressioonid - CyberMath</title>
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
            <?= ['🔢','✨','🧠','➗','✖️','📈','📉','∞'][rand(0, 7)] ?>
        </div>
    <?php endfor; ?>

<div class="card mx-auto" style="max-width: 900px;">
    <h1 class="mb-4 text-center">📘 Aritmeetilised ja geomeetrilised progressioonid</h1>

    <p><strong>Aritmeetiline progressioon</strong> on arvude järjestus, kus iga järgnev arv erineb eelmisest ühe ja sama suuruse võrra (progressiooni vahe).</p>

    <div class="alert alert-success">
        Näide: 2, 5, 8, 11, 14... (vahe d = 3)
    </div>

    <p>Aritmeetilise progressiooni põhivormelid:</p>
    <ul>
        <li><strong>n. liige:</strong> aₙ = a₁ + d(n-1)</li>
        <li><strong>Summa n liikmest:</strong> Sₙ = (a₁ + aₙ)·n/2</li>
    </ul>

    <p><strong>Geomeetriline progressioon</strong> on järjestus, kus iga järgnev arv saadakse eelmist arvu korrutades püsiva arvuga (progressiooni nimetaja).</p>

    <div class="alert alert-warning">
        Näide: 3, 6, 12, 24, 48... (nimetaja q = 2)
    </div>

    <p>Geomeetrilise progressiooni põhivormelid:</p>
    <ul>
        <li><strong>n. liige:</strong> bₙ = b₁·qⁿ⁻¹</li>
        <li><strong>Summa n liikmest:</strong> Sₙ = b₁(qⁿ - 1)/(q - 1)</li>
    </ul>

    <p>🔍 Peamised erinevused:</p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Omadus</th>
                <th>Aritmeetiline</th>
                <th>Geomeetriline</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Muutus</td>
                <td>Lisamine vahega</td>
                <td>Korrutamine nimetajaga</td>
            </tr>
            <tr>
                <td>Näide</td>
                <td>5, 8, 11, 14...</td>
                <td>5, 10, 20, 40...</td>
            </tr>
            <tr>
                <td>Graafik</td>
                <td>Sirge kasv</td>
                <td>Eksponentsiaalne kasv</td>
            </tr>
        </tbody>
    </table>

    <p>📌 Rakenduse näited:</p>
    <ul>
        <li>Aritmeetiline: lihtsad protsendid, ühtlane liikumine</li>
        <li>Geomeetriline: keerulised protsendid pankades, bakterite populatsiooni kasv</li>
    </ul>

    <p>🧠 Nõuanne: Formule meeldejätmiseks kujutlege reaalseid olukordi — näiteks panga sissemakse kasvu (geomeetriline) või igapäevase sõidukilomeetri kasvu ühesugustes sammudes (aritmeetiline).</p>

    <p class="text-center mt-4">
        <a href="../tasks/topic6.php" class="btn btn-primary btn-lg fw-bold">Mine ülesannete juurde 🚀</a>
    </p>
</div>
</body>
</html>
