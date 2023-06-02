<?php
    include 'utils/db.php';
    include 'utils/auth.php';
    include 'utils/getuser.php';
?>

<html>
    <head>
        <title>bookstore.online | <?= _("admin panel") ?></title>
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

        <table>
            <tr>
                <th colspan="6"><?= _("orders") ?></th>
            </tr>
            <tr>
                <th><?= _("number") ?></th>
                <th><?= _("products") ?></th>
                <th><?= _("user") ?></th>
                <th><?= _("address") ?></th>
                <th><?= _("total") ?></th>
                <th><?= _("actions") ?></th>
            </tr>
    
            <?php
                $sql = "SELECT orders.id as order_id, total_value, users.first_name, users.last_name, users.street, users.city, users.postal_code FROM orders INNER JOIN users ON orders.user_id = users.id INNER JOIN iteminorder ON iteminorder.order_id = orders.id INNER JOIN products ON products.id = iteminorder.product_id;";
                $result = mysqli_query($db, $sql);
                while($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><?= $row['order_id'] ?></td>
                    <td></td>
                    <td><?= $row['first_name'] ?> <?= $row['last_name'] ?></td>
                    <td><?= $row['street'] ?>, <?= $row['city'] ?> <?= $row['postal_code'] ?>, <?= $row['city'] ?></td>
                    <td><?= $row['total_value'] ?></td>
                    <td></td>
                </tr>
            <?php } ?>
        </table>

    </body>
</html>