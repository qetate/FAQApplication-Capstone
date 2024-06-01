<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Q&A</title>
    
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <header>
        <h1>Northeast State Q&A</h1>
        <br></br>
        <div id="loginLink">
            <a href="login.php">Admin Login</a>
        </div>
    </header>
    
    <main>
        <!-- Section for searching questions -->
        <section id="searchSubmitSection">
            <h2>Search Questions</h2>
            <!-- Search form -->
            <form id="searchSubmitForm" method="POST">
                <input type="text" id="searchInput" name="search" placeholder="Enter keywords:">
                <button type="submit">Search</button>
            </form>
            <!-- Search results display -->
            <div id="searchResults">
                <?php
                // Database connection variables
                $host = "localhost";
                $username = "root"; 
                $password = "";
                $database = "faq"; 

                try {
                    // Connect to database
                    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
                    
                    // Check if search form is submitted
                    if (isset($_POST['search'])) {
                        $searchInput = trim($_POST['search']);
                        if (!empty($searchInput)) {
                            // Prepare and execute SQL query for searching questions
                            $sqlSearch = "SELECT * FROM questionsanswers WHERE question LIKE :search OR answer LIKE :search";
                            $stmtSearch = $pdo->prepare($sqlSearch);
                            $stmtSearch->bindValue(':search', '%' . $searchInput . '%');
                            $stmtSearch->execute();
                            
                            // Display search results
                            echo "<h3>Search Results:</h3>";
                            while ($row = $stmtSearch->fetch()) {
                                echo "<p><strong>Question:</strong> " . $row['question'] . "<br><strong>Answer:</strong> " . $row['answer'] . "</p>";
                            }
                        } else {
                            echo "Please enter a search keyword.";
                        }
                    }
                } catch (PDOException $e) {
                    // Handle database connection errors
                    echo 'Error connecting to the database: ' . $e->getMessage();
                }
                ?>
            </div>
        </section>
        
        <!-- Section for submitting new questions -->
        <section id="submitQuestionSection">
            <h2>Submit a New Question</h2>
            <!-- Submit question form -->
            <form id="submitQuestionForm" action="index.php" method="POST">
                <textarea id="questionText" name="question" placeholder="Enter your question:" required></textarea>
                <button type="submit">Submit</button>
            </form>
        </section>
        <!-- Section for displaying approved questions and answers -->
        <section id="approvedQuestionsSection">
            <h2>Approved Questions and Answers</h2>
            <div>
                <?php
                try {
                    // Query to fetch approved questions and answers
                    $sqlApproved = "SELECT * FROM questionsanswers WHERE approved = 1";
                    $stmtApproved = $pdo->query($sqlApproved);
                    
                    // Display the questions and answers
                    while ($row = $stmtApproved->fetch()) {
                        echo "<div>";
                        // Capitalize first letter and add question mark to the question
                        $question = ucfirst($row['question']) . (substr(trim($row['question']), -1) !== '?' ? '?' : '');
                        echo "<p><strong>Question:</strong> {$question}</p>";
                        echo "<p><strong>Answer:</strong> {$row['answer']}</p>";
                        echo "</div>";
                    }
                } catch (PDOException $e) {
                    echo 'Error fetching approved questions and answers: ' . $e->getMessage();
                }
                ?>
            </div>
        </section>

    </main>
</body>
</html>