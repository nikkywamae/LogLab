<?php
include 'db.php';

if (isset($_POST['add'])) {
    $uid   = (int)$_POST['userID'];
    $start = mysqli_real_escape_string($conn, str_replace("T", " ", $_POST['accessStart']) . ":00");
    $end   = $_POST['accessEnd'] ? "'" . mysqli_real_escape_string($conn, str_replace("T", " ", $_POST['accessEnd']) . ":00") . "'" : "NULL";
    $res = mysqli_query($conn, "SELECT MAX(AccessID)+1 FROM AccessSession");
    $row = mysqli_fetch_row($res);
    $id  = $row[0] ?? 1;
    $result = mysqli_query($conn, "INSERT INTO AccessSession (AccessID, UserID, AccessStart, AccessEnd) VALUES ($id, $uid, '$start', $end)");
    if ($result) echo "<p style='color:green'>Session added!</p>";
    else echo "<p style='color:red'>Error: " . mysqli_error($conn) . "</p>";
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM AccessSession WHERE AccessID = $id");
    echo "<p style='color:red'>Session deleted.</p>";
}

$result = mysqli_query($conn,
    "SELECT s.AccessID, s.UserID, ru.Email, s.AccessStart, s.AccessEnd
     FROM AccessSession s
     JOIN RegisteredUser ru ON s.UserID = ru.UserID
     ORDER BY s.AccessStart DESC");

$users = mysqli_query($conn, "SELECT UserID, Email FROM RegisteredUser ORDER BY UserID");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Access Sessions</title>
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
    <h2>Access Sessions</h2>

    <form method="POST">
        <b>Add New Session:</b><br><br>
        User: <select name="userID">
            <?php while ($u = mysqli_fetch_assoc($users)): ?>
                <option value="<?php echo $u['UserID']; ?>">#<?php echo $u['UserID']; ?> — <?php echo $u['Email']; ?></option>
            <?php endwhile; ?>
        </select>
        &nbsp; Start: <input type="datetime-local" name="accessStart" required>
        &nbsp; End (leave blank if still active): <input type="datetime-local" name="accessEnd">
        &nbsp; <input type="submit" name="add" value="Add Session">
    </form>

    <table>
        <tr>
            <th>AccessID</th>
            <th>UserID</th>
            <th>Email</th>
            <th>Access Start</th>
            <th>Access End</th>
            <th>Delete</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['AccessID']; ?></td>
            <td><?php echo $row['UserID']; ?></td>
            <td><?php echo $row['Email']; ?></td>
            <td><?php echo $row['AccessStart']; ?></td>
            <td><?php echo $row['AccessEnd'] ? $row['AccessEnd'] : '<b style="color:orange">Still Active</b>'; ?></td>
            <td><a style="color:red;" href="?delete=<?php echo $row['AccessID']; ?>"
                   onclick="return confirm('Delete?')">Delete</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
