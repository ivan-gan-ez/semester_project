<?php

if ( !isAdmin() ){
  header("Location: /");
  exit;
};

$database = connectToDB();

    $sql = "SELECT * FROM users";

    $query = $database->prepare($sql);

    $query->execute();

    $users = $query->fetchAll();

?>

<?php require "parts/header.php"?>

    <div class="hero">
      <div class="mask p-5">
        <h1 class="text-center fw-normal text-light pb-3">All users</h1>

        <div class="card mb-2 p-4">
          <?php require "parts/message_success.php"?>

          <table class="table">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col" class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>

            <?php foreach ($users as $i => $user) :?>

                <tr>
                <th scope="row"><?= $user["user_id"]?></th>
                <td class="text-break"><?= $user["name"];?></td>
                <td><?= $user["email"];?></td>
                <td>
                  <?php if ($user['role'] === 'owner'){
                    echo "<span class='badge bg-primary'>Owner</span>";
                  } else if ($user['role'] === 'admin'){
                    echo "<span class='badge bg-info'>Admin</span>";
                  } else {
                    echo "<span class='badge bg-success'>User</span>";
                  }?>
                </td>

                <td class="text-end">
                  <div class="buttons" style="min-width: 170px">
                    <a href="/userpage?id=<?= $user["user_id"];?>" class="btn btn-primary btn-sm me-2"
                      ><i class="bi bi-eye"></i
                    ></a>

                    <?php if (isOwner() || !isOwner() && isAdmin() && $user['role'] !== "owner") {?>
                    <a href="/user/edit?id=<?= $user["user_id"];?>" class="btn btn-success btn-sm me-2"
                      ><i class="bi bi-pencil"></i
                    ></a>

                    <a href="/user/changepwd?id=<?php echo $user["user_id"];?>" class="btn btn-warning btn-sm me-2"
                      ><i class="bi bi-key"></i
                    ></a>

                    <?php if (isOwner() && $user['user_id'] !== $_SESSION['user']['user_id'] || !isOwner() && isAdmin() && $user['role'] === "user" ) {?>
                    <!-- Button trigger modal -->
                    <button
                      type="button"
                      class="btn btn-danger btn-sm" data-bs-toggle="modal"
                      data-bs-target="#userDeleteModal-<?= $user["user_id"]?>"
                    >
                      <i class="bi bi-trash"></i>
                    </button>

                    <!-- Modal -->
                    <div
                      class="modal fade"
                      id="userDeleteModal-<?= $user["user_id"]?>"
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
                              action="/auth/user/delete"
                              style="display: inline"
                            >
                              <input
                                type="hidden"
                                name="user_id"
                                value="<?= $user["user_id"]?>"
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
                    <?php }?>
                    <?php }?>
                  </div>
                </td>
              </tr>

            <?php endforeach ?>


            </tbody>
          </table>
        </div>

      </div>
    </div>

<?php require "parts/footer.php"?>
