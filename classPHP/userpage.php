<?php
// session_start();
$pagetitle = "User page";
include 'header.php';
include 'autoloadClass.php';
$user = new User;
function test_input($inputs){
    $inputs = trim($inputs);
    $inputs = stripslashes($inputs);
    $inputs = htmlspecialchars($inputs);
    return $inputs;
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $user->email = $_SESSION['email'];
    $user->uuid = $_SESSION['uuid'];
    if($_POST['newpass'] == $_POST['newpass2']){
        $user->psw = test_input($_POST['psw']);
        $user->newpsw = test_input($_POST['newpass']);
        if($user->changepass()){
        echo '<script>alert("password changed!!!");</script>';
        }else{
        echo '<script>alert("wrong old password!!!");</script>';
        }
    }else{
        echo '<script>alert("the password and repeat password must be equal");</script>';
    }
}
if (isset($_SESSION['uuid'])) {
    # code...
?>
<h2><b>User information</b></h2>
<table>
   <tr>
       <th>Name</th>
       <td><?php echo $_SESSION['firstname']; ?></td>
   </tr>
   <tr>
       <th>email</th>
       <td><?php echo $_SESSION['email']; ?></td>
   </tr>
   <tr>
       <th>uuid</th>
       <td><?php echo $_SESSION['uuid']; ?></td>
   </tr>
</table>
    <form class="modal-content" action="userpage.php" id="form1" method="post" onsubmit="pass(); return false;" >
        <div class="container">
            <h3> <strong>change password?</strong></h3>
            <label for="psw"><b>old password</b></label>
            <input type="password" placeholder="Enter old password" name="psw" required>
            <label for="newpass"><b>New Password</b></label>
            <input type="password" id="password" placeholder="Enter New Password" name="newpass" required>
            <label for="newpass2"><b>Repeat New Password</b></label>
            <input type="password" id="confirm_password" placeholder="repeat New Password" name="newpass2" required>
            <p id="passcheck"></p>
            <div class="clearfix"> 
                <input type="submit" class="greenbtn" value="change password"><a href="index.php" class="cancelbtn" >cancel</a>
            </div>
        </div>
    </form>

<?php
}else{
    echo '<h3>you are not loggged in</h3>';
}
include 'footer.php';
?>