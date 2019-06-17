<?php
    include_once "Session.php";
    include "Database.php";


    class User{
        private $db;

        public function __construct(){
            $this->db = new Database();
        }

        public function userRegistration($data){
          $name = $data['name'];
          $username = $data['username'];
          $email = $data['email'];
          $password = $data['password'];

          $chk_email = $this->emailCheck($email);

          if ($name == "" OR $username =="" OR $email =="" OR $password =="") {
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> Field must not be empty.</div>";
            return $msg;
          }
          if (strlen($username) < 3) {
            $msg = "<div class='alert alert-danger'><strong>Note!</strong> Username is too short.</div>";
            return $msg;
          }elseif (preg_match('/[^a-z0-9_-]+/i',$username)) {
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> Username must only contain Alphanumerical, dashes and underscores.</div>";
            return $msg;
          }

          // Email validation
          if (filter_var($email,FILTER_VALIDATE_EMAIL) == false) {
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> Email address is not valid.</div>";
            return $msg;
          }

          if ($chk_email == true) {
            $msg = "<div class='alert alert-danger'><strong>Alert!</strong> The Email address already exist.</div>";
            return $msg;
          }

          $password = md5($data['password']);
          $sql = "INSERT INTO user_info (name,username,email,pass) VALUES(:name, :username, :email, :pass) ";
          $query = $this->db->pdo->prepare($sql);
          $query->bindParam(':name',$name);
          $query->bindParam(':username',$username);
          $query->bindParam(':email',$email);
          $query->bindParam(':pass',$password);
          $result = $query->execute();

          if ($result) {
            $msg = "<div class='alert alert-success'><strong>Congrats!</strong> You have been registered.</div>";
            return $msg;
          }else {
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> Registration failed.</div>";
            return $msg;
          }

        }




        public function emailCheck($email){
          $sql = "SELECT email FROM user_info WHERE email = :email ";
          $query = $this->db->pdo->prepare($sql);
          $query->bindParam(':email',$email);
          $query->execute();

          if ($query->rowCount() > 0) {
            return true;
          }else {
            return false;
          }
        }


        public function getLoginUser($email,$password){
          $sql = "SELECT * FROM user_info WHERE email = :email AND pass = :pass LIMIT 1 ";
          $query = $this->db->pdo->prepare($sql);
          $query->bindParam(':email',$email);
          $query->bindParam(':pass',$password);
          $query->execute();
          $result = $query->fetch(PDO::FETCH_OBJ);
          return $result;
        }


        public function userLogin($data){
          $email = $data['email'];
          $password = md5($data['pass']);
          $chk_email = $this->emailCheck($email);

          if ($email =="" OR $password =="") {
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> Field must not be empty.</div>";
            return $msg;
          }
          if (filter_var($email,FILTER_VALIDATE_EMAIL) == false) {
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> Email address is not valid.</div>";
            return $msg;
          }

          if ($chk_email == false) {
            $msg = "<div class='alert alert-danger'><strong>Alert!</strong> The Email address is not matched.</div>";
            return $msg;
          }

          $result = $this->getLoginUser($email,$password);
          if ($result) {
            Session::init();
            Session::set('login',true);
            Session::set('id',$result->id);
            Session::set('name',$result->name);
            Session::set('username',$result->username);
            Session::set('loginmsg',"<div class='alert alert-success'><strong>Success!</strong> You are logged in.</div>");
            header("Location:index.php");
          }else {
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> Data not matched.</div>";
            return $msg;
          }
        }

        public function getUserData(){
          $sql = "SELECT * FROM user_info ORDER BY id DESC ";
          $query = $this->db->pdo->prepare($sql);
          $query->execute();
          return $query->fetchAll();
        }


        public function getUserById($userId){
          $sql = "SELECT * FROM user_info WHERE id = :id LIMIT 1 ";
          $query = $this->db->pdo->prepare($sql);
          $query->bindValue(':id',$userId);
          $query->execute();
          $result = $query->fetch(PDO::FETCH_OBJ);
          return $result;
        }


        public function updateUser($id,$data){
          $name = $data['name'];
          $username = $data['username'];
          $email = $data['email'];


          if ($name == "" OR $username =="" OR $email =="") {
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> Field must not be empty.</div>";
            return $msg;
          }
          if (strlen($username) < 3) {
            $msg = "<div class='alert alert-danger'><strong>Note!</strong> Username is too short.</div>";
            return $msg;
          }elseif (preg_match('/[^a-z0-9_-]+/i',$username)) {
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> Username must only contain Alphanumerical, dashes and underscores.</div>";
            return $msg;
          }

          // Email validation
          if (filter_var($email,FILTER_VALIDATE_EMAIL) == false) {
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> Email address is not valid.</div>";
            return $msg;
          }


          $sql = "UPDATE user_info SET name = :name, username = :username, email = :email WHERE id = :id ";

          $query = $this->db->pdo->prepare($sql);

          $query->bindValue(':name',$name);
          $query->bindValue(':username',$username);
          $query->bindValue(':email',$email);
          $query->bindValue(':id',$id);
          $result = $query->execute();

          if ($result) {
            $msg = "<div class='alert alert-success'><strong>Congrats!</strong> Data updated successfully.</div>";
            return $msg;
          }else {
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> Failed to update.</div>";
            return $msg;
          }
        }

        private function checkPassword($id,$old_pass){
          $password = md5($old_pass);

          $sql = "SELECT pass FROM user_info WHERE id = :id AND pass = :pass";
          $query = $this->db->pdo->prepare($sql);
          $query->bindParam(':id',$id);
          $query->bindParam(':pass',$password);
          $query->execute();

          if ($query->rowCount() > 0) {
            return true;
          }else {
            return false;
          }

        }

        public function updatePass($id,$data){
          $old_pass = $data['old_pass'];
          $new_pass = $data['password'];
          $chk_pass = $this->checkPassword($id,$old_pass);

          if ($old_pass == "" OR $new_pass == "") {
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> Field must not be empty.</div>";
            return $msg;
          }
          if ($chk_pass == false) {
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> Old Password not found.</div>";
            return $msg;
          }

          if (strlen($new_pass) < 6) {
            $msg = "<div class='alert alert-danger'><strong>Warning!</strong> Password must be more than 6 characters.</div>";
            return $msg;
          }

          $password = md5($new_pass);
          $sql = "UPDATE user_info SET pass = :pass WHERE id = :id ";

          $query = $this->db->pdo->prepare($sql);

          $query->bindValue(':pass',$password);
          $query->bindValue(':id',$id);
          $result = $query->execute();

          if ($result) {
            $msg = "<div class='alert alert-success'><strong>Congrats!</strong> Password updated successfully.</div>";
            return $msg;
          }else {
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> Failed to update.</div>";
            return $msg;
          }

        }


        }








?>
