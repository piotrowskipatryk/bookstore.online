<?php
    include 'utils/db.php';
    include 'utils/serializer.php';
    include 'utils/translations.php';
    if(array_key_exists('email', $_SESSION)){
        header('Location: /profile.php');
    }

    $errors = false;
    $success = false;
    $key_to_label = array(
        "first_name" => _("first name"),
        "last_name" => _("last name"),
        "password" => _("password"),
        "email" => _("email"),
        "street" => _("street"),
        "city" => _("city"),
        "postal_code" => _("postal code"),
    );

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        foreach($_POST as $key => $value)
        {
            if (empty($value)) {
                $errors = _("Field " . $key_to_label[$key] . " is required.");
                break;
            } else {
                $$key = prepare($value);
                switch ($key) {
                    case 'email':
                        if (!filter_var($$key, FILTER_VALIDATE_EMAIL)) {
                            $errors = _("Wrong email address format.");
                        }
                        break;
                    case 'postal_code':
                        if (!preg_match('/^([0-9]{2})(-[0-9]{3})?$/i', $$key)) {
                            $errors = _("Wrong postal code format.");
                        }
                        break;
                    case 'password':
                        $$key = md5($$key);
                }
            }
        }
        // data verified and checked - saving to db
        if (!$errors){
            $sql = "SELECT email FROM users WHERE email = '".$email."'";
            $email_result = mysqli_query($db, $sql);
            while($row = mysqli_fetch_array($email_result)){
                $errors = _("User with provided email address already exists.");
            }
            if (!$errors){
                $sql = "INSERT INTO users(`first_name`, `last_name`, `password`, `email`, `street`, `city`, `postal_code`) VALUES ('$first_name', '$last_name', '$password', '$email', '$street', '$city', '$postal_code')";
                $success = mysqli_query($db, $sql);
            }
        }

        // if success give session and redirect to page with data got from db
        if ($success){
            $_SESSION['valid'] = true;
            $_SESSION['email'] = $email;
            header('Location: /profile.php');
        }
    }
?>
<html>
    <head>
        <title>bookstore.online | <?= _("register") ?></title>
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
        <div class="center">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <fieldset>
                    <legend>Dane osobowe</legend>
                    <p>
                        <input type="text" name="first_name" placeholder="imię" value="<?= get_value('first_name') ?>" />
                    </p>
                    <p>
                        <input type="text" name="last_name" placeholder="nazwisko" value="<?= get_value('last_name') ?>" />
                    </p>
                    <p>
                        <input type="password" name="password" placeholder="hasło" value="<?= get_value('password') ?>" />
                    </p>
                    <p>
                        <input type="email" name="email" placeholder="email" value="<?= get_value('email') ?>" />
                    </p>
                </fieldset>
                <fieldset>
                    <legend>Adres</legend>
    
                    <p>
                        <input type="text" name="street" placeholder="ulica" value="<?= get_value('street') ?>" />
                    </p>
                    <p>
                        <input type="text" name="city" placeholder="miejscowość" value="<?= get_value('city') ?>" />
                    </p>
                    <p>
                        <input type="text" name="postal_code" placeholder="kod pocztowy" value="<?= get_value('postal_code') ?>" />
                    </p>
                </fieldset>
                <?php if($errors) : ?><p class="errors"><?php echo $errors ?></p><?php endif; ?>
                <p class="right">
                    <input type="submit" class="submit-button" value="Zarejestruj"/>
                </p>
            </form>
        </div>
    </body>
</html>