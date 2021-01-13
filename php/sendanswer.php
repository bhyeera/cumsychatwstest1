<?php
include('database.php');

$sendanswerquery = "UPDATE room SET answer='".$_POST['answer']."' WHERE receiverid='".$_SESSION['userid']."'";
// $sendofferresult = $connection->query($sendofferquery);

do {
    $sendanswerresult = $connection->query($sendanswerquery);
    /*if($attempts>100) {
        break;
    }*/
} while ($connection->affected_rows == 0);

echo "sucess: this ".$_POST['answer']." inserted into".$_SESSION['userid'];
$connection->close();
?>
