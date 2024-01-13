# WebTech-GroupAssignment (Online Library) 
Insert welcome note here idk.
![unnamed](https://github.com/Noctilucent139/WebTech-GroupAssignment/assets/106331743/562afe26-996d-43bd-8a7d-dc3a7d012325)


Module
-----------------------------------------------------------------
User Authentication
- login
- register
- forgot password
- logout

Index
- about us 
- contact us (with its table for QnA)

Dashboard
- admin dashboard
- user dashboard

Admin Manage Users
- table management (with CRUD, add, edit, delete)

Admin Manage Books
- table management (with CRUD, add, edit, delete)

Book Library
- book index 
- borrow books process
- check book availability

User Profile
- proflie page
- proflie page edit

Return Book
- return book table
- return book process

-----------------------------------------------------------------

-- INITIALISE DATABASE 
-- COPYPASTE BELOW, tekan edit file dlu atau tekan code bru copypaste spaya ngam alignment
-- Create the online_library database
CREATE DATABASE IF NOT EXISTS online_library;

-- Switch to the online_library database
USE online_library;

-- Create user_information table
CREATE TABLE IF NOT EXISTS user_information (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(255) NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    user_state TINYINT NOT NULL DEFAULT 0 CHECK (user_state IN (0, 1))
);

-- Create book_information table
CREATE TABLE IF NOT EXISTS book_information (
    id INT AUTO_INCREMENT PRIMARY KEY,
    book_name VARCHAR(255) NOT NULL,
    book_page INT NOT NULL,
    book_detail TEXT NOT NULL,
    book_state TINYINT NOT NULL DEFAULT 0 CHECK (book_state IN (0, 1, 2)),
    username VARCHAR(50),
    date DATE,
    FOREIGN KEY (username) REFERENCES user_information(username)
);

-- Insert sample data into user_information
INSERT INTO user_information (fullname, username, email, password, user_state)
VALUES
    ('Admin User', 'admin', 'admin@example.com', 'admin_password', 1),
    ('Regular User', 'regular_user', 'user@example.com', 'user_password', 0);

-- Insert sample data into book_information
INSERT INTO book_information (book_name, book_page, book_detail, book_state)
VALUES
    ('Book 1', 200, 'Description for Book 1', 0),
    ('Book 2', 150, 'Description for Book 2', 0),
    ('Book 3', 300, 'Description for Book 3', 0),
    ('Book 4', 180, 'Description for Book 4', 0),
    ('Book 5', 220, 'Description for Book 5', 0),
    ('Book 6', 250, 'Description for Book 6', 0),
    ('Book 7', 170, 'Description for Book 7', 0),
    ('Book 8', 190, 'Description for Book 8', 0),
    ('Book 9', 320, 'Description for Book 9', 0),
    ('Book 10', 280, 'Description for Book 10', 0),
    ('Book 11', 240, 'Description for Book 11', 0),
    ('Book 12', 200, 'Description for Book 12', 0),
    ('Book 13', 180, 'Description for Book 13', 0),
    ('Book 14', 210, 'Description for Book 14', 0),
    ('Book 15', 250, 'Description for Book 15', 0);
    
-- Create table contact_form_submissions 
CREATE TABLE contact_form_submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    submission_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
