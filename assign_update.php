<?php
include 'conn.php';

if(isset($_POST['save_to']))

{

$noRequest=$_POST['noRequest'];
$request_assign=$_POST['request_assign_txt'];
// $assign_owner=$_POST['assign_owner_txt'];


$sql_assign = "insert into request_assign (request_assign,assign_owner,no_request) values ('$request_assign',NULL,'$noRequest')";

$sql_assign_query = $conn->query($sql_assign);


if($sql_assign_query) {
    echo '<script> alert("تم تحديث الطلب"); </script>';
    echo "<script> window.location.href='main.php'</script>";
}
}

?>
