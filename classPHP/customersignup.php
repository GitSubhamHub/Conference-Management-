<?php
include 'autoloadClass.php';

$customer = new customer;

function test_input($inputs)
{
  $inputs = trim($inputs);
  $inputs = stripslashes($inputs);
  $inputs = htmlspecialchars($inputs);
  return $inputs;
}

$pagetitle = "Studdent signup page";
include 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $validate = true;
  $customer->customerName = test_input($_POST['fname']);
  // check if name only contains letters and whitespace
  if (!preg_match("/^[a-zA-Z-' ]*$/", $customer->customerName)) {
    $validate = false;
    echo '<script>alert("Please use letters and whitespaces in name");</script>';
    header("Refresh:0; url=signup.php");
  }
  $customer->customerMail = test_input($_POST['customerMail']);
  if (!filter_var($customer->customerMail, FILTER_VALIDATE_EMAIL)) {
    $validate = false;
    echo '<script>alert("Please input valid email");</script>';
  }
  $customer->psw = test_input($_POST['psw']);
  if (!$_POST['psw'] == $_POST['psw2']) {
    $validate = false;
  }

  if ($validate) {
    if ($customer->signup()) {
      echo '<script>alert("signedup successfuly please login now");</script>';
      header("refresh:0; url=login.php");
    } else {
      echo '<script>alert("email adress already registered!!!!");</script>';
    }
  }
}
?>
<form class="modal-content" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
  <div class="container">
    <h1>Sign Up</h1>
    <p>Please fill in this form to create an account.</p>
    <hr>
    <label for="fname"><b>Name</b></label>
    <input type="text" placeholder="Enter Name" name="fname" required>

    <label for="customerMail"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="customerMail" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>

    <label for="psw2"><b>Repeat Password</b></label>
    <input type="password" placeholder="Repeat Password" name="psw2" required>

    <div class="clearfix">
      <a href='index.php' class="cancelbtn">cancel</a>
      <input type="submit" class="greenbtn" value="signup">
    </div>
  </div>
</form>
<?php include 'footer.php'; ?>