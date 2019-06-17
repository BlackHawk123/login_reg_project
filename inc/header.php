<?php
  $filepath = realpath(dirname(__FILE__));
  include_once $filepath.'/../lib/Session.php';
  Session::init();


 ?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login Register</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

</head>
<body>

  <?php
    //logout mechanism

    if (isset($_GET['action']) && $_GET['action'] == 'logout') {
      Session::destroy();
    }

   ?>


  <div class="container">
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="index.php">Login Register PHP & PDO</a>
        </div>
        <ul class="nav navbar-nav pull-right">

          <?php
            $id = Session::get('id');
            $userlogin = Session::get('login');
            if ($userlogin == true) {
              ?>
              <li ><a href="profile.php?id=<?php echo $id;?>">Profile</a></li>
              <li><a href="?action=logout">Logout</a></li>
            <?php
            }else{
              ?>
          <li><a href="login.php">Login</a></li>
          <li><a href="register.php">Register</a></li>
          <?php } ?>
        </ul>
      </div>
    </nav>
