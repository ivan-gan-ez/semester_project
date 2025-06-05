<?php

$database = connectToDB();

//get number info
$sql = "SELECT * FROM featured ORDER BY number ASC";

$query = $database->prepare($sql);

$query->execute();

$numbers = $query->fetchAll();

?>

<?php require "parts/header.php"?>

    <div class="hero">
      <div class="mask p-5">
        <h1 class="display-1 text-center fw-normal text-light m-5">
          Welcome to Numberpedia!
        </h1>

        <form method="GET" action="/page" class="d-flex mb-4" role="search">
          <input
            class="form-control me-2"
            type="search"
            placeholder="Search for a number..."
            aria-label="Search"
            name="number"
          />
          <button class="btn btn-success" type="submit">Search</button>
        </form>

        <?php require "parts/message_error.php"?>
        <?php require "parts/message_success.php"?>

        <h1 class="text-light my-4">Featured Numbers</h1>
        <?php if ( isAdmin() ) {?>
          <form method="POST" action="/auth/featured/add" class="d-flex mb-4" role="search">
            <input class="form-control me-2" type="search" placeholder="Like a number? Put it on the front page!" aria-label="Search" name="number"/>
            <button class="btn btn-success" type="submit">Search</button>
          </form>
        <?php }?>
          
        <div class="row">

          <?php foreach ($numbers as $i => $number) {?>
            <div class="col-4 col-md-3 col-lg-2 mb-4">
              <div class="card text-center p-3">
                <h1 class="display-5 fw-bold"><?=$number['number']?><h1>
                  <div>
                    <a href="/page?number=<?=$number['number']?>" class="btn btn-primary btn-sm me-2">
                      <i class="bi bi-eye"></i>
                    </a>
                    
                    <?php if ( isAdmin() ) {?>
                      <form method="POST" action="auth/featured/delete" class="d-inline">
                        <input type="hidden" name="number" value=<?=$number['number']?>>
                        <button class="btn btn-danger btn-sm me-2 submit"><i class="bi bi-trash"></i></button>
                      </form>
                    <?php };?>
                  </div>
              </div>
            </div>
          <?php };?>

        <div>
      </div>
    </div>

<?php require "parts/footer.php"?>
