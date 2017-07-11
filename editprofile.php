<?php
require_once 'functions.php';
require_once 'panel.php';


if (!checkUser($_SESSION["login"], $_SESSION["password"])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST["editprofile"])) {
    $old_pqssword = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    if (checkUser($_SESSION['login'], $old_pqssword)){
        if ($new_password === $confirm_password) {
        updatePass ($_SESSION['login'], $new_password);
        $_SESSION["password"] = $new_password;
        $message = 'Пароль змінено';
    }
 else {
        $message = 'Паролі не співпадають';
    }
  }
 else $message = 'Поточний пароль не співпадає';
}
unset($_SESSION);
?>

<body>
<center> 
<h1>Редагування</h1>

    <form name="edit" action="" method="POST">
        <h3>Зміна пароля</h3>
        <?php
        if (isset($message)) {
            echo "<h2 style = 'color: red'>$message</h2>";
            unset($message);
        }
        ?>
        <table>
        <tr>
            <td>
                <label>Поточний пароль:</label>
            </td>
            <td>
                <input type="password" name="old_password" />
            </td>
        </tr>
        <tr>
            <td>
                <label>Новий пароль:</label>
            </td>
            <td>
                <input type="password" name="new_password" />
            </td>
        </tr>
        <tr>
            <td>
                <label>Підтвердження пароля:</label>
            </td>
            <td>
                <input type="password" name="confirm_password" />
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit" name="editprofile" value="ПОМІНЯТИ" />
            </td>
        </tr>
        </table>

</body>


