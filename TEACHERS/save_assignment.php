<?php
$conn = new mysqli("127.0.0.1:3307", "root", "", "ds411");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $topic = trim($_POST['topic'] ?? '');
    $homework_title = trim($_POST['homework_title'] ?? '');
    $due_datetime = $_POST['due_datetime'] ?? '';
    $class_name = trim($_POST['class_name'] ?? '');
    $submit_note = trim($_POST['submit_note'] ?? '');
    $posted_time = date('Y-m-d H:i:s');

    $file_paths = [];
    $file_types = [];

    if (isset($_FILES['file']) || isset($_FILES['files'])) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $filesArray = isset($_FILES['files']) ? $_FILES['files'] : $_FILES['file'];

        if (!is_array($filesArray['name'])) {
            $filesArray = [
                'name' => [$filesArray['name']],
                'tmp_name' => [$filesArray['tmp_name']],
                'error' => [$filesArray['error']]
            ];
        }

        foreach ($filesArray['tmp_name'] as $index => $tmp_name) {
            if ($filesArray['error'][$index] === UPLOAD_ERR_OK) {
                $originalName = basename($filesArray['name'][$index]);
                $ext = pathinfo($originalName, PATHINFO_EXTENSION);
                $uniqueName = time() . '_' . uniqid() . '.' . $ext;
                $targetFile = $upload_dir . $uniqueName;

                if (move_uploaded_file($tmp_name, $targetFile)) {
                    $file_paths[] = $targetFile;
                    $file_types[] = $ext;
                }
            }
        }
    }

    $file_paths_json = json_encode($file_paths, JSON_UNESCAPED_SLASHES);
    $file_types_json = json_encode($file_types);

    $sql = "INSERT INTO classwork_assignments 
            (topic, homework_title, due_datetime, file_path, file_type, submit_note, posted_time, class_name)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", 
        $topic, 
        $homework_title, 
        $due_datetime, 
        $file_paths_json, 
        $file_types_json, 
        $submit_note, 
        $posted_time, 
        $class_name
    );

    if ($stmt->execute()) {
        echo "✅ Assignment inserted successfully!";
    } else {
        echo "❌ Error inserting assignment: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
