<?php

$database = connectToDB();

if ( isUserLoggedIn() ) {
    $name = $_SESSION['user']['name'];

    $sql = "SELECT * FROM users WHERE name = :name";
    $query = $database->prepare($sql);
    $query->execute(["name" => $name]);
    $user = $query->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Numberpedia</title>

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7"
      crossorigin="anonymous"
    />

    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&family=Noto+Sans+Math&family=Playpen+Sans:wght@100..800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/pages/style/style.css" />
  </head>
  <body>
    <!--navbar start-->
    <nav class="navbar navbar-expand-lg px-3">
      <div class="container-fluid">
        <span class="navbar-brand">
          <a class="nav-link" href="/">
            <img src="/pages/style/numberpedia.svg" style="height: 50px" />
          </a>
        </span>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <i class="bi bi-list"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="/">Home</a>
            </li>

            <?php if ( isUserLoggedIn() ) {?>
            <li class="nav-item">
              <a class="nav-link" href="/userpage?id=<?= $user['user_id']?>">My page</a>
            </li>
            <?php } ?>

            <?php if ( isAdmin() ) {?>
                <li class="nav-item">
                <a class="nav-link" href="/user/manage">All users</a>
                </li>
            <?php } ?>
          </ul>

          <form method="GET" action="/page" class="d-flex" role="search">
            <input
              class="form-control me-2"
              type="search"
              placeholder="Search"
              aria-label="Search"
              name="number"
            />
            <button class="btn btn-success" type="submit">Search</button>
          </form>

          <ul class="navbar-nav mb-2 mb-lg-0">
            <?php if ( isUserLoggedIn() ) {?>
                <li class="nav-item">
                <a class="nav-link" href="/logout">Logout</a>
                </li>
            <?php } else { ?>
                <li class="nav-item">
                <a class="nav-link" href="/login">Log In</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="/signup">Sign Up</a>
                </li>
            <?php } ?>

          </ul>

        </div>
      </div>
    </nav>
    <!--navbar end-->