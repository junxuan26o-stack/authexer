<?php

session_start();

if(isset($_SESSION['authenticated']) && $_SESSION['authenticated'] ==true){
    header('Location:index.php');
    exit;
}

if($_SERVER['REQUEST_METHOD'] ==='POST'){
    $email = $_POST['email'];
    $password =$_POST['password'];

    if(empty($email) || empty($password)){
        echo"All fields are required.";
        exit;
    }

    $db = new PDO("mysql:host=localhost;dbname=login_auth", 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $statement =$db->prepare("SELECT * FROM users WHERE email = :email");
    $statement ->execute([':email'=>$email]);
    $user =$statement->fetch(PDO::FETCH_OBJ);

    if($user && password_verify($password, $user->password)){
        $_SESSION['authenticated']=true;
        $_SESSION['email'] =$user->email;
        header('Location:index.php');
        exit;
    }
    else{
        echo"invalid email or password';
    }
  }

        ?>

    