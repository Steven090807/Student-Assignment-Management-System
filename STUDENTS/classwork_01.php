<?php 
include('class/User.php');
$user = new User();
$user->loginStatus();
include('include/header.php');
$conn = new mysqli("127.0.0.1:3307", "root", "", "ds411");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<title>Teacher Management System</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php include('include/container.php');?>
<link rel="stylesheet" href="CSS/classwork_01.css">
<?php include 'menu.php'; ?>
<hr id="top">
<div class="note-function">
  <div class="note"> 
    <span>
      <img src="IMAGES/notes.png" width="30" height="30" alt="Note"> Note
    </span>
  </div>
  
  <div class="row"> 
  <?php
  $className = isset($_GET['className']) ? $conn->real_escape_string($_GET['className']) : '';

  if (!empty($className)) {
      $result = $conn->query("SELECT * FROM classwork_note WHERE class_name = '$className'  ORDER BY note_id ASC");

      if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              ?>
              <div class="col-md-6">
                <div class="note-box" data-id="<?= htmlspecialchars($row['note_id']) ?>">
                  <div class="note-header">
                    <span id="title"><?= htmlspecialchars($row['note_title']) ?></span>
                  </div>
                  <hr style="border: 1px solid #e5e4e2; margin-bottom: 8px;">
                  <p class="note-content"><?= nl2br(htmlspecialchars($row['note_content'])) ?></p>
                </div>
              </div>
              <?php
          }
      } else {
          ?>
          <div class="col-md-6">
            <div class="note-box">
              <div class="note-header">
                <span id="title">Waiting for teacher input...</span>
              </div>
              <hr style="border: 1px solid #e5e4e2; margin-bottom: 8px;">
              <p></p>
            </div>
          </div>

          <div class="col-md-6">
            <div class="note-box">
              <div class="note-header">
                <span id="title">Waiting for teacher input...</span>
              </div>
              <hr style="border: 1px solid #e5e4e2; margin-bottom: 8px;">
              <p></p>
            </div>
          </div>
          <?php
      }
  } else {
      echo "<p style='color:gray;'>No class selected.</p>";
  }

  $conn->close();
  ?>
</div>

</div>

<div class="task-function">
  <div class="task"> 
    <span>
       <img src="IMAGES/task (1).png" width="27" height="27" alt="Task"> Task 
    </span>
    <div class="dropdown">
        <button class="panel-button dropdown-toggle" data-bs-toggle="dropdown" onclick="event.stopPropagation();">
            <img src="IMAGES/more.png" width="23" height="23" alt="More">
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item text-danger" href="#">Click In</a></li>
        </ul>
    </div>
  </div>

  <ul class="nav nav-tabs" id="assignmentTabs">
    <li class="nav-item" style="width: 70px;">
      <a class="nav-link active" href="#" data-tab="all">All</a>
    </li>
  </ul>

<?php
$conn = new mysqli("127.0.0.1:3307", "root", "", "ds411");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$className = isset($_GET['className']) ? $conn->real_escape_string($_GET['className']) : '';

