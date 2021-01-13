<?php
session_start();
if(isset($_POST['adultconsent']) && $_POST['adultconsent'] == true) {
    $_SESSION['adultconsent'] = $_POST['adultconsent'];
}

if(isset($_SESSION['adultconsent'])) {
    echo $_SESSION['adultconsent'];
}
?>
