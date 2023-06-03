<?php
    putenv("LANG=pl_PL");
    setlocale(LC_ALL, 'pl_PL.UTF-8');
    $domain = "messages";
    bindtextdomain($domain, "translations");
    bind_textdomain_codeset($domain, 'UTF-8');
    textdomain($domain);
?>