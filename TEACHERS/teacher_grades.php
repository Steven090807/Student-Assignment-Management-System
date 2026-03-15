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

.topic #tree::after {
    opacity: 1;
}
.note-function {
    width: 85%;
    margin: 0 120px;
}

.note{ 
    margin-top: 6%; 
    margin-bottom: 1.5%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-weight: bold;
    font-size: 19px;
}

.note button {
    border: none;
    background: none;
    cursor: pointer;
    padding: 4px;
}

.note-box {
    border: 1px solid black;
    border-radius: 8px;
    padding: 12px;
    margin-bottom: 20px;
    background: #fff;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}  

.note-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-weight: bold;
    font-size: 16px;
}
.note-edit-btn{
    border: none;
    background: none;
    cursor: pointer;
}
.task-function {
    width: 85%;
    margin: 0 120px;
}

.task { 
    display: flex;
    align-items: center; 
    margin-top: 2%; 
    font-weight: bold; 
    font-size: 20px; 
    margin-bottom: 1.2rem;
    justify-content: space-between;
}

.task button {
    border: none;
    background: none;
    cursor: pointer;
    padding: 4px;
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

.list-bar {
    width: 95%;
    height: 50px;
    border: 1px solid black;
    border-radius: 12px;
    background-color: rgb(250, 250, 250);
    margin-left: 10px;
    margin-bottom: -2%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.list-bar-text {
    font-weight: bold;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;

}

.row-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 0;
    margin-left: 10px;
    width: 95%;
    border-top: 1px solid #d3d3d3ff;
    position: relative;
    z-index: -2;
}
.left-part {
    min-width: 200px;
    margin-left: 22px;
    display: flex;
    align-items: center;
    gap: 15px; 
}
.right-part {
    display: flex;
    align-items: center;
}
.middle-part {
    flex: 1;
    display: flex;
    justify-content: center;
}

.progress {
    height: 16px;
    border-radius: 7px;
    overflow: hidden;
    width: 75%;
    margin-top: 20px;
}

.progress-bar {
    background: #c562efff;
    font-size: 12px;
    font-weight: bold;
    text-align: center;
    color: white;
    width: 0;
    animation: grow 2s ease forwards;
}
.content {
    width: 45px;
    height: 45px;
    background-color: rgb(183, 185, 186);
    border-radius: 50%;
    display: flex;
    color: white;
    font-size: 20px;
    font-weight: bold;
    align-items: center;
    justify-content: center;
}
.content-font {
    margin-bottom: -2px;
    margin-right: 2px;
}
.view-grade {
    width: 60px;
    height: 32px;
    background-color: rgb(108, 118, 125);
    border-radius: 5px;
    display: flex;
    color: white;
    font-size: 18px;
    font-weight: bold;
    align-items: center;
    justify-content: center;
}
.view-grade-back {
    width: 60px;
    height: 36px;
    margin-right: 40px;
    background-color: black;
    border-radius: 5px;
    display: flex;
    margin-top: 5px;
}
.view-grade p {
    margin: 0;
}
.main-text {
    margin-bottom: -2px;
    margin-right: 2px;
    font-size: 16px;
    font-weight: 500;
    color: black;
}


.row-space{
    margin: 2% auto;
    margin-bottom: 50px;
}

</style>
<?php include 'menu.php'; ?>
<hr id="top">
<div class="note-function">
  <div class="note"> 
    <span>
       <img src="IMAGES/student.png" width="27" height="27" alt="Task"> Student 
    </span>
    <button>
        <img src="IMAGES/more.png" width="23" height="23" alt="More">
    </button>
  </div>
  <div class="list-bar">
   <div class="list-bar-text" style="padding-left: 90px;">Name</div>
   <div class="list-bar-text" style="padding-left: 50px;">Assignment Score</div>
   <div class="list-bar-text" style="padding-right: 50px;">Grade</div>
  </div>
   <div class="row-space">
    <div class="row-content">
        <div class="left-part">
            <div class="content">
                <p class="content-font">Y</p>
            </div>
            <p class="main-text">You Kah King</p>
        </div>
        <div class="middle-part">
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">70%</div>
            </div>
        </div>
        <div class="right-part">
            <div class="view-grade-back">
                <div class="view-grade">
                    <p>B</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row-content">
        <div class="left-part">
            <div class="content">
                <p class="content-font">K</p>
            </div>
            <p class="main-text">Khor Hao Jie</p>
        </div>
        <div class="middle-part">
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 65%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">65%</div>
            </div>
        </div>
        <div class="right-part">
            <div class="view-grade-back">
                <div class="view-grade">
                    <p>B-</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row-content">
        <div class="left-part">
            <div class="content">
                <p class="content-font">N</p>
            </div>
            <p class="main-text">Ng Zi Rong</p>
        </div>
        <div class="middle-part">
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">60%</div>
            </div>
        </div>
        <div class="right-part">
            <div class="view-grade-back">
                <div class="view-grade">
                    <p>C+</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row-content">
        <div class="left-part">
            <div class="content">
                <p class="content-font">T</p>
            </div>
            <p class="main-text">Tan Jia Yong</p>
        </div>
        <div class="middle-part">
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 55%;" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100">55%</div>
            </div>
        </div>
        <div class="right-part">
            <div class="view-grade-back">
                <div class="view-grade">
                    <p>C</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row-content">
        <div class="left-part">
            <div class="content">
                <p class="content-font">S</p>
            </div>
            <p class="main-text">Steven Goh Yi Shen</p>
        </div>
        <div class="middle-part">
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
            </div>
        </div>
        <div class="right-part">
            <div class="view-grade-back">
                <div class="view-grade">
                    <p>C-</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row-content">
        <div class="left-part">
            <div class="content">
                <p class="content-font">P</p>
            </div>
            <p class="main-text">Pang Sin Guan</p>
        </div>
        <div class="middle-part">
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">60%</div>
            </div>
        </div>
        <div class="right-part">
            <div class="view-grade-back">
                <div class="view-grade">
                    <p>C+</p>
                </div>
            </div>
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