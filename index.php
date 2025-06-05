<?php

session_start();

require "includes/functions.php";

$path = $_SERVER["REQUEST_URI"];
$path = parse_url( $path, PHP_URL_PATH );

switch ($path) {

    # actual pages

    case '/fact/add':
        require "pages/fact_add.php";
        break;

    case '/fact/edit':
        require "pages/fact_edit.php";
        break;
        
    case '/login':
        require "pages/login.php";
        break;

    case '/logout':
        require "pages/logout.php";
        break;

    case '/page':
        require "pages/page.php";
        break;
        
    case '/page/edit':
        require "pages/page_edit.php";
        break;

    case '/signup':
        require "pages/signup.php";
        break;
        
    case '/userpage':
        require "pages/userpage.php";
        break;

    case '/user/changepwd':
        require "pages/user/user_changepwd.php";
        break;

    case '/user/edit':
        require "pages/user/user_edit.php";
        break;
        
    case '/user/manage':
        require "pages/user/users_manage.php";
        break;

    case '/comment/add':
        require "pages/comment_add.php";
        break;

    case '/comment/edit':
        require "pages/comment_edit.php";
        break;

    case '/user/comment/add':
        require "pages/user/user_comment_add.php";
        break;

    case '/user/comment/edit':
        require "pages/user/user_comment_edit.php";
        break;


    # behind the scene pages. im using "auth" as a catch-all term for these because i don't want kpop fans or haters freaking out over something like "/bts/login"

    case '/auth/login':
        require "includes/auth/do_login.php";
        break;

    case '/auth/signup':
        require "includes/auth/do_signup.php";
        break;
        
    case '/auth/fact/add':
        require "includes/fact/add.php";
        break;

    case '/auth/fact/delete':
        require "includes/fact/delete.php";
        break;

    case '/auth/fact/edit':
        require "includes/fact/edit.php";
        break;

    case '/auth/user/changepwd':
        require "includes/user/changepwd.php";
        break;

    case '/auth/user/delete':
        require "includes/user/delete.php";
        break;

    case '/auth/user/edit':
        require "includes/user/edit.php";
        break;

    case '/auth/page/edit':
        require "includes/page/edit.php";
        break;

    case '/auth/page/comment/add':
        require "includes/page/comment_add.php";
        break;

    case '/auth/page/comment/edit':
        require "includes/page/comment_edit.php";
        break;

    case '/auth/page/comment/delete':
        require "includes/page/comment_delete.php";
        break;

    case '/auth/user/comment/add':
        require "includes/user/comment_add.php";
        break;

    case '/auth/user/comment/edit':
        require "includes/user/comment_edit.php";
        break;

    case '/auth/user/comment/delete':
        require "includes/user/comment_delete.php";
        break;

    case '/auth/featured/add':
        require "includes/featured/add.php";
        break;

    case '/auth/featured/delete':
        require "includes/featured/delete.php";
        break;

    # default

    default:
        require "pages/main.php";
        break;
};

?>