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

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updatepass'])) {
    $updatePass = $user->updatePass($userId,$_POST);
  }

  ?>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h2>Change Password <span class="pull-right"><a class="btn btn-primary" href="profile.php?id=<?php echo $userId; ?>">Back</a></span> </h2>
      </div>
      <div class="panel-body">
        <div style="max-width:600px; margin:0 auto;">
          <?php

          //To echo User update message
            if (isset($updatePass)){
              echo $updatePass;
            }

              ?>
          <form action="" method="post">
            <div class="form-group">
              <label for="old_pass">Old Password</label>
              <input type="password" id="old_pass" class="form-control" name="old_pass">
            </div>
            <div class="form-group">
              <label for="password">New Password</label>
              <input type="password" id="password" class="form-control" name="password">
            </div>

                <button type="submit" class="btn btn-success" name="updatepass">Update Password</button>

          </form>


        </div>
      </div>
    </div>




<?php include 'inc/footer.php'; ?>













<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</body>
</html>
