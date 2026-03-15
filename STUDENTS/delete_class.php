<?php
$conn = new mysqli("127.0.0.1:3307", "root", "", "ds411");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['class_name'], $_POST['student_name'])) {
    $className = $_POST['class_name'];
    $studentName = $_POST['student_name'];

    $stmt = $conn->prepare("DELETE FROM class_student WHERE class_name = ? AND student_name = ?");
    $stmt->bind_param("ss", $className, $studentName);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
}

$conn->close();
?>
