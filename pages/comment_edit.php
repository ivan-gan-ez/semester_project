<?php

$id = $_GET["id"];

$database = connectToDB();

//get comments
$sql = "SELECT * FROM page_comments WHERE comment_id = :id";

$query = $database->prepare($sql);

$query->execute(["id" => $id]);

$comment = $query->fetch();

if ( !isAdmin() && $_SESSION["user"]["user_id"] != $comment['user_id'] ){
  header("Location: /");
  exit;
};

$id = $comment["comment_id"];
$number = $comment["page_id"];
$user = $comment["user_id"];
$content = $comment["content"];

?>

<?php require "parts/header.php"?>

    <div class="hero">
      <div class="mask p-5">
        <h1 class="text-center fw-normal text-light pb-3">Editing comment</h1>
        <div class="card p-4">
          <?php require "parts/message_error.php"?>

          <form method="POST" action="/auth/page/comment/edit">

            <div class="mb-3">
              <label for="text" class="form-label">Content</label>
              <textarea type="text" class="form-control" id="content" name="content" rows="5"><?= $content ?></textarea>
            </div>

            <div class="d-grid mt-4">
              <input type="hidden" name="id" value="<?= $id?>">
              <input type="hidden" name="number" value="<?= $number?>">
              <button type="submit" class="btn btn-success btn-fu">Done</button>
            </div>
            <div class="pt-4 text-center">
              <a class="link-success text-decoration-none" href="/page?number=<?=$number?>">Go back</a>
            </div>
          </form>
        </div>
      </div>
    </div>

<?php require "parts/footer.php"?>