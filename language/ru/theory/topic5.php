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
    <title>Проценты - CyberMath</title>
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
            <?= ['🔢','✨','🧠','%','💰','📈','📉','🧮'][rand(0, 7)] ?>
        </div>
    <?php endfor; ?>

<div class="card mx-auto" style="max-width: 900px;">
    <h1 class="mb-4 text-center">📘 Проценты</h1>

    <p><strong>Процент</strong> — это сотая часть числа. Обозначается знаком %. Проценты широко используются в повседневной жизни: в банковских расчетах, скидках, статистике и многих других областях.</p>

    <div class="alert alert-success">
        Пример: 1% от 200 = <strong>2</strong> (так как 200 ÷ 100 = 2)
    </div>

    <p>Основные понятия:</p>
    <ul>
        <li><strong>Процент</strong> — сотая часть (1% = 1/100 = 0.01)</li>
        <li><strong>Базовое значение</strong> — число, от которого вычисляются проценты</li>
        <li><strong>Процентное значение</strong> — результат вычисления процента от базового значения</li>
    </ul>

    <p><strong>Основные типы задач с процентами:</strong></p>
    <ol>
        <li>Найти процент от числа</li>
        <li>Найти число по его проценту</li>
        <li>Найти процентное соотношение двух чисел</li>
    </ol>

    <div class="alert alert-warning">
        Формула для нахождения процента от числа: <strong>число × процент / 100</strong><br>
        Пример: 15% от 300 = 300 × 15 / 100 = 45
    </div>

    <p>🔍 Полезные советы:</p>
    <ul>
        <li>Чтобы увеличить число на процент, нужно умножить его на (1 + процент/100)</li>
        <li>Чтобы уменьшить число на процент, нужно умножить его на (1 - процент/100)</li>
        <li>Проценты можно складывать и вычитать только от одного и того же базового значения</li>
    </ul>

    <p>📌 Примеры из реальной жизни:</p>
    <ul>
        <li>Скидка 20% на товар стоимостью 50 €: 50 × 0.20 = 10 € (новая цена: 40 €)</li>
        <li>Банковский вклад под 5% годовых на сумму 1000 €: 1000 × 0.05 = 50 € дохода за год</li>
        <li>Налог 15% от дохода 2000 €: 2000 × 0.15 = 300 €</li>
    </ul>

    <p>🧠 Совет: Для быстрого вычисления некоторых процентов можно использовать дроби: 50% = ½, 25% = ¼, 10% = 1/10 и т.д.</p>

    <p class="text-center mt-4">
        <a href="../tasks/topic5.php" class="btn btn-primary btn-lg fw-bold">Перейти к примерам 🚀</a>
    </p>
</div>
</body>
</html>