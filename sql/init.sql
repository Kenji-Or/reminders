CREATE TABLE users (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       email VARCHAR(255) NOT NULL UNIQUE,
                       password VARCHAR(255) NOT NULL,
                       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE reminders (
                           id INT AUTO_INCREMENT PRIMARY KEY,
                           user_id INT NOT NULL,
                           title VARCHAR(255) NOT NULL,
                           message TEXT,
                           context_type ENUM('time', 'frequency') DEFAULT 'time',
                           trigger_time TIME,
                           trigger_date DATE,
                           frequency ENUM('none','daily','weekly') DEFAULT 'none',
                           status ENUM('pending','triggered') DEFAULT 'pending',
                           last_checked_at TIMESTAMP NULL,
                           FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);