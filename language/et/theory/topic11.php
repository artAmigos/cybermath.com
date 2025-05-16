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
    <title>Ruutfunktsioonid - CyberMath</title>
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
            <?= ['🔢','✨','🧠','x²','Δ','=','➗','√'][rand(0, 7)] ?>
        </div>
    <?php endfor; ?>

<div class="card mx-auto" style="max-width: 900px;">
    <h1 class="mb-4 text-center">📘 Ruutfunktsioonid ja diskriminant</h1>

    <p><strong>Ruutfunktsioon</strong> on võrrand kujul ax² + bx + c = 0, kus a ≠ 0. Selle lahendamiseks kasutatakse diskriminanti (D), mis määrab juurte arvu ja tüübi.</p>

    <div class="alert alert-success">
        Näide: x² - 5x + 6 = 0 → D = 1, juured: <strong>2 ja 3</strong>
    </div>

    <p><strong>Diskriminandi valem:</strong></p>
    <p class="text-center">D = b² - 4ac</p>

    <p><strong>Lahendite tüübid sõltuvalt D-st:</strong></p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Diskriminant</th>
                <th>Juurte arv</th>
                <th>Juurte valem</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>D > 0</td>
                <td>2 erinevat</td>
                <td>x = (-b ± √D)/2a</td>
            </tr>
            <tr>
                <td>D = 0</td>
                <td>1 (korduv)</td>
                <td>x = -b/2a</td>
            </tr>
            <tr>
                <td>D < 0</td>
                <td>Puuduvad reaalsed juured</td>
                <td>-</td>
            </tr>
        </tbody>
    </table>

    <p><strong>Lahendamise algoritm:</strong></p>
    <ol>
        <li>Viige võrrand standardvormi</li>
        <li>Arvutage diskriminant</li>
        <li>Määrake juurte arv</li>
        <li>Leidke juured valemi järgi (kui need on olemas)</li>
    </ol>

    <div class="alert alert-warning">
        <strong>Täieliku lahenduse näide:</strong><br>
        2x² - 4x - 6 = 0<br>
        1. D = (-4)² - 4·2·(-6) = 16 + 48 = 64<br>
        2. D > 0 → 2 juurt<br>
        3. x = (4 ± √64)/4 = (4 ± 8)/4<br>
        4. x₁ = 3, x₂ = -1
    </div>

    <p>📌 Kus kasutatakse:</p>
    <ul>
        <li>Füüsikas (trajektooride arvutamine)</li>
        <li>Majanduses (kasumi maksimeerimine)</li>
        <li>Arhitektuuris (konstruktsioonide arvutamine)</li>
        <li>Arvutigraafikas</li>
    </ul>

    <p>🧠 Nõuanne: Kontrollige alati koefitsientide märke diskriminandi arvutamisel!</p>

    <p class="text-center mt-4">
        <a href="../tasks/topic11.php" class="btn btn-primary btn-lg fw-bold">Mine näidete juurde 🚀</a>
    </p>
</div>
</body>
</html>
