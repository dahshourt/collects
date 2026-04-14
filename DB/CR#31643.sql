CREATE TABLE IF NOT EXISTS roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    number  int,
    role VARCHAR (50) NOT NULL
    );
	

insert into roles(number,role) VALUES(1,"admin");
insert into roles(number,role) VALUES(2,"user");
