<?php
class User extends Database{
    static public $table = "userdata";
    private $table_name;

    public $uuid;
    public $firstname;
    public $email;
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
                firstname = :firstname,
                email = :email,
                psw = :psw";
 
        $stmt = $this->conn->prepare($query);
 
        // posted values
        $this->firstname=htmlspecialchars(strip_tags($this->firstname));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->psw=htmlspecialchars(strip_tags($this->psw));
 
 
        // bind values 
        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":email", $this->email);
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
        $query = "SELECT uuid, firstname, email FROM ".$this->table_name." WHERE email = :email AND psw = :psw";
        $stmt = $this->conn->prepare( $query );

        // bind values
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":psw", $this->psw);
        $stmt->execute();
        if ($stmt->rowCount() == 1) {
            # code...
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['uuid']=$row["uuid"];
            $_SESSION['firstname']=$row["firstname"];
            $_SESSION['email']=$row["email"];
            return true;
            echo $row["uuid"] , $row["firstname"] , $row["email"];
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
        $query = "SELECT uuid, firstname, email FROM ".$this->table_name." WHERE email = :email AND psw = :psw";
        $stmt = $this->conn->prepare( $query );

        // bind values
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":psw", $this->psw);
        $stmt->execute();
        if ($stmt->rowCount() == 1) {
           $query = "UPDATE ".$this->table_name." SET psw = :psw WHERE uuid = :uuid";
           $stmt = $this->conn->prepare( $query );
           
           //bind value
           $stmt->bindParam(":uuid", $this->uuid);
           $stmt->bindParam(":psw", $this->newpsw);
           if ($stmt->execute()) {
               # code...
               return true;
           }else{
               return false;
           }
        }
    }
}
?>