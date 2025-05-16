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
    <title>Muutuja ja funktsioon - CyberMath</title>
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
        
        .concept-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .concept-title {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        code {
            background: #f8f9fa;
            padding: 2px 5px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
        }
    </style>
</head>
<body class="container py-5 position-relative">

    <?php for ($i = 0; $i < 15; $i++): ?>
        <div class="emoji" style="left: <?= rand(0, 100) ?>%; top: <?= rand(10, 100) ?>px; animation-delay: <?= rand(0, 10) ?>s;">
            <?= ['📊','ƒ(x)','x','y','🔢','🧮','📐','🔍'][rand(0, 7)] ?>
        </div>
    <?php endfor; ?>

<div class="card mx-auto" style="max-width: 900px;">
    <h1 class="mb-4 text-center">ƒ(x) Muutuja ja funktsioon</h1>

    <div class="concept-card">
        <div class="concept-title">📌 Mis on muutuja?</div>
        <p><strong>Muutuja</strong> on sümbol (tavaliselt täht), mis esindab matemaatikas tundmatut või muutuvat väärtust. Muutujad võimaldavad kirjutada üldisi reegleid ja valemeid.</p>
        
        <div class="alert alert-success">
            Muutujate kasutamise näited:
            <ul>
                <li>Ristküliku pindala valem: <code>S = a × b</code></li>
                <li>Sirge võrrand: <code>y = kx + b</code></li>
            </ul>
        </div>
        
        <p>Muutujad võivad võtta erinevaid väärtusi sõltuvalt ülesande tingimustest. Näiteks võrrandis <code>2x + 3 = 7</code> võtab muutuja <code>x</code> väärtuse 2.</p>
    </div>

    <div class="concept-card">
        <div class="concept-title">🧮 Mis on funktsioon?</div>
        <p><strong>Funktsioon</strong> on ühe muutuja (tavaliselt <code>y</code>) sõltuvus teisest muutujast (tavaliselt <code>x</code>), kus iga <code>x</code> väärtuse kohta on kindel <code>y</code> väärtus.</p>
        
        <p>Funktsioone kirjutatakse tavaliselt kujul: <code>y = f(x)</code>, kus <code>f</code> on reegel, mille järgi <code>x</code> muudetakse <code>y</code>-ks.</p>
        
        <div class="alert alert-info">
            Funktsioonide näited:
            <ul>
                <li>Sirge funktsioon: <code>f(x) = 2x + 3</code></li>
                <li>Ruutfunktsioon: <code>f(x) = x² - 4</code></li>
                <li>Eksponentsiaalne funktsioon: <code>f(x) = 3ˣ</code></li>
            </ul>
        </div>
    </div>

    <div class="concept-card">
        <div class="concept-title">📊 Funktsiooni graafik</div>
        <p>Funktsiooni saab esitada graafiliselt koordinaatide tasandil. Horisontaalsel teljel (abstsisside telg) märgitakse <code>x</code> väärtused, vertikaalsel teljel (ordinattide telg) vastavad <code>y = f(x)</code> väärtused.</p>
        
        <div class="alert alert-warning">
            Funktsioonide omadused:
            <ul>
                <li><strong>Määramispiirkond</strong> — kõik võimalikud <code>x</code> väärtused</li>
                <li><strong>Väärtuste piirkond</strong> — kõik võimalikud <code>y</code> väärtused</li>
                <li><strong>Funktsiooni nullkohad</strong> — väärtused <code>x</code>, kus <code>f(x) = 0</code></li>
            </ul>
        </div>
    </div>

    <div class="concept-card">
        <div class="concept-title">🔢 Funktsioonide liigid</div>
        <p>Matemaatikas on põhifunktsioonide liigid:</p>
        <ol>
            <li><strong>Sirged</strong>: <code>f(x) = kx + b</code> (graafik — sirge)</li>
            <li><strong>Ruutfunktsioonid</strong>: <code>f(x) = ax² + bx + c</code> (graafik — parabool)</li>
            <li><strong>Jõudude funktsioonid</strong>: <code>f(x) = xⁿ</code></li>
            <li><strong>Eksponentsiaalsed funktsioonid</strong>: <code>f(x) = aˣ</code></li>
            <li><strong>Logaritmilised funktsioonid</strong>: <code>f(x) = logₐx</code></li>
        </ol>
    </div>

    <p>🧠 Soovitus: Et paremini mõista funktsioone, proovige nende graafikuid koostada erinevate parameetrite väärtustega!</p>

    <p class="text-center mt-4">
        <a href="../tasks/topic13.php" class="btn btn-primary btn-lg fw-bold">Liigu ülesannete juurde 🚀</a>
    </p>
</div>
</body>
</html>
