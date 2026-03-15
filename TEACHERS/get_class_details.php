<?php
session_start();
$conn = new mysqli("127.0.0.1:3307", "root", "", "ds411");
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$className = $_POST['className'] ?? '';

if (empty($className)) {
    exit("<p style='text-align:center; color:gray;'>No class name provided.</p>");
}

$stmt = $conn->prepare("
    SELECT student_name, avater_name, teacher_name, color
    FROM class_student
    WHERE class_name = ?
");
$stmt->bind_param("s", $className);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo '
    <div id="teacherInfo">
        <div class="row-content">
            <div class="left-part" style="margin-bottom: 10px;">
                <p class="main-text">Waiting for students to join this class.</p>
            </div>
        </div>
    </div>';
}

$rows = $result->fetch_all(MYSQLI_ASSOC);
$teacherName = htmlspecialchars($rows[0]['teacher_name']);
$teacherColor = htmlspecialchars($rows[0]['color']);
?>


<div id="teacherInfo">
  <div class="row-content">
    <div class="left-part">
      <div class="content" style="background-color: <?= $teacherColor ?>;">
        <p class="content-font">Mr</p>
      </div>
      <p class="main-text"><?= $teacherName ?></p>
    </div>
  </div>
</div>


<div id="studentList">
<?php foreach ($rows as $r): ?>
  <div class="row-content student-item">
    <div class="left-part">
      <div class="content" style="background-color: <?= htmlspecialchars($r['color']) ?>;">
        <p class="content-font"><?= htmlspecialchars($r['avater_name']) ?></p>
      </div>
      <p class="main-text"><?= htmlspecialchars($r['student_name']) ?></p>
    </div>
  </div>
<?php endforeach; ?>
</div>

<?php
$stmt->close();
$conn->close();
?>
