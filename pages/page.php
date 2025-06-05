<?php

$search = $_GET["number"];

if ( !is_numeric($search) or str_contains($search, "e") ){
  $_SESSION["error"] = "Not a number.";
  header("Location: /");  
  exit;
};

$database = connectToDB();

//get number info
$sql = "SELECT * FROM pages WHERE page_id = :number";

$query = $database->prepare($sql);

$query->execute(["number" => $search]);

$number = $query->fetch();

//get facts
$sql = "SELECT * FROM facts WHERE number = :number";

$query = $database->prepare($sql);

$query->execute(["number" => $search]);

$facts = $query->fetchAll();

//get comments
$sql = "SELECT page_comments.*, users.* FROM page_comments INNER JOIN users ON page_comments.user_id = users.user_id WHERE page_id = :number ORDER BY comment_id DESC";

$query = $database->prepare($sql);

$query->execute(["number" => $search]);

$comments = $query->fetchAll();

if ( isset($_SESSION["user"]["user_id"]) ) {
  $sessionid = $_SESSION["user"]["user_id"];
} else {
  $sessionid = "";
}

?>

<?php require "parts/header.php"?>

    <div class="hero">
      <div class="mask p-5">
        <div class="mask2 p-5">

          <?php require "parts/message_success.php"?>

          <div class="d-flex justify-content-between">
            <h1 class="fw-bold"><?= $search ?></h1>
            
            <?php if( isUser() ) {?>
            <form method="GET" action="/page/edit">
              <input type="hidden" name="number" value="<?=$search ?>"></input>
              <button class="btn btn-success px-3 submit">
                <i class="bi bi-pencil"></i> Edit
              </button>
            </form>
            <?php } ?>

          </div>
          
          <p class="py-3">
            Prime factorisation: <?php echo ( $number != NULL ? $number["prime_factorisation"] : "" ); ?>
            <br />
            Factors: <?php echo ( $number != NULL ? $number["factors"].countFactors($number["factors"]) : "" ); ?>
          </p>

          <?php foreach ($facts as $i => $fact) {?>
          
          <p><?= $fact['fact'];?></p>
          <img src="<?= $fact['image'];?>">

          <?php }; ?>

        </div>

          <!-- comments section start -->
        <h1 class="text-light my-4">Comments</h1>

        <?php if ( isUser() ) {?>
        <a href="/comment/add?number=<?= $search?>" class="btn btn-success w-100 mb-2">Add New Comment</a>
        <?php }; ?>

        <?php foreach ($comments as $i => $comment) {?>
          
        <div class="card my-4 p-4">
          <div class="row">
            <div class="col-1">
              <img src="<?=$comment["profile_picture"]?>" class="rounded-circle pfp">
            </div>
            <div class="col-11">
              <div class="d-flex justify-content-between">
                <h4><a href="userpage?id=<?= $comment['user_id']?>" class="link-success fw-bold"><?= $comment['name']?></a></h4>

                <div class="align-items-end d-flex gap-2">

                <?php if( isAdmin() || $comment['user_id'] === $sessionid ) {?>
                <form method="GET" action="/comment/edit">
                  <input type="hidden" name="id" value="<?=$comment['comment_id'] ?>"></input>
                  <button class="btn btn-success px-3 submit">
                    <i class="bi bi-pencil"></i> Edit
                  </button>
                </form>
                
                <!-- Button trigger modal -->
                <button
                type="button"
                class="btn btn-danger btn-sm h-100"
                data-bs-toggle="modal"
                data-bs-target="#commentDeleteModal-<?= $comment["comment_id"]?>"
                >
                <i class="bi bi-trash"></i>
              </button>
              
              <!-- Modal -->
              <div
              class="modal fade"
              id="commentDeleteModal-<?= $comment["comment_id"]?>"
              tabindex="-1"
              aria-labelledby="exampleModalLabel"
              aria-hidden="true"
              >
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                      Are you sure you want to delete?
                    </h1>
                    <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                    ></button>
                  </div>
                  <div class="modal-body text-start">
                    This action cannot be undone.
                  </div>
                  <div class="modal-footer">
                    <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                    >
                    No
                  </button>
                  <form
                  method="post"
                  action="/auth/page/comment/delete"
                  style="display: inline"
                  >
                  <input
                  type="hidden"
                  name="id"
                  value="<?= $comment["comment_id"]?>"
                  style="width: 0px"
                  />
                  <input
                  type="hidden"
                  name="number"
                  value="<?= $comment["page_id"]?>"
                  style="width: 0px"
                  />
                  <button class="btn btn-danger">
                    Yes, I'm sure
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Modal end -->
        
        <?php } ?>
      </div>

              </div>
              <p class="mt-2"><?= nl2br($comment['content']) ?></p>
            </div>
          </div>
        </div>
            
        <?php }; ?>
          <!-- comments section end -->

      </div>
    </div>

<?php require "parts/footer.php"?>
