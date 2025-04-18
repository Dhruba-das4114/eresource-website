<?php
include 'db_connection.php';

// Fetch subject details
$sql_subjects = "SELECT * FROM subjects WHERE id = 40"; 
$result_subjects = $conn->query($sql_subjects);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject Information</title>
    <link rel="stylesheet" href="class11.css">
</head>
<body>
    <h1>Subject Information</h1>
    <table>
        <thead>
            <tr>
                <th>Subject</th>
                <th>Syllabus</th>
                <th>Previous Year Question Paper</th>
                <th>E-book</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result_subjects->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row["subject_name"]); ?></td>
                    <td>
                        <?php
                        // Fetch syllabus from newpdffiles table
                        $sql_syllabus = "SELECT * FROM newpdffiles WHERE subject_id = " . $row['id'] . " LIMIT 1";
                        $result_syllabus = $conn->query($sql_syllabus);

                        if ($result_syllabus->num_rows > 0) {
                            $syllabus = $result_syllabus->fetch_assoc();
                            $file_path = "uploads/" . htmlspecialchars($syllabus["file_name"]);

                            if (file_exists(__DIR__ . "/" . $file_path)) {
                                echo '<a href="' . $file_path . '" target="_blank">Download</a>'; // 🔥 Removed 'download'
                            } else {
                                echo "File Not Found!";
                            }
                        } else {
                            echo "No Syllabus Available";
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        // Fetch previous year question papers
                        $sql_papers = "SELECT * FROM pdf_files WHERE subject_id = " . $row['id'] . " AND file_type = 'question_paper' ORDER BY year DESC";
                        $result_papers = $conn->query($sql_papers);
                        
                        if ($result_papers->num_rows > 0) {
                            while ($paper = $result_papers->fetch_assoc()) {
                                $file_name = htmlspecialchars($paper["file_name"]); // Get file name from DB
                                $paper_path = "uploads/" . $file_name; // ✅ Corrected path
                                $full_path = __DIR__ . "/" . $paper_path; // ✅ Full server path for checking

                                // Debugging output
                                echo "<!-- Debug: Checking file at $full_path -->";

                                if (file_exists($full_path)) {
                                    echo '<a href="' . $paper_path . '" target="_blank" download>' . htmlspecialchars($paper["year"]) . '</a><br>';
                                } else {
                                    echo "❌ File Not Found for " . htmlspecialchars($paper["year"]) . " (Check: $full_path)<br>";
                                }
                            }
                        } else {
                            echo "No Papers Available";
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        // Fetch e-book from pdf_files table
                        $sql_ebook = "SELECT * FROM pdf_files WHERE subject_id = " . $row['id'] . " AND file_type = 'ebook' LIMIT 1";
                        $result_ebook = $conn->query($sql_ebook);
                        
                        if ($result_ebook->num_rows > 0) {
                            $ebook = $result_ebook->fetch_assoc();
                            $ebook_path = "pdf_files/" . htmlspecialchars($ebook["file_name"]);
                            
                            if (file_exists(__DIR__ . "/" . $ebook_path)) {
                                echo '<a href="' . $ebook_path . '" target="_blank" download>Download</a>';
                            } else {
                                echo "File Not Found!";
                            }
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
