<?php
    include 'utils/db.php';
    include 'utils/serializer.php';
    if(array_key_exists('email', $_SESSION)){
        header('Location: /profile.php');
    }

    $errors = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $sql = "SELECT password FROM users WHERE email = '".htmlspecialchars($_POST['email'])."'";
        $result = mysqli_query($db, $sql);

        while($row = mysqli_fetch_array($result)){
            if ($row["password"] == md5(prepare($_POST['password']))){
                $_SESSION['email'] = $_POST['email'];
                header('Location: /profile.php');
            }
        }
        $errors = _("Password is not correct.");
    }
?>
<html>
    <head>
        <title>bookstore.online | <?= _("login") ?></title>
        <META HTTP-EQUIV="Content Type" CONTENT="text/html;charset=iso8859-2">
        <META NAME=KEYWORDS CONTENT="html,php,projekt,logowanie">
        <META NAME=DESCRIPTION CONTENT="Praca projektowa">
        <META NAME="author" CONTENT="Patryk Piotrowski">
        <META NAME="reply-to" CONTENT= "patryk.piotrowski2.stud@pw.edu.pl">
        <meta name="copyright" content="Patryk Piotrowski">

        <link rel="stylesheet" href="style.css">
        <link rel="icon" type="image/x-icon" href="/images/favicon.png">
    </head>
    <body>
        <?php include 'utils/header.php' ?>
        <div class="center">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <fieldset>
                    <legend><?= _("Log in") ?></legend>
                    <p>
                        <input type="email" name="email" placeholder="email" value="<?= get_value('email') ?>" />
                    </p>
                    <p>
                        <input type="password" name="password" placeholder="hasło" value="<?= get_value('password') ?>" />
                    </p>
                    <p class="right">
                        <input type="submit" class="submit-button" value="<?= _("log in") ?>"/>
                    </p>
                </fieldset>
                <?php if($errors) : ?><p class="errors"><?php echo $errors ?></p><?php endif; ?>
                <p class="right">
                    <a href="/register.php"><?= _("You don't have an account? Click to register.") ?></a>
                </p>
            </form>
        </div>
    </body>
</html>