<?php

if ( !isUser() ){
  header("Location: /");
  exit;
};

$fact_id = $_GET["fact"];

$database = connectToDB();

$sql = "SELECT * FROM facts WHERE fact_id = :id";

$query = $database->prepare($sql);

$query->execute(["id" => $fact_id]);

$fact = $query->fetch();

?>

<?php require "parts/header.php"?>

    <div class="hero">
      <div class="mask p-5">
        <h1 class="text-center fw-normal text-light pb-3">
          Editing fact about <?=$fact['number']?>
        </h1>
        <div class="card p-4">
          <form method="POST" action="/auth/fact/edit" enctype="multipart/form-data">

            <?php require "parts/message_error.php"?>

            <div class="mb-3">
              <label for="password" class="form-label">Fact</label>
              <input type="text" class="form-control" id="fact" name="fact" value="<?=$fact['fact']?>"/>
            </div>

            <label class="form-label">Image</label>
            <div class="mb-4">
              <img src="<?=$fact['image']?>" class="img-fluid" />
            </div>
            <input type="file" name="image" accept="image/*" />

            <div class="d-grid mt-4">
              <input type="hidden" name="id" value="<?=$fact['fact_id']?>"></input>
              <input type="hidden" name="number" value="<?=$fact['number']?>"></input>
              <button type="submit" class="btn btn-success btn-fu">Done</button>
            </div>
            <div class="pt-4 text-center">
              <a class="link-success text-decoration-none" href="/page/edit?number=<?=$fact['number']?>">Go back</a>
            </div>
          </form>
        </div>
      </div>
    </div>

<?php require "parts/footer.php"?>
