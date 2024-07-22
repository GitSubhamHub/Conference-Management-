<?php
include 'autoloadClass.php';
$book = new book;

$pagetitle = "add book record";
include 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $book->bookname = $_POST['bookname'];
  $book->author = $_POST['author'];
  $book->price = $_POST['price'];
  $book->quantity = $_POST['quantity'];

  if ($id = $book->insert()) {
    echo '<script>alert("Conference Created");</script>';
    echo "<h3>Data you entered</h3>";
    $stmt = $book->readOne($id);

    echo "<table class='table table-bordered'>";

    echo "<tr>";
    echo "<th>Conference id</th>";
    echo "<th>Agenda</th>";
    echo "<th>Host By</th>";
    echo "<th>price</th>";
    echo "<th>Available Tickets</th>";
    echo "</tr>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

      extract($row);

      echo "<tr>";
      echo "<td>{$bookid}</td>";
      echo "<td>{$bookname}</td>";
      echo "<td>{$author}</td>";
      echo "<td>{$price}</td>";
      echo "<td>{$quantity}</td>";
      echo "</tr>";
    }

    echo "</table>";
  } else {
    echo '<script>alert("error : no record added");</script>';
  }
}
if (isset($_SESSION['uuid'])) {
?>
  <h2>please fill</h2>
  <form action="addbook.php" method="post" onsubmit="return(formvalidate())">
    Conference Agenda name: <input type="text" name="bookname" required><br>
     <input type="hidden" name="author" value="<?= isset($_SESSION['firstname']) ? $_SESSION['firstname'] : '' ?>"><br>
    Conference Entry Fee: <input type="text" name="price" required><br>
    Available Tickets: <input type="text" name="quantity" required><br>
    <input type="submit" class="greenbtn">
  </form><br><br>
<?php
} else {
  echo '<h3>Login to create Conference</h3>';
} ?>
<!-- <script>
  function formvalidate() {
    if (document.myForm.bookname.value == "") {
      alert("Please enter bookname!");
      document.myForm.bookname.focus();
      return false;
    }
    if (document.myForm.author.value == "") {
      alert("Please enter authorname!");
      document.myForm.author.focus();
      return false;
    }
    if (isNaN(document.myForm.price.value)) {
      alert("Please provide price in number");
      document.myForm.price.focus();
      return false;
    }
    if (isNaN(document.myForm.quantity.value)) {
      alert("Please provide quantity in number");
      document.myForm.quantity.focus();
      return false;
    }
    return (true);
  }
</script> -->
<?php
include 'footer.php';
?>