<?php
class Orders extends Database{
    // database connection and table name
    public static $table = "orders";
    private $table_name;
    
    // object properties
    public $orderId;
    public $bookid;
    public $customerId;
    public $issueDate;
    public $returnDate;
    public $status;
    
    public function __construct(){
        $this->conn = $this->getConnection();
        $this->table_name = self::$table;
    }

    // issue book
    public function issue(){
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                bookid = :bookid,
                customerId = :customerId";
    
        $stmt = $this->conn->prepare($query);

        // bind values 
        $stmt->bindParam(":bookid", $this->bookid);
        $stmt->bindParam(":customerId", $this->customerId);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }

    // insert random 
    public function insertData()
    {
         $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                bookid = :bookid,
                customerId = :customerId,
                issueDate = :issueDate,
                returnDate = :returnDate,
                status = :status";
    
        $stmt = $this->conn->prepare($query);

        // bind values 
        $stmt->bindParam(":bookid", $this->bookid);
        $stmt->bindParam(":customerId", $this->customerId);
        $stmt->bindParam(":issueDate", $this->issueDate);
        $stmt->bindParam(":returnDate", $this->returnDate);
        $stmt->bindParam(":status", $this->status);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    // return book
    public function return(){
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    status = :status
                WHERE
                    orderId = :orderId";

        $stmt = $this->conn->prepare($query);

        $var = 1;
        $curdate = date('Y-m-d');
        
        // bind parameters
        $stmt->bindParam(':status', $var);
        // $stmt->bindParam(':returnDate', $curdate);
        $stmt->bindParam(':orderId', $this->orderId);
        echo "<br".$this->orderId;
        // execute the query
        try{
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt->execute();
            echo "true stmt execute <br>";
            return true;
        }
        catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            echo "<br> error occurd";
            return false;
          }
        // if ($stmt->execute()) {
        //     return true;
        // }else{
        //     return false;
        // }
    }

    // get pending
    public function getPending()
    {
        $query = "SELECT 
                    orderId, bookid, issueDate 
                FROM 
                    " . $this->table_name . " 
                WHERE 
                status= :status AND customerId= :customerId";
        
        $stmt = $this->conn->prepare($query);

        // hmm
        $var = 0;

        // bind parameters
        $stmt->bindparam(':status', $var);
        $stmt->bindparam(':customerId', $this->customerId);

        $stmt->execute();

        return $stmt;
    }

    // get previous order
    public function allOrder($offset = 0, $limit = 10)
    {
        $query = "SELECT 
                    orderId, bookid, issueDate, returnDate, status
                FROM 
                    " . $this->table_name . " 
                WHERE 
                    customerId= :customerId
                LIMIT $offset, $limit";
        
        $stmt = $this->conn->prepare($query);

        // bind parameters
        $stmt->bindparam(':customerId', $this->customerId);

        $stmt->execute();

        return $stmt;
    }
    public function countAllOrder()
    {
        $query = "SELECT 
                    orderId, bookid, issueDate, returnDate, status
                FROM 
                    " . $this->table_name . " 
                WHERE 
                    customerId= :customerId";
        
        $stmt = $this->conn->prepare($query);

        // bind parameters
        $stmt->bindparam(':customerId', $this->customerId);

        $stmt->execute();
        $num = $stmt->rowCount();
        return $num;
    }

    // pending orders
    public function countPendingBook()
    {
        $query = "SELECT 
                    orderId
                FROM 
                    " . $this->table_name . " 
                WHERE 
                    status = :status AND bookid = :bookid";
        
        $stmt = $this->conn->prepare($query);

        // var
        $var = 0;

        // bind parameters
        $stmt->bindparam(':status', $var);
        $stmt->bindparam(':bookid', $this->bookid);

        $stmt->execute();
        $num = $stmt->rowCount();

        return $num;
    }
    //count for book
    public function countForBook($from = 0, $to = 0)
    {
        $query = "SELECT 
                    orderId
                FROM 
                    " . $this->table_name . " 
                WHERE 
                    issueDate > :fromDate AND 
                    issueDate < :toDate AND 
                    bookid = :bookid";
        
        $stmt = $this->conn->prepare($query);
        if ($to == 0) {
            $fromDate = date("Y-m-d", strtotime("2020-10-1"));
            $toDate = date("Y-m-d", strtotime("+1 day"));
        }else{
            $fromDate = date("Y-m-d", $from);
            $toDate = date("Y-m-d", $to);
        }
        // bind parameters
        $stmt->bindparam(':fromDate', $fromDate);
        $stmt->bindparam(':toDate', $toDate);
        $stmt->bindparam(':bookid', $this->bookid);

        $stmt->execute();
        $num = $stmt->rowCount();

        return $num;
    }

