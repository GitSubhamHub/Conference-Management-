<?php
class Customer extends Database{
    static public $table = "customer";
    private $table_name;

    public $customerId;
    public $customerName;
    public $customerMail;
    public $psw;
    public $newpsw;

    public function __construct(){
        $this->conn = $this->getConnection();
        $this->table_name = self::$table;
    }

    // create user
    function signup(){
 
        // write query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                customerName = :customerName,
                customerMail = :customerMail,
                psw = :psw";
 
        $stmt = $this->conn->prepare($query);
 
        // posted values
        $this->customerName=htmlspecialchars(strip_tags($this->customerName));
        $this->customerMail=htmlspecialchars(strip_tags($this->customerMail));
        $this->psw=htmlspecialchars(strip_tags($this->psw));
 
 
        // bind values 
        $stmt->bindParam(":customerName", $this->customerName);
        $stmt->bindParam(":customerMail", $this->customerMail);
        $stmt->bindParam(":psw", $this->psw);
        
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
 
    }

    // login user
    function login(){
        // query
        $query = "SELECT customerId, customerName, customerMail FROM ".$this->table_name." WHERE customerMail = :customerMail AND psw = :psw";
        $stmt = $this->conn->prepare( $query );

        // bind values
        $stmt->bindParam(":customerMail", $this->customerMail);
        $stmt->bindParam(":psw", $this->psw);
        $stmt->execute();
        if ($stmt->rowCount() == 1) {
            # code...
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['customerId']=$row["customerId"];
            $_SESSION['customerName']=$row["customerName"];
            $_SESSION['customerMail']=$row["customerMail"];
            return true;
            // echo $row["customerId"] , $row["customerName"] , $row["customerMail"];
        }else{
            return false;
        }



    }

    // logout user
    static function logout(){

        session_start();
        session_unset();
        session_destroy();
        session_write_close();
        setcookie(session_name(),'',0,'/');
        // session_regenerate_id(true);
        // header("Location: index.php");

    }
    
    // password change
    function changepass(){
        $query = "SELECT customerId, customerName, customerMail FROM ".$this->table_name." WHERE customerMail = :customerMail AND psw = :psw";
        $stmt = $this->conn->prepare( $query );

        // bind values
        $stmt->bindParam(":customerMail", $this->customerMail);
        $stmt->bindParam(":psw", $this->psw);
        $stmt->execute();
        if ($stmt->rowCount() == 1) {
           $query = "UPDATE ".$this->table_name." SET psw = :psw WHERE customerId = :customerId";
           $stmt = $this->conn->prepare( $query );
           
           //bind value
           $stmt->bindParam(":customerId", $this->customerId);
           $stmt->bindParam(":psw", $this->newpsw);
           if ($stmt->execute()) {
               # code...
               return true;
           }else{
               return false;
           }
        }
    }
    
    //read customer name
    public function readname()
    {
        $query = "SELECT 
                    customerName
                FROM 
                    " . $this->table_name . " 
                WHERE 
                    customerId = :customerId";
        $stmt = $this->conn->prepare($query);

        $stmt->bindparam(':customerId', $this->customerId);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->customerName = $row['customerName'];
    }
}
?>