<?php

require_once __DIR__ . '/db.php';

// التأكد من أن المستخدم سجل دخوله
function require_login(): void {

    if (empty($_SESSION['user_id'])) {
        header('Location: ../login.html');
        exit;
    }
}

// التحقق من صلاحية المدير
function require_admin(): void {

    require_login();

    if (($_SESSION['role'] ?? '') !== 'admin') {
        http_response_code(403);
        exit("ليس لديك صلاحية للوصول إلى هذه الصفحة.");
    }
}