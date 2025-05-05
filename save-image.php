<?php
// استقبال البيانات
$data = json_decode(file_get_contents("php://input"), true);
$name = preg_replace('/[^a-zA-Z0-9-_ءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى\s]/u', '', $data['name']);
$imageData = $data['image'];

// تحويل DataURL إلى صورة فعلية
if (preg_match('/^data:image\/png;base64,/', $imageData)) {
    $imageData = str_replace('data:image/png;base64,', '', $imageData);
    $imageData = str_replace(' ', '+', $imageData);
    $decoded = base64_decode($imageData);

    // تأكد من وجود مجلد التخزين
    $folder = __DIR__ . '/image-user-print';
    if (!file_exists($folder)) {
        mkdir($folder, 0775, true);
    }

    // حفظ الصورة بالاسم داخل المجلد
    $fileName = $folder . '/معايدة - ' . $name . '.png';
    file_put_contents($fileName, $decoded);

    echo json_encode(['status' => 'success', 'path' => $fileName]);
    exit;
}

echo json_encode(['status' => 'error']);
?>
