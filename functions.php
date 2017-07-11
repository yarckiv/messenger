<?php

function connectDB () {
    return new mysqli('localhost', 'root', '', 'test');
     
}

function closeDB ($mysqli) {
    $mysqli->close();
}

function regUser ($login, $password){   //реєстрація користувача
    $mysqli = connectDB();
    $mysqli-> query("INSERT INTO users (`login`, `password`) VALUES ('$login', '$password')");
    closeDB($mysqli);
}

function checkUser ($login, $password) {    //перевірка пароля користувача
    if (($login == "") || ($password == "")) return FALSE;
    $mysqli = connectDB();
    $result_set = $mysqli-> query ("SELECT password FROM users WHERE login = '$login'");
    $user = $result_set-> fetch_assoc ();
    $real_pass = $user ['password'];
    closeDB($mysqli);
    return $real_pass == $password;
}

function checkBan ($login) {
    $mysqli = connectDB();
    $result_set = $mysqli-> query ("SELECT ban FROM users WHERE login = '$login'");
    $user = $result_set-> fetch_assoc ();
    $ban = $user ['ban'];
    closeDB($mysqli);
    return $ban == 0;
}

function updatePass ($login, $password) {    // зміна пароля
    if (($login == "") || ($password == "")) return FALSE;
    $mysqli = connectDB();
    $mysqli-> query("UPDATE users SET password = '$password' WHERE login = '$login'");
    closeDB($mysqli);
}

function getAllUsers () {    //отримання переліку всіх зареєстрованих користувачів системи
   $mysqli = connectDB();
   $result_set = $mysqli-> query("SELECT * FROM users");
   closeDB($mysqli); 
   return resultToArray ($result_set);
}

function resultToArray ($result_set) {     
    $result = array ();
    while (($row = $result_set->fetch_assoc ())!= FALSE){
        $result [] = $row;
    }
    return $result;
}

function getUserOnID ($id) {    //отримання користувача по id
   $mysqli = connectDB();
   $result_set = $mysqli-> query("SELECT * FROM users WHERE id = '$id'");
   $row = $result_set->fetch_assoc ();
   closeDB($mysqli); 
   return $row['login'];
}

function getIDonLogin ($login) {    //отримання id користувача по логіну
   $mysqli = connectDB();
   $result_set = $mysqli-> query("SELECT id FROM users WHERE login = '$login'");
   $row = $result_set->fetch_assoc ();
   closeDB($mysqli); 
   return $row['id'];
}

function addMessage ($from, $to, $message) {     //додати саме повідомлення
    $mysqli = connectDB();
    $mysqli-> query("INSERT INTO messages (`from`, `to`, `message`) VALUES ('$from', '$to', '$message')");
    closeDB($mysqli); 
}

function getAllMessages ($to) {                 //вибірка всіх повідомлень конкретному користувачу
   $mysqli = connectDB();
   $result_set = $mysqli-> query("SELECT * FROM messages WHERE `to` = '$to' ORDER BY `date` DESC");
   closeDB($mysqli); 
   return resultToArray($result_set);
}

function addMessageDialog ($user_to, $text) {     //
    $mysqli = connectDB();
    $user_id = getIDonLogin($_SESSION['login']);
    $row = mysqli_fetch_assoc (mysqli_query ($mysqli, "SELECT `id` FROM `dialog` WHERE `receive` = '$user_to' AND `send` = '$user_id' OR `receive` = '$user_id' AND `send` = '$user_to'"));
    if ($row) {
    $did = $row['id'];
    $mysqli->query ("UPDATE `dialog` SET `status` = 0, `send` = '$user_id', `receive` = '$user_to' WHERE id = '$row[id]'");
    }
    else {
    $mysqli->query("INSERT INTO `dialog` (`send`, `receive`, `status`) VALUES ('$user_id','$user_to',0)");
    $did = $mysqli->insert_id;}
    $mysqli->query ("INSERT INTO `message_d`(`did`, `user_id`, `text`, `date`) VALUES ('$did', '$user_id','$text', NOW())");
    closeDB($mysqli); 
   }

function countDialog ($login){
$mysqli = connectDB();    
$user_id = getIDonLogin($_SESSION['login']);
$mysqli = connectDB();
$count = mysqli_num_rows (mysqli_query ($mysqli, "SELECT * FROM dialog WHERE `receive` = '$user_id' OR `send` = '$user_id'"));
if ($count) {
echo "У вас є $count повідомення: <a href ='s_dialog.php?to=".$u."'>$user</a>";
} else{
echo 'У вас нема повідомлень';}
closeDB($mysqli); 
}

function isAdmin ($login, $password){
    $mysqli = connectDB();
    $result_set = $mysqli-> query("SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'");
    $row = $result_set->fetch_assoc ();
    $admin = $row ['admin'];
    closeDB($mysqli);
    return $admin;
}