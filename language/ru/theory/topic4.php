<?php
session_start();
require_once '../../../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Десятичные и обыкновенные дроби - CyberMath</title>
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
    <h1 class="mb-4 text-center">📘 Десятичные и обыкновенные дроби</h1>

    <p><strong>Обыкновенные дроби</strong> — это числа вида a/b, где a — числитель, b — знаменатель. Они используются для представления частей целого.</p>

    <div class="alert alert-success">
        Пример: ½ (одна вторая) означает, что целое разделено на 2 части и взята 1 часть.
    </div>

    <p>Основные виды обыкновенных дробей:</p>
    <ul>
        <li><strong>Правильные</strong> — числитель меньше знаменателя (¾)</li>
        <li><strong>Неправильные</strong> — числитель больше или равен знаменателю (5/4)</li>
        <li><strong>Смешанные</strong> — целая часть и дробь (1¼)</li>
    </ul>

    <p><strong>Десятичные дроби</strong> — это другая форма записи дробей, где целая часть отделена от дробной запятой или точкой.</p>

    <div class="alert alert-warning">
        Пример: 0.5 (ноль целых пять десятых) — это то же самое, что ½
    </div>

    <p>🔍 Основные свойства десятичных дробей:</p>
    <ul>
        <li>Каждая цифра после запятой имеет свой разряд (десятые, сотые, тысячные и т.д.)</li>
        <li>Десятичные дроби можно складывать, вычитать, умножать и делить по определённым правилам</li>
        <li>Некоторые обыкновенные дроби нельзя точно представить в виде десятичной (например, 1/3 ≈ 0.333...)</li>
    </ul>

    <p>📌 Примеры преобразований:</p>
    <ul>
        <li>½ = 0.5</li>
        <li>¼ = 0.25</li>
        <li>¾ = 0.75</li>
        <li>1/5 = 0.2</li>
    </ul>

    <p>🧠 Совет: Для перевода обыкновенной дроби в десятичную нужно разделить числитель на знаменатель. Для обратного преобразования — записать дробь по разрядам и сократить.</p>

    <p class="text-center mt-4">
        <a href="../tasks/topic4.php" class="btn btn-primary btn-lg fw-bold">Перейти к примерам 🚀</a>
    </p>
</div>
</body>
</html>