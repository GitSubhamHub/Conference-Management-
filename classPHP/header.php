<?php
session_start();
include 'config/core.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $pagetitle; ?></title>
  <!-- bootstrap css stylesheet -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <!-- our custom css -->
  <link rel="stylesheet" href="lib/signupstyle.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="viewavailable.php">Join Conference</a>
        </li>
        <?php if (isset($_SESSION['uuid'])) {
          # code...
        ?>
          <li class="nav-item">
            <a class="nav-link" href="addbookjs.php">Create Conference</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="viewall.php">View All Conference</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="allorder.php">All Previous Member</a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" href="salestats.php"></a>
          </li> -->
          <!-- <li class="nav-item">
            <a class="nav-link" href="bookwise.php">Conference Wise Data</a>
          </li> -->
          <li class="nav-item">
            <a class="nav-link" href="userpage.php"><?php echo $_SESSION['firstname']; ?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">logout</a>
          </li>
        <?php
        } elseif (isset($_SESSION['customerId'])) {
        ?>

          <li class="nav-item">
            <a class="nav-link" href="viewissued.php">Leave Conference</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="previousissued.php">Previously Joined Conference</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="customerpage.php"><?php echo $_SESSION['customerName']; ?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">logout</a>
          </li>
        <?php
        } else {
        ?>

          <li class="nav-item">
            <a class="nav-link" href="login.php">Admin Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="signup.php">Admin Signup</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="customerlogin.php">Member Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="customersignup.php">Member Signup</a>
          </li>
        <?php
        }
        ?>

      </ul>
    </div>
  </nav>
  <div class="container">
    <h1><?php echo "$pagetitle"; ?></h1>