CREATE TABLE IF NOT EXISTS people(
	id int primary key not null auto_increment,
	name varchar(255),
	surname varchar(255),
	fiscal_code varchar(16),
	birth_date date
)ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS employees(
	id int primary key not null auto_increment,
	role varchar(255),
	identity int,
	foreign key (identity) references people(id)
)ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS teams(
	id int primary key not null auto_increment,
	name varchar(255),
	team_leader int,
	foreign key (team_leader) references employees(id)
)ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS projects(
	id int primary key not null auto_increment,
	name varchar(255) not null,
	start_date date,
	description text,
	last_update timestamp,
	budget int,
	project_state enum('On Going', 'Completed', 'Closed'),
	team int,
	foreign key (team) references teams(id)
)ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS tasks(
	id int primary key not null auto_increment,
	name varchar(255) not null,
	timeframe bigint not null,
	start_date date,
	end_date date,
	percentage_complete int,
	link int,
	project int,
	foreign key (link) references tasks(id),
	foreign key (project) references projects(id)
)ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS resources(
	id int primary key not null auto_increment,
	name varchar(255) not null,
	description text not null,
	id_task int,
	foreign key (id_task) references tasks(id)
)ENGINE=INNODB;
