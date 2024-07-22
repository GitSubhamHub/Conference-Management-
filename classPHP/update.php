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
    $book->bookid = $_POST['bookid'];
    if ($book->update()) {
        echo '<script>alert("book record updated");</script>';
        header("Refresh:0; url=viewall.php");
    } else {
        echo "not updated!!!";
    }
}

if (isset($_SESSION['uuid'])) {
    if (isset($_GET['bookid'])) {
        $bookid = $_GET['bookid'];
        if ($stmt = $book->readOne($bookid)) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $defaultbook = $row["bookname"];
                $defaultauthor = $row["author"];
                $defaultprice = $row["price"];
                $defaultquantity = $row["quantity"];
            }
?>
            <hr>
            <form action="update.php" method="post">
                bookid to change: <input type="text" style="width:100px;" name="bookid" value=<?php echo $bookid; ?>><br>
                Book name: <input type="text" name="bookname" value="<?php echo $defaultbook; ?>">
                Auther name: <input type="text" name="author" value="<?php echo $defaultauthor; ?>">
                Book price: <input type="text" name="price" value="<?php echo $defaultprice; ?>">
                Book quantity: <input type="text" name="quantity" value="<?php echo $defaultquantity; ?>">
                <button type="submit" class="greenbtn">update</button><a href="viewall.php" class="cancelbtn">cancel</a>
            </form>
<?php
        } else {
            echo '<h4> you entered randon id in url';
        }
    } else {
        echo '<h4> bookid not selected</h4>';
        echo '<li>please go to view all page by clicking in the navbar to select id';
    }
} else {
    echo '<h3>Login to enter book record</h3>';
}
?>