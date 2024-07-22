<?php
$pagetitle = "customer page";
include 'header.php';
include 'autoloadClass.php';

$customer = new customer;
function test_input($inputs)
{
    $inputs = trim($inputs);
    $inputs = stripslashes($inputs);
    $inputs = htmlspecialchars($inputs);
    return $inputs;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer->customerMail = $_SESSION['customerMail'];
    $customer->customerId = $_SESSION['customerId'];
    if ($_POST['newpass'] == $_POST['newpass2']) {
        $customer->psw = test_input($_POST['psw']);
        $customer->newpsw = test_input($_POST['newpass']);
        if ($customer->changepass()) {
            echo '<script>alert("password changed!!!");</script>';
        } else {
            echo '<script>alert("wrong old password!!!");</script>';
        }
    } else {
        echo '<script>alert("the password and repeat password must be equal");</script>';
    }
}
if (isset($_SESSION['customerId'])) {
    # code...
?>
    <h2><b>customer information</b></h2>
    <table>
        <tr>
            <th>Name</th>
            <td><?php echo $_SESSION['customerName']; ?></td>
        </tr>
        <tr>
            <th>email</th>
            <td><?php echo $_SESSION['customerMail']; ?></td>
        </tr>
        <tr>
            <th>customerId</th>
            <td><?php echo $_SESSION['customerId']; ?></td>
        </tr>
    </table>
    <form class="modal-content" action="customerpage.php" id="form1" method="post" onsubmit="pass(); return false;">
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
                <input type="submit" class="greenbtn" value="change password"><a href="index.php" class="cancelbtn">cancel</a>
            </div>
        </div>
    </form>

<?php
} else {
    echo '<h3>you are not loggged in</h3>';
}
include 'footer.php';
?>