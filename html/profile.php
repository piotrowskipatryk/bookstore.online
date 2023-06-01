<?php
    session_start();

    if(!isset($_SESSION['valid']) || $_SESSION['valid'] != true){
        header('Location: /index.php');
    }

    $db = mysqli_connect("mysql-server", "root", "secret", "bookstore");
    $sql = "SELECT * FROM users WHERE login = '" . $_SESSION['login'] . "'";
    $result = mysqli_query($db, $sql);
    $user_data_array = mysqli_fetch_array($result);
?>

<html>
    <head>
        <title>bookstore.online | <?= _("profile") ?></title>
        <META HTTP-EQUIV="Content Type" CONTENT="text/html;charset=iso8859-2">
        <META NAME=KEYWORDS CONTENT="html,php,projekt,rejestracja">
        <META NAME=DESCRIPTION CONTENT="Praca projektowa - mechanizm rejestracji">
        <META NAME="author" CONTENT="Patryk Piotrowski">
        <META NAME="reply-to" CONTENT= "patryk.piotrowski2.stud@pw.edu.pl">
        <meta name="copyright" content="Patryk Piotrowski">

        <link rel="stylesheet" href="style.css">
        <link rel="icon" type="image/x-icon" href="/images/favicon.png">
    </head>
    <body>
        <div class="center">dane konta:</div>
        <div class="center">login: <?php echo $user_data_array['login'] ?></div>
        <div class="center">imię: <?php echo $user_data_array['first_name'] ?></div>
        <div class="center">nazwisko: <?php echo $user_data_array['last_name'] ?></div>
        <div class="center">email: <?php echo $user_data_array['email'] ?></div>
        <div class="center">adres:</div>
        <div class="center"><?php echo $user_data_array['street'] ?></div>
        <div class="center">
             <?= $user_data_array['postal_code']?>, <?= $user_data_array['city']?>
        </div>
        <div class="center">zainteresowania: <?php echo implode(', ', unserialize($user_data_array['intrests'])) ?></div>
        <div class="center">wykształcenie: <?php echo $user_data_array['education'] ?></div>
        <br />
        <div class="center"><a href="/logout.php">wyloguj</a></div>
    </body>
</html>