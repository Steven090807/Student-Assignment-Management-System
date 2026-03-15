<?php 
include('class/User.php');
$user = new User();
$user->loginStatus();
include('include/header.php');
?>
<title>Teacher Management System</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php include('include/container.php');?>
<link rel="stylesheet" href="CSS/classwork_02.css">
<?php include 'menu.php'; ?>
<?php
$conn = new mysqli("127.0.0.1:3307", "root", "", "ds411");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$homework_title = isset($_GET['homework_title']) ? urldecode($_GET['homework_title']) : '';
$className = isset($_GET['className']) ? $conn->real_escape_string($_GET['className']) : '';

$noteResult = $conn->query("SELECT submit_note FROM student_assignments ORDER BY id DESC LIMIT 1");
$submitNote = "#8a988aff";

if (!empty($homework_title) && !empty($className)) {
    $stmt = $conn->prepare("
        SELECT submit_note 
        FROM student_assignments 
        WHERE homework_title = ? AND class_name = ?
        ORDER BY id DESC 
        LIMIT 1
    ");
    $stmt->bind_param("ss", $homework_title, $className);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $noteRow = $result->fetch_assoc();
        $submitNote = $noteRow['submit_note'];
    }

    $stmt->close();
}

if (empty($homework_title) || empty($className)) {
    echo "<p style='color:gray; text-align:center;'>Invalid homework title or class name.</p>";
    exit;
}

$stmt = $conn->prepare("
    SELECT homework_title, posted_time, due_datetime, file_type, file_path 
    FROM classwork_assignments 
    WHERE homework_title = ? AND class_name = ?
");
$stmt->bind_param("ss", $homework_title, $className);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows === 0){
    echo "<p style='color:gray; text-align:center;'>Assignment not found.</p>";
    exit;
}

$teacherName = isset($_SESSION['teacher_name']) ? $_SESSION['teacher_name'] : 'Mr Unknown';

$firstRow = $result->fetch_assoc();
$postedTime = !empty($firstRow['posted_time']) ? date('g:i A', strtotime($firstRow['posted_time'])) : '-';
$dueTime = !empty($firstRow['due_datetime']) ? "Due to " . date('j M, H:i', strtotime($firstRow['due_datetime'])) : 'No due date';
?>

<div class="assignmnet-title">
  <div class="assignmnet"> 
    <div class="content">
        <img src="IMAGES/notes.png" width="30" height="30" alt="Note">
    </div>
    <p class="main-text"><?= htmlspecialchars($firstRow['homework_title']) ?></p>
  </div>

  <div class="extra-row">
    <div class="left-part">
      <p class="sub-text"><?= $teacherName ?> • <span>Posted at <?= $postedTime ?></span></p>
    </div>
    <div class="right-part">
      <p class="sub-text"><?= $dueTime ?></p>
    </div>
  </div>

  <hr style="border: 1px solid #d3d3d3ff; margin-top: -10px;">

  <div class="row">
    <?php 
    $file_paths = json_decode($firstRow['file_path'], true);
    $file_types = json_decode($firstRow['file_type'], true);

    if (!is_array($file_paths)) {
        $file_paths = $firstRow['file_path'] ? [$firstRow['file_path']] : [];
    }
    if (!is_array($file_types)) {
        $file_types = $firstRow['file_type'] ? [$firstRow['file_type']] : [];
    }

    foreach ($file_paths as $index => $file_path):
        $type = isset($file_types[$index]) ? strtoupper($file_types[$index]) : strtoupper(pathinfo($file_path, PATHINFO_EXTENSION));
        $baseName = basename($file_path);
        $displayName = (strlen($baseName) > 19) ? substr($baseName, 0, 19) . "..." : $baseName;
    ?>
        <div class="col-md-4">
            <div class="upload-box">
                <div class="upload-box-back"></div>
                <div class="file-style"><?= htmlspecialchars($type) ?></div>
                <hr class="upload-hr">
                <div class="file-name">
                    <p>
                        <a href="../TEACHER/classwork_02.php<?= htmlspecialchars($file_path) ?>" target="_blank" title="<?= htmlspecialchars($baseName) ?>">
                            <?= htmlspecialchars($displayName) ?>
                        </a>
                    </p>
                    <p><?= htmlspecialchars($type) ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <?php 
    while ($row = $result->fetch_assoc()):
        $file_paths = json_decode($row['file_path'], true);
        $file_types = json_decode($row['file_type'], true);

        if (!is_array($file_paths)) {
            $file_paths = $row['file_path'] ? [$row['file_path']] : [];
        }
        if (!is_array($file_types)) {
            $file_types = $row['file_type'] ? [$row['file_type']] : [];
        }

        foreach ($file_paths as $index => $file_path):
            $type = isset($file_types[$index]) ? strtoupper($file_types[$index]) : strtoupper(pathinfo($file_path, PATHINFO_EXTENSION));
            $baseName = basename($file_path);
            $displayName = (strlen($baseName) > 19) ? substr($baseName, 0, 19) . "..." : $baseName;
    ?>
        <div class="col-md-4">
            <div class="upload-box">
                <div class="upload-box-back"></div>
                <div class="file-style"><?= htmlspecialchars($type) ?></div>
                <hr class="upload-hr">
                <div class="file-name">
                    <p>
                        <a href="<?= htmlspecialchars($file_path) ?>" target="_blank" title="<?= htmlspecialchars($baseName) ?>">
                            <?= htmlspecialchars($displayName) ?>
                        </a>
                    </p>
                    <p><?= htmlspecialchars($type) ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; endwhile; ?>
  </div>

  <hr style="border: 1px solid #d3d3d3ff;">
