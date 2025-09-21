<?php
// إعدادات قاعدة البيانات (اختياري)
$servername = "localhost";
$username = "your_db_username";
$password = "your_db_password";
$dbname = "your_database_name";

// معالجة النموذج
if ($_POST) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
    
    // التحقق من البيانات
    if (empty($name) || empty($email) || empty($message)) {
        echo json_encode(['status' => 'error', 'message' => 'يرجى ملء جميع الحقول']);
        exit;
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'البريد الإلكتروني غير صحيح']);
        exit;
    }
    
    // إرسال بريد إلكتروني
    $to = "info@yourwebsite.com";
    $subject = "رسالة جديدة من موقع السعودية لك";
    $body = "الاسم: $name\n";
    $body .= "البريد الإلكتروني: $email\n";
    $body .= "الرسالة: $message\n";
    
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    
    if (mail($to, $subject, $body, $headers)) {
        echo json_encode(['status' => 'success', 'message' => 'تم إرسال رسالتك بنجاح']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'حدث خطأ في إرسال الرسالة']);
    }
    
    // حفظ في قاعدة البيانات (اختياري)
    /*
    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $pdo->prepare("INSERT INTO contacts (name, email, message, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$name, $email, $message]);
        
    } catch(PDOException $e) {
        error_log("Database error: " . $e->getMessage());
    }
    */
}
?>