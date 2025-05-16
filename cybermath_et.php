<?php
$host = 'localhost';
$db   = 'cybermath'; 
$user = 'root';      
$pass = '';          
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    echo "Andmebaasi ühenduse viga: " . $e->getMessage();
    exit;
}
?>

<?php
    $stmt = $pdo->query("
      SELECT u.name, u.coins, COUNT(ut.topic_id) AS solved_tasks
      FROM users u
      LEFT JOIN user_topics ut ON u.id = ut.user_id
      WHERE u.status = 'active'
      GROUP BY u.id
      ORDER BY u.coins DESC, solved_tasks DESC
      LIMIT 10
    ");
    $leaders = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="et">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>CyberMath</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <style>

    html {
      scroll-behavior: smooth;
    }

    body {
      background-color: #111;
      color: #fff;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      position: relative;
      overflow-x: hidden;
    }

    .hero {
        position: relative;
        min-height: 50vh;
        padding: 4rem 2rem;
        background: linear-gradient(to right, rgba(17, 17, 17, 0.95) 60%, rgba(17, 17, 17, 0.6));
        overflow: hidden;
    }

    .hero .container {
      max-width: 700px;
      z-index: 2;
    }

.hero-image {
  position: absolute;
  top: 0;
  right: 0;
  height: 100%;
  width: 45%;
  background: linear-gradient(to left, rgba(0, 0, 0, 0.7), transparent),
              url('assets/offer_et.png') no-repeat center center;
  background-size: cover;
  z-index: 1;
  pointer-events: none;
}


    .navbar {
      background: #222;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.7);
    }

    .navbar-nav .nav-link {
      transition: color 0.3s, transform 0.3s;
    }

    .navbar-nav .nav-link:hover {
      color:hsl(267, 100.00%, 74.70%);
      transform: scale(1.05);
    }

    .btn-primary {
      background: #6a0dad;
      border: none;
      transition: background 0.3s, transform 0.2s;
    }

    .btn-primary:hover {
      background: #b77eff;
      transform: translateY(-2px);
    }

    .hero {
      text-align: center;
      padding: 120px 20px;
      background: linear-gradient(135deg, #6a0dad, #000);
      animation: fadeIn 1.5s ease;
      position: relative;
      z-index: 1;
      min-height: 50vh;
      overflow: hidden;
    }

    @keyframes fadeIn {
      from {
        
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .section-title {
      font-size: 2.5rem;
      margin-bottom: 30px;
      color: #b77eff;
    }

    .service-card {
      background: #222;
      padding: 25px;
      border-radius: 15px;
      transition: transform 0.3s, box-shadow 0.3s;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    }

    .service-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 0 20px #b77eff60;
    }

    .contact-form,
    .leaderboard {
      background: #1b1b1b;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.4);
    }

    .leaderboard th {
      color: #b77eff;
    }

    .emoji-background {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      pointer-events: none;
      z-index: 0;
      overflow: hidden;
    }

    .emoji {
      position: absolute;
      font-size: 2.5rem;
      opacity: 0.6;
      animation: float 15s linear infinite;
    }


    @keyframes float {
      0% {
        transform: translateY(0) rotate(0deg);
        opacity: 0.6;
      }
      50% {
        opacity: 0.9;
      }
      100% {
        transform: translateY(-120vh) rotate(360deg);
        opacity: 0;
      }
    }

    .leaderboard {
        width: 100%;
        max-width: 800px;
        margin: 30px auto;
        border-collapse: collapse;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #1a1a1a;
        color: #e6e6e6;
        box-shadow: 0 0 15px #6a0dad;
        border-radius: 12px;
        overflow: hidden;
    }
    .leaderboard thead {
        background: #0f0f0f;
        color: #b77eff;
        font-weight: bold;
    }
    .leaderboard th, .leaderboard td {
        padding: 12px 20px;
        text-align: center;
    }
    .leaderboard tbody tr:nth-child(even) {
        background-color: #222;
    }
    .leaderboard tbody tr:hover {
        background-color: #333;
    }
    .leaderboard tbody tr td:first-child {
        font-weight: bold;
        color: #b77eff;
    }

    footer a {
      transition: transform 0.3s, color 0.3s;
    }

    footer a:hover {
      color: #b77eff !important;
      transform: scale(1.2);
    }

    .about-section {
      transition: transform 0.3s;
    }

    .about-section:hover {
      transform: scale(1.01);
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">CyberMath</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="#services">Kuidas see töötab</a></li>
          <li class="nav-item"><a class="nav-link" href="#about">Projektist</a></li>
          <li class="nav-item"><a class="nav-link" href="#leaderboard">Edetabel</a></li>
          <li class="nav-item"><a class="nav-link" href="#contact">Kontaktid</a></li>
          <li class="nav-item">

          <div class="ms-auto me-3 d-flex align-items-center">
            <a class="nav-link" href="cybermath.php">RU</a> 
            | 
            <span class="nav-link active">ET</span>
          </div>  

          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="emoji-background" id="emojiBg">
    <span class="emoji">😊</span>
    <span class="emoji">🎓</span>
    <span class="emoji">📚</span>
    <span class="emoji">✏️</span>
    <span class="emoji">🧠</span>
  </div>

  <script>
  const emojiContainer = document.getElementById('emojiBg');

  const emojis = ['😊', '🎓', '📚', '✏️', '🧠', '💡', '🤓'];
  for (let i = 0; i < 10; i++) {
    const emoji = document.createElement('span');
    emoji.className = 'emoji';
    emoji.textContent = emojis[Math.floor(Math.random() * emojis.length)];
    emoji.style.left = Math.random() * 100 + 'vw';
    emoji.style.top = '100%';
    emoji.style.animationDelay = (Math.random() * 15) + 's';
    emojiContainer.appendChild(emoji);
  }

  setTimeout(() => {
    creators.forEach((creator, index) => {
      const img = document.createElement('img');
      img.src = creator.src;
      img.className = 'creator';
      img.style.left = creator.left;
      img.style.top = '100%';
      img.style.animationDelay = (index * 2) + 's';
      emojiContainer.appendChild(img);
      setTimeout(() => {
        img.style.opacity = '0.7';
      }, 50);
    });
  }, 20000);
</script>

  <section class="hero d-flex align-items-center">
    <div class="container z-2 position-relative">
      <h1 class="display-4 fw-bold">Jaga teadmisi, arene ja tõuse edetabelis!</h1>
      <p class="lead">CyberMath — mänguline platvorm matemaatika ja digioskuste õppimiseks</p>
      <a href="language/index.php" class="btn btn-primary btn-lg mt-3">Liitu</a>
    </div>
    <div class="hero-image"></div>
  </section>

  <section id="services" class="py-5">
    <div class="container">
      <h2 class="text-center section-title">Kuidas see töötab</h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="service-card">
            <h3>Lahenda ülesandeid</h3>
            <p>Sukeldu põnevatesse matemaatikatasemetesse alates aritmeetikast kuni keerukamate teemadeni. Õpi ja avasta iga päev midagi uut!</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="service-card">
            <h3>Teeni punkte</h3>
            <p>Saa punkte kiiruse, täpsuse ja aktiivsuse eest. Mida rohkem mängid — seda kõrgem on sinu tulemus. Tõuse edetabelis!</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="service-card">
            <h3>Arenda end</h3>
            <p>Kasuta punkte profiili kohandamiseks ja unikaalsete võimaluste avamiseks platvormil. Saavuta üle tuhande punkti ja saa juhendajaks!</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="about" class="py-5" style="background-color:#2f2f2f;">
    <div class="container text-center about-section">
      <h2 class="section-title">Projektist</h2>
      <p class="lead">CyberMath ei ole lihtsalt mäng. See on innovatiivne õppeplatvorm, kus igaüks saab õppida matemaatikat, parandada oma oskusi ja teenida punkte unikaalsete auhindade saamiseks.</p>
      <p>Oleme loonud paindliku ja kaasahaarava süsteemi, kus erineva raskusastmega ülesanded vahelduvad mänguliste elementidega, et õppimisprotsess oleks interaktiivne ja huvitav. Iga õige vastuse eest saad punkte, mida saab vahetada erinevate auhindade vastu: alates profiili kujundustest kuni eksklusiivsete võimalusteni platvormil.</p>
      <p>Meie eesmärk on muuta matemaatika kättesaadavaks ja huvitavaks kõigile. Soovime, et õppimine oleks tõeline seiklus!</p>
    </div>
  </section>

  <section id="leaderboard" class="py-5">
    <div class="container leaderboard">
      <h2 style="text-align:center; color:#b77eff; margin-top:40px;">🏆 CyberMathi liidrid</h2>
      <table class="leaderboard">
        <thead>
          <tr>
            <th>#</th>
            <th>Kasutajanimi</th>
            <th>Mündid</th>
            <th>Lahendatud teemad</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $rank = 1;
            foreach ($leaders as $user) {
              echo "<tr>";
              echo "<td>{$rank}</td>";
              echo "<td>" . htmlspecialchars($user['name']) . "</td>";
              echo "<td>{$user['coins']}</td>";
              echo "<td>{$user['solved_tasks']}</td>";
              echo "</tr>";
              $rank++;
            }
          ?>
        </tbody>
      </table>
    </div>
  </section>

  <section id="contact" class="py-5">
    <div class="container">
      <h2 class="text-center section-title">Võta meiega ühendust</h2>
      <div class="row justify-content-center">
        <div class="col-md-6 contact-form">
          <form action="send_email.php" method="POST">
            <div class="mb-3">
              <label for="name" class="form-label">Nimi</label>
              <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
              <label for="message" class="form-label">Sõnum</label>
              <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Saada</button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <footer class="mt-5 pt-5 pb-4" style="background: linear-gradient(to right, #1a1a1a, #2a0a3d); color: #ccc;">
        <div class="container text-center">
            <div class="mb-4">
                <a href="#" class="mx-3 text-white fs-4" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="mx-3 text-white fs-4" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="#" class="mx-3 text-white fs-4" target="_blank"><i class="fab fa-vk"></i></a>
            </div>
            <p class="mb-1" style="font-size: 1.1rem;">📧 inf.cybermath@gmail.com</p>
            <p class="mb-2">📍 Estonia, Tallinn</p>
            <hr style="width: 60px; margin: 20px auto; border-top: 2px solid #6a0dad;">
            <p class="mb-0" style="font-size: 0.9rem;">© 2025 <strong>CyberMath</strong>. Kõik õigused kaitstud.</p>
        </div>
    </footer>
</body>
</html>
 
