DROP TABLE IF EXISTS people;
DROP TABLE IF EXISTS jobrole;

CREATE TABLE jobrole
(id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
name varchar(50) NOT NULL
) ENGINE=INNODB;

INSERT INTO jobrole (name)
VALUES
("Developer"),
("Project Manager");

CREATE TABLE people
(id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
firstname varchar(30) NOT NULL,
lastname varchar(30) NOT NULL,
email varchar(50) NOT NULL,
job_role INT(6) UNSIGNED NOT NULL,
FOREIGN KEY (job_role)
  REFERENCES jobrole(id)
) ENGINE=INNODB;

INSERT INTO people (firstname, lastname, email, job_role)
VALUES
("Jo", "Strummer", "mail+j+strummer@9xb.com", 1),
("Mick", "Jones", "mail+m+jones@9xb.com", 2),
("Pauline", "Black", "mail+p+black@9xb.com", 1),
("Topper", "Headon", "mail+t+headon@9xb.com", 1),
("Stuart", "Bradbury", "mail+s+bradbury@9xb.com", 1);

