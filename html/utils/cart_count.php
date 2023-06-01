<?php
    if (isset($_SESSION['cart'])){
        $cart_count = array_sum($_SESSION['cart']);
    } else {
        $cart_count = 0;
    }
?>