<?php
include('database.php');

$offerObj = new stdClass();
$offerObj = json_decode($_POST['offer']);
$offer = json_encode($offerObj);
$sendofferquery = "UPDATE room SET offer='".$offer."' WHERE callerid='".$_SESSION['userid']."'";
// $sendofferresult = $connection->query($sendofferquery);

do {
    $sendofferresult = $connection->query($sendofferquery);
    /*if($attempts>100) {
        break;
    }*/
} while ($connection->affected_rows == 0);

echo "sucess: this ".$offer." inserted into ".$_SESSION['userid'];
$connection->close();
?>
