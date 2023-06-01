<?php
    session_start();
    $db = mysqli_connect("mysql-server", "root", "secret", "bookstore");
    $errors = false;
    $success = false;

    $key_to_label = array(
        "street" => "ulica",
        "city" => "miejscowość",
        "postal_code" => "kod pocztowy",
    );

    if (isset($_GET['del'])){
        if (isset($_SESSION['cart'])){
            if ($_SESSION['cart'][$_GET['del']] > 1){
                $_SESSION['cart'][$_GET['del']] = $_SESSION['cart'][$_GET['del']] - 1;
            } else {
                unset($_SESSION['cart'][$_GET['del']]);
            }
        }
        header('Location: http://'.$_SERVER['HTTP_HOST'].'/cart.php');  # removing query param to prevent deleting to cart while page refresh
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
        foreach($_POST as $key => $value)
        {
            if (empty($value)) {
                $errors = "Pole " . $key_to_label[$key] . " jest wymagane.";
                break;
            } else {
                $$key = prepare($value);
                switch ($key) {
                    case 'postal_code':
                        if (!preg_match('/^([0-9]{2})(-[0-9]{3})?$/i', $$key)) {
                            $errors = "Błędny format kodu pocztowego.";
                        }
                        break;
                }
            }
        }

        if (!$errors) {
            mail("sklep@example.com", "Zamówienie ze sklepu internetowego", http_build_query($_POST, '', ', '));
            unset($_SESSION['cart']);
            unset($cart);
            $success = true;
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
        <title>bookstore.online | <?= _("cart") ?></title>
        <META HTTP-EQUIV="Content Type" CONTENT="text/html;charset=iso8859-2">
        <META NAME=KEYWORDS CONTENT="html,php,projekt,sklep,e-commerce">
        <META NAME=DESCRIPTION CONTENT="Praca projektowa - symulacja elementów sklepu internegowego">
        <META NAME="author" CONTENT="Patryk Piotrowski">
        <META NAME="reply-to" CONTENT= "patryk.piotrowski2.stud@pw.edu.pl">
        <meta name="copyright" content="Patryk Piotrowski">

        <link rel="stylesheet" href="style.css">
        <link rel="icon" type="image/x-icon" href="/images/favicon.png">
    </head>
    <body>
        <?php include 'utils/header.php' ?>
        <div class="center">
                <?php if($success) : ?><p>Zamówienie wysłane.</p><?php endif; ?>
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
                        echo 'Brak produktów w koszyku.';
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
        <div class="center form">
            <?php if(isset($cart)) : ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <fieldset>
                        <legend>Adres</legend>
                        <p>
                            <input type="hidden" name="products" value="<?= http_build_query($_SESSION['cart'], 'product_id:', ', ') ?>" />
                        </p>
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
                    <input type="submit" class="submit" value="Złóż zamówienie"/>
                </form>
                <?php endif; ?>
            </div>
            <div class="center">
                <?php if($errors) : ?><p class="errors"><?= $errors ?></p><?php endif; ?>
            </div>
    </body>
</html>