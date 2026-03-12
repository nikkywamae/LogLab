<?php
include 'db.php';

if (isset($_POST['add'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass  = mysqli_real_escape_string($conn, $_POST['password']);
    $res   = mysqli_query($conn, "SELECT MAX(UserID)+1 FROM RegisteredUser");
    $row   = mysqli_fetch_row($res);
    $id    = $row[0] ?? 1;
    mysqli_query($conn, "INSERT INTO RegisteredUser (UserID, Email, Password) VALUES ($id, '$email', '$pass')");
    echo "<p style='color:green'>User added!</p>";
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM RegisteredUser WHERE UserID = $id");
    echo "<p style='color:red'>User deleted.</p>";
}

$result = mysqli_query($conn, "SELECT * FROM RegisteredUser ORDER BY UserID");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registered Users</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar">
    <a class="site-title" href="index.php">LogLab</a>
    <a href="registered_users.php">Registered Users</a>
    <a href="publishers.php">Publishers</a>
    <a href="auditors.php">Auditors</a>
    <a href="articles.php">Articles</a>
    <a href="messages.php">Messages</a>
    <a href="sessions.php">Sessions</a>
</div>

<div class="container">
    <h2>Registered Users</h2>

    <form method="POST">
        <b>Add New User:</b><br><br>
        Email: <input type="email" name="email" required>
        &nbsp; Password: <input type="text" name="password" required>
        &nbsp; <input type="submit" name="add" value="Add User">
    </form>

    <table>
        <tr>
            <th>UserID</th>
            <th>Email</th>
            <th>Password</th>
            <th>Delete</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['UserID']; ?></td>
            <td><?php echo $row['Email']; ?></td>
            <td><?php echo $row['Password']; ?></td>
            <td><a style="color:red;" href="?delete=<?php echo $row['UserID']; ?>"
                   onclick="return confirm('Delete this user?')">Delete</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
