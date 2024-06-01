<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Admin 1 Panel</title>
    
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <header>
        <h1>Admin 1 Panel</h1>
    </header>

    <main>
        <!-- Section for handling unapproved questions -->
        <section id="unapprovedQuestionsSection">
            <h2>Answer Questions</h2>
            
            <!-- Form for submitting answers to questions -->
            <form id="approveQuestionsForm" action="admin1.php" method="POST">
            <?php
                session_start();

                // Check if the user is logged in and is an Admin 1
                if (!isset($_SESSION['user_email']) || $_SESSION['user_type'] !== 'ADMIN1') {
                    header("Location: /login1.php");
                    exit();
                }

                // Database connection parameters
                $host = "localhost";
                $username = "root";
                $password = "";
                $database = "faq";

                try {
                    // Establish database connection
                    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Check if the form is submitted with an answer and question ID
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['answer']) && isset($_POST['id'])) {
                        // Prepare an SQL statement to update the answer in the database
                        $stmt = $pdo->prepare("UPDATE QuestionsAnswers SET answer = :answer WHERE id = :id");
                        // Bind the form values to the SQL statement
                        $stmt->bindParam(':answer', $_POST['answer']);
                        $stmt->bindParam(':id', $_POST['id']);
                        // Execute the SQL statement
                        $stmt->execute();

                        // Check if the update was successful
                        if ($stmt->rowCount() > 0) {
                            echo "Answer submitted successfully!";
                        } else {
                            echo "Failed to update answer.";
                        }
                    }

                    // Fetch unapproved questions from the database
                    $stmt = $pdo->query("SELECT * FROM QuestionsAnswers WHERE answer = 'pending' ");
                    // Check if there are no unapproved questions
                    if ($stmt->rowCount() == 0) {
                        echo "<p>No questions left to answer.</p>";
                    } else {
                        // Loop through each unapproved question and display it with a form to submit an answer
                        while ($row = $stmt->fetch()) {
                            echo "<div>";
                            echo "<p><strong>Question:</strong> {$row['question']}</p>";
                            echo "<form action='' method='POST'>";
                            echo "<input type='hidden' name='id' value='{$row['id']}'>";
                            echo "<textarea name='answer' placeholder='Enter your answer...' required></textarea>";
                            echo "<button type='submit'>Submit Answer</button>";
                            echo "</form>";
                            echo "</div>";
                        }
                    }
                } catch (PDOException $e) {
                    echo 'Error: ' . $e->getMessage();
                }
                ?>
            </form>
        </section>
    </main>
</body>

</html>