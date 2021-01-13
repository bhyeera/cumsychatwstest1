<?php
$diff = strtotime(date("Y-m-d h:i:sa")) - strtotime('2020-12-31 5:02:03pm');
echo "<br>";
echo strtotime('2020-12-31 16:46:00');
echo "<br>";
echo strtotime('2020-12-31 4:17:29pm');
echo "<br>";
echo '2020-12-31 5:02:03pm';
echo "<br>";
echo date("Y-m-d h:i:sa");
echo "<br>";
echo strtotime(date("Y-m-d h:i:sa"))-(60*60);
echo "<br>";
echo strtotime(date("Y-m-d h:i:sa"));
echo "<br>";
if($diff>30) {
    echo "client is offline";
}
return true;
?>
