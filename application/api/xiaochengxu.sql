-- ----------------------------------------------
-- Table structure for banner(轮播图表)
-- ----------------------------------------------
DROP TABLE IF EXITS `banner`;
CREATE TABLE `banner`(
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(32) NOT NULL DEFAULT '' COMMENT '轮播图名称',
	`description` varchar(50) NOT NULL DEFAULT '' COMMENT '轮播图介绍',
	`banner_image` varchar(100) NOT NULL DEFAULT '' COMMENT '轮播图',
	`listorder` int(8) unsigned NOT NULL DEFAULT 0 COMMENT '排序',
	`status` tinyint(2) NOT NULL DEFAULT 0 COMMENT '状态',
	`create_time` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
	`update_time` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
	PRIMARY KEY(`id`) 
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; 

--------------------------
-- Records of banner
--------------------------
INSERT INTO `banner` VALUES(1,'红豆沙冰','夏季冰霜红豆沙冰','15.jpg','1','1','145854655','184545421');
INSERT INTO `banner` VALUES(2,'绿豆沙冰','夏季冰霜绿豆沙冰','16.jpg','1','1','145854658','184545428');
INSERT INTO `banner` VALUES(3,'西瓜沙冰','夏季冰霜西瓜沙冰','17.jpg','1','1','145854662','184545462');
INSERT INTO `banner` VALUES(4,'芒果沙冰','夏季冰霜芒果沙冰','18.jpg','1','1','145854665','184545465');

-- ----------------------------
-- Table structure for image
-- ----------------------------
DROP TABLE IF EXISTS `image`;
CREATE TABLE `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL COMMENT '图片路径',
  `from` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 来自本地，2 来自公网',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COMMENT='图片总表';

-- ----------------------------
-- Records of image
-- ----------------------------

INSERT INTO `image` VALUES ('1', 'image/14.png', '1', null, null);
INSERT INTO `image` VALUES ('2', 'image/15.png', '1', null, null);
INSERT INTO `image` VALUES ('3', 'image/16.png', '1', null, null);
INSERT INTO `image` VALUES ('4', 'image/17.png', '1', null, null);
INSERT INTO `image` VALUES ('5', 'image/18.png', '1', null, null);
INSERT INTO `image` VALUES ('6', 'image/19.png', '1', null, null);
INSERT INTO `image` VALUES ('7', 'image/20.png', '1', null, null);
INSERT INTO `image` VALUES ('8', 'image/21.png', '1', null, null);
INSERT INTO `image` VALUES ('9', 'image/22.png', '1', null, null);
INSERT INTO `image` VALUES ('10', 'image/23.png', '1', null, null);
INSERT INTO `image` VALUES ('11', 'image/24.png', '1', null, null);
INSERT INTO `image` VALUES ('12', 'image/25.png', '1', null, null);
INSERT INTO `image` VALUES ('13', 'image/26.png', '1', null, null);
INSERT INTO `image` VALUES ('14', 'image/27.png', '1', null, null);



-- ----------------------------
-- Table structure for product_property
-- ----------------------------
DROP TABLE IF EXISTS `product_property`;
CREATE TABLE `product_property` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `originplace` varchar(50) NOT NULL COMMENT '产地',
  `qualitytime` varchar (50) NOT NULL COMMENT '保质期',
  `tasty` varchar(50) NOT NULL COMMENT '味道类型',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of product_property
-- ----------------------------
INSERT INTO `product_property` VALUES ('1', '广东广州', '180天','青梅味', null, null);
INSERT INTO `product_property` VALUES ('2', '广东广州', '180天','蓝梅味', null, null);
INSERT INTO `product_property` VALUES ('3', '广东广州', '180天','草莓味',null, null);
INSERT INTO `product_property` VALUES ('4', '广东广州', '180天','原味', null, null);
INSERT INTO `product_property` VALUES ('5', '广东广州', '180天','巧克力味', null, null);
INSERT INTO `product_property` VALUES ('6', '广东广州', '180天','香草味', null, null);
INSERT INTO `product_property` VALUES ('7', '广东广州', '180天','牛奶味', null, null);
INSERT INTO `product_property` VALUES ('8', '广东广州', '180天','榴莲味', null, null);
INSERT INTO `product_property` VALUES ('9', '广东深圳', '180天','哈密瓜味', null, null);
INSERT INTO `product_property` VALUES ('10', '广东深圳', '180天','水蜜桃味', null, null);
INSERT INTO `product_property` VALUES ('11', '广东深圳', '180天','香蕉味', null, null);
INSERT INTO `product_property` VALUES ('12', '广东深圳', '180天','苹果味', null, null);

-- ----------------------------
-- Table structure for product_size
-- ----------------------------
DROP TABLE IF EXISTS `product_size`;
CREATE TABLE `product_size` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `detail` varchar(50) NOT NULL COMMENT '商品详情',
  `product_id` varchar (50) NOT NULL COMMENT '商品id，外键关联',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of product_size
-- ----------------------------

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(50) NOT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `extend` varchar(255) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL COMMENT '注册时间',
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `openid` (`openid`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of user
-- ----------------------------


-- ----------------------------
-- Table structure for user_address
-- ----------------------------
DROP TABLE IF EXISTS `user_address`;
CREATE TABLE `user_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL COMMENT '收获人姓名',
  `mobile` varchar(20) NOT NULL COMMENT '手机号',
  `province` varchar(20) DEFAULT NULL COMMENT '省',
  `city` varchar(20) DEFAULT NULL COMMENT '市',
  `country` varchar(20) DEFAULT NULL COMMENT '区',
  `detail` varchar(100) DEFAULT NULL COMMENT '详细地址',
  `delete_time` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL COMMENT '外键',
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of user_address
-- ----------------------------

-- ----------------------------
-- Table structure for order
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(20) NOT NULL COMMENT '订单号',
  `user_id` int(11) NOT NULL COMMENT '外键，用户id，注意并不是openid',
  `delete_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `total_price` decimal(6,2) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:未支付， 2：已支付，3：已发货 , 4: 已支付，但库存不足',
  `snap_img` varchar(255) DEFAULT NULL COMMENT '订单快照图片',
  `snap_name` varchar(80) DEFAULT NULL COMMENT '订单快照名称',
  `total_count` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) DEFAULT NULL,
  `snap_items` text COMMENT '订单其他信息快照（json)',
  `snap_address` varchar(500) DEFAULT NULL COMMENT '地址快照',
  `prepay_id` varchar(100) DEFAULT NULL COMMENT '订单微信支付的预订单id（用于发送模板消息）',
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_no` (`order_no`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=539 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of order
-- ----------------------------

-- ----------------------------
-- Table structure for order_product
-- ----------------------------
DROP TABLE IF EXISTS `order_product`;
CREATE TABLE `order_product` (
  `order_id` int(11) NOT NULL COMMENT '联合主键，订单id',
  `product_id` int(11) NOT NULL COMMENT '联合主键，商品id',
  `count` int(11) NOT NULL COMMENT '商品数量',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`product_id`,`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of order_product
-- ----------------------------

alter table banner add column `from` tinyint(4) NOT NULL DEFAULT '1' COMMENT '图片来源1:本地,2:云服务';
alter table category add column `from` tinyint(4) NOT NULL DEFAULT '1' COMMENT '图片来源1:本地,2:云服务';
ALTER TABLE product DROP COLUMN product_id;

