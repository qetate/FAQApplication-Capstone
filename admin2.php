<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Admin 2 Panel</title>
    
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <h1>Admin 2 Panel</h1>
    </header>

    <main>
        <!-- Section for displaying unapproved questions -->
        <section id="unapprovedQuestionsSection">
            <h2>Unapproved Questions</h2>
            
            <!-- Form for approving questions -->
            <form id="approveQuestionsForm" action="" method="POST">
            <?php
                session_start();

                // Check if the user is logged in and is an Admin 2
                if (!isset($_SESSION['user_email']) || $_SESSION['user_type'] !== 'ADMIN2') {
                    header("Location: /login2.php");
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

                    // Process form submission
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        // Process approved questions
                        if (isset($_POST['questions']) && is_array($_POST['questions'])) {
                            foreach ($_POST['questions'] as $questionId => $action) {
                                if ($action == 'approve') {
                                    // Prepare an SQL statement to update the approved status of the question
                                    $updateStmt = $pdo->prepare("UPDATE QuestionsAnswers SET approved = 1 WHERE id = :id AND approved = 0");
                                    // Bind the question ID to the SQL statement
                                    $updateStmt->bindParam(':id', $questionId);
                                    // Execute the SQL statement
                                    $updateStmt->execute();
                                }
                            }
                        }
                    }

                    // Fetch unapproved questions from the database
                    $stmt = $pdo->query("SELECT * FROM QuestionsAnswers WHERE approved = 0 AND answer != 'pending'");

                    // Check if there are unapproved questions
                    if ($stmt->rowCount() == 0) {
                        echo "<p>No questions to approve.</p>";
                    } else {
                        // Loop through each fetched row
                        while ($row = $stmt->fetch()) {
                            // Display each unapproved question with a radio button for approval
                            echo "<div>";
                            echo "<input type='radio' id='question{$row['id']}' name='questions[{$row['id']}]' value='approve'>";
                            echo "<label for='question{$row['id']}'>{$row['question']}</label>";
                            echo "<p>{$row['answer']}</p>";
                            echo "</div>";
                        }
                    }
                } catch (PDOException $e) {
                    echo 'Error: ' . $e->getMessage();
                }
                ?>
                <!-- Button to submit the form -->
                <button type="submit">Submit</button>
            </form>
        </section>
    </main>
</body>

</html>