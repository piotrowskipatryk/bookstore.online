<?php
    function active($item) {
        return str_contains($_SERVER['REQUEST_URI'], $item);
    }
?>

<div class="header">
    <div class="logo"><a href="/"><img src="/images/logo/logo.png" alt="bookstore.online" /></a></div>
    <div class="menu">
        <div class="menu-item <?php if (active('profile')) echo "active"; ?>"><a href="profile.php"><?= _("login") ?></a></div>
        <div class="menu-item <?php if (active('register')) echo "active"; ?>"><a href="register.php"><?= _("register") ?></a></div>
        <div class="menu-item <?php if (active('cart')) echo "active"; ?>"><a href="cart.php"><?= _("cart") ?> <?php if ($cart_count) echo "(".$cart_count.")" ?></a></div>
    </div>
</div>