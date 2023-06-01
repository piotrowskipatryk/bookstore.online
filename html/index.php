<?php
    $db = mysqli_connect("mysql-server", "root", "secret", "bookstore");
    session_start();
    $sql = "SELECT * FROM products";
    $result = mysqli_query($db, $sql);

    if (isset($_GET['add'])){
        if (isset($_SESSION['cart'])){
            if (isset($_SESSION['cart'][$_GET['add']])){
                $_SESSION['cart'][$_GET['add']]++;
            } else {
                $_SESSION['cart'][$_GET['add']] = 1;
            }
        } else {
            $_SESSION['cart'] = array($_GET['add'] => 1);
        }
        header('Location: http://'.$_SERVER['HTTP_HOST']);  # removing query param to prevent adding to cart while page refresh
    }

    if (isset($_SESSION['cart'])){
        $cart_count = array_sum($_SESSION['cart']);
    } else {
        $cart_count = 0;
    }
?>
<html>
    <head>
        <title>Projekt cząstkowy 2 - prosta symulacja elementów sklepu internetowego</title>
        <META HTTP-EQUIV="Content Type" CONTENT="text/html;charset=iso8859-2">
        <META NAME=KEYWORDS CONTENT="html,php,projekt,sklep,e-commerce">
        <META NAME=DESCRIPTION CONTENT="Praca projektowa - symulacja elementów sklepu internegowego">
        <META NAME="author" CONTENT="Patryk Piotrowski">
        <META NAME="reply-to" CONTENT= "patryk.piotrowski2.stud@pw.edu.pl">
        <meta name="copyright" content="Patryk Piotrowski">

        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="row">
            <div class="child center">Produkty:</div>
            <div class="child cart"><a href="cart.php">Ilość produktów w koszyku: <?= $cart_count ?></a></div>
        </div>
        <div class="center">
            <ul>
                <?php
                    if ($result) {
                        while($row = mysqli_fetch_assoc($result)) {
                            echo '<li class="product">';
                            echo $row['name'];
                            echo "<ul>";
                            echo '<li><img width="200px" src="' . $row['photo_path'] . '" /></li>';
                            echo "<li>cena: " . $row['price'] . 'zł</li>';
                            echo "<li>opis: " . $row['description'] . 'zł</li>';
                            echo '<li>' . '<a href="?add=' . $row['id'] . '">dodaj do koszyka</a>' . '</li>';
                            echo "</ul>";
                            echo "</li>";
                        }

                    } else {
                        echo "<li>Brak produktów w bazie.</li>";
                    }
                ?>
            </ul>
        </div>
    </body>
</html>
<?php mysqli_close($db); ?>