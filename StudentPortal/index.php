<?php
require_once "config/database.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>S.S.S Technical Night College - Student Portal</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
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
            font-size: 24px;
        }

        .logo p {
            font-size: 13px;
            margin-top: 5px;
            opacity: 0.9;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-left: 25px;
            font-weight: bold;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .hero {
            padding: 70px 50px;
            background: white;
            text-align: center;
        }

        .hero h2 {
            font-size: 42px;
            color: #4f46e5;
            margin-bottom: 15px;
        }

        .hero p {
            font-size: 18px;
            color: #666;
            max-width: 700px;
            margin: auto;
            line-height: 1.6;
        }

        .hero button {
            margin-top: 25px;
            padding: 13px 25px;
            border: none;
            border-radius: 8px;
            background: #4f46e5;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .hero button:hover {
            background: #3730a3;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 40px auto;
        }

        .section-title {
            text-align: center;
            margin-bottom: 30px;
        }

        .section-title h2 {
            font-size: 30px;
            color: #333;
        }

        .section-title p {
            color: #777;
            margin-top: 8px;
        }

        .year-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .year-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: 0.3s;
        }

        .year-card:hover {
            transform: translateY(-5px);
        }

        .year-card .icon {
            font-size: 45px;
            margin-bottom: 15px;
        }

        .year-card h3 {
            color: #4f46e5;
            margin-bottom: 10px;
        }

        .year-card p {
            color: #666;
            line-height: 1.5;
        }

        .subjects {
            margin-top: 50px;
        }

        .subject-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .subject-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            border-left: 5px solid #4f46e5;
            box-shadow: 0 3px 12px rgba(0,0,0,0.06);
        }

        .subject-card h3 {
            color: #333;
            margin-bottom: 8px;
        }

        .subject-card p {
            color: #777;
            font-size: 14px;
        }

        .quick-links {
            margin-top: 50px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .quick-card {
            background: white;
            padding: 25px;
            text-align: center;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.06);
        }

        .quick-card .icon {
            font-size: 35px;
            margin-bottom: 10px;
        }

        .quick-card h3 {
            font-size: 17px;
            margin-bottom: 5px;
        }

        .quick-card p {
            font-size: 13px;
            color: #777;
        }

        footer {
            margin-top: 60px;
            background: #171717;
            color: white;
            text-align: center;
            padding: 25px;
        }

        footer p {
            margin: 5px;
            color: #bbb;
            font-size: 13px;
        }

        @media (max-width: 900px) {

            .year-container {
                grid-template-columns: 1fr;
            }

            .quick-links {
                grid-template-columns: repeat(2, 1fr);
            }

            header {
                padding: 20px;
            }

            nav {
                display: none;
            }
        }

        @media (max-width: 600px) {

            .hero {
                padding: 50px 20px;
            }

            .hero h2 {
                font-size: 30px;
            }

            .subject-container {
                grid-template-columns: 1fr;
            }

            .quick-links {
                grid-template-columns: 1fr;
            }

            .container {
                width: 94%;
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
    <a href="practicals.php">Practicals</a>
    <a href="login.php">Login</a>
</nav>

</header>


<section class="hero">

    <h2>Student Portal</h2>

    <p>
        Welcome to the S.S.S Technical Night College
        B.Sc. Computer Science Student Portal.
        Access notes, question papers, practicals and
        useful study resources in one place.
    </p>

    <button onclick="document.getElementById('subjects').scrollIntoView()">
        Explore Subjects
    </button>

</section>


<div class="container">

    <div class="section-title">

        <h2>Choose Your Year</h2>

        <p>
            Select your academic year to find study material.
        </p>

    </div>


    <div class="year-container">

        <div class="year-card">

            <div class="icon">🌱</div>

            <h3>FY B.Sc. CS</h3>

            <p>
                First year study material,
                programming and computer fundamentals.
            </p>

        </div>


        <div class="year-card">

            <div class="icon">🚀</div>

            <h3>SY B.Sc. CS</h3>

            <p>
                Core computer science subjects,
                programming, DBMS and networking.
            </p>

        </div>


        <div class="year-card">

            <div class="icon">🏆</div>

            <h3>TY B.Sc. CS</h3>

            <p>
                Advanced subjects, practicals,
                projects and examination preparation.
            </p>

        </div>

    </div>


    <div class="subjects" id="subjects">

        <div class="section-title">

            <h2>TY B.Sc. Computer Science</h2>

            <p>
                Your final year subjects
            </p>

        </div>


        <div class="subject-container">

            <div class="subject-card">
                <h3>🤖 Artificial Intelligence</h3>
                <p>Notes, important questions and study material.</p>
            </div>

            <div class="subject-card">
                <h3>🔐 Cyber Security</h3>
                <p>Cyber security concepts and examination material.</p>
            </div>

            <div class="subject-card">
                <h3>⚖️ Ethical AI</h3>
                <p>Ethical AI concepts, notes and important topics.</p>
            </div>

            <div class="subject-card">
                <h3>📚 IKS</h3>
                <p>Indian Knowledge System study material.</p>
            </div>

            <div class="subject-card">
                <h3>📡 WSN</h3>
                <p>Wireless Sensor Networks notes and resources.</p>
            </div>

            <div class="subject-card">
                <h3>🛡️ Ethical Hacking</h3>
                <p>Ethical hacking concepts and practical resources.</p>
            </div>

            <div class="subject-card">
                <h3>🏆 Project</h3>
                <p>Project documentation and viva preparation material.</p>
            </div>

        </div>

    </div>


    <div class="section-title" style="margin-top:60px;">

        <h2>Quick Access</h2>

        <p>
            Everything you need for your studies.
        </p>

    </div>


    <div class="quick-links">

        <div class="quick-card">
            <div class="icon">📚</div>
            <h3>Study Notes</h3>
            <p>Subject-wise notes and material.</p>
        </div>

        <div class="quick-card">
            <div class="icon">📄</div>
            <h3>Question Papers</h3>
            <p>Previous year examination papers.</p>
        </div>

        <div class="quick-card">
            <div class="icon">💻</div>
            <h3>Practicals</h3>
            <p>Programs and practical preparation.</p>
        </div>

        <div class="quick-card">
            <div class="icon">⭐</div>
            <h3>Important Questions</h3>
            <p>Questions for exam preparation.</p>
        </div>

    </div>

</div>


<footer>

    <h3>S.S.S Technical Night College</h3>

    <p>B.Sc. Computer Science Student Portal</p>

    <p>CampusSphere • TY Project</p>

</footer>


</body>
</html>