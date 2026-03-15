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
<link rel="stylesheet" href="CSS/people.css">
<?php include 'menu.php'; ?>
<hr id="top">
<div class="note-function">
  <div class="note"> 
    <span>
      <img src="IMAGES/writing.png" width="30" height="30" alt="Note"> Teacher
    </span>
  </div>
  <div id="teacherInfo">
  </div>
</div>

<div class="task-function">
  <div class="task"> 
    <span>
      <img src="IMAGES/student.png" width="27" height="27" alt="Task"> 
      Student<span class="badge badge-light" id="studentCount">0</span>
    </span>
  </div>
  <div id="studentList">
  </div>
</div>

<script>
function loadClassDetails(classValue) {
  fetch('get_class_details.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `className=${encodeURIComponent(classValue)}`
  })
  .then(response => response.text())
  .then(html => {
    const container = document.createElement('div');
    container.innerHTML = html;

    const teacher = container.querySelector('#teacherInfo');
    const students = container.querySelector('#studentList');
    const studentItems = container.querySelectorAll('.student-item');

    document.getElementById('teacherInfo').innerHTML = teacher ? teacher.innerHTML : '';
    document.getElementById('studentList').innerHTML = students ? students.innerHTML : '';
    document.getElementById('studentCount').textContent = studentItems.length;
  })
  .catch(err => console.error('Error:', err));
}

document.addEventListener("DOMContentLoaded", () => {
  const urlParams = new URLSearchParams(window.location.search);
  const className = urlParams.get("className");
  if (className) {
    loadClassDetails(className);
  }
});

window.addEventListener("resize", MinWidth);
window.addEventListener("load", MinWidth);

function toggleRow(element) {
  element.classList.toggle("expanded");
}
</script>

<?php include('include/footer.php');?>