<?php
    
include 'autoloadClass.php';
$order = new orders;
$book = new book;
$pagetitle = "Bookwise sale";
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $preset = $_POST['preset'];
    $to = strtotime("next day");
    switch ($preset) {
        case 'Daily':
            $from = strtotime("today");
            break;
        case 'Weekly':
            $from = strtotime("-7 day");
            break;
        case 'Monthly':
            $from = strtotime("-30 day");
            break;
        case 'custom':
            $from = strtotime($_POST['fromdate']);
            $to = strtotime($_POST['todate']);
            break;
        default:
            echo "somthing wrong happens";
            break;
    }
    $totalSales = 0;
    $totalOrder = 0;
    $booksale = 0;
    $book->by_user = $_SESSION['email'];
    $stmt = $book->readAll();
    if($stmt->rowCount()){

    echo "<table class='table table-hover table-responsive table-bordered'>";
            echo "<tr>";
                echo "<th>BookID</th>";
                echo "<th>Book Name</th>";
                echo "<th>Author</th>";
                echo "<th>sale of book in given period</th>";
                echo "<th>Price of one book</th>";
                echo "<th>total sale</th>";
            echo "</tr>";
    
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            
                extract($row);
                $order->bookid = $bookid;
                $bookOrder = $order->countForBook($from, $to);
                if (!$bookOrder) {
                    continue;
                }
                $booksale = $bookOrder * $price;
                $totalSales = $totalSales + $booksale;
                $totalOrder = $totalOrder + $bookOrder;

                echo "<tr>";
                    echo "<td>{$bookid}</td>";
                    echo "<td>{$bookname}</td>";
                    echo "<td>{$author}</td>";
                    echo "<td>{$bookOrder}</td>"; 
                    echo "<td>{$price}</td>";
                    echo "<td>{$booksale}</td>";
                
                echo "</tr>";
                
                
            }
            echo "<tr>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<th>total order in this period</th>";
                echo "<td>$totalOrder</td>";
                echo "<th>total sales in given period</th>";
                echo "<td>$totalSales</td>";
            echo "</tr>";
        
        echo "</table>";
    }else{
      echo "<strong>No Sale in given period</strong>";
    }
}
?>
<div class="container">
    <h2>Select to view sales</h2>
    <form class="model-content" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <label for="preset"><strong>Select daily weekly or monthly</strong></label>
    <select name="preset" id="">
        <option value="custom">custom</option>
        <option value="Daily">Daily</option>
        <option value="Weekly">Weekly</option>
        <option value="Monthly">Monthly</option>
    </select><br><br>
    <label for="fromdate">Selct from:</label>
      <input type="date" id="fromdate" name="fromdate" ><br>
      <label for="todate">select to:</label>
      <input type="date" id="todate" name="todate" ><br>
      <input type="submit">
    </form>
</div>
<?php

include 'footer.php';
