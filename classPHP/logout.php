<?php
include 'autoloadClass.php';
user::logout();
Customer::logout();
header("refresh:0; url=index.php");
?>