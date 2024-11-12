<?php
include 'conn.php';

if(isset($_POST['save']))

{

$request_number=$_POST['number_request_usestaues'];
// $status_owner=$_POST['status_owner_txt'];
$status_owner=$_POST['status_owner'];
$statue=$_POST['statue'];

$note =$_POST['note'];

$sql_status = "insert into request_status (request_status,note_status,status_owner,no_request) values ('$statue','$note','$status_owner','$request_number')";
$sql_status_query = $conn->query($sql_status);

if($sql_status_query) {
    echo '<script> alert("تم تحديث الطلب"); </script>';
    echo "<script> window.location.href='main.php'</script>";
}


}

?>
