<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из формы
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Указываем получателя и тему письма
    $to = "info@cybermath.com";
    $subject = "Новое сообщение с сайта";

    // Формируем тело письма
    $body = "Имя: $name\nEmail: $email\nСообщение:\n$message";

    // Заголовки письма
    $headers = "From: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $headers .= "Content-Transfer-Encoding: base64\r\n";

    // Отправляем письмо
    if (mail($to, $subject, base64_encode($body), $headers)) {
        echo "Сообщение отправлено!";
    } else {
        echo "Ошибка отправки сообщения!";
    }
}
?>
