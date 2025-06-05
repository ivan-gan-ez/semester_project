<?php

if ( isUser() ){
  header("Location: /");
  exit;
};

?>

<?php require "parts/header.php"?>

    <div class="hero">
      <div class="mask p-5">
        <h1 class="text-center fw-normal text-light pb-3">Log in</h1>
        <div class="card p-4">

          <?php require "parts/message_error.php"?>
          <?php require "parts/message_success.php"?>

          <form method="POST" action="/auth/login">
            <div class="mb-3">
              <label for="email" class="form-label">Email address</label>
              <input
                type="email"
                class="form-control"
                id="email"
                name="email"
              />
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input
                type="password"
                class="form-control"
                id="password"
                name="password"
              />
            </div>
          
            <div class="d-grid mt-4">
              <button type="submit" class="btn btn-success btn-fu">
                Log in
              </button>
            </div>
            <div class="pt-4 text-center">
              <a class="link-success text-decoration-none" href="/signup"
                >Don't have an account? Sign up instead.</a
              >
            </div>
          </form>
        </div>
      </div>
    </div>

<?php require "parts/footer.php"?>
