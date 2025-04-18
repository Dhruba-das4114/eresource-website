<?php
include 'db_connection.php';

// Fetch subjects for Subject 11 page (Adjust IDs as per database)
$sql_subjects = "SELECT * FROM subjects WHERE id IN (20, 21)"; // Adjust subject IDs accordingly
$result_subjects = $conn->query($sql_subjects);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject Information</title>
    <link rel="stylesheet" href="sub11.css">
</head>
<body>
    <h1>Subject Information</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Subject</th>
                <th>Subject Code</th>
                <th>Previous Year Question Paper</th>
                <th>E-book</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result_subjects->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row["subject_name"]); ?></td>
                    <td><?php echo htmlspecialchars($row["subject_code"]); ?></td>
                    <td>
                        <div class="previous-year-dropdown">
                            <div class="previous-year-dropdown-content">
                                <?php
                                $subject_id = $row["id"];
                                $sql_papers = "SELECT * FROM pdf_files WHERE subject_id = $subject_id AND file_type = 'question_paper' ORDER BY year DESC";
                                $result_papers = $conn->query($sql_papers);
                                
                                if ($result_papers->num_rows > 0) {
                                    while ($paper = $result_papers->fetch_assoc()) {
                                        echo '<a href="' . htmlspecialchars($paper["file_path"]) . '" target="_blank" download>' . htmlspecialchars($paper["year"]) . '</a><br>';
                                    }
                                } else {
                                    echo "No Papers Available";
                                }
                                ?>
                            </div>
                        </div>
                    </td>
                    <td>
                        <?php
                        $sql_ebook = "SELECT * FROM pdf_files WHERE subject_id = $subject_id AND file_type = 'ebook' LIMIT 1";
                        $result_ebook = $conn->query($sql_ebook);
                        
                        if ($ebook = $result_ebook->fetch_assoc()) {
                            echo '<a href="' . htmlspecialchars($ebook["file_path"]) . '" target="_blank" download>Download</a>';
                        } else {
                            echo "No E-book Available";
                        }
                        ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close();
?>
