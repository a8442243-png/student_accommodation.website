<?php
session_start();
include("includes/db.php");

$message = "";

if(isset($_GET['success'])){
    $message = "<div class='alert alert-success'>Account created successfully. Please login.</div>";
}

if(isset($_POST['login'])){

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s",$email);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows==1){

        $user = $result->fetch_assoc();

        if(password_verify($password,$user['password'])){

            $_SESSION['user_id']=$user['id'];
            $_SESSION['user_name']=$user['name'];

            header("Location:index.php");
            exit();

        }else{
            $message="<div class='alert alert-danger'>Incorrect password.</div>";
        }

    }else{
        $message="<div class='alert alert-danger'>Email not found.</div>";
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-5">

<div class="card shadow">

<div class="card-header bg-success text-white text-center">
<h3>Login</h3>
</div>

<div class="card-body">

<?php echo $message; ?>

<form method="POST">

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control" required>
</div>

<div class="mb-3">
<label>Password</label>
<input type="password" name="password" class="form-control" required>
</div>

<button class="btn btn-success w-100" name="login">
Login
</button>

</form>

<div class="text-center mt-3">
Don't have an account?
<a href="signup.php">Create One</a>
</div>

</div>

</div>

</div>

</div>

</div>

</body>
</html>