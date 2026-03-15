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
    <div class="dropdown">
        <button class="panel-button dropdown-toggle" data-bs-toggle="dropdown" onclick="event.stopPropagation();">
            <img src="IMAGES/more.png" width="23" height="23" alt="More">
        </button>
        <ul class="dropdown-menu">
            <li>
              <a class="dropdown-item text-danger" href="#" 
                onclick="deleteAllNotes('<?php echo $className; ?>'); return false;">
                Delete All Note
              </a>
            </li>
        </ul>
    </div>
  </div>
  
  <div class="row">
    <?php
    session_start();
    $className = isset($_GET['className']) ? $conn->real_escape_string($_GET['className']) : '';

    if (!empty($className)) {
        $result = $conn->query("SELECT * FROM classwork_note WHERE class_name = '$className' ORDER BY note_id ASC");

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="col-md-6">
                  <div class="note-box" data-id="<?= htmlspecialchars($row['note_id']) ?>">
                    <div class="note-header">
                      <span id="title"><?= htmlspecialchars($row['note_title']) ?></span>
                      <button class="note-edit-btn">
                        <img src="IMAGES/edit.png" width="22" height="22" alt="Edit">
                      </button>
                    </div>
                    <hr style="border: 1px solid #e5e4e2; margin-bottom: 8px;">
                    <p class="note-content"><?= nl2br(htmlspecialchars($row['note_content'])) ?></p>
                  </div>
                </div>
                <?php
            }
        } else {
            $insert = "
                INSERT INTO classwork_note (note_id, note_title, note_content, class_name, created_at)
                VALUES 
                    ('1', 'Enter your class title', 'Enter your content', '$className', NOW()),
                    ('2', 'Enter your class title', 'Enter your content', '$className', NOW() )
            ";
            if ($conn->query($insert)) {
                echo "<script>window.location.href = window.location.href;</script>";
                exit;
            } else {
                echo "<p style='color:red;'>Error inserting default notes: " . $conn->error . "</p>";
            }
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

  <ul class="nav nav-tabs">
    <li class="nav-item" style="width: 70px;">
      <a class="nav-link active" aria-current="page" href="classwork_01.php">All</a>
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
            $fileType = strtolower($row['file_type']);

            $encodedTitle = urlencode($row['homework_title']);
            $encodedClassName = urlencode($className);
            $assignmentUrl = "classwork_02.php?homework_title={$encodedTitle}&className={$encodedClassName}";

            if ($currentTopic !== $topic) {
                if ($currentTopic !== '') echo '</div>';
                echo '<div class="row-space">';
                echo "<div class='title'>{$topic}</div>";
                $currentTopic = $topic;
            }

            $isStudyMaterial = (stripos($title, 'study materials') !== false || stripos($title, 'materials') !== false);
            $icon = $isStudyMaterial ? 'IMAGES/book.png' : 'IMAGES/notes.png';

            echo "
            <div class='row-content' onclick='toggleRow(this)'>
                <div class='left-part'>
                    <div class='content'>
                        <img src='{$icon}' width='30' height='30' alt='Icon'>
                    </div>
                    <p class='main-text'>{$title}</p>
                </div>
                <div class='right-part'>
                    <p class='sub-text'>Posted at {$postedTime}</p>
                    <div class='dropdown'>
                        <button class='panel-button dropdown-toggle sub-btn' data-bs-toggle='dropdown' onclick='event.stopPropagation();'>
                            <img class='more-icon' src='IMAGES/more.png' width='20' height='20' alt='More'>
                        </button>
                        <ul class='dropdown-menu'>
                            <li>
                                <a class='dropdown-item text-danger' 
                                  href='delete_assignment.php?homework_title={$encodedTitle}&className={$encodedClassName}' 
                                  onclick=\"return confirm('Are you sure you want to delete this assignment?');\">
                                  Delete
                                </a>
                            </li>
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
        echo '</div>';
    } else {
        echo "<p style='color:gray; text-align:center; margin-top: 50px'>No assignments yet for this class.</p>";
    }
}

$conn->close();
?>
</div>






<footer>
    <button class="btn-circle" id="openPopup">
        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="white" class="bi bi-plus" viewBox="0 0 16 16">
            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
        </svg>
        <span class="text">Add a Assignment</span>
    </button>
