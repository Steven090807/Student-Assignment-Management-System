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
<style>
    html, body {
    min-width: 786px;
}
body {
    padding: 0;
    margin: 0 auto;
    justify-content: center;
    align-items: center;
    height: auto;
    background: linear-gradient(to bottom, white 0%, white 0%,#F0F9FF 80%);
    background-attachment: fixed;
}
.head-top{
    
    width: 100%;
    padding: 5px;
    background-color: white;
    position: fixed; 
    z-index: 9999
}


.avatar,
.avatar-top {
    display: flex;
    justify-content: center;
    align-items: center;
    color: #fff;
    font-weight: bold;
    border-radius: 50%;
    box-shadow: 0 2px 20px rgba(0, 0, 0, 0.2);
    position: absolute;
    z-index: 10;
}
.avatar {
    width: 80px; 
    height: 80px;
    background-color: #3D3BB7; /* #7e57c2*/
    font-size: 30px;
    right: 15%; 
    bottom: 45%;
}
.avatar-top {
    width: 40px; 
    height: 40px;
    background-color: #78909c;
    font-size: 15px;
    right: 5%; 
    bottom: 0;
}

.avatar img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
}
.sidebar {
    position: fixed;
    font-size: 17px;            
    text-align: center;
    top: 0;
    left: 0;
    height: auto;
    width: 16%;
    padding-top: 120px;
    z-index: 1;
    background: linear-gradient(to bottom, white 0%, white 0%, #f6f9fcff 80%);
}
.sidebar a {
    display: block;
    color: #666666;
    padding: 12px 10px;
    font-weight: 600;
    margin-bottom: 4%;
    border-radius: 25px;
    text-decoration: none;
    transition: all 0.2s ease;
}
.sidebar a:hover{
    background-color: #3D3BB7;
    color: #fff;
}
.sidebar li:hover #error {
    color: #fff; 
}
.sidebar ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.sidebar li {
    margin-bottom: 10px;
    position: relative;
}

.too-small::before {
    content: "🔒 Please resize window wider than 810px.";
    position: fixed;
    width: 100%;
    height: 100%;
    background: black;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    z-index: 9999;
}
hr#top{
    border: 1px solid #e5e4e2;
    width: 100%;
    position: absolute;
    left: -0.1%;
}

.topic {
    display: flex;
    gap: 60px;
    margin: 68px 0 -1% 120px;
    font-family: Arial, sans-serif;
}

.topic .nav-item {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.topic a {
    text-decoration: none;
    font-size: 16px;
    color: grey;
    font-weight: bold;
}

#three a {
    color: #9400d3;
}

.topic .nav-item {
    position: relative;
}

.topic .nav-item::after {
    content: "";
    position: absolute;
    bottom: -11px;
    margin: auto;
    height: 5px;
    width: 130%;
    background: #9400d3;
    border-radius: 10px;
    opacity: 0; 
    z-index: 1;
}

.topic #three::after {
    opacity: 1;
}

.nav-tabs .nav-item {
    text-align: center;
}

.nav-tabs .nav-link {
    width: 100%;
    font-weight: 600;
    color: grey;
}

.nav-tabs .nav-link.active {
    color: black;
    border-color: #d3d3d3  #d3d3d3  #fff;
}

.card-container {
  width: 830px;
  margin: 65px auto;
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  border: 1px solid #b1a3a3ff;
  border-radius: 15px;
  padding: 20px;
  background: #fff;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  margin-left: 20%;
}

.left-panel {
  flex: 1;
  width: auto;
  border-right: 2px solid #444141;
  margin-left: 10px;
}


.student-avatar {
  width: 90px;
  height: 85px;
  background: #e74c3c;
  color: #fff;
  font-size: 38px;
  font-weight: bold;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  margin-bottom: 10px;
  margin: 50px 90px 0;
}

.student-title-icon {
    width: 85%;
    margin: 0 75px;
    margin-top: 6%; 
    margin-bottom: 1.5%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-weight: bold;
    font-size: 19px;
}
.student-title-text{
    margin-bottom: 25px;
}

.view-grade {
    width: auto;
    min-width: 60px;
    padding: 15px;
    height: 32px;
    background-color: rgb(108, 118, 125);
    border-radius: 5px;
    display: flex;
    color: white;
    font-size: 14px;
    font-weight: 600;
    align-items: center;
    justify-content: center;

}
.view-grade-back {
    width: auto;
    min-width: 60px;
    height: 36px;
    margin-right: 40px;
    background-color: black;
    border-radius: 5px;
    display: flex;
    margin-top: 5px;
    margin-bottom: 136px;
}
.view-grade p {
    margin: 0;
}

.right-panel {
  flex: 2;
  padding: 20px;
 margin-left: 20px;
}

.score-circle {
  width: 160px;
  height: 160px;
  position: relative;
  margin: 20px 20px;
}
.border {
    width: 160px;
    height: 160px;
    border-radius: 50%;
    padding: 20px;
}
.inner {
    width: 120px;
    height: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}
