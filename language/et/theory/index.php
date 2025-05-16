<?php
session_start();
require_once '../../../db.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$topics = [
    "Liitmine ja lahutamine",
    "Korrutamine ja jagamine",
    "Looduslikud, täis- ja ratsionaalsed arvud",
    "Kümnend- ja murrangulised arvud",
    "Protsendid",
    "Aritmeetiline ja geomeetriline järk",
    "Astmed ja juured",
    "Logaritmid",
    "Lihtsüsteemid",
    "Lihtsüsteemide lahendamine",
    "Ruutfunktsioonid ja diskriminant",
    "Ebavõrdsused",
    "Muudatused ja funktsioon",
    "Funktsioonide graafikud",
    "Trigonomeetria alused",
    "Koordinaatide tasand",
    "Pythagorase teoreem",
    "Geomeetrilised kujundid",
    "Pindala ja ümbermõõt",
    "Tõenäosuse alused",
];

?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Õpetused - CyberMath</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa, #e0f7fa);
        }

        .topic-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .topic-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .topic-title {
            font-weight: 500;
            font-size: 1.1rem;
        }

        .btn-tasks {
            background-color: #6c5ce7;
            border: none;
        }

        .btn-tasks:hover {
            background-color: #a29bfe;
        }
        
        .btn-outline-secondary{
            --bs-btn-color: #6c5ce7;
            --bs-btn-border-color:rgb(124, 111, 224);
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: #6c5ce7;
            --bs-btn-hover-border-color: #6c5ce7;
            --bs-btn-focus-shadow-rgb: 108,117,125;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: #6c5ce7;
            --bs-btn-active-border-color: #6c5ce7;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: #6c5ce7;
            --bs-btn-disabled-bg: transparent;
            --bs-btn-disabled-border-color: #6c5ce7;
            --bs-gradient: none;
        }

        .btn-outline-primary {
            --bs-btn-color: #00b894;
            --bs-btn-border-color: #00b894;
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: #00b894;
            --bs-btn-hover-border-color: #00b894;
            --bs-btn-focus-shadow-rgb: 13, 110, 253;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: #00b894;
            --bs-btn-active-border-color: #00b894;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: #00b894;
            --bs-btn-disabled-bg: transparent;
            --bs-btn-disabled-border-color: #00b894;
            --bs-gradient: none;
        }

    </style>
</head>
<body class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">📚 Õppetundide loend</h1>
        <a href="../profile.php" class="btn btn-outline-secondary">← Profiili</a>
    </div>

    <div class="mb-4">
    <input type="text" id="searchInput" class="form-control" placeholder="🔍 Otsi õppetunde...">
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach ($topics as $i => $topic): ?>
            <div class="col">
                <div class="card topic-card h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h5 class="topic-title mb-3"><?= htmlspecialchars($topic) ?></h5>
                        <div class="d-flex justify-content-between">
                            <a href="topic<?= $i + 1 ?>.php" class="btn btn-outline-primary">📖 Teooria</a>
                            <a href="../tasks/topic<?= $i + 1 ?>.php" class="btn btn-tasks text-white">🧠 Näited</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>


    <script>
    document.getElementById('searchInput').addEventListener('input', function () {
        const query = this.value.toLowerCase();
        const cards = document.querySelectorAll('.topic-card');

        cards.forEach(card => {
            const title = card.querySelector('.topic-title').textContent.toLowerCase();
            if (title.includes(query)) {
                card.closest('.col').style.display = '';
            } else {
                card.closest('.col').style.display = 'none';
            }
        });
    });
    </script>
</body>
</html>
