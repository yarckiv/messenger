
<?php
require_once 'functions.php';
require_once 'panel.php';
if (!checkUser($_SESSION["login"], $_SESSION["password"])) {
    header("Location: index.php");
    exit();
}
$user = getUserOnID($_GET['to']);

if (isset($_POST["send"])) {
    $text = $_POST['message'];
    $to = $_POST['to'];
    $from = getIDonLogin($_SESSION["login"]);
    if ($to != $from){
    addMessageDialog ($to, $text);
    $_SESSION["message_ok"] = 1;
} 
 else {
    $_SESSION["message_fail"] = 1;  
}
}

?>
<body>
<center>
        <?php
        if (isset($_SESSION["message_ok"]) == 1) {
            echo "<h2 style = 'color: red'>Ваше повідомлення відправлено</h2>";
            unset($_SESSION["message_ok"]);
        } if (isset($_SESSION["message_fail"]) == 1) {
            echo "<h2 style = 'color: red'>Повідомлення не  відправлено</h2>";
            unset($_SESSION["message_fail"]);
        } 
         ?>
        <h3>Відправити повідомлення користувачу <?php echo $user;?></h3>
        <form name="message" action="smessage.php?to= <?php echo $_GET['to']; ?>" method="POST">
            <textarea name="message" cols="70" rows="13"></textarea></br></br>
            <input type="hidden" name="to" value="<?php echo $_GET['to']; ?>" />
            <input type="submit" cols ="2" name="send" value="Відправити" />
        </form>
        
</body>