</footer>  
<div class="popup-overlay" id="popup">
  <div class="add-homework-btn">
    <img src="IMAGES/info-button .png" width="28" height="28" alt="Tips" id="tipsBtn" class="tips-btn">
    <button type="button" class="btn-close" id="closePopup" aria-label="Close">X</button>

    <div class="title-box">
      <img src="IMAGES/notes.png" width="30" height="30" alt="Note">
      <h2>Assignment</h2>
    </div>


    <form id="assignmentForm">
      <div class="form-group highlight-target">
        <label for="topic">Topic</label>
        <input type="text" id="topic" placeholder="Enter topic" required>
      </div>

      <div class="form-group highlight-target-two">
        <label for="homework-title">Homework Title</label>
        <input type="text" id="homework-title" placeholder="Enter homework title" required>
        <img src="IMAGES/book.png" width="32" height="32" alt="Study Materials" id="autoFillIcon">
      </div>

      <div class="form-group">
        <label for="due-date">Due Date & Time</label>
        <input type="datetime-local" id="due-date" required>
      </div>

      <div class="form-group">
        <label>Upload File</label>
        <div class="show-upload" id="showUpload"></div>
        <label for="file-btn" class="file-label">Choose File</label> 
        <input type="file" id="file-btn" style="display: none;" required>
      </div>

      <button type="submit" class="submit-btn">Assign</button>
    </form>
    <div id="tipsBox1" class="tips-box">
      <div class="tips-header">
        <img src="IMAGES/quick-tips.png" alt="Info" width="50" height="50">
        <span class="tips-title">Tips <span class="badge">1/2</span></span>
      </div>
      <p>If the topic you wrote already exists, it will be automatically added to it instead of creating a new one.</p>
      <button type="button" class="next-btn" onclick="showNextTips()">Next</button>
      <img src="IMAGES/right_arrow.png" width="400" class="arrow-img-right">
    </div>

    <div id="tipsBox2" class="tips-box" style="display: none;">
      <div class="tips-header">
        <img src="IMAGES/quick-tips.png" alt="Info" width="50" height="50">
        <span class="tips-title">Tips <span class="badge">2/2</span></span>
      </div>
      <p>Click the icon on the right to auto fill "Study Materials" Homework with this title will have no submission deadline.</p>
      <button type="button" class="next-btn" onclick="closeTips()">Got it</button>
      <img src="IMAGES/left_arrow.png" width="400" class="arrow-img-left">
    </div>
    
  </div>
  <div id="blurOverlay"></div>
</div>



<script>
const popup = document.getElementById('popup');
const openBtn = document.getElementById('openPopup');
const closeBtn = document.getElementById('closePopup');
const titleInput = document.getElementById('title');
const charCount = document.getElementById('charCount');
const form = document.getElementById('assignmentForm');
const assignmentContainer = document.getElementById('assignmentContainer');
const tipsBtn = document.getElementById('tipsBtn');
const blurOverlay = document.getElementById('blurOverlay');
const tipsBox1 = document.getElementById('tipsBox1');
const tipsBox2 = document.getElementById('tipsBox2');
const topicGroup = document.querySelector('.highlight-target');
const homeworkGroup = document.querySelector('.highlight-target-two');

tipsBtn.addEventListener('click', () => {
  blurOverlay.style.display = 'block';
  tipsBox1.style.display = 'block';
  topicGroup.classList.add('highlight');
  topicGroup.style.zIndex = '20';
});

function showNextTips() {
  tipsBox1.style.display = 'none';
  topicGroup.classList.remove('highlight');
  topicGroup.style.zIndex = '0';

  tipsBox2.style.display = 'block';
  homeworkGroup.classList.add('highlight');
  homeworkGroup.style.zIndex = '20';
}

function closeTips() {
  tipsBox2.style.display = 'none';
  blurOverlay.style.display = 'none';
  homeworkGroup.classList.remove('highlight');
  topicGroup.style.zIndex = '0';
  homeworkGroup.style.zIndex = '0';
}


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

const className = "<?= htmlspecialchars($className) ?>";

