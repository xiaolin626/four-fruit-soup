-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1:3306
-- 生成日期： 2022-01-05 17:12:49
-- 服务器版本： 5.7.24
-- PHP 版本： 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `diancan`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
  `username` varchar(20) NOT NULL COMMENT '管理员用户名',
  `pwd` varchar(70) NOT NULL COMMENT '管理员密码',
  `group_id` mediumint(8) DEFAULT '0' COMMENT '分组ID',
  `email` varchar(30) DEFAULT '0' COMMENT '邮箱',
  `realname` varchar(10) DEFAULT '' COMMENT '真实姓名',
  `tel` varchar(30) DEFAULT NULL COMMENT '电话号码',
  `ip` varchar(20) DEFAULT NULL COMMENT 'IP地址',
  `add_time` int(11) DEFAULT NULL COMMENT '添加时间',
  `is_use` tinyint(2) DEFAULT '1' COMMENT '是否可用',
  `avatar` varchar(120) DEFAULT '' COMMENT '头像',
  `last_time` int(11) DEFAULT NULL COMMENT '最后时间',
  `login` int(11) DEFAULT '0' COMMENT '登录次数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='后台管理员';

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`id`, `username`, `pwd`, `group_id`, `email`, `realname`, `tel`, `ip`, `add_time`, `is_use`, `avatar`, `last_time`, `login`) VALUES
(1, 'admin', '65ad4b1cd8266bd7f58814acbda86a26', 0, '791845283@qq.com', '', '18850737047', '127.0.0.1', 1637215119, 1, '', 1637215119, 0),
(2, 'kevin', '65ad4b1cd8266bd7f58814acbda86a26', 0, '791845213@qq.com', '', '13305940594', '127.0.0.1', 1637227716, 1, '', 1637227716, 0);

-- --------------------------------------------------------

--
-- 表的结构 `banner`
--

