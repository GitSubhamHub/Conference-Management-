<?php
include 'autoloadClass.php';
$book = new book;
$order = new orders;
$pagetitle = "Your Conferences";
include 'header.php';
if (isset($_SESSION['customerId'])) {
    # code...

$order->customerId = $_SESSION['customerId'];
$stmt = $order->getPending();
if ($stmt->rowCount()) {
    # code...
    echo "<table class='table table-hover table-responsive table-bordered'>";
    echo "<tr>";
        echo "<th>Conference id</th>";
        echo "<th>Agenda</th>";
        echo "<th>Host By</th>";
        echo "<th>price</th>";
        echo "<th>Actions</th>";
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
            
            echo "<td>";
    
                // issue book button
                echo "<a href='return.php?orderId={$orderId}&bookid={$bookid}' class='btn btn-primary left-margin'>";
                    echo "<span class='glyphicon glyphicon-list'></span> Leave Conference";
                echo "</a>";
    
            echo "</td>";
    
        echo "</tr>";
    
    }
    
    echo "</table>";
    }else{
        echo "You haven't joined any conference";
    }
    
}else{
    echo "you are not logged in";
}

include 'footer.php';
