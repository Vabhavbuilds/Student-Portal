<?php

require_once "config/database.php";

$result = $conn->query("SELECT * FROM subjects ORDER BY id ASC");

$selected_subject = null;
$papers_result = null;

if (isset($_GET["subject"])) {

    $subject_id = (int) $_GET["subject"];

    $stmt = $conn->prepare(
        "SELECT * FROM subjects WHERE id = ?"
    );

    $stmt->bind_param("i", $subject_id);
    $stmt->execute();

    $selected_subject = $stmt->get_result()->fetch_assoc();

    $stmt->close();

    $papers_stmt = $conn->prepare(
        "SELECT * FROM question_papers WHERE subject_id = ? ORDER BY id DESC"
    );

    $papers_stmt->bind_param("i", $subject_id);
    $papers_stmt->execute();

    $papers_result = $papers_stmt->get_result();
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Question Papers - CampusSphere</title>

    <style>

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            color: #222;
        }

        header {
            background: #202040;
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            margin: 0;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .subjects {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        .card h3 {
            margin-top: 0;
        }

        .button {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 16px;
            background: #4f46e5;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        .papers-section {
            margin-top: 40px;
        }

        .paper {
            background: white;
            padding: 20px;
            margin-top: 15px;
            border-radius: 10px;
        }

        .no-data {
            background: white;
            padding: 25px;
            border-radius: 10px;
            margin-top: 20px;
        }

        @media(max-width: 800px) {
            .subjects {
                grid-template-columns: 1fr;
            }

            header {
                flex-direction: column;
                gap: 15px;
            }
        }

    </style>

</head>

<body>

<header>

    <h1>CampusSphere</h1>

    <nav>

        <a href="index.php">Home</a>

        <a href="notes.php">Notes</a>

        <a href="papers.php">Papers</a>

        <a href="login.php">Login</a>

    </nav>

</header>


<div class="container">

    <h2>Previous Year Question Papers</h2>

    <p>Select a subject to view available question papers.</p>


    <div class="subjects">

        <?php while ($subject = $result->fetch_assoc()) { ?>

            <div class="card">

                <h3>
                    <?php echo htmlspecialchars($subject["subject_name"]); ?>
                </h3>

                <p>
                    <?php echo htmlspecialchars($subject["description"]); ?>
                </p>

                <a
                    class="button"
                    href="papers.php?subject=<?php echo $subject["id"]; ?>"
                >
                    View Papers
                </a>

            </div>

        <?php } ?>

    </div>


    <?php if ($selected_subject) { ?>

        <div class="papers-section">

            <h2>
                Papers for
                <?php echo htmlspecialchars($selected_subject["subject_name"]); ?>
            </h2>


            <?php if ($papers_result && $papers_result->num_rows > 0) { ?>

                <?php while ($paper = $papers_result->fetch_assoc()) { ?>

                    <div class="paper">

                        <h3>
                            <?php echo htmlspecialchars($paper["title"]); ?>
                        </h3>

                        <a
                            class="button"
                            href="uploads/papers/<?php echo rawurlencode($paper["file_name"]); ?>"
                            target="_blank"
                        >
                            Download Paper
                        </a>

                    </div>

                <?php } ?>

            <?php } else { ?>

                <div class="no-data">

                    <h3>No question papers available</h3>

                    <p>
                        No papers have been uploaded for this subject yet.
                    </p>

                </div>

            <?php } ?>

        </div>

    <?php } ?>

</div>

</body>

</html>