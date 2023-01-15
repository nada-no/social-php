-- DROP DATABASE IF EXISTS social;

-- CREATE DATABASE social;


use social;

CREATE TABLE users (
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(80) NOT NULL,
    pass VARCHAR(255) NOT NULL,
    datecreated TIMESTAMP,
    user_enabled TINYINT(1)
);

CREATE TABLE user_sessions (
    session_id VARCHAR(255) NOT NULL PRIMARY KEY,
    user_id INT(10) UNSIGNED NOT NULL,
    login_time timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE posts (
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    content VARCHAR(255) NOT NULL,
    date_posted TIMESTAMP,
    author INT(10) UNSIGNED NOT NULL,
    FOREIGN KEY (author) REFERENCES users(id)
);
