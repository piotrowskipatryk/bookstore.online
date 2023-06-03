<?php
    include 'utils/db.php';
    include 'utils/auth.php';
    include 'utils/getuser.php';
    include 'utils/translations.php';
?>

<html>
    <head>
        <title>bookstore.online | <?= _("profile") ?></title>
        <META HTTP-EQUIV="Content Type" CONTENT="text/html;charset=iso8859-2">
        <META NAME=KEYWORDS CONTENT="html,php,projekt">
        <META NAME=DESCRIPTION CONTENT="Praca projektowa">
        <META NAME="author" CONTENT="Patryk Piotrowski">
        <META NAME="reply-to" CONTENT= "patryk.piotrowski2.stud@pw.edu.pl">
        <meta name="copyright" content="Patryk Piotrowski">

        <link rel="stylesheet" href="style.css">
        <link rel="icon" type="image/x-icon" href="/images/favicon.png">
    </head>
    <body>
        <?php include 'utils/header.php' ?>

        <div class="center"><?= $user_data_array['first_name'], ' ', $user_data_array['last_name'] ?></div>
        <div class="center"><?= $user_data_array['email'] ?></div>
        <div class="center"><?= $user_data_array['street'] ?></div>
        <div class="center">
             <?= $user_data_array['postal_code']?>, <?= $user_data_array['city']?>
        </div>
        <br />
        <div class="center"><a href="/"><?= _("go to home page") ?></a></div>
    </body>
</html>