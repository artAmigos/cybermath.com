<?php
session_start();
require_once '../../../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$topics = [
    1 => "Liitmine ja lahutamine",
    2 => "Korrutamine ja jagamine",
    3 => "Looduslikud, täisarvud, ratsionaalsed ja irratsionaalsed arvud",
    4 => "Kümnend- ja murruarvud",
    5 => "Protsendid",
    6 => "Aritmeetiline ja geomeetriline progressioon",
    7 => "Astmed ja juured",
    8 => "Logaritmid",
    9 => "Sirged võrrandid",
    10 => "Sirgete võrrandite süsteemid",
    11 => "Ruutfunktsioonid ja diskriminandid",
    12 => "Ebavõrdsused",
    13 => "Muutuja ja funktsioon",
    14 => "Funktsioonide graafikud",
    15 => "Trigonometria alused",
    16 => "Koordinaatplaan",
    17 => "Pythagorase teoreem",
    18 => "Geomeetrilised kujundid",
    19 => "Pindala ja perimeeter",
    20 => "Tõenäosuse tutvustus"
];

// Arvutuste arv igas teemas
$tasksCount = [
    1 => 8,   // Liitmine ja lahutamine
    2 => 7,   // Korrutamine ja jagamine
    3 => 6,   // Arvud
    4 => 8,   // Murrud
    5 => 7,   // Protsendid
    6 => 5,   // Progressioonid
    7 => 6,   // Astmed ja juured
    8 => 5,   // Logaritmid
    9 => 7,   // Sirged võrrandid
    10 => 6,  // Võrrandite süsteemid
    11 => 6,  // Ruutfunktsioonid
    12 => 5,  // Ebavõrdsused
    13 => 6,  // Muutuja ja funktsioon
    14 => 5,  // Graafikud
    15 => 6,  // Trigonometria
    16 => 7,  // Koordinaatplaan
    17 => 5,  // Pythagorase teoreem
    18 => 8,  // Geomeetrilised kujundid
    19 => 7,  // Pindala ja perimeeter
    20 => 6   // Tõenäosus
];
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Probleemide lahendamine - CyberMath</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
        }
        .topic-card {
            transition: all 0.3s;
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .topic-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        .reward-badge {
            background-color: #00b894;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: bold;
        }
        .task-count {
            color: #6c5ce7;
            font-weight: 500;
        }
        .btn-solve {
            background-color: #6c5ce7;
            color: white;
            border: none;
        }
        .btn-solve:hover {
            background-color: #5649c0;
            color: white;
        }
    </style>
</head>
<body class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">🧩 Lahenda ülesandeid</h1>
        <a href="../profile.php" class="btn btn-outline-secondary">← Profiilile</a>
    </div>

    <div class="alert alert-info mb-4">
        <h5 class="alert-heading">Kuidas see töötab?</h5>
        <p class="mb-0">
            Valige teema ja ülesanne, lahendage see ja saate iga õigesti lahendatud ülesande eest <span class="reward-badge">+70 münti</span>!
            Igas ülesandes tuleb täita kõik väljad (Antud, Lahendus, Vastus) enne kontrollimist.
        </p>
    </div>

    <div class="mb-4">
    <input type="text" id="searchInput" class="form-control" placeholder="🔍 Otsi teemade järgi...">
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach ($topics as $id => $topic): ?>
            <div class="col">
                <div class="card topic-card h-100">
                    <div class="card-body d-flex flex-column">
                        <h4 class="mb-3"><?= htmlspecialchars($topic) ?></h4>
                        <p class="task-count mb-3"><?= $tasksCount[$id] ?> ülesannet</p>
                        
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small">Teema <?= $id ?></span>
                                <a href="topic<?= $id ?>.php" class="btn btn-solve">Vali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<script>
    document.getElementById('searchInput').addEventListener('input', function () {
        const query = this.value.toLowerCase().trim();
        const cards = document.querySelectorAll('.col');

        if (query === '') {
            cards.forEach(card => card.style.display = '');
            return;
        }

        cards.forEach(card => {
            const title = card.querySelector('h4').textContent.toLowerCase();
            const topicNumber = card.querySelector('.text-muted').textContent.toLowerCase();
            
            if (title.includes(query) || topicNumber.includes(query)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });
</script>

</body>
</html>
