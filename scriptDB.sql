CREATE DATABASE IF NOT EXISTS sistema_cotizaciones DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;
USE sistema_cotizaciones;
CREATE USER IF NOT EXISTS 'SC'@'%' IDENTIFIED BY 'SC';
GRANT ALL PRIVILEGES ON *.* TO 'SC'@'%' WITH GRANT OPTION;

CREATE TABLE IF NOT EXISTS user_type(
	id int not null primary key auto_increment,
    name varchar(50),
    description varchar(100)
);

CREATE TABLE IF NOT EXISTS user_detail(
	id int not null primary key auto_increment,
    name varchar(50),
    last_name varchar(50)
);

CREATE TABLE IF NOT EXISTS users(
	id int not null primary key auto_increment,
    user varchar(512),
    pass varchar(512),
    type_id int,
    detail_id int
);

CREATE TABLE IF NOT EXISTS items(
	id int not null primary key auto_increment,
	cust_id varchar(50),
	order_id varchar(50),
	catalog_number varchar(50),
	description varchar(256),
	stock int,
	uom varchar(25),
	sell_qty int,
	contract_price decimal(10,2),
	cook_division varchar(25),
	contract_id varchar(50),
	contract_desc varchar(256),
	price_expiration date,
	currency varchar(25),
	p_uom_sin_iva decimal(10,2),
	p_uom_con_iva decimal(10,2),
	individual_sin_iva decimal(10,2),
	individual_con_iva decimal(10,2),
	precio_lista_vta_min_sin_iva decimal(10,2),
	precio_lista_vta_min_con_iva decimal(10,2),
	vta_minima varchar(25),
	mb decimal(10,2),
	fob decimal(10,2),
	iva decimal(10,2),
	gtin varchar(50),
	image varchar(256),
	family varchar(128),
	sub_family_1 varchar(128),
	sub_family_2 varchar(128)
);

-- DEFAULT DATA
INSERT INTO user_type SET name = 'Administrador', description = '-';

INSERT INTO user_detail SET name = '-', last_name = '-';

INSERT INTO users SET user = '21232f297a57a5a743894a0e4a801fc3', pass = '21232f297a57a5a743894a0e4a801fc3', type_id = 1, detail_id = 1;