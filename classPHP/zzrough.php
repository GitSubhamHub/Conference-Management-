<?php
echo "<table class='table table-hover table-responsive table-bordered'>";
echo "<tr>";
echo "<th>Product</th>";
echo "<th>Price</th>";
echo "<th>Description</th>";
echo "<th>Category</th>";
echo "<th>Actions</th>";
echo "</tr>";

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

  extract($row);

  echo "<tr>";
  echo "<td>{$name}</td>";
  echo "<td>{$price}</td>";
  echo "<td>{$description}</td>";
  echo "<td>";
  $category->id = $category_id;
  $category->readName();
  echo $category->name;
  echo "</td>";

  echo "<td>";

  // read product button
  echo "<a href='read_one.php?id={$id}' class='btn btn-primary left-margin'>";
  echo "<span class='glyphicon glyphicon-list'></span> Read";
  echo "</a>";

  // edit product button
  echo "<a href='update_product.php?id={$id}' class='btn btn-info left-margin'>";
  echo "<span class='glyphicon glyphicon-edit'></span> Edit";
  echo "</a>";

  // delete product button
  echo "<a delete-id='{$id}' class='btn btn-danger delete-object'>";
  echo "<span class='glyphicon glyphicon-remove'></span> Delete";
  echo "</a>";

  echo "</td>";

  echo "</tr>";
}

echo "</table>";
try {
  $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt->execute();
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

function __autoload($class_name)
{
  //class directories
  $directorys = array(
    'config/',
    'objects/'
  );

  //for each directory
  foreach ($directorys as $directory) {
    //see if the file exsists
    if (file_exists($directory . $class_name . '.php')) {
      require_once($directory . $class_name . '.php');
      //only require the class once, so quit after to save effort (if you got more, then name them something else
      return;
    }
  }
}
$query = "SELECT
    orders.*,
    customer.customerName,
    customer.CustomerMail,
    userdata.uuid
FROM
    `orders`
JOIN userbooksrecord ON orders.bookid = userbooksrecord.bookid
JOIN customer ON customer.customerId = orders.CustomerId
JOIN userdata ON userbooksrecord.by_user = userdata.email
WHERE
    userbooksrecord.by_user = 'seller1@mail.com' AND orders.status = 0";
$sql ="
CREATE TABLE orders(
  orderId INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  bookid INT(6) NOT NULL,
  CustomerId INT(6) NOT NULL,
  issueDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  returnDate TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  STATUS BOOLEAN NOT NULL
      DEFAULT FALSE
)
";

//===========================---------------------------------------------------===========================

// include 'autoloadClass.php';
// $order = new Orders;
$pagetitle = "random";
include 'header.php';
$s = strtotime("2020-10-02 08:00:00");
$e = strtotime("2020-10-02 20:00:00");
// echo date("Y-m-d H:i:s", $startdate);
echo "<br>";
$startdate = $s;
$enddate = $e;
// var_dump($s);
// echo "<br>";
// var_dump($e);
echo "<table class='table table-hover table-responsive table-bordered'>";
echo "<tr>";
echo "<th>bookid</th>";
echo "<th>customerId</th>";
echo "<th>issudate</th>";
echo "</tr>";
$sno = 1;
for ($i=0; $i <10 ; $i++) {
    $startdate = strtotime("+1 day", $startdate);
    $enddate = strtotime("+1 day", $enddate);
    

for ($j=0; $j < 5; $j++) { 
    $issuedate = mt_rand($startdate,$enddate);
    $bookid = mt_rand(188,200);
    $customerId = mt_rand(1,5);
    echo "<tr>";
    echo "<td>{$sno}</td>";
    echo "<td>{$bookid}</td>";
    echo "<td>{$customerId}</td>";
    echo "<td>" . date("Y-m-d H:i:s", $issuedate) . "</td>";
  echo "</tr>";
  $sno++;



    // $order->bookid = $bookid;
    // $order->customerId = $customerId;

}}
echo "</table>";



