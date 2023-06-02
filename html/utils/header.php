<?php
    function active($item) {
        return str_contains($_SERVER['REQUEST_URI'], $item);
    }

    if (isset($_SESSION['cart'])){
        $cart_count = array_sum($_SESSION['cart']);
    } else {
        $cart_count = 0;
    }

?>

<div class="header">
    <div class="logo"><a href="/"><img src="/images/logo/logo.png" alt="bookstore.online" /></a></div>
    <div class="menu">
        <?php if(!isset($_SESSION['email'])) { ?>
            <div class="menu-item <?php if (active('login')) echo "active"; ?>"><a href="login.php"><?= _("login") ?></a></div>
            <div class="menu-item <?php if (active('register')) echo "active"; ?>"><a href="register.php"><?= _("register") ?></a></div>
            <?php } else { ?>
                <div class="menu-item <?php if (active('profile')) echo "active"; ?>"><a href="profile.php"><?= _("profile") ?> (<?= $_SESSION['email'] ?>)</a></div>
                <?php include 'utils/getuser.php'; if($user_data_array['is_staff']) { ?>
                    <div class="menu-item <?php if (active('admin')) echo "active"; ?>"><a href="admin.php"><?= _("admin panel") ?></a></div>
                <?php } ?>
                <div class="menu-item <?php if (active('logout')) echo "active"; ?>"><a href="/logout.php"><?= _("log out") ?></a></div>
        <?php } ?>
        <div class="menu-item <?php if (active('cart')) echo "active"; ?>"><a href="cart.php"><?= _("cart") ?> <?php if ($cart_count) echo "(".$cart_count.")" ?></a></div>
    </div>
</div>