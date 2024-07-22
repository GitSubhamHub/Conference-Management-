<?php
include 'autoloadClass.php';

$order = new Orders;
$book = new Book;
$customer = new Customer;

$pagetitle = "View all";
include 'header.php';

if (isset($_SESSION['uuid'])) {
    if (isset($_GET['bookid'])) {
        $bookid = $_GET['bookid'];
        if ($stmt = $order->readPendingCustomerId($bookid)) {
            echo "<table class='table table-hover table-responsive table-bordered'>";
            echo "<tr>";
                echo "<th>OrderID</th>";
                echo "<th>Book Name</th>";
                echo "<th>Author</th>";
                echo "<th>Price</th>";
                echo "<th>Issued to</th>";
            echo "</tr>";

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                extract($row);

                $book->bookid = $bookid;
                $book->readName();
                $customer->customerId = $customerId;
                $customer->readname();


                echo "<tr>";
                    echo "<td>{$orderId}</td>";
                    echo "<td>{$book->bookname}</td>";
                    echo "<td>{$book->author}</td>";
                    echo "<td>{$book->price}</td>";
                    echo "<td>{$customer->customerName}</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo '<h4> you entered randon id in url';
        }
    } else {
        echo '<h4> bookid not selected</h4>';
        echo '<li>please go to all order page by clicking in the navbar to select bookid';
    }
} else {
    echo '<h3>Login to view student name</h3>';
}

include 'footer.php';
