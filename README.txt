LTE-CI是一个把AdminLTE与CI组合后的项目,在此基础上添加一些可能会用到的方法,主要是方便自己的开发

开发前需要做的事:
1.检查application目录中所有TODO的地方,按每个项目的不同进行配置和修改
2.为了开发简单,这里会有关于session表以及menu表的DDL,可以在此基础上快速开发
3.为了保证缓存文件和日志文件的读写正常,需要修改对应目录的劝降为777


附session表以及menu表的DDL(按需修改):
CREATE TABLE xx_sessions
(
    id VARCHAR(128) NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    timestamp INT(10) unsigned DEFAULT '0' NOT NULL,
    data BLOB NOT NULL
);
CREATE INDEX xx_sessions_timestamp ON xx_sessions (timestamp);

CREATE TABLE menu
(
    id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(20),
    level INT(11) DEFAULT '1',
    pid INT(11) DEFAULT '1',
    url VARCHAR(50) DEFAULT '',
    position INT(11) DEFAULT '1'
);



最后,删掉这个文件,开始开发自己的项目吧!

