<?php
require_once 'functions.php';
session_start();
echo "<li><a href='admin.php'>Кабінет</a></li></br>";
if (!isAdmin($_SESSION["login"], $_SESSION["password"])) {
    header("Location: index.php");
    exit();
}
$login = getUserOnID($_GET['to']);
 

if (isset($_POST["edit_pass"])) {  //встановлення нового пароля
    $new_password = $_POST['new_password'];
        updatePass ($login, $new_password);
        $_SESSION["password"] = $new_password;
        $message = 'Пароль змінено на - '.$new_password;
unset($_SESSION);}
?>

<body>
<center> 
<h1>Редагування інформації користувача</h1>

    <form name="edit_pass" action="" method="POST">
        <h3>Встановлення нового пароля</h3>
        <?php
        if (isset($message)) {
            echo "<h2 style = 'color: red'>$message</h2>";
            unset($message);
        }
        ?>
        <table>
        <tr>
        </tr>
        <tr>
            <td>
                <label>Встановіть Новий пароль:</label>
            </td>
            <td>
                <input type="password" name="new_password" />
            </td>
            <tr>
            <td>
                <input type="submit" name="edit_pass" value="ВСТАНОВИТИ" />
            </td>
        </tr>
        </tr>
        </table>

</body>
