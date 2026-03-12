<?php
include 'db.php';

if (isset($_POST['send'])) {
    $sender   = (int)$_POST['senderID'];
    $receiver = (int)$_POST['receiverID'];
    $content  = mysqli_real_escape_string($conn, $_POST['content']);
    $time     = date("Y-m-d H:i:s");
    $res = mysqli_query($conn, "SELECT MAX(MessageID)+1 FROM Message");
    $row = mysqli_fetch_row($res);
    $id  = $row[0] ?? 1;
    $result = mysqli_query($conn, "INSERT INTO Message (MessageID, SenderID, ReceiverID, Timestamp, Content) VALUES ($id, $sender, $receiver, '$time', '$content')");
    if ($result) echo "<p style='color:green'>Message sent!</p>";
    else echo "<p style='color:red'>Error: " . mysqli_error($conn) . "</p>";
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM Message WHERE MessageID = $id");
    echo "<p style='color:red'>Message deleted.</p>";
}

$result = mysqli_query($conn,
    "SELECT m.MessageID, s.Email AS SenderEmail, r.Email AS ReceiverEmail, m.Timestamp, m.Content
     FROM Message m
     JOIN RegisteredUser s ON m.SenderID = s.UserID
     JOIN RegisteredUser r ON m.ReceiverID = r.UserID
     ORDER BY m.Timestamp DESC");

$users  = mysqli_query($conn, "SELECT UserID, Email FROM RegisteredUser ORDER BY UserID");
$users2 = mysqli_query($conn, "SELECT UserID, Email FROM RegisteredUser ORDER BY UserID");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Messages</title>
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
    <h2>Messages</h2>

    <form method="POST">
        <b>Send a Message:</b><br><br>
        From: <select name="senderID">
            <?php while ($u = mysqli_fetch_assoc($users)): ?>
                <option value="<?php echo $u['UserID']; ?>">#<?php echo $u['UserID']; ?> — <?php echo $u['Email']; ?></option>
            <?php endwhile; ?>
        </select>
        &nbsp; To: <select name="receiverID">
            <?php while ($u = mysqli_fetch_assoc($users2)): ?>
                <option value="<?php echo $u['UserID']; ?>">#<?php echo $u['UserID']; ?> — <?php echo $u['Email']; ?></option>
            <?php endwhile; ?>
        </select>
        <br><br>
        Message: <textarea name="content" required></textarea>
        <br><br>
        <input type="submit" name="send" value="Send Message">
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>From</th>
            <th>To</th>
            <th>Timestamp</th>
            <th>Content</th>
            <th>Delete</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['MessageID']; ?></td>
            <td><?php echo $row['SenderEmail']; ?></td>
            <td><?php echo $row['ReceiverEmail']; ?></td>
            <td style="white-space:nowrap; font-size:13px;"><?php echo $row['Timestamp']; ?></td>
            <td style="font-size:13px;"><?php echo htmlspecialchars($row['Content']); ?></td>
            <td><a style="color:red;" href="?delete=<?php echo $row['MessageID']; ?>"
                   onclick="return confirm('Delete?')">Delete</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
