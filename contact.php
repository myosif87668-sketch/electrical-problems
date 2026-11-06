<?php

require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('طريقة الطلب غير مسموحة.');
}

verify_csrf();

$name = trim($_POST['name'] ?? '');
$email = strtolower(trim($_POST['email'] ?? ''));
$message = trim($_POST['message'] ?? '');

if (mb_strlen($name) < 3 || mb_strlen($name) > 100) {
    exit('يرجى إدخال الاسم بصورة صحيحة.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit('البريد الإلكتروني غير صحيح.');
}

if (mb_strlen($message) < 5 || mb_strlen($message) > 3000) {
    exit('يرجى كتابة رسالة صحيحة.');
}

$stmt = $pdo->prepare(
    "INSERT INTO contact_messages (name, email, message)
     VALUES (?, ?, ?)"
);

$stmt->execute([$name, $email, $message]);

echo 'تم إرسال رسالتك بنجاح. شكراً لتواصلك معنا.';