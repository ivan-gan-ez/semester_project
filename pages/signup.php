<?php require "parts/header.php"?>

    <div class="hero">
      <div class="mask p-5">
        <h1 class="text-center fw-normal text-light pb-3">Sign Up</h1>
        <div class="card p-4">

        <?php require "parts/message_error.php"?>

          <form method="POST" action="/auth/signup">
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" name="name" />
            </div>
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
            <div class="mb-3">
              <label for="confirm_password" class="form-label"
                >Confirm Password</label
              >
              <input
                type="password"
                class="form-control"
                id="confirm_password"
                name="confirm_password"
              />
            </div>
            <div class="d-grid mt-4">
              <button type="submit" class="btn btn-success btn-fu">
                Sign Up
              </button>
            </div>
            <div class="pt-4 text-center">
              <a class="link-success text-decoration-none" href="/login"
                >Already have an account? Log in instead.</a
              >
            </div>
          </form>
        </div>
      </div>
    </div>

<?php require "parts/footer.php"?>
