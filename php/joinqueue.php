<?php
include('database.php');
$getqueue = "SELECT * FROM queue WHERE user_id='".$_SESSION['userid']."'";
$finduser = $connection->query($getqueue);

$joinqueue = "INSERT INTO queue (user_id) VALUES ('".$_SESSION['userid']."')";

$removefromroom = "DELETE FROM room WHERE callerid='".$_SESSION['userid']."' OR receiverid='".$_SESSION['userid']."'";
$removeresult = $connection->query($removefromroom);

if($finduser->num_rows==0) {
    $joinqueueresult = $connection->query($joinqueue);
}

if($connection->affected_rows > 0) {
    echo "success";
} else {
    echo "[PHP/MYSQL] Error joining chat queue.";
}
//
//INSER DUMMY DATA -----
// for ($i = 100; $i < 200; $i++) {

//     $connection->query("INSERT INTO queue (user_id) VALUES ('".$i."')");
// }


$connection->close();
?>
