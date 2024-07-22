<?php
$pagetitle = "Welcome to Conference Management System";
include 'header.php';
if (isset($_SESSION['uuid'])) {
    # code... 
?>
    <h3>You are loggedin</h3>
    <ul>
        <li>You can now manage conference</li>
        <li>navigate pages using navbar</li>
    </ul>
<?php
} else {
?>
    <h3>You can do following</h3>
    <ul>
        <li>Sign up and login  as a member</li>
        <li>Signup and login as Admin to create Conferences</li>
        <li>View your Conferences</li>
        <li>Manage your Conference</li>
        <li>logout</li>
    </ul>
<?php
}
include 'footer.php';
?>