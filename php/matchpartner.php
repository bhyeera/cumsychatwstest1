<?php
include ('database.php');

// $attempts = 0;
$callerid = null;
$receiverid = null;
$getpairquery = "SELECT * FROM queue ORDER BY RAND() LIMIT 2";

$matchresult = $connection->query($getpairquery);

do {
    $getpairresult = $connection->query($getpairquery);
    /*if($attempts>100) {
        break;
    }*/
} while ($getpairresult->num_rows < 2);

$leavequeuequery = "DELETE FROM queue WHERE user_id=";

while($row = $getpairresult->fetch_assoc()) {
    if($callerid == "") {
        $callerid = $row['user_id'];
        // echo $callerid;
        $connection->query($leavequeuequery."'".$row["user_id"]."'");
    } else {
        $receiverid = $row['user_id'];
        // echo $receiverid;
        $connection->query($leavequeuequery."'".$row["user_id"]."'");
    }
    // echo "<br>";
}

$insertroomquery = "INSERT INTO room (callerid,receiverid) VALUES ('".$callerid."','".$receiverid."')";
$matchresult = $connection->query($insertroomquery);

if($connection->affected_rows > 0) {
    echo "success matching partner";
} else {
    echo null;
}



$connection->close();
?>
