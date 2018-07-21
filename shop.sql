create database shop charset=utf8;

use shop;

-- 管理员表
create table wdy_admin(
admin_id int unsigned not null auto_increment,

-- 认证相关
admin_name varchar(32) not null default '' comment '管理员姓名',
admin_pwd  char(32) comment '管理员密码，md5加密后的密码',

-- 权限
role_ip  int unsigned not null default 0 comment '所属角色id',

-- 登录相关信息
last_id int unsigned not null default 0 comment '上次登录IP',
last_time int comment '上次登录时间',

-- 管理员属性信息
primary key (admin_id)
) charset=utf8 engine=myisam;


-- 插入测试数据
insert into wdy_admin values
(13, 'admin', md5('123abc'), 0, 0, 0),
(42, 'wdy', md5('123456'), 0, 0, 0),
(33, 'php', md5('123456'), 0, 0, 0),


-- 创建session表
create table `session` (
  session_id varchar (40) not null default '',
  session_content text,
  last_time int not null default 0,
  primary key (session_id)
)charset=utf8 engine=myisam;