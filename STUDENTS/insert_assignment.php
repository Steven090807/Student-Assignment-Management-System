<?php
$conn = new mysqli("127.0.0.1:3307", "root", "", "ds411");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$class_name = $_POST['class_name'] ?? '';
$homework_title = $_POST['homework_title'] ?? '';

if (isset($_FILES['file']) && !empty($_FILES['file']['name']) && !empty($class_name) && !empty($homework_title)) {
    $fileName = basename($_FILES['file']['name']);
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $targetDir = "uploads/";

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $uniqueName = uniqid("upload_", true) . "." . $fileType;
    $targetFile = $targetDir . $uniqueName;

    $allowedTypes = ['pdf', 'doc', 'docx', 'jpg', 'png', 'zip'];
    if (!in_array($fileType, $allowedTypes)) {
        echo "⚠️ Invalid file type. Allowed: pdf, doc, docx, jpg, png, zip.";
        exit;
    }

    if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $currentTime = date("Y-m-d H:i:s");
        $submitNote = "#32cd32";

        $stmt = $conn->prepare("
            INSERT INTO student_assignments 
            (file_path, file_type, submit_time, submit_note, homework_title, class_name) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("ssssss", $targetFile, $fileType, $currentTime, $submitNote, $homework_title, $class_name);

        if ($stmt->execute()) {
            echo "✅ File uploaded and saved successfully!";
        } else {
            echo "❌ Database insert failed: " . htmlspecialchars($stmt->error);
        }

        $stmt->close();
    } else {
        echo "❌ Failed to move uploaded file.";
    }
} else {
    echo "⚠️ Missing file, class name, or homework title.";
}

$conn->close();
?>
