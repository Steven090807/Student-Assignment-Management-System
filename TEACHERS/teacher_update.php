<?php
$conn = new mysqli("127.0.0.1:3307", "root", "", "ds411");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_FILES['file']) && isset($_POST['homework_title'])) {
    $homework_title = $conn->real_escape_string($_POST['homework_title']);
    $fileName = basename($_FILES['file']['name']);
    $fileTmp = $_FILES['file']['tmp_name'];
    $uploadDir = "uploads/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $targetPath = $uploadDir . $fileName;

    if (move_uploaded_file($fileTmp, $targetPath)) {
        $sql = "INSERT INTO homework_files (homework_title, file_name) VALUES ('$homework_title', '$fileName')";

        if ($conn->query($sql) === TRUE) {
            echo "✅ File uploaded and inserted successfully!";
        } else {
            echo "❌ Database insert failed: " . $conn->error;
        }
    } else {
        echo "❌ File upload failed!";
    }
} else {
    echo "⚠️ No file or title provided!";
}

$conn->close();
?>