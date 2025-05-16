# 🧮 CyberMath - Документация по установке проекта 🚀

Эта документация поможет вам развернуть проект **CyberMath** на локальной машине.  

## 📦 1. Установка XAMPP (последняя версия)  
XAMPP предоставляет веб-сервер (Apache), PHP и MariaDB в одном пакете.  

### 🔧 Шаги установки:  
1. **Скачайте XAMPP** с официального сайта:  
   🌐 [https://www.apachefriends.org/download.html](https://www.apachefriends.org/download.html)  
   *(Выберите версию для вашей ОС: Windows, Linux или macOS)*  

2. **Запустите установщик** и следуйте инструкциям:  
   - Выберите компоненты: **Apache, MySQL (MariaDB), PHP, phpMyAdmin**  
   - Установите в `C:\xampp` (по умолчанию)  

3. **Запустите XAMPP Control Panel** и стартуйте:  
   - 🟢 **Apache**  
   - 🟢 **MySQL (MariaDB)**  

4. **Проверьте работу:**  
   Откройте в браузере:  
   🌐 [http://localhost](http://localhost) → Должна открыться страница XAMPP.  

---

## 🎵 2. Установка Composer  
Composer нужен для управления зависимостями PHP.  

### 🔧 Шаги установки:  
1. **Скачайте Composer** с официального сайта:  
   🌐 [https://getcomposer.org/download/](https://getcomposer.org/download/)  

2. **Запустите установщик** и следуйте инструкциям:  
   - Выберите **"Use the PHP from XAMPP"** (укажите путь к PHP, например: `C:\xampp\php\php.exe`)  
   - Добавьте Composer в **PATH**  

3. **Проверьте установку:**  
   ```bash
   composer --version


## 3. 💻 Установка Visual Studio Code (VS Code)

VS Code - мощный редактор для разработки с поддержкой PHP.

### 📥 Шаги установки:
1. Скачайте VS Code с [официального сайта](https://code.visualstudio.com/download)
2. Установите и запустите программу
3. Откройте папку с проектом

   ### 🔌 Рекомендуемые расширения:
| Расширение | Назначение | Ссылка |
|------------|------------|--------|
| PHP Intelephense | Поддержка PHP | [Установить](https://marketplace.visualstudio.com/items?itemName=bmewburn.vscode-intelephense-client) |
| MySQL | Работа с базами данных | [Установить](https://marketplace.visualstudio.com/items?itemName=cweijan.vscode-mysql-client2) |
| DotENV | Подсветка .env файлов | [Установить](https://marketplace.visualstudio.com/items?itemName=mikestead.dotenv) |


### ⚙️ Конфигурация .env:
Создайте файл .env в корне проекта со следующим содержимым:


DB_HOST=localhost
DB_NAME=apparta
DB_USER=root
DB_PASS=
______________________

### 📦 Установка зависимостей:
Откройте терминал в папке проекта и выполните:


composer require vlucas/phpdotenv
composer require setasign/fpdf
composer require tecnickcom/tcpdf

### 🚀 Запуск проекта:
Откройте в браузере:
http://localhost/cybermath
