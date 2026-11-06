<?php

require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('طريقة الطلب غير مسموحة.');
}

verify_csrf();

$name = trim($_POST['name'] ?? '');
$email = strtolower(trim($_POST['email'] ?? ''));
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirm_password'] ?? '';

// التحقق من الاسم
if ($name === '' || mb_strlen($name) < 3 || mb_strlen($name) > 100) {
    exit('الاسم يجب أن يكون بين 3 و100 حرف.');
}

// التحقق من البريد الإلكتروني
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit('البريد الإلكتروني غير صحيح.');
}

// التحقق من كلمة المرور
if (strlen($password) < 8) {
    exit('كلمة المرور يجب ألا تقل عن 8 أحرف.');
}

if ($password !== $confirm) {
    exit('كلمتا المرور غير متطابقتين.');
}

try {

    // التأكد من عدم وجود حساب سابق
    $check = $pdo->prepare(
        "SELECT id FROM users WHERE email = ? LIMIT 1"
    );

    $check->execute([$email]);

    if ($check->fetch()) {
        exit('هذا البريد الإلكتروني مسجل بالفعل.');
    }

    // تشفير كلمة المرور
    $hashedPassword = password_hash(
        $password,
        PASSWORD_DEFAULT
    );

    // حفظ الحساب
    $stmt = $pdo->prepare(
        "INSERT INTO users (name, email, password, role)
         VALUES (?, ?, ?, 'user')"
    );

    $stmt->execute([
        $name,
        $email,
        $hashedPassword
    ]);

    header('Location: ../login.html?registered=1');
    exit;

} catch (PDOException $e) {

    error_log($e->getMessage());
    http_response_code(500);
    exit('تعذر إنشاء الحساب حالياً.');

}