<?php
include 'autoloadClass.php';
$order = new Orders;
$pagetitle = "random";
include 'header.php';
$s = strtotime("2020-10-01 08:00:00");
$e = strtotime("2020-10-01 20:00:00");
$startdate = $s;
$enddate = $e;
$sno = 1;
echo "<table class='table table-hover table-responsive table-bordered'>";
echo "<tr>";
echo "<th>sno.</th>";
echo "<th>bookid</th>";
echo "<th>customerId</th>";
echo "<th>issudate</th>";
echo "<th>return date</th>";
echo "<th>status</th>";
echo "</tr>";
for ($i = 0; $i < 31; $i++) {
    $startdate = strtotime("+1 day", $startdate);
    $enddate = strtotime("+1 day", $enddate);
    for ($j = 0; $j < 3; $j++) {
        $r = mt_rand($startdate, $enddate);
        $issuedate = $r;
        $r = mt_rand($startdate, $enddate);
        $returndate = strtotime("+2 day", $r);
        $bookid = mt_rand(188, 200);
        $customerId = mt_rand(1, 5);
        echo "<tr>";
        echo "<td>{$sno}</td>";
        echo "<td>{$bookid}</td>";
        echo "<td>{$customerId}</td>";
        echo "<td>" . date("Y-m-d H:i:s", $issuedate) . "</td>";
        echo "<td>" . date("Y-m-d H:i:s", $returndate) . "</td>";
        echo "<td>";
        // setting proferties to object
        $order->bookid = $bookid;
        $order->customerId = $customerId;
        $order->issueDate = date("Y-m-d H:i:s", $issuedate);
        $order->returnDate = date("Y-m-d H:i:s", $returndate);
        $order->status = 1;
        if ($order->insertData()) {
            echo "done</td></tr>";
        }
        $sno++;
    }
}
echo "</table>";
