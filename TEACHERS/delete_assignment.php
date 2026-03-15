<?php
$conn = new mysqli("127.0.0.1:3307", "root", "", "ds411");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['homework_title']) && isset($_GET['className'])) {
    $homework_title = $conn->real_escape_string(urldecode($_GET['homework_title']));
    $className = $conn->real_escape_string(urldecode($_GET['className']));

    $sql = "DELETE FROM classwork_assignments WHERE homework_title = '$homework_title' AND class_name = '$className'";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Assignment deleted successfully!'); window.location.href='classwork_01.php?className=" . urlencode($className) . "';</script>";
    } else {
        echo "<script>alert('Error deleting assignment: " . $conn->error . "'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.history.back();</script>";
}

$conn->close();
?>
