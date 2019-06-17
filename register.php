<?php
 include 'inc/header.php';
 include 'lib/User.php';

 ?>
 <?php
  $user = new User();

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $usrReg = $user->userRegistration($_POST);
  }

  ?>


    <div class="panel panel-default">
      <div class="panel-heading">
        <h2>User Registration</h2>
      </div>
      <div class="panel-body">

        <div style="max-width:600px; margin:0 auto;">
          <?php
            if (isset($usrReg)) {
              echo $usrReg;
            }

           ?>
          <form action="" method="post">
            <div class="form-group">
              <label for="name">Full Name</label>
              <input type="text" id="name" class="form-control" name="name">
            </div>
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" id="username" class="form-control" name="username">
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" id="email" class="form-control" name="email">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" id="password" class="form-control" name="password">
            </div>
            <button type="submit" class="btn btn-primary" name="register">Register</button>
          </form>
        </div>
      </div>
    </div>




<?php include 'inc/footer.php'; ?>













<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</body>
</html>
