<?php
    $db = mysqli_connect("mysql-server", "root", "secret", "bookstore");
    session_start();
    $errors = "";
    $success = false;
    $query_db = true;
    $key_to_label = array(
        "first_name" => "imię",
        "last_name" => "nazwisko",
        "login" => "login",
        "password" => "hasło",
        "email" => "email",
        "street" => "ulica",
        "city" => "miejscowość",
        "postal_code" => "kod pocztowy",
        "intrests" => "zainteresowania",
        "education" => "wykształcenie",
    );

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        foreach($_POST as $key => $value)
        {
            if (empty($value)) {
                $errors = "Pole " . $key_to_label[$key] . " jest wymagane.";
                $query_db = false;
                break;
            } else {
                $$key = prepare($value);
                switch ($key) {
                    case 'email':
                        if (!filter_var($$key, FILTER_VALIDATE_EMAIL)) {
                            $errors = "Błędny format adresu email.";
                        }
                        break;
                    case 'postal_code':
                        if (!preg_match('/^([0-9]{2})(-[0-9]{3})?$/i', $$key)) {
                            $errors = "Błędny format kodu pocztowego.";
                        }
                        break;
                    case 'password':
                        $$key = password_hash($$key, PASSWORD_DEFAULT);
                }
            }
        }
        // data verified and checked - saving to db
        if ($query_db){
            $sql = "INSERT INTO users VALUES ('$first_name', '$last_name', '$login', '$password', '$email', '$street', '$city', '$postal_code', '$intrests', '$education')";
            $success = mysqli_query($db, $sql);
        }

        // if success give session and redirect to page with data got from db
        if ($success){
            $_SESSION['valid'] = true;
            $_SESSION['login'] = $login;
            header('Location: /profile.php');
        }
    }

    function prepare($data) {
        if (!is_array($data)){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
        } else {
            $data = serialize($data);
        }
        return $data;
    }

    function get_value($input) {
        if(isset($_POST[$input])){
            return $_POST[$input];
        }
    }

    include 'utils/cart_count.php';
?>
<html>
    <head>
        <title>bookstore.online | <?= _("register") ?></title>
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
                        <input type="text" name="login" placeholder="login" value="<?= get_value('login') ?>" />
                    </p>
                    <p>
                        <input type="password" name="password" placeholder="hasło" value="<?= get_value('password') ?>" />
                    </p>
                    <p>
                        <input type="email" name="email" placeholder="email" value="<?= get_value('email') ?>" />
                    </p>
                    <p>
                        <label for="education" accesskey="w">Wykształcenie: </label>
                        <label><input type="radio" name="education" value="podstawowe" <?php if(get_value('education') == 'podstawowe') : ?> checked <?php endif; ?>> podstawowe</label>
                        <label><input type="radio" name="education" value="srednie" <?php if(get_value('education') == 'srednie') : ?> checked <?php endif; ?>> średnie</label>
                        <label><input type="radio" name="education" value="wyzsze" <?php if(get_value('education') == 'wyzsze') : ?> checked <?php endif; ?>> wyższe</label>
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
                <fieldset>
                    <legend>Zainteresowania</legend>
    
                    <p>
                        <input type="checkbox" name="intrests[]" value="sport" <?php if(get_value('intrests') == 'sport') : ?> checked <?php endif; ?>/> sport
                    </p>
                    <p>
                        <input type="checkbox" name="intrests[]" value="turystyka" <?php if(get_value('intrests') == 'turystyka') : ?> checked <?php endif; ?>/> turystyka
                    </p>
                    <p>
                        <input type="checkbox" name="intrests[]" value="kino" <?php if(get_value('intrests') == 'kino') : ?> checked <?php endif; ?>/> kino
                    </p>
                    <p>
                        <input type="checkbox" name="intrests[]" value="muzyka" <?php if(get_value('intrests') == 'muzyka') : ?> checked <?php endif; ?>/> muzyka
                    </p>
                    <p>
                        <input type="checkbox" name="intrests[]" value="technologia" <?php if(get_value('intrests') == 'technologia') : ?> checked <?php endif; ?>/> technologia
                    </p>
                </fieldset>
                <?php if($errors) : ?><p class="errors"><?php echo $errors ?></p><?php endif; ?>
                <p>
                    <input type="submit" class="submit-button" value="Zarejestruj"/>
                </p>
            </form>
        </div>
    </body>
</html>