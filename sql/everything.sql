DROP DATABASE IF EXISTS final_plus;
CREATE DATABASE final_plus;
USE final_plus;

CREATE TABLE login(
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(12) UNIQUE,
    password TINYTEXT,
    is_admin TINYINT(1)
);

CREATE TABLE admin(
    admin_id INT PRIMARY KEY REFERENCES login(user_id),
    fullname TINYTEXT,
    email TINYTEXT,
    phone TINYTEXT,
    company TINYTEXT
);

CREATE TABLE job(
    job_id INT AUTO_INCREMENT PRIMARY KEY,
    job_title TINYTEXT
);

CREATE TABLE employee(
    employee_id INT PRIMARY KEY REFERENCES login(user_id),
    fullname TINYTEXT,
    email TINYTEXT,
    phone TINYTEXT,
    job_id INT REFERENCES job(job_id) ON DELETE CASCADE ON UPDATE CASCADE,
    manager_id INT REFERENCES admin(admin_id) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE day(
    day_id INT PRIMARY KEY,
    day_name TINYTEXT
);

CREATE TABLE shift(
    shift_id INT PRIMARY KEY,
    shift_name TINYTEXT
);

CREATE TABLE availability(
    employee_id INT REFERENCES employee ON DELETE CASCADE,
    day_id INT REFERENCES day ON DELETE CASCADE,
    shift_id INT REFERENCES shift ON DELETE CASCADE,
    PRIMARY KEY (employee_id, day_id, shift_id)
);

CREATE TABLE assignment(
    assignment_id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT REFERENCES employee ON DELETE CASCADE,
    date DATE,
    shift_id INT REFERENCES shift ON DELETE CASCADE
);

INSERT INTO day VALUES(1, 'Monday');
INSERT INTO day VALUES(2, 'Tuesday');
INSERT INTO day VALUES(3, 'Wednesday');
INSERT INTO day VALUES(4, 'Thursday');
INSERT INTO day VALUES(5, 'Friday');
INSERT INTO day VALUES(6, 'Saturday');
INSERT INTO day VALUES(7, 'Sunday');

INSERT INTO shift VALUES (1, 'Morning');
INSERT INTO shift VALUES (2, 'Evening');
INSERT INTO shift VALUES (3, 'Night');

INSERT INTO job(job_title) VALUES ('Cashier');
INSERT INTO job(job_title) VALUES ('Sweeper');
INSERT INTO job(job_title) VALUES ('Loader');