#number {
    font-size: 31px;
    font-weight: 600;
    color: #555;
}
circle {
    fill: none;
    stroke: url(#GradientColor);
    stroke-width: 15px;
    stroke-dasharray: 472;
    stroke-dashoffset: 472;
    animation: animation 2s linear forwards;
}
svg{
    position: absolute;
    top: 0;
    left: 0;
}
.grade-scale {
  margin: 20px 0;
  font-weight: bold;
}

.grade-labels {
  display: flex;
  justify-content: space-between;
  font-weight: bold;
  margin-top: 15px;
}

.grade-labels-shortline {
  display: flex;
  justify-content: space-between;
  font-weight: bold;
  margin-left: 5px;
}

.progress {
    height: 16px;
    border-radius: 4px;
    margin-top: 20px;
    overflow: hidden;
}

.progress-bar {
    background: rgb(51, 166, 76);
    font-size: 12px;
    font-weight: bold;
    text-align: center;
    color: white;
    width: 0;
    animation: grow 2s ease forwards;
}

.score-row {
  display: flex;
  align-items: center;
  gap: 19%;
}
.note-box {
  width: 160px;
  font-size: 14px;
  border: 1px solid #aaa;
  padding: 12px;
  border-radius: 20px;
  background: #fafafa;
  line-height: 1.5;
  margin-top: -5%;

}
.parallelogram {
  width: 130px;
  height: 60px;
  background: white;
  border: 1px solid #555;
  display: flex;
  align-items: center;
  justify-content: center;
  transform: skew(-20deg);
  margin: -52px 35.3%;
  font-size: 13px;
  position: relative;
  z-index: 2;
}

.parallelogram-back {
  width: 130px;
  height: 60px;
  background: black;
  transform: skew(-20deg);
  margin: -5px 34%;
  position: relative;
  z-index: 1;
}

.parallelogram span {
  transform: skew(20deg);
  font-weight: bold;
}

#note-add {
    text-align: center;
    margin-bottom: -10px;
}

#note-grade-info {
    margin: 0;
    margin-top: -10px;
}
#center-line {
    border: 1px solid #78909c;
    width: 93%;
}
#space-left {
    margin-right: -13.3%;
}
#space-right {
    margin-left: -15.3%;
}
#short {
    font-size: 13px;
    margin: 6px 0 -15px;
}
#grade-level {
    font-size: 22px;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
}

@keyframes animation{
    100%{
        stroke-dashoffset: 165;
    }
}
@keyframes grow {
  from { width: 0; }
  to { width: 65%; }
}

</style>
<?php include 'menu.php'; ?>
<hr id="top">

<div class="card-container">
  <div class="left-panel" >
    <div class="student-avatar">S</div>
    <div class="student-title-icon">
        <span class="student-title-text">
            <img src="IMAGES/student.png" width="23" height="23" alt="Task"> Student 
        </span>
    </div>
    <p><b>Name:</b> Steven Goh Yi Shen</p>
    <p><b>Telephone:</b> 011-55023117</p>
    <p><b>Gender:</b> Male</p>
    <div class="view-grade-back">
        <div class="view-grade">
            <p>stevengohyishen@gmail.com</p>
        </div>
    </div>
  </div>

  <div class="right-panel">
    <div class="score-row">
        <div>
            <p style="color: #667277ff; font-weight: 600; font-size: 13px;">Current</p>
            <p style="margin-top: -10px">Assignment Score</p>
            <div class="score-circle">
                <div class="border">
                    <div class="inner">
                        <div id="number">65%</div>
                    </div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="160px" height="160px">
                    <defs>
                        <linearGradient id="GradientColor">
                            <stop offset="0%" stop-color="#2e2e2e" />
                            <stop offset="100%" stop-color="#4b0082" />
                        </linearGradient>
                    </defs>
                    <circle cx="80" cy="80" r="70" stroke-linecap="round" />
                </svg>
            </div>
        </div>

        <div class="note-box">
            <p id="note-add">— Add 2%<br>─ Add 2%</p><hr id="center-line">
            <p id="note-grade-info">
                F ─ 0% to 49% <br>
                C ─ 50% to 64% <br>
                B ─ 65% to 79% <br>
                A ─ 80% to 100%
            </p>
        </div>
    </div>

    <div class="grade-scale">
      <p>Grade</p>
      <div class="grade-labels">
        <span id="space-left"></span>
        <span>F</span>
        <span>C</span>
        <span>B</span>
        <span>A</span>
        <span id="space-right"></span>
      </div>
      <div class="grade-labels-shortline">
        <span id="short">l</span>
        <span>|</span>
        <span id="short">l</span>
        <span id="short">l</span>
        <span>|</span>
        <span id="short">l</span>
        <span id="short">l</span>
        <span>|</span>
        <span id="short">l</span>
        <span id="short">l</span>
        <span>|</span>
        <span id="short">l</span>
   
      </div>
      <div class="progress">
        <div class="progress-bar" role="progressbar" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
      
    </div>

    <div class="parallelogram-back"></div>
    <div class="parallelogram">
        <span>Your grade is <br><b id="grade-level">C-</b></span>
    </div>    
  </div>


    
</div>

 
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
</script>

<?php include('include/footer.php');?>