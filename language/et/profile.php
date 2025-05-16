<?php
session_start();
require_once '../../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

$coins = (int)$user['coins'];
$title = "Saavutusi ei ole veel saadud";

$titles = [
    4000 => "Teadmiste Jumal",
    3000 => "Matemaatika Isand",
    2500 => "CyberMathi Täht",
    1500 => "Tippmängija",
    1200 => "Tark Eraõpetaja",
    1000 => "Püsiv Õpilane",
    700  => "Teadmiste Guru",
    500  => "Teooria Meister",
    200  => "Avastaja",
    50   => "Algaja"
];

foreach ($titles as $threshold => $rank) {
    if ($coins >= $threshold) {
        $title = $rank;
        switch ($rank) {
            case "Teadmiste Jumal":
                $rank_class = "rank-god";
                break;
            case "Matemaatika Isand":
                $rank_class = "rank-lord";
                break;
            case "CyberMathi Täht":
                $rank_class = "rank-star";
                break;
            case "Tippmängija":
                $rank_class = "rank-top";
                break;
            case "Tark Eraõpetaja":
                $rank_class = "rank-tutor";
                break;
            case "Püsiv Õpilane":
                $rank_class = "rank-student";
                break;
            case "Teadmiste Guru":
                $rank_class = "rank-guru";
                break;
            case "Teooria Meister":
                $rank_class = "rank-theory";
                break;
            case "Avastaja":
                $rank_class = "rank-explorer";
                break;
            case "Algaja":
                $rank_class = "rank-novice";
                break;
                default:
                    $rank_class = "";
        }        
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Profiil - CyberMath</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { margin: 0; font-family: 'Rubik', sans-serif; background-color: #fff; color: #333; height: 100vh; overflow: hidden; display: flex; align-items: center; justify-content: center; padding: 20px; flex-direction: column; }
        .profile-box { background: #f9f9f9; border: 1px solid #ddd; padding: 60px 40px; border-radius: 20px; text-align: center; max-width: 400px; width: 100%; box-shadow: 0 0 30px rgba(0, 0, 0, 0.1); z-index: 2; margin-top: 130px; }
        .profile-box h1 { font-size: 2rem; font-weight: 700; margin-bottom: 15px; color: #333; }
        .profile-box p { font-size: 1rem; color: #555; }
        .btn-primary { background-color: #04a3ff; border: none; padding: 12px; border-radius: 10px; font-weight: bold; transition: all 0.3s ease; }
        .btn-primary:hover { background-color: #038ad1; }
        .smiley, .rocket { position: absolute; font-size: 30px; opacity: 0; animation: fly 10s infinite, fadeIn 1s forwards; }
        .smiley { animation-delay: calc(0.5s * var(--index)); }
        .rocket { font-size: 40px; animation-delay: calc(2s + 0.5s * var(--index)); color: #00bfff; }
        @keyframes fly { 0% { transform: translateY(0) translateX(0); } 100% { transform: translateY(-100vh) translateX(100vw); } }
        @keyframes fadeIn { 0% { opacity: 0; } 100% { opacity: 0.8; } }
        .smiley:nth-child(odd) { font-size: 35px; color: #ffcc00; }
        .smiley:nth-child(even) { font-size: 40px; color: #ff6699; }
        .navbar { font-size: 1.2rem; padding-top: 25px !important; padding-bottom: 25px !important; }
        .navbar a { padding: 15px 25px; font-size: 1.1rem; border-radius: 12px; }
        footer { z-index: 10; }
        @media (max-width: 480px) {
            .profile-box { padding: 50px 20px; }
            .profile-box h1 { font-size: 1.7rem; }
            .navbar { flex-direction: column; gap: 10px; }
            .navbar a { width: 100%; text-align: center; }
        }

        .profile-box {
            box-shadow: 0 4px 15px rgba(108, 92, 231, 0.5); /* тень фиолетового цвета */
        }


        .rank-title {
            font-weight: bold;
            font-size: 1.2rem;
            color:rgb(0, 0, 0);
            text-transform: uppercase;
            letter-spacing: 1px;
            animation: glow 1.5s ease-in-out infinite alternate;
        }

@keyframes glow {
    0% { text-shadow: 0 0 5px #04a3ff, 0 0 10px #04a3ff, 0 0 15px #04a3ff, 0 0 20px #04a3ff; }
    100% { text-shadow: 0 0 10px #ff1493, 0 0 20px #ff1493, 0 0 30px #ff1493, 0 0 40px #ff1493; }
}

.rank-novice {
    background: linear-gradient(45deg,rgb(43, 53, 68),rgb(89, 177, 218));
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: glowNovice 2s ease-in-out infinite;
}

.rank-explorer {
    animation: glow2 2s ease-in-out infinite alternate;
}
.rank-theory {
    animation: glow3 2s ease-in-out infinite alternate;
}
.rank-guru {
    animation: glow4 2s ease-in-out infinite alternate;
}
.rank-student {
    animation: glow5 2s ease-in-out infinite alternate;
}
.rank-tutor {
    animation: glow6 2s ease-in-out infinite alternate;
}

@keyframes glowNovice {
    0% { text-shadow: 0 0 5px #a1c4fd, 0 0 10px #c2e9fb; }
    100% { text-shadow: 0 0 10px #c2e9fb, 0 0 20px #a1c4fd; }
}

@keyframes glow1 {
    from { text-shadow: 0 0 5px #aaa; }
    to   { text-shadow: 0 0 8px #ccc; }
}
@keyframes glow2 {
    from { text-shadow: 0 0 5px #66ccff; }
    to   { text-shadow: 0 0 12px #66ccff; }
}
@keyframes glow3 {
    from { text-shadow: 0 0 6px #3399ff; }
    to   { text-shadow: 0 0 14px #3399ff; }
}
@keyframes glow4 {
    from { text-shadow: 0 0 8px #33cc33; }
    to   { text-shadow: 0 0 16px #33cc33; }
}
@keyframes glow5 {
    from { text-shadow: 0 0 10px #ffcc00; }
    to   { text-shadow: 0 0 20px #ffcc00; }
}
@keyframes glow6 {
    from { text-shadow: 0 0 10px #ff9900; }
    to   { text-shadow: 0 0 22px #ff9900; }
}
@keyframes glow7 {
    from { text-shadow: 0 0 12px #ff6600; }
    to   { text-shadow: 0 0 24px #ff6600; }
}
@keyframes glow8 {
    from { text-shadow: 0 0 15px #ff3399; }
    to   { text-shadow: 0 0 30px #ff3399; }
}
@keyframes glow9 {
    from { text-shadow: 0 0 18px #9933ff; }
    to   { text-shadow: 0 0 36px #9933ff; }
}
@keyframes glow10 {
    from { text-shadow: 0 0 20px #ff0000, 0 0 30px #ff0066; }
    to   { text-shadow: 0 0 40px #ff0066, 0 0 60px #ff33cc; }
}


.rank-top {
    background: linear-gradient(45deg, #f7971e, #ffd200);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: glowTop 3s ease-in-out infinite;
}
@keyframes glowTop {
    0% { text-shadow: 0 0 10px #ffd200; }
    100% { text-shadow: 0 0 20px #ffae00; }
}

.rank-star {
    background: linear-gradient(90deg, #ff6ec4, #7873f5);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: glowStar 3s ease-in-out infinite;
}
@keyframes glowStar {
    0% { text-shadow: 0 0 15px #ff6ec4; }
    100% { text-shadow: 0 0 30px #7873f5; }
}

.rank-lord {
    background: linear-gradient(90deg, #00c9ff, #92fe9d);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: glowLord 3s ease-in-out infinite;
}
@keyframes glowLord {
    0% { text-shadow: 0 0 15px #00c9ff; }
    100% { text-shadow: 0 0 30px #92fe9d; }
}

.rank-god {
    background: linear-gradient(270deg, 
        #ff0000, #ff7f00, #ffff00, 
        #00ff00, #0000ff, #4b0082, #8f00ff);
    background-size: 1400% 1400%;
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: rainbowGod 6s linear infinite, glowGod 3s ease-in-out infinite;
}

@keyframes rainbowGod {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
@keyframes glowGod {
    0% { text-shadow: 0 0 20px #fff, 0 0 40px #ff00ff; }
    100% { text-shadow: 0 0 40px #00ffff, 0 0 80px #ff00ff; }
}

    </style>
</head>
<body>
    <div class="smiley" style="left: 10%; top: 20%; --index: 1;">😊</div>
    <div class="smiley" style="left: 30%; top: 50%; --index: 2;">😎</div>
    <div class="smiley" style="left: 60%; top: 10%; --index: 3;">😄</div>
    <div class="smiley" style="left: 80%; top: 70%; --index: 4;">😁</div>
    <div class="rocket" style="left: 5%; top: 80%; --index: 5;">🚀</div>
    <div class="rocket" style="left: 70%; top: 40%; --index: 6;">🚀</div>
    <div class="rocket" style="left: 50%; top: 90%; --index: 7;">🚀</div>

    <nav class="navbar fixed-top bg-white shadow-sm px-4 d-flex justify-content-center gap-3">
        <a href="theory/index.php" class="btn btn-outline-primary fw-bold">📚 Teooriamaterjalid</a>
        <a href="theory/completed.php" class="btn btn-outline-success fw-bold">✅ Läbitud materjalid</a>
        <a href="math_tasks/index.php" class="btn btn-primary fw-bold">🚀 Alusta ülesannete lahendamist</a>
        <a href="certificates.php" class="btn btn-outline-warning fw-bold">🏅 Minu saavutused</a>
    </nav>

    <div class="profile-box">
        <h1>Tere, <?php echo $user['name']; ?>!</h1>
        <p>Email: <?php echo $user['email']; ?></p>
        <p>Registreerimise kuupäev: <?php echo $user['created_at']; ?></p>
        <p>Saldo: <?php echo $user['coins']; ?> münti</p>
        <p><strong>Tase:</strong> <span class="rank-title <?php echo $rank_class; ?>"><?php echo $title; ?></span></p>
    </div>

    <footer class="position-absolute bottom-0 start-0 end-0 text-center p-3 bg-light shadow-sm">
        <a href="logout.php" class="btn btn-danger fw-bold px-4 py-2">🚪 Logi välja</a>
    </footer>
</body>
</html>
