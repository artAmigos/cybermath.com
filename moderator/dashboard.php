<?php
session_start();

if (!isset($_SESSION['moderator_id'])) {
    header('Location: /moderator/moderator_login.php');
    exit;
}

require_once '../db.php';
$users = [];
try {
    $stmt = $pdo->query("SELECT id, name, email, created_at, coins, status FROM users ORDER BY name ASC");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Ошибка при получении списка пользователей: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Модераторская панель</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">
    <div class="max-w-xl mx-auto mt-12 bg-white shadow-lg rounded-2xl p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">👮‍♂️ Добро пожаловать в Модерку</h1>

        <form method="POST" action="submit_request.php" class="space-y-5">
            <div>
                <label class="block text-gray-700 font-medium mb-2">Ник пользователя</label>
                <input type="text" name="target_name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Тип запроса</label>
                <select name="action" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="give_coins">Выдать монеты</option>
                    <option value="block_user">Заблокировать пользователя</option>
                    <option value="unblock_user">Разблокировать пользователя</option>
                    <option value="delete_user">Удалить пользователя</option>
                </select>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Количество монет (если нужно)</label>
                <input type="number" name="coins" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Заметка</label>
                <textarea name="note" rows="3" placeholder="Причина запроса..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <div class="text-center">
                <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg shadow hover:bg-purple-700 transition duration-200">
                    🚀 Отправить запрос
                </button>
            </div>
        </form>

        <hr class="my-8">

        <h2 class="text-xl font-semibold text-gray-800 mb-4">📋 Список всех пользователей</h2>

        <!-- Поиск -->
        <div class="flex items-center mb-4">
            <input type="text" id="searchInput" placeholder="Поиск по нику..." class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button class="bg-purple-600 text-white px-4 py-2 rounded-r-lg hover:bg-purple-700 transition duration-200">
                🔍
            </button>
        </div>

        <div id="userList" class="bg-gray-50 border border-gray-200 rounded-lg p-4 max-h-96 overflow-y-auto space-y-2">
            <?php foreach ($users as $user): ?>
                <div class="user-item border rounded-lg overflow-hidden" data-name="<?= htmlspecialchars(strtolower($user['name'])) ?>">
                    <button 
                        class="w-full text-left px-4 py-2 bg-gray-100 hover:bg-gray-200 font-medium text-gray-800 flex justify-between items-center"
                        onclick="this.nextElementSibling.classList.toggle('hidden')">
                        <?= htmlspecialchars($user['name']) ?>
                        <svg class="w-4 h-4 transform transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="hidden px-4 py-2 bg-white text-sm text-gray-700">
                        📧 <strong>Email:</strong> <?= htmlspecialchars($user['email']) ?><br>
                        🗓 <strong>Дата регистрации:</strong> <?= htmlspecialchars($user['created_at']) ?><br>
                        💰 <strong>Монеты:</strong> <?= htmlspecialchars($user['coins']) ?><br>
                        🔒 <strong>Статус:</strong> 
                        <span class="<?= $user['status'] === 'blocked' ? 'text-red-600 font-semibold' : 'text-green-600 font-semibold' ?>">
                            <?= $user['status'] === 'blocked' ? 'Заблокирован' : 'Активен' ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        const buttons = document.querySelectorAll('button');
        buttons.forEach(btn => {
            btn.addEventListener('click', function () {
                const svg = this.querySelector('svg');
                if (svg) svg.classList.toggle('rotate-180');
            });
        });

        // Поиск
        document.getElementById('searchInput').addEventListener('input', function () {
            const query = this.value.toLowerCase();
            document.querySelectorAll('.user-item').forEach(item => {
                const name = item.getAttribute('data-name');
                item.style.display = name.includes(query) ? 'block' : 'none';
            });
        });
    </script>
</body>
</html>
