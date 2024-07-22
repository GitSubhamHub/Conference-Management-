<?php
    
include 'autoloadClass.php';
$order = new orders;
$book = new book;
$pagetitle = "Current Conference";
include 'header.php';

$book->by_user = $_SESSION['email'];
$stmt = $book->readAll();
if($stmt->rowCount()){

echo "<table class='table table-hover table-responsive table-bordered'>";
        echo "<tr>";
            echo "<th>Conference id</th>";
            echo "<th>Agenda</th>";
            echo "<th>Host By</th>";
            echo "<th>price</th>";
            echo "<th>Remaining Tickets</th>";
            echo "<th>Tickets Sold</th>";
        echo "</tr>";
 
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
 
            extract($row);
            $order->bookid = $bookid;
            $var = $order->countPendingBook();
            if (!$var) {
                continue;
            }
 
            echo "<tr>";
                echo "<td>{$bookid}</td>";
                echo "<td>{$bookname}</td>";
                echo "<td>{$author}</td>";
                echo "<td>{$price}</td>";
                echo "<td>{$quantity}</td>";  
                echo "<td>{$var}</td>";  
            echo "</tr>";
            
 
        }
 
    echo "</table>";
}else{
  echo "<strong>no record on your acccount</strong>";
}


include 'footer.php';
