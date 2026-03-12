<?php
include 'db.php';

if (isset($_POST['add'])) {
    $uid   = (int)$_POST['userID'];
    $fname = mysqli_real_escape_string($conn, $_POST['firstName']);
    $lname = mysqli_real_escape_string($conn, $_POST['lastName']);
    $photo = mysqli_real_escape_string($conn, $_POST['photo']);
    $result = mysqli_query($conn, "INSERT INTO Publisher (UserID, FirstName, LastName, Photo) VALUES ($uid, '$fname', '$lname', '$photo')");
    if ($result) echo "<p style='color:green'>Publisher added!</p>";
    else echo "<p style='color:red'>Error: " . mysqli_error($conn) . "</p>";
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM Publisher WHERE UserID = $id");
    echo "<p style='color:red'>Publisher deleted.</p>";
}

$result = mysqli_query($conn,
    "SELECT p.UserID, p.FirstName, p.LastName, p.Photo, ru.Email
     FROM Publisher p
     JOIN RegisteredUser ru ON p.UserID = ru.UserID
     ORDER BY p.UserID");

$users = mysqli_query($conn, "SELECT UserID, Email FROM RegisteredUser ORDER BY UserID");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Publishers</title>
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
    <h2>Publishers</h2>

    <form method="POST">
        <b>Add New Publisher:</b><br><br>
        User: <select name="userID">
            <?php while ($u = mysqli_fetch_assoc($users)): ?>
                <option value="<?php echo $u['UserID']; ?>">#<?php echo $u['UserID']; ?> — <?php echo $u['Email']; ?></option>
            <?php endwhile; ?>
        </select>
        &nbsp; First Name: <input type="text" name="firstName" required>
        &nbsp; Last Name: <input type="text" name="lastName" required>
        &nbsp; Photo: <input type="text" name="photo" placeholder="photos/name.jpg">
        &nbsp; <input type="submit" name="add" value="Add Publisher">
    </form>

    <table>
        <tr>
            <th>UserID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Photo</th>
            <th>Delete</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['UserID']; ?></td>
            <td><?php echo $row['FirstName']; ?></td>
            <td><?php echo $row['LastName']; ?></td>
            <td><?php echo $row['Email']; ?></td>
            <td><?php echo $row['Photo'] ? $row['Photo'] : 'NULL'; ?></td>
            <td><a style="color:red;" href="?delete=<?php echo $row['UserID']; ?>"
                   onclick="return confirm('Delete?')">Delete</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
