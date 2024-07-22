<?php
include 'autoloadClass.php';
$book = new book;

$pagetitle = "View Available Conference";
include 'header.php';

if (isset($_GET['page'])) {
   $page = intval($_GET['page']);
} else {
   $page = 1;
}
$offset = ($page - 1) * $limit;

$stmt = $book->readAvailable($offset, $limit);
echo "<table class='table table-hover table-responsive table-bordered'>";
echo "<tr>";
    echo "<th>Conference id</th>";
    echo "<th>Agenda</th>";
    echo "<th>Host By</th>";
    echo "<th>price</th>";
    echo "<th>Actions</th>";
echo "</tr>";

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

    extract($row);

    echo "<tr>";
        echo "<td>{$bookid}</td>";
        echo "<td>{$bookname}</td>";
        echo "<td>{$author}</td>";
        echo "<td>{$price}</td>";
        // echo "<td>";
        //     $category->id = $category_id;
        //     $category->readName();
        //     echo $category->name;
        // echo "</td>";

        echo "<td>";

            // issue book button
            echo "<a href='issue.php?bookid={$bookid}' class='btn btn-primary left-margin'>";
                echo "<span class='glyphicon glyphicon-list'></span> Buy Ticket";
            echo "</a>";

        echo "</td>";

    echo "</tr>";

}

echo "</table>";
$totalresult = $book->countavailable();
$pageurl = $_SERVER['PHP_SELF'];
include 'pagination.php';
include 'footer.php';