DROP TABLE IF EXISTS `banner`;
CREATE TABLE IF NOT EXISTS `banner` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '轮播图名称',
  `description` varchar(255) DEFAULT '' COMMENT '说明',
  `link` varchar(255) DEFAULT '' COMMENT '链接',
  `target` varchar(10) DEFAULT '' COMMENT '打开方式，可选值：_self，_blank',
  `image` varchar(255) DEFAULT '' COMMENT '轮播图片',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态  1 显示  0  隐藏',
  `sort` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
  `position` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0为首页显示 1为其他位置显示',
  `delete_time` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `position` (`position`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='轮播图表';

--
-- 转存表中的数据 `banner`
--

INSERT INTO `banner` (`id`, `name`, `description`, `link`, `target`, `image`, `status`, `sort`, `position`, `delete_time`) VALUES
(1, '舌尖上的美食', '舌尖上的美食。。', '', '', '/uploads/202111/a2fd1786ccb658e0c34c1365a903de20.jpg', 1, 5, 0, 0),
(2, '西式套餐饭', '西式套餐饭...', '', '', '/uploads/202111/9b72664039862ecf87e845af34b43da6.jpg', 1, 4, 0, 0),
(4, '餐厅风格', '餐厅风格', '', '', '/uploads/202111/b5bd82cd5e38ade99614a0dad71915d5.jpg', 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `topic_img_id` int(11) DEFAULT NULL COMMENT '外键，关联image表',
  `delete_time` int(11) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL COMMENT '描述',
  `sort` tinyint(1) NOT NULL DEFAULT '50' COMMENT '排序 越小越靠前',
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `topic_img_id` (`topic_img_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COMMENT='商品类目';

--
-- 转存表中的数据 `category`
--

INSERT INTO `category` (`id`, `name`, `topic_img_id`, `delete_time`, `description`, `sort`, `update_time`) VALUES
(2, '粤式煲仔饭', 109, NULL, '煲仔饭也称瓦煲饭，是广东省广州市的一道特色名菜，该菜品的种类主要有腊味煲仔饭、香菇滑鸡煲仔饭、豆豉排骨煲仔饭、猪肝、烧鸭、白切鸡煲仔饭等。', 1, 1637298872),
(3, '营养汤面', 110, NULL, '一碗汤面，暖胃暖心。吃碗温热的面条最有利于营养吸收。 增强免疫力，口感筋道的面条所含的蛋白质更多,能补充人体所需的营养。', 2, 1637299124),
(4, '生滚靓粥', 106, NULL, '五谷杂粮养生粥，营养价值高，五谷杂粮养生粥，隔三差五的吃上一顿，既营养健康', 3, 1637299510),
(5, '特色小炒', 107, NULL, '菜色多样，口味可挑，需要荤素随意指定，粤菜，川菜，闽南菜都可以', 4, 1637299675),
(6, '水酒饮料', 108, NULL, '饮料或者啤酒，白酒，二锅头，管够', 6, 1637299802),
(7, '凉拌菜', 111, NULL, '凉拌菜，就是这个酸爽，又开胃', 5, 1637300061);

-- --------------------------------------------------------

--
-- 表的结构 `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL COMMENT '图片路径',
  `from` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 来自本地，2 来自公网',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `from` (`from`)
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8mb4 COMMENT='图片总表';

--
-- 转存表中的数据 `image`
--

INSERT INTO `image` (`id`, `url`, `from`, `delete_time`, `update_time`) VALUES
(1, '/banner-1a.png', 1, NULL, NULL),
(2, '/banner-2a.png', 1, NULL, NULL),
(3, '/banner-3a.png', 1, NULL, NULL),
(4, '/category-cake.png', 1, NULL, NULL),
(5, '/category-vg.png', 1, NULL, NULL),
(6, '/category-dryfruit.png', 1, NULL, NULL),
(7, '/category-fry-a.png', 1, NULL, NULL),
(8, '/category-tea.png', 1, NULL, NULL),
(9, '/category-rice.png', 1, NULL, NULL),
(10, '/product-dryfruit@1.png', 1, NULL, NULL),
(13, '/product-vg@1.png', 1, NULL, NULL),
(14, '/product-rice@6.png', 1, NULL, NULL),
(16, '/1@theme.png', 1, NULL, NULL),
(17, '/2@theme.png', 1, NULL, NULL),
(18, '/3@theme.png', 1, NULL, NULL),
(19, '/detail-1@1-dryfruit.png', 1, NULL, NULL),
(20, '/detail-2@1-dryfruit.png', 1, NULL, NULL),
(21, '/detail-3@1-dryfruit.png', 1, NULL, NULL),
(22, '/detail-4@1-dryfruit.png', 1, NULL, NULL),
(23, '/detail-5@1-dryfruit.png', 1, NULL, NULL),
(24, '/detail-6@1-dryfruit.png', 1, NULL, NULL),
(25, '/detail-7@1-dryfruit.png', 1, NULL, NULL),
(26, '/detail-8@1-dryfruit.png', 1, NULL, NULL),
(27, '/detail-9@1-dryfruit.png', 1, NULL, NULL),
(28, '/detail-11@1-dryfruit.png', 1, NULL, NULL),
(29, '/detail-10@1-dryfruit.png', 1, NULL, NULL),
(31, '/product-rice@1.png', 1, NULL, NULL),
(32, '/product-tea@1.png', 1, NULL, NULL),
(33, '/product-dryfruit@2.png', 1, NULL, NULL),
(36, '/product-dryfruit@3.png', 1, NULL, NULL),
(37, '/product-dryfruit@4.png', 1, NULL, NULL),
(38, '/product-dryfruit@5.png', 1, NULL, NULL),
(39, '/product-dryfruit-a@6.png', 1, NULL, NULL),
(40, '/product-dryfruit@7.png', 1, NULL, NULL),
(41, '/product-rice@2.png', 1, NULL, NULL),
(42, '/product-rice@3.png', 1, NULL, NULL),
(43, '/product-rice@4.png', 1, NULL, NULL),
(44, '/product-fry@1.png', 1, NULL, NULL),
(45, '/product-fry@2.png', 1, NULL, NULL),
(46, '/product-fry@3.png', 1, NULL, NULL),
(47, '/product-tea@2.png', 1, NULL, NULL),
(48, '/product-tea@3.png', 1, NULL, NULL),
(49, '/1@theme-head.png', 1, NULL, NULL),
(50, '/2@theme-head.png', 1, NULL, NULL),
(51, '/3@theme-head.png', 1, NULL, NULL),
(52, '/product-cake@1.png', 1, NULL, NULL),
(53, '/product-cake@2.png', 1, NULL, NULL),
(54, '/product-cake-a@3.png', 1, NULL, NULL),
(55, '/product-cake-a@4.png', 1, NULL, NULL),
(56, '/product-dryfruit@8.png', 1, NULL, NULL),
(57, '/product-fry@4.png', 1, NULL, NULL),
(58, '/product-fry@5.png', 1, NULL, NULL),
(59, '/product-rice@5.png', 1, NULL, NULL),
(60, '/product-rice@7.png', 1, NULL, NULL),
(62, '/detail-12@1-dryfruit.png', 1, NULL, NULL),
(63, '/detail-13@1-dryfruit.png', 1, NULL, NULL),
(65, '/banner-4a.png', 1, NULL, NULL),
(66, '/product-vg@4.png', 1, NULL, NULL),
(67, '/product-vg@5.png', 1, NULL, NULL),
(68, '/product-vg@2.png', 1, NULL, NULL),
(69, '/product-vg@3.png', 1, NULL, NULL),
(70, './uploads/202111/82e3381e71c2d5f4f5aacadec6dec490.jpg', 1, NULL, NULL),
(71, '/uploads/202111/e0c5ece3d2d20a207f5325a264771dfa.jpg', 1, NULL, NULL),
(72, '/uploads/202111/37e1ec8fc8ea77e6246d9b724d170946.jpg', 1, NULL, NULL),
(73, '/uploads/202111/36bb9d61eeedd6ffb820dc88e3807ab1.jpg', 1, NULL, NULL),
(74, '/uploads/202111/62a779770ef0d2c56762d8971f28ba27.jpg', 1, NULL, NULL),
(75, '/uploads/202111/9aa829006b334a13cb4910528817b56d.jpg', 1, NULL, NULL),
(76, '/uploads/202111/c779c1ff4319d219be96757be0c3de29.jpg', 1, NULL, NULL),
(77, '/uploads/202111/dead316cfb86855b4dbc4f491d38fef3.jpg', 1, NULL, NULL),
(78, '/uploads/202111/d018943350458724ad23a7122d574478.jpg', 1, NULL, NULL),
(79, '/uploads/202111/2dde6e31c9e2447a4ceb36f357191d38.jpg', 1, NULL, NULL),
(80, '/uploads/202111/7d207fdc44932454a0db50770e232cbf.jpg', 1, NULL, NULL),
(81, '/uploads/202111/959e991311a7c0606f446ad979998da5.jpg', 1, NULL, NULL),
(82, '/uploads/202111/4067d216d3a6409e563f5b85876af3eb.jpg', 1, NULL, NULL),
(83, '/uploads/202111/edfb9888ca44aed90772bf4d02b0c637.jpg', 1, NULL, NULL),
(84, '/uploads/202111/772863ab21828fe8d779cae0cab339f1.jpg', 1, NULL, NULL),
(85, '/uploads/202111/3bcb89bfd62837cf7f874085aa18326f.jpg', 1, NULL, NULL),
(86, '/uploads/202111/b8cd1d38f0d9e6b2abec423db9126a7e.jpg', 1, NULL, NULL),
(87, '/uploads/202111/e8396f5be7db2bacbf781fb44695ec6e.jpg', 1, NULL, NULL),
(88, '/uploads/202111/d643a6f4d970defb7cbe2345afff8937.jpg', 1, NULL, NULL),
(89, '/uploads/202111/ba86d2af22e4aa2c7d2ec70f48187367.jpg', 1, NULL, NULL),
(90, '/uploads/202111/22361806677b8f6f725a4ad5cb1fe288.jpg', 1, NULL, NULL),
(91, '/uploads/202111/78baa33e591a145f73c23343e6acbd7f.jpg', 1, NULL, NULL),
(92, '/uploads/202111/fee8c2bb46a0f3f58d8cd8b0802017a8.jpg', 1, NULL, NULL),
(93, '/uploads/202111/834c729064df9d38733399d4ebb8aa1d.jpg', 1, NULL, NULL),
(94, '/uploads/202111/1ce12e0d2e4384008bc4b7ffee8615c3.jpg', 1, NULL, NULL),
(95, '/uploads/202111/a430fcd569d635034aad8a9617badf26.jpg', 1, NULL, NULL),
(96, '/uploads/202111/841f29977dd97439cd03193861cdcb82.jpg', 1, NULL, NULL),
(97, '/uploads/202111/d7f9d4fc303b4c53e365f9b9ad5a3779.jpg', 1, NULL, NULL),
(98, '/uploads/202111/37ded9eb9c56bfba1d6c65210c0fdc95.jpg', 1, NULL, NULL),
(99, '/uploads/202111/224739e161f1db6a822063f4427d7394.jpg', 1, NULL, NULL),
(100, '/uploads/202111/b2abd177318e60da538d7d6218331a53.jpg', 1, NULL, NULL),
(101, '/uploads/202111/7aab1575fe7b1822f4ce43f2d53490a3.jpg', 1, NULL, NULL),
(102, '/drinks/drinks6.png', 1, NULL, NULL),
(103, '/drinks/drinks7.png', 1, NULL, NULL),
(104, '/category/rice.png', 1, NULL, NULL),
(105, '/category/noodle.png', 1, NULL, NULL),
(106, '/uploads/202111/9d2c2cd03f1a6dfcb6d0fd309e0e75b2.png', 1, NULL, 1637299510),
(107, '/uploads/202111/30aec485932b39ca0720d6f3c8290218.png', 1, NULL, 1637299675),
(108, '/uploads/202111/9cbe0b6d9cc4520c7d735a27ad4e82da.png', 1, NULL, 1637299802),
(109, '/uploads/202111/d98b4491d57138e462eb34046e378c36.png', 1, NULL, 1637298872),
(110, '/uploads/202111/1049fb45f00b58d47f4b91b55a66a7a3.png', 1, NULL, 1637299124),
(111, '/uploads/202111/a5e98d9b14504ec013aa4439a9e39783.jpg', 1, NULL, 1637300061),
(112, '/uploads/202111/127585f8e16d8053520f5a4348a16e76.jpg', 1, NULL, NULL),
(113, '/uploads/202111/2cf1ac8fd2e5a99b4c3a1031bd32b8e6.jpg', 1, NULL, NULL),
(114, '/uploads/202111/f1dde2641fc295df7f89c5dc12c31e06.jpg', 1, NULL, NULL),
(115, '/uploads/202111/da339e1daeca20222681e25e0b1016f3.jpg', 1, NULL, NULL),
(116, '/uploads/202111/e3343e2b3d5fbbce524c25de168c2d00.jpg', 1, NULL, NULL),
(117, '/uploads/202111/1df1d3ae64034a951eb82b9e3a131bfd.jpg', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
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
  `select_status` int(5) NOT NULL DEFAULT '1' COMMENT '选择是店食还是外卖，1外卖，2店食',
  `prepay_id` varchar(100) DEFAULT NULL COMMENT '订单微信支付的预订单id（用于发送模板消息）',
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_no` (`order_no`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `order_product`
--

DROP TABLE IF EXISTS `order_product`;
CREATE TABLE IF NOT EXISTS `order_product` (
  `order_id` int(11) NOT NULL COMMENT '联合主键，订单id',
  `product_id` int(11) NOT NULL COMMENT '联合主键，商品id',
  `count` int(11) NOT NULL COMMENT '商品数量',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`product_id`,`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `order_product`
--

INSERT INTO `order_product` (`order_id`, `product_id`, `count`, `delete_time`, `update_time`) VALUES
(24, 1, 1, NULL, NULL),
(33, 1, 7, NULL, NULL),
(34, 1, 1, NULL, NULL),
(21, 2, 1, NULL, NULL),
(24, 2, 1, NULL, NULL),
(25, 2, 1, NULL, NULL),
(30, 2, 1, NULL, NULL),
(31, 2, 1, NULL, NULL),
(32, 2, 1, NULL, NULL),
(28, 5, 1, NULL, NULL),
(29, 5, 1, NULL, NULL),
(24, 6, 1, NULL, NULL),
(26, 9, 1, NULL, NULL),
(27, 9, 1, NULL, NULL),
(35, 10, 1, NULL, NULL),
(31, 12, 1, NULL, NULL),
(24, 17, 1, NULL, NULL),
(24, 20, 1, NULL, NULL),
(22, 34, 2, NULL, NULL),
(23, 34, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL COMMENT '商品名称',
  `price` decimal(6,2) NOT NULL COMMENT '价格,单位：分',
  `stock` int(11) NOT NULL DEFAULT '0' COMMENT '库存量',
  `delete_time` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `main_img_url` varchar(255) DEFAULT NULL COMMENT '主图ID号，这是一个反范式设计，有一定的冗余',
  `from` tinyint(4) NOT NULL DEFAULT '1' COMMENT '图片来自 1 本地 ，2公网',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL,
  `summary` varchar(255) DEFAULT NULL COMMENT '摘要',
  `recommend` tinyint(1) NOT NULL DEFAULT '0' COMMENT '推荐',
  `img_id` int(11) DEFAULT NULL COMMENT '图片外键',
  `seller_num` int(10) NOT NULL DEFAULT '0' COMMENT '售卖数量',
  PRIMARY KEY (`id`),
  KEY `recommend` (`recommend`),
  KEY `category_id` (`category_id`),
  KEY `img_id` (`img_id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `stock`, `delete_time`, `category_id`, `main_img_url`, `from`, `create_time`, `update_time`, `summary`, `recommend`, `img_id`, `seller_num`) VALUES
(1, '青岛啤酒', '0.01', 998, NULL, 6, '/uploads/202111/2dde6e31c9e2447a4ceb36f357191d38.jpg', 1, NULL, 1637602003, '330ML，水，麦芽糖，产地来自山东', 0, 79, 0),
(2, '秘制鸭翅中煲+米饭+饮料', '0.01', 984, NULL, 2, './uploads/202111/82e3381e71c2d5f4f5aacadec6dec490.jpg', 1, NULL, 1637327688, '鸭翅分类分量很足，一个人管够，不甜不辣，很解馋。', 0, 70, 0),
(4, '王老吉', '0.01', 998, NULL, 6, '/uploads/202111/d7f9d4fc303b4c53e365f9b9ad5a3779.jpg', 1, NULL, 1637317085, '加油，有它陪你过冬天，再冷也不怕~', 0, 97, 0),
(5, '招牌排骨煲+米饭+饮料', '0.01', 995, NULL, 2, '/uploads/202111/e0c5ece3d2d20a207f5325a264771dfa.jpg', 1, NULL, 1637327911, '用的上等猪咧排，蜜汁排骨。很鲜，赞', 0, 71, 0),
(6, '爆炒猪头肉', '0.01', 997, NULL, 5, '/uploads/202111/78baa33e591a145f73c23343e6acbd7f.jpg', 1, NULL, 1637343087, 'Q弹有嚼劲', 0, 91, 0),
(7, '红菇海鲜卤面', '0.01', 998, NULL, 3, '/uploads/202111/7d207fdc44932454a0db50770e232cbf.jpg', 1, NULL, 1637341103, '红菇，蔬菜，蘑菇，干贝，明虾，虾仁。莆田招牌菜，正宗莆田卤面', 0, 80, 0),
(8, '明虾鸡块煲+米饭+饮料', '0.01', 995, NULL, 2, '/uploads/202111/37e1ec8fc8ea77e6246d9b724d170946.jpg', 1, NULL, 1637338225, '煲里有明虾，鸡块，台湾肉狗切片，土豆，千叶豆腐，年糕。\r\n口味郁浓，回味无穷', 0, 72, 0),
(9, '仔排煲PLUS骨汁排骨+米饭+饮料', '0.01', 996, NULL, 2, '/uploads/202111/36bb9d61eeedd6ffb820dc88e3807ab1.jpg', 1, NULL, 1637338357, '秘制骨汁排骨，港味十足，多种显瘦', 0, 73, 0),
(10, '卤猪脚煲+米饭+饮料', '0.01', 996, NULL, 2, '/uploads/202111/62a779770ef0d2c56762d8971f28ba27.jpg', 1, NULL, 1637338553, '煲里有猪脚，搭配土豆，千叶豆腐，台湾香肠片，年糕', 0, 74, 0),
(11, '腊肉煲仔饭+米饭+饮料', '0.01', 994, NULL, 2, '/uploads/202111/9aa829006b334a13cb4910528817b56d.jpg', 1, NULL, 1637602020, '12月的腊肉，恋上山里的味道', 1, 75, 0),
(12, '酱香牛腩煲+米饭+饮料', '0.01', 999, NULL, 2, '/uploads/202111/c779c1ff4319d219be96757be0c3de29.jpg', 1, NULL, 1637602145, '酱香牛腩，有嚼劲，韧劲十足，味道鲜美。', 1, 76, 0),
(16, '猪肚汤米粉+肉片', '0.01', 999, NULL, 3, '/uploads/202111/959e991311a7c0606f446ad979998da5.jpg', 1, NULL, 1637340696, '米粉，猪肚，肉片。', 0, 81, 0),
(17, '猪杂汤线面', '0.01', 999, NULL, 3, '/uploads/202111/edfb9888ca44aed90772bf4d02b0c637.jpg', 1, NULL, 1637341672, '猪杂，猪肝，猪心，猪肉片，肉丸子，线面', 0, 83, 0),
(18, '牛腩粗面', '0.01', 997, NULL, 3, '/uploads/202111/772863ab21828fe8d779cae0cab339f1.jpg', 1, NULL, 1637602171, '牛腩，牛肉丸，蔬菜，粗面', 1, 84, 0),
(19, '潮汕明火虾粥', '0.01', 999, NULL, 4, '/uploads/202111/3bcb89bfd62837cf7f874085aa18326f.jpg', 1, NULL, 1637602151, '虾，粥，味道鲜美', 1, 85, 0),
(20, '雪碧', '0.01', 999, NULL, 6, '/uploads/202111/37ded9eb9c56bfba1d6c65210c0fdc95.jpg', 1, NULL, 1637316898, '透心凉，心飞扬', 0, 98, 0),
(21, '百威啤酒', '0.01', 998, NULL, 6, '/uploads/202111/224739e161f1db6a822063f4427d7394.jpg', 1, NULL, 1637316962, '一起哈啤，百威真敬我！', 0, 99, 0),
(22, '爆炒猪肝', '0.01', 997, NULL, 5, '/uploads/202111/fee8c2bb46a0f3f58d8cd8b0802017a8.jpg', 1, NULL, 1637343100, '香味俱全', 0, 92, 0),
(23, '笋干回锅肉【推荐】', '0.01', 998, NULL, 5, '/uploads/202111/834c729064df9d38733399d4ebb8aa1d.jpg', 1, NULL, 1637343113, '猪肉，笋，尝试一次还想来', 0, 93, 0),
(25, '肉沫茄子', '0.01', 999, NULL, 5, '/uploads/202111/1ce12e0d2e4384008bc4b7ffee8615c3.jpg', 1, NULL, 1637602186, '茄子，肉泥', 1, 94, 0),
(26, '重庆麻辣鸡公煲+米饭+饮料', '0.01', 999, NULL, 2, '/uploads/202111/dead316cfb86855b4dbc4f491d38fef3.jpg', 1, NULL, 1637339289, '麻辣香而不辣，鸡块胸脯肉，鸡腿，鸡翅。咬一口，口唇留香', 0, 77, 0),
(27, '乌鸡粥', '0.01', 998, NULL, 4, '/uploads/202111/b8cd1d38f0d9e6b2abec423db9126a7e.jpg', 1, NULL, 1637342483, '乌鸡，粥', 0, 86, 0),
(28, '鲍鱼排骨粥', '0.01', 999, NULL, 4, '/uploads/202111/e8396f5be7db2bacbf781fb44695ec6e.jpg', 1, NULL, 1637342496, '鲍鱼3块，排骨，萝卜丁，粥', 0, 87, 0),
(32, '河南人气烩面', '0.01', 999, NULL, 3, '/uploads/202111/4067d216d3a6409e563f5b85876af3eb.jpg', 1, NULL, 1637340711, '在河南是很有人气的一道面食。有肉片，蔬菜，金针菇，蘑菇', 0, 82, 0),
(34, '秘制凤爪煲+米饭+饮料', '0.01', 999, NULL, 2, '/uploads/202111/d018943350458724ad23a7122d574478.jpg', 1, NULL, 1637339662, '煲里有凤爪，台湾热狗切片，年糕，土豆，秘制而成的一份煲。凤爪香味十足，Q弹有嚼劲', 0, 78, 0),
(35, '招牌皮蛋廋肉粥', '0.01', 999, NULL, 4, '/uploads/202111/d643a6f4d970defb7cbe2345afff8937.jpg', 1, NULL, 1637342515, '瘦肉，皮蛋，粥。', 0, 88, 0),
(36, '香菇廋肉粥', '0.01', 999, NULL, 4, '/uploads/202111/ba86d2af22e4aa2c7d2ec70f48187367.jpg', 1, NULL, 1637342527, '白菜，大米，猪肉，香菇', 0, 89, 0),
(37, '广式清火白粥', '0.01', 999, NULL, 4, '/uploads/202111/22361806677b8f6f725a4ad5cb1fe288.jpg', 1, NULL, 1637342539, '一碗白粥，长时间熬制，水米融洽，柔腻如一，口感绵绵，滋味非凡', 0, 90, 0),
(38, '鱼香肉丝', '0.01', 999, NULL, 5, '/uploads/202111/a430fcd569d635034aad8a9617badf26.jpg', 1, NULL, 1637343153, '萝卜丝，香干，木耳，肉丝', 0, 95, 0),
(39, '蒜泥空心菜', '0.01', 999, NULL, 5, '/uploads/202111/841f29977dd97439cd03193861cdcb82.jpg', 1, NULL, 1637343167, '空心菜', 0, 96, 0),
(40, '百世可乐', '0.01', 999, NULL, 6, '/uploads/202111/b2abd177318e60da538d7d6218331a53.jpg', 1, NULL, 1637317159, '最爽的莫过于入口的那一瞬间', 0, 100, 0),
(41, '果粒橙', '0.01', 999, NULL, 6, '/uploads/202111/7aab1575fe7b1822f4ce43f2d53490a3.jpg', 1, NULL, 1637317229, '橙汁果粒橙，350ML', 0, 101, 0),
(42, '饮料6', '0.01', 999, 1637324263, 6, '/drinks/drinks6.png', 1, NULL, 1637324263, NULL, 0, 102, 0),
(43, '饮料7', '0.01', 999, 1637324266, 6, '/drinks/drinks7.png', 1, NULL, 1637324266, NULL, 0, 103, 0),
(44, '排骨细面', '1.00', 265, NULL, 3, '/uploads/202111/127585f8e16d8053520f5a4348a16e76.jpg', 1, 1637340405, 1637340405, '面，排骨', 0, 112, 0),
(45, '老鸭清汤面 ', '1.00', 994, NULL, 3, '/uploads/202111/2cf1ac8fd2e5a99b4c3a1031bd32b8e6.jpg', 1, 1637340603, 1637341155, '老鸭，面', 0, 113, 0),
(46, '猪心面+营养面', '1.00', 994, NULL, 3, '/uploads/202111/f1dde2641fc295df7f89c5dc12c31e06.jpg', 1, 1637341223, 1637341223, '猪心，面。营养膳食', 0, 114, 0),
(47, '酸辣土豆丝', '1.00', 998, NULL, 5, '/uploads/202111/da339e1daeca20222681e25e0b1016f3.jpg', 1, 1637343303, 1637343303, '配干饭，很下饭', 0, 115, 0),
(48, '韭菜炒鸡蛋', '1.00', 997, NULL, 5, '/uploads/202111/e3343e2b3d5fbbce524c25de168c2d00.jpg', 1, 1637343350, 1637343350, '韭菜，鸡蛋', 0, 116, 0),
(49, '西葫芦片炒肉', '1.00', 997, NULL, 5, '/uploads/202111/1df1d3ae64034a951eb82b9e3a131bfd.jpg', 1, 1637343389, 1637343389, '西葫芦，肉片', 0, 117, 0);

-- --------------------------------------------------------

--
-- 表的结构 `product_image`
--

DROP TABLE IF EXISTS `product_image`;
CREATE TABLE IF NOT EXISTS `product_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img_id` int(11) NOT NULL COMMENT '外键，关联图片表',
  `delete_time` int(11) DEFAULT NULL COMMENT '状态，主要表示是否删除，也可以扩展其他状态',
  `order` int(11) NOT NULL DEFAULT '0' COMMENT '图片排序序号',
  `product_id` int(11) NOT NULL COMMENT '商品id，外键',
  PRIMARY KEY (`id`),
  KEY `img_id` (`img_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `product_image`
--

INSERT INTO `product_image` (`id`, `img_id`, `delete_time`, `order`, `product_id`) VALUES
(4, 19, 1637338803, 1, 11),
(5, 20, 1637338803, 2, 11),
(6, 21, 1637338803, 3, 11),
(7, 22, 1637338803, 4, 11),
(8, 23, 1637338803, 5, 11),
(9, 24, 1637338803, 6, 11),
(10, 25, 1637338803, 7, 11),
(11, 26, 1637338803, 8, 11),
(12, 27, 1637338803, 9, 11),
(13, 28, 1637338803, 11, 11),
(14, 29, 1637338803, 10, 11),
(18, 62, 1637338803, 12, 11),
(19, 63, 1637338803, 13, 11);

-- --------------------------------------------------------

--
-- 表的结构 `product_property`
--

DROP TABLE IF EXISTS `product_property`;
CREATE TABLE IF NOT EXISTS `product_property` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT '' COMMENT '详情属性名称',
  `detail` varchar(255) NOT NULL COMMENT '详情属性',
  `product_id` int(11) NOT NULL COMMENT '商品id，外键',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `product_property`
--

INSERT INTO `product_property` (`id`, `name`, `detail`, `product_id`, `delete_time`, `update_time`) VALUES
(1, '品名', '杨梅', 11, 1637338803, NULL),
(2, '口味', '青梅味 雪梨味 黄桃味 菠萝味', 11, 1637338803, NULL),
(3, '产地', '火星', 11, 1637338803, NULL),
(4, '保质期', '180天', 11, 1637338803, NULL),
(5, '品名', '梨子', 2, 1637327084, NULL),
(6, '产地', '金星', 2, 1637327084, NULL),
(7, '净含量', '100g', 2, 1637327084, NULL),
(8, '保质期', '10天', 2, 1637327084, NULL),
(9, '品名', '梨子', 2, 1637327688, NULL),
(10, '产地', '金星', 2, 1637327688, NULL),
(11, '净含量', '100g', 2, 1637327688, NULL),
(12, '保质期', '10天', 2, 1637327688, NULL),
(13, '品名', '梨子', 2, NULL, NULL),
(14, '产地', '金星', 2, NULL, NULL),
(15, '净含量', '100g', 2, NULL, NULL),
(16, '保质期', '10天', 2, NULL, NULL),
(17, '品名', '杨梅', 11, 1637339261, NULL),
(18, '口味', '青梅味 雪梨味 黄桃味 菠萝味', 11, 1637339261, NULL),
(19, '产地', '火星', 11, 1637339261, NULL),
(20, '保质期', '180天', 11, 1637339261, NULL),
(21, '品名', '杨梅', 11, NULL, NULL),
(22, '口味', '青梅味 雪梨味 黄桃味 菠萝味', 11, NULL, NULL),
(23, '产地', '火星', 11, NULL, NULL),
(24, '保质期', '180天', 11, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `system`
--

DROP TABLE IF EXISTS `system`;
CREATE TABLE IF NOT EXISTS `system` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` char(36) NOT NULL DEFAULT '' COMMENT '网站名称',
  `url` varchar(36) NOT NULL DEFAULT '' COMMENT '网址',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `key` varchar(200) NOT NULL COMMENT '关键字',
  `des` varchar(200) NOT NULL COMMENT '描述',
  `bah` varchar(50) DEFAULT NULL COMMENT '备案号',
  `copyright` varchar(30) DEFAULT NULL COMMENT 'copyright',
  `work_time` varchar(255) NOT NULL DEFAULT '' COMMENT '营业时间',
  `ads` varchar(120) DEFAULT NULL COMMENT '公司地址',
  `tel` varchar(15) DEFAULT NULL COMMENT '公司电话',
  `email` varchar(50) DEFAULT NULL COMMENT '公司邮箱',
  `logo` varchar(120) DEFAULT NULL COMMENT 'logo',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `system`
--

INSERT INTO `system` (`id`, `name`, `url`, `title`, `key`, `des`, `bah`, `copyright`, `work_time`, `ads`, `tel`, `email`, `logo`) VALUES
(1, '老地方-农家味', 'http://www.laodifang.com', '老地方-农家味', '外卖，便捷快餐，农家家里的味道，小炒，盖浇饭', '荤素小炒，营养汤面，套餐饭，盖浇饭。正宗农家菜，农家的味道', 'cmsn1564s', '11111', '09:00-14:00 16:00-20:00', '福建省莆田市城厢区霞林街道喜盈门大厦2号楼1801室', '18850737047', '791845283@qq.com', '/uploads/202111/618a293577a880aa26e3e611eeaa1092.jpg');

-- --------------------------------------------------------

--
-- 表的结构 `third_app`
--

DROP TABLE IF EXISTS `third_app`;
CREATE TABLE IF NOT EXISTS `third_app` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` varchar(64) NOT NULL COMMENT '应用app_id',
  `app_secret` varchar(64) NOT NULL COMMENT '应用secret',
  `app_description` varchar(100) DEFAULT NULL COMMENT '应用程序描述',
  `scope` varchar(20) NOT NULL COMMENT '应用权限',
  `scope_description` varchar(100) DEFAULT NULL COMMENT '权限描述',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='访问API的各应用账号密码表';

--
-- 转存表中的数据 `third_app`
--

INSERT INTO `third_app` (`id`, `app_id`, `app_secret`, `app_description`, `scope`, `scope_description`, `delete_time`, `update_time`) VALUES
(1, 'wjj', '123456', 'CMS', '32', 'Super', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(50) NOT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `sex` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0为女男为1',
  `mobile` varchar(11) NOT NULL DEFAULT '',
  `ip` varchar(20) NOT NULL DEFAULT '',
  `extend` varchar(255) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL COMMENT '注册时间',
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `openid` (`openid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `openid`, `nickname`, `sex`, `mobile`, `ip`, `extend`, `delete_time`, `create_time`, `update_time`) VALUES
(4, 'oKFP-4wyYvUqFis01gFytWLJhXr8', NULL, 1, '', '', NULL, NULL, 1590767423, 1570031423),
(5, 'oKFP-46MU6KFiA_s-Cw7o0AThlaU', NULL, 1, '', '', NULL, NULL, 1590804966, 1570068966),
(6, 'oy0Th5kADuoh-C-5KcvW7HEEueu0', NULL, 1, '', '', NULL, NULL, 1590812657, 1570076657);

-- --------------------------------------------------------

--
-- 表的结构 `user_address`
--

DROP TABLE IF EXISTS `user_address`;
CREATE TABLE IF NOT EXISTS `user_address` (
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
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `user_address`
--

INSERT INTO `user_address` (`id`, `name`, `mobile`, `province`, `city`, `country`, `detail`, `delete_time`, `user_id`, `update_time`, `is_default`) VALUES
(4, '米店', '15911394330', '广东省', '广州市', '从化区', '华南农业大学珠江学院', NULL, 5, NULL, 0),
(9, '刘健凡', '18850737047', '天津', '天津市', '和平区', '万科小区3号楼', NULL, 6, NULL, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
