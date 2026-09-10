<?php

session_start();

if($_SERVER['REQUEST_METHOD']==='POST'){

    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if(empty($email) || empty($password) ||empty($confirmPassword)){
        echo "All fields are required";
        exit;
    }

    if($password !==$confirmPassword){
        echo"Passsword do not match";
        exit;
    }

$db = new PDO("mysql:host=localhost;dbname=login_auth", 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$check = $db->prepare("SELECT * FROM users WHERE email = :email");
$check ->execute([':email'=>$email]);

if($check->fetch()){
    echo"The email is already registered";
    exit;
}

$hashedPassword =password_hash($password,PASSWORD_DEFAULT);

$statement = $db->prepare("INSERT INTO users(email,password) VALUES(:email,:password)");
$statement->execute([
    ':email =>$email',
    ':password'=>$hashedPassword,
]);

echo "Successfully registered";

}
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
</head>
<body>

    <h2>Sign Up A New Account</h2>

    <form method="POST" action="">
        <label>Name</label>
        <input type="email" name="email" required><br><br>

        <label>Email Addres</label>
        <input type="email" name="email" required><br><br>

        <label>Password</label>
        <input type="password" name="password" required><br><br>

        <label>Confirm Password</label>
        <input type="password" name="confirm_password" required><br><br>

        <button type="submit">Sign Up</button>
    </form>

</body>
</html>

<!DOCTYPE html>