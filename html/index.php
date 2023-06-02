<?php
    include 'utils/db.php';
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
?>
<html>
    <head>
        <title>bookstore.online | <?= _("homepage") ?></title>
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
            <div class="bookshelf">
                <?php if ($result) : ?>
                    <?php while($row = mysqli_fetch_assoc($result)) { ?>
                        <div class="book-item">
                            <div class="photo"><img src="<?= $row['photo_path'] ?>" /></div>
                            <div>
                                <div class="title"><?= $row['name'] ?></div>
                                <div class="description"><?= $row['description'] ?></div>
                            </div>
                            <div class="price-and-button">
                                <div class="price"><?= $row['price'] ?> zł</div>
                                    <form>
                                        <button type="submit" class="add-button">
                                            <?= _("add to cart") ?>
                                        </button>
                                        <input type="hidden" name="add" value="<?= $row['id'] ?>" /></label>
                                    </form>
                            </div>
                        </div>
                    <?php } ?>
                <?php else : ?>
                    <p>Brak produktów w bazie.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="footer">
            <p>© Copyright by <span>Patryk Piotrowski</span> 2023</p>
        </div>
    </body>
</html>
<?php mysqli_close($db); ?>