<?php
session_start();
$className = $_GET['className'] ?? '';
?>
<link href="../SMS/assets/css/themify-icons.css" rel="stylesheet">
<div id="top-nav" class="navbar navbar-inverse navbar-static-top" style="background:#c4e3f3;color:white;border-color:white;"> <!-- light blue:#c4e3f3, light cornflower blue 2:#a4c2f4, dark cornflower blue 3:#1c4587 -->
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Welcome</a><?php //echo $_SESSION['name']; ?>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" role="button" data-toggle="dropdown" href="#"><i class="fa fa-user-circle"></i> <?php echo $_SESSION["name"]; //$_COOKIE["loginId"]; //echo strtoupper($_SESSION['name']); ?> <span class="caret"></span></a>
                    <ul id="g-account-menu" class="dropdown-menu" role="menu">
                        <li><a href="account.php"><i class="fa fa-user-secret"></i><span class="ti-user"></span>&nbsp;&nbsp;My&nbsp;Profile</a></li>				
                    </ul>
                </li>
                <li><a href="logout.php"><i class="btn btn-primary fa fa-sign-out" style="font-size:10px"><b><span class="ti-power-off"></span>&nbsp;&nbsp;Log&nbsp;Out</b></i> </a></li>
            </ul>
        </div>
    </div>    
</div>
<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
    <div class="sidebar">
        <ul style="border-right: 2px solid black; ">      
            <li><a href="home.php"> Main Page</a></li>
            <li><a href="My_Info.php"> My Infomation</a></li>
            <li><a href="My_Class.php"> My Class</a></li>
            <li><a href="login.php"> Log Out</a></li>      
        </ul>
        <?php
            if (
            basename($_SERVER['PHP_SELF']) === 'My_Class.php' ||
            basename($_SERVER['PHP_SELF']) === 'classwork_01.php' ||
            basename($_SERVER['PHP_SELF']) === 'classwork_02.php' ||
            basename($_SERVER['PHP_SELF']) === 'people.php' 
        ): ?>
        <img src="IMAGES/welcome.gif" alt="gif" width="100" style="margin-top:54%; margin-left: 100px; ">
        <img src="IMAGES/UserInterface.gif" alt="gif" width="200" style="margin-top: -18%; margin-bottom:60%;">
        <?php endif; ?>
    </div>
</div>
<?php if (
        basename($_SERVER['PHP_SELF']) === 'classwork_01.php' ||
        basename($_SERVER['PHP_SELF']) === 'people.php' 
    ): ?>
    <div class="topic">    
         <div class="nav-item active" id="one">
            <a href="classwork_01.php?className=<?= urlencode($className) ?>">Classwork</a>
        </div>
        <div class="nav-item" id="two">
            <a href="people.php?className=<?= urlencode($className) ?>">People</a>
        </div>
        <!-- <div class="nav-item" id="three">
            <a href="student_grades.php?className=<?= urlencode($className) ?>">Grades</a>
        </div> -->
    </div>
<?php endif; ?> 