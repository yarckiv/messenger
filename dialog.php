<meta http-equiv="Refresh" content="600" />
<?php
require_once 'functions.php';
require_once 'panel.php';

        
if (!checkUser($_SESSION["login"], $_SESSION["password"])) {
    header("Location: index.php");
exit();}
//$user = getUserOnID($_GET['to']);
?>
    
<body>
<center><center>  
<h1>Ваша історія діалогів</h1>
<div class="Page">
<?php
$user_id = getIDonLogin($_SESSION['login']);
$mysqli = connectDB();
$result = mysqli_query ($mysqli, "SELECT * FROM `dialog` WHERE `receive` = '$user_id' OR `send` = '$user_id' ORDER BY `id` DESC LIMIT 0, 5");

 
while ($row = mysqli_fetch_assoc ($result)){
    $user = getUserOnID($row['receive']);
    $u = $row['receive'];
    
        if ($row ['status'] == 1) {$status = 'Всі повідомлення прочитано';
        
        } else{

echo $status."<a href ='s_dialog.php?to=".$u."'>$user</a>";     
   }
}
?>
    </div>

<div>
    <form name="delay" action="dialog.php" method="post">
  <input type="submit" name="send" value="Оновити" />
  </form>
    </div>
</body>
