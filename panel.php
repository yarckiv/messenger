
<?php
require_once 'functions.php';
session_start(); 

if (!checkUser($_SESSION["login"], $_SESSION["password"])) {
    header("Location: index.php");
    exit();}  
//$mysqli = new mysqli('localhost', 'root', '', 'test');
//$q = $mysqli->query("SELECT * FROM `users` WHERE `login` = '$_SESSION[login]' AND `password` = '$_SESSION[password]'");
//$row = $q->fetch_assoc ();
//if (($row['admin'] == 1))
//{header("Location: admin.php");}
if (isAdmin($_SESSION["login"], $_SESSION["password"])){  
header("Location: admin.php");} 
 
 ?> 

<body>
<ul class="menu">
    <h3 style="color: blue">Вітаємо <?php echo $_SESSION['login'];?></h3>
    
<li><a href='editprofile.php'>Редагувати</a></li></br>
<li><a href='allusers.php'>Всі користувачі</a></li></br>
<li><a href='logout.php'>Вихід</a></li></br>
</ul>




