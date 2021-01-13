<?php
include('database.php');

$answer = null;
$getanswer = "SELECT * FROM room WHERE callerid='".$_SESSION['userid']."'";

$getanswerresult = $connection->query($getanswer);

while($row = $getanswerresult->fetch_assoc()) {
   $answer = $row["answer"];
}
/*if($attempts>100) {
    break;
}*/
echo $answer;


$connection->close();
?>
