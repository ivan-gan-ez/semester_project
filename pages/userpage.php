<?php

$id = $_GET["id"];

$database = connectToDB();

    $sql = "SELECT * FROM users WHERE user_id = :id";

    $query = $database->prepare($sql);

    $query->execute(["id" => $id]);

    $user = $query->fetch();

$vid = $user["user_id"];
$vname = $user["name"];
$vfav_num = $user["fav_num"];
$vpfp = $user["profile_picture"];
$vdesc = $user["desc"];
$vrole = $user["role"];

//get comments
$sql = "SELECT userpage_comments.*, users.* FROM userpage_comments INNER JOIN users ON userpage_comments.commenter_id	 = users.user_id WHERE userpage_id = :page_id ORDER BY up_comment_id DESC";

$query = $database->prepare($sql);

$query->execute(["page_id" => $vid]);

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
          <div class="row">
            <div class="col-4 col-md-3 col-lg-2">
              <img src="<?= $vpfp?>" class="img-fluid rounded-circle pfp"/>
            </div>
            <div class="col-8 col-md-9 col-lg-10">

              <div class="d-flex justify-content-between">
                <h1 class="fw-bold"><?= $vname?></h1>

                <?php if( isAdmin() || $sessionid === $vid ) {?>
                <form method="GET" action="/user/edit">
                  <input type="hidden" name="id" value="<?=$vid ?>"></input>
                  <button class="btn btn-success px-3 submit">
                    <i class="bi bi-pencil"></i> Edit
                  </button>
                </form>
                <?php }; ?>

              </div>

              <p><?= $vrole?></p>
              <p>Favourite number(s): <?= $vfav_num != NULL ? $vfav_num : "[unspecified]";?></p>
            </div>
          </div>
          <p class="mt-3"><?= $vdesc?></p>
        </div>

        <!-- comments section start -->
            <h1 class="text-light my-4">Comments</h1>
    
            <a href="/user/comment/add?id=<?= $vid?>" class="btn btn-success w-100 mb-2">Add New Comment</a>
    
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
    
                    <?php if( isAdmin() || $comment['commenter_id'] === $sessionid ) {?>
                    <form method="GET" action="/user/comment/edit">
                      <input type="hidden" name="id" value="<?=$comment['up_comment_id'] ?>"></input>
                      <button class="btn btn-success px-3 submit">
                        <i class="bi bi-pencil"></i> Edit
                      </button>
                    </form>
                    
                    <!-- Button trigger modal -->
                    <button
                    type="button"
                    class="btn btn-danger btn-sm h-100"
                    data-bs-toggle="modal"
                    data-bs-target="#commentDeleteModal-<?= $comment["up_comment_id"]?>"
                    >
                    <i class="bi bi-trash"></i>
                  </button>
                  
                  <!-- Modal -->
                  <div
                  class="modal fade"
                  id="commentDeleteModal-<?= $comment["up_comment_id"]?>"
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
                      action="/auth/user/comment/delete"
                      style="display: inline"
                      >
                      <input
                      type="hidden"
                      name="id"
                      value="<?= $comment["up_comment_id"]?>"
                      style="width: 0px"
                      />
                      <input
                      type="hidden"
                      name="userpage"
                      value="<?= $comment["userpage_id"]?>"
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
