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

INSERT INTO `image` VALUES ('1', './image/14.png', '1', null, null);
INSERT INTO `image` VALUES ('2', './image/15.png', '1', null, null);
INSERT INTO `image` VALUES ('3', './image/16.png', '1', null, null);
INSERT INTO `image` VALUES ('4', './image/17.png', '1', null, null);
INSERT INTO `image` VALUES ('5', './image/18.png', '1', null, null);
INSERT INTO `image` VALUES ('6', './image/19.png', '1', null, null);
INSERT INTO `image` VALUES ('7', './image/20.png', '1', null, null);
INSERT INTO `image` VALUES ('8', './image/21.png', '1', null, null);
INSERT INTO `image` VALUES ('9', './image/22.png', '1', null, null);
INSERT INTO `image` VALUES ('10', './image/23.png', '1', null, null);
INSERT INTO `image` VALUES ('11', './image/24.png', '1', null, null);
INSERT INTO `image` VALUES ('12', './image/25.png', '1', null, null);
INSERT INTO `image` VALUES ('13', './image/26.png', '1', null, null);
INSERT INTO `image` VALUES ('14', './image/27.png', '1', null, null);



alter table product change type theme_id int(5) not null commit"分类产品外键关联";