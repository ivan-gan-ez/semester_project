<?php

if ( !isUser() ){
  header("Location: /");
  exit;
};

$number = $_GET["number"]

?>
<?php require "parts/header.php"?>

    <div class="hero">
      <div class="mask p-5">
        <h1 class="text-center fw-normal text-light pb-3">
          Adding fact about <?=$number?>
        </h1>
        <div class="card p-4">
          <form method="POST" action="/auth/fact/add" enctype="multipart/form-data">

            <?php require "parts/message_error.php"?>

            <div class="mb-3">
              <label for="password" class="form-label">Fact</label>
              <input type="text" class="form-control" id="fact" name="fact" />
            </div>

            <label class="form-label">Image</label>
            <br />
            <input type="file" name="image" accept="image/*" />

            <div class="d-grid mt-4">
              <input type="hidden" name="number" value="<?=$number?>"></input>
              <button type="submit" class="btn btn-success btn-fu">Done</button>
            </div>
            <div class="pt-4 text-center">
              <a class="link-success text-decoration-none" href="/page/edit?number=<?=$number?>">Go back</a>
            </div>
          </form>
        </div>
      </div>
    </div>

<?php require "parts/footer.php"?>