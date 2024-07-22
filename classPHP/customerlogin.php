<?php
include 'autoloadClass.php';

$pagetitle = "Student login page";
include 'header.php';

$customer = new customer;

function test_input($inputs)
{
  $inputs = trim($inputs);
  $inputs = stripslashes($inputs);
  $inputs = htmlspecialchars($inputs);
  return $inputs;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $validate = 1;
  $customer->customerMail = test_input($_POST['customerMail']);
  if (!filter_var($customer->customerMail, FILTER_VALIDATE_EMAIL)) {
    $validate = 0;
    echo '<script>alert("Please input valid email");</script>';
  }
  $customer->psw = test_input($_POST['psw']);
  if ($customer->login()) {
    echo '<script>alert("logged in successfuly");</script>';
    header("refresh:0; url=index.php");
  } else {
    echo '<script>alert("Wrong email or password");</script>';
  }
}


?>
<form class="modal-content" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
  <div class="container">
    <label for="customerMail"><b>email</b></label>
    <input type="text" placeholder="Enter email" name="customerMail" required>
    <label for="psw"><b>password</b></label>
    <input type="password" placeholder="Enter psw" name="psw" required>
    <div class="clearfix">
      <input type="submit" class="greenbtn" value="Login"><a href="index.php" class="cancelbtn">cancel</a>
    </div>
  </div>
</form>
<?php include 'footer.php' ?>