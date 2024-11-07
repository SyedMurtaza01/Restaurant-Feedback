<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = $_POST['rating'];
    $audioFile = $_POST['audioFile']; 

    $stmt = $pdo->prepare("INSERT INTO feedback (rating, voice_note) VALUES (?, ?)");
    $stmt->execute([$rating, $audioFile]);

    echo json_encode(['success' => true]);
}
?>
