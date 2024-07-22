<?php
class book extends Database
{
    // database connection and table name
    static public $table = "UserBooksrecord";
    private $table_name;

    // object properties
    public $bookid;
    public $bookname;
    public $author;
    public $price;
    public $by_user;
    public $quantity;

    public function __construct()
    {
        $this->conn = $this->getConnection();
        $this->table_name = self::$table;
    }

    // create product
    function insert()
    {

        //write query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                bookname = :bookname,
                author = :author,
                price = :price,
                by_user = :by_user,
                quantity = :quantity";

        $stmt = $this->conn->prepare($query);

        // posted values
        $this->bookname = htmlspecialchars(strip_tags($this->bookname));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));
        $this->by_user = $_SESSION['email'];

        // bind values 
        $stmt->bindParam(":bookname", $this->bookname);
        $stmt->bindParam(":author", $this->author);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":by_user", $this->by_user);
        $stmt->bindParam(":quantity", $this->quantity);

        if ($stmt->execute()) {
            $id = $this->conn->lastInsertId();
            return $id;
        } else {
            return false;
        }
    }

    // read all by user
    function readAll($offset = 0, $limit = 100)
    {
        $query = "SELECT bookid, bookname, author, price, quantity FROM " . $this->table_name . " WHERE by_user= :by_user LIMIT $offset, $limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindparam(':by_user', $this->by_user);
        $stmt->execute();

        return $stmt;
    }

    // update record
    function update()
    {

        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    bookname = :bookname,
                    author = :author,
                    price = :price,
                    quantity = :quantity
                WHERE
                    bookid = :bookid";

        $stmt = $this->conn->prepare($query);

        // posted values
        $this->bookname = htmlspecialchars(strip_tags($this->bookname));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));
        $this->bookid = htmlspecialchars(strip_tags($this->bookid));

        // bind parameters
        $stmt->bindParam(':bookname', $this->bookname);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':quantity', $this->quantity);
        $stmt->bindParam(':bookid', $this->bookid);

        // execute the query
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // read one record
    function readOne($id)
    {
        $query = "SELECT bookid, bookname, author, price, quantity FROM " . $this->table_name . " WHERE bookid = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count == 1) {
            return $stmt;
        } else {
            return false;
        }
    }


    // count by user
    function count()
    {
        $query = "SELECT bookid FROM " . $this->table_name . " WHERE by_user= :by_user";
        $stmt = $this->conn->prepare($query);
        $stmt->bindparam(':by_user', $_SESSION['email']);
        $stmt->execute();
        $num = $stmt->rowCount();
        return $num;
    }

    // delete record
    function delete()
    {

        $query = "DELETE FROM " . $this->table_name . " WHERE bookid = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->bookid);

        if ($result = $stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // quantity decrement
    public function minusQuatity()
    {
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    quantity = quantity - 1
                WHERE
                    bookid = :bookid";

        $stmt = $this->conn->prepare($query);

        // bind parameters
        $stmt->bindParam(':bookid', $this->bookid);

        // execute the query
        try {
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return false;
        }
        // if ($stmt->execute()) {
        //     return true;
        // }
        // return false;
    }

    // quantity increment
    public function plusquantity()
    {
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    quantity = quantity + 1
                WHERE
                    bookid = :bookid";

        $stmt = $this->conn->prepare($query);

        // bind parameters
        $stmt->bindParam(':bookid', $this->bookid);

        // execute the query
        try {
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return false;
        }
        // if ($stmt->execute()) {
        //     return true;
        // }
        // return false;
    }

    // available for issue
    public function readAvailable($offset = 0, $limit = 10)
    {
        $query = "SELECT bookid, bookname, author, price FROM " . $this->table_name . " WHERE quantity > 0 LIMIT $offset, $limit";
        $stmt = $this->conn->prepare($query);
        // $stmt->bindparam(':by_user', $_SESSION['email']);
        $stmt->execute();

        return $stmt;
    }

    // count available
    public function countAvailable()
    {
        $query = "SELECT bookid FROM " . $this->table_name . " WHERE quantity > 0";
        $stmt = $this->conn->prepare($query);
        // $stmt->bindparam(':by_user', $_SESSION['email']);
        $stmt->execute();

        $num = $stmt->rowCount();
        return $num;
    }

    // read name
    public function readName()
    {
        $query = "SELECT bookname, author, price FROM " . $this->table_name . " WHERE bookid = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->bookid);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->bookname = $row['bookname'];
        $this->author = $row['author'];
        $this->price = $row['price'];
        // $count = $stmt->rowCount();
        // if ($count == 1) {
        //     return $stmt;
        // } else {
        //     return false;
        // }
    }

    // join user id and book id
    public function readsale($from, $to)
    {
        $query = "SELECT
                        " . Orders::$table . ".orderId,
                        " . Book::$table . ".bookname,
                        " . Book::$table . ".price,
                        " . Orders::$table . ".issueDate,
                        " . User::$table . ".uuid
                    FROM
                        " . Orders::$table . "
                    JOIN " . Book::$table . " ON " . Orders::$table . ".bookid = " . Book::$table . ".bookid
                    JOIN " . User::$table . " ON " . Book::$table . ".by_user = " . User::$table . ".email
                    WHERE
                        " . Book::$table . ".by_user = '" . $_SESSION['email'] . "' AND
                        " . Orders::$table . ".issueDate > '" . date("Y-m-d", $from) . "' AND 
                        " . Orders::$table . ".issueDate < '" . date("Y-m-d", $to) . "'";
        $stmt = $this->conn->prepare($query);
        echo "$query";
        $stmt->execute();

        return $stmt;
    }
}
