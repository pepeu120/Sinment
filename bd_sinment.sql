create database sinment;
use sinment;
CREATE TABLE user (
	id INT UNSIGNED AUTO_INCREMENT,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(60),
    email VARCHAR(60) NOT NULL UNIQUE,
    password varchar(255) NOT NULL,
    PRIMARY KEY (ID)    
);

CREATE TABLE post (
    id INT UNSIGNED AUTO_INCREMENT ,
    user_id INT(6) UNSIGNED,
    caption VARCHAR(255),
    image_path VARCHAR(255),
    posting_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES user(id)
		ON DELETE CASCADE
);

CREATE USER 'pepeu'@'localhost' IDENTIFIED BY 'pepeu';
GRANT ALL PRIVILEGES ON sinment.* TO 'pepeu'@'localhost';
