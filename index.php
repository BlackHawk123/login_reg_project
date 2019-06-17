  <?php
   include 'inc/header.php';
   include "lib/User.php";

   Session::checkSession();
    ?>

<?php
  $loginmsg = Session::get('loginmsg');
  if (isset($loginmsg)) {
    echo $loginmsg;
    Session::set('loginmsg',NULL);
  }

 ?>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h2>User List <span class="pull-right">Welcome! <strong>
            <?php
              $name = Session::get('username');
              if (isset($name)) {
                echo $name;
              }


             ?>
            </strong> </span></h2>
        </div>
        <div class="panel-body">
          <table class="table table-striped">
            <tr>
              <th width="20%">No.</th>
              <th width="20%">Name</th>
              <th width="20%">Username</th>
              <th width="20%">Email</th>
              <th width="20%">Action</th>
            </tr>
            <?php
              $user = new User();
              $userData = $user->getUserData();
              if ($userData) {
                $i = 0;
                foreach ($userData as $data){
                  $i++;
             ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $data['name'] ?></td>
              <td><?php echo $data['username'] ?></td>
              <td><?php echo $data['email'] ?></td>
              <td>

                <a class="btn btn-primary" href="profile.php?id=<?php echo $data['id'] ?>">View</a>

              </td>
            </tr>
            <?php
              }
            }else{
              ?>
              <tr>
                <td colspan="5"><h2>No Data Found</h2></td>
              </tr>
              <?php
            }
            ?>
          </table>
        </div>
      </div>




<?php include 'inc/footer.php'; ?>













<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</body>
</html>
