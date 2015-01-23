

CREATE DATABASE IF NOT EXISTS registration;
GRANT SELECT, INSERT, UPDATE, DELETE ON registration.* TO root@localhost IDENTIFIED BY 'root';
FLUSH PRIVILEGES;

USE registration;

CREATE TABLE IF NOT EXISTS user (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(50),
	password VARCHAR(255),
	created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
	)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS thread (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(255) NOT NULL,
	created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
	)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS comment (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	thread_id INT UNSIGNED NOT NULL, 
	body TEXT NOT NULL, 
	created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	INDEX (thread_id, created)
	)ENGINE=InnoDB;