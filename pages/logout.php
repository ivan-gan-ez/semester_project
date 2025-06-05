<?php

    //for logout

    // 1: remove user session
    unset( $_SESSION["user"] );

    // 2: redirect user
    header("Location: /");
    exit;
?>