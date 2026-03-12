<?php
include 'db.php';

if (isset($_POST['add'])) {
    $name     = mysqli_real_escape_string($conn, $_POST['name']);
    $abstract = mysqli_real_escape_string($conn, $_POST['abstract']);
    $res = mysqli_query($conn, "SELECT MAX(ArticleID)+1 FROM Article");
    $row = mysqli_fetch_row($res);
    $id  = $row[0] ?? 1;
    $result = mysqli_query($conn, "INSERT INTO Article (ArticleID, Name, Abstract) VALUES ($id, '$name', '$abstract')");
    if ($result) echo "<p style='color:green'>Article added!</p>";
    else echo "<p style='color:red'>Error: " . mysqli_error($conn) . "</p>";
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $result = mysqli_query($conn, "DELETE FROM Article WHERE ArticleID = $id");
    if ($result) echo "<p style='color:red'>Article deleted.</p>";
    else echo "<p style='color:red'>Cannot delete — this article has figures linked to it.</p>";
}

$result = mysqli_query($conn, "SELECT * FROM Article ORDER BY ArticleID");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Articles</title>
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
    <h2>Articles</h2>

    <form method="POST">
        <b>Add New Article:</b><br><br>
        Title: <input type="text" name="name" required style="width:300px;">
        <br><br>
        Abstract: <textarea name="abstract"></textarea>
        <br><br>
        <input type="submit" name="add" value="Add Article">
    </form>

    <table>
        <tr>
            <th>ArticleID</th>
            <th>Title</th>
            <th>Abstract</th>
            <th>Delete</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['ArticleID']; ?></td>
            <td><?php echo htmlspecialchars($row['Name']); ?></td>
            <td style="font-size:13px; color:#555;"><?php echo htmlspecialchars($row['Abstract']); ?></td>
            <td><a style="color:red;" href="?delete=<?php echo $row['ArticleID']; ?>"
                   onclick="return confirm('Delete?')">Delete</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
