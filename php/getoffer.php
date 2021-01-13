<?php
include('database.php');

$offer = null;
$getoffer = "SELECT * FROM room WHERE receiverid='".$_SESSION['userid']."'";

$getofferresult = $connection->query($getoffer);

while($row = $getofferresult->fetch_assoc()) {
   $offer = $row["offer"];
}
    /*if($attempts>100) {
        break;
    }*/
    echo $offer;

$connection->close();
?>
