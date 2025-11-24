<?php
// Get DB credentials from environment variables
$db_host = getenv('DB_HOST');
$db_user = getenv('DB_USER');
$db_pass = getenv('DB_PASS');
$db_name = getenv('DB_NAME');

// Connect to RDS
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create table if not exists
$conn->query("CREATE TABLE IF NOT EXISTS visitors (id INT AUTO_INCREMENT PRIMARY KEY, visited_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");

// Insert visitor
$conn->query("INSERT INTO visitors () VALUES ()");

// Get visitor count
$result = $conn->query("SELECT COUNT(*) as total FROM visitors");
$row = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Test Web App</title>
</head>
<body>
    <h1>Test Web Application</h1>
    <p>Connected to database: <?php echo $db_name; ?></p>
    <p>Total visits: <?php echo $row['total']; ?></p>
    <p>Server: <?php echo gethostname(); ?></p>
</body>
</html>
