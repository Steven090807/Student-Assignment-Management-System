<?php
$conn = new mysqli("127.0.0.1:3307", "root", "", "ds411");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $note_id = intval($_POST['note_id']);
    $note_title = trim($_POST['note_title']);
    $note_content = trim($_POST['note_content']);
    $class_name = trim($_POST['class_name']);

    $sql = "UPDATE classwork_note 
            SET note_title = ?, note_content = ?, created_at = NOW() 
            WHERE note_id = ? AND class_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssis", $note_title, $note_content, $note_id, $class_name);

    if ($stmt->execute()) {
        echo "✅ Note updated successfully!";
    } else {
        echo "❌ Error updating note: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "✅ can't update";
}
$conn->close();
?>
