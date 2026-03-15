<?php
session_start();

if (!isset($_SESSION['student_name'])) {
    echo "Please login first.";
    exit;
}

$studentName = $_SESSION['student_name'];
$avatarName = strtoupper($studentName[0]);
$className = $_POST['className'] ?? '';

if (empty($className)) {
    echo "No class name provided.";
    exit;
}

$conn = new mysqli("127.0.0.1:3307", "root", "", "ds411");
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT class_name, teacher_name, color FROM class_teacher WHERE class_name = ?");
$stmt->bind_param("s", $className);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $class_name = $row['class_name'];
    $teacher_name = $row['teacher_name'];
    $color = $row['color'];

    $check = $conn->prepare("SELECT * FROM class_student WHERE class_name = ? AND student_name = ?");
    $check->bind_param("ss", $class_name, $studentName);
    $check->execute();
    $checkResult = $check->get_result();

    if ($checkResult->num_rows > 0) {
        echo "You have already joined this class.";
    } else {
        $insert = $conn->prepare("INSERT INTO class_student (class_name, teacher_name, color, student_name, avater_name) VALUES (?, ?, ?, ?, ?)");
        $insert->bind_param("sssss", $class_name, $teacher_name, $color, $studentName, $avatarName);

        if ($insert->execute()) {
            echo "Joined class successfully! Click refresh to see.";
        } else {
            echo "Failed to join class.";
        }
        $insert->close();
    }

    $check->close();
} else {
    echo "Class not found.";
}

$stmt->close();
$conn->close();
?>