form.addEventListener('submit', function(e) {
  e.preventDefault();

  const topic = document.getElementById('topic').value.trim();
  const title = document.getElementById('homework-title').value.trim();
  const dueDate = document.getElementById('due-date').value;
  const fileInput = document.getElementById('file-btn');
  const file = fileInput.files[0];

  if (!topic || !title || !dueDate) return;

  const formData = new FormData();
  formData.append('topic', topic);
  formData.append('homework_title', title);
  formData.append('due_datetime', dueDate);
  formData.append('class_name', className);
  formData.append('submit_note', 'red');
  if (file) {
    formData.append('file', file);
  }

  fetch('save_assignment.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.text())
  .then(data => {
    console.log(data);
    if (data.includes('successfully')) {
      alert('Assignment assigned successfully!');
    } else {
      alert('Something went wrong:\n' + data);
    }
  })
  .catch(err => console.error('Error saving assignment:', err));

  const date = new Date(dueDate);
  const formattedDate = date.toLocaleString('en-MY', {
    hour: '2-digit',
    minute: '2-digit',
    hour12: true
  });

  let existingTopic = [...document.querySelectorAll('#assignmentContainer .title')]
    .find(el => el.textContent.trim().toLowerCase() === topic.toLowerCase());

  const lowerTitle = title.toLowerCase();

  const newAssignment = document.createElement('div');
  newAssignment.classList.add('row-content');
  newAssignment.setAttribute('onclick', 'toggleRow(this)');

  if (lowerTitle === 'study materials' || lowerTitle === 'materials') {
    newAssignment.innerHTML = `
      <div class="left-part">
        <div class="content">
          <img src="IMAGES/book.png" width="32" height="32" alt="Materials">
        </div>
        <p class="main-text">${title}</p>
      </div>
      <div class="right-part">
        <p class="sub-text">Posted ${formattedDate}</p>
        <div class="dropdown">
          <button class="panel-button dropdown-toggle sub-btn" data-bs-toggle="dropdown" onclick="event.stopPropagation();">
            <img class="more-icon" src="IMAGES/more.png" width="20" height="20" alt="More">
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item text-danger" href="classwork_02.php">Click In</a></li>
          </ul>
        </div>
      </div>
      <div class="row-extra">
        <hr style="margin-top: -2%; border: 1px solid #d3d3d3ff">
        <div class='extra-row'>
            <p class='extra-left'><b>Due:</b> {$dueTime}</p>
        </div>
        <button class="view-btn" onclick="window.location.href='classwork_02.php';">
          View Instructions
        </button>
      </div>
    `;
  } else {
    newAssignment.innerHTML = `
      <div class="left-part">
        <div class="content">
          <img src="IMAGES/notes.png" width="30" height="30" alt="Assignment">
        </div>
        <p class="main-text">${title}</p>
      </div>
      <div class="right-part">
        <div class="submit-note"></div>
        <p class="sub-text">Posted ${formattedDate}</p>
        <div class="dropdown">
          <button class="panel-button dropdown-toggle sub-btn" data-bs-toggle="dropdown" onclick="event.stopPropagation();">
            <img class="more-icon" src="IMAGES/more.png" width="20" height="20" alt="More">
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item text-danger" href="classwork_02.php">Click In</a></li>
          </ul>
        </div>
      </div>
      <div class="row-extra">
        <hr style="margin-top: -2%; border: 1px solid #d3d3d3ff">
        <div class='extra-row'>
            <p class='extra-left'><b>Due:</b> {$dueTime}</p>
        </div>
        <button class="view-btn" onclick="window.location.href='classwork_02.php';">
          View Instructions
        </button>
      </div>
    `;
  }

  if (existingTopic) {
    const topicContainer = existingTopic.closest('.row-space');
    topicContainer.appendChild(newAssignment);
  } 
  else {
    const newTopicContainer = document.createElement('div');
    newTopicContainer.classList.add('row-space');
    newTopicContainer.innerHTML = `
      <div class="title">${topic}</div>
    `;
    newTopicContainer.appendChild(newAssignment);
    document.getElementById('assignmentContainer').appendChild(newTopicContainer);
  }

  form.reset();
  popup.classList.remove('active');
});


function toggleRow(element) {
  element.classList.toggle('expanded');
}

document.querySelectorAll('.note-edit-btn').forEach(button => {
  button.addEventListener('click', function () {
    const noteBox = this.closest('.note-box');
    const noteId = noteBox.dataset.id;
    const title = noteBox.querySelector('#title');
    const paragraph = noteBox.querySelector('p');
    const img = this.querySelector('img');
    const isEditing = title.isContentEditable;

    if (!isEditing) {
      title.contentEditable = true;
      paragraph.contentEditable = true;
      paragraph.focus();
      img.src = 'IMAGES/check.png';
      img.alt = 'Save';

      const limitTitle = e => {
        const text = title.innerText.trim();
        const words = text.split(/\s+/);
        const lines = text.split(/\n/);
        const allowedKeys = ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown'];
        if (allowedKeys.includes(e.key)) return;
        if (words.length >= 6) e.preventDefault();
        if (lines.length >= 1 && e.key === 'Enter') e.preventDefault();
      };

      const limitParagraph = e => {
        const text = paragraph.innerText.trim();
        const words = text.split(/\s+/);
        const lines = text.split(/\n/);
        const allowedKeys = ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown'];
        if (allowedKeys.includes(e.key)) return;
        if (words.length >= 45) e.preventDefault();
        if (lines.length >= 5 && e.key === 'Enter') e.preventDefault();
      };

      if (!title.dataset.listenerAdded) {
        title.addEventListener('keydown', limitTitle);
        title.dataset.listenerAdded = true;
      }
      if (!paragraph.dataset.listenerAdded) {
        paragraph.addEventListener('keydown', limitParagraph);
        paragraph.dataset.listenerAdded = true;
      }

    } else {
      title.contentEditable = false;
      paragraph.contentEditable = false;
      img.src = 'IMAGES/edit.png';
      img.alt = 'Edit';

      const updatedTitle = title.textContent.trim();
      const updatedContent = paragraph.textContent.trim();
      const className = "<?= htmlspecialchars($className) ?>";

      fetch('save_note.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `note_id=${encodeURIComponent(noteId)}&note_title=${encodeURIComponent(updatedTitle)}&note_content=${encodeURIComponent(updatedContent)}&class_name=${encodeURIComponent(className)}`
    })
    .then(response => response.text())
    .then(data => {
      console.log(data);
      alert('✅ Note updated successfully!');
    })
      .catch(error => console.error('Error updating note:', error));
    }
  });
});


