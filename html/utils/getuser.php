<?php
    $sql = "SELECT * FROM users WHERE email = '" . $_SESSION['email'] . "'";
    $user_result = mysqli_query($db, $sql);
    $user_data_array = mysqli_fetch_array($user_result);
?>