    // issue count
    public function issueCount()
    {
         $query = "SELECT 
                    orderId 
                FROM 
                    " . $this->table_name . " 
                WHERE 
                status = 0 AND customerId = :customerId";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindparam(':customerId', $this->customerId);

        $stmt->execute();
        $num = $stmt->rowCount();
        return $num;
    }
    
    //check repeate
    public function checkRepeat()
    {
        $query = "SELECT 
                    orderId 
                FROM 
                    " . $this->table_name . " 
                WHERE 
                status = 0 AND bookid = :bookid AND customerId = :customerId";

        $stmt = $this->conn->prepare($query);

        $stmt->bindparam(':bookid', $this->bookid);
        $stmt->bindparam(':customerId', $this->customerId);

        $stmt->execute();
        if($stmt->rowCount()){
            return true;
        }else{
            return false;
        }

    }

    // pending customer id
    public function readPendingCustomerId($bookid)
    {
         $query = "SELECT 
                    orderId, customerId
                FROM 
                    " . $this->table_name . " 
                WHERE 
                status = 0 AND bookid = :bookid";

        $stmt = $this->conn->prepare($query);

        $stmt->bindparam(':bookid', $bookid);

        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
            return $stmt;
        }else{
            return false;
        }
    }

    // join user id and book id
    public function readsale($from, $to)
    {
        $query = "SELECT
                        ". $this->table_name . ".orderId,
                        ". Book::$table . ".bookname,
                        ". Book::$table . ".price,
                        ". $this->table_name . ".issueDate,
                        " . User::$table . ".uuid
                    FROM
                        " . $this->table_name . "
                    JOIN " . Book::$table . " ON " . $this->table_name . ".bookid = " . Book::$table . ".bookid
                    JOIN " . User::$table . " ON " . Book::$table . ".by_user = " . User::$table . ".email
                    WHERE
                        " . Book::$table . ".by_user = '" . $_SESSION['email'] . "' AND
                        " . $this->table_name . ".issueDate > '" . date("Y-m-d", $from) . "' AND 
                        " . $this->table_name . ".issueDate < '" . date("Y-m-d", $to) . "'";
        $stmt = $this->conn->prepare($query);
        // echo "$query";
        $stmt->execute();

        return $stmt;
    }

    //order perbook
    public function salePerBook($from, $to)
    {
        $query = "SELECT
                        ". $this->table_name . ".orderId,
                        ". Book::$table . ".bookname,
                        ". Book::$table . ".price,
                        ". $this->table_name . ".issueDate,
                        " . User::$table . ".uuid
                    FROM
                        " . $this->table_name . "
                    JOIN " . Book::$table . " ON " . $this->table_name . ".bookid = " . Book::$table . ".bookid
                    JOIN " . User::$table . " ON " . Book::$table . ".by_user = " . User::$table . ".email
                    WHERE
                        " . $this->table_name . ".issueDate > '" . date("Y-m-d", $from) . "' AND 
                        " . $this->table_name . ".issueDate < '" . date("Y-m-d", $to) . "' AND
                        " . $this->table_name . ".bookid = '" . $this->bookid . "'";

        $stmt = $this->conn->prepare($query);
        // echo "$query<br>";
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
            return $count;
        }else{
            return false;
        }

    }

    // test
    public function testBookCount($from = 0, $to = 0)
    {
        $query = "SELECT 
                    orderId, issueDate
                FROM 
                    " . $this->table_name . " 
                WHERE 
                    issueDate > :fromDate AND 
                    issueDate < :toDate AND 
                    bookid = :bookid";
        
        $stmt = $this->conn->prepare($query);
        if ($to == 0) {
            $fromDate = date("Y-m-d", strtotime("2020-10-1"));
            $fromDate = date("Y-m-d", strtotime("+1 day"));
        }else{
            $fromDate = date("Y-m-d", $from);
            $toDate = date("Y-m-d", $to);
        }
        // bind parameters
        $stmt->bindparam(':fromDate', $fromDate);
        $stmt->bindparam(':toDate', $toDate);
        $stmt->bindparam(':bookid', $this->bookid);

        $stmt->execute();
        // $num = $stmt->rowCount();

        return $stmt;
    }

    
}