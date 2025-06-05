<?php

if ( !isUser() ){
  header("Location: /");
  exit;
};

$search = $_GET["number"];

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

?>

<?php require "parts/header.php"?>

    <div class="hero">
      <div class="mask p-5">
        <h1 class="text-center fw-normal text-light pb-3">Editing <?=$search?></h1>
        <div class="card p-4">
          <form method="POST" action="/auth/page/edit">

            <!-- basic info -->
            <div class="mb-3">
              <label class="form-label">Prime factorisation</label>
              <input type="text" class="form-control" id="primefactorisation" name="primefactorisation" value="<?php echo ( $number != NULL ? $number["prime_factorisation"] : "" ); ?>"/>
            </div>

            <div class="mb-3">
              <label class="form-label">Factors</label>
              <input type="text" class="form-control" id="factors" name="factors" value="<?php echo ( $number != NULL ? $number["factors"] : "" ); ?>"/>

            <div class="d-grid my-4">
              <input type="hidden" id="number" name="number" value="<?=$search?>"/>
              <button type="submit" class="btn btn-success btn-fu">Done</button>
            </div>
          </form>

          <!-- trivia and facts or whatever you call them. this would've looked nicer but html5 hates nested forms 💔 -->
            <label class="form-label">Facts</label>
            <div class="card rounded shadow-sm mx-auto mb-4">
              <div class="card-body">

                <?php require "parts/message_success.php"?>
                
                <a href="/fact/add?number=<?= $search?>" class="btn btn-primary w-100 mb-2">Add New Fact</a>

                <?php foreach ($facts as $i => $fact) {?>

                  <div class="row d-flex justify-content-between align-items-center my-3">  
                      <div class="col-8">
                        <h5><?= $fact['fact']?></h5>
                      </div>
                      <div class="d-flex gap-2 align-top col-4 justify-content-end align-items-center">
                        <img src="<?= $fact['image']?>" height="45rem" />
                        <a href="/fact/edit?fact=<?= $fact['fact_id']?>" class="btn btn-success btn-sm">Update</a>

                        <!-- Button trigger modal -->
                          <button
                            type="button"
                            class="btn btn-danger btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#factDeleteModal-<?= $fact["fact_id"]?>"
                          >
                            <i class="bi bi-trash"></i>
                          </button>

                          <!-- Modal -->
                          <div
                            class="modal fade"
                            id="factDeleteModal-<?= $fact["fact_id"]?>"
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
                                    action="/auth/fact/delete"
                                    style="display: inline"
                                  >
                                    <input
                                      type="hidden"
                                      name="fact_id"
                                      value="<?= $fact["fact_id"]?>"
                                      style="width: 0px"
                                    />
                                    <input
                                      type="hidden"
                                      name="number"
                                      value="<?= $fact["number"]?>"
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

                      </div>
                  </div>

                <?php };?>
                
              </div>
            </div>


          <!-- go back -->
          <div class="pt-4 text-center">
            <a class="link-success text-decoration-none" href="/page?number=<?= $search?>">Go back</a>
          </div>

        </div>
      </div>
    </div>

<?php require "parts/footer.php"?>