if (empty($className)) {
    echo "<p style='color:gray; text-align:center;'>No class selected.</p>";
} else {
    $sql = "
        SELECT * FROM classwork_assignments 
        WHERE class_name = '$className' AND topic NOT LIKE 'Update%' 
        ORDER BY 
            topic,
            (homework_title NOT LIKE '%Study Materials%' AND homework_title NOT LIKE '%Materials%'),
            posted_time DESC
    ";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $currentTopic = '';
        echo '<div class="title-bar" id="assignmentContainer">';

        while ($row = $result->fetch_assoc()) {
            $topic = htmlspecialchars($row['topic']);
            $title = htmlspecialchars($row['homework_title']);
            $postedTime = !empty($row['posted_time']) ? date('g:i A', strtotime($row['posted_time'])) : '-';
            $dueTime = !empty($row['due_datetime']) ? date('j M, H:i', strtotime($row['due_datetime'])) : 'No due date';

            $encodedTitle = urlencode($row['homework_title']);
            $encodedClassName = urlencode($className);
            $assignmentUrl = "classwork_02.php?homework_title={$encodedTitle}&className={$encodedClassName}";

            $stmt = $conn->prepare("
                SELECT submit_note 
                FROM student_assignments 
                WHERE homework_title = ? AND class_name = ?
                ORDER BY id DESC 
                LIMIT 1
            ");
            $stmt->bind_param("ss", $row['homework_title'], $className);
            $stmt->execute();
            $noteResult = $stmt->get_result();

            $submitNote = "red";
            $statusClass = "undone";

            if ($noteResult && $noteResult->num_rows > 0) {
                $noteRow = $noteResult->fetch_assoc();
                $submitNote = $noteRow['submit_note'];
                $statusClass = "done";
            }
            $stmt->close();

            $isStudyMaterial = (stripos($title, 'study materials') !== false || stripos($title, 'materials') !== false);
            $icon = $isStudyMaterial ? 'IMAGES/book.png' : 'IMAGES/notes.png';
            $submitNoteDiv = $isStudyMaterial ? '' : "<div class='submit-note' style='background-color: {$submitNote};'></div>";

            if ($currentTopic !== $topic) {
                if ($currentTopic !== '') echo '</div>';
                echo '<div class="row-space">';
                echo "<div class='title'>{$topic}</div>";
                $currentTopic = $topic;
            }

            echo "
            <div class='row-content assignment {$statusClass}' onclick='toggleRow(this)'>
                <div class='left-part'>
                    <div class='content'>
                        <img src='{$icon}' width='30' height='30' alt='Icon'>
                    </div>
                    <p class='main-text'>{$title}</p>
                </div>
                <div class='right-part'>
                    {$submitNoteDiv}
                    <p class='sub-text'>Posted at {$postedTime}</p>
                    <div class='dropdown'>
                        <button class='panel-button dropdown-toggle sub-btn' data-bs-toggle='dropdown' onclick='event.stopPropagation();'>
                            <img class='more-icon' src='IMAGES/more.png' width='20' height='20' alt='More'>
                        </button>
                        <ul class='dropdown-menu'>
                            <li><a class='dropdown-item text-danger' href='{$assignmentUrl}'>Click In</a></li>
                        </ul>
                    </div>
                </div>
                <div class='row-extra'>
                    <hr style='margin-top: -2%; border: 1px solid #d3d3d3ff'>
                    <div class='extra-row'>
                        <p class='extra-left'><b>Due:</b> {$dueTime}</p>
                    </div>
                    <button class='view-btn' onclick=\"window.location.href='{$assignmentUrl}';\">
                        View Instructions
                    </button>
                </div>
            </div>
            ";
        }

        echo '</div>';
    } else {
        echo "<p style='color:gray; text-align:center; margin-top: 50px'>No assignments yet for this class.</p>";
    }
}

$conn->close();
?>
</div>


<script>
const popup = document.getElementById('popup');
const openBtn = document.getElementById('openPopup');
const closeBtn = document.getElementById('closePopup');
const titleInput = document.getElementById('title');
const charCount = document.getElementById('charCount');
const form = document.getElementById('assignmentForm');
const assignmentContainer = document.getElementById('assignmentContainer');

openBtn.addEventListener('click', () => popup.classList.add('active'));
closeBtn.addEventListener('click', () => popup.classList.remove('active'));
popup.addEventListener('click', (e) => {
  if (e.target === popup) popup.classList.remove('active');
});

titleInput.addEventListener('input', () => {
  charCount.textContent = `${titleInput.value.length} / 16`;
});


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


openBtn.addEventListener('click', () => popup.classList.add('active'));
closeBtn.addEventListener('click', () => popup.classList.remove('active'));
popup.addEventListener('click', (e) => {
  if (e.target === popup) popup.classList.remove('active');
});

function MinWidth() {
  document.body.classList.toggle("too-small", window.innerWidth < 790);
}
window.addEventListener("resize", MinWidth);
window.addEventListener("load", MinWidth);

function toggleRow(element) {
  element.classList.toggle('expanded');
}


document.querySelectorAll('#assignmentTabs .nav-link').forEach(tab => {
  tab.addEventListener('click', function (e) {
    e.preventDefault();

    document.querySelectorAll('#assignmentTabs .nav-link').forEach(t => t.classList.remove('active'));
    this.classList.add('active');

    const selectedTab = this.getAttribute('data-tab');
    const assignments = document.querySelectorAll('.assignment');

    assignments.forEach(a => {
      if (selectedTab === 'all') {
        a.style.display = 'block';
      } else if (a.classList.contains(selectedTab)) {
        a.style.display = 'block';
      } else {
        a.style.display = 'none';
      }
    });
  });
});

</script>

<?php include('include/footer.php');?>