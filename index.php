<?php 
require_once 'functions.php';
if (isset($_POST['reg'])) {
    $login = htmlspecialchars ($_POST['login']);
    $password = htmlspecialchars ($_POST['password']);
    session_start();
    unset($_SESSION['succes']);
    if (($login !== "") && ($password !== "")) {
    $mysqli = new mysqli('localhost', 'root', '', 'test');
    $query = $mysqli->query("SELECT `login` FROM `users` WHERE `login` = '$login'");
    $user = $query-> fetch_assoc ();
    if ($login === $user['login']) {
        echo '<b><center>Цей логін зайнято, виберіть інший</b>';
    }
    else
        { regUser($login, $password);
 echo '<b><center>Ви успішно зареєструвалися і можете увійти, використовуючи вказану інформацію</b>';
        }
}
}
?>
<center>
<div>
    <form action="index.php" method="post" name="registr" >
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
    <td colspan="2"> <input type="submit" name="reg" value="Зареєструватися" /> </td>
   </tr>
  </table>
</form>
    
<?php
if (isset($_POST['auth'])) {    
$login = htmlspecialchars ($_POST['login']);
$password = htmlspecialchars ($_POST['password']);
session_start();
    if (checkBan($login)) {
    if (checkUser($login, $password)) {
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $password;
    header("Location: panel.php");
    }
    else {
 echo 'Не вірно вказано логін та/або пароль';
 require_once 'index.php';}    
}
 else {
echo '<p style="color: red">Доступ заблоковано</p>';
require_once 'index.php';    
}
}
?>
    <form action="index.php" method="post" name="auth" >
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
    <td colspan="2"> <input type="submit" name="auth" value="Вхід" /> </td>
   </tr>
  </table>
</form>
</div>
