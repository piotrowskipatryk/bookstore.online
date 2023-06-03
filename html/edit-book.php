<?php
    include 'utils/db.php';
    include 'utils/serializer.php';
    include 'utils/translations.php';

    $errors = false;
    $success = false;
    $key_to_label = array(
        "name" => _("name"),
        "price" => _("price"),
        "description" => _("description"),
        "photo" => _("photo"),
    );

    if (isset($_GET['id'])){
        $sql = "SELECT * FROM `products` WHERE id='". htmlspecialchars($_GET['id']) ."'";
        $result = mysqli_query($db, $sql);
        $result = mysqli_fetch_assoc($result);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        foreach($_POST as $key => $value)
        {
            if (empty($value)) {
                $errors = _("Field " . $key_to_label[$key] . " is required.");
                break;
            } else {
                $$key = prepare($value);
                switch ($key) {
                    case 'price':
                        $$key = str_replace(",", ".", $value);
                        if (!filter_var($$key, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION)) {
                            $errors = _("Wrong price format.");
                        }
                        break;
                }
            }
        }
        if (!$errors){
            $sql = "UPDATE `products` SET name='".$name."', price='".$price."', description='".$description."' WHERE id='".$id."'";
            $success = mysqli_query($db, $sql);
        }

        if ($success){
            header('Location: /admin.php');
        }
    }
?>
<html>
    <head>
        <title>bookstore.online | <?= _("add new book") ?></title>
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
                    <legend>Dane książki</legend>
                    <p>
                        <input type="hidden" name="id" value="<?= $result['id'] ?>" />
                    </p>
                    <p>
                        <input type="text" name="name" placeholder="<?= _("name") ?>" value="<?= $result['name'] ?>" />
                    </p>
                    <p>
                        <input type="text" name="description" placeholder="<?= _("description") ?>" value="<?= $result['description'] ?>" />
                    </p>
                    <p>
                        <input type="text" name="price" placeholder="<?= _("price") ?>" value="<?= $result['price'] ?>" />
                    </p>
                    <p class="right">
                        <input type="submit" class="submit-button" value="<?= _('submit') ?>"/>
                    </p>
                </fieldset>
                <?php if($errors) : ?><p class="errors"><?php echo $errors ?></p><?php endif; ?>
            </form>
        </div>
    </body>
</html>