<?php
session_start();
include 'autoloadClass.php';

$book = new book;
$bookid = $_GET["bookid"];
$page = $_GET['page'];
$book->bookid = $bookid;
if (isset($_SESSION['email'])) {
    # code...
    $book->delete();

//     if ($book->delete()) {
//         echo '<script>alert("record deleted");</script>';
//     }
// } else {
//     echo '<script>alert("you are not loggedin");</script>';
}
// header("Refresh:0; url=viewall.php?page=" . $page);
