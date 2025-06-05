<?php

$id = $_GET["id"];

if ( !isAdmin() && $_SESSION["user"]["user_id"] != $id ){
  header("Location: /");
  exit;
};

$database = connectToDB();

?>

<?php require "parts/header.php"?>

    <div class="hero">
      <div class="mask p-5">
        <h1 class="text-center fw-normal text-light pb-3">Change Password</h1>

        <div class="container mx-auto my-5" style="max-width: 700px">
          <div class="card mb-2 p-4">
            <form method="POST" action="/auth/user/changepwd">

              <?php require "parts/message_error.php"?>
              
              <div class="mb-3">
                <div class="row">
                  <div class="col">
                    <label for="password" class="form-label">Password</label>
                    <input
                      type="password"
                      class="form-control"
                      id="password"
                      name="password"
                    />
                  </div>
                  <div class="col">
                    <label for="confirm-password" class="form-label"
                      >Confirm Password</label
                    >
                    <input type="hidden" name="id" value="<?= $_GET["id"]; ?>">
                    <input
                      type="password"
                      class="form-control"
                      id="confirm-password"
                      name="confirm_password"
                    />
                  </div>
                </div>
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-success">
                  Change Password
                </button>
              </div>
            </form>

            <div class="pt-4 text-center">
              <a class="link-success text-decoration-none" href="/user/edit?id=<?=$id?>">Go back</a>
            </div>
          </div>
        </div>
      </div>
    </div>

<?php require "parts/footer.php"?>
