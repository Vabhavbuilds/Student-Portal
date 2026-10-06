<?php

require_once "config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $subject_id = $_POST["subject_id"];
    $title = trim($_POST["title"]);

    if (empty($subject_id) || empty($title) || !isset($_FILES["paper_file"])) {

        $message = "Please fill all fields.";

    } else {

        $file = $_FILES["paper_file"];

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

            $upload_path = "uploads/papers/" . $new_name;

            if (move_uploaded_file($file["tmp_name"], $upload_path)) {

                $stmt = $conn->prepare(
                    "INSERT INTO question_papers (subject_id, title, file_name)
                     VALUES (?, ?, ?)"
                );

                $stmt->bind_param(
                    "iss",
                    $subject_id,
                    $title,
                    $new_name
                );

                if ($stmt->execute()) {

                    $message = "Question paper uploaded successfully!";

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
<html>
<head>

    <title>Upload Question Paper</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            padding: 40px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
        }

        h1 {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input,
        select {
            width: 100%;
            padding: 11px;
            box-sizing: border-box;
        }

        button {
            margin-top: 20px;
            padding: 12px 20px;
            background: #4f46e5;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .message {
            margin-bottom: 15px;
            padding: 10px;
            background: #e8f5e9;
        }

    </style>

</head>

<body>

<div class="container">

    <h1>Upload Question Paper</h1>

    <?php if (!empty($message)) { ?>

        <div class="message">
            <?php echo htmlspecialchars($message); ?>
        </div>

    <?php } ?>

    <form method="POST" enctype="multipart/form-data">

        <label>Select Subject</label>

        <select name="subject_id" required>

            <option value="">-- Select Subject --</option>

            <?php while ($subject = $subjects->fetch_assoc()) { ?>

                <option value="<?php echo $subject["id"]; ?>">
                    <?php echo htmlspecialchars($subject["subject_name"]); ?>
                </option>

            <?php } ?>

        </select>


        <label>Paper Title</label>

        <input
            type="text"
            name="title"
            placeholder="Example: Artificial Intelligence 2025"
            required
        >


        <label>Select Question Paper</label>

        <input
            type="file"
            name="paper_file"
            accept=".pdf,.doc,.docx"
            required
        >


        <button type="submit">
            Upload Question Paper
        </button>

    </form>

</div>

</body>
</html>