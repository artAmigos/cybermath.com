<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: /admin/admin_login.php');
    exit;
}

// Получаем запросы модераторов
$stmt = $pdo->query("SELECT * FROM moderator_requests ORDER BY created_at DESC");
$requests = $stmt->fetchAll();

// Получаем список всех пользователей
$usersStmt = $pdo->query("SELECT id, name, email, coins, status, created_at FROM users ORDER BY created_at DESC");
$users = $usersStmt->fetchAll();

// Обработка действий с пользователями
if (isset($_POST['ban_user'])) {
    $target_name = $_POST['target_name'];
    $stmt = $pdo->prepare("UPDATE users SET status = 'blocked' WHERE name = ?");
    $stmt->execute([$target_name]);
}

if (isset($_POST['unban_user'])) {
    $target_name = $_POST['target_name'];
    $stmt = $pdo->prepare("UPDATE users SET status = 'active' WHERE name = ?");
    $stmt->execute([$target_name]);
}

if (isset($_POST['update_coins'])) {
    $target_name = $_POST['target_name'];
    $new_coins = $_POST['coins'];
    $stmt = $pdo->prepare("UPDATE users SET coins = ? WHERE name = ?");
    $stmt->execute([$new_coins, $target_name]);
}

if (isset($_POST['delete_user'])) {
    $target_name = $_POST['target_name'];
    $stmt = $pdo->prepare("DELETE FROM users WHERE name = ?");
    $stmt->execute([$target_name]);
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админка</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans p-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">👑 Добро пожаловать в Админку</h1>

        <!-- Список пользователей -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">👥 Список пользователей</h2>
            
            <div class="overflow-x-auto">
                <div class="flex items-center mb-4">
                    <input type="text" id="userSearchInput" placeholder="Поиск по нику или email..." class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button onclick="searchUsers()" class="bg-purple-600 text-white px-4 py-2 rounded-r-lg hover:bg-purple-500 transition duration-200">
                    🔍
                </button>
                </div>

                <table class="w-full table-auto">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="px-4 py-3">ID</th>
                            <th class="px-4 py-3">Ник</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Монеты</th>
                            <th class="px-4 py-3">Статус</th>
                            <th class="px-4 py-3">Дата регистрации</th>
                            <th class="px-4 py-3">Действия</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <?php foreach ($users as $user): ?>
                            <tr class="border-b hover:bg-gray-50 transition duration-200">
                                <td class="px-4 py-3"><?= $user['id'] ?></td>
                                <td class="px-4 py-3 font-semibold"><?= htmlspecialchars($user['name']) ?></td>
                                <td class="px-4 py-3"><?= htmlspecialchars($user['email']) ?></td>
                                <td class="px-4 py-3"><?= $user['coins'] ?></td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded-full text-xs 
                                        <?= $user['status'] === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                        <?= $user['status'] === 'active' ? 'Активен' : 'Заблокирован' ?>
                                    </span>
                                </td>
                                <td class="px-4 py-3"><?= date('d.m.Y H:i', strtotime($user['created_at'])) ?></td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2">
                                        <form method="POST" class="inline">
                                            <input type="hidden" name="target_name" value="<?= htmlspecialchars($user['name']) ?>">
                                            <?php if ($user['status'] === 'active'): ?>
                                                <button type="submit" name="ban_user" class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs hover:bg-red-200">Бан</button>
                                            <?php else: ?>
                                                <button type="submit" name="unban_user" class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs hover:bg-green-200">Разбан</button>
                                            <?php endif; ?>
                                        </form>
                                        <form method="POST" class="inline">
                                            <input type="hidden" name="target_name" value="<?= htmlspecialchars($user['name']) ?>">
                                            <button type="submit" name="delete_user" class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs hover:bg-gray-200">Удалить</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Запросы модераторов -->
        <?php if (count($requests) > 0): ?>
            <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">📨 Запросы от модераторов</h2>
                <div class="overflow-x-auto">
                    <table class="w-full table-auto">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="px-4 py-3">ID</th>
                                <th class="px-4 py-3">Ник</th>
                                <th class="px-4 py-3">Действие</th>
                                <th class="px-4 py-3">Монеты</th>
                                <th class="px-4 py-3">Заметка</th>
                                <th class="px-4 py-3">Дата</th>
                                <th class="px-4 py-3">Управление</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            <?php foreach ($requests as $req): ?>
                                <tr class="border-b hover:bg-gray-50 transition duration-200">
                                    <td class="px-4 py-3"><?= $req['id'] ?></td>
                                    <td class="px-4 py-3 font-semibold"><?= htmlspecialchars($req['target_name']) ?></td>
                                    <td class="px-4 py-3"><?= $req['action'] ?></td>
                                    <td class="px-4 py-3"><?= $req['coins'] ?></td>
                                    <td class="px-4 py-3"><?= htmlspecialchars($req['note']) ?></td>
                                    <td class="px-4 py-3"><?= $req['created_at'] ?></td>
                                    <td class="px-4 py-3">
                                        <form method="POST" action="handle_request.php" class="flex gap-2">
                                            <input type="hidden" name="request_id" value="<?= $req['id'] ?>">
                                            <input type="hidden" name="target_name" value="<?= htmlspecialchars($req['target_name']) ?>">
                                            <input type="hidden" name="action" value="<?= $req['action'] ?>">
                                            <input type="hidden" name="coins" value="<?= $req['coins'] ?>">
                                            <button type="submit" name="do_action" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">Выполнить</button>
                                            <button type="submit" name="delete_only" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Удалить</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <form method="POST" action="clear_requests.php" class="text-center mt-4">
                    <button type="submit" class="bg-gray-800 text-white px-6 py-2 rounded hover:bg-red-600 transition duration-200">
                        🧹 Очистить все запросы
                    </button>
                </form>
            </div>
        <?php else: ?>
            <div class="bg-white p-6 rounded-lg shadow-md mb-8 text-center text-gray-600">
                💤 Нет запросов от модераторов
            </div>
        <?php endif; ?>

        <!-- Управление пользователями -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">⚙️ Управление пользователями</h2>
            <div class="space-y-4">
                <form method="POST" class="flex items-center gap-4">
                    <input type="text" name="target_name" placeholder="Ник пользователя" class="px-4 py-2 border rounded w-1/4" required>
                    <input type="number" name="coins" placeholder="Количество монет" class="px-4 py-2 border rounded w-1/4" required>
                    <button type="submit" name="update_coins" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">Обновить монеты</button>
                </form>

                <form method="POST" class="flex items-center gap-4">
                    <input type="text" name="target_name" placeholder="Ник пользователя" class="px-4 py-2 border rounded w-1/4" required>
                    <button type="submit" name="delete_user" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Удалить пользователя</button>
                </form>
            </div>
        </div>

        <!-- Генератор тем -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">🛠️ Генератор новых тем</h2>
            <p class="text-gray-600 mb-4">Здесь вы можете создать новую тему и её задания для пользователей.</p>
            <a href="create_topic.php" class="inline-block bg-purple-600 text-white px-6 py-2 rounded hover:bg-purple-700 transition">
                ➕ Новая тема
            </a>
        </div>
    </div>

    <script>
    function searchUsers() {
        const query = document.getElementById('userSearchInput').value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
    
        rows.forEach(row => {
            const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const email = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
        
            if (name.includes(query) || email.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Поиск при нажатии Enter
    document.getElementById('userSearchInput').addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            searchUsers();
        }
    });
    </script>


</body>
</html>