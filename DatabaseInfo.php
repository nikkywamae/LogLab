<?php
$host = "fdb1032.awardspace.net";
$user = "4742192_loglab";
$pass = "Redhawks2026!";
$db   = "4742192_loglab";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
