<!DOCTYPE html>
<html>
<head>
    <title>LogLab</title>
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
    <h2>Welcome to LogLab</h2>
    <p>A web interface for the LogLab research publishing database. Click a section below to view or manage records.</p>

    <div class="card-grid">
        <a class="card" href="registered_users.php">
            <div class="card-icon">👤</div>
            <h3>Registered Users</h3>
            <p>View all users, add new accounts, delete records.</p>
        </a>
        <a class="card" href="publishers.php">
            <div class="card-icon">✍️</div>
            <h3>Publishers</h3>
            <p>View publishers and their profile details.</p>
        </a>
        <a class="card" href="auditors.php">
            <div class="card-icon">🔍</div>
            <h3>Auditors</h3>
            <p>View auditors and their employer information.</p>
        </a>
        <a class="card" href="articles.php">
            <div class="card-icon">📄</div>
            <h3>Articles</h3>
            <p>Browse articles, add new ones, manage the catalog.</p>
        </a>
        <a class="card" href="messages.php">
            <div class="card-icon">💬</div>
            <h3>Messages</h3>
            <p>View messages between users, send new messages.</p>
        </a>
        <a class="card" href="sessions.php">
            <div class="card-icon">🕐</div>
            <h3>Sessions</h3>
            <p>View login session records for registered users.</p>
        </a>
    </div>
</div>

<footer>LogLab Database Interface — CPSC Introduction to Databases</footer>
</body>
</html>
