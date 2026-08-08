<<<<<<< HEAD
<?php
session_start();
include("includes/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    die("Property not found.");
}

$user_id = $_SESSION['user_id'];
$property_id = (int)$_GET['id'];

// Check if already interested
$check = $conn->prepare("SELECT * FROM interested_users WHERE user_id=? AND property_id=?");
$check->bind_param("ii", $user_id, $property_id);
$check->execute();

$result = $check->get_result();

if ($result->num_rows == 0) {

    $stmt = $conn->prepare("INSERT INTO interested_users(user_id,property_id) VALUES(?,?)");
    $stmt->bind_param("ii",$user_id,$property_id);
    $stmt->execute();

}

header("Location: shortlist.php");
exit();
=======
<?php
session_start();
include("includes/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    die("Property not found.");
}

$user_id = $_SESSION['user_id'];
$property_id = (int)$_GET['id'];

// Check if already interested
$check = $conn->prepare("SELECT * FROM interested_users WHERE user_id=? AND property_id=?");
$check->bind_param("ii", $user_id, $property_id);
$check->execute();

$result = $check->get_result();

if ($result->num_rows == 0) {

    $stmt = $conn->prepare("INSERT INTO interested_users(user_id,property_id) VALUES(?,?)");
    $stmt->bind_param("ii",$user_id,$property_id);
    $stmt->execute();

}

header("Location: shortlist.php");
exit();
>>>>>>> 6362c7bd55884c2bc407f28a8ac658e060923f3f
?>