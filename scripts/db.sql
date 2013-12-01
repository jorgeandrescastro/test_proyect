CREATE TABLE users
(
id int NOT NULL AUTO_INCREMENT,
name varchar(255),
username varchar(255),
address varchar(255),
brithday varchar(12),
password varchar(32),
PRIMARY KEY(id)
);

CREATE TABLE messages
(
id int NOT NULL AUTO_INCREMENT,
from_id int,
to_id int,
message text,
date_sent TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY(id),
FOREIGN KEY (from_id) REFERENCES users(id),
FOREIGN KEY (to_id) REFERENCES users(id)
);
