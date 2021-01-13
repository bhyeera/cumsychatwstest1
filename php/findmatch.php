<?php
include('database.php');

$matchedcaller;
$matchedreceiver;
$type = NULL;
$partner = NULL;
$returnEmtpy = null;
$matchdata = null;

$findmatchquery = "SELECT * FROM room WHERE callerid='".$_SESSION['userid']."' OR receiverid='".$_SESSION['userid']."'";
$findmatchresult = $connection->query($findmatchquery);

while($row = $findmatchresult->fetch_assoc()) {
    if($row["callerid"] == $_SESSION['userid']) {
        $partner = $row["receiverid"];
        $type = "caller";
    } else if ($row["receiverid"] == $_SESSION['userid']) {
        $partner = $row["callerid"];
        $type = "receiver";
    }
    $matchedcaller = $row["callerid"];
    $matchedreceiver = $row["receiverid"];
}

if($type == NULL) {
    $type = "ERROR";
}

if($partner == NULL) {
    $partner = "ERROR";
}

if($findmatchresult->num_rows != 0) {
    $matchdata = '{"type":"'.$type.'","partner":"'.$partner.'"}';
    echo $matchdata;
}

$connection->close();
?>
