<?php

require_once __DIR__ . '/auth.php';

require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('طريقة الطلب غير مسموحة.');
}

verify_csrf();

$type = trim($_POST['fault_type'] ?? '');
$location = trim($_POST['location'] ?? '');
$description = trim($_POST['description'] ?? '');
$phone = trim($_POST['phone'] ?? '');

$allowedTypes = [
    'انقطاع الكهرباء',
    'عطل في المحول',
    'سقوط أسلاك الكهرباء',
    'ضعف التيار',
    'أخرى'
];

if (!in_array($type, $allowedTypes, true)) {
    exit('نوع العطل غير صحيح.');
}

if ($location === '' || mb_strlen($location) > 255) {
    exit('يرجى إدخال موقع العطل بصورة صحيحة.');
}

if ($description === '' || mb_strlen($description) < 10 ||
    mb_strlen($description) > 3000) {
    exit('يرجى كتابة وصف للعطل لا يقل عن 10 أحرف.');
}

if (!preg_match('/^[0-9+\-\s()]{7,20}$/', $phone)) {
    exit('رقم الهاتف غير صحيح.');
}

// إنشاء رقم مرجعي للبلاغ
$reportCode = 'ELEC-' . strtoupper(bin2hex(random_bytes(5)));

$stmt = $pdo->prepare(
    "INSERT INTO reports
    (user_id, report_code, fault_type, location, description, phone, status)
    VALUES (?, ?, ?, ?, ?, ?, 'pending')"
);

$stmt->execute([
    $_SESSION['user_id'],
    $reportCode,
    $type,
    $location,
    $description,
    $phone
]);

echo '<h2>تم إرسال البلاغ بنجاح</h2>';
echo '<p>رقم البلاغ: ' . clean($reportCode) . '</p>';
echo '<a href="../track.html">متابعة البلاغ</a>';