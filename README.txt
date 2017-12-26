LTE-CI是一个把AdminLTE与CI组合后的项目,在此基础上添加一些可能会用到的方法,主要是方便自己的开发

开发前需要做的事:
1.检查application目录中所有TODO的地方,按每个项目的不同进行配置和修改
2.为了开发简单,这里会有关于session表,menu表,privilege表,role表及user表的DDL,可以在此基础上快速开发
3.为了保证缓存文件和日志文件的读写正常,需要修改对应目录的权限降为777


附session表,menu表,privilege表,role表及user表的DDL(按需修改):
CREATE TABLE xx_sessions
(
    id VARCHAR(128) NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    timestamp INT(10) unsigned DEFAULT '0' NOT NULL,
    data BLOB NOT NULL
);
CREATE INDEX xx_sessions_timestamp ON xx_sessions (timestamp);

create table menu
(
	id int auto_increment
		primary key,
	name varchar(20) null,
	icon varchar(50) default '' null,
	level int default '1' null,
	pid int default '1' null,
	url varchar(50) default '' null,
	position int default '1' null,
	group_id int default '1' null,
	not_display int default '0' null,
	deleted int default '0' null
)
engine=InnoDB
;

create table privilege
(
	privilege_id int auto_increment
		primary key,
	name varchar(20) null,
	url varchar(30) default '' null,
	group_name varchar(20) null
)
engine=InnoDB
;

create table role
(
	role_id int auto_increment
		primary key,
	name varchar(20) null,
	description varchar(100) null,
	privileges varchar(300) default '[]' null
)
engine=InnoDB
;

create table user
(
	user_id int auto_increment
		primary key,
	username varchar(50) default '' null,
	nickname varchar(20) null,
	password varchar(64) default '' null,
	role_id int not null comment '用户角色ID',
	last_login_time datetime null,
	is_locked tinyint default '0' null comment '帐号是否被禁用',
	created_at timestamp default CURRENT_TIMESTAMP not null,
	created_by varchar(10) null comment '创建人',
	updated_by varchar(10) default '' null,
	updated_at timestamp null,
	constraint user_username_uindex
		unique (username)
)
engine=InnoDB
;





最后,删掉这个文件,开始开发自己的项目吧!

