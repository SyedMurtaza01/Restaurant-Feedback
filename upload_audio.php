<?php

$uploadDir = 'uploads/';

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if ($_FILES['audio']['error'] === UPLOAD_ERR_OK) {

    $fileTmpPath = $_FILES['audio']['tmp_name'];
    $fileName = $_FILES['audio']['name'];
    $filePath = $uploadDir . $fileName;

    if (move_uploaded_file($fileTmpPath, $filePath)) {
        echo json_encode(['filePath' => $filePath]);
    } else {
        echo json_encode(['error' => 'Failed to upload the file.']);
    }
} else {
    echo json_encode(['error' => 'Error with the file upload.']);
}
?>
