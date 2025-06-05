<?php

$id = $_GET["id"];

if ( !isAdmin() && $_SESSION["user"]["user_id"] != $id ){
  header("Location: /");
  exit;
};

$database = connectToDB();

$sql = "SELECT * FROM users WHERE user_id = :id";

$query = $database->prepare($sql);

$query->execute(["id" => $id]);

$euser = $query->fetch();

if ( !$euser ){
  header("Location: /user/manage");
  exit;
};

$ename = $euser["name"];
$efav_num = $euser["fav_num"];
$epfp = $euser["profile_picture"];
$edesc = $euser["desc"];
$erole = $euser["role"];
?>

<?php require "parts/header.php"?>

    <div class="hero">
      <div class="mask p-5">
        <h1 class="text-center fw-normal text-light pb-3">Editing <?= $ename ?></h1>
        <div class="card p-4">
          <?php require "parts/message_error.php"?>
          <?php require "parts/message_success.php"?>

          <form method="POST" action="/auth/user/edit" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="text" class="form-label">Name</label>
              <div class="d-flex">
                <input type="text" class="form-control me-3" id="name" name="name" value="<?= $ename ?>"/>
                <a href="/user/changepwd?id=<?= $id?>" class="btn btn-warning btn-sm m-1">
                  <i class="bi bi-key"></i>
                </a>
              </div>
            </div>
            <div class="mb-3">
              <label for="text" class="form-label">Favourite number(s)</label>
              <input
                type="text"
                class="form-control"
                id="favnumber"
                name="favnumber"
                value="<?= $efav_num ?>"
              />
            </div>

            <label class="form-label">Image</label>
            <div class="mb-4">
              <img src="<?= $epfp?>" class="img-fluid" />
            </div>
            <input class="mb-3" type="file" name="image" accept="image/*" />

            <div class="mb-3">
              <label for="text" class="form-label">Desc</label><br />
              <textarea class="w-100" rows="4" id="desc" name="desc"><?= $edesc?></textarea>
            </div>

            <div class="mb-3">
              
              <?php if ( isOwner() ) {?>
                <?php if ( $erole === "owner" ) {?>
                  <input type="hidden" name="role" value="owner"></input>
                <?php } else {?>
                  <label for="role" class="form-label">Role</label>
                  <select class="form-control" id="role" name="role" <?php echo ( $erole === "owner" ? "disabled" : "" ); ?>>
                  <option value="user" <?php echo ( $erole === "user" ? "selected" : "" ); ?> >User</option>
                  <option value="admin" <?php echo ( $erole === "admin" ? "selected" : "" ); ?> >Admin</option>
                  </select>
                <?php } ?>
              <?php } else {?>
                  <input type="hidden" name="role" value=<?=$erole?> ></input>
              <?php } ?>
            </div>

            <div class="d-grid mt-4">
              <input type="hidden" name="id" value="<?= $id?>">
              <button type="submit" class="btn btn-success btn-fu">Done</button>
            </div>
            <div class="pt-4 text-center">
              <a class="link-success text-decoration-none" href="/user/manage">Go back</a>
            </div>
          </form>
        </div>
      </div>
    </div>

<?php require "parts/footer.php"?>