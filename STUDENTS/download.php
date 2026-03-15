<?php
if (!isset($_GET['file'])) {
    die("No file specified.");
}

$file = basename($_GET['file']);
$filepath = __DIR__ . '/uploads/' . $file;

if (file_exists($filepath)) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $filepath);
    finfo_close($finfo);

    header('Content-Description: File Transfer');
    header('Content-Type: ' . $mime);
    header('Content-Disposition: inline; filename="' . $file . '"');
    header('Content-Length: ' . filesize($filepath));
    readfile($filepath);
    exit;
} else {
    echo "File not found.";
}
?>
