<?php
require_once 'functions.php';
session_start();
if (!isAdmin($_SESSION["login"], $_SESSION["password"])) {
    header("Location: index.php");
    exit();
}

?>

<center>
<ul class="menu">
    <h3 style="color: blue">Вітаємо ADMIN <?php echo $_SESSION['login'];?></h3>
</center>  
<li><a href='logout.php'>Вихід</a></li></br>
</ul>

<div style="text-align: center">
<h1>Ви адміністратор системи, шановний <?php echo $_SESSION["login"];?></h1>
<p><em>Створити нового користувача</em></p>
<center>
    <form action="" method="post" name="registr" >
    <table>
    <tr>
    <td> Логін: </td>
    <td> <input type="text" name="login" required=" " /> </td>
   </tr>
   <tr>
    <td> Пароль: </td>
    <td> <input type="password" name="password" required=" " /> </td>
   </tr>
   <tr>
    <td colspan="2"> <input type="submit" name="reg" value="Зареєструвати" /> </td>
   </tr>
  </table>
</form>
</div> 
<div style="text-align: center">
<p><em>Всі зареєстровані користувачі</em></p>
<table style="margin: 0 auto" border="1" width="40%">
    <tr>
        <td style="text-align: center">Логін</td>
        <td style="text-align: center">Статус</td>
        <td style="text-align: center">Видалити користувача</td>
        <td style="text-align: center">Редагувати користувача</td>
    </tr>
    <tr>
        <?php
        $users = getAllUsers();
        for ($u = 0; $u < count($users); $u++) {
            echo "<tr>";
            echo "<td>".$users[$u]['login']."</td>";
            /*$login = $users[$u]['login'];
            echo $login;*/
            echo "<td>";
            if ($users[$u]['login'] == $_SESSION["login"])echo 'Ви адміністратор';
            elseif (!checkBan($users[$u]['login'])) 
            { echo 'Цей користувач на данний момент заблокований'; }
            else echo 'Активний';
            echo "</td>";
            echo "<td>";
            if ($users[$u]['login'] == $_SESSION["login"]){}
            else{
            $log = $users[$u]['login'];
            echo '<form action="" method="post" name="delete" >';
            echo '<input type="submit" name="del" value="Видалити" />';
            if (isset($_POST['del'])){
            $mysqli = connectDB();
            $del = $mysqli->query("DELETE FROM `users` WHERE `login` = '$log'");
            return $del;}}
            echo "</td>";
            echo "<td>";
            if ($users[$u]['login'] == $_SESSION["login"]){}
            else  {
            echo "<a href ='edit.php?to=".$users[$u]['id']."'>Редагувати</a>";
            echo "</td>";
            "</tr>"; 
        }}
        ?>
    </tr>
</table>
</div>


<?php                   //реєстрація новго користувача
if (isset($_POST['reg'])) {
    $login =$_POST['login'];
    $password = $_POST['password'];
    unset($_SESSION['succes']);
    unset($_SESSION['bad_login']);
    if (($login !== "") && ($password !== "")) {
    $mysqli = new mysqli('localhost', 'root', '', 'test');
    $query = $mysqli->query("SELECT `login` FROM `users` WHERE `login` = '$login'");
    $user = $query-> fetch_assoc ();
    if ($login === $user['login']) {
        $_SESSION['bad_login'] = '<b><center>Цей логін зайнято, виберіть інший</b>';
        echo $_SESSION['bad_login'];
    }
    else
        { regUser($login, $password);
        $_SESSION['succes'] = '<b><center>Ви успішно зареєстрували нового користувача</b>';
        echo $_SESSION['succes'];
        }
}
}
               


?>