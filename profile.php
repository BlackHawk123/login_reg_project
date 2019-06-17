<?php
  include 'lib/User.php';
  include 'inc/header.php';
  Session::checkSession();
 ?>
 <?php
  if (isset($_GET['id'])) {
    $userId = (int)$_GET['id'];
  }

  $user = new User();

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $updateUser = $user->updateUser($userId,$_POST);
  }

  ?>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h2>User Profile <span class="pull-right"><a class="btn btn-primary" href="index.php">Back</a></span> </h2>
      </div>
      <div class="panel-body">
        <div style="max-width:600px; margin:0 auto;">
          <?php

          //To echo User update message
            if (isset($updateUser)){
              echo $updateUser;
            }
              ?>
          <?php
          //To show data into update form by id
            $userdata = $user->getUserById($userId);
            if ($userdata) {
           ?>
          <form action="" method="post">
            <div class="form-group">
              <label for="name">Full Name</label>
              <input type="text" id="name" class="form-control" name="name" value="<?php echo $userdata->name; ?>">
            </div>
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" id="username" class="form-control" name="username" value="<?php echo $userdata->username; ?>">
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" id="email" class="form-control" name="email" value="<?php echo $userdata->email; ?>" disabled>
            </div>

            <?php
              $sessionId = Session::get("id");
              if ($userId == $sessionId) {
                ?>
                <button type="submit" class="btn btn-success" name="update">Update</button>
                <a class="btn btn-info" href="changepass.php?id=<?php echo $userId; ?>">Change Password</a>
                <?php } ?>
          </form>
          <?php } ?>

        </div>
      </div>
    </div>




<?php include 'inc/footer.php'; ?>













<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</body>
</html>
