<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = $_POST['rating'];
    $audioFile = $_POST['audioFile'];
    $mobileNumber = $_POST['mobileNumber'];

    if (!empty($mobileNumber) && !preg_match('/^\+?[0-9]{10,15}$/', $mobileNumber)) {
        echo json_encode(['success' => false, 'message' => 'Invalid mobile number format.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO feedback (rating, voice_note, mobile_number) VALUES (?, ?, ?)");
        $stmt->execute([$rating, $audioFile, $mobileNumber]);
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
}
?>