</div>

<?php
$stmt->close();
$conn->close();
?>


  <form id="uploadForm" enctype="multipart/form-data">
    <div class="submit-wrapper">
        <div class="image-box">
        <img src="IMAGES/submit_left.png" width="200px" height="90px" style="margin-top: -80px;">
        <div class="image-left-text">Time remaining:</div>
        <div class="imagebox-left-text" id="countdownHour">--:--:--</div>
        </div>

        <div class="submit-panel-all">
        <div class="submit-panel-back"></div>
        <div class="submit-panel">
            <h3>Submit by <span class="status" style="color: <?= htmlspecialchars($submitNote) ?>;">Assigned</span></h3>

            <input type="hidden" name="class_name" value="<?= htmlspecialchars($className); ?>">
            <input type="hidden" name="homework_title" value="<?= htmlspecialchars($homework_title); ?>">

            <label class="submit-btn" for="file-btn">File</label>
            <input type="file" id="file-btn" name="file" style="display:none;" required>

            <button type="button" class="submit-btn link" id="submitBtn">Submit</button>

            <div class="or-divider">or</div>

            <div class="drag-area">
            <img src="IMAGES/drop_icon.png" alt="Upload">
            Drag files here
            </div>
        </div>
        </div>

        <div class="image-box">
        <img src="IMAGES/submit_right.png" width="200px" height="200px" style="margin-top: 120px;">
        <div class="image-right-text">Day remaining:</div>
        <div class="imagebox-right-text" id="countdownDay">0 Day</div>
        </div>
    </div>
  </form>


<script>

function MinWidth() {
  if (window.innerWidth < 790) {
    document.body.classList.add("too-small");
  } else {
    document.body.classList.remove("too-small");
  }
}
window.addEventListener("resize", MinWidth);
window.addEventListener("load", MinWidth);

function toggleRow(element) {
  element.classList.toggle("expanded");
}


const dueDateTime = "<?= !empty($firstRow['due_datetime']) ? date('Y-m-d H:i:s', strtotime($firstRow['due_datetime'])) : '' ?>";

function startCountdown(dueDateTime) {
const countdownElement = document.getElementById('countdownHour');
const dayElement = document.getElementById('countdownDay');
const dueTime = new Date(dueDateTime.replace(' ', 'T')).getTime();

function updateCountdown() {
    const now = new Date().getTime();
    const diff = dueTime - now;

    if (diff <= 0) {
    countdownElement.textContent = "00:00:00";
    dayElement.textContent = "Expired";
    clearInterval(timer);
    return;
    }

    const totalSeconds = Math.floor(diff / 1000);
    const totalHours = Math.floor(totalSeconds / 3600);
    const minutes = Math.floor((totalSeconds % 3600) / 60);
    const seconds = totalSeconds % 60;

    countdownElement.textContent = `${String(totalHours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
    const rightText = document.querySelector('.imagebox-right-text');
    const leftText = document.querySelector('.imagebox-left-text');

    let dayText = "";
    if (totalHours < 24) {
        dayText = "Last day";
        rightText.style.right = "41px";
    } else {
        const daysLeft = Math.min(Math.ceil(totalHours / 24), 31);
        dayText = `${daysLeft} Day${daysLeft > 1 ? "s" : ""}`;

        if (totalHours > 100) {
            leftText.style.left = "40px";
            
        } else {
            leftText.style.left = ""; 
        }
        rightText.style.right = "";
    }

    dayElement.textContent = dayText;
}

updateCountdown();
const timer = setInterval(updateCountdown, 1000);
}

startCountdown(dueDateTime);


document.getElementById("submitBtn").addEventListener("click", function () {
  const uploadForm = document.getElementById("uploadForm");
  const fileInput = document.getElementById("file-btn");

  if (!fileInput.files.length) {
    alert("Please select a file before submitting.");
    return;
  }

  const formData = new FormData(uploadForm);

  fetch("insert_assignment.php", {
    method: "POST",
    body: formData
  })
    .then(response => response.text())
    .then(data => {
      alert(data);
      location.reload();
    })
    .catch(error => console.error("Upload failed:", error));
});

</script>

<?php include('include/footer.php');?>