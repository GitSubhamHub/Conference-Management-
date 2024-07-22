<?php
include 'autoloadClass.php';
$pagetitle = "Author Login page";
include 'header.php';

$user = new User();
function test_input($inputs)
{
  $inputs = trim($inputs);
  $inputs = stripslashes($inputs);
  $inputs = htmlspecialchars($inputs);
  return $inputs;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $validate = 1;
  $user->email = test_input($_POST['email']);
  if (!filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
    $validate = 0;
    echo '<script>alert("Please input valid email");</script>';
  }
  $user->psw = test_input($_POST['psw']);
  if ($user->login()) {
    echo '<script>alert("logged in successfuly");</script>';
    header("refresh:0; url=index.php");
  } else {
    echo '<script>alert("Wrong email or password");</script>';
  }
}


?>
<form class="modal-content" action="login.php" method="post">
  <div class="container">
    <label for="email"><b>email</b></label>
    <input type="text" placeholder="Enter email" name="email" required>
    <label for="psw"><b>password</b></label>
    <input type="password" placeholder="Enter psw" name="psw" required>
    <div class="clearfix">
      <input type="submit" class="greenbtn" value="Login"><a href="index.php" class="cancelbtn">cancel</a>
    </div>
  </div>
</form>
<?php include 'footer.php' ?>