# FAQ Application - Capstone

## Objective
This team project is a simple Question and Answer (Q&A) system designed for Northeast State to help facilitate efficient communication between the students and faculty. It allows users to submit questions, which can then be answered and approved by administrators. The system includes different panels for administrators to manage unapproved questions and user login functionality to access administrative features.

## Technologies Used
- **PHP**: Backend scripting language for server-side logic.
- **MySQL**: Relational database management system for storing user data, questions, and answers.
- **HTML/CSS**: Frontend development for user interfaces.
- **PDO (PHP Data Objects)**: PHP extension for interacting with the database.
- **Session Management**: Handling user authentication and maintaining session data.

## Skills Demonstrated
- **Frontend Development**: Developed HTML/CSS interfaces for user interaction.
- **Backend Development**: Utilized PHP for server-side logic and database interactions.
- **Database Management**: Designed and implemented a MySQL database schema for storing user data and questions.

## Database Structure
The project uses a MySQL database with two main tables:

1. **Users**: Contains user information including email, password, user type, and activation status.
2. **QuestionsAnswers**: Stores questions, answers, and their statuses.

## PHP Scripts

### 1. `login.php`
- Handles user authentication.
- Users log in with their email and password.
- Redirects users to different panels based on their user type.

### 2. `admin1.php` and `admin2.php`
- Admin panels for answering questions and approving them.
- Admins can view unapproved questions, submit answers, and approve questions for display.
- Questions are fetched from the database and displayed dynamically.

### 3. `index.php`
- Main page for users to search, submit, and view questions and answers.
- Includes sections for searching questions, submitting new questions, and displaying approved questions and answers.
