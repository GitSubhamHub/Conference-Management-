<?php
include 'autoloadClass.php';
$book = new book;
$order = new orders;
$pagetitle = "Previous Conferences";
include 'header.php';
if (isset($_GET['page'])) {
    $page = intval($_GET['page']);
  } else {
    $page = 1;
  }
  $offset = ($page - 1) * $limit;

if (isset($_SESSION['customerId'])) {
    # code...

$order->customerId = $_SESSION['customerId'];
$stmt = $order->allOrder($offset, $limit);
if ($stmt->rowCount()) {
    # code...
    echo "<table class='table table-hover table-responsive table-bordered'>";
    echo "<tr>";
        echo "<th>Conference id</th>";
        echo "<th>Agenda</th>";
        echo "<th>Host By</th>";
        echo "<th>price</th>";
        // echo "<th>Actions</th>";
    echo "</tr>";
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    
        extract($row);
        $book->bookid = $bookid;
        $book->readName();
        echo "<tr>";
            echo "<td>{$orderId}</td>";
            echo "<td>{$book->bookname}</td>";
            echo "<td>{$book->author}</td>";
            echo "<td>{$book->price}</td>";
            
            // echo "<td>";
    
            //     // issue book button
            //     echo "<a href='return.php?orderId={$orderId}&bookid={$bookid}' class='btn btn-primary left-margin'>";
            //         echo "<span class='glyphicon glyphicon-list'></span> return";
            //     echo "</a>";
    
            // echo "</td>";
    
        echo "</tr>";
    
    }
    
    echo "</table>";
    }else{
        echo "You Haven't Joined Any Conference";
    }
    
}else{
    echo "you are not logged in";
}
$totalresult = $order->countAllOrder();
$pageurl = $_SERVER['PHP_SELF'];
include 'pagination.php';

include 'footer.php';
