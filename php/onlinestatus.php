<?php
include('database.php');
$data = array();

function updateStatus($connection)
{
    $getonlineusersquery = "SELECT * FROM onlineusers WHERE userid='".$_SESSION['userid']."'";
    $updatequery = "UPDATE onlineusers SET lastonline=CURRENT_TIMESTAMP WHERE userid='".$_SESSION['userid']."'";
    $insertonlinequery = "INSERT INTO onlineusers (userid) VALUES ('".$_SESSION['userid']."')";
    // SEARCH USER IN ONLINEUSERS TABLE
    $currentusersresult = $connection->query($getonlineusersquery);
    if ($currentusersresult->num_rows > 0) {
        // IF USER IS FOUND, UPDATE CURRENT TIME STAMP
        $connection->query($updatequery);
    } else {
        // IF USER IS NOT FOUND, INSERT USER INTO DATABASE
        $connection->query($insertonlinequery);
    }

}

function deleteUsers($connection)
{
    // GET ALL USERS FROM DATABASE
    $getonlineusersquery = "SELECT * FROM onlineusers";
    $deleteofflineusers = "DELETE FROM onlineusers WHERE id=";
    $deletefromqueue = "DELETE FROM queue WHERE user_id=";
    $getonlineusers = $connection->query($getonlineusersquery);
    if ($getonlineusers->num_rows > 0) {
      // output data of each row
      while($row = $getonlineusers->fetch_assoc()) {
        // echo "<br>";
        // echo "<br>";
        // echo "id: " . $row["id"]. " " . $row["lastonline"]. "<br>";
        // echo strtotime($row["lastonline"]);
       // print_r($row);
        if( ((strtotime(date("Y-m-d h:i:sa"))-(60*60))-strtotime($row["lastonline"]))>30 ) {
            $connection->query($deleteofflineusers."'".$row["id"]."'");
            $connection->query($deletefromqueue."'".$row["userid"]."'");
        }
      }
    }
}

function getUsersOnline($connection)
{
    $getonlineuserstotalquery = "SELECT * FROM onlineusers";
    $getonlineuserstotal = $connection->query($getonlineuserstotalquery);
    echo $getonlineuserstotal->num_rows;
}
// UPDATE LAST ONLINE STATUS
// $sql = "SELECT id,lastonline FROM onlineusers";
// $sql = "UPDATE onlineusers SET lastonline=CURRENT_TIMESTAMP WHERE userid='".$_SESSION['userid']."'";
// $updatesql = "UPDATE onlineusers SET lastonline=CURRENT_TIMESTAMP WHERE userid='".$_SESSION['userid']."'";
// echo $_SESSION['userid'];
// $result = $conn->query($sql);
// $conn->query($sql);

// if ($result->num_rows > 0) {
//   // output data of each row
//   while($row = $result->fetch_assoc()) {
//     // echo "id: " . $row["id"]. " " . $row["lastonline"]. "<br>";
//     if( (strtotime(date("Y-m-d h:i:sa"))-(60*60)-strtotime($row["lastonline"]))>60 ) {

//     }
//   }
// } else {
//   echo "0";
// }


updateStatus($connection);
deleteUsers($connection);
getUsersOnline($connection);

$connection->close();
// UPDATE `onlineusers` SET `lastonline`=CURRENT_TIMESTAMP WHERE userid=1;
?>
