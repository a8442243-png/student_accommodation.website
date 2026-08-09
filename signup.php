<?php
include("includes/db.php");

$message = "";

if(isset($_POST['signup']))
{
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if($result->num_rows > 0)
    {
        $message = "<div class='alert alert-danger'>Email already registered!</div>";
    }
    else
    {
        $stmt = $conn->prepare("INSERT INTO users(name,email,password,phone) VALUES(?,?,?,?)");
        $stmt->bind_param("ssss",$name,$email,$password,$phone);

        if($stmt->execute())
        {
            header("Location: login.php?success=1");
            exit();
        }
        else
        {
            $message = "<div class='alert alert-danger'>Something went wrong.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Signup</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="css/style.css">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-5">

<div class="card shadow">

<div class="card-header bg-primary text-white text-center">
<h3>Create Account</h3>
</div>

<div class="card-body">

<?php echo $message; ?>

<form method="POST">

<div class="mb-3">
<label>Name</label>
<input type="text" name="name" class="form-control" required>
</div>

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control" required>
</div>

<div class="mb-3">
<label>Phone</label>
<input type="text" name="phone" class="form-control" required>
</div>

<div class="mb-3">
<label>Password</label>
<input type="password" name="password" class="form-control" required>
</div>

<button type="submit" name="signup" class="btn btn-primary w-100">
Create Account
</button>

</form>

<div class="text-center mt-3">
Already have an account?
<a href="login.php">Login</a>
</div>

</div>

</div>

</div>

</div>

</div>

</body>
</html>