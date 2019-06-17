<?php
 include 'inc/header.php';
 include 'lib/User.php';
 Session::checkLogin();
 ?>

 <?php
  $user = new User();

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $usrLogin = $user->userLogin($_POST);
  }

  ?>


    <div class="panel panel-default">
      <div class="panel-heading">
        <h2>User Login</h2>
      </div>
      <div class="panel-body">
        <div style="max-width:600px; margin:0 auto;">

          <?php
            if (isset($usrLogin)) {
              echo $usrLogin;
            }

           ?>

          <form action="" method="post">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" id="email" class="form-control" name="email">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" id="password" class="form-control" name="pass">
            </div>
            <button type="submit" class="btn btn-primary" name="login">Login</button>
          </form>
        </div>
      </div>
    </div>




<?php include 'inc/footer.php'; ?>













<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</body>
</html>
