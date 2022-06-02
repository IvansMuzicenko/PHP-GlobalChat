<?php
if ($_REQUEST['action'] == "changeName") {
    session_start();
    $_SESSION['user'] = $_REQUEST["name"];
    echo 1;
    exit;
}
?>