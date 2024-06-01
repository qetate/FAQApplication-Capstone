USE faq;

-- Drop tables if they exist
DROP TABLE IF EXISTS questionsanswers;
DROP TABLE IF EXISTS Users;

-- Create Users table
CREATE TABLE Users (
    email VARCHAR(255) NOT NULL,
    password TEXT NOT NULL,
    user_type VARCHAR(24) NOT NULL,
    active BIT NOT NULL,
    PRIMARY KEY (email)
);

-- Insert data into Users table
INSERT INTO Users (email, password, user_type, active) VALUES 
('jwalsh@northeaststate.edu', MD5('Password1'), 'ADMIN', 1),
('jdoe@northeaststate.edu', MD5('Password1'), 'INSTRUCTOR', 1);

-- Create QuestionsAnswers table
CREATE TABLE QuestionsAnswers (
    id INT AUTO_INCREMENT NOT NULL,
    email VARCHAR(255) NOT NULL,
    question TEXT NOT NULL,
    question_date DATE NOT NULL,
    answer TEXT NOT NULL,
    answer_date DATE NOT NULL,
    approved BIT NOT NULL,
    active BIT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (email) REFERENCES Users(email)
);

-- Insert data into QuestionsAnswers table
INSERT INTO QuestionsAnswers (email, question, question_date, answer, answer_date, approved, active) VALUES 
('jdoe@northeaststate.edu', 'Question 1', '2024-01-01', 'Answer 1', '2024-02-01', 1, 1);