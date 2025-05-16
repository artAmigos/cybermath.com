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
    <title>Lineaarsete võrrandite süsteemid - CyberMath</title>
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
        
        .method-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .method-title {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
        }
    </style>
</head>
<body class="container py-5 position-relative">

    <?php for ($i = 0; $i < 15; $i++): ?>
        <div class="emoji" style="left: <?= rand(0, 100) ?>%; top: <?= rand(10, 100) ?>px; animation-delay: <?= rand(0, 10) ?>s;">
            <?= ['📊','✖️','➕','➖','🔢','🧮','📐','🔍'][rand(0, 7)] ?>
        </div>
    <?php endfor; ?>

<div class="card mx-auto" style="max-width: 900px;">
    <h1 class="mb-4 text-center">📊 Lineaarsete võrrandite süsteemid</h1>

    <p><strong>Lineaarsete võrrandite süsteem</strong> on mitme võrrandi kogum, kus samad muutujad võtavad kõikides võrrandites süsteemis samu väärtusi. Süsteemi lahendus on muutujate väärtuste kogum, mis rahuldab kõiki võrrandeid korraga.</p>

    <div class="alert alert-success">
        Näide kaht muutujaga süsteemist:
        \[
        \begin{cases}
        2x + 3y = 5 \\
        x - y = 1
        \end{cases}
        \]
    </div>

    <h3 class="mt-4">Põhilised lahendamismeetodid:</h3>
    
    <div class="method-card">
        <div class="method-title">1. Asendamise meetod</div>
        <p>Väljendame ühe muutuja teise kaudu ühest võrrandist ja asendame selle teises võrrandis.</p>
        <p>Näide:</p>
        \[
        \begin{cases}
        x + y = 5 \\
        2x - y = 1
        \end{cases}
        \]
        <p>Esimesest võrrandist: \( x = 5 - y \). Asendame teise: \( 2(5 - y) - y = 1 \) → \( 10 - 3y = 1 \) → \( y = 3 \), \( x = 2 \).</p>
    </div>
    
    <div class="method-card">
        <div class="method-title">2. Liitmise meetod</div>
        <p>Liidame või lahutame süsteemi võrrandeid nii, et üks muutujatest kaoks.</p>
        <p>Näide:</p>
        \[
        \begin{cases}
        3x + 2y = 8 \\
        2x - 2y = 2
        \end{cases}
        \]
        <p>Liidame võrrandid: \( 5x = 10 \) → \( x = 2 \). Asendame esimeses: \( 6 + 2y = 8 \) → \( y = 1 \).</p>
    </div>
    
    <div class="method-card">
        <div class="method-title">3. Graafiline meetod</div>
        <p>Joonistame iga võrrandi graafikud ja leiame nende lõikepunkti.</p>
        <p>Näide:</p>
        \[
        \begin{cases}
        y = 2x - 1 \\
        y = -x + 5
        \end{cases}
        \]
        <p>Graafikute lõikepunkt (2, 3) — süsteemi lahendus.</p>
    </div>

    <h3 class="mt-4">Eriolukorrad:</h3>
    <ul>
        <li><strong>Ei ole lahendusi</strong> — võrrandid on omavahel vastuolus (paralleelsed sirged).</li>
        <li><strong>Piisavalt palju lahendusi</strong> — võrrandid on ekvivalentne (ühesugused sirged).</li>
    </ul>

    <div class="alert alert-warning">
        Näide süsteemist ilma lahendusteta:
        \[
        \begin{cases}
        x + y = 2 \\
        x + y = 5
        \end{cases}
        \]
    </div>

    <p>🧠 Soovitus: Kontrollige alati lahendust, asendades leitud väärtused algsetes võrrandites!</p>

    <p class="text-center mt-4">
        <a href="../tasks/topic10.php" class="btn btn-primary btn-lg fw-bold">Mine ülesannete juurde 🚀</a>
    </p>
</div>

<!-- MathJaxi jaoks matemaatiliste valemite kuvamiseks -->
<script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
<script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
</body>
</html>
