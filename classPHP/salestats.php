<?php

include 'autoloadClass.php';
$order = new orders;

$pagetitle = "Conference stats";
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

    $stmt = $order->readsale($from, $to);
    if ($stmt->rowCount()) {

        echo "<table class='table table-hover table-responsive table-bordered'>";
        echo "<tr>";
            echo "<th>S.No.</th>";
            echo "<th>PurchaseId</th>";
            echo "<th>Conference</th>";
            echo "<th>Purchase Date</th>";
            echo "<th>Price</th>";
        echo "</tr>";
        $sno = 1;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            extract($row);

            echo "<tr>";
                echo "<td>{$sno}</td>";
                echo "<td>{$orderId}</td>";
                echo "<td>{$bookname}</td>";
                echo "<td>{$issueDate}</td>";
                echo "<td>{$price}</td>";
            echo "</tr>";

            $totalSales = $totalSales + $price;
            $sno++;
        }

        echo "<tr>";
            echo "<th> total sales in selected period </th>";
            echo "<td></td>";
            echo "<td></td>";
            echo "<td></td>";
            echo "<td>$totalSales</td>";
        echo "</tr>";

        echo "</table>";
    } else {
        echo "<strong>no sales on given period</strong>";
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
        <input type="date" id="fromdate" name="fromdate"><br>
        <label for="todate">select to:</label>
        <input type="date" id="todate" name="todate"><br>
        <input type="submit">
    </form>
</div>
<?php

include 'footer.php';