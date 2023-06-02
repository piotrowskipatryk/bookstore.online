<?php
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
?>