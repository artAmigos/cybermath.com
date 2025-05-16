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
    <title>Astmed ja juured - CyberMath</title>
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
            <?= ['🔢','✨','🧠','√','^','²','³','∞'][rand(0, 7)] ?>
        </div>
    <?php endfor; ?>

<div class="card mx-auto" style="max-width: 900px;">
    <h1 class="mb-4 text-center">📘 Astmed ja juured</h1>

    <p><strong>Arvu astendamine</strong> on arvu korrutamine iseendaga mitu korda. Seda kirjutatakse kui aⁿ, kus a on alus ja n on astme näitaja.</p>

    <div class="alert alert-success">
        Näide: 2³ = 2 × 2 × 2 = <strong>8</strong>
    </div>

    <p>Peamised astmete omadused:</p>
    <ul>
        <li>aⁿ × aᵐ = aⁿ⁺ᵐ</li>
        <li>aⁿ ÷ aᵐ = aⁿ⁻ᵐ</li>
        <li>(aⁿ)ᵐ = aⁿᵐ</li>
        <li>a⁻ⁿ = 1/aⁿ</li>
        <li>a⁰ = 1 (kui a ≠ 0)</li>
    </ul>

    <p><strong>Juure astendamine</strong> arvu a n. juurest on arv, mille n. astme väärtus on a. Seda tähistatakse kui ⁿ√a.</p>

    <div class="alert alert-warning">
        Näide: ³√8 = <strong>2</strong>, sest 2³ = 8
    </div>

    <p>Juure omadused:</p>
    <ul>
        <li>ⁿ√(a × b) = ⁿ√a × ⁿ√b</li>
        <li>ⁿ√(a ÷ b) = ⁿ√a ÷ ⁿ√b</li>
        <li>(ⁿ√a)ᵐ = ⁿ√(aᵐ)</li>
        <li>ⁿ√ᵐ√a = ᵐⁿ√a</li>
    </ul>

    <p>🔍 Erilised juhtumid:</p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tüüp</th>
                <th>Näide</th>
                <th>Selgitus</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Ruudujuur</td>
                <td>√9 = 3</td>
                <td>2. astme juur (tavaliselt ei kirjutata numbrit 2)</td>
            </tr>
            <tr>
                <td>Kuubikujuur</td>
                <td>³√27 = 3</td>
                <td>3. astme juur</td>
            </tr>
            <tr>
                <td>Juur astmest</td>
                <td>√(4²) = 4</td>
                <td>Kui n = m, siis juur ja aste tühistuvad</td>
            </tr>
        </tbody>
    </table>

    <p>📌 Rakenduse näited:</p>
    <ul>
        <li>Pindalade (ruudud) ja mahtude (kuubid) arvutamine</li>
        <li>Võrrandite ja füüsikaliste valemite lahendamine</li>
        <li>Finantsarvutused koos liitintressidega</li>
    </ul>

    <p>🧠 Nõuanne: Kiireks ruutude ja kuubikute arvutamiseks kuni 20 ja 10-le on kasulik õppida astmete tabelit pähe.</p>

    <p class="text-center mt-4">
        <a href="../tasks/topic7.php" class="btn btn-primary btn-lg fw-bold">Liigu ülesannete juurde 🚀</a>
    </p>
</div>
</body>
</html>
