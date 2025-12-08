<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
    <link rel="stylesheet" href="styles/main.css">
    <script src="scripts/main.js" defer></script>
</head>
<body>

<h1>Search Results</h1>
<a href="index.php">Return to Home Page</a>
<br><br>

<?php
$host = "localhost";
$user = "root";
$pass = "mysql";  // default AMPPS password
$db = "student_directory";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$lname = $_POST['lname'] ?? '';

$stmt = $conn->prepare("CALL search_students(?)");
$stmt->bind_param("s", $lname);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p>No students found.</p>";
} else {
    echo "<table>";
    echo "<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['firstName']) . "</td>";
        echo "<td>" . htmlspecialchars($row['lastName']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
}

$stmt->close();
$conn->close();
?>

</body>
</html>

<link rel="stylesheet" href="styles/main.css">
<script src="scripts/main.js" defer></script>
