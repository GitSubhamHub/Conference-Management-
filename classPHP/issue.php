<?php
session_start();
include 'autoloadClass.php';
$book = new book;
$order = new orders;
// $pagetitle = "Issue Page";
// include 'header.php';
include 'config/core.php';

if (isset($_SESSION['customerId'])) {
    if (isset($_GET['bookid'])) {
        # code...
        $order->customerId = $_SESSION['customerId'];
        $order->bookid = $_GET['bookid'];
        $book->bookid = $_GET['bookid'];
        $issued = $order->issueCount();
        if ($issued < $issuelimit) {
            # code...
            if (!($order->checkRepeat())) {
                # code...
                if ($order->issue()) {
                    $book->minusQuatity();
                    echo '<script>alert("Ticket Issued");</script>';
                    header("Refresh:0; url=viewavailable.php");
                } else {
                    echo "error occured";
                }
            } else {
                echo '<script>alert("you already bought this conference Ticket");</script>';
                header("Refresh:0; url=viewavailable.php");
            }
        } else {
            echo '<script>alert("Ticket Limit Reached");</script>';
            header("Refresh:0; url=viewissued.php");
        }
    } else {
        echo "Invalid Conference";
    }
} else {
    if (isset($_SESSION['uuid'])) {
        # code...
        echo '<script>alert("your are loggedin as Admin");</script>';
        header("Refresh:0; url=viewavailable.php");
    } else {
        echo '<script>alert("Please login first");</script>';
        header("Refresh:0; url=viewavailable.php");
    }
}
