<?php

require_once __DIR__ . '/auth.php';

require_login();

$stmt = $pdo->prepare(
    "SELECT report_code, fault_type, location,
            description, status, created_at
     FROM reports
     WHERE user_id = ?
     ORDER BY created_at DESC"
);

$stmt->execute([$_SESSION['user_id']]);

$reports = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>متابعة البلاغات</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div class="container">

    <h1>متابعة بلاغات أعطال الكهرباء</h1>

    <?php if (empty($reports)): ?>

        <p>لا توجد بلاغات مسجلة حتى الآن.</p>

    <?php else: ?>

        <?php foreach ($reports as $report): ?>

            <div class="report-card">

                <h3>
                    رقم البلاغ:
                    <?= clean($report['report_code']) ?>
                </h3>

                <p>نوع العطل:
                    <?= clean($report['fault_type']) ?>
                </p>

                <p>الموقع:
                    <?= clean($report['location']) ?>
                </p>

                <p>الوصف:
                    <?= clean($report['description']) ?>
                </p>

                <p>الحالة:
                    <?= clean($report['status']) ?>
                </p>

                <p>تاريخ البلاغ:
                    <?= clean($report['created_at']) ?>
                </p>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>

    <a href="../report.html">تقديم بلاغ جديد</a>

</div>

</body>
</html>