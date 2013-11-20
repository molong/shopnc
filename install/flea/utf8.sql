CREATE TABLE `shopnc_flea` (
  `goods_id` int(11) NOT NULL auto_increment COMMENT '闲置索引id',
  `goods_name` varchar(100) NOT NULL COMMENT '闲置名称',
  `gc_id` int(11) NOT NULL COMMENT '闲置分类id',
  `gc_name` varchar(200) NOT NULL COMMENT '闲置分类名称',
  `member_id` int(11) NOT NULL COMMENT '店铺id',
  `member_name` varchar(110) NOT NULL COMMENT '会员名称',
  `goods_image` varchar(100) NOT NULL COMMENT '闲置默认封面图片',
  `goods_tag` varchar(100) NOT NULL COMMENT '闲置标签',
  `goods_price` decimal(10,2) NOT NULL COMMENT '闲置原价',
  `goods_store_price` decimal(10,2) NOT NULL COMMENT '闲置转让价格',
  `goods_show` tinyint(1) NOT NULL COMMENT '闲置上架',
  `goods_click` int(11) NOT NULL default '0' COMMENT '闲置浏览数',
  `flea_collect_num` int(11) unsigned NOT NULL COMMENT '闲置物品总收藏次数',
  `goods_commend` tinyint(1) NOT NULL COMMENT '闲置推荐',
  `goods_add_time` varchar(10) NOT NULL COMMENT '闲置添加时间',
  `goods_keywords` varchar(255) NOT NULL COMMENT '闲置关键字',
  `goods_description` varchar(255) NOT NULL COMMENT '闲置描述',
  `goods_body` text NOT NULL COMMENT '商品详细内容',
  `commentnum` int(11) NOT NULL default '0' COMMENT '评论次数',
  `salenum` int(11) NOT NULL default '0' COMMENT '售出数量',
  `flea_quality` tinyint(4) NOT NULL default '0' COMMENT '闲置物品成色，0未选择，9-5九五成新，3是低于五成新',
  `flea_pname` varchar(20) default NULL COMMENT '闲置商品联系人',
  `flea_pphone` varchar(20) default NULL COMMENT '闲置商品联系人电话',
  `flea_area_id` int(11) unsigned NOT NULL COMMENT '闲置物品地区id',
  `flea_area_name` varchar(50) NOT NULL COMMENT '闲置物品地区名称',
  PRIMARY KEY  (`goods_id`),
  KEY `goods_name` (`goods_name`,`gc_id`,`member_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='闲置商品';

CREATE TABLE `shopnc_flea_area` (
  `flea_area_id` int(11) unsigned NOT NULL auto_increment COMMENT '闲置地区id',
  `flea_area_name` varchar(50) NOT NULL COMMENT '闲置地区名称',
  `flea_area_parent_id` int(11) unsigned NOT NULL default '0' COMMENT '闲置地区上级地区id',
  `flea_area_sort` tinyint(3) unsigned NOT NULL default '0' COMMENT '闲置地区排序',
  `flea_area_deep` tinyint(1) unsigned NOT NULL default '1' COMMENT '闲置地区层级',
  `flea_area_hot` int(11) NOT NULL default '0' COMMENT '地区检索热度',
  PRIMARY KEY  (`flea_area_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='闲置地区';

CREATE TABLE `shopnc_flea_class` (
  `gc_id` int(10) unsigned NOT NULL auto_increment COMMENT '索引ID',
  `gc_name` varchar(100) NOT NULL COMMENT '分类名称',
  `gc_name_index` varchar(100) NOT NULL COMMENT '闲置首页显示的名称',
  `gc_parent_id` int(10) unsigned NOT NULL default '0' COMMENT '父ID',
  `gc_sort` tinyint(3) unsigned NOT NULL default '0' COMMENT '排序',
  `gc_show` tinyint(1) NOT NULL default '1' COMMENT '前台显示，0为否，1为是，默认为1',
  `gc_index_show` tinyint(1) NOT NULL default '1' COMMENT '首页显示 1：默认 显示 0：不显示',
  PRIMARY KEY  (`gc_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='闲置分类';

CREATE TABLE `shopnc_flea_class_index` (
  `fc_index_id` int(11) unsigned NOT NULL auto_increment COMMENT '自增id',
  `fc_index_class` varchar(50) NOT NULL COMMENT '类别名称',
  `fc_index_code` varchar(50) NOT NULL COMMENT '类别code',
  `fc_index_id1` varchar(50) NOT NULL default '0' COMMENT '分类id1',
  `fc_index_name1` varchar(50) NOT NULL,
  `fc_index_id2` varchar(50) NOT NULL default '0' COMMENT '分类id2',
  `fc_index_name2` varchar(50) NOT NULL,
  `fc_index_id3` varchar(50) NOT NULL default '0' COMMENT '分类id3',
  `fc_index_name3` varchar(50) NOT NULL,
  `fc_index_id4` varchar(50) NOT NULL default '0' COMMENT '分类id4',
  `fc_index_name4` varchar(50) NOT NULL,
  PRIMARY KEY  (`fc_index_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='闲置首页分类';

CREATE TABLE `shopnc_flea_consult` (
  `consult_id` int(10) unsigned NOT NULL auto_increment COMMENT '咨询编号',
  `goods_id` int(11) default '0' COMMENT '商品编号',
  `member_id` int(11) NOT NULL default '0' COMMENT '咨询发布者会员编号(0：游客)',
  `seller_id` int(11) NOT NULL COMMENT '信息发布者编号',
  `email` varchar(255) default NULL COMMENT '咨询发布者邮箱',
  `consult_content` varchar(4000) default NULL COMMENT '咨询内容',
  `consult_addtime` int(10) default NULL COMMENT '咨询发布时间',
  `consult_reply` varchar(4000) default NULL COMMENT '咨询回复内容',
  `consult_reply_time` int(10) default NULL COMMENT '咨询回复时间',
  `type` varchar(20) NOT NULL default 'flea' COMMENT '咨询类型',
  PRIMARY KEY  (`consult_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='闲置咨询';

CREATE TABLE `shopnc_flea_upload` (
  `upload_id` int(10) unsigned NOT NULL auto_increment COMMENT '索引ID',
  `file_name` varchar(100) default NULL COMMENT '文件名',
  `file_thumb` varchar(100) default NULL COMMENT '缩微图片',
  `file_wm` varchar(100) default NULL COMMENT '水印图片',
  `file_size` int(10) unsigned NOT NULL default '0' COMMENT '文件大小',
  `store_id` int(10) unsigned NOT NULL default '0' COMMENT '会员ID',
  `upload_type` tinyint(1) NOT NULL default '0' COMMENT '默认为0，12为商品切换图片，13为商品内容图片',
  `upload_time` int(10) unsigned NOT NULL default '0' COMMENT '添加时间',
  `item_id` int(11) unsigned NOT NULL default '0' COMMENT '信息ID',
  PRIMARY KEY  (`upload_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='闲置上传文件表';

CREATE TABLE `shopnc_flea_favorites` (
  `member_id` int(10) unsigned NOT NULL COMMENT '会员ID',
  `fav_id` int(10) unsigned NOT NULL COMMENT '收藏ID',
  `fav_type` varchar(20) NOT NULL COMMENT '收藏类型',
  `fav_time` varchar(10) NOT NULL COMMENT '收藏时间'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='买家闲置收藏表';
