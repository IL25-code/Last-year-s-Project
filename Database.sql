CREATE TABLE IF NOT EXISTS companies(
	id int primary key not null auto_increment,
	vat int,
	name varchar(255),
	phone_number varchar(20),
	email varchar(255),
	address varchar(255),
	code int,
	unique(code)
)ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS users(
	fiscal_code varchar(16) primary key not null,
	name varchar(255),
	surname varchar(255),
	birth_date date,
	email varchar(255),
	password varchar(255),
	username varchar(255),
	role varchar(255),
	company int,
	foreign key (company) references companies(id),
)ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS teams(
	id int primary key not null auto_increment,
	name varchar(255),
	team_leader varchar(16),
	foreign key (team_leader) references users(fiscal_code)
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
	company int,
	foreign key (team) references teams(id),
	foreign key (company) references companies(id)
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
	id_project int,
	foreign key (id_project) references projects(id),
	foreign key (id_task) references tasks(id)
)ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS requests(
	id int primary key not null auto_increment,
	name varchar(255) not null,
	description text not null,
	status enum('Requested','Accepted','Refused'),
	applicant int,
	id_project int,
	id_task int,
	foreign key (applicant) references users(fiscal_code),
	foreign key (id_project) references projects(id),
	foreign key (id_task) references tasks(id)
)ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS users-teams(
	id_user varchar(16),
	id_team int,
	primary key(id_user,id_team),
	foreign key (id_user) references users(fiscal_code),
	foreign key (id_team) references teams(id),
)ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS teams-projects(
	id_team int,
	id_project int,
	primary key(id_team,id_project),
	foreign key (id_team) references teams(id),
	foreign key (id_project) references projects(id),
)