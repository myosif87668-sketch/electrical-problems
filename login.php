<?php

require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('طريقة الطلب غير مسموحة.');
}

verify_csrf();

$email = strtolower(trim($_POST['email'] ?? ''));
$password = $_POST['password'] ?? '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL) ||
    !is_string($password) || $password === '') {
    exit('يرجى إدخال البريد الإلكتروني وكلمة المرور بصورة صحيحة.');
}

$stmt = $pdo->prepare(
    "SELECT id, name, email, password, role
     FROM users
     WHERE email = ?
     LIMIT 1"
);

$stmt->execute([$email]);

$user = $stmt->fetch();

if (!$user || !password_verify($password, $user['password'])) {
    exit('البريد الإلكتروني أو كلمة المرور غير صحيحة.');
}

// تجديد معرف الجلسة بعد نجاح الدخول
session_regenerate_id(true);

// حفظ بيانات المستخدم في الجلسة
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['name'];
$_SESSION['user_email'] = $user['email'];
$_SESSION['role'] = $user['role'];

// الانتقال إلى صفحة تقديم البلاغ
header('Location: ../report.html');
exit;