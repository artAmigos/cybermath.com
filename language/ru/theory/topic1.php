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
    <title>Сложение и вычитание - CyberMath</title>
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
            <?= ['🔢','✨','🧠','➕','➖','📘','🚀','🧮'][rand(0, 7)] ?>
        </div>
    <?php endfor; ?>

<div class="card mx-auto" style="max-width: 900px;">
    <h1 class="mb-4 text-center">📘 Сложение и вычитание</h1>

    <p><strong>Сложение</strong> — это одна из базовых арифметических операций, при которой два или более числа объединяются в одно общее значение — сумму. Эта операция используется повсеместно: в магазинах, в рецептах, в программировании, в бухгалтерии и других сферах.</p>

    <div class="alert alert-success">
        Пример: 3 + 5 = <strong>8</strong>
    </div>

    <p>Сложение — это, что означает: <strong>a + b = b + a</strong>. То есть от переноса слагаемых сумма не меняется</p>

    <p>Также оно: <strong>(a + b) + c = a + (b + c)</strong>. Это полезно при сложении более двух чисел — можно объединять их в любом порядке.</p>

    <p><strong>Вычитание</strong> — это обратная сложению. Она показывает, насколько одно число больше или меньше другого. В повседневной жизни вычитание используется, например, при расчётах сдачи или при нахождении разницы между значениями.</p>

    <div class="alert alert-warning">
        Пример: 9 - 4 = <strong>5</strong>
    </div>

    <p>В отличие от сложения, вычитание: <strong>9 - 4 ≠ 4 - 9</strong>.</p>

    <p>🔍 При вычитании важно помнить:</p>
    <ul>
        <li>Если <strong>уменьшаемое</strong> меньше <strong>вычитаемого</strong>, результат будет отрицательным.</li>
        <li>Отрицательные числа используются в реальных задачах — например, когда долг превышает активы, или температура ниже нуля.</li>
    </ul>

    <p>📌 Некоторые дополнительные примеры:</p>
    <ul>
        <li>12 + 15 = 27</li>
        <li>20 - 7 = 13</li>
        <li>5 - 10 = -5</li>
    </ul>

    <p>🧠 Совет: Тренируйся складывать и вычитать в уме — это помогает быстрее мыслить и ориентироваться в цифрах в жизни.</p>

    <p class="text-center mt-4">
        <a href="../tasks/topic1.php" class="btn btn-primary btn-lg fw-bold">Перейти к примерам 🚀</a>
    </p>
</div>
</body>
</html>
