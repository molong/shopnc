CREATE TABLE `#__activity` (
  `activity_id` mediumint(9) NOT NULL auto_increment COMMENT 'id',
  `activity_title` varchar(255) NOT NULL COMMENT '标题',
  `activity_type` enum('1','2') default NULL COMMENT '活动类型 1:商品 2:团购',
  `activity_banner` varchar(255) NOT NULL COMMENT '活动横幅大图片',
  `activity_style` varchar(255) NOT NULL COMMENT '活动页面模板样式标识码',
  `activity_desc` varchar(1000) NOT NULL COMMENT '描述',
  `activity_start_date` int(10) unsigned NOT NULL default '0' COMMENT '开始时间',
  `activity_end_date` int(10) unsigned NOT NULL default '0' COMMENT '结束时间',
  `activity_sort` tinyint(1) unsigned NOT NULL default '255' COMMENT '排序',
  `activity_state` tinyint(1) unsigned NOT NULL default '1' COMMENT '活动状态 0为关闭 1为开启',
  PRIMARY KEY (`activity_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='活动表';

CREATE TABLE `#__activity_detail` (
  `activity_detail_id` mediumint(9) NOT NULL auto_increment COMMENT 'id',
  `activity_id` mediumint(8) unsigned NOT NULL default '0' COMMENT '活动编号',
  `item_id` int(11) NOT NULL COMMENT '商品或团购的编号',
  `item_name` varchar(255) NOT NULL COMMENT '商品或团购名称',
  `store_id` int(11) NOT NULL COMMENT '店铺编号',
  `store_name` varchar(255) NOT NULL COMMENT '店铺名称',
  `activity_detail_state` enum('0','1','2','3') NOT NULL default '0' COMMENT '审核状态 0:(默认)待审核 1:通过 2:未通过 3:再次申请',
  `activity_detail_sort` tinyint(1) unsigned NOT NULL default '255' COMMENT '排序',
  PRIMARY KEY  (`activity_detail_id`),
  KEY `activity_id` (`activity_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='活动细节表';

CREATE TABLE `#__address` (
  `address_id` mediumint(10) unsigned NOT NULL auto_increment COMMENT '地址ID',
  `member_id` mediumint(10) unsigned NOT NULL default '0' COMMENT '会员ID',
  `true_name` varchar(50) NOT NULL COMMENT '会员姓名',
  `area_id` mediumint(10) unsigned NOT NULL default '0' COMMENT '地区ID',
  `city_id` mediumint(9) default NULL COMMENT '市级ID',
  `area_info` varchar(255) NOT NULL default '' COMMENT '地区内容',
  `address` varchar(255) NOT NULL COMMENT '地址',
  `zip_code` char(6) default NULL COMMENT '邮编',
  `tel_phone` varchar(20) default NULL COMMENT '座机电话',
  `mob_phone` varchar(15) default NULL COMMENT '手机电话',
  PRIMARY KEY (`address_id`),
  KEY `member_id` (`member_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='买家地址信息表';

CREATE TABLE `#__admin` (
  `admin_id` int(11) unsigned NOT NULL auto_increment COMMENT '管理员ID',
  `admin_permission` varchar(3000) default NULL COMMENT '管理权限',
  `admin_name` varchar(20) NOT NULL COMMENT '管理员名称',
  `admin_password` varchar(32) NOT NULL default '' COMMENT '管理员密码',
  `admin_login_time` int(10) NOT NULL default '0' COMMENT '登录时间',
  `admin_login_num` int(11) NOT NULL default '0' COMMENT '登录次数',
  `admin_is_super` tinyint(1) NOT NULL default '0' COMMENT '是否超级管理员',
  PRIMARY KEY  (`admin_id`),
  KEY `member_id` (`admin_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='管理员表';

CREATE TABLE `#__adv` (
  `adv_id` mediumint(8) unsigned NOT NULL auto_increment COMMENT '广告自增标识编号',
  `ap_id` mediumint(8) unsigned NOT NULL COMMENT '广告位id',
  `adv_title` varchar(255) NOT NULL COMMENT '广告内容描述',
  `adv_content` varchar(1000) NOT NULL COMMENT '广告内容',
  `adv_start_date` int(10) default NULL COMMENT '广告开始时间',
  `adv_end_date` int(10) default NULL COMMENT '广告结束时间',
  `slide_sort` int(10) unsigned NOT NULL COMMENT '幻灯片排序',
  `member_id` int(11) NOT NULL COMMENT '会员ID',
  `member_name` varchar(50) NOT NULL COMMENT '会员用户名',
  `click_num` int(10) unsigned NOT NULL COMMENT '广告点击率',
  `is_allow` smallint(1) unsigned NOT NULL COMMENT '会员购买的广告是否通过审核0未审核1审核已通过2审核未通过',
  `buy_style` varchar(10) NOT NULL COMMENT '购买方式',
  `goldpay` int(10) unsigned NOT NULL COMMENT '购买所支付的金币',
  PRIMARY KEY  (`adv_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='广告表';

CREATE TABLE `#__adv_click` (
  `adv_id` mediumint(8) unsigned NOT NULL COMMENT '广告id',
  `ap_id` mediumint(8) unsigned NOT NULL default '0' COMMENT '所属广告位id',
  `click_year` smallint(5) unsigned NOT NULL default '0' COMMENT '点击年份',
  `click_month` smallint(5) unsigned NOT NULL default '0' COMMENT '点击月份',
  `click_num` mediumint(8) unsigned NOT NULL default '0' COMMENT '点击率',
  `adv_name` varchar(100) NOT NULL COMMENT '广告名称',
  `ap_name` varchar(100) NOT NULL COMMENT '广告位名称',
  UNIQUE KEY `adv_id` (`adv_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='广告点击率表';

CREATE TABLE `#__adv_position` (
  `ap_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '广告位置id',
  `ap_name` varchar(100) NOT NULL COMMENT '广告位置名',
  `ap_intro` varchar(255) NOT NULL COMMENT '广告位简介',
  `ap_class` smallint(1) unsigned NOT NULL COMMENT '广告类别：0图片1文字2幻灯3Flash',
  `ap_display` smallint(1) unsigned NOT NULL COMMENT '广告展示方式：0幻灯片1多广告展示2单广告展示',
  `is_use` smallint(1) unsigned NOT NULL COMMENT '广告位是否启用：0不启用1启用',
  `ap_width` int(10) NOT NULL COMMENT '广告位宽度',
  `ap_height` int(10) NOT NULL COMMENT '广告位高度',
  `ap_price` int(10) unsigned NOT NULL COMMENT '广告位单价',
  `adv_num` int(10) unsigned NOT NULL COMMENT '拥有的广告数',
  `click_num` int(10) unsigned NOT NULL COMMENT '广告位点击率',
  `default_content` varchar(100) NOT NULL COMMENT '广告位默认内容',
  PRIMARY KEY (`ap_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='广告位表';

CREATE TABLE `#__album_class` (
  `aclass_id` int(10) unsigned NOT NULL auto_increment COMMENT '相册id',
  `aclass_name` varchar(100) NOT NULL COMMENT '相册名称',
  `store_id` int(10) unsigned NOT NULL COMMENT '所属店铺id',
  `aclass_des` varchar(255) NOT NULL COMMENT '相册描述',
  `aclass_sort` tinyint(3) unsigned NOT NULL COMMENT '排序',
  `aclass_cover` varchar(255) NOT NULL COMMENT '相册封面',
  `upload_time` int(10) unsigned NOT NULL COMMENT '图片上传时间',
  `is_default` tinyint(1) unsigned NOT NULL default '0' COMMENT '是否为默认相册,1代表默认',
  PRIMARY KEY (`aclass_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='相册表';

CREATE TABLE `#__album_pic` (
  `apic_id` int(10) unsigned NOT NULL auto_increment COMMENT '相册图片表id',
  `apic_name` varchar(100) NOT NULL COMMENT '图片名称',
  `apic_tag` varchar(255) NOT NULL COMMENT '图片标签',
  `aclass_id` int(10) unsigned NOT NULL COMMENT '相册id',
  `apic_cover` varchar(255) NOT NULL COMMENT '图片路径',
  `apic_size` int(10) unsigned NOT NULL COMMENT '图片大小',
  `apic_spec` varchar(100) NOT NULL COMMENT '图片规格',
  `store_id` int(10) unsigned NOT NULL COMMENT '所属店铺id',
  `upload_time` int(10) unsigned NOT NULL COMMENT '图片上传时间',
  PRIMARY KEY  (`apic_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='相册图片表';

CREATE TABLE `#__article` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '索引id',
  `ac_id` mediumint(8) unsigned NOT NULL default '0' COMMENT '分类id',
  `article_url` varchar(100) DEFAULT NULL COMMENT '跳转链接',
  `article_show` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示，0为否，1为是，默认为1',
  `article_sort` tinyint(3) unsigned NOT NULL DEFAULT '255' COMMENT '排序',
  `article_title` varchar(100) DEFAULT NULL COMMENT '标题',
  `article_content` text COMMENT '内容',
  `article_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  PRIMARY KEY (`article_id`),
  KEY `ac_id` (`ac_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文章表';

CREATE TABLE `#__article_class` (
  `ac_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '索引ID',
  `ac_code` varchar(20) default NULL COMMENT '分类标识码',
  `ac_name` varchar(100) NOT NULL COMMENT '分类名称',
  `ac_parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `ac_sort` tinyint(1) unsigned NOT NULL DEFAULT '255' COMMENT '排序',
  PRIMARY KEY (`ac_id`),
  KEY `ac_parent_id` (`ac_parent_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文章分类表';

CREATE TABLE `#__attribute` (
	`attr_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '属性id',
	`attr_name` varchar(100) NOT NULL COMMENT '属性名称',
	`type_id` int(10) unsigned NOT NULL COMMENT '所属类型id',
	`attr_value` text NOT NULL COMMENT '属性值列',
	`attr_show` tinyint(1) unsigned NOT NULL COMMENT '是否显示。0为不显示、1为显示',
	`attr_sort` tinyint(1) unsigned NOT NULL COMMENT '排序',
	PRIMARY KEY  (`attr_id`),
	KEY `attr_id` (`attr_id`,`type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品属性表';

CREATE TABLE `#__attribute_value` (
	`attr_value_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '属性值id',
	`attr_value_name` varchar(100) NOT NULL COMMENT '属性值名称',
	`attr_id` int(10) unsigned NOT NULL COMMENT '所属属性id',
  `attr_value_sort` tinyint(1) unsigned NOT NULL COMMENT '属性值排序',
  PRIMARY KEY (`attr_value_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品属性值表';

CREATE TABLE `#__brand` (
  `brand_id` mediumint(11) NOT NULL AUTO_INCREMENT COMMENT '索引ID',
  `brand_name` varchar(100) DEFAULT NULL COMMENT '品牌名称',
  `brand_class` varchar(50) default NULL COMMENT '类别名称',
  `brand_pic` varchar(100) DEFAULT NULL COMMENT '图片',
  `brand_sort` tinyint(3) unsigned DEFAULT '0' COMMENT '排序',
  `brand_recommend` tinyint(1) DEFAULT '0' COMMENT '推荐，0为否，1为是，默认为0',
  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `brand_apply` tinyint(1) NOT NULL DEFAULT '1' COMMENT '品牌申请，0为申请中，1为通过，默认为1，申请功能是会员使用，系统后台默认为1',
  PRIMARY KEY (`brand_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='品牌表';

CREATE TABLE `#__cart` (
  `cart_id` int(11) NOT NULL auto_increment COMMENT '购物车id',
  `member_id` int(11) unsigned NOT NULL default '0' COMMENT '会员id',
  `store_id` int(11) unsigned NOT NULL default '0' COMMENT '店铺id',
  `goods_id` int(11) unsigned NOT NULL default '0' COMMENT '商品id',
  `goods_name` varchar(100) NOT NULL COMMENT '商品名称',
  `spec_id` int(11) unsigned NOT NULL default '0' COMMENT '规格id',
  `spec_info` text NOT NULL COMMENT '规格内容',
  `goods_store_price` decimal(10,2) NOT NULL COMMENT '商品价格',
  `goods_num` smallint(5) unsigned NOT NULL default '1' COMMENT '购买商品数量',
  `goods_images` varchar(100) NOT NULL COMMENT '商品图片',
  PRIMARY KEY  (`cart_id`),
  KEY `member_id` (`member_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='购物车数据表';

CREATE TABLE `#__complain` (
  `complain_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '投诉id',
  `order_id` int(11) NOT NULL COMMENT '订单id',
  `order_goods_count` int(11) NOT NULL COMMENT '订单商品数量',
  `complain_goods_count` int(11) NOT NULL COMMENT '投诉商品数量',
  `accuser_id` int(11) NOT NULL COMMENT '原告id',
  `accuser_name` varchar(50) NOT NULL COMMENT '原告名称',
  `accused_id` int(11) NOT NULL COMMENT '被告id',
  `accused_name` varchar(50) NOT NULL COMMENT '被告名称',
  `complain_subject_content` varchar(50) NOT NULL COMMENT '投诉主题',
  `complain_subject_id` int(11) NOT NULL COMMENT '投诉主题id',
  `complain_content` varchar(255) NOT NULL COMMENT '投诉内容',
  `complain_pic1` varchar(100) NOT NULL COMMENT '投诉图片1',
  `complain_pic2` varchar(100) NOT NULL COMMENT '投诉图片2',
  `complain_pic3` varchar(100) NOT NULL COMMENT '投诉图片3',
  `complain_datetime` int(11) NOT NULL COMMENT '投诉时间',
  `complain_handle_datetime` int(11) NOT NULL COMMENT '投诉处理时间',
  `complain_handle_member_id` int(11) NOT NULL COMMENT '投诉处理人id',
  `appeal_message` varchar(255) NOT NULL COMMENT '申诉内容',
  `appeal_datetime` int(11) NOT NULL COMMENT '申诉时间',
  `appeal_pic1` varchar(100) NOT NULL COMMENT '申诉图片1',
  `appeal_pic2` varchar(100) NOT NULL COMMENT '申诉图片2',
  `appeal_pic3` varchar(100) NOT NULL COMMENT '申诉图片3',
  `final_handle_message` varchar(255) NOT NULL COMMENT '最终处理意见',
  `final_handle_datetime` int(11) NOT NULL COMMENT '最终处理时间',
  `final_handle_member_id` int(11) NOT NULL COMMENT '最终处理人id',
  `complain_type` tinyint(4) NOT NULL COMMENT '投诉类型(1-买家投诉/2-卖家投诉)',
  `complain_state` tinyint(4) NOT NULL COMMENT '投诉状态(10-新投诉/20-投诉通过转给被投诉人/30-被投诉人已申诉/40-提交仲裁/99-已关闭)',
  `complain_active` tinyint(4) NOT NULL DEFAULT '1' COMMENT '投诉是否通过平台审批(1未通过/2通过)',
  PRIMARY KEY (`complain_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='投诉表';

CREATE TABLE `#__complain_goods` (
  `complain_goods_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '投诉商品序列id',
  `complain_id` int(11) NOT NULL COMMENT '投诉id',
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `goods_name` varchar(100) NOT NULL COMMENT '商品名称',
  `spec_id` int(11) NOT NULL COMMENT '规格id',
  `spec_info` varchar(50) NOT NULL DEFAULT '' COMMENT '规格描述',
  `goods_price` decimal(10,2) NOT NULL COMMENT '商品价格',
  `goods_num` int(11) NOT NULL COMMENT '商品数量',
  `goods_image` varchar(100) NOT NULL DEFAULT '' COMMENT '商品图片',
  `evaluation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '评价类型: 1好评 2中评 3差评',
  `comment` varchar(255) NOT NULL DEFAULT '' COMMENT '评论',
  `complain_message` varchar(100) NOT NULL COMMENT '被投诉商品的问题描述',
  PRIMARY KEY (`complain_goods_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='投诉商品表';

CREATE TABLE `#__complain_subject` (
  `complain_subject_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '投诉主题id',
  `complain_subject_content` varchar(50) NOT NULL COMMENT '投诉主题',
  `complain_subject_desc` varchar(100) NOT NULL COMMENT '投诉主题描述',
  `complain_subject_type` tinyint(4) NOT NULL COMMENT '投诉主题类型(1-买家/2-卖家)',
  `complain_subject_state` tinyint(4) NOT NULL COMMENT '投诉主题状态(1-有效/2-失效)',
  PRIMARY KEY (`complain_subject_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='投诉主题表';

CREATE TABLE `#__complain_talk` (
  `talk_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '投诉对话id',
  `complain_id` int(11) NOT NULL COMMENT '投诉id',
  `talk_member_id` int(11) NOT NULL COMMENT '发言人id',
  `talk_member_name` varchar(50) NOT NULL COMMENT '发言人名称',
  `talk_member_type` varchar(10) NOT NULL COMMENT '发言人类型(1-投诉人/2-被投诉人/3-平台)',
  `talk_content` varchar(255) NOT NULL COMMENT '发言内容',
  `talk_state` tinyint(4) NOT NULL COMMENT '发言状态(1-显示/2-不显示)',
  `talk_admin` int(11) NOT NULL DEFAULT '0' COMMENT '对话管理员，屏蔽对话人的id',
  `talk_datetime` int(11) NOT NULL COMMENT '对话发表时间',
  PRIMARY KEY (`talk_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='投诉对话表';

CREATE TABLE `#__consult` (
  `consult_id` int(10) unsigned NOT NULL auto_increment COMMENT '咨询编号',
  `goods_id` int(11) unsigned default '0' COMMENT '商品编号',
  `cgoods_name` varchar(100) NOT NULL COMMENT '商品名称',
  `member_id` int(11) NOT NULL default '0' COMMENT '咨询发布者会员编号(0：游客)',
  `cmember_name` varchar(100) default NULL COMMENT '会员名称',
  `seller_id` int(11) unsigned NOT NULL default '0' COMMENT '卖家编号',
  `email` varchar(255) default NULL COMMENT '咨询发布者邮箱',
  `consult_content` varchar(255) default NULL COMMENT '咨询内容',
  `consult_addtime` int(10) default NULL COMMENT '咨询发布时间',
  `consult_reply` varchar(255) default NULL COMMENT '咨询回复内容',
  `consult_reply_time` int(10) default NULL COMMENT '咨询回复时间',
  `isanonymous` tinyint(1) NOT NULL default '0' COMMENT '0表示不匿名 1表示匿名',
  PRIMARY KEY  (`consult_id`),
  KEY `goods_id` (`goods_id`),
  KEY `seller_id` (`seller_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='产品咨询表';

CREATE TABLE `#__coupon` (
  `coupon_id` int(11) NOT NULL auto_increment COMMENT 'id',
  `coupon_title` varchar(255) NOT NULL COMMENT '优惠券名称',
  `coupon_type` enum('1','2') default NULL COMMENT '',
  `coupon_pic` varchar(255) NOT NULL COMMENT '',
  `coupon_desc` varchar(255) NOT NULL COMMENT '优惠券描述',
  `coupon_start_date` int(10) NOT NULL COMMENT '优惠券开始日期',
  `coupon_end_date` int(10) NOT NULL COMMENT '优惠券截止日期',
  `coupon_price` decimal(10,2) NOT NULL default '0.00' COMMENT '优惠金额',
  `coupon_limit` decimal(10,2) NOT NULL default '0.00' COMMENT '金额限制',
  `store_id` int(11) default NULL COMMENT '店铺id',
  `coupon_state` enum('1','2') default '1' COMMENT '上架与下架状态',
  `coupon_storage` int(11) NOT NULL default '0' COMMENT '总共数量',
  `coupon_usage` int(11) NOT NULL default '0' COMMENT '使用数量',
  `coupon_lock` enum('1','2') NOT NULL default '1' COMMENT '是否锁定',
  `coupon_add_date` int(10) NOT NULL COMMENT '添加日期',
  `coupon_class_id` int(11) NOT NULL COMMENT '分类',
  `coupon_click` int(11) NOT NULL default '1' COMMENT '点击次数',
  `coupon_print_style` varchar(255) NOT NULL default '4STYLE' COMMENT '4STYLE STANDS FOR 4 COUPONS PER A4 PAGE, AND 8STYLE STANDS FOR 8 COUPONS PER A4 PAGE',
  `coupon_recommend` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0不推荐 1推荐到首页',
  `coupon_allowstate` tinyint(1) unsigned DEFAULT '1' COMMENT '审核状态 0为待审核 1已通过 2未通过',
  `coupon_allowremark` varchar(255) NULL COMMENT '审核备注',
  PRIMARY KEY  (`coupon_id`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='优惠券';

CREATE TABLE `#__coupon_class` (
  `class_id` int(11) NOT NULL auto_increment COMMENT '优惠券分类id',
  `class_parent_id` int(11) NOT NULL default '0' COMMENT '父类id',
  `class_name` varchar(100) NOT NULL COMMENT '分类名称',
  `class_sort` tinyint(1) unsigned NOT NULL default '0' COMMENT '排序',
  `class_show` enum('0','1') NOT NULL default '0' COMMENT '是否显示',
  PRIMARY KEY  (`class_id`),
  KEY `class_parent_id` (`class_parent_id`),
  KEY `class_sort` (`class_sort`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='优惠券分类';

CREATE TABLE `#__daddress` (
  `address_id` mediumint(10) unsigned NOT NULL auto_increment COMMENT '地址ID',
  `store_id` mediumint(10) unsigned NOT NULL default '0' COMMENT '店铺ID',
  `seller_name` varchar(50) NOT NULL default '' COMMENT '联系人',
  `area_id` mediumint(10) unsigned NOT NULL default '0' COMMENT '地区ID',
  `city_id` mediumint(9) default NULL COMMENT '市级ID',
  `area_info` varchar(255) NOT NULL default '' COMMENT '地区内容',
  `address` varchar(255) NOT NULL COMMENT '地址',
  `zip_code` char(6) default NULL COMMENT '邮编',
  `tel_phone` varchar(20) default NULL COMMENT '座机电话',
  `mob_phone` varchar(15) default NULL COMMENT '手机电话',
  `company` varchar(255) NOT NULL COMMENT '公司',
  `content` text COMMENT '备注',
  `is_default` enum('0','1') NOT NULL default '0' COMMENT '是否默认1是',
  PRIMARY KEY  (`address_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='卖家发货地址信息表';

CREATE TABLE `#__document` (
  `doc_id` mediumint(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `doc_code` varchar(255) NOT NULL COMMENT '调用标识码',
  `doc_title` varchar(255) NOT NULL COMMENT '标题',
  `doc_content` text NOT NULL COMMENT '内容',
  `doc_time` int(10) unsigned NOT NULL COMMENT '添加时间/修改时间',
  PRIMARY KEY (`doc_id`),
  UNIQUE KEY `doc_code` (`doc_code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='系统文章表';

CREATE TABLE `#__evaluate_goods` (
  `geval_id` int(11) NOT NULL auto_increment COMMENT '评价ID',
  `geval_orderid` int(11) NOT NULL COMMENT '订单表自增ID',
  `geval_orderno` bigint(20) unsigned NOT NULL COMMENT '订单编号',
  `geval_ordergoodsid` int(11) NOT NULL COMMENT '订单商品表编号',
  `geval_goodsid` int(11) NOT NULL COMMENT '商品表编号',
  `geval_goodsname` varchar(100) NOT NULL COMMENT '商品名称',
  `geval_specinfo` varchar(50) default NULL COMMENT '规格描述',
  `geval_goodsprice` decimal(10,2) default NULL COMMENT '商品价格',
  `geval_scores` tinyint(1) NOT NULL COMMENT '1代表好评 0代表中评 -1代表差评',
  `geval_content` varchar(255) default NULL COMMENT '信誉评价内容',
  `geval_isanonymous` tinyint(1) NOT NULL default '0' COMMENT '0表示不是 1表示是匿名评价',
  `geval_addtime` int(11) NOT NULL COMMENT '评价时间',
  `geval_storeid` int(11) NOT NULL COMMENT '店铺编号',
  `geval_storename` varchar(100) NOT NULL COMMENT '店铺名称',
  `geval_frommemberid` int(11) NOT NULL COMMENT '评价人编号',
  `geval_frommembername` varchar(100) NOT NULL COMMENT '评价人名称',
  `geval_tomemberid` int(11) NOT NULL COMMENT '接收人编号',
  `geval_tomembername` varchar(100) NOT NULL COMMENT '接收人用户名',
  `geval_state` tinyint(1) NOT NULL default '0' COMMENT '评价信息的状态 0为正常 1为禁止显示',
  `geval_remark` varchar(255) default NULL COMMENT '管理员对评价的处理备注',
  `geval_explain` varchar(255) default NULL COMMENT '解释内容',
  `geval_bothstate` tinyint(1) NOT NULL default '1' COMMENT '评价互评状态 1单方评价2双方互评',
  `geval_showtime` int(11) NOT NULL COMMENT '评价展示时间统计等都以该值为准',
  `geval_type` tinyint(1) NOT NULL default '1' COMMENT '评价类型 1买家评价 2卖家评价',
  PRIMARY KEY  (`geval_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='信誉评价表';

CREATE TABLE `#__evaluate_goodsstat` (
  `gevalstat_id` int(11) NOT NULL auto_increment COMMENT '自增ID',
  `gevalstat_storeid` int(11) NOT NULL COMMENT '店铺ID',
  `gevalstat_type` tinyint(1) NOT NULL COMMENT '统计类型 1最近一周 2最近一月 3最近半年 4半年以前 5总记录',
  `gevalstat_level1num` int(11) NOT NULL default '0' COMMENT '好评次数',
  `gevalstat_level2num` int(11) NOT NULL default '0' COMMENT '中评次数',
  `gevalstat_level3num` int(11) NOT NULL default '0' COMMENT '差评次数',
  PRIMARY KEY  (`gevalstat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品评价统计表';

CREATE TABLE `#__evaluate_store` (
  `seval_id` int(11) NOT NULL auto_increment COMMENT '评价ID',
  `seval_orderid` int(11) NOT NULL COMMENT '订单ID',
  `seval_orderno` varchar(100) NOT NULL COMMENT '订单编号',
  `seval_type` tinyint(1) NOT NULL COMMENT '评价类型  1表示宝贝与描述相符度 2表示卖家服务态度 3表示卖家发货速度',
  `seval_scores` tinyint(1) NOT NULL default '0' COMMENT '评价分数',
  `seval_addtime` int(11) NOT NULL COMMENT '评价时间',
  `seval_storeid` int(11) NOT NULL COMMENT '店铺编号',
  `seval_storename` varchar(100) NOT NULL COMMENT '店铺名称',
  `seval_memberid` int(11) NOT NULL COMMENT '买家编号',
  `seval_membername` varchar(100) NOT NULL COMMENT '买家名称',
  PRIMARY KEY  (`seval_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='店铺评分表';

CREATE TABLE `#__evaluate_storestat` (
  `evalstat_id` int(11) NOT NULL auto_increment COMMENT '统计ID',
  `evalstat_storeid` int(11) NOT NULL COMMENT '店铺ID',
  `evalstat_type` tinyint(1) NOT NULL COMMENT '统计类型 1表示宝贝与描述相符度 2表示卖家服务态度 3表示卖家发货速度',
  `evalstat_average` float NOT NULL default '0' COMMENT '平均分',
  `evalstat_timesnum` int(11) NOT NULL default '0' COMMENT '评价次数',
  `evalstat_onenum` int(11) NOT NULL default '0' COMMENT '一星次数',
  `evalstat_twonum` int(11) NOT NULL default '0' COMMENT '二星次数',
  `evalstat_threenum` int(11) NOT NULL default '0' COMMENT '三星次数',
  `evalstat_fournum` int(11) NOT NULL default '0' COMMENT '四星次数',
  `evalstat_fivenum` int(11) NOT NULL default '0' COMMENT '五星次数',
  PRIMARY KEY  (`evalstat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='店铺评价统计表';

CREATE TABLE `#__express` (
  `id` tinyint(1) unsigned NOT NULL auto_increment COMMENT '索引ID',
  `e_name` varchar(50) NOT NULL COMMENT '公司名称',
  `e_state` enum('0','1') NOT NULL default '1' COMMENT '状态',
  `e_code` varchar(50) NOT NULL COMMENT '编号',
  `e_letter` char(1) NOT NULL COMMENT '首字母',
  `e_order` enum('1','2') NOT NULL default '2' COMMENT '1常用2不常用',
  `e_url` varchar(100) NOT NULL COMMENT '公司网址',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='快递公司';

CREATE TABLE `#__favorites` (
  `member_id` int(10) unsigned NOT NULL COMMENT '会员ID',
  `fav_id` int(10) unsigned NOT NULL COMMENT '收藏ID',
  `fav_type` varchar(20) NOT NULL COMMENT '收藏类型',
  `fav_time` int(10) unsigned NOT NULL COMMENT '收藏时间'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='买家收藏表';

CREATE TABLE `#__flowstat_1` (
  `date` int(8) unsigned NOT NULL COMMENT '访问日期',
  `clicknum` int(11) unsigned NOT NULL COMMENT '访问量',
  `store_id` int(11) unsigned NOT NULL COMMENT '店铺ID',
  `type` varchar(10) NOT NULL COMMENT '类型',
  `goods_id` int(11) unsigned NOT NULL COMMENT '商品ID'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='访问量统计表';

CREATE TABLE `#__flowstat_2` (
  `date` int(8) unsigned NOT NULL COMMENT '访问日期',
  `clicknum` int(11) unsigned NOT NULL COMMENT '访问量',
  `store_id` int(11) unsigned NOT NULL COMMENT '店铺ID',
  `type` varchar(10) NOT NULL COMMENT '类型',
  `goods_id` int(11) unsigned NOT NULL COMMENT '商品ID'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='访问量统计表';

CREATE TABLE `#__flowstat_3` (
  `date` int(8) unsigned NOT NULL COMMENT '访问日期',
  `clicknum` int(11) unsigned NOT NULL COMMENT '访问量',
  `store_id` int(11) unsigned NOT NULL COMMENT '店铺ID',
  `type` varchar(10) NOT NULL COMMENT '类型',
  `goods_id` int(11) unsigned NOT NULL COMMENT '商品ID'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='访问量统计表';

CREATE TABLE `#__flowstat_4` (
  `date` int(8) unsigned NOT NULL COMMENT '访问日期',
  `clicknum` int(11) unsigned NOT NULL COMMENT '访问量',
  `store_id` int(11) unsigned NOT NULL COMMENT '店铺ID',
  `type` varchar(10) NOT NULL COMMENT '类型',
  `goods_id` int(11) unsigned NOT NULL COMMENT '商品ID'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='访问量统计表';

CREATE TABLE `#__flowstat_5` (
  `date` int(8) unsigned NOT NULL COMMENT '访问日期',
  `clicknum` int(11) unsigned NOT NULL COMMENT '访问量',
  `store_id` int(11) unsigned NOT NULL COMMENT '店铺ID',
  `type` varchar(10) NOT NULL COMMENT '类型',
  `goods_id` int(11) unsigned NOT NULL COMMENT '商品ID'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='访问量统计表';

CREATE TABLE `#__gold_buy` (
  `gbuy_id` int(11) NOT NULL auto_increment COMMENT '自增id',
  `gbuy_mid` int(11) NOT NULL COMMENT '购买会员编号',
  `gbuy_membername` varchar(50) NOT NULL COMMENT '会员名称',
  `gbuy_storeid` int(11) NOT NULL COMMENT '店铺编号',
  `gbuy_storename` varchar(50) NOT NULL COMMENT '店铺名称',
  `gbuy_num` int(11) NOT NULL default '0' COMMENT '购买金币数额',
  `gbuy_price` decimal(10,2) NOT NULL COMMENT '购买金币所需金额',
  `gbuy_addtime` int(11) NOT NULL COMMENT '购买记录添加时间',
  `gbuy_ispay` tinyint(4) NOT NULL default '0' COMMENT '是否已经支付 0 未支付 1已支付',
  `gbuy_adminid` int(11) default NULL COMMENT '操作记录管理员编号',
  `gbuy_sys_remark` varchar(255) default NULL COMMENT '操作备注',
  `gbuy_user_remark` varchar(255) default NULL COMMENT '用户备注',
  `gbuy_check_type` varchar(100) default NULL COMMENT '购买金币的支付类型',
  PRIMARY KEY  (`gbuy_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='金币购买记录表';

CREATE TABLE `#__gold_log` (
  `glog_id` int(11) NOT NULL auto_increment COMMENT '自增编号',
  `glog_memberid` int(11) NOT NULL COMMENT '会员编号',
  `glog_membername` varchar(50) NOT NULL COMMENT '会员名称',
  `glog_storeid` int(11) NOT NULL COMMENT '店铺编号',
  `glog_storename` varchar(50) NOT NULL COMMENT '店铺名称',
  `glog_adminid` int(11) NOT NULL COMMENT '管理员编号，如果没有管理员则该项为0',
  `glog_adminname` varchar(20) NOT NULL COMMENT '管理员名称',
  `glog_goldnum` int(11) NOT NULL default '0' COMMENT '金币数',
  `glog_method` tinyint(4) NOT NULL default '1' COMMENT '金币增减方式 1增加 2减少',
  `glog_addtime` int(11) NOT NULL COMMENT '添加时间',
  `glog_desc` varchar(255) default NULL COMMENT '操作描述',
  `glog_stage` varchar(20) NOT NULL default 'system' COMMENT '操作类型',
  PRIMARY KEY  (`glog_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='金币日志表';

CREATE TABLE `#__gold_payment` (
  `payment_id` tinyint(1) unsigned NOT NULL COMMENT '支付索引id',
  `payment_code` char(10) NOT NULL COMMENT '支付代码名称',
  `payment_name` varchar(20) NOT NULL COMMENT '支付名称',
  `payment_info` varchar(255) default NULL COMMENT '支付接口介绍',
  `payment_config` text COMMENT '支付接口配置信息',
  `payment_online` tinyint(1) unsigned default '0' COMMENT '是否为在线接口，1是，0否',
  `payment_state` tinyint(1) unsigned default '1' COMMENT '接口状态，1可用，2不可用',
  `payment_sort` tinyint(1) unsigned default '3' COMMENT '支付排序',
  PRIMARY KEY  (`payment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='金币支付方式表';

CREATE TABLE `#__goods` (
  `goods_id` int(10) unsigned NOT NULL auto_increment COMMENT '商品索引id',
  `goods_name` varchar(100) NOT NULL COMMENT '商品名称',
  `gc_id` int(10) unsigned NOT NULL COMMENT '商品分类id',
  `gc_name` varchar(200) NOT NULL COMMENT '商品分类名称',
  `brand_id` mediumint(8) unsigned NOT NULL default '0' COMMENT '商品品牌id',
  `type_id` int(10) unsigned NOT NULL default '0' COMMENT '类型id',
  `store_id` int(10) unsigned NOT NULL COMMENT '店铺id',
  `spec_open` tinyint(1) NOT NULL default '0' COMMENT '商品规格开启状态，1开启，0关闭',
  `spec_id` int(11) NOT NULL COMMENT '商品默认对应的规格id',
  `spec_name` varchar(255) NOT NULL default '' COMMENT '规格名称',
  `goods_image` varchar(100) NOT NULL COMMENT '商品默认封面图片',
  `goods_image_more` text COMMENT '商品多图',
  `goods_store_price` decimal(10,2) NOT NULL COMMENT '商品店铺价格',
  `goods_store_price_interval` varchar(30) NOT NULL default '' COMMENT '商品价格区间',
  `goods_serial` varchar(50) NOT NULL default '' COMMENT '商品货号',
  `goods_show` tinyint(1) NOT NULL COMMENT '商品上架',
  `goods_click` int(11) NOT NULL default '1' COMMENT '商品浏览数',
  `goods_state` tinyint(1) NOT NULL default '0' COMMENT '商品状态，0开启，1违规下架',
  `goods_commend` tinyint(1) NOT NULL COMMENT '商品推荐',
  `goods_add_time` int(10) unsigned NOT NULL default '0' COMMENT '商品添加时间',
  `goods_keywords` varchar(255) NOT NULL default '' COMMENT '商品关键字',
  `goods_description` varchar(255) NOT NULL default '' COMMENT '商品描述',
  `goods_body` text NOT NULL COMMENT '商品详细内容',
  `goods_attr` text COMMENT '商品属性',
  `goods_spec` text COMMENT '商品规格',
  `goods_col_img` text COMMENT '颜色自定义图片',
  `goods_starttime` int(10) unsigned NOT NULL default '0' COMMENT '发布开始时间',
  `goods_endtime` int(10) unsigned NOT NULL default '0' COMMENT '发布结束时间',
  `goods_form` tinyint(1) unsigned NOT NULL default '1' COMMENT '商品类型,1为全新、2为二手',
  `transport_id` mediumint(8) unsigned default '0' COMMENT '运费模板ID，不使用运费模板值为0',
  `py_price` decimal(10,2) default '0.00' COMMENT '平邮',
  `kd_price` decimal(10,2) default '0.00' COMMENT '快递',
  `es_price` decimal(10,2) default '0.00' COMMENT 'EMS',
  `city_id` mediumint(8) unsigned default '0' COMMENT '商品所在地(市)',
  `province_id` mediumint(8) unsigned default '0' COMMENT '商品所在地(省)',
  `goods_close_reason` varchar(255) default NULL COMMENT '商品违规下架原因',
  `goods_store_state` tinyint(1) NOT NULL default '0' COMMENT '商品所在店铺状态 0开启 1关闭',
  `commentnum` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论次数',
  `salenum` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '售出数量',
  `goods_collect` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品收藏数量',
  `goods_goldnum` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '直通车剩余金币额',
  `goods_isztc` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是直通车商品 0不是 1是直通车商品',
  `goods_ztcstate` tinyint(1) NOT NULL DEFAULT '1' COMMENT '直通车状态  1表示开启 2表示中止',
  `goods_ztcstartdate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '开始时间',
  `goods_ztclastdate` int(10) unsigned NULL COMMENT '最后消费金币的时间 如果没有设置的话则按照没有减金币情况',
  `group_flag` tinyint(1) unsigned NULL DEFAULT '0' COMMENT '团购标识(团购1/非团购0)',
  `group_price` decimal(10,2) NOT NULL default '0.00' COMMENT '团购价格',
  `xianshi_flag` tinyint(1) unsigned NOT NULL default '0' COMMENT '限时折扣商品标志(1-是/0-不是)',
  `xianshi_discount` decimal(10,2) NOT NULL default '0.00' COMMENT '限时折扣率',
  `goods_transfee_charge` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '商品运费承担方式 默认 0为买家承担 1为卖家承担',
  PRIMARY KEY  (`goods_id`),
  KEY `store_id` (`store_id`),
  KEY `gc_id` (`gc_id`),
  KEY `goods_starttime` (`goods_starttime`),
  KEY `brand_id` (`brand_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品表';

CREATE TABLE `#__goods_attr_index` (
	`goods_id` int(10) unsigned NOT NULL COMMENT '商品id',
	`gc_id` int(10) unsigned NOT NULL COMMENT '商品分类id',
	`type_id` int(10) unsigned NOT NULL COMMENT '类型id',
	`attr_id` int(10) unsigned NOT NULL COMMENT '属性id',
	`attr_value_id` int(10) unsigned NOT NULL COMMENT '属性值id',
	PRIMARY KEY (`goods_id`,`gc_id`,`attr_value_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品与属性对应表';

CREATE TABLE `#__goods_class` (
  `gc_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '索引ID',
  `gc_name` varchar(100) NOT NULL COMMENT '分类名称',
  `type_id` int(10) unsigned NOT NULL COMMENT '类型id',
  `type_name` varchar(100) NOT NULL COMMENT '类型名称',
  `store_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '店铺ID，0为系统后台发布',
  `gc_parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `gc_sort` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `gc_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT '前台显示，0为否，1为是，默认为1',
  `gc_title` varchar(200) NOT NULL COMMENT '名称',
  `gc_keywords` varchar(255) NOT NULL default '' COMMENT '关键词',
  `gc_description` varchar(255) NOT NULL default '' COMMENT '描述',
  PRIMARY KEY (`gc_id`),
  KEY `store_id` (`store_id`,`gc_parent_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品分类表';

CREATE TABLE `#__goods_class_staple` (
	`staple_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '常用分类id',
	`staple_name` varchar(255) NOT NULL COMMENT '常用分类名称',
	`gc_id` int(10) unsigned NOT NULL COMMENT '分类id',
	`type_id` int(10) unsigned NOT NULL COMMENT '类型id',
	`store_id` int(10) unsigned NOT NULL COMMENT '所属店铺id',
  PRIMARY KEY (`staple_id`),
	KEY `store_id` (`store_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='店铺常用分类表';

CREATE TABLE `#__goods_class_tag` (
	`gc_tag_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'TAGid',
	`gc_id_1` int(10) unsigned NOT NULL COMMENT '一级分类id',
	`gc_id_2` int(10) unsigned NOT NULL COMMENT '二级分类id',
	`gc_id_3` int(10) unsigned NOT NULL COMMENT '三级分类id',
	`gc_tag_name` varchar(255) NOT NULL COMMENT '分类TAG名称',
	`gc_tag_value` text NOT NULL COMMENT '分类TAG值',
	`gc_id` int(10) unsigned NOT NULL COMMENT '商品分类id',
	`type_id` int(10) unsigned NOT NULL COMMENT '类型id',
  PRIMARY KEY (`gc_tag_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品分类TAG表';

CREATE TABLE `#__goods_group` (
  `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '团购ID',
  `group_name` varchar(255) NOT NULL COMMENT '活动名称',
  `template_id` int(10) unsigned NOT NULL COMMENT '团购活动编号',
  `template_name` varchar(50) NOT NULL COMMENT '团购活动名称',
  `group_help` varchar(255) DEFAULT NULL COMMENT '活动说明',
  `start_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '开始时间',
  `end_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '结束时间',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `goods_name` varchar(200) NOT NULL COMMENT  '商品名称',
  `store_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `store_name` varchar(50) NOT NULL COMMENT  '店铺名称',
  `spec_price` varchar(255) NOT NULL COMMENT '规格价格',
  `goods_price` decimal(10,2) NOT NULL COMMENT  '商品原价',
  `groupbuy_price` decimal(10,2) NOT NULL COMMENT  '团购价格',
  `limit_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '限制类型 1.按照人数 2.按照件数',
  `virtual_quantity` int(10) unsigned NOT NULL COMMENT  '虚拟购买数量',
  `buyer_count` int(10) unsigned NOT NULL COMMENT  '已购买人数',
  `def_quantity` int(10) NOT NULL DEFAULT '0' COMMENT '已订购数',
  `min_quantity` int(10) NOT NULL DEFAULT '0' COMMENT '最小团购数量',
  `sale_quantity` int(10) NOT NULL DEFAULT '0' COMMENT '每人限购数量',
  `max_num` int(10) NOT NULL DEFAULT '0' COMMENT '最高件数',
  `group_intro` text DEFAULT NULL COMMENT '本团介绍',
  `state` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '团购状态 1.未发布 2.已取消 3.进行中 4.已完成 5.已结束',
  `recommended` tinyint(1) unsigned NOT NULL COMMENT '是否推荐 0.未推荐 1.已推荐',
  `published` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否发布 1.未发布 2.已发布',
  `views` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '查看次数',
  `cancel_intro` varchar(255) DEFAULT NULL COMMENT '取消说明',
  `class_id` int(10) unsigned NOT NULL COMMENT  '团购类别编号',
  `area_id` int(10) unsigned NOT NULL COMMENT  '团购地区编号',
  `group_pic` varchar(100) NOT NULL COMMENT  '团购图片',
  `rebate` decimal(10,2) NOT NULL COMMENT '折扣率',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  PRIMARY KEY (`group_id`),
  KEY `template_id` (`template_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='团购商品表';

CREATE TABLE `#__goods_spec` (
  `spec_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品规格索引id',
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `spec_name` varchar(255) NOT NULL COMMENT '规格名称',
  `spec_goods_price` decimal(10,2) NOT NULL COMMENT '规格商品价格',
  `spec_goods_storage` int(11) NOT NULL COMMENT '规格商品库存',
  `spec_salenum` int NOT NULL DEFAULT '0' COMMENT '售出数量',
  `spec_goods_color` varchar(20) NOT NULL COMMENT '规格商品颜色',
  `spec_goods_serial` varchar(50) NOT NULL COMMENT '规格商品编号',
  `spec_goods_spec` text NOT NULL COMMENT '商品规格序列化',
  PRIMARY KEY (`spec_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品规格表';

CREATE TABLE `#__goods_spec_index` (
	`goods_id` int(10) unsigned NOT NULL COMMENT '商品id',
	`gc_id` int(10) unsigned NOT NULL COMMENT '商品分类id',
	`type_id` int(10) unsigned NOT NULL COMMENT '类型id',
	`sp_id` int(10) unsigned NOT NULL COMMENT '规格id',
	`sp_value_id` int(10) unsigned NOT NULL COMMENT '规格值id',
	`sp_value_name` varchar(100) NULL COMMENT '规格值名称',
	PRIMARY KEY (`goods_id`,`gc_id`,`sp_value_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品与规格对应表';

CREATE TABLE  `#__groupbuy_area` (
	`area_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT  '地区编号',
	`area_name` varchar(50) NOT NULL COMMENT  '地区名称',
	`area_parent_id` int(10) unsigned NOT NULL COMMENT  '父地区编号',
	`area_sort` tinyint(1) unsigned NOT NULL COMMENT  '排序',
	`area_deep` tinyint(1) unsigned NOT NULL COMMENT  '深度',
	PRIMARY KEY (`area_id`)
) ENGINE=MYISAM  DEFAULT CHARSET=utf8 COMMENT='团购地区表';

CREATE TABLE `#__groupbuy_class` (
  `class_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '类别编号',
  `class_name` varchar(20) NOT NULL COMMENT '类别名称',
  `class_parent_id` int(10) unsigned NOT NULL COMMENT '父类别编号',
  `sort` tinyint(1) unsigned NOT NULL COMMENT '排序',
  `deep` tinyint(1) unsigned NOT NULL COMMENT '深度',
  PRIMARY KEY (`class_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='团购类别表';

CREATE TABLE `#__groupbuy_price_range` (
  `range_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '价格区间编号',
  `range_name` varchar(20) NOT NULL COMMENT '区间名称',
  `range_start` int(10) unsigned NOT NULL COMMENT '区间下限',
  `range_end` int(10) unsigned NOT NULL COMMENT '区间上限',
  PRIMARY KEY (`range_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='团购价格区间表';

CREATE TABLE `#__groupbuy_template` (
  `template_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '团购活动编号',
  `template_name` varchar(50) NOT NULL COMMENT '团购活动能够名称',
  `start_time` int(10) unsigned NOT NULL COMMENT '活动开始时间',
  `end_time` int(10) unsigned NOT NULL COMMENT '活动结束时间',
  `join_end_time` int(10) unsigned NOT NULL COMMENT '活动报名截至时间',
  `state` tinyint(1) unsigned NOT NULL COMMENT '状态(1-可报名/2-已过期)',
  PRIMARY KEY (`template_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='团购活动表';

CREATE TABLE `#__inform` (
  `inform_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '举报id',
  `inform_member_id` int(11) NOT NULL COMMENT '举报人id',
  `inform_member_name` varchar(50) NOT NULL COMMENT '举报人会员名',
  `inform_goods_id` int(11) NOT NULL COMMENT '被举报的商品id',
  `inform_goods_name` varchar(100) NOT NULL COMMENT '被举报的商品名称',
  `inform_subject_id` int(11) NOT NULL COMMENT '举报主题id',
  `inform_subject_content` varchar(50) NOT NULL COMMENT '举报主题',
  `inform_content` varchar(100) NOT NULL COMMENT '举报信息',
  `inform_pic1` varchar(100) NOT NULL COMMENT '图片1',
  `inform_pic2` varchar(100) NOT NULL COMMENT '图片2',
  `inform_pic3` varchar(100) NOT NULL COMMENT '图片3',
  `inform_datetime` int(11) NOT NULL COMMENT '举报时间',
  `inform_store_id` int(11) NOT NULL COMMENT '被举报商品的店铺id',
  `inform_state` tinyint(4) NOT NULL COMMENT '举报状态(1未处理/2已处理)',
  `inform_handle_type` tinyint(4) NOT NULL COMMENT '举报处理结果(1无效举报/2恶意举报/3有效举报)',
  `inform_handle_message` varchar(100) NOT NULL COMMENT '举报处理信息',
  `inform_handle_datetime` int(11) NOT NULL DEFAULT '0' COMMENT '举报处理时间',
  `inform_handle_member_id` int(11) NOT NULL DEFAULT '0' COMMENT '管理员id',
  PRIMARY KEY (`inform_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='举报表';

CREATE TABLE `#__inform_subject` (
  `inform_subject_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '举报主题id',
  `inform_subject_content` varchar(100) NOT NULL COMMENT '举报主题内容',
  `inform_subject_type_id` int(11) NOT NULL COMMENT '举报类型id',
  `inform_subject_type_name` varchar(50) NOT NULL COMMENT '举报类型名称 ',
  `inform_subject_state` tinyint(11) NOT NULL COMMENT '举报主题状态(1可用/2失效)',
  PRIMARY KEY (`inform_subject_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='举报主题表';

CREATE TABLE `#__inform_subject_type` (
  `inform_type_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '举报类型id',
  `inform_type_name` varchar(50) NOT NULL COMMENT '举报类型名称 ',
  `inform_type_desc` varchar(100) NOT NULL COMMENT '举报类型描述',
  `inform_type_state` tinyint(4) NOT NULL COMMENT '举报类型状态(1有效/2失效)',
  PRIMARY KEY (`inform_type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='举报类型表';

CREATE TABLE `#__link` (
  `link_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '索引id',
  `link_title` varchar(100) DEFAULT NULL COMMENT '标题',
  `link_url` varchar(100) DEFAULT NULL COMMENT '链接',
  `link_pic` varchar(100) DEFAULT NULL COMMENT '图片',
  `link_sort` tinyint(3) unsigned NOT NULL DEFAULT '255' COMMENT '排序',
  PRIMARY KEY (`link_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='合作伙伴表';

CREATE TABLE `#__mail_msg_temlates` (
  `name` varchar(100) NOT NULL COMMENT '模板名称',
  `title` varchar(100) DEFAULT NULL COMMENT '模板标题',
  `code` varchar(100) NOT NULL COMMENT '模板调用代码',
  `content` text NOT NULL COMMENT '模板内容',
  `type` tinyint(1) NOT NULL COMMENT '模板类别，0为邮件，1为短信息，默认为0',
  `mail_switch` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否开启',
  PRIMARY KEY (`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='邮件模板表';

CREATE TABLE `#__map` (
  `map_id` int(11) NOT NULL auto_increment COMMENT '地图ID',
  `member_id` int(11) NOT NULL COMMENT '会员ID',
  `member_name` varchar(20) NOT NULL COMMENT '会员名称',
  `area_id` int(11) NOT NULL COMMENT '地区ID',
  `area_info` varchar(50) NOT NULL COMMENT '地区内容',
  `address` varchar(50) default NULL COMMENT '地址',
  `point_lng` float NOT NULL default '0' COMMENT '地理经度',
  `point_lat` float NOT NULL default '0' COMMENT '地理纬度',
  `store_name` varchar(20) default NULL COMMENT '店铺名称',
  `store_id` int(11) default '0' COMMENT '店铺ID',
  `map_api` char(9) NOT NULL default 'baidu' COMMENT '地图API(暂时只有baidu)',
  PRIMARY KEY  (`map_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='地图表';

CREATE TABLE `#__member` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '会员id',
  `member_name` varchar(50) NOT NULL COMMENT '会员名称',
  `member_truename` varchar(20) default NULL COMMENT '真实姓名',
  `store_id` int(11) unsigned NOT NULL default '0' COMMENT '店铺id',
  `member_avatar` varchar(50) DEFAULT NULL COMMENT '会员头像',
  `member_sex` tinyint(1) DEFAULT NULL COMMENT '会员性别',
  `member_birthday` date DEFAULT NULL COMMENT '生日',
  `member_passwd` varchar(32) NOT NULL COMMENT '会员密码',
  `member_email` varchar(100) NOT NULL COMMENT '会员邮箱',
  `member_qq` varchar(100) DEFAULT NULL COMMENT 'qq',
  `member_ww` varchar(100) DEFAULT NULL COMMENT '阿里旺旺',
  `member_login_num` int(11) NOT NULL DEFAULT '1' COMMENT '登录次数',
  `member_time` varchar(10) NOT NULL COMMENT '会员注册时间',
  `member_login_time` varchar(10) NOT NULL COMMENT '当前登录时间',
  `member_old_login_time` varchar(10) NOT NULL COMMENT '上次登录时间',
  `member_login_ip` varchar(20) DEFAULT NULL COMMENT '当前登录ip',
  `member_old_login_ip` varchar(20) DEFAULT NULL COMMENT '上次登录ip',
  `member_goldnum` int(11) NOT NULL DEFAULT '0' COMMENT '金币数',
  `member_goldnumcount` int(11) NOT NULL DEFAULT '0' COMMENT '曾经拥有购买金币数',
  `member_goldnumminus` int(11) NOT NULL DEFAULT '0' COMMENT '已经消费金币数',
  `member_qqopenid` varchar(100) NULL COMMENT 'qq互联id',
  `member_qqinfo` text NULL COMMENT 'qq账号相关信息',
  `member_sinaopenid` varchar(100) NULL COMMENT '新浪微博登录id',
  `member_sinainfo` text NULL COMMENT '新浪账号相关信息序列化值',
  `member_points` int(11) NOT NULL DEFAULT '0' COMMENT '会员积分',
  `available_predeposit` decimal(10,2) NOT NULL DEFAULT '0' COMMENT '预存款可用金额',
  `freeze_predeposit` decimal(10,2) NOT NULL DEFAULT '0' COMMENT '预存款冻结金额',
  `inform_allow` tinyint(1) NOT NULL default '1' COMMENT '是否允许举报(1可以/2不可以)',
  `is_buy` tinyint(1) NOT NULL default '1' COMMENT '会员是否有购买权限 1为开启 0为关闭',
  `is_allowtalk` tinyint(1) NOT NULL default '1' COMMENT '会员是否有咨询和发送站内信的权限 1为开启 0为关闭',
  `member_state` tinyint(1) NOT NULL default '1' COMMENT '会员的开启状态 1为开启 0为关闭',
  `member_credit` int(11) NOT NULL default '0' COMMENT '会员信用',
  `member_snsvisitnum` int(11) NOT NULL default '0' COMMENT 'sns空间访问次数',
  `member_areaid` int(11) default NULL COMMENT '地区ID',
  `member_cityid` int(11) default NULL COMMENT '城市ID',
  `member_provinceid` int(11) default NULL COMMENT '省份ID',
  `member_areainfo` varchar(255) default NULL COMMENT '地区内容',
  PRIMARY KEY (`member_id`),
  KEY `member_name` (`member_name`,`store_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='会员表';

CREATE TABLE `#__message` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '短消息索引id',
  `message_parent_id` int(11) NOT NULL COMMENT '回复短消息message_id',
  `from_member_id` int(11) NOT NULL COMMENT '短消息发送人',
  `to_member_id` varchar(1000) NOT NULL COMMENT '短消息接收人',
  `message_title` varchar(50) DEFAULT NULL COMMENT '短消息标题',
  `message_body` varchar(255) NOT NULL COMMENT '短消息内容',
  `message_time` varchar(10) NOT NULL COMMENT '短消息发送时间',
  `message_update_time` varchar(10) DEFAULT NULL COMMENT '短消息回复更新时间',
  `message_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '短消息打开状态',
  `message_state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '短消息状态，0为正常状态，1为发送人删除状态，2为接收人删除状态',
  `message_type` tinyint(1) NOT NULL default '0' COMMENT '0为私信、1为系统消息、2为留言',
  `read_member_id` varchar(1000) NULL COMMENT '已经读过该消息的会员id',
  `del_member_id` varchar(1000) NULL COMMENT '已经删除该消息的会员id',
  `message_ismore` tinyint(1) NOT NULL DEFAULT '0' COMMENT '站内信是否为一条发给多个用户 0为否 1为多条 ',
  `from_member_name` varchar(100)  NULL COMMENT '发信息人用户名',
  `to_member_name` varchar(100) NULL COMMENT '接收人用户名',
  PRIMARY KEY (`message_id`),
  KEY `from_member_id` (`from_member_id`),
  KEY `to_member_id` (`to_member_id`),
  KEY `message_ismore` (`message_ismore`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='短消息';

CREATE TABLE `#__navigation` (
  `nav_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '索引ID',
  `nav_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类别，0自定义导航，1商品分类，2文章导航，3活动导航，默认为0',
  `nav_title` varchar(100) DEFAULT NULL COMMENT '导航标题',
  `nav_url` varchar(255) DEFAULT NULL COMMENT '导航链接',
  `nav_location` tinyint(1) NOT NULL DEFAULT '0' COMMENT '导航位置，0头部，1中部，2底部，默认为0',
  `nav_new_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否以新窗口打开，0为否，1为是，默认为0',
  `nav_sort` tinyint(3) unsigned NOT NULL DEFAULT '255' COMMENT '排序',
  `item_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '类别ID，对应着nav_type中的内容，默认为0',
  PRIMARY KEY (`nav_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='页面导航表';

CREATE TABLE `#__order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单索引id',
  `order_sn` bigint(20) unsigned NOT NULL COMMENT '订单编号，商城内部使用',
  `seller_id` int(11) NOT NULL COMMENT '卖家id',
  `store_id` int(11) NOT NULL COMMENT '卖家店铺id',
  `store_name` varchar(50) NOT NULL COMMENT '卖家店铺名称',
  `buyer_id` int(11) NOT NULL COMMENT '买家id',
  `buyer_name` varchar(50) NOT NULL COMMENT '买家姓名',
  `buyer_email` varchar(100) NOT NULL COMMENT '买家电子邮箱',
  `add_time` varchar(10) NOT NULL COMMENT '订单生成时间',
  `order_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '订单类型 0.普通 1.团购',
  `payment_id` int(11) NOT NULL COMMENT '支付方式id',
  `payment_name` varchar(50) NOT NULL COMMENT '支付方式名称',
  `payment_code` varchar(50) NOT NULL COMMENT '支付方式名称代码',
  `payment_direct` char(1) NULL DEFAULT '1' COMMENT '支付类型:1是即时到帐,2是担保交易',
  `out_sn` varchar(100) NOT NULL COMMENT '订单编号，外部支付时使用，有些外部支付系统要求特定的订单编号',
  `payment_time` varchar(10) DEFAULT NULL COMMENT '支付(付款)时间',
  `pay_message` text COMMENT '支付留言',
  `shipping_time` varchar(10) DEFAULT NULL COMMENT '配送时间',
  `shipping_express_id` tinyint(1) NOT NULL default '0' COMMENT '配送公司ID',
  `shipping_code` varchar(50) DEFAULT NULL COMMENT '物流单号',
  `out_payment_code` varchar(255) DEFAULT NULL COMMENT '外部交易平台单独使用的标识字符串',
  `finnshed_time` varchar(10) DEFAULT NULL COMMENT '订单完成时间',
  `invoice` varchar(100) DEFAULT NULL COMMENT '发票信息',
  `goods_amount` decimal(10,2) NOT NULL COMMENT '商品总价格',
  `discount` decimal(10,2) DEFAULT NULL COMMENT '折扣价格',
  `order_amount` decimal(10,2) NOT NULL COMMENT '订单总价格',
  `shipping_fee` decimal(10,2) default NULL COMMENT '运费价格',
  `shipping_name` char(3) default '' COMMENT '配送方式',
  `evaluation_status` tinyint(1) DEFAULT NULL COMMENT '评价状态 0为评价，1已评价',
  `evaluation_time` varchar(10) DEFAULT NULL COMMENT '评价时间',
  `evalseller_status` tinyint(1) NOT NULL default '0' COMMENT '卖家是否已评价买家',
  `evalseller_time` int(11) default NULL COMMENT '卖家评价买家的时间',
  `order_message` varchar(300) DEFAULT NULL COMMENT '订单留言',
  `order_state` int(11) NOT NULL DEFAULT '10' COMMENT '订单状态：10(默认):未付款;20:已付款;30:已发货;40:已收货;50:已提交;60已确认;',
  `order_pointscount` int(11) NOT NULL DEFAULT '0' COMMENT '订单赠送积分',
  `voucher_id` int(11) NULL COMMENT '代金券id',
  `voucher_price` int(11) NULL COMMENT '代金券面额',
  `voucher_code` varchar(32) NULL COMMENT '代金券编码',
  `refund_state` tinyint(1) unsigned NULL DEFAULT '0' COMMENT '退款状态:0是无退款,1是部分退款,2是全部退款',
  `return_state` tinyint(1) unsigned NULL DEFAULT '0' COMMENT '退货状态:0是无退货,1是部分退货,2是全部退货',
  `refund_amount` decimal(10,2) NULL DEFAULT '0.00' COMMENT '退款金额',
  `return_num` int(10) unsigned NULL DEFAULT '0' COMMENT '退货数量',
  `group_id` int(10) unsigned NULL DEFAULT '0' COMMENT '团购编号(非团购订单为0)',
  `group_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '团购数量',
  `xianshi_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT ' 限时折扣编号',
  `xianshi_explain` varchar(100) NOT NULL DEFAULT '' COMMENT '限时折扣说明',
  `mansong_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '满就送编号',
  `mansong_explain` varchar(200) NOT NULL DEFAULT '' COMMENT '满就送说明',
  `bundling_id` int(10) default NULL COMMENT '搭配套餐id',
  `bundling_explain` varchar(100) default NULL COMMENT '搭配套餐说明',
  `order_from` enum('1','2') default '1' COMMENT '1PC2手机端',
  `deliver_explain` text COMMENT '发货备注',
  `daddress_id` mediumint(9) NOT NULL default '0' COMMENT '发货地址ID',
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='订单表';

CREATE TABLE `#__order_address` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `true_name` varchar(50) NOT NULL COMMENT '收货人姓名',
  `area_id` int(11) NOT NULL COMMENT '地区id',
  `area_info` varchar(100) NOT NULL COMMENT '地区内容',
  `address` varchar(100) NOT NULL COMMENT '详细地址',
  `zip_code` char(6) NOT NULL COMMENT '邮政编码',
  `tel_phone` varchar(20) NOT NULL COMMENT '电话号码',
  `mob_phone` varchar(20) NOT NULL COMMENT '手机号码',
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='订单配送信息表';

CREATE TABLE `#__order_goods` (
  `rec_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单商品表索引id',
  `order_id` int(11) NOT NULL COMMENT '订单id',
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `goods_name` varchar(100) NOT NULL COMMENT '商品名称',
  `spec_id` int(11) NOT NULL COMMENT '规格id',
  `spec_info` varchar(50) DEFAULT NULL COMMENT '规格描述',
  `goods_price` decimal(10,2) NOT NULL COMMENT '商品价格',
  `goods_num` smallint(5) unsigned NOT NULL default '1' COMMENT '商品数量',
  `goods_image` varchar(100) DEFAULT NULL COMMENT '商品图片',
  `goods_returnnum` smallint(5) unsigned NULL DEFAULT '0' COMMENT '退货数量',
  `stores_id` mediumint(9) NOT NULL default '0' COMMENT '店铺ID',
  PRIMARY KEY (`rec_id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='订单商品表';

CREATE TABLE `#__order_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单处理历史索引id',
  `order_id` int(11) NOT NULL COMMENT '订单id',
  `order_state` varchar(20) NOT NULL COMMENT '订单状态信息',
  `change_state` varchar(20) NOT NULL COMMENT '下一步订单状态信息',
  `state_info` varchar(20) NOT NULL COMMENT '订单状态描述',
  `log_time` int(10) unsigned NOT NULL default '0' COMMENT '处理时间',
  `operator` varchar(30) NOT NULL COMMENT '操作人',
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='订单处理历史表';

CREATE TABLE `#__payment` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '店铺支付索引id',
  `payment_code` varchar(50) NOT NULL COMMENT '支付代码名称',
  `payment_name` varchar(50) NOT NULL COMMENT '支付名称',
  `payment_info` varchar(255) DEFAULT NULL COMMENT '支付接口介绍',
  `payment_config` text NOT NULL COMMENT '支付接口配置信息',
  `store_id` int(11) NOT NULL COMMENT '对应的店铺id',
  `payment_online` tinyint(1) NOT NULL COMMENT '是否为在线接口，1是，0否',
  `payment_state` tinyint(1) NOT NULL COMMENT '接口状态，1可用，2不可用',
  `payment_sort` int(11) NOT NULL COMMENT '支付排序',
  PRIMARY KEY (`payment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='店铺支付接口数据表';

CREATE TABLE `#__points_cart` (
  `pcart_id` int(11) NOT NULL auto_increment COMMENT '自增ID',
  `pmember_id` int(11) NOT NULL COMMENT '会员编号',
  `pgoods_id` int(11) NOT NULL COMMENT '积分礼品序号',
  `pgoods_name` varchar(100) NOT NULL COMMENT '积分礼品名称',
  `pgoods_points` int(11) NOT NULL COMMENT '积分礼品兑换积分',
  `pgoods_choosenum` int(11) NOT NULL COMMENT '选择积分礼品数量',
  `pgoods_image` varchar(100) default NULL COMMENT '积分礼品图片',
  PRIMARY KEY  (`pcart_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='积分礼品兑换购物车';

CREATE TABLE `#__points_goods` (
  `pgoods_id` int(11) NOT NULL auto_increment COMMENT '积分礼品索引id',
  `pgoods_name` varchar(100) NOT NULL COMMENT '积分礼品名称',
  `pgoods_price` decimal(10,2) NOT NULL default '0.00' COMMENT '积分礼品原价',
  `pgoods_points` int(11) NOT NULL COMMENT '积分礼品兑换所需积分',
  `pgoods_image` varchar(100) NOT NULL COMMENT '积分礼品默认封面图片',
  `pgoods_tag` varchar(100) NOT NULL COMMENT '积分礼品标签',
  `pgoods_serial` varchar(50) NOT NULL COMMENT '积分礼品货号',
  `pgoods_storage` int(11) NOT NULL default '0' COMMENT '积分礼品库存数',
  `pgoods_show` tinyint(1) NOT NULL COMMENT '积分礼品上架 0表示下架 1表示上架',
  `pgoods_commend` tinyint(1) NOT NULL COMMENT '积分礼品推荐',
  `pgoods_add_time` int(11) NOT NULL COMMENT '积分礼品添加时间',
  `pgoods_keywords` varchar(100) default NULL COMMENT '积分礼品关键字',
  `pgoods_description` varchar(200) default NULL COMMENT '积分礼品描述',
  `pgoods_body` text NOT NULL COMMENT '积分礼品详细内容',
  `pgoods_state` tinyint(1) NOT NULL default '0' COMMENT '积分礼品状态，0开启，1禁售',
  `pgoods_close_reason` varchar(255) default NULL COMMENT '积分礼品禁售原因',
  `pgoods_salenum` int(11) NOT NULL default '0' COMMENT '积分礼品售出数量',
  `pgoods_view` int(11) NOT NULL default '0' COMMENT '积分商品浏览次数',
  `pgoods_islimit` tinyint(1) NOT NULL COMMENT '是否限制每会员兑换数量',
  `pgoods_limitnum` int(11) default NULL COMMENT '每会员限制兑换数量',
  `pgoods_freightcharge` tinyint(1) NOT NULL default '0' COMMENT '运费承担方式 0表示卖家承担 1表示买家承担',
  `pgoods_freightprice` decimal(10,2) default NULL COMMENT '运费价格',
  `pgoods_islimittime` tinyint(1) NOT NULL default '0' COMMENT '是否限制兑换时间 0为不限制 1为限制',
  `pgoods_starttime` int(11) default NULL COMMENT '兑换开始时间',
  `pgoods_endtime` int(11) default NULL COMMENT '兑换结束时间',
  `pgoods_sort` int(11) NOT NULL default '0' COMMENT '礼品排序',
  PRIMARY KEY  (`pgoods_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='积分礼品表';

CREATE TABLE `#__points_log` (
	`pl_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '积分日志编号',
	`pl_memberid` int(11) NOT NULL COMMENT '会员编号',
	`pl_membername` varchar(100) NOT NULL COMMENT '会员名称',
	`pl_adminid` int(11) NULL COMMENT '管理员编号',
	`pl_adminname` varchar(100) NULL COMMENT '管理员名称',
	`pl_points` int(11) NOT NULL DEFAULT '0' COMMENT '积分数负数表示扣除',
	`pl_addtime` int(11) NOT NULL COMMENT '添加时间',
	`pl_desc` varchar(100) NOT NULL COMMENT '操作描述',
	`pl_stage` varchar(50) NOT NULL COMMENT '操作阶段',
	PRIMARY KEY (`pl_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='会员积分日志表';

CREATE TABLE `#__points_order` (
  `point_orderid` int(11) NOT NULL auto_increment COMMENT '兑换订单编号',
  `point_ordersn` varchar(100) NOT NULL COMMENT '兑换订单编号',
  `point_buyerid` int(11) NOT NULL COMMENT '兑换会员id',
  `point_buyername` varchar(50) NOT NULL COMMENT '兑换会员姓名',
  `point_buyeremail` varchar(100) NOT NULL COMMENT '兑换会员email',
  `point_addtime` int(11) NOT NULL COMMENT '兑换订单生成时间',
  `point_paymentid` int(11) NOT NULL COMMENT '支付方式id',
  `point_paymentname` varchar(50) NOT NULL COMMENT '支付方式名称',
  `point_paymentcode` varchar(50) NOT NULL COMMENT '支付方式名称代码',
  `point_paymentdirect` tinyint(1) default '1' COMMENT '支付类型:1是即时到帐,2是但保交易',
  `point_outsn` varchar(100) NOT NULL COMMENT '订单编号，外部支付时使用，有些外部支付系统要求特定的订单编号',
  `point_paymenttime` int(11) default NULL COMMENT '支付(付款)时间',
  `point_paymessage` varchar(300) default NULL COMMENT '支付留言',
  `point_shippingtime` int(11) default NULL COMMENT '配送时间',
  `point_shippingcode` varchar(50) default NULL COMMENT '物流单号',
  `point_shippingdesc` varchar(500) default NULL COMMENT '发货描述',
  `point_outpaymentcode` varchar(255) default NULL COMMENT '外部交易平台单独使用的标识字符串',
  `point_finnshedtime` int(11) default NULL COMMENT '订单完成时间',
  `point_allpoint` int(11) NOT NULL default '0' COMMENT '兑换总积分',
  `point_orderamount` decimal(10,2) NOT NULL COMMENT '兑换订单总金额',
  `point_shippingcharge` tinyint(1) NOT NULL default '0' COMMENT '运费承担方式 0表示卖家 1表示买家',
  `point_shippingfee` decimal(10,2) NOT NULL default '0.00' COMMENT '运费金额',
  `point_ordermessage` varchar(300) default NULL COMMENT '订单留言',
  `point_orderstate` int(11) NOT NULL default '10' COMMENT '订单状态：10(默认):未付款;11已付款;20:确认付款;30:已发货;40:已收货;50已完成;2已取消',
  PRIMARY KEY  (`point_orderid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='兑换订单表';

CREATE TABLE `#__points_orderaddress` (
  `point_oaid` int(11) NOT NULL auto_increment COMMENT '自增id',
  `point_orderid` int(11) NOT NULL COMMENT '订单id',
  `point_truename` varchar(50) NOT NULL COMMENT '收货人姓名',
  `point_areaid` int(11) NOT NULL COMMENT '地区id',
  `point_areainfo` varchar(100) NOT NULL COMMENT '地区内容',
  `point_address` varchar(200) NOT NULL COMMENT '详细地址',
  `point_zipcode` varchar(20) NOT NULL COMMENT '邮政编码',
  `point_telphone` varchar(20) NOT NULL COMMENT '电话号码',
  `point_mobphone` varchar(20) NOT NULL COMMENT '手机号码',
  PRIMARY KEY  (`point_oaid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='兑换订单地址表';

CREATE TABLE `#__points_ordergoods` (
  `point_recid` int(11) NOT NULL auto_increment COMMENT '订单礼品表索引',
  `point_orderid` int(11) NOT NULL COMMENT '订单id',
  `point_goodsid` int(11) NOT NULL COMMENT '礼品id',
  `point_goodsname` varchar(100) NOT NULL COMMENT '礼品名称',
  `point_goodspoints` int(11) NOT NULL COMMENT '礼品兑换积分',
  `point_goodsnum` int(11) NOT NULL COMMENT '礼品数量',
  `point_goodsimage` varchar(100) default NULL COMMENT '礼品图片',
  PRIMARY KEY  (`point_recid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='兑换订单商品表';

CREATE TABLE `#__predeposit_cash` (
  `pdcash_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增编号',
  `pdcash_sn` varchar(100) NOT NULL COMMENT '记录唯一标示',
  `pdcash_memberid` int(11) NOT NULL COMMENT '会员编号',
  `pdcash_membername` varchar(50) NOT NULL COMMENT '会员名称',
  `pdcash_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
  `pdcash_payment` varchar(50) NOT NULL COMMENT '支付方式',
  `pdcash_paymentaccount` varchar(100) DEFAULT NULL COMMENT '支付账号',
  `pdcash_toname` varchar(100) DEFAULT NULL COMMENT '收款人姓名',
  `pdcash_tobank` varchar(100) DEFAULT NULL COMMENT '收款银行',
  `pdcash_memberremark` varchar(1000) DEFAULT NULL COMMENT '会员提现备注',
  `pdcash_addtime` int(11) NOT NULL COMMENT '添加时间',
  `pdcash_paystate` tinyint(1) NOT NULL DEFAULT '0' COMMENT '提现支付状态 0为未支付 1为支付',
  `pdcash_adminid` int(11) DEFAULT NULL COMMENT '管理员编号',
  `pdcash_adminname` varchar(100) DEFAULT NULL COMMENT '管理员姓名',
  `pdcash_adminremark` varchar(1000) DEFAULT NULL COMMENT '管理员备注',
  `pdcash_remark` varchar(1000) DEFAULT NULL COMMENT '管理员和会员都可查看的备注',
  PRIMARY KEY (`pdcash_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='预存款提现记录表';

CREATE TABLE `#__predeposit_log` (
  `pdlog_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增编号',
  `pdlog_memberid` int(11) NOT NULL COMMENT '会员编号',
  `pdlog_membername` varchar(50) NOT NULL COMMENT '会员名称',
  `pdlog_adminid` int(11) DEFAULT NULL COMMENT '管理员编号',
  `pdlog_adminname` varchar(50) DEFAULT NULL COMMENT '管理员名称',
  `pdlog_stage` enum('system','recharge','cash','order','admin','income','') NOT NULL default '' COMMENT '日志类型 枚举 system 系统自动 recharge 充值 cash 提现 order 订单 admin 管理员手动修改 income收入',
  `pdlog_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '日志类型 0表示可用金额 1表示冻结金额',
  `pdlog_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
  `pdlog_addtime` int(11) NOT NULL COMMENT '添加时间',
  `pdlog_desc` varchar(1000) DEFAULT NULL COMMENT '描述',
  PRIMARY KEY (`pdlog_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='预存款日志表';

CREATE TABLE `#__predeposit_recharge` (
  `pdr_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增编号',
  `pdr_sn` varchar(100) NOT NULL COMMENT '记录唯一标示',
  `pdr_memberid` int(11) NOT NULL COMMENT '会员编号',
  `pdr_membername` varchar(50) NOT NULL COMMENT '会员名称',
  `pdr_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '充值金额',
  `pdr_payment` varchar(50) DEFAULT NULL COMMENT '支付方式',
  `pdr_onlinecode` varchar(100) DEFAULT NULL COMMENT '线上支付的交易流水号',
  `pdr_remittancename` varchar(100) DEFAULT NULL COMMENT '汇款人姓名',
  `pdr_remittancebank` varchar(100) DEFAULT NULL COMMENT '汇款银行',
  `pdr_remittancedate` int(11) DEFAULT NULL COMMENT '汇款日期',
  `pdr_memberremark` varchar(1000) DEFAULT NULL COMMENT '会员备注',
  `pdr_addtime` int(11) NOT NULL COMMENT '添加时间',
  `pdr_paystate` tinyint(1) NOT NULL DEFAULT '0' COMMENT '支付状态 0表示未支付 1表示支付',
  `pdr_adminid` int(11) DEFAULT NULL COMMENT '管理员编号',
  `pdr_adminname` varchar(100) DEFAULT NULL COMMENT '管理员名称',
  `pdr_adminremark` varchar(1000) DEFAULT NULL COMMENT '管理员备注',
  PRIMARY KEY (`pdr_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='预存款充值信息表';

CREATE TABLE `#__p_bundling` (
  `bl_id` int(11) NOT NULL auto_increment COMMENT '组合ID',
  `bl_name` varchar(50) NOT NULL COMMENT '组合名称',
  `store_id` int(11) NOT NULL COMMENT '店铺名称',
  `store_name` varchar(50) NOT NULL COMMENT '店铺名称',
  `bl_img_more` varchar(1000) NOT NULL COMMENT '商品多图',
  `bl_discount_price` decimal(10,2) NOT NULL COMMENT '组合价格',
  `bl_freight_choose` tinyint(1) NOT NULL COMMENT '运费承担方式',
  `bl_freight` decimal(10,2) NOT NULL COMMENT '运费',
  `bl_desc` text NOT NULL COMMENT '组合描述',
  `bl_state` tinyint(1) NOT NULL default '1' COMMENT '组合状态 0-关闭/1-开启',
  PRIMARY KEY  (`bl_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='组合销售活动表';

CREATE TABLE `#__p_bundling_goods` (
  `bl_goods_id` int(11) NOT NULL auto_increment COMMENT '组合商品id',
  `bl_id` int(11) NOT NULL COMMENT '组合id',
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `goods_name` varchar(50) NOT NULL COMMENT '商品名称',
  PRIMARY KEY  (`bl_goods_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='组合销售活动商品表';

CREATE TABLE `#__p_bundling_quota` (
  `bl_quota_id` int(11) NOT NULL auto_increment COMMENT '套餐ID',
  `store_id` int(11) NOT NULL COMMENT '店铺id',
  `store_name` varchar(50) NOT NULL COMMENT '店铺名称',
  `member_id` int(11) NOT NULL COMMENT '会员id',
  `member_name` varchar(50) NOT NULL COMMENT '会员名称',
  `bl_quota_month` tinyint(3) unsigned NOT NULL COMMENT '购买数量（单位月）',
  `bl_quota_starttime` varchar(10) NOT NULL COMMENT '套餐开始时间',
  `bl_quota_endtime` varchar(10) NOT NULL COMMENT '套餐结束时间',
  `bl_quota_state` tinyint(1) unsigned NOT NULL COMMENT '套餐状态：0关闭，1开启。默认为 1',
  `bl_pay_gold` int(10) unsigned NOT NULL COMMENT '花费金币数量',
  PRIMARY KEY  (`bl_quota_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='组合销售套餐表';

CREATE TABLE `#__p_mansong` (
  `mansong_id` int(10) unsigned NOT NULL auto_increment COMMENT '满送活动编号',
  `mansong_name` varchar(50) NOT NULL COMMENT '活动名称',
  `quota_id` int(10) unsigned NOT NULL COMMENT '套餐编号',
  `start_time` int(10) unsigned NOT NULL COMMENT '活动开始时间',
  `end_time` int(10) unsigned NOT NULL COMMENT '活动结束时间',
  `member_id` int(10) unsigned NOT NULL COMMENT '用户编号',
  `store_id` int(10) unsigned NOT NULL COMMENT '店铺编号',
  `member_name` varchar(50) NOT NULL COMMENT '用户名',
  `store_name` varchar(50) NOT NULL COMMENT '店铺名称',
  `state` tinyint(1) unsigned NOT NULL COMMENT '活动状态(1-未发布/2-正常/3-取消/4-失效/5-结束)',
  `remark` varchar(200) NOT NULL COMMENT '备注',
  PRIMARY KEY  (`mansong_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='满就送活动表';

CREATE TABLE `#__p_mansong_apply` (
  `apply_id` int(10) unsigned NOT NULL auto_increment COMMENT '申请编号',
  `member_id` int(10) unsigned NOT NULL COMMENT '用户编号',
  `member_name` varchar(50) NOT NULL COMMENT '用户名',
  `store_id` int(10) unsigned NOT NULL COMMENT '店铺编号',
  `store_name` varchar(50) NOT NULL COMMENT '店铺名称',
  `apply_quantity` tinyint(1) unsigned NOT NULL COMMENT '申请数量',
  `apply_date` int(10) unsigned NOT NULL COMMENT '申请时间',
  `state` tinyint(1) unsigned NOT NULL COMMENT '状态(1-新申请/2-审核通过/3-已取消/4-审核失败)',
  PRIMARY KEY  (`apply_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='满就送套餐申请表';

CREATE TABLE `#__p_mansong_quota` (
  `quota_id` int(10) unsigned NOT NULL auto_increment COMMENT '满就送套餐编号',
  `apply_id` int(10) unsigned NOT NULL COMMENT '申请编号',
  `member_id` int(10) unsigned NOT NULL COMMENT '用户编号',
  `store_id` int(10) unsigned NOT NULL COMMENT '店铺编号',
  `member_name` varchar(50) NOT NULL COMMENT '用户名',
  `store_name` varchar(50) NOT NULL COMMENT '店铺名称',
  `start_time` int(10) unsigned NOT NULL COMMENT '开始时间',
  `end_time` int(10) unsigned NOT NULL COMMENT '结束时间',
  `state` tinyint(1) unsigned NOT NULL COMMENT '配额状态(1-可用/2-取消/3-结束)',
  PRIMARY KEY  (`quota_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='满就送套餐表';

CREATE TABLE `#__p_mansong_rule` (
  `rule_id` int(10) unsigned NOT NULL auto_increment COMMENT '规则编号',
  `mansong_id` int(10) unsigned NOT NULL COMMENT '活动编号',
  `level` tinyint(1) unsigned NOT NULL COMMENT '规则级别(1/2/3)',
  `price` int(10) unsigned NOT NULL COMMENT '级别价格',
  `shipping_free` tinyint(1) unsigned NOT NULL COMMENT '免邮标志(0-不免邮/1-免邮费)',
  `discount` int(10) unsigned NOT NULL COMMENT '减现金优惠金额',
  `gift_name` varchar(50) NOT NULL COMMENT '礼品名称',
  `gift_link` varchar(100) NOT NULL COMMENT '礼品链接',
  PRIMARY KEY (`rule_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='满就送活动规则表';

CREATE TABLE `#__p_xianshi` (
  `xianshi_id` int(10) unsigned NOT NULL auto_increment COMMENT '限时编号',
  `goods_limit` int(10) unsigned NOT NULL COMMENT '商品限制',
  `xianshi_name` varchar(50) NOT NULL COMMENT '活动名称',
  `quota_id` int(10) unsigned NOT NULL COMMENT '套餐编号',
  `start_time` int(10) unsigned NOT NULL COMMENT '活动开始时间',
  `end_time` int(10) unsigned NOT NULL COMMENT '活动结束时间',
  `member_id` int(10) unsigned NOT NULL COMMENT '用户编号',
  `store_id` int(10) unsigned NOT NULL COMMENT '店铺编号',
  `member_name` varchar(50) NOT NULL COMMENT '用户名',
  `store_name` varchar(50) NOT NULL COMMENT '店铺名称',
  `discount` decimal(10,2) NOT NULL COMMENT '活动折扣',
  `buy_limit` int(10) unsigned NOT NULL COMMENT '购买限制',
  `state` tinyint(1) unsigned NOT NULL COMMENT '活动状态(1-未发布/2-正常/3-取消/4-失效/5-结束)',
  PRIMARY KEY  (`xianshi_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='限时折扣活动表';

CREATE TABLE `#__p_xianshi_apply` (
  `apply_id` int(10) unsigned NOT NULL auto_increment COMMENT '申请编号',
  `member_id` int(10) unsigned NOT NULL COMMENT '用户编号',
  `member_name` varchar(50) NOT NULL COMMENT '用户名',
  `store_id` int(10) unsigned NOT NULL COMMENT '店铺编号',
  `store_name` varchar(50) NOT NULL COMMENT '店铺名称',
  `apply_quantity` tinyint(1) unsigned NOT NULL COMMENT '申请数量',
  `apply_date` int(10) unsigned NOT NULL COMMENT '申请时间',
  `state` tinyint(1) unsigned NOT NULL COMMENT '状态(1-新申请/2-审核通过/3-已取消/4-审核失败)',
  PRIMARY KEY  (`apply_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='限时折扣套餐申请表';

CREATE TABLE `#__p_xianshi_goods` (
  `xianshi_goods_id` int(10) unsigned NOT NULL auto_increment COMMENT '限时折扣商品表',
  `xianshi_id` int(10) unsigned NOT NULL COMMENT '限时活动编号',
  `xianshi_name` varchar(50) NOT NULL COMMENT '活动名称',
  `quota_id` int(10) unsigned NOT NULL COMMENT '套餐编号',
  `goods_id` int(10) unsigned NOT NULL COMMENT '商品编号',
  `goods_name` varchar(100) NOT NULL COMMENT '商品名称',
  `goods_store_price` decimal(10,2) NOT NULL COMMENT '店铺价格',
  `discount` decimal(10,2) NOT NULL COMMENT '折扣',
  `buy_limit` int(10) unsigned NOT NULL COMMENT '购买限额',
  `xianshi_price` decimal(10,2) NOT NULL COMMENT '限时折扣价格',
  `goods_image` varchar(100) NOT NULL COMMENT '商品图片',
  `state` tinyint(1) unsigned NOT NULL COMMENT '状态(1-可用/2-取消)',
  PRIMARY KEY  (`xianshi_goods_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='限时折扣商品表';

CREATE TABLE `#__p_xianshi_quota` (
  `quota_id` int(10) unsigned NOT NULL auto_increment COMMENT '限时折扣套餐编号',
  `apply_id` int(10) unsigned NOT NULL COMMENT '申请编号',
  `member_id` int(10) unsigned NOT NULL COMMENT '用户编号',
  `store_id` int(10) unsigned NOT NULL COMMENT '店铺编号',
  `member_name` varchar(50) NOT NULL COMMENT '用户名',
  `store_name` varchar(50) NOT NULL COMMENT '店铺名称',
  `start_time` int(10) unsigned NOT NULL COMMENT '套餐开始时间',
  `end_time` int(10) unsigned NOT NULL COMMENT '套餐结束时间',
  `times_limit` int(10) unsigned NOT NULL COMMENT '套餐时间限制',
  `published_times` int(10) unsigned NOT NULL COMMENT '已发布次数',
  `goods_limit` int(10) unsigned NOT NULL COMMENT '活动商品数限制',
  `state` tinyint(1) unsigned NOT NULL COMMENT '配额状态(1-可用/2-取消/3-结束)',
  PRIMARY KEY  (`quota_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='限时折扣套餐表';

CREATE TABLE `#__recommend` (
  `recommend_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '索引ID',
  `recommend_name` varchar(50) DEFAULT NULL COMMENT '名称',
  `recommend_code` varchar(255) NOT NULL COMMENT '推荐标识码',
  `recommend_desc` varchar(255) NOT NULL COMMENT '推荐描述',
  `recommend_config` varchar(255) NULL COMMENT '配置信息',
  PRIMARY KEY (`recommend_id`),
  UNIQUE KEY `recommend_code` (`recommend_code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='推荐类型表';

CREATE TABLE `#__recommend_goods` (
  `recommend_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '推荐ID',
  `goods_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `sort` tinyint(1) unsigned NOT NULL DEFAULT '255' COMMENT '排序',
  PRIMARY KEY (`recommend_id`,`goods_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='推荐商品表';

CREATE TABLE `#__rec_position` (
  `rec_id` mediumint(8) unsigned NOT NULL auto_increment,
  `pic_type` enum('1','2','0') NOT NULL default '1' COMMENT '0文字1本地图片2远程',
  `title` varchar(200) NOT NULL default '' COMMENT '标题',
  `content` text NOT NULL COMMENT '序列化推荐位内容',
  PRIMARY KEY  (`rec_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='推荐位';

CREATE TABLE `#__refund_log` (
  `log_id` int(10) unsigned NOT NULL auto_increment COMMENT '退款记录ID',
  `order_id` int(10) unsigned NOT NULL COMMENT '订单ID',
  `refund_sn` varchar(100) NOT NULL COMMENT '退款编号',
  `order_sn` varchar(100) NOT NULL COMMENT '订单编号',
  `seller_id` int(10) unsigned NOT NULL COMMENT '卖家ID',
  `store_id` int(10) unsigned NOT NULL COMMENT '店铺ID',
  `store_name` varchar(20) NOT NULL COMMENT '店铺名称',
  `buyer_id` int(10) unsigned NOT NULL COMMENT '买家ID',
  `buyer_name` varchar(50) NOT NULL COMMENT '买家会员名',
  `add_time` int(10) unsigned NOT NULL COMMENT '添加时间',
  `order_amount` decimal(10,2) NOT NULL COMMENT '订单金额',
  `order_refund` decimal(10,2) NOT NULL COMMENT '退款金额',
  `refund_paymentname` varchar(50) NOT NULL COMMENT '支付方式名称',
  `refund_paymentcode` varchar(50) NOT NULL COMMENT '支付方式代码',
  `refund_message` varchar(300) default NULL COMMENT '退款备注',
  `buyer_message` varchar(300) default NULL COMMENT '退款原因',
  `admin_message` varchar(300) default NULL COMMENT '管理员处理原因',
  `seller_time` int(10) unsigned default '0' COMMENT '卖家处理时间',
  `admin_time` int(10) unsigned default '0' COMMENT '管理员处理时间',
  `confirm_time` int(10) unsigned default '0' COMMENT '买家确认收款时间',
  `refund_type` tinyint(1) unsigned default '2' COMMENT '类型:1为买家,2为卖家,默认为2',
  `refund_state` tinyint(1) unsigned default '2' COMMENT '状态:1为待处理,2为同意,3为拒绝,默认为2',
  `buyer_confirm` tinyint(1) unsigned default '2' COMMENT '确认收款状态:1为待确认,2为已确认,默认为2',
  PRIMARY KEY  (`log_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='退款表';

CREATE TABLE `#__return` (
  `return_id` int(10) unsigned NOT NULL auto_increment COMMENT '退货记录ID',
  `order_id` int(10) unsigned NOT NULL COMMENT '订单ID',
  `return_sn` varchar(100) NOT NULL COMMENT '退货编号',
  `order_sn` varchar(100) NOT NULL COMMENT '订单编号',
  `seller_id` int(10) unsigned NOT NULL COMMENT '卖家ID',
  `store_id` int(10) unsigned NOT NULL COMMENT '店铺ID',
  `store_name` varchar(20) NOT NULL COMMENT '店铺名称',
  `buyer_id` int(10) unsigned NOT NULL COMMENT '买家ID',
  `buyer_name` varchar(50) NOT NULL COMMENT '买家会员名',
  `return_goodsnum` int(10) unsigned NOT NULL COMMENT '退货数量',
  `add_time` int(10) unsigned NOT NULL COMMENT '添加时间',
  `seller_time` int(10) unsigned default '0' COMMENT '卖家处理时间',
  `return_message` varchar(300) default NULL COMMENT '退货备注',
  `buyer_message` varchar(300) default NULL COMMENT '退款原因',
  `return_type` tinyint(1) unsigned default '2' COMMENT '类型:1为买家,2为卖家,默认为2',
  `return_state` tinyint(1) unsigned default '2' COMMENT '状态:1为待审核,2为同意,3为不同意,默认为2',
  PRIMARY KEY  (`return_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='退货表';

CREATE TABLE `#__return_goods` (
  `log_id` int(10) unsigned NOT NULL auto_increment COMMENT '退货商品记录ID',
  `return_id` int(10) unsigned NOT NULL COMMENT '退货记录ID',
  `order_id` int(10) unsigned NOT NULL COMMENT '订单ID',
  `goods_id` int(10) unsigned NOT NULL COMMENT '商品ID',
  `goods_name` varchar(100) NOT NULL COMMENT '商品名称',
  `spec_id` int(10) unsigned NOT NULL COMMENT '规格ID',
  `spec_info` varchar(50) default NULL COMMENT '规格描述',
  `goods_price` decimal(10,2) NOT NULL COMMENT '商品价格',
  `goods_num` int(10) unsigned NOT NULL COMMENT '商品数量',
  `goods_returnnum` int(10) unsigned NOT NULL COMMENT '退货数量',
  `goods_image` varchar(100) default NULL COMMENT '商品图片',
  PRIMARY KEY  (`log_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='退货商品表';

CREATE TABLE `#__salenum` (
  `date` int(8) unsigned NOT NULL COMMENT '销售日期',
  `salenum` int(11) unsigned NOT NULL COMMENT '销量',
  `goods_id` int(11) unsigned NOT NULL COMMENT '商品ID',
  `store_id` int(11) unsigned NOT NULL COMMENT '店铺ID'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='销量统计表';

CREATE TABLE `#__seo` (
  `id` mediumint(8) unsigned NOT NULL auto_increment  COMMENT '主键',
  `title` varchar(255) NOT NULL  COMMENT '标题',
  `keywords` varchar(255) NOT NULL  COMMENT '关键词',
  `description` text NOT NULL  COMMENT '描述',
  `type` varchar(20) NOT NULL COMMENT '类型',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='SEO信息存放表';

CREATE TABLE `#__setting` (
  `name` varchar(50) NOT NULL COMMENT '名称',
  `value` text COMMENT '值',
  PRIMARY KEY  (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='系统设置表';

CREATE TABLE `#__sns_albumclass` (
  `ac_id` int(10) unsigned NOT NULL auto_increment COMMENT '相册id',
  `ac_name` varchar(100) NOT NULL COMMENT '相册名称',
  `member_id` int(10) unsigned NOT NULL COMMENT '所属会员id',
  `ac_des` varchar(255) NOT NULL COMMENT '相册描述',
  `ac_sort` tinyint(3) unsigned NOT NULL COMMENT '排序',
  `ac_cover` varchar(255) NOT NULL COMMENT '相册封面',
  `upload_time` int(10) unsigned NOT NULL COMMENT '图片上传时间',
  `is_default` tinyint(1) unsigned NOT NULL default '0' COMMENT '是否为买家秀相册  1为是,0为否',
  PRIMARY KEY  (`ac_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='相册表';

CREATE TABLE `#__sns_albumpic` (
  `ap_id` int(10) unsigned NOT NULL auto_increment COMMENT '相册图片表id',
  `ap_name` varchar(100) NOT NULL COMMENT '图片名称',
  `ac_id` int(10) unsigned NOT NULL COMMENT '相册id',
  `ap_cover` varchar(255) NOT NULL COMMENT '图片路径',
  `ap_size` int(10) unsigned NOT NULL COMMENT '图片大小',
  `ap_spec` varchar(100) NOT NULL COMMENT '图片规格',
  `member_id` int(10) unsigned NOT NULL COMMENT '所属店铺id',
  `upload_time` int(10) unsigned NOT NULL COMMENT '图片上传时间',
  `ap_type` tinyint(4) NOT NULL default '0' COMMENT '图片类型，0为无、1为买家秀',
  `item_id` tinyint(4) NOT NULL default '0' COMMENT '信息ID',
  PRIMARY KEY  (`ap_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='相册图片表';

CREATE TABLE `#__sns_binding` (
  `snsbind_id` int(11) NOT NULL auto_increment COMMENT '自增ID',
  `snsbind_memberid` int(11) NOT NULL COMMENT '会员编号',
  `snsbind_membername` varchar(100) NOT NULL COMMENT '会员名称',
  `snsbind_appsign` varchar(50) NOT NULL COMMENT '应用标志',
  `snsbind_updatetime` int(11) NOT NULL COMMENT '绑定更新时间',
  `snsbind_openid` varchar(100) NOT NULL COMMENT '应用用户编号',
  `snsbind_openinfo` text COMMENT '应用用户信息',
  `snsbind_accesstoken` varchar(100) NOT NULL COMMENT '访问第三方资源的凭证',
  `snsbind_expiresin` int(11) NOT NULL COMMENT 'accesstoken过期时间，以返回的时间的准，单位为秒，注意过期时提醒用户重新授权',
  `snsbind_refreshtoken` varchar(100) default NULL COMMENT '刷新token',
  PRIMARY KEY  (`snsbind_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='分享应用用户绑定记录表';

CREATE TABLE `#__sns_comment` (
  `comment_id` int(11) NOT NULL auto_increment COMMENT '自增ID',
  `comment_memberid` int(11) NOT NULL COMMENT '会员ID',
  `comment_membername` varchar(100) NOT NULL COMMENT '会员名称',
  `comment_memberavatar` varchar(100) default NULL COMMENT '会员头像',
  `comment_originalid` int(11) NOT NULL COMMENT '原帖ID',
  `comment_originaltype` tinyint(1) NOT NULL default '0' COMMENT '原帖类型 0表示动态信息 1表示分享商品 默认为0',
  `comment_content` varchar(500) NOT NULL COMMENT '评论内容',
  `comment_addtime` int(11) NOT NULL COMMENT '添加时间',
  `comment_ip` varchar(50) NOT NULL COMMENT '来源IP',
  `comment_state` tinyint(1) NOT NULL default '0' COMMENT '状态 0正常 1屏蔽',
  PRIMARY KEY  (`comment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='评论表';

CREATE TABLE `#__sns_friend` (
  `friend_id` int(11) NOT NULL auto_increment COMMENT 'id值',
  `friend_frommid` int(11) NOT NULL COMMENT '会员id',
  `friend_frommname` varchar(100) default NULL COMMENT '会员名称',
  `friend_frommavatar` varchar(100) default NULL COMMENT '会员头像',
  `friend_tomid` int(11) NOT NULL COMMENT '朋友id',
  `friend_tomname` varchar(100) NOT NULL COMMENT '好友会员名称',
  `friend_tomavatar` varchar(100) default NULL COMMENT '朋友头像',
  `friend_addtime` int(11) NOT NULL COMMENT '添加时间',
  `friend_followstate` tinyint(1) NOT NULL default '1' COMMENT '关注状态 1为单方关注 2为双方关注',
  PRIMARY KEY  (`friend_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='好友数据表';

CREATE TABLE `#__sns_goods` (
  `snsgoods_goodsid` int(11) NOT NULL COMMENT '商品ID',
  `snsgoods_goodsname` varchar(100) NOT NULL COMMENT '商品名称',
  `snsgoods_goodsimage` varchar(100) default NULL COMMENT '商品图片',
  `snsgoods_goodsprice` decimal(10,2) NOT NULL default '0.00' COMMENT '商品价格',
  `snsgoods_storeid` int(11) NOT NULL COMMENT '店铺ID',
  `snsgoods_storename` varchar(100) NOT NULL COMMENT '店铺名称',
  `snsgoods_addtime` int(11) NOT NULL COMMENT '添加时间',
  `snsgoods_likenum` int(11) NOT NULL default '0' COMMENT '喜欢数',
  `snsgoods_likemember` text COMMENT '喜欢过的会员ID，用逗号分隔',
  `snsgoods_sharenum` int(11) NOT NULL default '0' COMMENT '分享数',
  UNIQUE KEY `snsgoods_goodsid` (`snsgoods_goodsid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='SNS商品表';

CREATE TABLE `#__sns_membertag` (
  `mtag_id` int(10) NOT NULL auto_increment COMMENT '会员标签id',
  `mtag_name` varchar(20) NOT NULL COMMENT '会员标签名称',
  `mtag_sort` tinyint(4) NOT NULL default '0' COMMENT '会员标签排序',
  `mtag_recommend` tinyint(4) NOT NULL default '0' COMMENT '标签推荐 0未推荐（默认），1为已推荐',
  `mtag_desc` varchar(50) NOT NULL COMMENT '标签描述',
  `mtag_img` varchar(50) default NULL COMMENT '标签图片',
  PRIMARY KEY  (`mtag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='会员标签表';

CREATE TABLE `#__sns_mtagmember` (
  `mtag_id` int(11) NOT NULL COMMENT '会员标签表id',
  `member_id` int(11) NOT NULL COMMENT '会员id',
  `recommend` tinyint(4) NOT NULL default '0' COMMENT '推荐，默认为0',
  PRIMARY KEY  (`mtag_id`,`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='会员标签会员对照表';

CREATE TABLE `#__sns_setting` (
  `member_id` int(11) NOT NULL COMMENT '会员id',
  `setting_skin` varchar(50) default NULL COMMENT '皮肤',
  PRIMARY KEY  (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='个人中心设置表';

CREATE TABLE `#__sns_sharegoods` (
  `share_id` int(11) NOT NULL auto_increment COMMENT '自增ID',
  `share_goodsid` int(11) NOT NULL COMMENT '商品ID',
  `share_memberid` int(11) NOT NULL COMMENT '所属会员ID',
  `share_membername` varchar(100) NOT NULL COMMENT '会员名称',
  `share_content` varchar(500) default NULL COMMENT '描述内容',
  `share_addtime` int(11) NOT NULL COMMENT '分享操作时间',
  `share_likeaddtime` int(11) NOT NULL default '0' COMMENT '喜欢操作时间',
  `share_privacy` tinyint(1) NOT NULL default '0' COMMENT '隐私可见度 0所有人可见 1好友可见 2仅自己可见',
  `share_commentcount` int(11) NOT NULL default '0' COMMENT '评论数',
  `share_isshare` tinyint(1) NOT NULL default '0' COMMENT '是否分享 0为未分享 1为分享',
  `share_islike` tinyint(1) NOT NULL default '0' COMMENT '是否喜欢 0为未喜欢 1为喜欢',
  PRIMARY KEY  (`share_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='共享商品表';

CREATE TABLE `#__sns_sharestore` (
  `share_id` int(11) NOT NULL auto_increment COMMENT '自增ID',
  `share_storeid` int(11) NOT NULL COMMENT '店铺编号',
  `share_storename` varchar(100) NOT NULL COMMENT '店铺名称',
  `share_memberid` int(11) NOT NULL COMMENT '所属会员ID',
  `share_membername` varchar(100) NOT NULL COMMENT '所属会员名称',
  `share_content` varchar(500) default NULL COMMENT '描述内容',
  `share_addtime` int(11) NOT NULL COMMENT '添加时间',
  `share_privacy` tinyint(1) NOT NULL default '0' COMMENT '隐私可见度 0所有人可见 1好友可见 2仅自己可见',
  PRIMARY KEY  (`share_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='共享店铺表';

CREATE TABLE `#__sns_s_autosetting` (
  `sauto_storeid` int(11) NOT NULL COMMENT '店铺id',
  `sauto_new` tinyint(4) NOT NULL default '1' COMMENT '新品,0为关闭/1为开启',
  `sauto_newtitle` varchar(150) NOT NULL COMMENT '新品内容',
  `sauto_coupon` tinyint(4) NOT NULL default '1' COMMENT '优惠券,0为关闭/1为开启',
  `sauto_coupontitle` varchar(150) NOT NULL COMMENT '优惠券内容',
  `sauto_xianshi` tinyint(4) NOT NULL default '1' COMMENT '限时折扣,0为关闭/1为开启',
  `sauto_xianshititle` varchar(150) NOT NULL COMMENT '限时折扣内容',
  `sauto_mansong` tinyint(4) NOT NULL default '1' COMMENT '满即送,0为关闭/1为开启',
  `sauto_mansongtitle` varchar(150) NOT NULL COMMENT '满即送内容',
  `sauto_bundling` tinyint(4) NOT NULL default '1' COMMENT '组合销售,0为关闭/1为开启',
  `sauto_bundlingtitle` varchar(150) NOT NULL COMMENT '组合销售内容',
  `sauto_groupbuy` tinyint(4) NOT NULL default '1' COMMENT '团购,0为关闭/1为开启',
  `sauto_groupbuytitle` varchar(150) NOT NULL COMMENT '团购内容',
  PRIMARY KEY  (`sauto_storeid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='店铺自动发布动态设置表';

CREATE TABLE `#__sns_s_comment` (
  `scomm_id` int(11) NOT NULL auto_increment COMMENT '店铺动态评论id',
  `strace_id` int(11) NOT NULL COMMENT '店铺动态id',
  `scomm_content` varchar(150) default NULL COMMENT '评论内容',
  `scomm_memberid` int(11) default NULL COMMENT '会员id',
  `scomm_membername` varchar(45) default NULL COMMENT '会员名称',
  `scomm_memberavatar` varchar(50) default NULL COMMENT '会员头像',
  `scomm_time` varchar(11) default NULL COMMENT '评论时间',
  `scomm_state` tinyint(1) NOT NULL default '1' COMMENT '评论状态 1正常，0屏蔽',
  PRIMARY KEY  (`scomm_id`),
  UNIQUE KEY `scomm_id` (`scomm_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='店铺动态评论表';

CREATE TABLE `#__sns_s_tracelog` (
  `strace_id` int(11) NOT NULL auto_increment COMMENT '店铺动态id',
  `strace_storeid` int(11) default NULL COMMENT '店铺id',
  `strace_storename` varchar(100) default NULL COMMENT '店铺名称',
  `strace_storelogo` varchar(255) NOT NULL COMMENT '店标',
  `strace_title` varchar(150) default NULL COMMENT '动态标题',
  `strace_content` text COMMENT '发表内容',
  `strace_time` varchar(11) default NULL COMMENT '发表时间',
  `strace_cool` int(11) default '0' COMMENT '赞数量',
  `strace_spread` int(11) default '0' COMMENT '转播数量',
  `strace_comment` int(11) default '0' COMMENT '评论数量',
  `strace_type` tinyint(4) default '1' COMMENT '1=relay,2=normal,3=new,4=coupon,5=xianshi,6=mansong,7=bundling,8=groupbuy,9=recommend,10=hotsell',
  `strace_goodsdata` varchar(1000) default NULL COMMENT '商品信息',
  `strace_state` tinyint(1) NOT NULL default '1' COMMENT '动态状态 1正常，0屏蔽',
  PRIMARY KEY  (`strace_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='店铺动态表';

CREATE TABLE `#__sns_tracelog` (
  `trace_id` int(11) NOT NULL auto_increment COMMENT '自增ID',
  `trace_originalid` int(11) NOT NULL default '0' COMMENT '原动态ID 默认为0',
  `trace_originalmemberid` int(11) NOT NULL default '0' COMMENT '原帖会员编号',
  `trace_originalstate` tinyint(1) NOT NULL default '0' COMMENT '原帖的删除状态 0为正常 1为删除',
  `trace_memberid` int(11) NOT NULL COMMENT '会员ID',
  `trace_membername` varchar(100) NOT NULL COMMENT '会员名称',
  `trace_memberavatar` varchar(100) default NULL COMMENT '会员头像',
  `trace_title` varchar(500) default NULL COMMENT '动态标题',
  `trace_content` text NOT NULL COMMENT '动态内容',
  `trace_addtime` int(11) NOT NULL COMMENT '添加时间',
  `trace_state` tinyint(1) NOT NULL default '0' COMMENT '状态  0正常 1为禁止显示 默认为0',
  `trace_privacy` tinyint(1) NOT NULL default '0' COMMENT '隐私可见度 0所有人可见 1好友可见 2仅自己可见',
  `trace_commentcount` int(11) NOT NULL default '0' COMMENT '评论数',
  `trace_copycount` int(11) NOT NULL default '0' COMMENT '转发数',
  `trace_orgcommentcount` int(11) NOT NULL default '0' COMMENT '原帖评论次数',
  `trace_orgcopycount` int(11) NOT NULL default '0' COMMENT '原帖转帖次数',
  `trace_from` tinyint default '1' COMMENT'来源  1=shop 2=storetracelog 3=microshop',
  PRIMARY KEY  (`trace_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='动态信息表';

CREATE TABLE `#__sns_visitor` (
  `v_id` int(11) NOT NULL auto_increment COMMENT '自增ID',
  `v_mid` int(11) NOT NULL COMMENT '访客会员ID',
  `v_mname` varchar(100) NOT NULL COMMENT '访客会员名称',
  `v_mavatar` varchar(100) default NULL COMMENT '访客会员头像',
  `v_ownermid` int(11) NOT NULL COMMENT '主人会员ID',
  `v_ownermname` varchar(100) NOT NULL COMMENT '主人会员名称',
  `v_ownermavatar` varchar(100) default NULL COMMENT '主人会员头像',
  `v_addtime` int(11) NOT NULL COMMENT '访问时间',
  PRIMARY KEY  (`v_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='sns访客表';

CREATE TABLE `#__spec` (
	`sp_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '规格id',
	`sp_name` varchar(100) NOT NULL COMMENT '规格名称',
	`sp_format` enum('text', 'image') NOT NULL COMMENT '显示类型',
	`sp_value` text NOT NULL COMMENT '规格值列',
	`sp_sort` tinyint(1) unsigned NOT NULL COMMENT '排序',
  PRIMARY KEY  (`sp_id`)
) ENGINE = MYISAM CHARSET=utf8 COMMENT='商品规格表';

CREATE TABLE `#__spec_value` (
	`sp_value_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '规格值id',
	`sp_value_name` varchar(100) NOT NULL COMMENT '规格值名称',
	`sp_id` int(10) unsigned NOT NULL COMMENT '所属规格id',
	`sp_value_image` varchar(100) NULL COMMENT '规格图片',
	`sp_value_sort` tinyint(1) unsigned NOT NULL COMMENT '排序',
  PRIMARY KEY  (`sp_value_id`)
) ENGINE = MYISAM CHARSET=utf8 COMMENT='商品规格值表';

CREATE TABLE `#__store` (
  `store_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '店铺索引id',
  `store_name` varchar(50) NOT NULL COMMENT '店铺名称',
  `store_auth` tinyint(1) DEFAULT '0' COMMENT '店铺认证',
  `name_auth` tinyint(1) DEFAULT '0' COMMENT '店主认证',
  `grade_id` int(11) NOT NULL COMMENT '店铺等级',
  `member_id` int(11) NOT NULL COMMENT '会员id',
  `member_name` varchar(50) NOT NULL COMMENT '会员名称',
  `store_owner_card` varchar(50) NOT NULL COMMENT '身份证',
  `sc_id` int(11) NOT NULL COMMENT '店铺分类',
  `area_id` int(11) NOT NULL COMMENT '地区id',
  `area_info` varchar(100) NOT NULL COMMENT '地区内容，冗余数据',
  `store_address` varchar(100) NOT NULL COMMENT '详细地区',
  `store_zip` varchar(10) NOT NULL COMMENT '邮政编码',
  `store_tel` varchar(50) NOT NULL COMMENT '电话号码',
  `store_image` varchar(100) DEFAULT NULL COMMENT '证件上传',
  `store_image1` varchar(100) DEFAULT NULL COMMENT '执照上传',
  `store_state` tinyint(1) NOT NULL DEFAULT '2' COMMENT '店铺状态，0关闭，1开启，2审核中',
  `store_close_info` varchar(255) DEFAULT NULL COMMENT '店铺关闭原因',
  `store_sort` int(11) NOT NULL DEFAULT '0' COMMENT '店铺排序',
  `store_time` varchar(10) NOT NULL COMMENT '店铺时间',
  `store_end_time` varchar(10) DEFAULT NULL COMMENT '店铺关闭时间',
  `store_label` varchar(255) default NULL COMMENT '店铺logo',
  `store_banner` varchar(255) DEFAULT NULL COMMENT '店铺横幅',
  `store_logo` varchar(255) DEFAULT NULL COMMENT '店标',
  `store_keywords` varchar(255)  NOT NULL DEFAULT '' COMMENT '店铺seo关键字',
  `store_description` varchar(255) NOT NULL DEFAULT '' COMMENT '店铺seo描述',
  `store_qq` varchar(50) DEFAULT NULL COMMENT 'QQ',
  `store_ww` varchar(50) DEFAULT NULL COMMENT '阿里旺旺',
  `description` text COMMENT '店铺简介',
  `store_zy` text COMMENT '主营商品',
  `store_domain` varchar(50) DEFAULT NULL COMMENT '店铺二级域名',
  `store_domain_times` tinyint(1) unsigned NULL DEFAULT '0' COMMENT '二级域名修改次数',
  `store_recommend` tinyint(1) NOT NULL DEFAULT '0' COMMENT '推荐，0为否，1为是，默认为0',
  `store_theme` varchar(50) NOT NULL DEFAULT 'default' COMMENT '店铺当前主题',
  `store_credit` int(10) NOT NULL DEFAULT '0' COMMENT '店铺信用',
  `praise_rate` float NOT NULL DEFAULT '0' COMMENT '店铺好评率',
  `store_desccredit` float NOT NULL default '0' COMMENT '描述相符度分数',
  `store_servicecredit` float NOT NULL default '0' COMMENT '服务态度分数',
  `store_deliverycredit` float NOT NULL default '0' COMMENT '发货速度分数',
  `store_code` varchar(255) NOT NULL DEFAULT 'default_qrcode.png' COMMENT '店铺二维码',
  `store_collect` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '店铺收藏数量',
  `store_slide` text DEFAULT NULL COMMENT '店铺幻灯片',
  `store_slide_url` text COMMENT '店铺幻灯片链接',
  `store_center_quicklink` text COMMENT '卖家中心的常用操作快捷链接',
  `store_stamp` varchar(200) default NULL COMMENT '店铺印章',
  `store_printdesc` varchar(500) default NULL COMMENT '打印订单页面下方说明文字',
  `store_sales` int(10) unsigned NOT NULL default '0' COMMENT '店铺销量',
  `store_presales` text COMMENT '售前客服',
  `store_aftersales` text COMMENT '售后客服',
  `store_workingtime` varchar(100) default NULL COMMENT '工作时间',
  PRIMARY KEY (`store_id`),
  KEY `store_name` (`store_name`),
  KEY `sc_id` (`sc_id`),
  KEY `area_id` (`area_id`),
  KEY `store_state` (`store_state`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='店铺数据表';

CREATE TABLE `#__store_class` (
  `sc_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '索引ID',
  `sc_name` varchar(100) NOT NULL COMMENT '分类名称',
  `sc_parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `sc_sort` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`sc_id`),
  KEY `sc_parent_id` (`sc_parent_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='店铺分类表';

CREATE TABLE `#__store_class_goods` (
  `stc_id` int(11) NOT NULL COMMENT '店铺商品分类id',
  `goods_id` int(11) NOT NULL COMMENT '商品id'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品店铺分类存储表';

CREATE TABLE `#__store_extend` (
  `store_id` mediumint(8) unsigned NOT NULL COMMENT '店铺ID',
  `express` text COMMENT '快递公司ID的组合',
  PRIMARY KEY  (`store_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='店铺信息扩展表';

CREATE TABLE `#__store_goods_class` (
  `stc_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '索引ID',
  `stc_name` varchar(50) NOT NULL COMMENT '店铺商品分类名称',
  `stc_parent_id` int(11) NOT NULL COMMENT '父级id',
  `stc_state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '店铺商品分类状态',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `stc_sort` int(11) NOT NULL DEFAULT '0' COMMENT '商品分类排序',
  PRIMARY KEY (`stc_id`),
  KEY `stc_parent_id` (`stc_parent_id`,`stc_sort`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='店铺商品分类表';

CREATE TABLE `#__store_grade` (
  `sg_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '索引ID',
  `sg_name` char(50) default NULL COMMENT '等级名称',
  `sg_goods_limit` mediumint(10) unsigned NOT NULL DEFAULT '0' COMMENT '允许发布的商品数量',
  `sg_album_limit` mediumint(8) unsigned NOT NULL default '0' COMMENT '允许上传图片数量',
  `sg_space_limit` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上传空间大小，单位MB',
  `sg_template_number` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '选择店铺模板套数',
  `sg_template` varchar(255) DEFAULT NULL COMMENT '模板内容',
  `sg_price` varchar(100) DEFAULT NULL COMMENT '费用',
  `sg_confirm` tinyint(1) NOT NULL DEFAULT '1' COMMENT '审核，0为否，1为是，默认为1',
  `sg_description` text COMMENT '申请说明',
  `sg_function` varchar(255) DEFAULT NULL COMMENT '附加功能',
  `sg_sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '级别，数目越大级别越高',
  PRIMARY KEY (`sg_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='店铺等级表';

CREATE TABLE `#__store_gradelog` (
  `gl_id` int(11) NOT NULL auto_increment COMMENT '等级日志自增编号',
  `gl_shopid` int(11) NOT NULL COMMENT '店铺编号',
  `gl_shopname` varchar(50) NOT NULL COMMENT '店铺名称',
  `gl_memberid` int(11) NOT NULL COMMENT '会员编号',
  `gl_membername` varchar(50) NOT NULL COMMENT '会员名称',
  `gl_sgid` int(11) NOT NULL COMMENT '等级编号',
  `gl_sgname` varchar(100) NOT NULL COMMENT '等级名称',
  `gl_sgconfirm` tinyint(4) NOT NULL default '1' COMMENT '是否需要审核 0不需要 1需要',
  `gl_sgsort` tinyint(3) NOT NULL COMMENT '级别',
  `gl_addtime` int(11) NOT NULL COMMENT '添加时间',
  `gl_allowstate` tinyint(1) NOT NULL COMMENT '审核状态 0为审核 1审核通过 2 审核未通过',
  `gl_allowadminid` int(11) NOT NULL default '0' COMMENT '管理员编号 默认为0 ',
  `gl_allowadminname` varchar(100) NOT NULL default 'system' COMMENT '管理员名称 默认为system 表示系统自动审核',
  `gl_allowremark` varchar(500) NOT NULL COMMENT '审核备注',
  PRIMARY KEY  (`gl_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='店铺升级申请记录表';

CREATE TABLE `#__store_navigation` (
  `sn_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '导航ID',
  `sn_title` varchar(50) NOT NULL COMMENT '导航名称',
  `sn_store_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '卖家店铺ID',
  `sn_content` text COMMENT '导航内容',
  `sn_sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '导航排序',
  `sn_if_show` tinyint(1) NOT NULL DEFAULT '0' COMMENT '导航是否显示',
  `sn_add_time` int(10) NOT NULL COMMENT '导航',
  `sn_url` varchar(255) default NULL COMMENT '店铺导航的外链URL',
  `sn_new_open` tinyint(1) unsigned NOT NULL default '0' COMMENT '店铺导航外链是否在新窗口打开：0不开新窗口1开新窗口，默认是0',
  PRIMARY KEY (`sn_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='卖家店铺导航信息表';

CREATE TABLE `#__store_partner` (
  `sp_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '店铺合作伙伴ID',
  `sp_store_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `sp_title` varchar(100) NOT NULL COMMENT '店铺合作伙伴标题',
  `sp_link` varchar(255) NOT NULL COMMENT '店铺合作伙伴链接',
  `sp_logo` varchar(255) DEFAULT NULL COMMENT '店铺合作伙伴LOGO',
  `sp_sort` tinyint(1) unsigned NOT NULL DEFAULT '255' COMMENT '店铺合作伙伴排序',
  PRIMARY KEY (`sp_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='卖家店铺合作伙伴表';

CREATE TABLE `#__store_theme` (
  `theme_id` int(10) unsigned NOT NULL auto_increment COMMENT '主题ID',
  `member_id` int(10) unsigned NOT NULL COMMENT '会员ID',
  `member_name` varchar(20) NOT NULL COMMENT '会员名称',
  `style_id` varchar(10) NOT NULL default 'style6' COMMENT '模版名称',
  `style_name` varchar(20) default '' COMMENT '风格名称',
  `theme_info` text COMMENT '主题内容',
  `store_name` varchar(20) default NULL COMMENT '店铺名称',
  `store_id` int(10) unsigned default '0' COMMENT '店铺ID',
  `show_page` varchar(20) default 'index' COMMENT '所在页面(暂时只有index)',
  `update_time` int(10) unsigned NOT NULL COMMENT '更新时间',
  PRIMARY KEY  (`theme_id`),
  KEY `style_id` (`style_id`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='店铺主题表';

CREATE TABLE `#__store_watermark` (
  `wm_id` int(11) NOT NULL auto_increment COMMENT '水印id',
  `jpeg_quality` int(3) NOT NULL default '90' COMMENT 'jpeg图片质量',
  `wm_image_name` varchar(255) default NULL COMMENT '水印图片的路径以及文件名',
  `wm_image_pos` tinyint(1) NOT NULL default '1' COMMENT '水印图片放置的位置',
  `wm_image_transition` int(3) NOT NULL default '20' COMMENT '水印图片与原图片的融合度 ',
  `wm_text` text COMMENT '水印文字',
  `wm_text_size` int(3) NOT NULL default '20' COMMENT '水印文字大小',
  `wm_text_angle` tinyint(1) NOT NULL default '4' COMMENT '水印文字角度',
  `wm_text_pos` tinyint(1) NOT NULL default '3' COMMENT '水印文字放置位置',
  `wm_text_font` varchar(50) default NULL COMMENT '水印文字的字体',
  `wm_text_color` varchar(7) NOT NULL default '#CCCCCC' COMMENT '水印字体的颜色值',
  `wm_is_open` tinyint(1) NOT NULL default '0' COMMENT '水印是否开启 0关闭 1开启',
  `store_id` int(11) default NULL COMMENT '店铺id',
  PRIMARY KEY  (`wm_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='店铺水印图片表';

CREATE TABLE `#__transport` (
  `id` mediumint(8) unsigned NOT NULL auto_increment COMMENT '运费模板ID',
  `title` varchar(60) default NULL COMMENT '运费模板名称',
  `send_tpl_id` mediumint(8) unsigned default NULL COMMENT '发货地区模板ID',
  `member_id` mediumint(8) unsigned default NULL COMMENT '会员ID',
  `update_time` int(10) unsigned default '0' COMMENT '最后更新时间',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='运费模板';

CREATE TABLE `#__transport_extend` (
  `id` mediumint(8) unsigned NOT NULL auto_increment COMMENT '运费模板扩展ID',
  `type` char(2) default NULL COMMENT '平邮py 快递kd EMS es',
  `area_id` text COMMENT '市级地区ID组成的串，以，隔开，两端也有，',
  `top_area_id` text COMMENT '省级地区ID组成的串，以，隔开，两端也有，',
  `area_name` text COMMENT '地区name组成的串，以，隔开',
  `snum` mediumint(8) unsigned default '1' COMMENT '首件数量',
  `sprice` decimal(10,2) default '0.00' COMMENT '首件运费',
  `xnum` mediumint(8) unsigned default '1' COMMENT '续件数量',
  `xprice` decimal(10,2) default '0.00' COMMENT '续件运费',
  `is_default` enum('1','2') default '2' COMMENT '是否默认运费1是2否',
  `transport_id` mediumint(8) unsigned NOT NULL COMMENT '运费模板ID',
  `transport_title` varchar(60) default NULL COMMENT '运费模板',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='运费模板扩展表';

CREATE TABLE `#__type` (
	`type_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '类型id',
	`type_name` varchar(100) NOT NULL COMMENT '类型名称',
	`type_sort` tinyint(1) unsigned NOT NULL COMMENT '排序',
	 PRIMARY KEY  (`type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品类型表';

CREATE TABLE `#__type_brand` (
	`type_id` int(10) unsigned NOT NULL COMMENT '类型id',
	`brand_id` int(10) unsigned NOT NULL COMMENT '品牌id'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品类型与品牌对应表';

CREATE TABLE `#__type_spec` (
	`type_id` int(10) unsigned NOT NULL COMMENT '类型id',
	`sp_id` int(10) unsigned NOT NULL COMMENT '规格id'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品类型与规格对应表';

CREATE TABLE `#__upload` (
  `upload_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '索引ID',
  `file_name` varchar(100) DEFAULT NULL COMMENT '文件名',
  `file_thumb` varchar(100) DEFAULT NULL COMMENT '缩微图片',
  `file_wm` varchar(100) NULL COMMENT '水印图片',
  `file_size` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `store_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '店铺ID，0为管理员',
  `upload_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '文件类别，0为无，1为文章图片，默认为0，2为商品切换图片，3为商品内容图片，4为系统文章图片，5为积分礼品切换图片，6为积分礼品内容图片',
  `upload_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `item_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '信息ID',
  PRIMARY KEY (`upload_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='上传文件表';

CREATE TABLE `#__voucher` (
  `voucher_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '代金券编号',
  `voucher_code` varchar(32) NOT NULL COMMENT '代金券编码',
  `voucher_t_id` int(11) NOT NULL COMMENT '代金券模版编号',
  `voucher_title` varchar(50) NOT NULL COMMENT '代金券标题',
  `voucher_desc` varchar(255) NOT NULL COMMENT '代金券描述',
  `voucher_start_date` int(11) NOT NULL COMMENT '代金券有效期开始时间',
  `voucher_end_date` int(11) NOT NULL COMMENT '代金券有效期结束时间',
  `voucher_price` int(11) NOT NULL COMMENT '代金券面额',
  `voucher_limit` decimal(10,2) NOT NULL COMMENT '代金券使用时的订单限额',
  `voucher_store_id` int(11) NOT NULL COMMENT '代金券的店铺id',
  `voucher_state` tinyint(4) NOT NULL COMMENT '代金券状态(1-未用,2-已用,3-过期,4-收回)',
  `voucher_active_date` int(11) NOT NULL COMMENT '代金券发放日期',
  `voucher_type` tinyint(4) NOT NULL COMMENT '代金券类别',
  `voucher_owner_id` int(11) NOT NULL COMMENT '代金券所有者id',
  `voucher_owner_name` varchar(50) NOT NULL COMMENT '代金券所有者名称',
  `voucher_order_id` int(11) DEFAULT NULL COMMENT '使用该代金券的订单编号',
  PRIMARY KEY (`voucher_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='代金券表';

CREATE TABLE `#__voucher_apply` (
  `apply_id` int(11) NOT NULL auto_increment COMMENT '申请编号',
  `apply_memberid` int(11) NOT NULL COMMENT '会员编号',
  `apply_membername` varchar(100) NOT NULL COMMENT '会员名称',
  `apply_storeid` int(11) NOT NULL COMMENT '店铺编号',
  `apply_storename` varchar(100) NOT NULL COMMENT '店铺名称',
  `apply_quantity` int(11) NOT NULL COMMENT '申请数量',
  `apply_datetime` int(11) NOT NULL COMMENT '申请时间',
  `apply_state` tinyint(1) NOT NULL COMMENT '状态(1-新申请/2-审核通过/3-已取消)',
  PRIMARY KEY  (`apply_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='代金券套餐申请表';

CREATE TABLE `#__voucher_price` (
  `voucher_price_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '代金券面值编号',
  `voucher_price_describe` varchar(255) NOT NULL COMMENT '代金券描述',
  `voucher_price` int(11) NOT NULL COMMENT '代金券面值',
  `voucher_defaultpoints` int(11) NOT NULL default '0' COMMENT '代金劵默认的兑换所需积分可以为0',
  PRIMARY KEY (`voucher_price_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='代金券面额表';

CREATE TABLE `#__voucher_quota` (
  `quota_id` int(11) NOT NULL auto_increment COMMENT '套餐编号',
  `quota_applyid` int(11) NOT NULL COMMENT '申请编号',
  `quota_memberid` int(11) NOT NULL COMMENT '会员编号',
  `quota_membername` varchar(100) NOT NULL COMMENT '会员名称',
  `quota_storeid` int(11) NOT NULL COMMENT '店铺编号',
  `quota_storename` varchar(100) NOT NULL COMMENT '店铺名称',
  `quota_starttime` int(11) NOT NULL COMMENT '开始时间',
  `quota_endtime` int(11) NOT NULL COMMENT '结束时间',
  `quota_timeslimit` int(11) NOT NULL default '0' COMMENT '活动次数限制',
  `quota_publishedtimes` int(11) NOT NULL default '0' COMMENT '活动已使用次数',
  `quota_state` tinyint(1) NOT NULL default '1' COMMENT '状态(1-可用/2-取消/3-结束)',
  PRIMARY KEY  (`quota_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='代金券套餐表';

CREATE TABLE `#__voucher_template` (
  `voucher_t_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '代金券模版编号',
  `voucher_t_title` varchar(50) NOT NULL COMMENT '代金券模版名称',
  `voucher_t_desc` varchar(255) NOT NULL COMMENT '代金券模版描述',
  `voucher_t_start_date` int(11) NOT NULL COMMENT '代金券模版有效期开始时间',
  `voucher_t_end_date` int(11) NOT NULL COMMENT '代金券模版有效期结束时间',
  `voucher_t_price` int(11) NOT NULL COMMENT '代金券模版面额',
  `voucher_t_limit` decimal(10,2) NOT NULL COMMENT '代金券使用时的订单限额',
  `voucher_t_store_id` int(11) NOT NULL COMMENT '代金券模版的店铺id',
  `voucher_t_storename` varchar(100) default NULL COMMENT '店铺名称',
  `voucher_t_creator_id` int(11) NOT NULL COMMENT '代金券模版的创建者id',
  `voucher_t_state` tinyint(4) NOT NULL COMMENT '代金券模版状态(1-有效,2-失效)',
  `voucher_t_total` int(11) NOT NULL COMMENT '模版可发放的代金券总数',
  `voucher_t_giveout` int(11) NOT NULL COMMENT '模版已发放的代金券数量',
  `voucher_t_used` int(11) NOT NULL COMMENT '模版已经使用过的代金券',
  `voucher_t_add_date` int(11) NOT NULL COMMENT '模版的创建时间',
  `voucher_t_quotaid` int(11) NOT NULL COMMENT '套餐编号',
  `voucher_t_points` int(11) NOT NULL default '0' COMMENT '兑换所需积分',
  `voucher_t_eachlimit` int(11) NOT NULL default '1' COMMENT '每人限领张数',
  `voucher_t_styleimg` varchar(200) default NULL COMMENT '样式模版图片',
  `voucher_t_customimg` varchar(200) default NULL COMMENT '自定义代金券模板图片',
  PRIMARY KEY (`voucher_t_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='代金券模版表';

CREATE TABLE `#__web` (
  `web_id` int(10) unsigned NOT NULL auto_increment COMMENT '模块ID',
  `web_name` varchar(20) default '' COMMENT '模块名称',
  `style_name` varchar(20) default 'orange' COMMENT '风格名称',
  `web_page` varchar(10) default 'index' COMMENT '所在页面(暂时只有index)',
  `update_time` int(10) unsigned NOT NULL COMMENT '更新时间',
  `web_sort` tinyint(1) unsigned default '9' COMMENT '排序',
  `web_show` tinyint(1) unsigned default '1' COMMENT '是否显示，0为否，1为是，默认为1',
  `web_html` text COMMENT '模块html代码',
  PRIMARY KEY  (`web_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='页面模块表';

CREATE TABLE `#__web_code` (
  `code_id` int(10) unsigned NOT NULL auto_increment COMMENT '内容ID',
  `web_id` int(10) unsigned NOT NULL COMMENT '模块ID',
  `code_type` varchar(10) NOT NULL default 'array' COMMENT '数据类型:array,html,json',
  `var_name` varchar(20) NOT NULL COMMENT '变量名称',
  `code_info` text COMMENT '内容数据',
  `show_name` varchar(20) default '' COMMENT '页面名称',
  PRIMARY KEY  (`code_id`),
  KEY `web_id` (`web_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='模块内容表';

CREATE TABLE `#__ztc_glodlog` (
  `glog_id` int(11) NOT NULL auto_increment COMMENT '自增编号',
  `glog_goodsid` int(11) NOT NULL COMMENT '商品编号',
  `glog_goodsname` varchar(100) NOT NULL COMMENT '商品名称',
  `glog_memberid` int(11) NOT NULL COMMENT '会员编号',
  `glog_membername` varchar(50) NOT NULL COMMENT '会员名称',
  `glog_storeid` int(11) NOT NULL COMMENT '店铺编号',
  `glog_storename` varchar(50) NOT NULL COMMENT '店铺名称',
  `glog_type` tinyint(4) NOT NULL COMMENT '金币日志类型 1增加 2减少',
  `glog_goldnum` int(11) NOT NULL default '0' COMMENT '金币额',
  `glog_addtime` int(11) NOT NULL COMMENT '添加时间',
  `glog_desc` varchar(500) NOT NULL COMMENT '操作描述',
  PRIMARY KEY  (`glog_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='直通车金币日志表';

CREATE TABLE `#__ztc_goods` (
  `ztc_id` int(11) NOT NULL auto_increment COMMENT '自增编号',
  `ztc_goodsid` int(11) NOT NULL COMMENT '商品编号',
  `ztc_goodsname` varchar(100) NOT NULL COMMENT '商品名称',
  `ztc_goodsimage` varchar(100) NOT NULL COMMENT '商品图片',
  `ztc_memberid` int(11) NOT NULL COMMENT '会员编号',
  `ztc_membername` varchar(50) NOT NULL COMMENT '会员名称',
  `ztc_storeid` int(11) NOT NULL COMMENT '店铺编号',
  `ztc_storename` varchar(50) NOT NULL COMMENT '店铺名称',
  `ztc_gold` int(11) NOT NULL COMMENT '加入直通车分配的金币额',
  `ztc_remark` varchar(200) NOT NULL COMMENT '备注信息',
  `ztc_addtime` int(11) NOT NULL COMMENT '添加时间',
  `ztc_startdate` int(11) default NULL COMMENT '直通车开始时间，没设置表明即刻开始',
  `ztc_state` tinyint(1) NOT NULL default '0' COMMENT '审核状态 0未审核 1审核通过 2 审核未通过',
  `ztc_paystate` tinyint(4) NOT NULL default '0' COMMENT '支付状态 0未支付 1已支付',
  `ztc_type` tinyint(4) NOT NULL default '0' COMMENT '充值类型 0表示新申请记录 1表示充值记录，不经过审核直接给直通车加金币',
  PRIMARY KEY  (`ztc_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='直通车申请表';

INSERT INTO `#__setting` (`name`, `value`) VALUES('time_zone', '8');
INSERT INTO `#__setting` (`name`, `value`) VALUES('time_format_simple', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('time_format_complete', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('default_goods_image', 'default_goods_image.gif');
INSERT INTO `#__setting` (`name`, `value`) VALUES('default_store_logo', 'default_store_logo.gif');
INSERT INTO `#__setting` (`name`, `value`) VALUES('default_user_portrait', 'default_user_portrait.gif');
INSERT INTO `#__setting` (`name`, `value`) VALUES('statistics_code', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('guest_comment', '1');
INSERT INTO `#__setting` (`name`, `value`) VALUES('rewrite_enabled', '0');
INSERT INTO `#__setting` (`name`, `value`) VALUES('site_logo', 'logo.png');
INSERT INTO `#__setting` (`name`, `value`) VALUES('member_logo', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('site_name', 'ShopNC');
INSERT INTO `#__setting` (`name`, `value`) VALUES('icp_number', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('image_dir_type','1');
INSERT INTO `#__setting` (`name`, `value`) VALUES('gold_isuse', '1');
INSERT INTO `#__setting` (`name`, `value`) VALUES('gold_rmbratio', '10');
INSERT INTO `#__setting` (`name`, `value`) VALUES('ztc_isuse', '0');
INSERT INTO `#__setting` (`name`, `value`) VALUES('ztc_dayprod', '1');
INSERT INTO `#__setting` (`name`, `value`) VALUES('qq_isuse', '0');
INSERT INTO `#__setting` (`name`, `value`) VALUES('qq_appid', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('qq_appkey', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('qq_appcode', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('sina_isuse', '0');
INSERT INTO `#__setting` (`name`, `value`) VALUES('sina_wb_akey','');
INSERT INTO `#__setting` (`name`, `value`) VALUES('sina_wb_skey','');
INSERT INTO `#__setting` (`name`, `value`) VALUES('sina_appcode', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('points_isuse', '0');
INSERT INTO `#__setting` (`name`, `value`) VALUES('points_reg', '0');
INSERT INTO `#__setting` (`name`, `value`) VALUES('points_login', '0');
INSERT INTO `#__setting` (`name`, `value`) VALUES('points_comments', '0');
INSERT INTO `#__setting` (`name`, `value`) VALUES('points_orderrate', '0');
INSERT INTO `#__setting` (`name`, `value`) VALUES('points_ordermax', '0');
INSERT INTO `#__setting` (`name`, `value`) VALUES('pointprod_isuse', '0');
INSERT INTO `#__setting` (`name`, `value`) VALUES('voucher_allow', '0');
INSERT INTO `#__setting` (`name`, `value`) VALUES('predeposit_isuse', '0');
INSERT INTO `#__setting` (`name`, `value`) VALUES('complain_time_limit', '2592000');
INSERT INTO `#__setting` (`name`, `value`) VALUES('creditrule', 'a:3:{s:5:"heart";a:5:{i:1;a:2:{i:0;s:1:"1";i:1;s:3:"100";}i:2;a:2:{i:0;s:3:"101";i:1;s:3:"200";}i:3;a:2:{i:0;s:3:"201";i:1;s:3:"300";}i:4;a:2:{i:0;s:3:"301";i:1;s:3:"400";}i:5;a:2:{i:0;s:3:"401";i:1;s:3:"500";}}s:7:"diamond";a:5:{i:1;a:2:{i:0;s:3:"501";i:1;s:3:"600";}i:2;a:2:{i:0;s:3:"601";i:1;s:3:"700";}i:3;a:2:{i:0;s:3:"701";i:1;s:3:"800";}i:4;a:2:{i:0;s:3:"801";i:1;s:3:"900";}i:5;a:2:{i:0;s:3:"901";i:1;s:4:"1000";}}s:5:"crown";a:5:{i:1;a:2:{i:0;s:4:"1001";i:1;s:4:"1100";}i:2;a:2:{i:0;s:4:"1101";i:1;s:4:"1200";}i:3;a:2:{i:0;s:4:"1201";i:1;s:4:"1300";}i:4;a:2:{i:0;s:4:"1301";i:1;s:4:"1400";}i:5;a:2:{i:0;s:4:"1401";i:1;s:4:"1500";}}}');
INSERT INTO `#__setting` (`name`, `value`) VALUES('site_status', '1');
INSERT INTO `#__setting` (`name`, `value`) VALUES('closed_reason', '升级中……');
INSERT INTO `#__setting` (`name`, `value`) VALUES('hot_search', '李宁,耐克,Kappa,双肩包,手提包');
INSERT INTO `#__setting` (`name`, `value`) VALUES('email_type', '1');
INSERT INTO `#__setting` (`name`, `value`) VALUES('email_host', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('email_port', '25');
INSERT INTO `#__setting` (`name`, `value`) VALUES('email_addr', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('email_id', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('email_pass', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('captcha_status_login', '1');
INSERT INTO `#__setting` (`name`, `value`) VALUES('captcha_status_register', '1');
INSERT INTO `#__setting` (`name`, `value`) VALUES('captcha_status_goodsqa', '1');
INSERT INTO `#__setting` (`name`, `value`) VALUES('captcha_status_backend', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('store_allow', '1');
INSERT INTO `#__setting` (`name`, `value`) VALUES('enabled_subdomain', '0');
INSERT INTO `#__setting` (`name`, `value`) VALUES('subdomain_suffix', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('subdomain_reserved', 'www');
INSERT INTO `#__setting` (`name`, `value`) VALUES('subdomain_length', '3-12');
INSERT INTO `#__setting` (`name`, `value`) VALUES('subdomain_edit', '1');
INSERT INTO `#__setting` (`name`, `value`) VALUES('subdomain_times', '3');
INSERT INTO `#__setting` (`name`, `value`) VALUES('tpl_type', 'nc');
INSERT INTO `#__setting` (`name`, `value`) VALUES('md5_key', '91be7deb1a5efcb6ca2fe5c66272e9bc');
INSERT INTO `#__setting` (`name`, `value`) VALUES('email_enabled', '0');
INSERT INTO `#__setting` (`name`, `value`) VALUES('ucenter_status', '0');
INSERT INTO `#__setting` (`name`, `value`) VALUES('ucenter_app_id', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('ucenter_app_key', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('ucenter_ip', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('ucenter_connect_type', '0');
INSERT INTO `#__setting` (`name`, `value`) VALUES('ucenter_mysql_server', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('ucenter_mysql_username', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('ucenter_mysql_passwd', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('ucenter_mysql_name', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('ucenter_mysql_pre', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('ucenter_url', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('ucenter_type','discuz');
INSERT INTO `#__setting` (`name`, `value`) VALUES('groupbuy_allow', '1');
INSERT INTO `#__setting` (`name`, `value`) VALUES('image_max_filesize', '1024');
INSERT INTO `#__setting` (`name`, `value`) VALUES('image_allow_ext', 'gif,jpg,jpeg,bmp,png,swf,tbi');
INSERT INTO `#__setting` (`name`, `value`) VALUES('thumb_tiny_width', '60');
INSERT INTO `#__setting` (`name`, `value`) VALUES('thumb_tiny_height', '60');
INSERT INTO `#__setting` (`name`, `value`) VALUES('thumb_small_width', '160');
INSERT INTO `#__setting` (`name`, `value`) VALUES('thumb_small_height', '160');
INSERT INTO `#__setting` (`name`, `value`) VALUES('thumb_mid_width', '310');
INSERT INTO `#__setting` (`name`, `value`) VALUES('thumb_mid_height', '310');
INSERT INTO `#__setting` (`name`, `value`) VALUES('thumb_max_width', '1024');
INSERT INTO `#__setting` (`name`, `value`) VALUES('thumb_max_height', '1024');
INSERT INTO `#__setting` (`name`, `value`) VALUES('class_generation_cache', '0');
INSERT INTO `#__setting` (`name`, `value`) VALUES('promotion_allow', '1');
INSERT INTO `#__setting` (`name`, `value`) VALUES('promotion_mansong_price', '20');
INSERT INTO `#__setting` (`name`, `value`) VALUES('promotion_xianshi_price', '20');
INSERT INTO `#__setting` (`name`, `value`) VALUES('promotion_xianshi_times_limit', '20');
INSERT INTO `#__setting` (`name`, `value`) VALUES('promotion_xianshi_goods_limit', '20');
INSERT INTO `#__setting` (`name`, `value`) VALUES('ftp_open', '0');
INSERT INTO `#__setting` (`name`, `value`) VALUES('ftp_ssl_state', '0');
INSERT INTO `#__setting` (`name`, `value`) VALUES('ftp_server', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('ftp_port', '21');
INSERT INTO `#__setting` (`name`, `value`) VALUES('ftp_username', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('ftp_password', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('ftp_pasv', '0');
INSERT INTO `#__setting` (`name`, `value`) VALUES('ftp_attach_dir', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('ftp_access_url', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('ftp_timeout', '0');
INSERT INTO `#__setting` (`name`, `value`) VALUES('site_phone', '23456789,88997788');
INSERT INTO `#__setting` (`name`, `value`) VALUES('site_email', 'abc@shopnc.net');
INSERT INTO `#__setting` (`name`, `value`) VALUES('share_qqzone_isuse', '0');
INSERT INTO `#__setting` (`name`, `value`) VALUES('share_qqzone_appkey', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('share_qqzone_appid', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('share_qqzone_appcode', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('share_sinaweibo_appcode', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('share_sinaweibo_appid', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('share_sinaweibo_appkey', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('share_sinaweibo_isuse', '0');
INSERT INTO `#__setting` (`name`, `value`) VALUES('share_qqweibo_appid', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('share_qqweibo_appkey', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('share_qqweibo_isuse', '0');
INSERT INTO `#__setting` (`name`, `value`) VALUES('share_renren_appid', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('share_renren_appkey', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('share_renren_secretkey', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('share_renren_isuse', '0');
INSERT INTO `#__setting` (`name`, `value`) VALUES('share_isuse', '1');
INSERT INTO `#__setting` (`name`, `value`) VALUES('promotion_voucher_price', '20');
INSERT INTO `#__setting` (`name`, `value`) VALUES('promotion_voucher_storetimes_limit', '20');
INSERT INTO `#__setting` (`name`, `value`) VALUES('promotion_voucher_buyertimes_limit', '5');
INSERT INTO `#__setting` (`name`, `value`) VALUES('promotion_voucher_default_styleimg', 'default_voucher.jpg');
INSERT INTO `#__setting` (`name`, `value`) VALUES('pointshop_isuse', '0');
INSERT INTO `#__setting` (`name`, `value`) VALUES('sphinx_main_produptime', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('sphinx_main_storelastid', '');
INSERT INTO `#__setting` (`name`, `value`) VALUES('login_pic', 'a:4:{i:0;s:5:"1.jpg";i:1;s:5:"2.jpg";i:2;s:5:"3.jpg";i:3;s:5:"4.jpg";}');
INSERT INTO `#__setting` (`name`, `value`) VALUES('promotion_bundling_price', '20');
INSERT INTO `#__setting` (`name`, `value`) VALUES('promotion_bundling_sum', '50');
INSERT INTO `#__setting` (`name`, `value`) VALUES('promotion_bundling_goods_sum', '5');
INSERT INTO `#__setting` (`name`, `value`) VALUES('malbum_max_sum', '200');

INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (9, '首页底部通栏图片广告', '位于首页底部的通栏型图片广告', 0, 2, 1, 1000, 90, 100, 0, 0, '84de815edad64024ae2e2c45979dc77e.jpg');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (13, '首页幻灯片', '首页幻灯片', 2, 0, 1, 530, 210, 100, 3, 0, '8d2b873c7dd4ed47aa907b95d7852e6f.jpg');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (14, '首页对联广告左', '首页对联广告左', 0, 2, 0, 150, 240, 100, 0, 0, '8d1531247fc8ce90b373360fd0b55fd4.jpg');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (15, '首页对联广告右', '首页对联广告右', 0, 2, 0, 150, 240, 100, 0, 0, '9a708eade54a7070918643a652cd3d7e.jpg');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (16, '购物车广告位1', '位于购物车信息页面下方图片广告', 0, 2, 1, 240, 135, 100, 0, 0, 'eb1ab09f6eb9fe7517c0612b3c45b503.jpg');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (17, '购物车广告位2', '位于购物车信息页面下方图片广告', 0, 2, 1, 240, 135, 100, 0, 0, '989d9e7bdefaa9568388c7d155ebb066.jpg');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (18, '购物车广告位3', '位于购物车信息页面下方图片广告', 0, 2, 1, 240, 135, 100, 0, 0, '8357db899b3ba02b5549702be7c4d17d.jpg');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (19, '购物车广告位4', '位于购物车信息页面下方图片广告', 0, 2, 1, 240, 135, 100, 0, 0, '96d16971074cbf29cc8fc08d2dcda137.jpg');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (20, '首页特别推荐-四格轮换广告位01', '商城特别推荐处轮动广告\r\n四格图片连为一组广告展示', 0, 1, 1, 117, 131, 100, 1, 1, 'f1414e558d853ebd8835f50bda72fdce.jpg');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (21, '首页特别推荐-四格轮换广告位02', '商城特别推荐处轮动广告\r\n四格图片连为一组广告展示', 0, 2, 1, 117, 131, 100, 0, 0, 'dafee38e6539ffe625f7658033e64bb1.jpg');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (22, '首页特别推荐-四格轮换广告位03', '商城特别推荐处轮动广告\r\n四格图片连为一组广告展示', 0, 2, 1, 117, 131, 100, 0, 0, '3b489eb71d6d7a760e61803cf191c1b7.jpg');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (23, '首页特别推荐-四格轮换广告位04', '商城特别推荐处轮动广告\r\n四格图片连为一组广告展示', 0, 2, 1, 117, 131, 100, 0, 0, '290e4cd2096b2b3ab1ce633cf3441401.jpg');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (24, '首页特别推荐-两格轮换广告位01', '商城特别推荐处轮动广告\r\n两格图片连为一组广告展示', 0, 2, 1, 230, 115, 150, 0, 0, '3067e3fbe549d28e183590463cf9c97d.jpg');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (25, '首页特别推荐-两格轮换广告位02', '商城特别推荐处轮动广告\r\n两格图片连为一组广告展示', 0, 2, 1, 230, 115, 150, 0, 0, '28d1eff4411f81442c8d4eb3ac255672.jpg');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (35, '积分列表页中部广告位', '积分列表页中部广告位', 0, 1, 1, 780, 254, 30, 0, 0, 'f448e48ee0deb06707480d46a2a360ae.gif');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (37, '商品列表页左侧广告位', '商品列表页左侧广告位', 0, 1, 1, 200, 350, 100, 0, 0, '7a4832d109ee46fe7677c1d3c30e067f.gif');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (301, '首页设置活动广告1', '首页设置活动广告1', 0, 2, 1, 208, 128, 100, 0, 0, 'adv200-100.jpg');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (302, '首页设置活动广告2', '首页设置活动广告2', 0, 2, 1, 208, 128, 100, 0, 0, 'web-1-13_53bfbfc958cb55a435545033bd075bf3.png');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (311, '首页设置图片广告1', '首页设置图片广告1', 0, 2, 1, 220, 100, 100, 0, 0, 'web-1-18_4c91b4889516f10059e6ccf921542323.gif');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (312, '首页设置图片广告2', '首页设置图片广告2', 0, 2, 1, 220, 100, 100, 0, 0, 'web-2-28_9f2f7dcad3049df7450cecd179e142d8.gif');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (313, '首页设置图片广告3', '首页设置图片广告3', 0, 2, 1, 220, 100, 100, 0, 0, 'web-3-38_ff9bd2d724f7138cec1b1937000f4feb.jpg');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (314, '首页设置图片广告4', '首页设置图片广告4', 0, 2, 1, 220, 100, 100, 0, 0, 'web-4-48_cce6e8b8852046a712028b85f99bfe20.jpg');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (371, '卖家中心页右侧广告位', '卖家中心页右侧广告位', 0, 1, 1, 200, 350, 100, 0, 0, 'adv200-300.gif');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (372, '买家中心页右侧广告位', '买家中心页右侧广告位', 0, 1, 1, 200, 350, 100, 0, 0, 'adv200-300.gif');

INSERT INTO `#__adv` (`adv_id`, `ap_id`, `adv_title`, `adv_content`, `adv_start_date`, `adv_end_date`, `slide_sort`, `member_id`, `member_name`, `click_num`, `is_allow`, `buy_style`, `goldpay`) VALUES (1, 13, '首页幻灯片测试广告1', 'a:2:{s:13:"adv_slide_pic";s:36:"271b2785f67f6119332213367516a426.jpg";s:13:"adv_slide_url";s:14:"www.shopnc.net";}', 1306857600, 1622476800, 1, 0, '', 0, 1, '', 0);
INSERT INTO `#__adv` (`adv_id`, `ap_id`, `adv_title`, `adv_content`, `adv_start_date`, `adv_end_date`, `slide_sort`, `member_id`, `member_name`, `click_num`, `is_allow`, `buy_style`, `goldpay`) VALUES (2, 13, '首页幻灯片测试广告2', 'a:2:{s:13:"adv_slide_pic";s:36:"bd32bd9949a93f96eeb7bf7fdc619361.jpg";s:13:"adv_slide_url";s:14:"www.shopnc.net";}', 1306857600, 1623772800, 2, 0, '', 0, 1, '', 0);
INSERT INTO `#__adv` (`adv_id`, `ap_id`, `adv_title`, `adv_content`, `adv_start_date`, `adv_end_date`, `slide_sort`, `member_id`, `member_name`, `click_num`, `is_allow`, `buy_style`, `goldpay`) VALUES (3, 13, '首页幻灯片测试广告3', 'a:2:{s:13:"adv_slide_pic";s:36:"7dbaaa6f5324cd4b7a3531dfc5ca810b.jpg";s:13:"adv_slide_url";s:14:"www.shopnc.net";}', 1306857600, 1622476800, 3, 0, '', 0, 1, '', 0);
INSERT INTO `#__adv` (`adv_id`, `ap_id`, `adv_title`, `adv_content`, `adv_start_date`, `adv_end_date`, `slide_sort`, `member_id`, `member_name`, `click_num`, `is_allow`, `buy_style`, `goldpay`) VALUES (4, 13, '首页幻灯片测试广告4', 'a:2:{s:13:"adv_slide_pic";s:36:"1c8f6c1c8192d7fa5d3cc7f30d7db09c.jpg";s:13:"adv_slide_url";s:14:"www.shopnc.net";}', 1306857600, 1622476800, 4, 0, '', 0, 1, '', 0);
INSERT INTO `#__adv` (`adv_id`, `ap_id`, `adv_title`, `adv_content`, `adv_start_date`, `adv_end_date`, `slide_sort`, `member_id`, `member_name`, `click_num`, `is_allow`, `buy_style`, `goldpay`) VALUES (5, 13, '首页幻灯片测试广告5', 'a:2:{s:13:"adv_slide_pic";s:36:"33e9d8a94c644cd87ca97f7ced8024af.jpg";s:13:"adv_slide_url";s:14:"www.shopnc.net";}', 1306857600, 1622476800, 5, 0, '', 0, 1, '', 0);
INSERT INTO `#__adv` (`adv_id`, `ap_id`, `adv_title`, `adv_content`, `adv_start_date`, `adv_end_date`, `slide_sort`, `member_id`, `member_name`, `click_num`, `is_allow`, `buy_style`, `goldpay`) VALUES (9, 25, '两格轮换广告02', 'a:2:{s:7:"adv_pic";s:36:"5591c0054e33b3d86fbdadb536bb50a5.jpg";s:11:"adv_pic_url";s:14:"www.shopnc.net";}', 1321977600, 1622476800, 0, 0, '', 0, 1, '', 0);
INSERT INTO `#__adv` (`adv_id`, `ap_id`, `adv_title`, `adv_content`, `adv_start_date`, `adv_end_date`, `slide_sort`, `member_id`, `member_name`, `click_num`, `is_allow`, `buy_style`, `goldpay`) VALUES (10, 24, '两格轮换广告01', 'a:2:{s:7:"adv_pic";s:36:"97caa4b287891a56f9434af1a5b71c82.jpg";s:11:"adv_pic_url";s:14:"www.shopnc.net";}', 1321977600, 1622476800, 0, 0, '', 0, 1, '', 0);
INSERT INTO `#__adv` (`adv_id`, `ap_id`, `adv_title`, `adv_content`, `adv_start_date`, `adv_end_date`, `slide_sort`, `member_id`, `member_name`, `click_num`, `is_allow`, `buy_style`, `goldpay`) VALUES (11, 23, '四格轮换广告01', 'a:2:{s:7:"adv_pic";s:36:"edbbe33a9dd3ca37861f4045e34edd5c.jpg";s:11:"adv_pic_url";s:14:"www.shopnc.net";}', 1321977600, 1622476800, 0, 0, '', 0, 1, '', 0);
INSERT INTO `#__adv` (`adv_id`, `ap_id`, `adv_title`, `adv_content`, `adv_start_date`, `adv_end_date`, `slide_sort`, `member_id`, `member_name`, `click_num`, `is_allow`, `buy_style`, `goldpay`) VALUES (12, 22, '四格轮换广告02', 'a:2:{s:7:"adv_pic";s:36:"606a56dfbd9509033358ad8beb8ac631.jpg";s:11:"adv_pic_url";s:14:"www.shopnc.net";}', 1321977600, 1622476800, 0, 0, '', 0, 1, '', 0);
INSERT INTO `#__adv` (`adv_id`, `ap_id`, `adv_title`, `adv_content`, `adv_start_date`, `adv_end_date`, `slide_sort`, `member_id`, `member_name`, `click_num`, `is_allow`, `buy_style`, `goldpay`) VALUES (13, 21, '四格轮换广告03', 'a:2:{s:7:"adv_pic";s:36:"7f7c874c8f3a4f3835c8fe0348b96600.jpg";s:11:"adv_pic_url";s:14:"www.shopnc.net";}', 1321977600, 1622476800, 0, 0, '', 0, 1, '', 0);
INSERT INTO `#__adv` (`adv_id`, `ap_id`, `adv_title`, `adv_content`, `adv_start_date`, `adv_end_date`, `slide_sort`, `member_id`, `member_name`, `click_num`, `is_allow`, `buy_style`, `goldpay`) VALUES (14, 20, '四格轮换广告04', 'a:2:{s:7:"adv_pic";s:36:"c2d7e0d98aab6f4f4f3c8639fe4b4722.jpg";s:11:"adv_pic_url";s:14:"www.shopnc.net";}', 1321977600, 1622476800, 0, 0, '', 0, 1, '', 0);

INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (1, '安信达', '0', 'anxindakuaixi', 'A', '2', 'http://www.anxinda.com');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (2, '包裹平邮', '1', 'youzhengguonei', 'B', '2', 'http://yjcx.chinapost.com.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (3, 'CCES', '1', 'cces', 'C', '2', 'http://www.cces.com.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (4, '传喜物流', '1', 'chuanxiwuliu', 'C', '2', 'http://www.cxcod.com');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (5, 'DHL快递', '1', 'dhl', 'D', '2', 'http://www.cn.dhl.com');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (6, '大田物流', '1', 'datianwuliu', 'D', '2', 'http://www.dtw.com.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (7, '德邦物流', '1', 'debangwuliu', 'D', '2', 'http://www.deppon.com');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (8, 'EMS', '1', 'ems', 'E', '2', 'http://www.ems.com.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (9, 'EMS国际', '1', 'emsguoji', 'E', '2', '###');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (10, '飞康达', '1', 'feikangda', 'F', '2', 'http://www.fkd.com.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (11, 'FedEx(国际)', '1', 'fedex', 'F', '2', 'http://fedex.com/cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (12, '凡客如风达', '1', 'rufengda', 'F', '2', 'http://www.rufengda.com');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (13, '港中能达', '1', 'ganzhongnengda', 'G', '2', 'http://www.nd56.com');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (14, '挂号信', '1', 'youzhengguonei', 'G', '2', 'http://yjcx.chinapost.com.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (15, '共速达', '1', 'gongsuda', 'G', '2', 'http://www.gongsuda.com/mall/Search.aspx');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (16, '汇通快递', '1', 'huitongkuaidi', 'H', '2', 'http://www.htky365.com');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (17, '华宇物流', '1', 'tiandihuayu', 'H', '2', 'http://www.hoau.net');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (18, '佳吉快运', '1', 'jiajiwuliu', 'J', '2', 'http://www.jiaji.com');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (19, '佳怡物流', '1', 'jiayiwuliu', 'J', '2', 'http://www.jiayi56.com');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (20, '急先达', '1', 'jixianda', 'J', '2', 'http://www.joust.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (21, '快捷速递', '1', 'kuaijiesudi', 'K', '2', 'http://www.fastexpress.com.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (22, '龙邦快递', '1', 'longbanwuliu', 'L', '2', 'http://www.lbex.com.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (23, '联邦快递', '1', 'lianbangkuaidi', 'L', '2', 'http://cndxp.apac.fedex.com/dxp.html');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (24, '联昊通', '1', 'lianhaowuliu', 'L', '2', 'http://www.lhtex.com.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (25, '全一快递', '1', 'quanyikuaidi', 'Q', '2', 'http://www.apex100.com');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (26, '全峰快递', '1', 'quanfengkuaidi', 'Q', '2', 'http://www.qfkd.com.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (27, '全日通', '1', 'quanritongkuaidi', 'Q', '2', 'http://www.at-express.com');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (28, '申通快递', '1', 'shentong', 'S', '2', 'http://www.sto.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (29, '顺丰快递', '1', 'shunfeng', 'S', '1', 'http://www.sf-express.com');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (30, '速尔快递', '1', 'suer', 'S', '2', 'http://www.sure56.com');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (31, 'TNT快递', '1', 'tnt', 'T', '2', 'http://www.tnt.com.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (32, '天天快递', '1', 'tiantian', 'T', '2', 'http://www.ttkdex.com');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (33, '天地华宇', '1', 'tiandihuayu', 'T', '2', 'http://www.hoau.net');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (34, 'UPS快递', '1', 'ups', 'U', '2', 'http://www.ups.com/cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (35, 'USPS', '1', 'usps', 'U', '2', 'http://www.kuaidi100.com/all/usps.shtml');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (36, '新邦物流', '1', 'xinbangwuliu', 'X', '2', 'http://www.xbwl.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (37, '信丰物流', '1', 'xinfengwuliu', 'X', '2', 'http://www.xf-express.com.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (38, '希伊艾斯', '1', 'cces', 'X', '2', 'http://www.cces.com.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (39, '新蛋物流', '1', 'neweggozzo', 'X', '2', 'http://www.ozzo.com.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (40, '圆通快递', '1', 'yuantong', 'Y', '1', 'http://www.yto.net.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (41, '韵达快递', '1', 'yunda', 'Y', '1', 'http://www.yundaex.com');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (42, '邮政包裹', '1', 'youzhengguonei', 'Y', '2', 'http://yjcx.chinapost.com.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (43, '优速快递', '1', 'youshuwuliu', 'Y', '2', 'http://www.uc56.com');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (44, '中通快递', '1', 'zhongtong', 'Z', '1', 'http://www.zto.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (45, '中铁快运', '1', 'zhongtiewuliu', 'Z', '2', 'http://www.cre.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (46, '宅急送', '1', 'zhaijisong', 'Z', '2', 'http://www.zjs.com.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (47, '中邮物流', '1', 'zhongyouwuliu', 'Z', '2', 'http://www.cnpl.com.cn');

INSERT INTO `#__seo` (`id`, `title`, `keywords`, `description`, `type`) VALUES (1, '{sitename}', 'ShopNC,PHP商城系统,ShopNC商城系统,多用户商城系统,电商ERP,电商CRM,电子商务解决方案', 'ShopNC专注于研发符合时代发展需要的电子商务商城系统，以专业化的服务水平为企业级用户提供B(2B)2C【B2B2C】电子商务平台解决方案，全力打造电商平台专项ERP(CRM)系统、ERP(RFID)系统等，引领中国电子商务行业企业级需求的发展方向。咨询电话：400-611-5098', 'index');
INSERT INTO `#__seo` (`id`, `title`, `keywords`, `description`, `type`) VALUES (2, '{sitename} - 团购', 'ShopNC,{sitename}', 'ShopNC专注于研发符合时代发展需要的电子商务商城系统，以专业化的服务水平为企业级用户提供B(2B)2C【B2B2C】电子商务平台解决方案，全力打造电商平台专项ERP(CRM)系统、ERP(RFID)系统等，引领中国电子商务行业企业级需求的发展方向。咨询电话：400-611-5098', 'group');
INSERT INTO `#__seo` (`id`, `title`, `keywords`, `description`, `type`) VALUES (3, '{sitename} - {name}', 'ShopNC,{name},{sitename}', 'ShopNC,{name},{sitename}', 'group_content');
INSERT INTO `#__seo` (`id`, `title`, `keywords`, `description`, `type`) VALUES (4, '{sitename} - 品牌', 'ShopNC,{sitename}', 'ShopNC,{sitename}', 'brand');
INSERT INTO `#__seo` (`id`, `title`, `keywords`, `description`, `type`) VALUES (5, '{sitename} - {name}', 'ShopNC,{sitename},{name}', 'ShopNC,{sitename},{name}', 'brand_list');
INSERT INTO `#__seo` (`id`, `title`, `keywords`, `description`, `type`) VALUES (6, '{sitename} - 优惠券', 'ShopNC,{sitename}', 'ShopNC,{sitename}', 'coupon');
INSERT INTO `#__seo` (`id`, `title`, `keywords`, `description`, `type`) VALUES (7, '{sitename} - {name}', 'ShopNC,{sitename},{name}', 'ShopNC,{sitename},{name}', 'coupon_content');
INSERT INTO `#__seo` (`id`, `title`, `keywords`, `description`, `type`) VALUES (8, '{sitename} - 积分商城', 'ShopNC,{sitename}', 'ShopNC,{sitename}', 'point');
INSERT INTO `#__seo` (`id`, `title`, `keywords`, `description`, `type`) VALUES (9, '{sitename} - {name}', 'ShopNC,{sitename},{key}', 'ShopNC,{sitename},{description}', 'point_content');
INSERT INTO `#__seo` (`id`, `title`, `keywords`, `description`, `type`) VALUES (10, '{sitename} - {article_class}', 'ShopNC,{sitename}', 'ShopNC,{sitename}', 'article');
INSERT INTO `#__seo` (`id`, `title`, `keywords`, `description`, `type`) VALUES (11, '{sitename} - {name}', 'ShopNC,{sitename},{key}', 'ShopNC,{sitename},{description}', 'article_content');
INSERT INTO `#__seo` (`id`, `title`, `keywords`, `description`, `type`) VALUES (12, '{sitename} - {shopname}', 'ShopNC,{sitename},{key}', 'ShopNC,{sitename},{description}', 'shop');
INSERT INTO `#__seo` (`id`, `title`, `keywords`, `description`, `type`) VALUES (13, '{name} - {sitename}', 'ShopNC,{sitename},{key}', 'ShopNC,{sitename},{description}', 'product');
INSERT INTO `#__seo` (`id`, `title`, `keywords`, `description`, `type`) VALUES (14, '看{name}怎么淘到好的宝贝-{sitename}', 'ShopNC,{sitename},{name}', 'ShopNC,{sitename},{name}', 'sns');

INSERT INTO `#__web` (`web_id`, `web_name`, `style_name`, `web_page`, `update_time`, `web_sort`, `web_show`, `web_html`) VALUES (1, '红色', 'red', 'index', 1346654878, 1, 1, NULL);
INSERT INTO `#__web` (`web_id`, `web_name`, `style_name`, `web_page`, `update_time`, `web_sort`, `web_show`, `web_html`) VALUES (2, '粉色', 'pink', 'index', 1346654890, 2, 1, NULL);
INSERT INTO `#__web` (`web_id`, `web_name`, `style_name`, `web_page`, `update_time`, `web_sort`, `web_show`, `web_html`) VALUES (3, '橘色', 'orange', 'index', 1346654909, 3, 1, NULL);
INSERT INTO `#__web` (`web_id`, `web_name`, `style_name`, `web_page`, `update_time`, `web_sort`, `web_show`, `web_html`) VALUES (4, '绿色', 'green', 'index', 1346654944, 4, 1, NULL);
INSERT INTO `#__web` (`web_id`, `web_name`, `style_name`, `web_page`, `update_time`, `web_sort`, `web_show`, `web_html`) VALUES (5, '蓝色', 'blue', 'index', 1346654957, 5, 0, NULL);
INSERT INTO `#__web` (`web_id`, `web_name`, `style_name`, `web_page`, `update_time`, `web_sort`, `web_show`, `web_html`) VALUES (6, '紫色', 'purple', 'index', 1346654976, 6, 0, NULL);
INSERT INTO `#__web` (`web_id`, `web_name`, `style_name`, `web_page`, `update_time`, `web_sort`, `web_show`, `web_html`) VALUES (7, '褐色', 'brown', 'index', 1346654987, 7, 0, NULL);
INSERT INTO `#__web` (`web_id`, `web_name`, `style_name`, `web_page`, `update_time`, `web_sort`, `web_show`, `web_html`) VALUES (8, '灰色', 'gray', 'index', 1346654998, 8, 0, NULL);

INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (11, 1, 'array', 'tit', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-11_f3acb5954fbdeef69591fd5a84ac3adb.png";s:3:"url";s:0:"";}', '标题图片');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (12, 1, 'array', 'category_list', '', '推荐分类');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (13, 1, 'array', 'act', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-13_53bfbfc958cb55a435545033bd075bf3.png";s:3:"url";s:0:"";}', '活动图片');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (15, 1, 'array', 'recommend_list', '', '商品推荐');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (17, 1, 'array', 'goods_list', '', '排行类型');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (18, 1, 'array', 'adv', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-18_4c91b4889516f10059e6ccf921542323.gif";s:3:"url";s:0:"";}', '广告图片');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (19, 1, 'array', 'brand_list', '', '品牌推荐');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (21, 2, 'array', 'tit', 'a:2:{s:3:"pic";s:56:"upload/adv/web-2-21_82132e2a55300f4e3a32be07af077d63.png";s:3:"url";s:0:"";}', '标题图片');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (22, 2, 'array', 'category_list', '', '推荐分类');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (23, 2, 'array', 'act', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-13_53bfbfc958cb55a435545033bd075bf3.png";s:3:"url";s:0:"";}', '活动图片');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (25, 2, 'array', 'recommend_list', '', '商品推荐');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (27, 2, 'array', 'goods_list', '', '排行类型');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (28, 2, 'array', 'adv', 'a:2:{s:3:"pic";s:56:"upload/adv/web-2-28_9f2f7dcad3049df7450cecd179e142d8.gif";s:3:"url";s:0:"";}', '广告图片');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (29, 2, 'array', 'brand_list', '', '品牌推荐');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (31, 3, 'array', 'tit', 'a:2:{s:3:"pic";s:56:"upload/adv/web-3-31_ebd488bcb4e1e97798cc0528135fbdd6.png";s:3:"url";s:0:"";}', '标题图片');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (32, 3, 'array', 'category_list', '', '推荐分类');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (33, 3, 'array', 'act', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-13_53bfbfc958cb55a435545033bd075bf3.png";s:3:"url";s:0:"";}', '活动图片');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (35, 3, 'array', 'recommend_list', '', '商品推荐');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (37, 3, 'array', 'goods_list', '', '排行类型');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (38, 3, 'array', 'adv', 'a:2:{s:3:"pic";s:56:"upload/adv/web-3-38_ff9bd2d724f7138cec1b1937000f4feb.jpg";s:3:"url";s:0:"";}', '广告图片');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (39, 3, 'array', 'brand_list', '', '品牌推荐');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (41, 4, 'array', 'tit', 'a:2:{s:3:"pic";s:56:"upload/adv/web-4-41_aa1184ab1026c95ec8cc3c6f8c282287.png";s:3:"url";s:0:"";}', '标题图片');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (42, 4, 'array', 'category_list', '', '推荐分类');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (43, 4, 'array', 'act', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-13_53bfbfc958cb55a435545033bd075bf3.png";s:3:"url";s:0:"";}', '活动图片');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (45, 4, 'array', 'recommend_list', '', '商品推荐');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (47, 4, 'array', 'goods_list', '', '排行类型');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (48, 4, 'array', 'adv', 'a:2:{s:3:"pic";s:56:"upload/adv/web-4-48_cce6e8b8852046a712028b85f99bfe20.jpg";s:3:"url";s:0:"";}', '广告图片');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (49, 4, 'array', 'brand_list', '', '品牌推荐');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (51, 5, 'array', 'tit', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-11_f3acb5954fbdeef69591fd5a84ac3adb.png";s:3:"url";s:0:"";}', '标题图片');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (52, 5, 'array', 'category_list', '', '推荐分类');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (53, 5, 'array', 'act', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-13_53bfbfc958cb55a435545033bd075bf3.png";s:3:"url";s:0:"";}', '活动图片');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (55, 5, 'array', 'recommend_list', '', '商品推荐');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (57, 5, 'array', 'goods_list', '', '排行类型');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (58, 5, 'array', 'adv', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-18_4c91b4889516f10059e6ccf921542323.gif";s:3:"url";s:0:"";}', '广告图片');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (59, 5, 'array', 'brand_list', '', '品牌推荐');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (61, 6, 'array', 'tit', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-11_f3acb5954fbdeef69591fd5a84ac3adb.png";s:3:"url";s:0:"";}', '标题图片');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (62, 6, 'array', 'category_list', '', '推荐分类');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (63, 6, 'array', 'act', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-13_53bfbfc958cb55a435545033bd075bf3.png";s:3:"url";s:0:"";}', '活动图片');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (65, 6, 'array', 'recommend_list', '', '商品推荐');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (67, 6, 'array', 'goods_list', '', '排行类型');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (68, 6, 'array', 'adv', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-18_4c91b4889516f10059e6ccf921542323.gif";s:3:"url";s:0:"";}', '广告图片');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (69, 6, 'array', 'brand_list', '', '品牌推荐');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (71, 7, 'array', 'tit', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-11_f3acb5954fbdeef69591fd5a84ac3adb.png";s:3:"url";s:0:"";}', '标题图片');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (72, 7, 'array', 'category_list', '', '推荐分类');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (73, 7, 'array', 'act', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-13_53bfbfc958cb55a435545033bd075bf3.png";s:3:"url";s:0:"";}', '活动图片');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (75, 7, 'array', 'recommend_list', '', '商品推荐');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (77, 7, 'array', 'goods_list', '', '排行类型');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (78, 7, 'array', 'adv', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-18_4c91b4889516f10059e6ccf921542323.gif";s:3:"url";s:0:"";}', '广告图片');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (79, 7, 'array', 'brand_list', '', '品牌推荐');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (81, 8, 'array', 'tit', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-11_f3acb5954fbdeef69591fd5a84ac3adb.png";s:3:"url";s:0:"";}', '标题图片');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (82, 8, 'array', 'category_list', '', '推荐分类');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (83, 8, 'array', 'act', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-13_53bfbfc958cb55a435545033bd075bf3.png";s:3:"url";s:0:"";}', '活动图片');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (85, 8, 'array', 'recommend_list', '', '商品推荐');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (87, 8, 'array', 'goods_list', '', '排行类型');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (88, 8, 'array', 'adv', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-18_4c91b4889516f10059e6ccf921542323.gif";s:3:"url";s:0:"";}', '广告图片');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (89, 8, 'array', 'brand_list', '', '品牌推荐');

INSERT INTO `#__gold_payment` (`payment_id`, `payment_code`, `payment_name`, `payment_info`, `payment_config`, `payment_online`, `payment_state`, `payment_sort`) VALUES(1, 'offline', '线下支付', '线下支付描述', 'a:1:{s:0:"";s:0:"";}', 0, 1, 3);
INSERT INTO `#__gold_payment` (`payment_id`, `payment_code`, `payment_name`, `payment_info`, `payment_config`, `payment_online`, `payment_state`, `payment_sort`) VALUES(2, 'alipay', '支付宝', '', 'a:1:{s:0:"";s:0:"";}', 1, 2, 3);
INSERT INTO `#__gold_payment` (`payment_id`, `payment_code`, `payment_name`, `payment_info`, `payment_config`, `payment_online`, `payment_state`, `payment_sort`) VALUES(3, 'tenpay', '财付通', '', 'a:2:{s:14:"tenpay_account";s:10:"1900000109";s:10:"tenpay_key";s:32:"8934e7d15453e97507ef794cf7b0519d";}', 1, 2, 3);
INSERT INTO `#__gold_payment` (`payment_id`, `payment_code`, `payment_name`, `payment_info`, `payment_config`, `payment_online`, `payment_state`, `payment_sort`) VALUES(4, 'chinabank', '网银在线', '', 'a:2:{s:17:"chinabank_account";s:4:"1001";s:13:"chinabank_key";s:4:"test";}', 1, 1, 3);
INSERT INTO `#__gold_payment` (`payment_id`, `payment_code`, `payment_name`, `payment_info`, `payment_config`, `payment_online`, `payment_state`, `payment_sort`) VALUES('5', 'predeposit', '预存款', NULL, NULL, '1', '2', '3');

INSERT INTO `#__article_class` (`ac_id`, `ac_code`, `ac_name`, `ac_parent_id`, `ac_sort`) VALUES(1, 'notice', '商城公告', 0, 255);
INSERT INTO `#__article_class` (`ac_id`, `ac_code`, `ac_name`, `ac_parent_id`, `ac_sort`) VALUES(2, 'member', '帮助中心', 0, 255);
INSERT INTO `#__article_class` (`ac_id`, `ac_code`, `ac_name`, `ac_parent_id`, `ac_sort`) VALUES(3, 'store', '店主之家', 0, 255);
INSERT INTO `#__article_class` (`ac_id`, `ac_code`, `ac_name`, `ac_parent_id`, `ac_sort`) VALUES(4, 'payment', '支付方式', 0, 255);
INSERT INTO `#__article_class` (`ac_id`, `ac_code`, `ac_name`, `ac_parent_id`, `ac_sort`) VALUES(5, 'sold', '售后服务', 0, 255);
INSERT INTO `#__article_class` (`ac_id`, `ac_code`, `ac_name`, `ac_parent_id`, `ac_sort`) VALUES(6, 'service', '客服中心', 0, 255);
INSERT INTO `#__article_class` (`ac_id`, `ac_code`, `ac_name`, `ac_parent_id`, `ac_sort`) VALUES(7, 'about', '关于我们', 0, 255);

INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(6, 2, '', 1, 255, '如何注册成为会员', '<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:24px;color:#003399;font-family:Microsoft YaHei;background-color:#ffffff;"><span style="font-size:18px;">登录商城首页，点击页面右上方“注册”</span></span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span lang="EN-US" style="font-size:9pt;color:red;line-height:115%;font-family:Calibri;mso-bidi-font-size:8.0pt;mso-fareast-font-family:宋体;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><?xml:namespace prefix = v ns = "urn:schemas-microsoft-com:vml" /><v:shapetype id="_x0000_t75" coordsize="21600,21600" o:spt="75" o:preferrelative="t" path="m@4@5l@4@11@9@11@9@5xe" stroked="f" filled="f"><span style="font-size:24px;">&nbsp;</span><img alt="" src="./upload/editor/20110128134626_62236.jpg" border="0" /></v:shapetype></span></span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span lang="EN-US" style="font-size:9pt;color:red;line-height:115%;font-family:Calibri;mso-bidi-font-size:8.0pt;mso-fareast-font-family:宋体;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><v:shapetype coordsize="21600,21600" o:spt="75" o:preferrelative="t" path="m@4@5l@4@11@9@11@9@5xe" stroked="f" filled="f"><span style="font-size:24px;">&nbsp;</span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;"><span style="font-size:small;color:#003399;"><span style="font-size:18px;">进入注册页面，填写相关信息并阅读用户服务手册</span></span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;"><span style="font-size:small;color:#335a89;"><img alt="" src="./upload/editor/20110128135022_79350.jpg" border="0" /></span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;"><span style="font-size:small;color:#003399;"><span style="font-size:18px;">相关资料填写完成后点击“免费注册”提交</span></span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;"><span style="font-size:small;color:#003399;"><img alt="" src="./upload/editor/20110128135237_43758.jpg" border="0" /></span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;"><span style="font-size:small;color:#003399;"><span style="font-size:18px;">提示注册成功</span></span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;"><span style="font-size:small;color:#003399;"><img alt="" src="./upload/editor/20110128135406_55835.jpg" border="0" /></span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<h3>&nbsp;</h3>\r\n</v:shapetype></span></span></span>', 1294709136);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(7, 2, '', 1, 255, '如何搜索', '<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:24px;color:#003399;font-family:Microsoft YaHei;background-color:#ffffff;"><span style="font-size:18px;">登录商城首页，在搜索商品的搜索框内填入要搜索的商品的关键字，点击“搜索”</span></span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:24px;color:#003399;font-family:Microsoft YaHei;background-color:#ffffff;"><span style="font-size:18px;"><img alt="" src="./upload/editor/20110208093142_97861.jpg" border="0" /></span></span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:24px;color:#003399;font-family:Microsoft YaHei;background-color:#ffffff;"><span style="font-size:18px;">出现含有关键字的商品页面</span></span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:24px;color:#003399;font-family:Microsoft YaHei;background-color:#ffffff;"><span style="font-size:18px;"><img alt="" src="./upload/editor/20110208094130_68431.jpg" border="0" width="700px" /></span></span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>', 1294709301);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(8, 2, '', 1, 255, '忘记密码', '<span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;"> <h3 style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;">进入会员登录页面，点击“忘记密码”</span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><img alt="" src="./upload/editor/20110208095308_38085.jpg" border="0" /></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"> <h3 style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;">在忘记密码页面中填写用户名、电子邮箱等信息，点击“提交找回”</span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><img alt="" src="./upload/editor/20110208095715_55839.jpg" border="0" /></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:x-small;color:#ff0000;">电子邮箱地址要填写注册用户名是的邮箱</span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;">\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="color:#003399;">提示电子邮件已发送成功</span></span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><img alt="" src="./upload/editor/20110208095945_10374.jpg" border="0" /></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:18px;color:#003399;line-height:115%;font-family:SimSun;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-size:8.0pt;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;">登录电子邮箱查看，找回密码</span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:18px;color:#003399;line-height:115%;font-family:SimSun;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-size:8.0pt;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><img alt="" src="./upload/editor/20110208100610_22468.jpg" border="0" /></span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n</span></h3>\r\n</span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n</span></span></span>', 1294709313);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(9, 2, '', 1, 255, '我要买', '<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;">会员登陆商城首页，打开商品信息页面</span></span></span></p>\r\n<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;"><img alt="" src="./upload/editor/20110208170115_29919.jpg" border="0" width="700px" /></span></span></span></p>\r\n<p>&nbsp;</p>\r\n<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;">填写购买数量，点击“加入购物车”</span></span></span></p>\r\n<p></p>\r\n<p><img alt="" src="./upload/editor/20110209093017_89659.jpg" border="0" /></p>\r\n<p>&nbsp;</p>\r\n<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;">点击“查看购物车”</span></span></span></p>\r\n<p><img alt="" src="./upload/editor/20110209093309_99011.jpg" border="0" /></p>\r\n<p>&nbsp;</p>\r\n<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;">点击“填写并确认订单”</span></span></span></p>\r\n<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;"><img alt="" src="./upload/editor/20110209093721_30123.jpg" border="0" width="700px" /></span></span></span></p>\r\n<p>&nbsp;</p>\r\n<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;">填写信息，点击“下单完成并支付”</span></span></span></p>\r\n<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;"><img alt="" src="./upload/editor/20110209093819_87401.jpg" border="0" width="700px" /></span></span></span></p>\r\n<p>&nbsp;</p>\r\n<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;"><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;">选择支付方式，点击“确认支付”</span></span></span></span></span></span></p>\r\n<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;"><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;"><img alt="" src="./upload/editor/20110209094020_49119.jpg" border="0" width="700px" /></span></span></span></span></span></span></p>\r\n<p>&nbsp;</p>\r\n<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;"><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;">购买商品成功</span></span></span></span></span></span></p>\r\n<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;"><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;"><img alt="" src="./upload/editor/20110209094145_20766.jpg" border="0" width="700px"/></span></span></span></span></span></span></p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>', 1294709365);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(10, 2, '', 1, 255, '查看已购买商品', '<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;">会员登录商城，进入用户中心</span></span></span></p>\r\n<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;"><img alt="" src="./upload/editor/20110209094358_99646.jpg" border="0" /></span></span></span></p>\r\n<p>&nbsp;</p>\r\n<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;">在我是买家板块点进“我的订单”进入，则可查看已购买宝贝</span></span></span></p>\r\n<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;"><img alt="" src="./upload/editor/20110209094502_62272.jpg" border="0" width="700px"/></span></span></span></p>', 1294709380);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(11, 3, '', 1, 255, '如何管理店铺', '<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="font-size:18px;color:#003399;font-family:SimSun;"><span style="font-size:18px;color:#003399;font-family:SimSun;">&nbsp;</span><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;">会员登陆商城进入用户中心，在我是卖家板块找到“店铺设置”点击</span></span></span></span></span></span></p>\r\n<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="font-size:18px;color:#003399;font-family:SimSun;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;"><img alt="" src="./upload/editor/20110209101544_91746.jpg" border="0" /></span></span></span></span></span></span></p>\r\n<span style="font-family:SimSun;"><span style="font-size:18px;"><span style="font-size:18px;color:#003399;font-family:SimSun;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;"> <p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;">填写店铺信息后点击“提交”</span></span></span></p>\r\n<h3 style="margin:15pt 0cm 0pt;"></h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><img alt="" src="./upload/editor/20110209132805_31517.jpg" border="0" /></h3>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;">点击我的店铺首页可查看设置后的首页</span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;"><img alt="" src="./upload/editor/20110209133004_49592.jpg" border="0" /></span></span></span></p>\r\n</span></span></span></span></span></span> <p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="font-size:18px;color:#003399;font-family:SimSun;">&nbsp;</p>\r\n<p class="MsoNormal" style="margin:10pt 0cm;"><span style="font-size:x-small;"><span style="color:#000000;"><span style="font-size:18px;color:#003399;font-family:SimSun;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span lang="EN-US" style="font-size:10pt;line-height:115%;font-family:Calibri;mso-fareast-font-family:宋体;mso-bidi-font-family:Times New Roman;mso-bidi-font-size:10.5pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><?xml:namespace prefix = v /><v:shapetype stroked="f" filled="f" path="m@4@5l@4@11@9@11@9@5xe" o:preferrelative="t" o:spt="75" coordsize="21600,21600"></v:shapetype></span></span></span></span>&nbsp;</p>\r\n<p class="MsoNormal" style="margin:10pt 0cm;"><span style="font-size:x-small;"><span style="color:#000000;"><span style="font-size:18px;color:#003399;font-family:SimSun;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span lang="EN-US" style="font-size:10pt;line-height:115%;font-family:Calibri;mso-fareast-font-family:宋体;mso-bidi-font-family:Times New Roman;mso-bidi-font-size:10.5pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><v:shapetype stroked="f" filled="f" path="m@4@5l@4@11@9@11@9@5xe" o:preferrelative="t" o:spt="75" coordsize="21600,21600"><span style="color:#000000;"><?xml:namespace prefix = v ns = "urn:schemas-microsoft-com:vml" /><v:stroke joinstyle="miter"></v:stroke></span><v:formulas><v:f eqn="if lineDrawn pixelLineWidth 0"></v:f><v:f eqn="sum @0 1 0"></v:f><v:f eqn="sum 0 0 @1"></v:f><v:f eqn="prod @2 1 2"></v:f><v:f eqn="prod @3 21600 pixelWidth"></v:f><v:f eqn="prod @3 21600 pixelHeight"></v:f><v:f eqn="sum @0 0 1"></v:f><v:f eqn="prod @6 1 2"></v:f><v:f eqn="prod @7 21600 pixelWidth"></v:f><v:f eqn="sum @8 21600 0"></v:f><v:f eqn="prod @7 21600 pixelHeight"></v:f><v:f eqn="sum @10 21600 0"></v:f></v:formulas><v:path o:connecttype="rect" gradientshapeok="t" o:extrusionok="f"></v:path><?xml:namespace prefix = o ns = "urn:schemas-microsoft-com:office:office" /><o:lock aspectratio="t" v:ext="edit"></o:lock></v:shapetype></span></span></span></span>&nbsp;</p>\r\n</span></span></span>', 1294709442);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(12, 3, '', 1, 255, '查看售出商品', '<span style="font-size:18px;color:#003399;font-family:SimSun;"> <p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;">会员登陆商城进入用户中心，在我是卖家板块找到“订单管理”点击</span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;"><img alt="" src="./upload/editor/20110209141334_26280.jpg" border="0" /></span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;">点击“查看订单”</span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;"><img alt="" src="./upload/editor/20110209143053_56888.jpg" border="0" /></span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n</span>', 1294709506);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(13, 3, '', 1, 255, '如何发货', '<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;">在所有订单列表页面，点击“收到货款”</span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;"><img alt="" src="./upload/editor/20110209144219_67019.jpg" border="0" /></span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;"> <p style="margin:15pt 0cm 0pt;"><span style="font-family:SimSun;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;">填写操作描述，点击“确定”</span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:SimSun;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><img alt="" src="./upload/editor/20110209144319_11772.jpg" border="0" /></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<span style="font-family:SimSun;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"> <p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="color:#335a89;font-size:small;">在所有订单列表页面，点击“发货”</span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><img alt="" src="./upload/editor/20110209150146_55268.jpg" border="0" /></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"> <p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="color:#335a89;font-size:small;">填写物流编号以及操作描述，点击“确定”</span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><img alt="" src="./upload/editor/20110209150256_60581.jpg" border="0" /></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n</span></span> <p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n</span></span></span>', 1294709579);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(14, 3, '', 1, 255, '商城商品推荐', '<p><span style="font-size:18px;color:#003399;line-height:115%;font-family:宋体;mso-bidi-font-size:8.0pt;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;">会员登陆商城进入用户中心，在我是卖家板块找到“商品管理”点击</span></p>\r\n<p><span style="font-size:18px;color:#003399;line-height:115%;font-family:宋体;mso-bidi-font-size:8.0pt;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><img alt="" src="./upload/editor/20110209154027_17581.jpg" border="0" /></span></p>\r\n<p>&nbsp;</p>\r\n<span style="font-size:18px;color:#003399;line-height:115%;font-family:宋体;mso-bidi-font-size:8.0pt;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"> <p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;">在商品列表中点击该商品后的“编辑”</span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><img alt="" src="./upload/editor/20110209155654_54046.jpg" border="0" /></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;">选择推荐，点击“提交”</span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><img alt="" src="./upload/editor/20110209160008_38544.jpg" border="0" /></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><img alt="" src="./upload/editor/20110209160122_33174.jpg" border="0" /></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n</span>', 1294709599);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(15, 3, '', 1, 255, '如何申请开店', '<p><span style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-ascii-font-family:Times New Roman;mso-hansi-font-family:Times New Roman;mso-bidi-font-family:Times New Roman;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;">登录商城首页，点击右上角“用户中心</span><span lang="EN-US" style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;mso-fareast-font-family:宋体;">”</span></p>\r\n<p><span lang="EN-US" style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;mso-fareast-font-family:宋体;"><img alt="" src="./upload/editor/20110209162925_19705.jpg" border="0" /></span></p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p><span lang="EN-US" style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;mso-fareast-font-family:宋体;"><span style="color:#000000;"><span style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-ascii-font-family:Times New Roman;mso-hansi-font-family:Times New Roman;mso-bidi-font-family:Times New Roman;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;">会员进入用户中心页面，点击下方</span><span style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-ascii-font-family:Times New Roman;mso-hansi-font-family:Times New Roman;mso-bidi-font-family:Times New Roman;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;">“申请开店”</span></span></span></p>\r\n<p><span lang="EN-US" style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;mso-fareast-font-family:宋体;"><span style="color:#000000;"><span style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-ascii-font-family:Times New Roman;mso-hansi-font-family:Times New Roman;mso-bidi-font-family:Times New Roman;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><img alt="" src="./upload/editor/20110209163229_20901.jpg" border="0" /></span></span></span></p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p><span lang="EN-US" style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;mso-fareast-font-family:宋体;"><span style="color:#000000;"><span style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-ascii-font-family:Times New Roman;mso-hansi-font-family:Times New Roman;mso-bidi-font-family:Times New Roman;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><span style="color:#000000;"><span style="font-size:18px;color:#003399;font-family:宋体;mso-bidi-font-size:12.0pt;mso-ascii-font-family:Times New Roman;mso-hansi-font-family:Times New Roman;mso-bidi-font-family:Times New Roman;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;">选择店铺类型，收费标准等，点击“立即开店”</span></span></span></span></span></p>\r\n<p><span lang="EN-US" style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;mso-fareast-font-family:宋体;"><span style="color:#000000;"><span style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-ascii-font-family:Times New Roman;mso-hansi-font-family:Times New Roman;mso-bidi-font-family:Times New Roman;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><span style="color:#000000;"><span style="font-size:18px;color:#003399;font-family:宋体;mso-bidi-font-size:12.0pt;mso-ascii-font-family:Times New Roman;mso-hansi-font-family:Times New Roman;mso-bidi-font-family:Times New Roman;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><img alt="" src="./upload/editor/20110209163457_37558.jpg" border="0" width="700px" /></span></span></span></span></span></p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p><span lang="EN-US" style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;mso-fareast-font-family:宋体;"><span style="color:#000000;"><span style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-ascii-font-family:Times New Roman;mso-hansi-font-family:Times New Roman;mso-bidi-font-family:Times New Roman;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><span style="color:#000000;"><span style="font-size:18px;color:#003399;font-family:宋体;mso-bidi-font-size:12.0pt;mso-ascii-font-family:Times New Roman;mso-hansi-font-family:Times New Roman;mso-bidi-font-family:Times New Roman;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;">填写店主店铺信息，点击“立即开店”</span></span></span></span></span></p>\r\n<p><span lang="EN-US" style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;mso-fareast-font-family:宋体;"><span style="color:#000000;"><span style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-ascii-font-family:Times New Roman;mso-hansi-font-family:Times New Roman;mso-bidi-font-family:Times New Roman;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><span style="color:#000000;"><span style="font-size:18px;color:#003399;font-family:宋体;mso-bidi-font-size:12.0pt;mso-ascii-font-family:Times New Roman;mso-hansi-font-family:Times New Roman;mso-bidi-font-family:Times New Roman;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><img alt="" src="./upload/editor/20110209164206_43906.jpg" border="0" /></span></span></span></span></span></p>\r\n<p>&nbsp;</p>\r\n<p><span lang="EN-US" style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;mso-fareast-font-family:宋体;"><span style="color:#000000;"><span style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-ascii-font-family:Times New Roman;mso-hansi-font-family:Times New Roman;mso-bidi-font-family:Times New Roman;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><span style="color:#000000;"><span style="font-size:18px;color:#003399;font-family:宋体;mso-bidi-font-size:12.0pt;mso-ascii-font-family:Times New Roman;mso-hansi-font-family:Times New Roman;mso-bidi-font-family:Times New Roman;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;">提示申请开店成功</span></span></span></span></span></p>\r\n<p><span lang="EN-US" style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;mso-fareast-font-family:宋体;"><span style="color:#000000;"><span style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-ascii-font-family:Times New Roman;mso-hansi-font-family:Times New Roman;mso-bidi-font-family:Times New Roman;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><span style="color:#000000;"><span style="font-size:18px;color:#003399;font-family:宋体;mso-bidi-font-size:12.0pt;mso-ascii-font-family:Times New Roman;mso-hansi-font-family:Times New Roman;mso-bidi-font-family:Times New Roman;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><img alt="" src="./upload/editor/20110209164344_55309.jpg" border="0" /></span></span></span></span></span></p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>', 1294709809);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(16, 4, '', 1, 255, '如何注册支付宝', '<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;">会员登陆商城进入用户中心，在我是卖家板块找到“支付方式管理”点击</span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;"><img alt="" src="./upload/editor/20110210083402_90837.jpg" border="0" /></span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;"><span style="font-size:18px;color:#003399;line-height:115%;font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-size:8.0pt;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;">点击需要的添加的支付方式后的“安装”</span></span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;"><span style="font-size:18px;color:#003399;line-height:115%;font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-size:8.0pt;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><img alt="" src="./upload/editor/20110210084935_79853.jpg" border="0" /></span></span></span></span></p>\r\n<span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;"><span style="font-size:18px;color:#003399;line-height:115%;font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-size:8.0pt;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"> <h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;">填写相关信息，点击“提交”</span></span></p>\r\n</span></span></span></span> <p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;"><span style="font-size:18px;color:#003399;line-height:115%;font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-size:8.0pt;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><img alt="" src="./upload/editor/20110210085515_46504.jpg" border="0" /></span></span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>', 1294709827);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(17, 4, '', 1, 255, '在线支付', '在线支付', 1294713631);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(18, 6, '', 1, 255, '会员修改密码', '<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;">会员登录商城，点击右上角“用户中心”进入</span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;"><img alt="" src="./upload/editor/20110210100016_71548.jpg" border="0" width="700px" /></span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;">在我的账户板块点击“个人资料”进入</span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;"><img alt="" src="./upload/editor/20110210100143_75461.jpg" border="0" /></span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;">在个人资料页面点击“修改密码”</span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;"><img alt="" src="./upload/editor/20110210100354_81369.jpg" border="0" /></span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;">填写密码口令，点击“提交”</span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;"><img alt="" src="./upload/editor/20110210100612_16845.jpg" border="0" /></span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>', 1294713819);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(19, 6, '', 1, 255, '会员修改个人资料', '<p><span style="font-size:18px;color:#003399;line-height:115%;font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-size:8.0pt;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;">会员登录商城，点击右上角“用户中心”进入</span></p>\r\n<p><span style="font-size:18px;color:#003399;line-height:115%;font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-size:8.0pt;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><img alt="" src="./upload/editor/20110210100846_23142.jpg" border="0" /></span></p>\r\n<p>&nbsp;</p>\r\n<span style="font-size:18px;color:#003399;line-height:115%;font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-size:8.0pt;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"> <p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;">在用户中心的我的账户板块点击“个人资料”</span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><img alt="" src="./upload/editor/20110210101042_74191.jpg" border="0" /></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"> <p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;">也可在用户中心默认界面（账户概况）点击“编辑个人资料”</span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><img alt="" src="./upload/editor/20110210101209_36181.jpg" border="0" /></span></p>\r\n<span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"> <p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;">填写个人信息资料，点击“更改头像”</span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><img alt="" src="./upload/editor/20110210101333_62566.jpg" border="0" /></span></span></p>\r\n<span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"> <p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;">进行本地上传图片更改头像</span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><img alt="" src="./upload/editor/20110210101528_80109.jpg" border="0" /></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:18px;color:#003399;line-height:115%;font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-size:8.0pt;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;">修改头像、填写完成个人信息后点击“保存修改”</span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:18px;color:#003399;line-height:115%;font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-size:8.0pt;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><img alt="" src="./upload/editor/20110210101632_31534.jpg" border="0" /></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:18px;color:#003399;line-height:115%;font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-size:8.0pt;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"> <p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="color:#003399;">完成个人信息修改</span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="color:#003399;"><img alt="" src="./upload/editor/20110210101732_37374.jpg" border="0" /></span></span></span></p>\r\n</span></span> <p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n</span></span> <p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n</span></span></span>', 1294713836);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(20, 6, '', 1, 255, '商品发布', '<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;">会员登陆商城进入用户中心，在我是卖家板块找到“商品管理”点击</span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><img alt="" src="./upload/editor/20110210102523_43795.jpg" border="0" /></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"> <p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;">在商品列表中点击“新增商品”</span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><img alt="" src="./upload/editor/20110210102626_41732.jpg" border="0" /></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"> <p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;">填写商品的详细信息，点击“提交”发布</span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><img alt="" src="./upload/editor/20110210102729_99892.jpg" border="0" /></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"> <p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;">提示添加商品成功</span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><img alt="" src="./upload/editor/20110210102812_84565.jpg" border="0" /></span></p>\r\n</span></span></span>', 1294713852);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(21, 6, '', 1, 255, '修改收货地址', '<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;">会员登录商城进入用户中心，在我是买家板块找到“我的地址”点击进入</span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;"><img alt="" src="./upload/editor/20110210103254_50780.jpg" border="0" /></span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;"><span style="font-size:18px;color:#003399;line-height:115%;font-family:SimSun;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-size:8.0pt;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;">在地址列表页面点击该地址后的“编辑”</span></span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;"><span style="font-size:18px;color:#003399;line-height:115%;font-family:SimSun;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-size:8.0pt;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><img alt="" src="./upload/editor/20110210103509_39444.jpg" border="0" /></span></span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;"><span style="font-size:18px;color:#003399;line-height:115%;font-family:SimSun;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-size:8.0pt;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"> <p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;">可对该地址的相关信息进行修改后，点击“编辑地址”保存</span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:宋体;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><img alt="" src="./upload/editor/20110210103710_47524.jpg" border="0" /></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n</span></span></span></span> <p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>', 1294713910);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(22, 7, '', 1, 255, '关于ShopNC', '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 天津市网城创想科技有限责任公司位于天津市南开区，是专业从事生产管理信息化领域技术咨询和软件开发的高新技术企业。公司拥有多名技术人才和资深的行业解决方案专家。</p>\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 公司拥有一支勇于开拓、具有战略眼光和敏锐市场判断力的市场营销队伍，一批求实敬业，追求卓越的行政管理人才，一个能征善战，技术优秀，经验丰富的开发团队。公司坚持按现代企业制度和市场规律办事，在扩大经营规模的同时，注重企业经济运行质量，在自主产品研发及承接软件项目方面获得了很强的竞争力。 我公司也积极参与国内传统企业的信息化改造，引进国际化产品开发的标准，规范软件开发流程，通过提升各层面的软件开发人才的技术素质，打造国产软件精品，目前已经开发出具有自主知识产权的网络商城软件，还在积极开发基于电子商务平台高效能、高效益的管理系统。为今后进一步开拓国内市场打下坚实的基础。公司致力于构造一个开放、发展的人才平台，积极营造追求卓越、积极奉献的工作氛围，把“以人为本”的理念落实到每一项具体工作中，为那些锋芒内敛，激情无限的业界精英提供充分的发展空间，优雅自信、从容自得的工作环境，事业雄心与生活情趣两相兼顾的生活方式。并通过每个员工不断提升自我，以自己的独特价值观对工作与生活作最准确的判断，使我们每一个员工彰显出他们出色的自我品位，独有的工作个性和卓越的创新风格，让他们时刻保持振奋、不断鼓舞内心深处的梦想，永远走在时代潮流前端。公司发展趋势 励精图治，展望未来。公司把发展产业策略与发掘人才策略紧密结合，广纳社会精英，挖掘创新潜能，以人为本，凝聚人气，努力营造和谐宽松的工作氛围，为优秀人才的脱颖而出提供机遇。公司将在深入发展软件产业的同时，通过不懈的努力，来塑造大型软件公司的辉煌形象。 </p>', 1294714215);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(23, 7, '', 1, 255, '联系我们', '<p>欢迎您对我们的站点、工作、产品和服务提出自己宝贵的意见或建议。我们将给予您及时答复。同时也欢迎您到我们公司来洽商业务。</p>\r\n<p><br />\r\n<strong>公司名称</strong>： 天津市网城创想科技有限责任公司 <br />\r\n<strong>通信地址</strong>： 天津市南开区红旗路220号慧谷大厦712 <br />\r\n<strong>邮政编码</strong>： 300072 <br />\r\n<strong>电话</strong>： 400-611-5098 <br />\r\n<strong>商务洽谈</strong>： 86-022-87631069 <br />\r\n<strong>传真</strong>： 86-022-87631069 <br />\r\n<strong>软件企业编号</strong>： 120193000029441 <br />\r\n<strong>软件著作权登记号</strong>： 2008SR07843 <br />\r\n<strong>ICP备案号</strong>： 津ICP备08000171号 </p>', 1294714228);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(24, 7, '', 1, 255, '招聘英才', '<dl> <h3>PHP程序员</h3>\r\n<dt>职位要求： <dd>熟悉PHP5开发语言；<br />\r\n熟悉MySQL5数据库，同时熟悉sqlserver，oracle者优先；<br />\r\n熟悉面向对象思想，MVC三层体系，至少使用过目前已知PHP框架其中一种；<br />\r\n熟悉SERVER2003/Linux操作系统，熟悉常用Linux操作命令；<br />\r\n熟悉Mysql数据库应用开发，了解Mysql的数据库配置管理、性能优化等基本操作技能；<br />\r\n熟悉jquery，smarty等常用开源软件；<br />\r\n具备良好的代码编程习惯及较强的文档编写能力；<br />\r\n具备良好的团队合作能力；<br />\r\n熟悉设计模式者优先；<br />\r\n熟悉java，c++,c#,python其中一种者优先； </dd> <dt>学历要求： <dd>大本 </dd> <dt>工作经验： <dd>一年以上 </dd> <dt>工作地点： <dd>天津 </dd></dl> <dl> <h3>网页设计（2名）</h3>\r\n<dt>岗位职责： <dd>网站UI设计、 切片以及HTML制作。 </dd> <dt>职位要求： <dd>有大型网站设计经验；有网站改版、频道建设经验者优先考虑； <br />\r\n熟练掌握photoshop,fireworks,dreamwaver等设计软件； <br />\r\n熟练运用Div+Css制作网页，符合CSS2.0-W3C标准，并掌握不同浏览器下，不同版本下CSS元素的区别；<br />\r\n熟悉网站制作流程，能运用并修改简单JavaScript类程序； <br />\r\n积极向上，有良好的人际沟通能力，良好的工作协调能力，踏实肯干的工作精神；具有良好的沟通表达能力，<br />\r\n需求判断力，团队协作能力； <br />\r\n请应聘者在简历中提供个人近期作品连接。 </dd> <dt>学历要求： <dd>专科 </dd> <dt>工作经验： <dd>一年以上 </dd> <dt>工作地点： <dd>天津 </dd></dl> <dl> <h3>方案策划（1名）</h3>\r\n<dt>职位要求： <dd>2年以上的文案编辑类相关工作经验，具备一定的文字功底，有极强的语言表达和逻辑思维能力， 能独立完成项目方案的编写，拟草各种协议。熟悉使用办公软件。 </dd> <dt>学历要求： <dd>大专以上 </dd> <dt>工作经验： <dd>一年以上 </dd> <dt>工作地点： <dd>天津 </dd></dl>', 1294714240);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(25, 7, '', 1, 255, '合作及洽谈', '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ShopNC希望与服务代理商、合作伙伴并肩合作，携手开拓日益广阔的网络购物软件市场。如果您拥有好的建议，拥有丰富渠道资源、拥有众多目标客户、拥有相应的市场资源，并希望与ShopNC进行深度业务合作， 欢迎成为ShopNC业务合作伙伴，请联系。</p>\r\n<p>&nbsp;</p>\r\n<p><strong>公司名称</strong>： 天津市网城创想科技有限责任公司 <br />\r\n<strong>通信地址</strong>： 天津市南开区红旗路220号慧谷大厦712 <br />\r\n<strong>邮政编码</strong>： 300072 <br />\r\n<strong>电话</strong>： 400-611-5098 <br />\r\n<strong>商务洽谈</strong>： 86-022-87631069 <br />\r\n<strong>传真</strong>： 86-022-87631069 <br />\r\n</p>', 1294714257);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(26, 5, '', 1, 255, '联系卖家', '联系卖家', 1294714858);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(28, 4, '', 1, 255, '分期付款', '分期付款<br />', 1309835564);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(29, 4, '', 1, 255, '邮局汇款', '邮局汇款<br />', 1309835582);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(30, 4, '', 1, 255, '公司转账', '公司转账<br />', 1309835600);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(31, 5, '', 1, 255, '退换货政策', '退换货政策', 1309835651);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(32, 5, '', 1, 255, '退换货流程', '退换货流程', 1309835666);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(33, 5, '', 1, 255, '返修/退换货', '返修/退换货', 1309835679);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(34, 5, '', 1, 255, '退款申请', '退款申请', 1309835699);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(35, 1, 'http://www.shopnc.net/', 1, 255, '2.4版火爆销售中', '2.4版火爆销售中<br />', 1362023129);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(38, 1, '', 1, 252, '如何利用直通车让站长盈利', '<h3 style="font-size:16px;text-align:center;">ShopNC商城系统1.2版本之"直通车"功能说明</h3>\r\n<p style="text-indent:2em;">直通车是我们经过对客户习惯的深入研究而制作的一种让站长轻松盈利的模式。商家（即平台卖家用户）使用直通车进行商品营销。商家通过支付金币使商品加入直通车后能够优先显示在商品列表中商品剩余金币越多排名越靠前，并在商品名称下方显示直通车标志。商品优先显示提高了用户点击和购买机会。站长通过直通车方便了平台的推广并且实现实实在在的盈利。站长更好的为商家服务，及商家之所需，使双方都得到相应的回报。并且直通车平台实现按时间自动扣除直通车金币功能，免除了站长繁杂的操作流程。</p>\r\n<p></p>\r\n<p style="color:red;">注：详细使用方法请参阅安装包内document文件夹中的相关帮助文档</p>', 1310203091);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(36, 1, '', 1, 253, '新版“广告管理”功能说明', '<h3 style="font-size:16px;text-align:center;">ShopNC商城系统1.2版本之"广告管理"功能说明</h3>\r\n<p style="text-indent:2em;">网站广告是一个站点的主要收入来源，也是站长运营网站的主要目的之一。一个功能强大，灵活自由，方便管理的广告系统是每一个站长迫切需要的。</p>\r\n<p style="text-indent:2em;">ShopNC商城系统1.2版本较之前版本在广告管理这个模块上有了重大的改进，彻底颠覆了之前非常不灵活的广告系统，使站长可以自由地增减广告位，对其定价并放到网站的任何一个地方，系统提供了"幻灯片"、"图片"、"文字"、"Flash"等多种广告形式供站长选择。同时全新的广告系统也具有商户直接在线购买广告的功能（和1.2版本新增"金币"系统配合使用），使网站广告的购买变的非常简单、直接、便利，能极大程度地提高站长的收入。在线生成的广告统计图功能也是ShopNC商城系统1.2版本的一大特色，通过在线即时生成Flash形式的统计图表，广告主及站长可以直观地掌握广告点击率情况（系统提供了"折线图"、"饼形图"、"柱形图"等展示形式），同时站长在后台可以通过广告位点击率排序功能，迅速得知哪些广告位最容易被用户点击，进而调整站点的广告位价格，进一步增加站长的收入。</p>\r\n<p></p>\r\n<p style="color:red;">注：详细使用方法请参阅安装包内document文件夹中的相关帮助文档</p>', 1310198494);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(37, 1, '', 1, 251, '如何扩充水印字体库', '<h3 style="font-size:16px;text-align:center;">扩充水印功能字体库支持详解</h3>\r\n<p style="text-indent:2em;"><b>使用方法：</b>将您下载的字体库上传到网站目录"网站根目录\\resource\\font\\"这个文件夹内，同时需要修改此文件夹下的font.info.php文件。例如：您下载了一个"宋体"字库simsun.ttf，将其放置于前面所述文件夹内，使用代码编辑工具（如EditPlus）打开font.info.php文件在其中的$fontInfo = array(''arial''=&gt;''Arial'')数组后面添加宋体字库信息，"=&gt;"符号左边是文件名，右边是您想在网站上显示的文字信息。</p>\r\n<p style="text-indent:2em;">添加后的样子如：array(''arial''=&gt;''Arial'',''simsun''=&gt;''宋体'')，所示。</p>\r\n<p></p>\r\n<p style="text-indent:2em;">您可以在ShopNC官方网站下载字体库文件，下载地址：<a href="http://www.shopnc.net/downloads/product/multishop/fonts.zip">字体库文件[fonts.zip]</a>。</p>\r\n<p></p>\r\n<p style="color:red;">注：详细使用方法也可参阅安装包内upload文件夹中的readme文档</p>', 1310200272);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(40, 1, '', 1, 254, 'ShopNC官方使用提示信息', '<p style="text-indent:2em;"><b>官方提示：</b>ShopNC商城系统可供站长们免费下载使用，具体安装使用协议详见安装过程中的授权协议文档。如需获得更多帮助或更多使用权限，请联系官方购买授权。</p>\r\n<p style="text-indent:2em;">ShopNC开发团队力争做最适合站长运营的社区化电子商城系统，欢迎各位站长与官方联系提出您的宝贵需求建议。您的需要就是我们的动力，您的回报正是我们所做的考虑。</p>\r\n<ul style="line-height:150%;">\r\n<li>官方网址：<a href="http://www.shopnc.net">http://www.shopnc.net</a></li>\r\n<li>官方论坛：<a href="http://bbs.shopnc.net">http://bbs.shopnc.net</a></li>\r\n<li>在线咨询QQ：1045269763 、921362895</li>\r\n<li>免费咨询电话：<b>400-611-5098</b></li>\r\n</ul>', 1310268647);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(39, 1, '', 1, 254, 'UCenter整合说明', '<h3 style="font-size:16px;text-align:center;">ShopNC商城系统1.2版本之"Ucenter整合"功能说明</h3>\r\n<p style="text-indent:2em;">平台之间的会员互通是站长们的一大需求，会员的互通方便站长多种不同模式的平台共同进行运营，利用各种平台之间的微妙联系增强整体平台的用户粘度和商业价值。</p>\r\n<p style="text-indent:2em;">ShopNC商城系统1.2版很好的与UCenter进行了整合，实现会员的互通，方便站长进行多种模式的系统进行协调运营。在进行UCenter整合的时候需要注意以下几点：</p>\r\n<ul>\r\n<li>如果Ucenter使用的是utf8，则商城的也要用utf8的，如果用gbk版的就会出问题。</li>\r\n<li>建议在使用前就整合，因为整合成功后，原系统中的会员将不能再登录，都以Ucenter的为主。</li>\r\n<li>在商城填完信息后就能在Ucenter中看到"通信成功"提示，说明整合完成。</li>\r\n<li>如果出现了不能同步登录问题，可以在论坛的后台更新缓存。</li>\r\n</ul>\r\n<p></p>\r\n<p style="color:red;">注：详细使用方法请参阅安装包内document文件夹中的相关帮助文档</p>', 1310262555);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(41, 2, '', 1, 255, '积分细则', '积分细则积分细则', 1322621203);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(42, 2, '', 1, 255, '积分兑换说明', '积分兑换说明积分兑换说明<br />', 1322621243);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(43, 1, '', 1, 254, '新功能使用说明', '<p>&nbsp;&nbsp;&nbsp; 新浪账号登录需要申请开通后才能在后台设置开启。</p>\r\n<p>&nbsp;&nbsp;&nbsp; 积分兑换、预存款、代金劵的使用在网站设置中可以选择是否开通相应功能。</p>\r\n<p>&nbsp;&nbsp;&nbsp; 其它的详细说明请参考安装包内document文件夹中的相关帮助文档。</p>', 1322789334);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(44, 1, '', 1, 255, '促销功能限时折扣使用说明', '<p>\r\n	一、<span style="font-size:10.5000pt;font-family:''宋体'';">卖家进入用户中心 <span>-&gt; </span><span>卖家 </span><span>-&gt; </span><span>促销管理 </span><span>-&gt; </span><span>商品促销 </span><span>-&gt; </span><span>限时折扣，如果当前没有可用套餐，系统会提示卖家首先购买套餐。</span></span><span style="font-size:10.5pt;font-family:''宋体'';"></span> \r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504022113_65206.png" alt="" /> \r\n</p>\r\n<p>\r\n	二、<span style="font-size:10.5000pt;font-family:''宋体'';">卖家点击购买套餐按钮，进入套餐购买界面，填写要购买的数量，点击提交按钮完成套餐购买申请。</span><span style="font-size:10.5000pt;font-family:''宋体'';"></span> \r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504022155_70768.png" alt="" /> \r\n</p>\r\n<p>\r\n	三、<span style="font-size:10.5000pt;font-family:''宋体'';">套餐申请后，在平台没有审核通过前，系统会提示卖家已经购买套餐但是没有通过审核。</span><span style="font-size:10.5000pt;font-family:''宋体'';"></span> \r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504022223_45601.png" alt="" /> \r\n</p>\r\n<p>\r\n	四、<span style="font-size:10.5000pt;font-family:''宋体'';">套餐申请通过后，卖家可以发布限时折扣活动。点击添加活动按钮进入活动添加页面。点击套餐列表链接可以查看套餐记录。</span><span style="font-size:10.5000pt;font-family:''宋体'';"></span><br />\r\n<span style="font-size:10.5000pt;font-family:''宋体'';"></span> \r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504022253_29124.png" alt="" /> \r\n</p>\r\n<p>\r\n	五、<span style="font-size:10.5000pt;font-family:''宋体'';">卖家填写活动名称、开始时间、结束时间和默认折扣，点击提交按钮进入商品选择页面。</span><span style="font-size:10.5000pt;font-family:''宋体'';"></span> \r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504022317_65502.png" alt="" /> \r\n</p>\r\n<p>\r\n	六、<span style="font-size:10.5000pt;font-family:''宋体'';">点击添加商品按钮选择，想要参加活动的商品。</span><span style="font-size:10.5000pt;font-family:''宋体'';"></span> \r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504022344_86225.png" alt="" /> \r\n</p>\r\n<p>\r\n	七、<span style="font-size:10.5000pt;font-family:''宋体'';">点击商品后边的添加按钮，把所选商品添加到当前活动中。商品选择完毕后点击下方的返回活动管理按钮，回到活动管理页面。</span><span style="font-size:10.5000pt;font-family:''宋体'';"></span> \r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504022411_71122.png" alt="" /> \r\n</p>\r\n<p>\r\n	八、<span style="font-size:10.5pt;font-family:''宋体'';">在活动管理页面可以单独设置每个商品的折扣率，在确认无误后点击发布活动按钮完成限时折扣活动的发布。</span> \r\n</p>\r\n<p>\r\n	<span style="font-size:10.5pt;font-family:''宋体'';"><img src="./upload/editor/20120504022440_49064.png" alt="" /></span> \r\n</p>\r\n<p>\r\n	<span style="font-size:10.5000pt;font-family:''宋体'';">九、限时折扣商品会优先显示在商品列表中，在商品列表页还可以对限时折扣商品进行筛选。进入商品详细页面后会出现限时折扣标识，点击立刻购买按钮即可以限时折扣价购买商品。</span><span style="font-size:10.5000pt;font-family:''宋体'';"></span><span style="font-size:10.5pt;font-family:''宋体'';"></span> \r\n</p>\r\n<p>\r\n	<span style="font-size:10.5pt;font-family:''宋体'';"><img src="./upload/editor/20120504022517_84608.png" alt="" /></span> \r\n</p>\r\n<p>\r\n	<span style="font-size:10.5000pt;font-family:''宋体'';"><img src="./upload/editor/20120504022542_81820.png" alt="" /></span> \r\n</p>\r\n<br />', 1336098353);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(45, 1, '', 1, 255, '促销功能满即送使用说明', '<p>\r\n	一、<span style="font-size:10.5000pt;font-family:''宋体'';">卖家进入用户中心&nbsp;<span>-&gt;&nbsp;</span><span>卖家&nbsp;</span><span>-&gt;&nbsp;</span><span>促销管理&nbsp;</span><span>-&gt;&nbsp;</span><span>商品促销&nbsp;</span><span>-&gt;&nbsp;</span><span>满即送，如果当前没有可用套餐，系统会提示卖家首先购买套餐。</span></span><span style="font-size:10.5pt;font-family:''宋体'';"></span>\r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504025039_83457.png" alt="" />\r\n</p>\r\n<p>\r\n	二、<span style="font-size:10.5000pt;font-family:''宋体'';">卖家点击购买套餐按钮，进入套餐购买界面，填写要购买的数量，点击提交按钮完成套餐购买申请。</span><span style="font-size:10.5000pt;font-family:''宋体'';"></span>\r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504025105_16849.png" alt="" />\r\n</p>\r\n<p>\r\n	三、<span style="font-size:10.5000pt;font-family:''宋体'';">套餐申请后，在平台没有审核通过前，系统会提示卖家已经购买套餐但是没有通过审核。</span><span style="font-size:10.5000pt;font-family:''宋体'';"></span>\r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504025127_50866.png" alt="" />\r\n</p>\r\n<p>\r\n	四、<span style="font-size:10.5000pt;font-family:''宋体'';">套餐申请通过后，卖家可以发布满即送活动。点击添加活动按钮进入活动添加页面。点击套餐列表链接可以查看套餐记录。</span>\r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504025157_78499.png" alt="" />\r\n</p>\r\n<p>\r\n	五、<span style="font-size:10.5000pt;font-family:''宋体'';">首先填写活动名称、开始时间和结束时间</span><span style="font-size:10.5000pt;font-family:''宋体'';"></span><br />\r\n<span style="font-size:10.5000pt;font-family:''宋体'';"></span>\r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504025227_23504.png" alt="" />\r\n</p>\r\n<p>\r\n	六、<span style="font-size:10.5000pt;font-family:''宋体'';">满即送活动最多可以设置三个级别，每个级别可以分别选择参加减现金、包邮和赠送礼品等形式。点击新增级别可以设置下一个级别。</span><span style="font-size:10.5000pt;font-family:''宋体'';"></span>\r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504025246_12664.png" alt="" />\r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504025255_72740.png" alt="" />\r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504025305_38366.png" alt="" />\r\n</p>\r\n<p>\r\n	七、<span style="font-size:10.5000pt;font-family:''宋体'';">满即送规则设置完成后，填写备注信息，点击提交按钮完成满即送活动的发布。</span><span style="font-size:10.5000pt;font-family:''宋体'';"></span>\r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504025316_42126.png" alt="" />\r\n</p>\r\n<p>\r\n	八、<span style="font-size:10.5000pt;font-family:''宋体'';">进入商品详细页面后参加满即送活动的店铺会出现满即送标识。购物车结算时如果符合满即送规则将按照满即送活动进行返利。</span><span style="font-size:10.5000pt;font-family:''宋体'';"></span>\r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504025440_23068.png" alt="" />\r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504025453_64906.png" alt="" />\r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504025501_90167.png" alt="" />\r\n</p>\r\n<br />', 1336100107);

INSERT INTO `#__coupon_class` (`class_id`, `class_parent_id`, `class_name`, `class_sort`, `class_show`) VALUES(1, 0, '测试分类', 99, '1');

INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(1, '网城创想', 'http://www.shopnc.net', 'ac1d6b368d9a8b048b974186c8d467a9.gif', 0);
INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(29, '腾讯网', 'http://www.qq.com', '75eb906e1b7a2f568f38517c3b338b76.png', 8);
INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(28, '天空下载', 'http://www.skycn.com', '7e6c4529c180781a4918728c59106a0d.jpg', 6);
INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(27, '站长之家', 'http://www.chinaz.com', 'd3f4b551af9621eca9dce6b742c66540.gif', 7);
INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(26, '华军下载', 'http://www.onlinedown.net', '675e3c273601596996c7d9f56340c7ff.gif', 5);
INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(22, 'PHPChina', 'http://www.phpchina.com', '71f3651a995ef7a8d8bcc00dfe1fa018.gif', 3);
INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(23, '康盛创想', 'http://www.comsenz.com', '2656c79dff5e988bc20d707d1a73a583.jpg', 2);
INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(24, 'A5下载', 'http://down.admin5.com', '1ce6ffadfcf5e45d7fbd86d46d0e90db.gif', 4);
INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(25, 'DZ动力', 'http://www.verydz.com', '29269def49a5d57a24490b69b3312260.gif', 1);
INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(38, '支付宝平台', 'https://www.alipay.com/', '', 5);
INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(37, '新浪微博开放平台', 'http://open.weibo.com/', '', 3);
INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(36, 'Discuz!云平台', 'http://discuz.qq.com/', '', 4);
INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(35, '搜搜开放平台', 'http://open.soso.com/', '', 6);
INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(34, 'QQ彩贝开放联盟', 'http://open.cb.qq.com/', '', 8);
INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(33, '财付通开放平台', 'http://open.tenpay.com/', '', 7);
INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(32, '腾讯微博开放平台', 'http://open.t.qq.com/', '', 2);
INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(31, '腾讯社区开放平台', 'http://opensns.qq.com/', '', 1);
INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(30, 'QQ互联登录', 'http://connect.opensns.qq.com/', '', 0);

INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[给买家]</strong>店铺调整了订单费用的邮件通知', '{$site_name}提醒:店铺{$store_name}调整了您的订单费用', 'email_tobuyer_adjust_fee_notify', '<p>\r\n	尊敬的{$buyer_name}:\r\n</p>\r\n<p style="" padding-left:="" 30px;="">与您交易的店铺{$store_name}调整了您订单号为{$order_sn}的订单的费用，请您及时付款。\r\n	</p>\r\n<p style="" padding-left:="" 30px;="">查看订单详细信息请点击以下链接\r\n</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=member&amp;op=show_order&amp;order_id={$order_id}" target="_blank">{$site_url}/index.php?act=member&amp;op=show_order&amp;order_id={$order_id}</a><br />\r\n \r\n	</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$site_name}\r\n</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$mail_send_time}\r\n	</p>', 0, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[给买家]</strong>订单被取消的邮件通知', '{$site_name}提醒:您的订单{$order_sn}已被取消', 'email_tobuyer_cancel_order_notify', '<p>\r\n	尊敬的{$buyer_name}:\r\n</p>\r\n<p style="" padding-left:="" 30px;="">与您交易的店铺{$store_name}已经取消了您的订单{$order_sn}。\r\n	</p>\r\n<p style="" padding-left:="" 30px;="">原因：{$reason}\r\n</p>\r\n<p style="" padding-left:="" 30px;="">查看订单详细信息请点击以下链接\r\n	</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=member&amp;op=show_order&amp;order_id={$order_id}" target="_blank">{$site_url}/index.php?act=member&amp;op=show_order&amp;order_id={$order_id}</a> \r\n</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$site_name}\r\n	</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$mail_send_time}\r\n</p>', 0, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[给买家]</strong>店铺确认收到即时到帐的货款并完成交易的邮件通知', '{$site_name}提醒:店铺{$store_name}确认收到了您的货款，交易完成！', 'email_tobuyer_cod_order_finish_notify', '<p>\r\n	尊敬的{$buyer_name}:\r\n</p>\r\n<p style="" padding-left:="" 30px;="">与您交易的店铺{$store_name}已经确认收到了您的货到付款订单{$order_sn}的付款，交易完成！您可以到用户中心-&gt;我的订单中对该交易进行评价。\r\n	</p>\r\n<p style="" padding-left:="" 30px;="">查看订单详细信息请点击以下链接\r\n</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=member&amp;op=show_order&amp;order_id={$order_id}" target="_blank">{$site_url}/index.php?act=member&amp;op=show_order&amp;order_id={$order_id}</a> \r\n	</p>\r\n<p style="" padding-left:="" 30px;="">查看我的订单列表请点击以下链接\r\n</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=member&amp;op=order" target="_blank">{$site_url}/index.php?act=member&amp;op=order</a> \r\n	</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$site_name}\r\n</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$mail_send_time}\r\n	</p>', 0, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[给买家]</strong>店铺已确认了订单的邮件通知', '{$site_name}提醒:店铺{$store_name}已确认了您的订单', 'email_tobuyer_confirm_cod_order_notify', '尊敬的{$buyer_name}:\r\n<p style="" padding-left:="" 30px;="">与您交易的店铺{$store_name}已经确认了您的货到付款订单{$order_sn}，请耐心等待发货。\r\n	</p>\r\n<p style="" padding-left:="" 30px;="">查看订单详细信息请点击以下链接\r\n</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=member&amp;op=show_order&amp;order_id={$order_id}" target="_blank">{$site_url}/index.php?act=member&amp;op=show_order&amp;order_id={$order_id}</a> \r\n	</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$site_name}\r\n</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$mail_send_time}\r\n	</p>', 0, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[给买家]</strong>订单已生成的邮件通知', '{$site_name}提醒:您的订单已生成', 'email_tobuyer_new_order_notify', '尊敬的{$buyer_name}:\r\n<p style="" padding-left:="" 30px;="">您在{$site_name}上下的订单已生成，订单号{$order_sn}。\r\n	</p>\r\n<p style="" padding-left:="" 30px;="">查看订单详细信息请点击以下链接\r\n</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=member&amp;op=show_order&amp;order_id={$order_id}" target="_blank">{$site_url}/index.php?act=member&amp;op=show_order&amp;order_id={$order_id}</a> \r\n	</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$site_name}\r\n</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$mail_send_time}\r\n	</p>', 0, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[给买家]</strong>店铺确认收到线下支付的货款的邮件通知', '{$site_name}提醒:店铺{$store_name}已确认收到了您线下支付的货款', 'email_tobuyer_offline_pay_success_notify', '尊敬的{$buyer_name}:\r\n<p style="" padding-left:="" 30px;="">与您交易的店铺{$store_name}已经确认了收到了您的订单{$order_sn}的付款，请耐心等待卖家发货。\r\n	</p>\r\n<p style="" padding-left:="" 30px;="">查看订单详细信息请点击以下链接\r\n</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=member&amp;op=show_order&amp;order_id={$order_id}" target="_blank">{$site_url}/index.php?act=member&amp;op=show_order&amp;order_id={$order_id}</a> \r\n	</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$site_name}\r\n</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$mail_send_time}\r\n	</p>', 0, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[给买家]</strong>订单已发货的邮件通知', '{$site_name}提醒:您的订单{$order_sn}已发货', 'email_tobuyer_shipped_notify', '尊敬的{$buyer_name}:\r\n<p style="" padding-left:="" 30px;="">与您交易的店铺{$store_name}已经给您的订单{$order_sn}发货了，请注意查收。\r\n	</p>\r\n<p style="" padding-left:="" 30px;="">发货单号：{$invoice_no}\r\n</p>\r\n<p style="" padding-left:="" 30px;="">查看订单详细信息请点击以下链接\r\n	</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=member&amp;op=show_order&amp;order_id={$order_id}" target="_blank">{$site_url}/index.php?act=member&amp;op=show_order&amp;order_id={$order_id}</a> \r\n</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$site_name}\r\n	</p>\r\n	<div style="text-align:right;">\r\n	</div>\r\n<p style="text-align: right;" text-align:="" right;="">{$mail_send_time}\r\n</p>', 0, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[给卖家]</strong>买家取消了订单的邮件通知', '{$site_name}提醒:买家{$buyer_name}取消了订单{$order_sn}', 'email_toseller_cancel_order_notify', '尊敬的{$seller_name}:\r\n<p style="" padding-left:="" 30px;="">买家{$buyer_name}已经取消了与您交易的订单{$order_sn}。</p>\r\n<p style="" padding-left:="" 30px;="">原因：{$reason}</p>\r\n<p style="" padding-left:="" 30px;="">查看订单详细信息请点击以下链接</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=store&amp;op=show_order&amp;order_id={$order_id}" target="_blank">{$site_url}/index.php?act=store&amp;op=show_order&amp;order_id={$order_id}</a></p>\r\n<p style="" padding-left:="" 30px;="">查看您的订单列表管理页请点击以下链接</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=store&amp;op=store_order" target="_blank">{$site_url}/index.php?act=store&amp;op=store_order</a></p>\r\n<p style="text-align: right;" text-align:="" right;="">{$site_name}</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$mail_send_time}</p>', 0, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[给卖家]</strong>买家确认了订单并完成交易的邮件通知', '{$site_name}提醒:买家确认了与您交易的订单{$order_sn}，交易完成', 'email_toseller_finish_notify', '尊敬的{$seller_name}:\r\n<p style="" padding-left:="" 30px;="">买家{$buyer_name}已经确认了与您交易的订单{$order_sn}。交易完成</p>\r\n<p style="" padding-left:="" 30px;="">查看订单详细信息请点击以下链接</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=store&amp;op=show_order&amp;order_id={$order_id}" target="_blank">{$site_url}/index.php?act=store&amp;op=show_order&amp;order_id={$order_id}</a></p>\r\n<p style="" padding-left:="" 30px;="">查看您的订单列表管理页请点击以下链接</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=store&amp;op=store_order" target="_blank">{$site_url}/index.php?act=store&amp;op=store_order</a></p>\r\n<p style="text-align: right;" text-align:="" right;="">{$site_name}</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$mail_send_time}</p>', 0, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[给卖家]</strong>有新订单需要处理的邮件通知', '{$site_name}提醒:您有一个新订单需要处理', 'email_toseller_new_order_notify', '尊敬的{$seller_name}:\r\n<p style="" padding-left:="" 30px;="">您有一个新的订单需要处理，订单号{$order_sn}，请尽快处理。</p>\r\n<p style="" padding-left:="" 30px;="">查看订单详细信息请点击以下链接</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=store&amp;op=show_order&amp;order_id={$order_id}" target="_blank">{$site_url}/index.php?act=store&amp;op=show_order&amp;order_id={$order_id}</a></p>\r\n<p style="" padding-left:="" 30px;="">查看您的订单列表管理页请点击以下链接</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=store&amp;op=store_order" target="_blank">{$site_url}/index.php?act=store&amp;op=store_order</a></p>\r\n<p style="text-align: right;" text-align:="" right;="">{$site_name}</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$mail_send_time}</p>', 0, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[给卖家]</strong>买家已经完成线下付款的邮件通知', '{$site_name}提醒:买家{$buyer_name}已通过线下支付支付了订单的费用', 'email_toseller_offline_pay_notify', '尊敬的{$seller_name}:\r\n<p style="" padding-left:="" 30px;="">买家{$buyer_name}已通过线下支付支付了与您交易的订单{$order_sn}。请注意查收。</p>\r\n<p style="" padding-left:="" 30px;="">支付信息：{$pay_message}</p>\r\n<p style="" padding-left:="" 30px;="">查看订单详细信息请点击以下链接</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=store&amp;op=show_order&amp;order_id={$order_id}" target="_blank">{$site_url}/index.php?act=store&amp;op=show_order&amp;order_id={$order_id}</a></p>\r\n<p style="" padding-left:="" 30px;="">查看您的订单列表管理页请点击以下链接</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=store&amp;op=store_order" target="_blank">{$site_url}/index.php?act=store&amp;op=store_order</a></p>\r\n<p style="text-align: right;" text-align:="" right;="">{$site_name}</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$mail_send_time}</p>', 0, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[给卖家]</strong>买家已付款的邮件通知', '{$site_name}提醒:买家{$buyer_name}已付款', 'email_toseller_online_pay_success_notify', '尊敬的{$seller_name}:\r\n<p style="" padding-left:="" 30px;="">买家{$buyer_name}已通过线上支付完成了订单{$.order_sn}的付款，请核实并尽快安排发货。</p>\r\n<p style="" padding-left:="" 30px;="">查看订单详细信息请点击以下链接</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=store&amp;op=show_order&amp;order_id={$order_id}" target="_blank">{$site_url}/index.php?act=store&amp;op=show_order&amp;order_id={$order_id}</a></p>\r\n<p style="" padding-left:="" 30px;="">查看您的订单列表管理页请点击以下链接</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=store&amp;op=store_order" target="_blank">{$site_url}/index.php?act=store&amp;op=store_order</a></p>\r\n<p style="text-align: right;" text-align:="" right;="">{$site_name}</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$mail_send_time}</p>', 0, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[给用户]</strong>用户修改了密码的邮件通知', '{$site_name}提醒:{$user_name}修改密码设置', 'email_touser_find_password', '<p>尊敬的{$user_name}:</p>\r\n<p>您好, 您刚才在{$site_name}申请了重置密码，您的新密码为<span style="color:#ff9900;">{$new_password}</span>。</p>\r\n<p>请点击<a href="{$site_url}" target="_blank">{$site_url}</a>登录，修改您的新密码。</p>\r\n<p style="text-align:right;">{$site_name}</p>\r\n<p style="text-align:right;">{$mail_send_time}</p>', 0, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[给卖家]</strong>店铺被管理员关闭时的通知', NULL, 'msg_toseller_store_closed_notify', '您的店铺已被关闭，原因是：{$reason}', 1, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[给卖家]</strong>店铺过期被自动关闭时的通知', NULL, 'msg_toseller_store_expired_closed_notify', '您的店铺已被关闭，原因是：店铺已到期', 1, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[给卖家]</strong>商品被管理员删除时的通知', NULL, 'msg_toseller_goods_droped_notify', '管理员删除了您的商品：{$goods_name}\\r\\n原因是：{$reason}', 1, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[给卖家]</strong>品牌申请通过审核时的通知', NULL, 'msg_toseller_brand_passed_notify', '恭喜！您申请的品牌 {$brand_name} 已通过审核。', 1, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[给卖家]</strong>品牌申请被拒绝时的通知', NULL, 'msg_toseller_brand_refused_notify', '抱歉，您申请的品牌 {$brand_name} 已被拒绝，原因如下：\\r\\n{$reason}', 1, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[给卖家]</strong>店铺被管理员删除时的通知', NULL, 'msg_toseller_store_droped_notify', '您的店铺已被删除', 1, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[给卖家]</strong>开店申请被通过时的通知', NULL, 'msg_toseller_store_passed_notify', '恭喜，您的店铺已开通，赶快来用户中心发布商品吧。', 1, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[给卖家]</strong>开店申请被拒绝时的通知', NULL, 'msg_toseller_store_refused_notify', '抱歉，您的开店申请已被拒绝，原因如下： {$reason}', 1, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[给卖家]</strong>购买搭配套餐后的金币消费通知', NULL, 'msg_toseller_bundling_gold_consume_notify', '您成功购买搭配套餐活动{$buy_month}个月，单价{$bundling_price}金币，总共花费{$pay_gold}金币，时间从{$mail_send_time}开始计算', 1, 1);

INSERT INTO `#__navigation` (`nav_id`, `nav_type`, `nav_title`, `nav_url`, `nav_location`, `nav_new_open`, `nav_sort`, `item_id`) VALUES(6, 0, '关于ShopNC', 'index.php?act=article&article_id=22', 2, 0, 255, 0);
INSERT INTO `#__navigation` (`nav_id`, `nav_type`, `nav_title`, `nav_url`, `nav_location`, `nav_new_open`, `nav_sort`, `item_id`) VALUES(7, 0, '联系我们', 'index.php?act=article&article_id=23', 2, 0, 240, 0);
INSERT INTO `#__navigation` (`nav_id`, `nav_type`, `nav_title`, `nav_url`, `nav_location`, `nav_new_open`, `nav_sort`, `item_id`) VALUES(8, 0, '广告合作', 'index.php?act=article&article_id=25', 2, 0, 220, 0);
INSERT INTO `#__navigation` (`nav_id`, `nav_type`, `nav_title`, `nav_url`, `nav_location`, `nav_new_open`, `nav_sort`, `item_id`) VALUES(9, 0, '招聘英才', 'index.php?act=article&article_id=24', 2, 0, 210, 0);

INSERT INTO `#__recommend` (`recommend_id`, `recommend_name`, `recommend_code`, `recommend_desc`, `recommend_config`) VALUES (1, '特别推荐', 'best_item', '这里面的商品将在首页的特别推荐区域显示', NULL);

INSERT INTO `#__goods_class` (`gc_id`, `gc_name`, `type_id`, `type_name`, `store_id`, `gc_parent_id`, `gc_sort`, `gc_show`) VALUES(1, '男女服装', 1, '服装', 0, 0, 1, 1);
INSERT INTO `#__goods_class` (`gc_id`, `gc_name`, `type_id`, `type_name`, `store_id`, `gc_parent_id`, `gc_sort`, `gc_show`) VALUES(2, '鞋包配饰', 0, '', 0, 0, 2, 1);
INSERT INTO `#__goods_class` (`gc_id`, `gc_name`, `type_id`, `type_name`, `store_id`, `gc_parent_id`, `gc_sort`, `gc_show`) VALUES(3, '美容美妆', 0, '', 0, 0, 3, 1);
INSERT INTO `#__goods_class` (`gc_id`, `gc_name`, `type_id`, `type_name`, `store_id`, `gc_parent_id`, `gc_sort`, `gc_show`) VALUES(4, '数码家电', 0, '', 0, 0, 5, 1);
INSERT INTO `#__goods_class` (`gc_id`, `gc_name`, `type_id`, `type_name`, `store_id`, `gc_parent_id`, `gc_sort`, `gc_show`) VALUES(5, '家居家装', 0, '', 0, 0, 6, 1);
INSERT INTO `#__goods_class` (`gc_id`, `gc_name`, `type_id`, `type_name`, `store_id`, `gc_parent_id`, `gc_sort`, `gc_show`) VALUES(6, '食品保健', 0, '', 0, 0, 7, 1);
INSERT INTO `#__goods_class` (`gc_id`, `gc_name`, `type_id`, `type_name`, `store_id`, `gc_parent_id`, `gc_sort`, `gc_show`) VALUES(7, '母婴用品', 0, '', 0, 0, 8, 1);
INSERT INTO `#__goods_class` (`gc_id`, `gc_name`, `type_id`, `type_name`, `store_id`, `gc_parent_id`, `gc_sort`, `gc_show`) VALUES(8, '运动户外', 0, '', 0, 0, 4, 1);
INSERT INTO `#__goods_class` (`gc_id`, `gc_name`, `type_id`, `type_name`, `store_id`, `gc_parent_id`, `gc_sort`, `gc_show`) VALUES(9, '文化娱乐', 0, '', 0, 0, 9, 1);
INSERT INTO `#__goods_class` (`gc_id`, `gc_name`, `type_id`, `type_name`, `store_id`, `gc_parent_id`, `gc_sort`, `gc_show`) VALUES(10, '话费网游', 0, '', 0, 0, 10, 1);
INSERT INTO `#__goods_class` (`gc_id`, `gc_name`, `type_id`, `type_name`, `store_id`, `gc_parent_id`, `gc_sort`, `gc_show`) VALUES(11, '票务旅游', 0, '', 0, 0, 11, 1);
INSERT INTO `#__goods_class` (`gc_id`, `gc_name`, `type_id`, `type_name`, `store_id`, `gc_parent_id`, `gc_sort`, `gc_show`) VALUES(12, '女装', 1, '服装', 0, 1, 255, 1);
INSERT INTO `#__goods_class` (`gc_id`, `gc_name`, `type_id`, `type_name`, `store_id`, `gc_parent_id`, `gc_sort`, `gc_show`) VALUES(13, '男装', 1, '服装', 0, 1, 255, 1);
INSERT INTO `#__goods_class` (`gc_id`, `gc_name`, `type_id`, `type_name`, `store_id`, `gc_parent_id`, `gc_sort`, `gc_show`) VALUES(14, '内衣/睡衣', 1, '服装', 0, 1, 255, 1);
INSERT INTO `#__goods_class` (`gc_id`, `gc_name`, `type_id`, `type_name`, `store_id`, `gc_parent_id`, `gc_sort`, `gc_show`) VALUES(15, '羽绒服', 1, '服装', 0, 13, 255, 1);
INSERT INTO `#__goods_class` (`gc_id`, `gc_name`, `type_id`, `type_name`, `store_id`, `gc_parent_id`, `gc_sort`, `gc_show`) VALUES(16, '棉衣', 1, '服装', 0, 12, 255, 1);

INSERT INTO `#__type` (`type_id`, `type_name`, `type_sort`) VALUES(1, '服装', 1);
INSERT INTO `#__type` (`type_id`, `type_name`, `type_sort`) VALUES(2, '鞋码', 2);
INSERT INTO `#__type` (`type_id`, `type_name`, `type_sort`) VALUES(3, '箱包', 3);
INSERT INTO `#__type` (`type_id`, `type_name`, `type_sort`) VALUES(4, '茶具', 4);
INSERT INTO `#__type` (`type_id`, `type_name`, `type_sort`) VALUES(5, '照相机', 1);

INSERT INTO `#__spec` (`sp_id`, `sp_name`, `sp_format`, `sp_value`, `sp_sort`) VALUES(1, '颜色', 'image', '白色,黑色,紫色,红色,绿色,花色,蓝色,褐色,黄色,粉色,桔色,透明', 1);
INSERT INTO `#__spec` (`sp_id`, `sp_name`, `sp_format`, `sp_value`, `sp_sort`) VALUES(2, '尺码', 'text', 'XXS,XS,S,M,L,XL,XXL,XXXL,加大XXXL,均码', 2);
INSERT INTO `#__spec` (`sp_id`, `sp_name`, `sp_format`, `sp_value`, `sp_sort`) VALUES(3, '鞋码', 'text', '35,45,44,43,42,41,40,39,38,37,36,46', 3);

INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(1, '白色', 1, 'c53bca14dc85bb3af17d8fe91b34e4b2.png_small.png', 0);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(2, '黑色', 1, 'ec769a6ddb0704a805bfe5f4b917dbfc.png_small.png', 1);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(3, '紫色', 1, '7e79c94b506b4f26064c5ad9cf415d6a.png_small.png', 2);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(4, '红色', 1, '36dffaac297ed95204d5a5e7ffc9cfc0.png_small.png', 3);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(5, '绿色', 1, 'cd0a502349ba45ff6e57a9c56faead64.png_small.png', 4);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(6, '花色', 1, '51e66b9e43213cc8eddf6038477dc0ea.png_small.png', 5);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(7, '蓝色', 1, '17cac2d3e7c5f7a3d258912287c86cf5.png_small.png', 6);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(8, '褐色', 1, 'dd12d18ad6d68331149083265ee225f9.png_small.png', 7);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(9, '黄色', 1, '9984776d635bd493b9b83a59712283e2.png_small.png', 8);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(10, '粉色', 1, '27f09f244c0aea8157d81e9f59e3a2ed.png_small.png', 9);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(11, '桔色', 1, 'b700b535d2995468263e92541e2f74c9.png_small.png', 10);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(12, '透明', 1, '81416e9137b049dc494fbc21e18aac58.png_small.png', 11);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(13, 'XXS', 2, '', 1);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(14, 'XS', 2, '', 2);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(15, 'S', 2, '', 3);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(16, 'M', 2, '', 4);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(17, 'L', 2, '', 5);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(18, 'XL', 2, '', 6);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(19, 'XXL', 2, '', 7);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(20, 'XXXL', 2, '', 8);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(21, '加大XXXL', 2, '', 9);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(22, '均码', 2, '', 10);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(23, '35', 3, '', 1);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(24, '36', 3, '', 2);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(25, '37', 3, '', 3);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(26, '38', 3, '', 4);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(27, '39', 3, '', 5);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(28, '40', 3, '', 6);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(29, '41', 3, '', 7);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(30, '42', 3, '', 8);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(31, '43', 3, '', 9);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(32, '44', 3, '', 10);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(33, '45', 3, '', 11);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(34, '46', 3, '', 12);

INSERT INTO `#__type_spec` (`type_id`, `sp_id`) VALUES(1, 1);
INSERT INTO `#__type_spec` (`type_id`, `sp_id`) VALUES(1, 2);
INSERT INTO `#__type_spec` (`type_id`, `sp_id`) VALUES(2, 3);
INSERT INTO `#__type_spec` (`type_id`, `sp_id`) VALUES(2, 1);
INSERT INTO `#__type_spec` (`type_id`, `sp_id`) VALUES(3, 1);

INSERT INTO `#__store_class` (`sc_id`, `sc_name`, `sc_parent_id`, `sc_sort`) VALUES(4, '服装鞋包', 0, 1);
INSERT INTO `#__store_class` (`sc_id`, `sc_name`, `sc_parent_id`, `sc_sort`) VALUES(13, '女装', 4, 2);
INSERT INTO `#__store_class` (`sc_id`, `sc_name`, `sc_parent_id`, `sc_sort`) VALUES(14, '男装', 4, 2);
INSERT INTO `#__store_class` (`sc_id`, `sc_name`, `sc_parent_id`, `sc_sort`) VALUES(15, '女鞋', 4, 3);
INSERT INTO `#__store_class` (`sc_id`, `sc_name`, `sc_parent_id`, `sc_sort`) VALUES(16, '运动鞋', 4, 4);
INSERT INTO `#__store_class` (`sc_id`, `sc_name`, `sc_parent_id`, `sc_sort`) VALUES(17, '男鞋/皮鞋/休闲鞋', 4, 5);
INSERT INTO `#__store_class` (`sc_id`, `sc_name`, `sc_parent_id`, `sc_sort`) VALUES(18, '运动服/运动包/颈环配件', 4, 6);

INSERT INTO `#__inform_subject_type` (`inform_type_id`, `inform_type_name`, `inform_type_desc`, `inform_type_state`) VALUES (1, '出售禁售品', '销售商城禁止和限制交易规则下所规定的所有商品。', 1);

INSERT INTO `#__inform_subject` (`inform_subject_id`, `inform_subject_content`, `inform_subject_type_id`, `inform_subject_type_name`, `inform_subject_state`) VALUES (1, '管制刀具、弓弩类、其他武器等', 1, '出售禁售品', 1);
INSERT INTO `#__inform_subject` (`inform_subject_id`, `inform_subject_content`, `inform_subject_type_id`, `inform_subject_type_name`, `inform_subject_state`) VALUES (2, '赌博用具类', 1, '出售禁售品', 1);
INSERT INTO `#__inform_subject` (`inform_subject_id`, `inform_subject_content`, `inform_subject_type_id`, `inform_subject_type_name`, `inform_subject_state`) VALUES (3, '枪支弹药', 1, '出售禁售品', 1);
INSERT INTO `#__inform_subject` (`inform_subject_id`, `inform_subject_content`, `inform_subject_type_id`, `inform_subject_type_name`, `inform_subject_state`) VALUES (4, '毒品及吸毒工具', 1, '出售禁售品', 1);

INSERT INTO `#__complain_subject` (`complain_subject_id`, `complain_subject_content`, `complain_subject_desc`, `complain_subject_type`, `complain_subject_state`) VALUES (1, '卖家不同意退款', '买家申请退款被拒绝。', 1, 2);
INSERT INTO `#__complain_subject` (`complain_subject_id`, `complain_subject_content`, `complain_subject_desc`, `complain_subject_type`, `complain_subject_state`) VALUES (7, '未收到货', '交易成功，未收到货，钱已经付给卖家，可进行维权。', 1, 1);
INSERT INTO `#__complain_subject` (`complain_subject_id`, `complain_subject_content`, `complain_subject_desc`, `complain_subject_type`, `complain_subject_state`) VALUES (8, '售后保障服务', '交易完成后30天内，在使用商品过程中，发现商品有质量问题或无法正常使用，可进行维权。', 1, 1);
INSERT INTO `#__complain_subject` (`complain_subject_id`, `complain_subject_content`, `complain_subject_desc`, `complain_subject_type`, `complain_subject_state`) VALUES (9, '未收到货款', '货物已经发出，未收到货款，商品已经寄给买家，可进行维权。', 2, 1);

INSERT INTO `#__voucher_price` (`voucher_price_id`, `voucher_price_describe`, `voucher_price`) VALUES (1, '10元面额', 10);
INSERT INTO `#__voucher_price` (`voucher_price_id`, `voucher_price_describe`, `voucher_price`) VALUES (2, '50元面额', 50);

INSERT INTO `#__store_grade` (`sg_id`, `sg_name`, `sg_goods_limit`, `sg_album_limit`, `sg_space_limit`, `sg_template_number`, `sg_template`, `sg_price`, `sg_confirm`, `sg_description`, `sg_function`, `sg_sort`) VALUES(1, '系统默认', 100, 500, 100, 6, 'default|style1|style2|style3|style4|style5', '100元/年', 0, '用户选择“默认等级”，可以立即开通。', '', 0);
INSERT INTO `#__store_grade` (`sg_id`, `sg_name`, `sg_goods_limit`, `sg_album_limit`, `sg_space_limit`, `sg_template_number`, `sg_template`, `sg_price`, `sg_confirm`, `sg_description`, `sg_function`, `sg_sort`) VALUES(2, '白金店铺', 200, 1000, 100, 6, 'default|style1|style2|style3|style4|style5', '200元/年', 1, '享受更多特权', 'editor_multimedia', 2);

INSERT INTO `#__document` (`doc_id`, `doc_code`, `doc_title`, `doc_content`, `doc_time`) VALUES(1, 'agreement', '用户服务协议', '<p>特别提醒用户认真阅读本《用户服务协议》(下称《协议》) 中各条款。除非您接受本《协议》条款，否则您无权使用本网站提供的相关服务。您的使用行为将视为对本《协议》的接受，并同意接受本《协议》各项条款的约束。 <br /> <br /> <strong>一、定义</strong><br /></p>\r\n<ol>\r\n<li>"用户"指符合本协议所规定的条件，同意遵守本网站各种规则、条款（包括但不限于本协议），并使用本网站的个人或机构。</li>\r\n<li>"卖家"是指在本网站上出售物品的用户。"买家"是指在本网站购买物品的用户。</li>\r\n<li>"成交"指买家根据卖家所刊登的交易要求，在特定时间内提出最优的交易条件，因而取得依其提出的条件购买该交易物品的权利。</li>\r\n</ol>\r\n<p><br /> <br /> <strong>二、用户资格</strong><br /> <br /> 只有符合下列条件之一的人员或实体才能申请成为本网站用户，可以使用本网站的服务。</p>\r\n<ol>\r\n<li>年满十八岁，并具有民事权利能力和民事行为能力的自然人；</li>\r\n<li>未满十八岁，但监护人（包括但不仅限于父母）予以书面同意的自然人；</li>\r\n<li>根据中国法律或设立地法律、法规和/或规章成立并合法存在的公司、企事业单位、社团组织和其他组织。</li>\r\n</ol>\r\n<p><br /> 无民事行为能力人、限制民事行为能力人以及无经营或特定经营资格的组织不当注册为本网站用户或超过其民事权利或行为能力范围从事交易的，其与本网站之间的协议自始无效，本网站一经发现，有权立即注销该用户，并追究其使用本网站"服务"的一切法律责任。<br /> <br /> <strong>三.用户的权利和义务</strong><br /></p>\r\n<ol>\r\n<li>用户有权根据本协议的规定及本网站发布的相关规则，利用本网站网上交易平台登录物品、发布交易信息、查询物品信息、购买物品、与其他用户订立物品买卖合同、在本网站社区发帖、参加本网站的有关活动及有权享受本网站提供的其他的有关资讯及信息服务。</li>\r\n<li>用户有权根据需要更改密码和交易密码。用户应对以该用户名进行的所有活动和事件负全部责任。</li>\r\n<li>用户有义务确保向本网站提供的任何资料、注册信息真实准确，包括但不限于真实姓名、身份证号、联系电话、地址、邮政编码等。保证本网站及其他用户可以通过上述联系方式与自己进行联系。同时，用户也有义务在相关资料实际变更时及时更新有关注册资料。</li>\r\n<li>用户不得以任何形式擅自转让或授权他人使用自己在本网站的用户帐号。</li>\r\n<li>用户有义务确保在本网站网上交易平台上登录物品、发布的交易信息真实、准确，无误导性。</li>\r\n<li>用户不得在本网站网上交易平台买卖国家禁止销售的或限制销售的物品、不得买卖侵犯他人知识产权或其他合法权益的物品，也不得买卖违背社会公共利益或公共道德的物品。</li>\r\n<li>用户不得在本网站发布各类违法或违规信息。包括但不限于物品信息、交易信息、社区帖子、物品留言，店铺留言，评价内容等。</li>\r\n<li>用户在本网站交易中应当遵守诚实信用原则，不得以干预或操纵物品价格等不正当竞争方式扰乱网上交易秩序，不得从事与网上交易无关的不当行为，不得在交易平台上发布任何违法信息。</li>\r\n<li>用户不应采取不正当手段（包括但不限于虚假交易、互换好评等方式）提高自身或他人信用度，或采用不正当手段恶意评价其他用户，降低其他用户信用度。</li>\r\n<li>用户承诺自己在使用本网站网上交易平台实施的所有行为遵守国家法律、法规和本网站的相关规定以及各种社会公共利益或公共道德。对于任何法律后果的发生，用户将以自己的名义独立承担所有相应的法律责任。</li>\r\n<li>用户在本网站网上交易过程中如与其他用户因交易产生纠纷，可以请求本网站从中予以协调。用户如发现其他用户有违法或违反本协议的行为，可以向本网站举报。如用户因网上交易与其他用户产生诉讼的，用户有权通过司法部门要求本网站提供相关资料。</li>\r\n<li>用户应自行承担因交易产生的相关费用，并依法纳税。</li>\r\n<li>未经本网站书面允许，用户不得将本网站资料以及在交易平台上所展示的任何信息以复制、修改、翻译等形式制作衍生作品、分发或公开展示。</li>\r\n<li>用户同意接收来自本网站的信息，包括但不限于活动信息、交易信息、促销信息等。</li>\r\n</ol>\r\n<p><br /> <br /> <strong>四、 本网站的权利和义务</strong><br /></p>\r\n<ol>\r\n<li>本网站不是传统意义上的"拍卖商"，仅为用户提供一个信息交流、进行物品买卖的平台，充当买卖双方之间的交流媒介，而非买主或卖主的代理商、合伙  人、雇员或雇主等经营关系人。公布在本网站上的交易物品是用户自行上传进行交易的物品，并非本网站所有。对于用户刊登物品、提供的信息或参与竞标的过程，  本网站均不加以监视或控制，亦不介入物品的交易过程，包括运送、付款、退款、瑕疵担保及其它交易事项，且不承担因交易物品存在品质、权利上的瑕疵以及交易  方履行交易协议的能力而产生的任何责任，对于出现在拍卖上的物品品质、安全性或合法性，本网站均不予保证。</li>\r\n<li>本网站有义务在现有技术水平的基础上努力确保整个网上交易平台的正常运行，尽力避免服务中断或将中断时间限制在最短时间内，保证用户网上交易活动的顺利进行。</li>\r\n<li>本网站有义务对用户在注册使用本网站网上交易平台中所遇到的问题及反映的情况及时作出回复。 </li>\r\n<li>本网站有权对用户的注册资料进行查阅，对存在任何问题或怀疑的注册资料，本网站有权发出通知询问用户并要求用户做出解释、改正，或直接做出处罚、删除等处理。</li>\r\n<li>用  户因在本网站网上交易与其他用户产生纠纷的，用户通过司法部门或行政部门依照法定程序要求本网站提供相关资料，本网站将积极配合并提供有关资料；用户将纠  纷告知本网站，或本网站知悉纠纷情况的，经审核后，本网站有权通过电子邮件及电话联系向纠纷双方了解纠纷情况，并将所了解的情况通过电子邮件互相通知对  方。 </li>\r\n<li>因网上交易平台的特殊性，本网站没有义务对所有用户的注册资料、所有的交易行为以及与交易有关的其他事项进行事先审查，但如发生以下情形，本网站有权限制用户的活动、向用户核实有关资料、发出警告通知、暂时中止、无限期地中止及拒绝向该用户提供服务：         \r\n<ul>\r\n<li>用户违反本协议或因被提及而纳入本协议的文件；</li>\r\n<li>存在用户或其他第三方通知本网站，认为某个用户或具体交易事项存在违法或不当行为，并提供相关证据，而本网站无法联系到该用户核证或验证该用户向本网站提供的任何资料；</li>\r\n<li>存在用户或其他第三方通知本网站，认为某个用户或具体交易事项存在违法或不当行为，并提供相关证据。本网站以普通非专业交易者的知识水平标准对相关内容进行判别，可以明显认为这些内容或行为可能对本网站用户或本网站造成财务损失或法律责任。 </li>\r\n</ul>\r\n</li>\r\n<li>在反网络欺诈行动中，本着保护广大用户利益的原则，当用户举报自己交易可能存在欺诈而产生交易争议时，本网站有权通过表面判断暂时冻结相关用户账号，并有权核对当事人身份资料及要求提供交易相关证明材料。</li>\r\n<li>根据国家法律法规、本协议的内容和本网站所掌握的事实依据，可以认定用户存在违法或违反本协议行为以及在本网站交易平台上的其他不当行为，本网站有权在本网站交易平台及所在网站上以网络发布形式公布用户的违法行为，并有权随时作出删除相关信息，而无须征得用户的同意。</li>\r\n<li>本  网站有权在不通知用户的前提下删除或采取其他限制性措施处理下列信息：包括但不限于以规避费用为目的；以炒作信用为目的；存在欺诈等恶意或虚假内容；与网  上交易无关或不是以交易为目的；存在恶意竞价或其他试图扰乱正常交易秩序因素；该信息违反公共利益或可能严重损害本网站和其他用户合法利益的。</li>\r\n<li>用  户授予本网站独家的、全球通用的、永久的、免费的信息许可使用权利，本网站有权对该权利进行再授权，依此授权本网站有权(全部或部份地)  使用、复制、修订、改写、发布、翻译、分发、执行和展示用户公示于网站的各类信息或制作其派生作品，以现在已知或日后开发的任何形式、媒体或技术，将上述  信息纳入其他作品内。</li>\r\n</ol>\r\n<p><br /> <br /> <strong>五、服务的中断和终止</strong><br /></p>\r\n<ol>\r\n<li>在  本网站未向用户收取相关服务费用的情况下，本网站可自行全权决定以任何理由  (包括但不限于本网站认为用户已违反本协议的字面意义和精神，或用户在超过180天内未登录本网站等)  终止对用户的服务，并不再保存用户在本网站的全部资料（包括但不限于用户信息、商品信息、交易信息等）。同时本网站可自行全权决定，在发出通知或不发出通  知的情况下，随时停止提供全部或部分服务。服务终止后，本网站没有义务为用户保留原用户资料或与之相关的任何信息，或转发任何未曾阅读或发送的信息给用户  或第三方。此外，本网站不就终止对用户的服务而对用户或任何第三方承担任何责任。 </li>\r\n<li>如用户向本网站提出注销本网站注册用户身份，需经本网站审核同意，由本网站注销该注册用户，用户即解除与本网站的协议关系，但本网站仍保留下列权利：         \r\n<ul>\r\n<li>用户注销后，本网站有权保留该用户的资料,包括但不限于以前的用户资料、店铺资料、商品资料和交易记录等。 </li>\r\n<li>用户注销后，如用户在注销前在本网站交易平台上存在违法行为或违反本协议的行为，本网站仍可行使本协议所规定的权利。 </li>\r\n</ul>\r\n</li>\r\n<li>如存在下列情况，本网站可以通过注销用户的方式终止服务：         \r\n<ul>\r\n<li>在用户违反本协议相关规定时，本网站有权终止向该用户提供服务。本网站将在中断服务时通知用户。但如该用户在被本网站终止提供服务后，再一次直接或间接或以他人名义注册为本网站用户的，本网站有权再次单方面终止为该用户提供服务；</li>\r\n<li>一旦本网站发现用户注册资料中主要内容是虚假的，本网站有权随时终止为该用户提供服务； </li>\r\n<li>本协议终止或更新时，用户未确认新的协议的。 </li>\r\n<li>其它本网站认为需终止服务的情况。 </li>\r\n</ul>\r\n</li>\r\n<li>因用户违反相关法律法规或者违反本协议规定等原因而致使本网站中断、终止对用户服务的，对于服务中断、终止之前用户交易行为依下列原则处理：         \r\n<ul>\r\n<li>本网站有权决定是否在中断、终止对用户服务前将用户被中断或终止服务的情况和原因通知用户交易关系方，包括但不限于对该交易有意向但尚未达成交易的用户,参与该交易竞价的用户，已达成交易要约用户。</li>\r\n<li>服务中断、终止之前，用户已经上传至本网站的物品尚未交易或交易尚未完成的，本网站有权在中断、终止服务的同时删除此项物品的相关信息。 </li>\r\n<li>服务中断、终止之前，用户已经就其他用户出售的具体物品作出要约，但交易尚未结束，本网站有权在中断或终止服务的同时删除该用户的相关要约和信息。</li>\r\n</ul>\r\n</li>\r\n<li>本网站若因用户的行为（包括但不限于刊登的商品、在本网站社区发帖等）侵害了第三方的权利或违反了相关规定，而受到第三方的追偿或受到主管机关的处分时，用户应赔偿本网站因此所产生的一切损失及费用。</li>\r\n<li>对违反相关法律法规或者违反本协议规定，且情节严重的用户，本网站有权终止该用户的其它服务。</li>\r\n</ol>\r\n<p><br /> <br /> <strong>六、协议的修订</strong><br /> <br /> 本协议可由本网站随时修订，并将修订后的协议公告于本网站之上，修订后的条款内容自公告时起生效，并成为本协议的一部分。用户若在本协议修改之后，仍继续使用本网站，则视为用户接受和自愿遵守修订后的协议。本网站行使修改或中断服务时，不需对任何第三方负责。<br /> <br /> <strong>七、 本网站的责任范围 </strong><br /> <br /> 当用户接受该协议时，用户应明确了解并同意∶</p>\r\n<ol>\r\n<li>是否经由本网站下载或取得任何资料，由用户自行考虑、衡量并且自负风险，因下载任何资料而导致用户电脑系统的任何损坏或资料流失，用户应负完全责任。</li>\r\n<li>用户经由本网站取得的建议和资讯，无论其形式或表现，绝不构成本协议未明示规定的任何保证。</li>\r\n<li>基于以下原因而造成的利润、商誉、使用、资料损失或其它无形损失，本网站不承担任何直接、间接、附带、特别、衍生性或惩罚性赔偿（即使本网站已被告知前款赔偿的可能性）：         \r\n<ul>\r\n<li>本网站的使用或无法使用。</li>\r\n<li>经由或通过本网站购买或取得的任何物品，或接收之信息，或进行交易所随之产生的替代物品及服务的购买成本。</li>\r\n<li>用户的传输或资料遭到未获授权的存取或变更。</li>\r\n<li>本网站中任何第三方之声明或行为。</li>\r\n<li>本网站其它相关事宜。</li>\r\n</ul>\r\n</li>\r\n<li>本网站只是为用户提供一个交易的平台，对于用户所刊登的交易物品的合法性、真实性及其品质，以及用户履行交易的能力等，本网站一律不负任何担保责任。用户如果因使用本网站，或因购买刊登于本网站的任何物品，而受有损害时，本网站不负任何补偿或赔偿责任。</li>\r\n<li>本  网站提供与其它互联网上的网站或资源的链接，用户可能会因此连结至其它运营商经营的网站，但不表示本网站与这些运营商有任何关系。其它运营商经营的网站均  由各经营者自行负责，不属于本网站控制及负责范围之内。对于存在或来源于此类网站或资源的任何内容、广告、产品或其它资料，本网站亦不予保证或负责。因使  用或依赖任何此类网站或资源发布的或经由此类网站或资源获得的任何内容、物品或服务所产生的任何损害或损失，本网站不负任何直接或间接的责任。</li>\r\n</ol>\r\n<p><br /> <br /> <strong>八.、不可抗力</strong><br /> <br /> 因不可抗力或者其他意外事件，使得本协议的履行不可能、不必要或者无意义的，双方均不承担责任。本合同所称之不可抗力意指不能预见、不能避免并不能克服的  客观情况，包括但不限于战争、台风、水灾、火灾、雷击或地震、罢工、暴动、法定疾病、黑客攻击、网络病毒、电信部门技术管制、政府行为或任何其它自然或人  为造成的灾难等客观情况。<br /> <br /> <strong>九、争议解决方式</strong><br /></p>\r\n<ol>\r\n<li>本协议及其修订本的有效性、履行和与本协议及其修订本效力有关的所有事宜，将受中华人民共和国法律管辖，任何争议仅适用中华人民共和国法律。</li>\r\n<li>因  使用本网站服务所引起与本网站的任何争议，均应提交深圳仲裁委员会按照该会届时有效的仲裁规则进行仲裁。相关争议应单独仲裁，不得与任何其它方的争议在任  何仲裁中合并处理，该仲裁裁决是终局，对各方均有约束力。如果所涉及的争议不适于仲裁解决，用户同意一切争议由人民法院管辖。</li>\r\n</ol>', 1293773586);
INSERT INTO `#__document` (`doc_id`, `doc_code`, `doc_title`, `doc_content`, `doc_time`) VALUES(2, 'real_name', '什么是实名认证', '<p><strong>什么是实名认证？</strong></p>\r\n<p>&ldquo;认证店铺&rdquo;服务是一项对店主身份真实性识别服务。店主可以通过站内PM、电话或管理员EMail的方式 联系并申请该项认证。经过管理员审核确认了店主的真实身份，就可以开通该项认证。</p>\r\n<p>通过该认证，可以说明店主身份的真实有效性，为买家在网络交易的过程中提供一定的信心和保证。</p>\r\n<p><strong>认证申请的方式：</strong></p>\r\n<p>Email：XXXX@XX.com</p>\r\n<p>管理员：XXXXXX</p>', 1293773817);
INSERT INTO `#__document` (`doc_id`, `doc_code`, `doc_title`, `doc_content`, `doc_time`) VALUES(3, 'real_store', '什么是实体店铺认证', '<p><strong>什么是实体店铺认证？</strong></p>\r\n<p>&ldquo;认证店铺&rdquo;服务是一项对店主身份真实性识别服务。店主可以通过站内PM、电话或管理员EMail的方式 联系并申请该项认证。经过管理员审核确认了店主的真实身份，就可以开通该项认证。</p>\r\n<p>通过该认证，可以说明店主身份的真实有效性，为买家在网络交易的过程中提供一定的信心和保证。</p>\r\n<p><strong>认证申请的方式：</strong></p>\r\n<p>Email：XXXX@XX.com</p>\r\n<p>管理员：XXXXXX</p>', 1293773875);
INSERT INTO `#__document` (`doc_id`, `doc_code`, `doc_title`, `doc_content`, `doc_time`) VALUES(4, 'open_store', '开店协议', '<p>使用本公司服务所须遵守的条款和条件。<br /><br />1.用户资格<br />本公司的服务仅向适用法律下能够签订具有法律约束力的合同的个人提供并仅由其使用。在不限制前述规定的前提下，本公司的服务不向18周岁以下或被临时或无限期中止的用户提供。如您不合资格，请勿使用本公司的服务。此外，您的帐户（包括信用评价）和用户名不得向其他方转让或出售。另外，本公司保留根据其意愿中止或终止您的帐户的权利。<br /><br />2.您的资料（包括但不限于所添加的任何商品）不得：<br />*具有欺诈性、虚假、不准确或具误导性；<br />*侵犯任何第三方著作权、专利权、商标权、商业秘密或其他专有权利或发表权或隐私权；<br />*违反任何适用的法律或法规（包括但不限于有关出口管制、消费者保护、不正当竞争、刑法、反歧视或贸易惯例/公平贸易法律的法律或法规）；<br />*有侮辱或者诽谤他人，侵害他人合法权益的内容；<br />*有淫秽、色情、赌博、暴力、凶杀、恐怖或者教唆犯罪的内容；<br />*包含可能破坏、改变、删除、不利影响、秘密截取、未经授权而接触或征用任何系统、数据或个人资料的任何病毒、特洛依木马、蠕虫、定时炸弹、删除蝇、复活节彩蛋、间谍软件或其他电脑程序；<br /><br />3.违约<br />如发生以下情形，本公司可能限制您的活动、立即删除您的商品、向本公司社区发出有关您的行为的警告、发出警告通知、暂时中止、无限期地中止或终止您的用户资格及拒绝向您提供服务：<br />(a)您违反本协议或纳入本协议的文件；<br />(b)本公司无法核证或验证您向本公司提供的任何资料；<br />(c)本公司相信您的行为可能对您、本公司用户或本公司造成损失或法律责任。<br /><br />4.责任限制<br />本公司、本公司的关联公司和相关实体或本公司的供应商在任何情况下均不就因本公司的网站、本公司的服务或本协议而产生或与之有关的利润损失或任何特别、间接或后果性的损害（无论以何种方式产生，包括疏忽）承担任何责任。您同意您就您自身行为之合法性单独承担责任。您同意，本公司和本公司的所有关联公司和相关实体对本公司用户的行为的合法性及产生的任何结果不承担责任。<br /><br />5.无代理关系<br />用户和本公司是独立的合同方，本协议无意建立也没有创立任何代理、合伙、合营、雇员与雇主或特许经营关系。本公司也不对任何用户及其网上交易行为做出明示或默许的推荐、承诺或担保。<br /><br />6.一般规定<br />本协议在所有方面均受中华人民共和国法律管辖。本协议的规定是可分割的，如本协议任何规定被裁定为无效或不可执行，该规定可被删除而其余条款应予以执行。</p>', 1293773901);
INSERT INTO `#__document` (`doc_id`, `doc_code`, `doc_title`, `doc_content`, `doc_time`) VALUES(5, 'groupbuy', '团购活动协议', '<p>\r\n	一、团购的所有权和运作权归本公司。\r\n</p>\r\n<p>\r\n	二、本公司有权在必要时修改本协议，本协议一旦发生变更，将会在相关页面上公布。如果您不同意所改动的内容，您应主动停止使用团购服务。如果您继续使用服务，则视为接受本协议的变更。\r\n</p>\r\n<p>\r\n	三、如发生下列任何一种情形，本公司有权中断或终止向您提供的服务而无需通知您：\r\n</p>\r\n1、 您提供的个人资料不真实；<br />\r\n2、您违反本协议的规定；<br />\r\n3、 按照政府主管部门的监管要求；<br />\r\n4、本公司认为您的行为违反团购服务性质或需求的特殊情形。\r\n<p>\r\n	四、尽管本协议可能另有其他规定，本公司仍然可以随时终止本协议。\r\n</p>\r\n<p>\r\n	五、本公司终止本协议的权利不会妨害本公司可能拥有的在本协议终止前因您违反本协议或本公司本应享有的任何其他权利。\r\n</p>\r\n<p>\r\n	六、您理解并完全接受，本公司有权自行对团购资源作下线处理。\r\n</p>', 1328580944);
