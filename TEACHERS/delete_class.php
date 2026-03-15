<?php
$conn = new mysqli("127.0.0.1:3307", "root", "", "ds411");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$className = isset($_GET['className']) ? trim($_GET['className']) : '';

if (!empty($className)) {
    $stmt = $conn->prepare("DELETE FROM class_teacher WHERE class_name = ?");
    $stmt->bind_param("s", $className);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "missing_class";
}

$conn->close();
?>
