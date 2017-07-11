<?php
require_once 'functions.php';
require_once 'panel.php';
if (!checkUser($_SESSION["login"], $_SESSION["password"])) {
    header("Location: index.php");
exit();}

$user_id = getIDonLogin($_SESSION['login']);
$user_to = $_GET["to"];
$mysqli = connectDB(); 
$info = mysqli_fetch_assoc (mysqli_query($mysqli,"SELECT * FROM `dialog` WHERE `receive` = '$user_to' AND `send` = '$user_id' OR `receive` = '$user_id' AND `send` = '$user_to'"));

 
 
if ($info['receive'] == $user_to) {
    $mysqli->query("UPDATE `dialog` SET `status` = 1 WHERE `receive` = '$user_to'");
}
if ($info['send'] == $user_id){
    $info['send'] = $info['receive'];}




$user = mysqli_fetch_assoc (mysqli_query($mysqli,"SELECT `login` FROM `users` WHERE `id` = '$info[send]'"));
 
?>
<body>
<center><center>  
        <h1>Історія розмов з <?php echo getUserOnID($user_to)?></h1>
        <table style="margin: 0 auto" border="1" width="40%">
    <tr>
        <td style="text-align: center">від</td>
        <td style="text-align: center">текст повідомлення</td>
        <td style="text-align: center">дата</td>
    </tr>
    
<?php
$result = $mysqli->query("SELECT * FROM `message_d` WHERE `did` = '$info[id]' ORDER BY `date` DESC");
if (isset($_POST['send'])) {
    $mysqli = connectDB();
    $mysqli->query("UPDATE * FROM `message_d` WHERE `did` = '$info[id]' ORDER BY `date` DESC");}
while ($row= mysqli_fetch_assoc ($result))
{
    if ($info['send']== $row['user_id']) {
        $row['user_id']= $user['login'];
        
    }
    else {
        $row['user_id'] = $_SESSION["login"];}
     
            echo "<tr>";
            echo "<td>".$row['user_id']."</td>";
            echo "<td>".$row['text']."</td>";
            echo "<td>".$row['date']."</td>";
}
echo "<a href ='smessage.php?to=".$user_to."'>Надіслати повідомлення</a>".'<br>';


 ?> 
   
           