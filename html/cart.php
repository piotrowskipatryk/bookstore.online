<?php
    include 'utils/db.php';
    $errors = false;
    $success_message = false;

    if (isset($_GET['del'])){
        if (isset($_SESSION['cart'])){
            if ($_SESSION['cart'][$_GET['del']] > 1){
                $_SESSION['cart'][$_GET['del']] = $_SESSION['cart'][$_GET['del']] - 1;
            } else {
                unset($_SESSION['cart'][$_GET['del']]);
            }
        }
        header('Location: http://'.$_SERVER['HTTP_HOST'].'/cart.php');
    }

    if (isset($_SESSION['cart']) && $_SESSION['cart']) {
        $ids = implode(",", array_keys($_SESSION['cart']));
        $sql = "SELECT id, name, photo_path, price FROM products WHERE id in (" . $ids . ")";
        $result = mysqli_query($db, $sql);
        $cart = array();
        $total = 0;
        while($row = mysqli_fetch_assoc($result)) {
            $row['count'] = $_SESSION['cart'][$row['id']];
            $row['sum'] = $row['count'] * $row['price'];
            $total = $total + $row['sum'];
            array_push($cart, $row);
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(!isset($_SESSION['email'])){
            header('Location: /login.php');
        }
        if (!$errors) {
            include 'utils/getuser.php';
            $user_id = $user_data_array['id'];
            $sql = "INSERT INTO orders(`user_id`, `total_value`) VALUES ('$user_id', '$total')";
            mysqli_query($db, $sql);
            $order_id = mysqli_insert_id($db);
            foreach ($cart as $value){
                $product_id = $value['id'];
                $quantity = $value['count'];
                $price = $value['price'];
                $sql = "INSERT INTO iteminorder(`order_id`, `product_id`, `quantity`, `price`) VALUES ('$order_id', '$product_id', '$quantity', '$price')";
                mysqli_query($db, $sql);
            }
            unset($_SESSION['cart']);
            unset($cart);
            $success_message = true;
        }
    }
?>

<html>
    <head>
        <title>bookstore.online | <?= _("cart") ?></title>
        <META HTTP-EQUIV="Content Type" CONTENT="text/html;charset=iso8859-2">
        <META NAME=KEYWORDS CONTENT="html,php,projekt,sklep,e-commerce">
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
                <?php if($success_message) : ?><p><?= _("Order was successfully made.") ?></p><?php endif; ?>
            </div>
        <div class="center">
            <table>
                <?php if(isset($cart)) : ?>
                    <tr>
                        <th></th>
                        <th>nazwa</th>
                        <th>ilość sztuk</th>
                        <th>cena jednostkowa</th>
                        <th>suma</th>
                        <th></th>
                    </tr>
                <?php endif; ?>
                <?php
                    if (isset($cart)) {
                        foreach ($cart as $value){
                            echo '<tr>';
                            echo '<td><img width="50px" src="' . $value['photo_path'] . '"/></td>';
                            echo '<td>' . $value['name'] . '</td>';
                            echo '<td>' . $value['count'] . '</td>';
                            echo '<td>' . $value['price'] . 'zł</td>';
                            echo '<td>' . $value['sum'] . 'zł</td>';
                            echo '<td><a href="?del=' . $value['id'] . '">usuń</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo _('Cart is empty. Click on the logo to go to the home page.');
                    }
                ?>
                <?php
                    if (isset($cart)){
                        echo '<tr>';
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td>razem</td>';
                        echo '<td>' . $total . 'zł</td>';
                        echo '<td></td>';
                        echo '</tr>';
                    }
                ?>
            </table>
        </div>
        <div class="form center">
            <?php if(isset($cart)) : ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <input type="submit" class="submit-button" value="<?= _('place order') ?>"/>
                </form>
            <?php endif; ?>
            <?php if($errors) : ?><p class="errors"><?php echo $errors ?></p><?php endif; ?>
        </div>
    </body>
</html>