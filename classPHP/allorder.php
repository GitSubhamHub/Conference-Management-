<?php
    
include 'autoloadClass.php';
$order = new orders;
$book = new book;
$pagetitle = "All orders";
include 'header.php';

if (isset($_GET['page'])) {
        $page = intval($_GET['page']);
    } else {
        $page = 1;
    }
    
    $offset = ($page - 1) * $limit;
    
    $book->by_user = $_SESSION['email'];
    $stmt = $book->readAll($offset, $limit);

    if($stmt->rowCount()){

        echo "<table class='table table-hover table-responsive table-bordered'>";

            echo "<tr>";
                echo "<th>Conference ID</th>";
                echo "<th>Agenda</th>";
                echo "<th>Host By</th>";
                echo "<th>Price</th>";
                echo "<th>Remaining Tickets</th>";
                echo "<th>No. of tickets Sold</th>";
                echo "<th>Current Members</th>";
            echo "</tr>";
    
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    
                extract($row);
                $order->bookid = $bookid;
                $totalOrder = $order->countForBook();
                $pendingBook = $order->countPendingBook();

    
                echo "<tr>";
                    echo "<td>{$bookid}</td>";
                    echo "<td>{$bookname}</td>";
                    echo "<td>{$author}</td>";
                    echo "<td>{$price}</td>";
                    echo "<td>{$quantity}</td>";  
                    echo "<td>{$totalOrder}</td>"; 
                    if ($pendingBook) {
                        echo "<td>{$pendingBook}</td>"; 
                    } else{
                        echo "<td>not pending</td>";
                    }
                    
                    if ($pendingBook) {
                        echo "<td>";
        
                            // view product button
                            echo "<a href='issuedto.php?bookid={$bookid}' class='btn btn-info left-margin'>";
                            echo "<span class='glyphicon glyphicon-edit'></span> view";
                            echo "</a>";
        
                        echo "</td>";
                    }
            
                echo "</tr>";
    
            }
    
        echo "</table>";
    }else{
  echo "<strong>no record on your acccount</strong>";
}
$totalresult = $book->count();
$pageurl = $_SERVER['PHP_SELF'];
include 'pagination.php';
include 'footer.php';