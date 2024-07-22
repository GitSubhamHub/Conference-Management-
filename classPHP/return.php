<?php
session_start();
include 'autoloadClass.php';
$book = new book;
$order = new orders;
if (isset($_SESSION['customerId'])) {
    if (isset($_GET['bookid'])) {
        $order->customerId = $_SESSION['customerId'];
        $order->orderId = $_GET['orderId'];
        $book->bookid = $_GET['bookid'];
        if ($order->return()) {
            $book->plusquantity();
            
            header("Refresh:0; url=viewissued.php");
        } else {
            echo "error occured";
        }
    } else {
        echo '<script>alert("Invalid Conference");</script>';
        header("Refresh:0; url=viewissued.php");
    }
} else {
    echo '<script>alert("be nice and dont put value directly in url");</script>';
    header("Refresh:0; url=viewavailable.php");
}