const fileInput = document.getElementById('file-btn');
const showUpload = document.getElementById('showUpload');

fileInput.addEventListener('change', function() {
  const file = this.files[0];
  if (!file) return;

  const fileName = file.name;
  const fileExt = fileName.split('.').pop().toUpperCase();

  const fileURL = URL.createObjectURL(file);

  showUpload.innerHTML = `
    <div class="upload-box">
      <div class="file-style">${fileExt}</div>
      <hr class="upload-hr">
      <div class="file-name">
        <p><a href="${fileURL}" target="_blank" class="file-link">${fileName}</a></p>
        <p>${fileExt}</p>
        <button type="button" class="upload-btn-close">X</button>
      </div>
    </div>
  `;

  const closeBtn = showUpload.querySelector('.upload-btn-close');
  closeBtn.addEventListener('click', () => {
    showUpload.innerHTML = '';
    fileInput.value = '';
    URL.revokeObjectURL(fileURL);
  });
});

document.getElementById('autoFillIcon').addEventListener('click', function() {
document.getElementById('homework-title').value = 'Study Materials';
});



function deleteAllNotes(className) {
    if (confirm('Are you sure you want to delete all notes?')) {
        fetch('note_delete.php?className=' + encodeURIComponent(className))
            .then(response => response.text())
            .then(result => {
                if (result.trim() === 'success') {
                    const titleInput = document.getElementById('topic');
                    const contentInput = document.getElementById('content');
                    if (titleInput) titleInput.value = 'Enter your class title';
                    if (contentInput) contentInput.value = 'Enter your content';
                    
                    alert('All notes deleted successfully!');
                } else {
                    alert('Failed to delete notes.');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Error occurred while deleting.');
            });
    }
}
</script>

<?php include('include/footer.php');?>