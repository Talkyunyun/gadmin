-- 创建数据库
CREATE DATABASE gadmin DEFAULT CHARACTER SET = utf8mb4;

-- 系统用户表
CREATE TABLE g_admin (
  id int(11) unsigned PRIMARY KEY AUTO_INCREMENT COMMENT '用户ID',
  username varchar(50) not null COMMENT '登录用户名',
  password char(40) not null COMMENT '密码',
  email varchar(100) COMMENT '电子邮箱',
  phone varchar(12) COMMENT '手机号码',
  real_name varchar(20) COMMENT '真名',
  roles varchar(100) DEFAULT NULL comment '角色列表',
  status tinyint(1) unsigned DEFAULT 1 COMMENT '状态,1:正常,0:禁用',
  created_at int(11) not null COMMENT '创建时间',
  updated_at int(11) not null COMMENT '更新时间',
  KEY status (status)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COMMENT='系统用户表';

-- 插入记录
INSERT INTO `g_admin` (`id`, `username`, `password`, `email`, `phone`, `real_name`, `status`, `created_at`, `updated_at`, `roles`)
VALUES
	(1,'admin','bb5a769af1a5394298e4c1cba2ab80dc55e2c4d5',NULL,NULL,'admin',1,1484299329,1486609121, NULL);

-- 节点表
CREATE TABLE g_node(
  id smallint(6) unsigned PRIMARY KEY auto_increment comment '主键',
  url VARCHAR (140) not null comment '节点访问地址',
  name varchar(50) not null comment '节点名称',
  remark varchar(255) DEFAULT null comment '备注',
  status tinyint(1) unsigned DEFAULT 1 comment '状态,1:正常,0禁用',
  pid smallint(6) unsigned DEFAULT 0 comment '父节点,0顶级',
  created_at int(11) not null COMMENT '创建时间',
  updated_at int(11) not null COMMENT '更新时间',
  key pid (pid),
  key status (status)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COMMENT='节点表';

-- 角色表
CREATE TABLE g_role(
  id smallint(6) unsigned PRIMARY KEY auto_increment comment '主键',
  name varchar(100) not null comment '名称',
  remark varchar(255) DEFAULT null comment '备注',
  status tinyint(1) unsigned DEFAULT 1 comment '状态,1:正常,0:禁用',
  created_at int(11) not null COMMENT '创建时间',
  updated_at int(11) not null COMMENT '更新时间',
  key status (status)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COMMENT='角色表';

-- 权限表
CREATE TABLE g_access(
  role_id smallint(6) unsigned not null comment '角色ID',
  node_id smallint(6) unsigned not null comment '节点ID',
  created_at int(11) not null COMMENT '创建时间',
  updated_at int(11) not null COMMENT '更新时间'
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COMMENT='权限表';