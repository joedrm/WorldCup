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

-- 创建商品表
create table `goods` (
  goods_id int unsigned not null auto_increment,
  goods_name varchar (32) not null default '' comment '名',
  shop_price decimal(10, 2) not null default 0 comment '商品价格',
  category_id int unsigned comment '所属类型的ID',
  brand_id int unsigned comment '所属品牌的ID',
  goods_image varchar(255) not null default '' comment '商品图片,图片地址',
  goods_image_ori varchar(255) not null default '' comment '原图',
  goods_desc text comment '描述',
  goods_number  int unsigned not null default 0 comment '库存',
  is_on_sale tinyint not null default 1 comment '是否上架',
  goods_promote set ('精品', '新品', '热销') not null default '' comment '商品的推荐属性使用集合存储',
  create_admin_id int unsigned not null default 0 comment '添加该商品的管理员',
  primary key (`goods_id`)
)charset=utf8 engine=myisam;

-- 品类表
create table category(
  category_id int unsigned not null auto_increment,
  primary key (`category_id`)
);

-- 品牌表
create table brand (
  brand_id int unsigned not null auto_increment,
  primary key (`brand_id`)
);