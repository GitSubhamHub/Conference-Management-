<?php
$pagetitle = "Create Conference";
include 'header.php';
?>
<div id="output"></div>
<h2>please fill</h2>
<form action="addbook.php" name="bookproperties" method="post">
    Conference Agenda name: <input type="text" name="bookname" required><br>
     <input type="hidden" name="author" value="<?= isset($_SESSION['firstname']) ? $_SESSION['firstname'] : '' ?>"><br>
    Conference Entry Fee: <input type="text" name="price" required><br>
    Available Tickets: <input type="text" name="quantity" required><br>
    <input type="submit" class="greenbtn">
</form><br><br>
<?php include 'footer.php'; ?>