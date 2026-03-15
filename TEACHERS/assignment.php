<?php 
include('class/User.php');
$user = new User();
$user->loginStatus();
session_start();
$teacherName = isset($_SESSION['teacher_name']) ? $_SESSION['teacher_name'] : 'Mr Unknown';

include('include/header.php');
?>
<title>Teacher Management System</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php include('include/container.php');?>
<link rel="stylesheet" href="CSS/assignment.css">
<div class="container contact">	
	<?php include 'menu.php'; ?>
<div class="row">
  <div class="col-lg-6 col-md-8 col-sm-8 col-xs-12">
    <div style="margin-top: 30px; margin-left: -30%">
     <div class="search-container">
      <div class="search-box">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#999" class="bi bi-search" viewBox="0 0 16 16">
          <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
        </svg>
        <input type="text" id="searchInput" class="form-control search-input" placeholder="Search your courses...">
        <div id="search">
            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="search-icon" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
            </svg>
        </div>
        <div class="search-bar-line"></div>
        <div id="close">
            <svg xmlns="http://www.w3.org/2000/svg" width="33" height="33" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
            </svg>
        </div>
      </div>
      <div class="dropdown dropdown-space" id="MostRecent">
          <button class="btn btn-secondary dropdown-toggle dropdown-btn" type="button" data-bs-toggle="dropdown">Most Recent</button>
      </div>
     </div>
    </div>
  </div>
</div>

<div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">   
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <?php
                session_start();
                
                if (!isset($_SESSION['teacher_name'])) {
                    echo "<p style='color:red; text-align:center;'>Please login first.</p>";
                    exit;
                }

                $teacherName = $_SESSION['teacher_name'];   

                $conn = new mysqli("127.0.0.1:3307", "root", "", "ds411");

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $stmt = $conn->prepare("SELECT * FROM `class_teacher` WHERE `teacher_name` = ?");
                $stmt->bind_param("s", $teacherName);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows == 0) {
                    echo '
                    <div id="nothing" style="text-align: center; margin-top: 120px;">
                        <img src="IMAGES/box.png" alt="No classes found" width="140" height="140">
                        <p style="color: gray; margin-top: 10px;">No classes created yet</p>
                    </div>';
                } else {
                    echo '<style>#nothing { display: none; }</style>';
                    while ($row = $result->fetch_assoc()) {
                        echo '
                        <div class="col-md-4">
                            <div class="custom-panel-all" onclick="window.location.href=\'classwork_01.php?className=' . urlencode($row['class_name']) . '\'">
                                <div class="custom-panel-back"></div>
                                <div class="custom-panel">
                                    <div class="custom-panel-top">
                                        <div class="class-name text-uppercase">'.htmlspecialchars($row['class_name']).'</div>
                                        <div class="stat-panel-title">'.htmlspecialchars($row['teacher_name']).'</div>
                                        <div class="avatar" style="background-color: '.htmlspecialchars($row['color']).';">
                                            '.htmlspecialchars($row['avater_name']).'
                                        </div>
                                    </div>
                                    <div class="custom-panel-middle"></div>
                                    <div class="custom-panel-bottom">
                                        <div class="dropdown">
                                            <button class="panel-button dropdown-toggle" data-bs-toggle="dropdown" onclick="event.stopPropagation();">
                                                <i class="fa fa-bars" style="font-size:24px; color:black; margin-right: 5%;"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item text-danger" href="#" onclick="deleteClass(\'' . htmlspecialchars($row['class_name']) . '\'); return false;">Delete</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    }
                }

                $stmt->close();
                $conn->close();
                ?>
            </div>
        </div>
    </div>
</div>

<footer>
    <button class="btn-circle" id="openPopup">
        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="white" class="bi bi-plus" viewBox="0 0 16 16">
            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
        </svg>
        <span class="text">Add a class</span>
    </button>
</footer>
<div class="popup-overlay" id="popup">
  <div class="add-class-btn">
    <button type="button" class="btn-close" id="closePopup" aria-label="Close">X</button>
    <h2><b>+ Create Class</b></h2><hr>
    <div class="form-group">
      <label for="title">Class Name</label>
      <input type="text" id="title" placeholder="Enter your class name" maxlength="16" required>
      <small id="charCount">0 / 16</small>
    </div>
    <button class="submit-btn">Add Class</button>
  </div>
</div>

<script>
const popup = document.getElementById('popup');
const openBtn = document.getElementById('openPopup');
const closeBtn = document.getElementById('closePopup');
const titleInput = document.getElementById('title');
const charCount = document.getElementById('charCount');
const addBtn = document.querySelector('.submit-btn');
const searchInput = document.querySelector('.search-input');
const closeBtnTop = document.getElementById('close');

closeBtnTop.addEventListener('click', () => {
searchInput.value = '';
searchInput.focus();
});

document.getElementById("searchInput").addEventListener("keyup", function() {
  const keyword = this.value.toLowerCase();
  const panels = document.querySelectorAll(".custom-panel-all");

  panels.forEach(panel => {
    const className = panel.querySelector(".class-name").textContent.toLowerCase();
    if (className.includes(keyword)) {
      panel.style.display = "block";
    } else {
      panel.style.display = "none";
    }
  });
});

const classContainer = document.querySelector('.col-md-12 .row');

openBtn.addEventListener('click', () => popup.classList.add('active'));
closeBtn.addEventListener('click', () => popup.classList.remove('active'));
popup.addEventListener('click', (e) => {
  if (e.target === popup) popup.classList.remove('active');
});

titleInput.addEventListener('input', () => {
  charCount.textContent = `${titleInput.value.length} / 16`;
});

addBtn.addEventListener('click', () => {
  const className = titleInput.value.trim();
  if (className === "") {
    alert("Please enter a class name!");
    return;
  }

  fetch('insert_class.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `className=${encodeURIComponent(className)}`
  })
  .then(response => response.text())
  .then(data => {
    alert(data);
    if (data.includes("✅")) {
      setTimeout(() => location.reload(), 1000);
    }
  })
  .catch(err => console.error('Error:', err));
});


const colors = ['#3D3BB7', '#66023c', '#4169e1', '#ff4500', '#644117', '#757575'];

document.querySelectorAll('.avatar').forEach((avatar, index) => {
  const savedColor = localStorage.getItem('avatarColor_' + index);
  
  if (savedColor) {
    avatar.style.backgroundColor = savedColor;
  } else {
    const randomColor = colors[Math.floor(Math.random() * colors.length)];
    avatar.style.backgroundColor = randomColor;
    localStorage.setItem('avatarColor_' + index, randomColor);
  }
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


function deleteClass(className) {
    if (confirm(`Are you sure you want to delete class "${className}"?`)) {
        fetch('delete_class.php?className=' + encodeURIComponent(className))
            .then(response => response.text())
            .then(result => {
                if (result.trim() === 'success') {
                    alert('✅ Class deleted successfully!');
                    window.location.reload(); 
                } else {
                    alert('❌ Failed to delete class: ' + result);
                }
            })
    }
}

</script>


<?php include('include/footer.php');?>