<?php
session_start();

if (!isset($_SESSION['teacher_name'])) {
    exit("⚠️ Please login first.");
}

$conn = new mysqli("127.0.0.1:3307", "root", "", "ds411");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$className   = trim($_POST['className'] ?? '');
$teacherName = $_SESSION['teacher_name'];
$avatarName  = strtoupper($teacherName[0]);
$color       = '#3D3BB7';

if (empty($className)) {
    exit("⚠️ Please enter a class name.");
}

$check = $conn->prepare("SELECT class_name FROM class_teacher WHERE class_name = ?");
$check->bind_param("s", $className);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    echo "⚠️ This class name already exists. Please choose another name.";
} else {
    $stmt = $conn->prepare("INSERT INTO class_teacher (class_name, teacher_name, avater_name, color) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $className, $teacherName, $avatarName, $color);

    echo $stmt->execute()
        ? "Class created successfully! Click refresh to see."
        : "Error creating class.";

    $stmt->close();
}

$check->close();
$conn->close();
?>
