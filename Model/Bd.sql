use trabajotrans;
 
create table if not exists aficionado (
Id int (255) not null auto_increment primary key,
Name varchar (50) not null,
Pwd varchar (50) not null,
PwdCon varchar (50) not null,
Email varchar (75) not null,
Sport varchar (25) not null
);
 
create table if not exists promotor (
Id int (255) not null auto_increment primary key,
Name varchar (50) not null,
Pwd varchar (50) not null,
Email varchar (75) not null,
Direction varchar (150) not null,
CreditCard varchar (16) not null
);
 
create table if not exists evento (
Id int (255) not null auto_increment primary key,
Name varchar (50) not null,
Sport varchar (60) not null,
Date date not null,
Location varchar (100) not null,
Price decimal (10,2) not null,
Description text
);
 
-- Tabla de Entradas
create table if not exists entrada (
Id int (255) not null auto_increment primary key,
EventoId int (255) not null,
AficionadoId int (255) not null,
PurchaseDate date not null,
Quantity int (10) not null,
TotalPrice decimal (10,2) not null,
Status varchar (20) default 'pending',
foreign key (EventoId) references evento(Id),
foreign key (AficionadoId) references aficionado(Id)
);
 
-- Tabla de Noticias
create table if not exists noticia (
Id int (255) not null auto_increment primary key,
Title varchar (100) not null,
Content text not null,
PublishDate date not null,
Author varchar (50) not null,
Category varchar (30) not null,
ImageUrl varchar (200)
);
 
-- Tabla de Compras
create table if not exists compra (
Id int (255) not null auto_increment primary key,
AficionadoId int (255) not null,
EventoId int (255) not null,
CardNumber varchar (16) not null,
PurchaseDate datetime not null,
Quantity int not null,
TotalAmount decimal (10,2) not null,
Status varchar (20) default 'completed',
foreign key (AficionadoId) references aficionado(Id),
foreign key (EventoId) references evento(Id)
);
 
-- Tabla de Categorías de Eventos
create table if not exists categoria (
Id int (255) not null auto_increment primary key,
Name varchar (50) not null,
Description varchar (200)
);
 
create table if not exists Users (
Id int (255) not null auto_increment primary key,
Name varchar (50) not null,
Pwd varchar (50) not null,
Email varchar (100) not null  
);
 
-- Update password fields to support bcrypt hashes (60+ characters)
ALTER TABLE aficionado MODIFY COLUMN Pwd VARCHAR(255) NOT NULL;
ALTER TABLE aficionado MODIFY COLUMN PwdCon VARCHAR(255) NOT NULL;
ALTER TABLE promotor MODIFY COLUMN Pwd VARCHAR(255) NOT NULL;
ALTER TABLE Users MODIFY COLUMN Pwd VARCHAR(255) NOT NULL;
 
DELIMITER //
 
create procedure sp_comprovar_email (
    in p_email varchar(75),
    out p_existe boolean
)
begin
    select exists(
        select 1
        from aficionado
        where Email = p_email
    ) into p_existe;
end //
 
DELIMITER ;
 
 
SELECT *
FROM aficionado;
 
SELECT *
FROM promotor;
 
DELIMITER //
 
create procedure sp_comprovar_emailp (
    in p_email varchar(75),
    out p_existe boolean
)
begin
    select exists(
        select 1
        from promotor
        where Email = p_email
    ) into p_existe;
end //
 
DELIMITER ;
 
DELIMITER //
CREATE PROCEDURE sp_login(
    IN emailP varchar(50),
    OUT pwdP varchar(255)
)
BEGIN
    SELECT Pwd INTO pwdP
    FROM aficionado
    WHERE email = emailP;
END //
DELIMITER ;
 
DELIMITER //
CREATE PROCEDURE sp_loginp(
    IN emailP varchar(50),
    OUT pwdP varchar(255)
)
BEGIN
    SELECT Pwd INTO pwdP
    FROM promotor
    WHERE email = emailP;
END //
DELIMITER ;
 
-- Stored procedures for `evento` table (created from PHP controller migration)
DELIMITER //
 
CREATE PROCEDURE sp_create_event(
    IN p_Name VARCHAR(50),
    IN p_Sport VARCHAR(60),
    IN p_Date DATE,
    IN p_Location VARCHAR(100),
    IN p_Price DECIMAL(10,2),
    IN p_Description TEXT,
    OUT p_new_id INT
)
BEGIN
    INSERT INTO evento (Name, Sport, `Date`, Location, Price, Description)
    VALUES (p_Name, p_Sport, p_Date, p_Location, p_Price, p_Description);
    SET p_new_id = LAST_INSERT_ID();
END //
 
CREATE PROCEDURE sp_update_event(
    IN p_Id INT,
    IN p_Name VARCHAR(50),
    IN p_Sport VARCHAR(60),
    IN p_Date DATE,
    IN p_Location VARCHAR(100),
    IN p_Price DECIMAL(10,2),
    IN p_Description TEXT
)
BEGIN
    UPDATE evento
    SET Name = p_Name,
        Sport = p_Sport,
        `Date` = p_Date,
        Location = p_Location,
        Price = p_Price,
        Description = p_Description
    WHERE Id = p_Id;
END //
 
CREATE PROCEDURE sp_delete_event(IN p_Id INT)
BEGIN
    DELETE FROM evento WHERE Id = p_Id;
END //
 
CREATE PROCEDURE sp_get_event_by_id(IN p_Id INT)
BEGIN
    SELECT * FROM evento WHERE Id = p_Id;
END //
 
CREATE PROCEDURE sp_list_events()
BEGIN
    SELECT * FROM evento ORDER BY `Date` DESC, Id DESC;
END //
 
DELIMITER ;
 