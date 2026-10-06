<?php

require_once "config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $subject_id = $_POST["subject_id"];
    $title = trim($_POST["title"]);

    if (empty($subject_id) || empty($title) || !isset($_FILES["note_file"])) {

        $message = "Please fill all fields.";

    } else {

        $file = $_FILES["note_file"];

        $allowed = ["pdf", "doc", "docx"];

        $extension = strtolower(
            pathinfo($file["name"], PATHINFO_EXTENSION)
        );

        if (!in_array($extension, $allowed)) {

            $message = "Only PDF, DOC and DOCX files are allowed.";

        } elseif ($file["error"] != 0) {

            $message = "File upload failed.";

        } else {

            $new_name = time() . "_" . basename($file["name"]);

            $upload_path = "uploads/notes/" . $new_name;

            if (move_uploaded_file($file["tmp_name"], $upload_path)) {

                $stmt = $conn->prepare(
                   "INSERT INTO notes (subject_id, title, file_name)
                     VALUES (?, ?, ?)"
                );

                $stmt->bind_param(
                    "iss",
                    $subject_id,
                    $title,
                   $new_name
                );

                if ($stmt->execute()) {

                    $message = "Note uploaded successfully!";

                } else {

                    $message = "Database error.";

                }

                $stmt->close();

            } else {

                $message = "Could not save the file.";

            }
        }
    }
}

$subjects = $conn->query(
    "SELECT id, subject_name FROM subjects ORDER BY id ASC"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Upload Notes</title>

</head>

<body>

<h2>Upload Study Notes</h2>

<?php if (!empty($message)) { ?>

    <p><?php echo htmlspecialchars($message); ?></p>

<?php } ?>

<form method="POST" enctype="multipart/form-data">

    <label>Subject:</label>

    <select name="subject_id" required>

        <option value="">Select Subject</option>

        <?php while ($subject = $subjects->fetch_assoc()) { ?>

            <option value="<?php echo $subject["id"]; ?>">

                <?php echo htmlspecialchars($subject["subject_name"]); ?>

            </option>

        <?php } ?>

    </select>

    <br><br>

    <label>Note Title:</label>

    <input type="text" name="title" required>

    <br><br>

    <label>Select File:</label>

    <input
        type="file"
        name="note_file"
        accept=".pdf,.doc,.docx"
        required
    >

    <br><br>

    <button type="submit">Upload Note</button>

</form>

</body>

</html>