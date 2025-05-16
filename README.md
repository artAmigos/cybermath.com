😎 CyberMath - Документация по установке проекта
Эта документация поможет вам развернуть проект CyberMath на локальной машине с использованием XAMPP, MariaDB, Composer и Visual Studio Code.

1. Установка XAMPP (последняя версия)
XAMPP предоставляет веб-сервер (Apache), PHP и MariaDB в одном пакете.

Шаги установки:
Скачайте XAMPP с официального сайта:
🔗 https://www.apachefriends.org/download.html
(Выберите версию для вашей ОС: Windows, Linux или macOS)

Запустите установщик и следуйте инструкциям:

Выберите компоненты: Apache, MySQL (MariaDB), PHP, phpMyAdmin.

Установите в C:\xampp (по умолчанию).

Запустите XAMPP Control Panel и стартуйте:

Apache

MySQL (MariaDB)

Проверьте работу:
Откройте в браузере:
🔗 http://localhost → Должна открыться страница XAMPP.

2. Установка Composer
Composer нужен для управления зависимостями PHP.

Шаги установки:
Скачайте Composer с официального сайта:
🔗 https://getcomposer.org/download/

Запустите установщик и следуйте инструкциям:

Выберите "Use the PHP from XAMPP" (укажите путь к PHP в XAMPP, например: C:\xampp\php\php.exe).

Добавьте Composer в PATH.

Проверьте установку:

bash
composer --version
Должна отобразиться версия Composer.

3. Установка Visual Studio Code (VS Code)
VS Code — удобный редактор для разработки.

Шаги установки:
Скачайте VS Code с официального сайта:
🔗 https://code.visualstudio.com/download

Установите и запустите, затем откройте папку проекта.

Рекомендуемые расширения:

PHP Intelephense (поддержка PHP)

MySQL (для работы с БД)

DotENV (подсветка .env файлов)

4. Настройка MariaDB (MySQL в XAMPP)
Откройте phpMyAdmin:
🔗 http://localhost/phpmyadmin

Создайте базу данных:

Имя БД: apparta

Кодировка: utf8mb4_unicode_ci

Создайте пользователя (если нужно):

Логин: root (по умолчанию, пароль пустой)

Или создайте нового пользователя с правами на БД.

5. Настройка проекта CyberMath
Клонируйте репозиторий или скопируйте файлы в папку C:\xampp\htdocs\cybermath.

Создайте .env файл в корне проекта:

env
DB_HOST=localhost
DB_NAME=apparta
DB_USER=root
DB_PASS=
Установите зависимости через Composer:

bash
cd C:\xampp\htdocs\cybermath
composer require vlucas/phpdotenv
composer require setasign/fpdf
composer require tecnickcom/tcpdf
Проверьте работу:
Откройте в браузере:
🔗 http://localhost/cybermath
