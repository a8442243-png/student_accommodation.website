<?php
session_start();
include("includes/db.php");

if(!isset($_SESSION['user_id'])){
    echo "login";
    exit();
}

$user_id = $_SESSION['user_id'];
$property_id = (int)$_POST['property_id'];

$check = $conn->prepare("SELECT * FROM interested_users WHERE user_id=? AND property_id=?");
$check->bind_param("ii",$user_id,$property_id);
$check->execute();

$result = $check->get_result();

if($result->num_rows > 0){

    $delete = $conn->prepare("DELETE FROM interested_users WHERE user_id=? AND property_id=?");
    $delete->bind_param("ii",$user_id,$property_id);
    $delete->execute();

    echo "removed";

}else{

    $insert = $conn->prepare("INSERT INTO interested_users(user_id,property_id) VALUES(?,?)");
    $insert->bind_param("ii",$user_id,$property_id);
    $insert->execute();

    echo "added";

}
?>