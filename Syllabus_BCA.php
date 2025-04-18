<?php
include 'db_connection.php'; // Include database connection

// Fetch BCA syllabus file path
$sql = "SELECT file_path FROM syllabus WHERE syllabus_name = 'BCA Syllabus' LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $file_path = $row['file_path']; // Relative path from database
    $absolute_path = $_SERVER['DOCUMENT_ROOT'] . $file_path; // Absolute path

    if (!file_exists($absolute_path)) {
        die("❌ Error: File not found!");
    }
} else {
    die("❌ Error: No syllabus found in the database!");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BCA Syllabus Preview</title>
    <style>
        body { margin: 0; padding: 0; background: #f8f9fa; display: flex; justify-content: center; align-items: center; height: 100vh; }
        iframe { width: 100vw; height: 100vh; border: none; }
    </style>
</head>
<body>

    <!-- PDF Preview -->
    <iframe src="<?php echo htmlspecialchars($file_path); ?>"></iframe>

</body>
</html>
