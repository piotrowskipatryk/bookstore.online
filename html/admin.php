<?php
    include 'utils/db.php';
    include 'utils/auth.php';
    include 'utils/getuser.php';
    include 'utils/translations.php';

    if (isset($_GET['send'])){
        $sql = "UPDATE iteminorder SET is_sent=true WHERE id='".htmlspecialchars($_GET['send'])."'";
        mysqli_query($db, $sql);
        header('Location: http://'.$_SERVER['HTTP_HOST'].'/admin.php');
    }

    if (isset($_GET['del'])){
        $sql = "DELETE FROM `products` WHERE id='".htmlspecialchars($_GET['del'])."'";
        mysqli_query($db, $sql);
        header('Location: http://'.$_SERVER['HTTP_HOST'].'/admin.php');
    }

    if (isset($_POST['add-new'])){
        header('Location: http://'.$_SERVER['HTTP_HOST'].'/add-new-book.php');
    }
?>

<html>
    <head>
        <title>bookstore.online | <?= _("admin panel") ?></title>
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

        <div class="admin-panel">
            <table class="ordered-books-table">
                <tr>
                    <th colspan="6"><?= _("ordered books") ?></th>
                </tr>
                <tr>
                    <th><?= _("order no.") ?></th>
                    <th><?= _("products") ?></th>
                    <th><?= _("user") ?></th>
                    <th><?= _("address") ?></th>
                    <th><?= _("total") ?></th>
                    <th><?= _("actions") ?></th>
                </tr>
        
                <?php
                    $sql = "SELECT * FROM `order_table`";
                    $result = mysqli_query($db, $sql);
                    while($row = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                        <td><?= $row['order_id'] ?></td>
                        <td><?= $row['itemtitle'] ?></td>
                        <td><?= $row['first_name'] ?> <?= $row['last_name'] ?></td>
                        <td><?= $row['street'] ?>, <?= $row['city'] ?> <?= $row['postal_code'] ?>, <?= $row['city'] ?></td>
                        <td><?= $row['price'] ?> zł</td>
                        <td><a href="?send=<?= $row['iteminorderid'] ?>"><?= _("send the book") ?></a></td>
                    </tr>
                <?php } ?>
            </table>

            <table>
                <tr>
                    <th colspan="6"><?= _("books management") ?></th>
                </tr>
                <tr>
                    <th><?= _("book no.") ?></th>
                    <th><?= _("photo") ?></th>
                    <th><?= _("name") ?></th>
                    <th><?= _("description") ?></th>
                    <th><?= _("price") ?></th>
                    <th><?= _("actions") ?></th>
                </tr>
        
                <?php
                    $sql = "SELECT * FROM `products`";
                    $result = mysqli_query($db, $sql);
                    while($row = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['photo_path'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['description'] ?></td>
                        <td><?= $row['price'] ?></td>
                        <td>
                            <a href="/edit-book.php?id=<?= $row['id'] ?>"><?= _("edit") ?></a><br/>
                            <a href="?del=<?= $row['id'] ?>"><?= _("delete") ?></a>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="6">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="center">
                                <button type="submit" class="submit-button">
                                    <?= _("add new book") ?>
                                </button>
                                <input type="hidden" name="add-new">
                            </form>
                        </td>
                    </tr>
            </table>
        </div>

    </body>
</html>