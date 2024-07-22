<?php
include 'autoloadClass.php';
// spl_autoload_register();
$book = new book;
$pagetitle = "View all";
include 'header.php';

if (isset($_GET['page'])) {
    $page = intval($_GET['page']);
} else {
    $page = 1;
}
$offset = ($page - 1) * $limit;
if (isset($_SESSION['email'])) {
    $book->by_user = $_SESSION['email'];
    $stmt = $book->readAll($offset, $limit);
    if ($stmt->rowCount()) {

        echo "<table class='table table-hover table-responsive table-bordered'>";
        echo "<tr>";
        echo "<th>Conference id</th>";
        echo "<th>Agenda</th>";
        echo "<th>Host By</th>";
        echo "<th>Price</th>";
        echo "<th>Available Tickets</th>";
        echo "<th>Actions</th>";
        echo "</tr>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            extract($row);

            echo "<tr>";
            echo "<td>{$bookid}</td>";
            echo "<td>{$bookname}</td>";
            echo "<td>{$author}</td>";
            echo "<td>{$price}</td>";
            echo "<td>{$quantity}</td>";

            echo "<td>";

            // book update button
            echo "<a href='update.php?bookid={$bookid}' class='btn btn-primary left-margin'>";
            echo "<span class='glyphicon glyphicon-list'></span> Update";
            echo "</a>";

            // echo "<button class='deletebtn' onclick='confirmDelete($bookid, $page)'>delete</button>";
            echo "<button type='button' class='btn btn-danger' onclick='cnfrmDelete($bookid, $page)'>Danger</button>";


            // delete product button
            // echo "<a href='delete.php?bookid={$bookid}&page={$page}' class='btn btn-danger delete-object'>";
            // echo "<span class='glyphicon glyphicon-remove'></span> Delete";
            // echo "</a>";

            echo "</td>";

            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<strong>no record on your acccount</strong>";
    }
} else {
    echo '<script>alert("you are not loggedin");</script>';
    header("refresh:0; url=index.php");
}
$totalresult = $book->count();
$pageurl = $_SERVER['PHP_SELF'];
include 'pagination.php';
?>
<script>
    // function cnfrmDelete(bookid, page) {
    //     if (confirm("Delete bookid:" + bookid)) {
    //         location.assign("delete.php?bookid=" + bookid + "&page=" + page);
    //     }
    // }
    function cnfrmDelete(bookid, page) {
        if (confirm("Delete bookid:" + bookid)) {
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    location.reload();
                }
            };
            xhttp.open("GET", "delete.php?bookid=" + bookid + "&page=" + page, true);
            xhttp.send();
        }
    }
</script>
<?php
include 'footer.php';
