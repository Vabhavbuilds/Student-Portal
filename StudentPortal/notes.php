<?php

require_once "config/database.php";

$result = $conn->query("SELECT * FROM subjects ORDER BY id ASC");

$selected_subject = null;
$notes_result = null;

if (isset($_GET["subject"])) {

    $subject_id = (int) $_GET["subject"];

    $stmt = $conn->prepare(
        "SELECT * FROM subjects WHERE id = ?"
    );

    $stmt->bind_param("i", $subject_id);
    $stmt->execute();

    $selected_subject = $stmt->get_result()->fetch_assoc();

    $stmt->close();

    $notes_stmt = $conn->prepare(
        "SELECT * FROM notes WHERE subject_id = ? ORDER BY id DESC"
    );

    $notes_stmt->bind_param("i", $subject_id);
    $notes_stmt->execute();

    $notes_result = $notes_stmt->get_result();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Notes - S.S.S Technical Night College</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6fb;
            color: #222;
        }

        header {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            padding: 20px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo h1 {
            margin: 0;
            font-size: 24px;
        }

        .logo p {
            margin: 5px 0 0;
            font-size: 13px;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: bold;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .title {
            text-align: center;
            margin-bottom: 35px;
        }

        .title h2 {
            font-size: 32px;
            margin-bottom: 8px;
        }

        .title p {
            color: #666;
        }

        .subjects {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .subject-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }

        .subject-card h3 {
            color: #4f46e5;
            margin-top: 0;
        }

        .subject-card p {
            color: #666;
        }

        .button {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 18px;
            background: #4f46e5;
            color: white;
            text-decoration: none;
            border-radius: 8px;
        }

        .button:hover {
            background: #3730a3;
        }

        .notes-section {
            margin-top: 40px;
        }

        .note-card {
            background: white;
            padding: 20px;
            margin-top: 15px;
            border-radius: 12px;
            box-shadow: 0 5px 18px rgba(0,0,0,0.08);
        }

        .note-card h3 {
            margin: 0;
            color: #4f46e5;
        }

        .no-data {
            text-align: center;
            background: white;
            padding: 30px;
            border-radius: 12px;
        }

        @media (max-width: 700px) {

            header {
                padding: 20px;
                flex-direction: column;
                gap: 15px;
            }

            nav a {
                margin: 0 7px;
            }

            .subjects {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>

<body>

<header>

    <div class="logo">

        <h1>CampusSphere</h1>

        <p>S.S.S Technical Night College</p>

    </div>

    <nav>

        <a href="index.php">Home</a>
        <a href="notes.php">Notes</a>
        <a href="papers.php">Papers</a>
        <a href="login.php">Login</a>

    </nav>

</header>


<div class="container">

    <div class="title">

        <h2>📚 TY B.Sc. Computer Science Notes</h2>

        <p>Select a subject to access study material.</p>

    </div>


    <div class="subjects">

        <?php

        if ($result && $result->num_rows > 0) {

            while ($subject = $result->fetch_assoc()) {

        ?>

                <div class="subject-card">

                    <h3>
                        <?php echo htmlspecialchars($subject["subject_name"]); ?>
                    </h3>

                    <p>
                        TY B.Sc. Computer Science
                    </p>

                    <a
                        class="button"
                        href="notes.php?subject=<?php echo $subject["id"]; ?>"
                    >
                        View Notes
                    </a>

                </div>

        <?php

            }

        } else {

        ?>

            <div class="no-data">

                <h3>No subjects found</h3>

                <p>Please add subjects in the database.</p>

            </div>

        <?php

        }

        ?>

    </div>


    <?php if ($selected_subject) { ?>

        <div class="notes-section">

            <h2>
                Notes for
                <?php echo htmlspecialchars($selected_subject["subject_name"]); ?>
            </h2>


            <?php if ($notes_result && $notes_result->num_rows > 0) { ?>

                <?php while ($note = $notes_result->fetch_assoc()) { ?>

                    <div class="note-card">

                        <h3>
                            <?php echo htmlspecialchars($note["title"]); ?>
                        </h3>

                        <a
                            class="button"
                            href="uploads/notes/<?php echo rawurlencode($note["file_name"]); ?>"
                            target="_blank"
                        >
                            Open Note
                        </a>

                    </div>

                <?php } ?>

            <?php } else { ?>

                <div class="no-data">

                    <h3>No notes available</h3>

                    <p>No notes have been uploaded for this subject yet.</p>

                </div>

            <?php } ?>

        </div>

    <?php } ?>


</div>

</body>

</html>