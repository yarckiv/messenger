<?php
require_once 'functions.php';
require_once 'panel.php';


if (!checkUser($_SESSION["login"], $_SESSION["password"])) {
    header("Location: index.php");
    exit();
}

?>

<div style="text-align: center">
<h1>Користувачі системи</h1>
<table style="margin: 0 auto" border="1" width="40%">
    <tr>
        <td style="text-align: center">Логін</td>
        <td style="text-align: center">Повідомлення</td>
        <td style="text-align: center">Історія спілкування</td>
    </tr>
    <tr>
        <?php
        $users = getAllUsers();
        for ($u = 0; $u < count($users); $u++) {
            echo "<tr>";
            echo "<td>".$users[$u]['login']."</td>";
            echo "<td>";
            if ($users[$u]['login'] == $_SESSION["login"]){}
            elseif (!checkBan($users[$u]['login'])) 
            { echo 'Користувач заблокований'; }
                else {
                echo "<a href ='smessage.php?to=".$users[$u]['id']."'>Надіслати повідомлення</a>";}
            echo "</td>";
            echo "<td>";
            if ($users[$u]['login'] == $_SESSION["login"]){}  
            else echo "<a href ='s_dialog.php?to=".$users[$u]['id']."'>переглянути</a>";
            echo "</td>";
            "</tr>";
        }
        ?>
    </tr>
</table>
</div>
