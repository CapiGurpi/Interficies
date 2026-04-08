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
Sport varchar (60) not null
);

create table if not exists Users (
Id int (255) not null auto_increment primary key,
Name varchar (50) not null,
Pwd varchar (50) not null,
Email varchar (100) not null  
);

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
CREATE PROCEDURE sp_login(
	IN emailP varchar(50),
    IN passwordP varchar(100),
    OUT valido boolean
)
BEGIN
	SELECT EXISTS(
		SELECT *
        FROM aficionado
        WHERE email = emailP
        AND password = passwordP
	) INTO valido;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE sp_loginp(
	IN emailP varchar(50),
    IN passwordP varchar(100),
    OUT valido boolean
)
BEGIN
	SELECT EXISTS(
		SELECT *
        FROM promotor
        WHERE email = emailP
        AND password = passwordP
	) INTO valido;
END //
DELIMITER ;