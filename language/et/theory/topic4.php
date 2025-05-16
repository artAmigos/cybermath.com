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
    <title>Kümnendmurd ja harilik murd - CyberMath</title>
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
            <?= ['🔢','✨','🧠','½','¼','¾','📘','🚀','🧮'][rand(0, 8)] ?>
        </div>
    <?php endfor; ?>

<div class="card mx-auto" style="max-width: 900px;">
    <h1 class="mb-4 text-center">📘 Kümnendmurrud ja harilikud murrud</h1>

    <p><strong>Harilikud murrud</strong> — need on arvud kujul a/b, kus a on lugeja ja b nimetaja. Neid kasutatakse terviku osade näitamiseks.</p>

    <div class="alert alert-success">
        Näide: ½ (üks teine) tähendab, et tervik jagati kaheks osaks ja võeti üks osa.
    </div>

    <p>Harilike murdude peamised tüübid:</p>
    <ul>
        <li><strong>Õiged murrud</strong> — lugeja on väiksem kui nimetaja (¾)</li>
        <li><strong>Valed murrud</strong> — lugeja on suurem või võrdne nimetajaga (5/4)</li>
        <li><strong>Segaarvud</strong> — koosnevad täisarvust ja murrust (1¼)</li>
    </ul>

    <p><strong>Kümnendmurrud</strong> — need on murrud, kus täisarvuline osa on komaga (või punktiga) eraldatud murdosast.</p>

    <div class="alert alert-warning">
        Näide: 0.5 (null koma viis) on sama, mis ½
    </div>

    <p>🔍 Kümnendmurdude peamised omadused:</p>
    <ul>
        <li>Iga number pärast koma tähistab oma järku (kümnendikud, sajandikud, tuhandikud jne.)</li>
        <li>Kümnendmurde saab liita, lahutada, korrutada ja jagada vastavalt reeglitele</li>
        <li>Mõningaid harilikke murde ei saa täpselt kümnendmurdudena esitada (nt 1/3 ≈ 0.333...)</li>
    </ul>

    <p>📌 Näited teisendamisest:</p>
    <ul>
        <li>½ = 0.5</li>
        <li>¼ = 0.25</li>
        <li>¾ = 0.75</li>
        <li>1/5 = 0.2</li>
    </ul>

    <p>🧠 Nõuanne: Hariliku murru teisendamiseks kümnendmurruks jaga lugeja nimetajaga. Tagurpidi teisendamiseks kirjuta murd vastavalt järkudele ja lihtsusta.</p>

    <p class="text-center mt-4">
        <a href="../tasks/topic4.php" class="btn btn-primary btn-lg fw-bold">Mine ülesanneteni 🚀</a>
    </p>
</div>
</body>
</html>
