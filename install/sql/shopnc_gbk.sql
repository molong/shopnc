CREATE TABLE `#__activity` (
  `activity_id` mediumint(9) NOT NULL auto_increment COMMENT 'id',
  `activity_title` varchar(255) NOT NULL COMMENT '����',
  `activity_type` enum('1','2') default NULL COMMENT '����� 1:��Ʒ 2:�Ź�',
  `activity_banner` varchar(255) NOT NULL COMMENT '������ͼƬ',
  `activity_style` varchar(255) NOT NULL COMMENT '�ҳ��ģ����ʽ��ʶ��',
  `activity_desc` varchar(1000) NOT NULL COMMENT '����',
  `activity_start_date` int(10) unsigned NOT NULL default '0' COMMENT '��ʼʱ��',
  `activity_end_date` int(10) unsigned NOT NULL default '0' COMMENT '����ʱ��',
  `activity_sort` tinyint(1) unsigned NOT NULL default '255' COMMENT '����',
  `activity_state` tinyint(1) unsigned NOT NULL default '1' COMMENT '�״̬ 0Ϊ�ر� 1Ϊ����',
  PRIMARY KEY (`activity_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='���';

CREATE TABLE `#__activity_detail` (
  `activity_detail_id` mediumint(9) NOT NULL auto_increment COMMENT 'id',
  `activity_id` mediumint(8) unsigned NOT NULL default '0' COMMENT '����',
  `item_id` int(11) NOT NULL COMMENT '��Ʒ���Ź��ı��',
  `item_name` varchar(255) NOT NULL COMMENT '��Ʒ���Ź�����',
  `store_id` int(11) NOT NULL COMMENT '���̱��',
  `store_name` varchar(255) NOT NULL COMMENT '��������',
  `activity_detail_state` enum('0','1','2','3') NOT NULL default '0' COMMENT '���״̬ 0:(Ĭ��)����� 1:ͨ�� 2:δͨ�� 3:�ٴ�����',
  `activity_detail_sort` tinyint(1) unsigned NOT NULL default '255' COMMENT '����',
  PRIMARY KEY  (`activity_detail_id`),
  KEY `activity_id` (`activity_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='�ϸ�ڱ�';

CREATE TABLE `#__address` (
  `address_id` mediumint(10) unsigned NOT NULL auto_increment COMMENT '��ַID',
  `member_id` mediumint(10) unsigned NOT NULL default '0' COMMENT '��ԱID',
  `true_name` varchar(50) NOT NULL COMMENT '��Ա����',
  `area_id` mediumint(10) unsigned NOT NULL default '0' COMMENT '����ID',
  `city_id` mediumint(9) default NULL COMMENT '�м�ID',
  `area_info` varchar(255) NOT NULL default '' COMMENT '��������',
  `address` varchar(255) NOT NULL COMMENT '��ַ',
  `zip_code` char(6) default NULL COMMENT '�ʱ�',
  `tel_phone` varchar(20) default NULL COMMENT '�����绰',
  `mob_phone` varchar(15) default NULL COMMENT '�ֻ��绰',
  PRIMARY KEY (`address_id`),
  KEY `member_id` (`member_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='��ҵ�ַ��Ϣ��';

CREATE TABLE `#__admin` (
  `admin_id` int(11) unsigned NOT NULL auto_increment COMMENT '����ԱID',
  `admin_permission` varchar(3000) default NULL COMMENT '����Ȩ��',
  `admin_name` varchar(20) NOT NULL COMMENT '����Ա����',
  `admin_password` varchar(32) NOT NULL default '' COMMENT '����Ա����',
  `admin_login_time` int(10) NOT NULL default '0' COMMENT '��¼ʱ��',
  `admin_login_num` int(11) NOT NULL default '0' COMMENT '��¼����',
  `admin_is_super` tinyint(1) NOT NULL default '0' COMMENT '�Ƿ񳬼�����Ա',
  PRIMARY KEY  (`admin_id`),
  KEY `member_id` (`admin_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='����Ա��';

CREATE TABLE `#__adv` (
  `adv_id` mediumint(8) unsigned NOT NULL auto_increment COMMENT '���������ʶ���',
  `ap_id` mediumint(8) unsigned NOT NULL COMMENT '���λid',
  `adv_title` varchar(255) NOT NULL COMMENT '�����������',
  `adv_content` varchar(1000) NOT NULL COMMENT '�������',
  `adv_start_date` int(10) default NULL COMMENT '��濪ʼʱ��',
  `adv_end_date` int(10) default NULL COMMENT '������ʱ��',
  `slide_sort` int(10) unsigned NOT NULL COMMENT '�õ�Ƭ����',
  `member_id` int(11) NOT NULL COMMENT '��ԱID',
  `member_name` varchar(50) NOT NULL COMMENT '��Ա�û���',
  `click_num` int(10) unsigned NOT NULL COMMENT '�������',
  `is_allow` smallint(1) unsigned NOT NULL COMMENT '��Ա����Ĺ���Ƿ�ͨ�����0δ���1�����ͨ��2���δͨ��',
  `buy_style` varchar(10) NOT NULL COMMENT '����ʽ',
  `goldpay` int(10) unsigned NOT NULL COMMENT '������֧���Ľ��',
  PRIMARY KEY  (`adv_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='����';

CREATE TABLE `#__adv_click` (
  `adv_id` mediumint(8) unsigned NOT NULL COMMENT '���id',
  `ap_id` mediumint(8) unsigned NOT NULL default '0' COMMENT '�������λid',
  `click_year` smallint(5) unsigned NOT NULL default '0' COMMENT '������',
  `click_month` smallint(5) unsigned NOT NULL default '0' COMMENT '����·�',
  `click_num` mediumint(8) unsigned NOT NULL default '0' COMMENT '�����',
  `adv_name` varchar(100) NOT NULL COMMENT '�������',
  `ap_name` varchar(100) NOT NULL COMMENT '���λ����',
  UNIQUE KEY `adv_id` (`adv_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='������ʱ�';

CREATE TABLE `#__adv_position` (
  `ap_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '���λ��id',
  `ap_name` varchar(100) NOT NULL COMMENT '���λ����',
  `ap_intro` varchar(255) NOT NULL COMMENT '���λ���',
  `ap_class` smallint(1) unsigned NOT NULL COMMENT '������0ͼƬ1����2�õ�3Flash',
  `ap_display` smallint(1) unsigned NOT NULL COMMENT '���չʾ��ʽ��0�õ�Ƭ1����չʾ2�����չʾ',
  `is_use` smallint(1) unsigned NOT NULL COMMENT '���λ�Ƿ����ã�0������1����',
  `ap_width` int(10) NOT NULL COMMENT '���λ���',
  `ap_height` int(10) NOT NULL COMMENT '���λ�߶�',
  `ap_price` int(10) unsigned NOT NULL COMMENT '���λ����',
  `adv_num` int(10) unsigned NOT NULL COMMENT 'ӵ�еĹ����',
  `click_num` int(10) unsigned NOT NULL COMMENT '���λ�����',
  `default_content` varchar(100) NOT NULL COMMENT '���λĬ������',
  PRIMARY KEY (`ap_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='���λ��';

CREATE TABLE `#__album_class` (
  `aclass_id` int(10) unsigned NOT NULL auto_increment COMMENT '���id',
  `aclass_name` varchar(100) NOT NULL COMMENT '�������',
  `store_id` int(10) unsigned NOT NULL COMMENT '��������id',
  `aclass_des` varchar(255) NOT NULL COMMENT '�������',
  `aclass_sort` tinyint(3) unsigned NOT NULL COMMENT '����',
  `aclass_cover` varchar(255) NOT NULL COMMENT '������',
  `upload_time` int(10) unsigned NOT NULL COMMENT 'ͼƬ�ϴ�ʱ��',
  `is_default` tinyint(1) unsigned NOT NULL default '0' COMMENT '�Ƿ�ΪĬ�����,1����Ĭ��',
  PRIMARY KEY (`aclass_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='����';

CREATE TABLE `#__album_pic` (
  `apic_id` int(10) unsigned NOT NULL auto_increment COMMENT '���ͼƬ��id',
  `apic_name` varchar(100) NOT NULL COMMENT 'ͼƬ����',
  `apic_tag` varchar(255) NOT NULL COMMENT 'ͼƬ��ǩ',
  `aclass_id` int(10) unsigned NOT NULL COMMENT '���id',
  `apic_cover` varchar(255) NOT NULL COMMENT 'ͼƬ·��',
  `apic_size` int(10) unsigned NOT NULL COMMENT 'ͼƬ��С',
  `apic_spec` varchar(100) NOT NULL COMMENT 'ͼƬ���',
  `store_id` int(10) unsigned NOT NULL COMMENT '��������id',
  `upload_time` int(10) unsigned NOT NULL COMMENT 'ͼƬ�ϴ�ʱ��',
  PRIMARY KEY  (`apic_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='���ͼƬ��';

CREATE TABLE `#__article` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '����id',
  `ac_id` mediumint(8) unsigned NOT NULL default '0' COMMENT '����id',
  `article_url` varchar(100) DEFAULT NULL COMMENT '��ת����',
  `article_show` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '�Ƿ���ʾ��0Ϊ��1Ϊ�ǣ�Ĭ��Ϊ1',
  `article_sort` tinyint(3) unsigned NOT NULL DEFAULT '255' COMMENT '����',
  `article_title` varchar(100) DEFAULT NULL COMMENT '����',
  `article_content` text COMMENT '����',
  `article_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '����ʱ��',
  PRIMARY KEY (`article_id`),
  KEY `ac_id` (`ac_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='���±�';

CREATE TABLE `#__article_class` (
  `ac_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '����ID',
  `ac_code` varchar(20) default NULL COMMENT '�����ʶ��',
  `ac_name` varchar(100) NOT NULL COMMENT '��������',
  `ac_parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '��ID',
  `ac_sort` tinyint(1) unsigned NOT NULL DEFAULT '255' COMMENT '����',
  PRIMARY KEY (`ac_id`),
  KEY `ac_parent_id` (`ac_parent_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='���·����';

CREATE TABLE `#__attribute` (
	`attr_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '����id',
	`attr_name` varchar(100) NOT NULL COMMENT '��������',
	`type_id` int(10) unsigned NOT NULL COMMENT '��������id',
	`attr_value` text NOT NULL COMMENT '����ֵ��',
	`attr_show` tinyint(1) unsigned NOT NULL COMMENT '�Ƿ���ʾ��0Ϊ����ʾ��1Ϊ��ʾ',
	`attr_sort` tinyint(1) unsigned NOT NULL COMMENT '����',
	PRIMARY KEY  (`attr_id`),
	KEY `attr_id` (`attr_id`,`type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='��Ʒ���Ա�';

CREATE TABLE `#__attribute_value` (
	`attr_value_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '����ֵid',
	`attr_value_name` varchar(100) NOT NULL COMMENT '����ֵ����',
	`attr_id` int(10) unsigned NOT NULL COMMENT '��������id',
  `attr_value_sort` tinyint(1) unsigned NOT NULL COMMENT '����ֵ����',
  PRIMARY KEY (`attr_value_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='��Ʒ����ֵ��';

CREATE TABLE `#__brand` (
  `brand_id` mediumint(11) NOT NULL AUTO_INCREMENT COMMENT '����ID',
  `brand_name` varchar(100) DEFAULT NULL COMMENT 'Ʒ������',
  `brand_class` varchar(50) default NULL COMMENT '�������',
  `brand_pic` varchar(100) DEFAULT NULL COMMENT 'ͼƬ',
  `brand_sort` tinyint(3) unsigned DEFAULT '0' COMMENT '����',
  `brand_recommend` tinyint(1) DEFAULT '0' COMMENT '�Ƽ���0Ϊ��1Ϊ�ǣ�Ĭ��Ϊ0',
  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '����ID',
  `brand_apply` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Ʒ�����룬0Ϊ�����У�1Ϊͨ����Ĭ��Ϊ1�����빦���ǻ�Աʹ�ã�ϵͳ��̨Ĭ��Ϊ1',
  PRIMARY KEY (`brand_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='Ʒ�Ʊ�';

CREATE TABLE `#__cart` (
  `cart_id` int(11) NOT NULL auto_increment COMMENT '���ﳵid',
  `member_id` int(11) unsigned NOT NULL default '0' COMMENT '��Աid',
  `store_id` int(11) unsigned NOT NULL default '0' COMMENT '����id',
  `goods_id` int(11) unsigned NOT NULL default '0' COMMENT '��Ʒid',
  `goods_name` varchar(100) NOT NULL COMMENT '��Ʒ����',
  `spec_id` int(11) unsigned NOT NULL default '0' COMMENT '���id',
  `spec_info` text NOT NULL COMMENT '�������',
  `goods_store_price` decimal(10,2) NOT NULL COMMENT '��Ʒ�۸�',
  `goods_num` smallint(5) unsigned NOT NULL default '1' COMMENT '������Ʒ����',
  `goods_images` varchar(100) NOT NULL COMMENT '��ƷͼƬ',
  PRIMARY KEY  (`cart_id`),
  KEY `member_id` (`member_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='���ﳵ���ݱ�';

CREATE TABLE `#__complain` (
  `complain_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Ͷ��id',
  `order_id` int(11) NOT NULL COMMENT '����id',
  `order_goods_count` int(11) NOT NULL COMMENT '������Ʒ����',
  `complain_goods_count` int(11) NOT NULL COMMENT 'Ͷ����Ʒ����',
  `accuser_id` int(11) NOT NULL COMMENT 'ԭ��id',
  `accuser_name` varchar(50) NOT NULL COMMENT 'ԭ������',
  `accused_id` int(11) NOT NULL COMMENT '����id',
  `accused_name` varchar(50) NOT NULL COMMENT '��������',
  `complain_subject_content` varchar(50) NOT NULL COMMENT 'Ͷ������',
  `complain_subject_id` int(11) NOT NULL COMMENT 'Ͷ������id',
  `complain_content` varchar(255) NOT NULL COMMENT 'Ͷ������',
  `complain_pic1` varchar(100) NOT NULL COMMENT 'Ͷ��ͼƬ1',
  `complain_pic2` varchar(100) NOT NULL COMMENT 'Ͷ��ͼƬ2',
  `complain_pic3` varchar(100) NOT NULL COMMENT 'Ͷ��ͼƬ3',
  `complain_datetime` int(11) NOT NULL COMMENT 'Ͷ��ʱ��',
  `complain_handle_datetime` int(11) NOT NULL COMMENT 'Ͷ�ߴ���ʱ��',
  `complain_handle_member_id` int(11) NOT NULL COMMENT 'Ͷ�ߴ�����id',
  `appeal_message` varchar(255) NOT NULL COMMENT '��������',
  `appeal_datetime` int(11) NOT NULL COMMENT '����ʱ��',
  `appeal_pic1` varchar(100) NOT NULL COMMENT '����ͼƬ1',
  `appeal_pic2` varchar(100) NOT NULL COMMENT '����ͼƬ2',
  `appeal_pic3` varchar(100) NOT NULL COMMENT '����ͼƬ3',
  `final_handle_message` varchar(255) NOT NULL COMMENT '���մ������',
  `final_handle_datetime` int(11) NOT NULL COMMENT '���մ���ʱ��',
  `final_handle_member_id` int(11) NOT NULL COMMENT '���մ�����id',
  `complain_type` tinyint(4) NOT NULL COMMENT 'Ͷ������(1-���Ͷ��/2-����Ͷ��)',
  `complain_state` tinyint(4) NOT NULL COMMENT 'Ͷ��״̬(10-��Ͷ��/20-Ͷ��ͨ��ת����Ͷ����/30-��Ͷ����������/40-�ύ�ٲ�/99-�ѹر�)',
  `complain_active` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Ͷ���Ƿ�ͨ��ƽ̨����(1δͨ��/2ͨ��)',
  PRIMARY KEY (`complain_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='Ͷ�߱�';

CREATE TABLE `#__complain_goods` (
  `complain_goods_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Ͷ����Ʒ����id',
  `complain_id` int(11) NOT NULL COMMENT 'Ͷ��id',
  `goods_id` int(11) NOT NULL COMMENT '��Ʒid',
  `goods_name` varchar(100) NOT NULL COMMENT '��Ʒ����',
  `spec_id` int(11) NOT NULL COMMENT '���id',
  `spec_info` varchar(50) NOT NULL DEFAULT '' COMMENT '�������',
  `goods_price` decimal(10,2) NOT NULL COMMENT '��Ʒ�۸�',
  `goods_num` int(11) NOT NULL COMMENT '��Ʒ����',
  `goods_image` varchar(100) NOT NULL DEFAULT '' COMMENT '��ƷͼƬ',
  `evaluation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '��������: 1���� 2���� 3����',
  `comment` varchar(255) NOT NULL DEFAULT '' COMMENT '����',
  `complain_message` varchar(100) NOT NULL COMMENT '��Ͷ����Ʒ����������',
  PRIMARY KEY (`complain_goods_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='Ͷ����Ʒ��';

CREATE TABLE `#__complain_subject` (
  `complain_subject_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Ͷ������id',
  `complain_subject_content` varchar(50) NOT NULL COMMENT 'Ͷ������',
  `complain_subject_desc` varchar(100) NOT NULL COMMENT 'Ͷ����������',
  `complain_subject_type` tinyint(4) NOT NULL COMMENT 'Ͷ����������(1-���/2-����)',
  `complain_subject_state` tinyint(4) NOT NULL COMMENT 'Ͷ������״̬(1-��Ч/2-ʧЧ)',
  PRIMARY KEY (`complain_subject_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='Ͷ�������';

CREATE TABLE `#__complain_talk` (
  `talk_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Ͷ�߶Ի�id',
  `complain_id` int(11) NOT NULL COMMENT 'Ͷ��id',
  `talk_member_id` int(11) NOT NULL COMMENT '������id',
  `talk_member_name` varchar(50) NOT NULL COMMENT '����������',
  `talk_member_type` varchar(10) NOT NULL COMMENT '����������(1-Ͷ����/2-��Ͷ����/3-ƽ̨)',
  `talk_content` varchar(255) NOT NULL COMMENT '��������',
  `talk_state` tinyint(4) NOT NULL COMMENT '����״̬(1-��ʾ/2-����ʾ)',
  `talk_admin` int(11) NOT NULL DEFAULT '0' COMMENT '�Ի�����Ա�����ζԻ��˵�id',
  `talk_datetime` int(11) NOT NULL COMMENT '�Ի�����ʱ��',
  PRIMARY KEY (`talk_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='Ͷ�߶Ի���';

CREATE TABLE `#__consult` (
  `consult_id` int(10) unsigned NOT NULL auto_increment COMMENT '��ѯ���',
  `goods_id` int(11) unsigned default '0' COMMENT '��Ʒ���',
  `cgoods_name` varchar(100) NOT NULL COMMENT '��Ʒ����',
  `member_id` int(11) NOT NULL default '0' COMMENT '��ѯ�����߻�Ա���(0���ο�)',
  `cmember_name` varchar(100) default NULL COMMENT '��Ա����',
  `seller_id` int(11) unsigned NOT NULL default '0' COMMENT '���ұ��',
  `email` varchar(255) default NULL COMMENT '��ѯ����������',
  `consult_content` varchar(255) default NULL COMMENT '��ѯ����',
  `consult_addtime` int(10) default NULL COMMENT '��ѯ����ʱ��',
  `consult_reply` varchar(255) default NULL COMMENT '��ѯ�ظ�����',
  `consult_reply_time` int(10) default NULL COMMENT '��ѯ�ظ�ʱ��',
  `isanonymous` tinyint(1) NOT NULL default '0' COMMENT '0��ʾ������ 1��ʾ����',
  PRIMARY KEY  (`consult_id`),
  KEY `goods_id` (`goods_id`),
  KEY `seller_id` (`seller_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='��Ʒ��ѯ��';

CREATE TABLE `#__coupon` (
  `coupon_id` int(11) NOT NULL auto_increment COMMENT 'id',
  `coupon_title` varchar(255) NOT NULL COMMENT '�Ż�ȯ����',
  `coupon_type` enum('1','2') default NULL COMMENT '',
  `coupon_pic` varchar(255) NOT NULL COMMENT '',
  `coupon_desc` varchar(255) NOT NULL COMMENT '�Ż�ȯ����',
  `coupon_start_date` int(10) NOT NULL COMMENT '�Ż�ȯ��ʼ����',
  `coupon_end_date` int(10) NOT NULL COMMENT '�Ż�ȯ��ֹ����',
  `coupon_price` decimal(10,2) NOT NULL default '0.00' COMMENT '�Żݽ��',
  `coupon_limit` decimal(10,2) NOT NULL default '0.00' COMMENT '�������',
  `store_id` int(11) default NULL COMMENT '����id',
  `coupon_state` enum('1','2') default '1' COMMENT '�ϼ����¼�״̬',
  `coupon_storage` int(11) NOT NULL default '0' COMMENT '�ܹ�����',
  `coupon_usage` int(11) NOT NULL default '0' COMMENT 'ʹ������',
  `coupon_lock` enum('1','2') NOT NULL default '1' COMMENT '�Ƿ�����',
  `coupon_add_date` int(10) NOT NULL COMMENT '�������',
  `coupon_class_id` int(11) NOT NULL COMMENT '����',
  `coupon_click` int(11) NOT NULL default '1' COMMENT '�������',
  `coupon_print_style` varchar(255) NOT NULL default '4STYLE' COMMENT '4STYLE STANDS FOR 4 COUPONS PER A4 PAGE, AND 8STYLE STANDS FOR 8 COUPONS PER A4 PAGE',
  `coupon_recommend` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0���Ƽ� 1�Ƽ�����ҳ',
  `coupon_allowstate` tinyint(1) unsigned DEFAULT '1' COMMENT '���״̬ 0Ϊ����� 1��ͨ�� 2δͨ��',
  `coupon_allowremark` varchar(255) NULL COMMENT '��˱�ע',
  PRIMARY KEY  (`coupon_id`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='�Ż�ȯ';

CREATE TABLE `#__coupon_class` (
  `class_id` int(11) NOT NULL auto_increment COMMENT '�Ż�ȯ����id',
  `class_parent_id` int(11) NOT NULL default '0' COMMENT '����id',
  `class_name` varchar(100) NOT NULL COMMENT '��������',
  `class_sort` tinyint(1) unsigned NOT NULL default '0' COMMENT '����',
  `class_show` enum('0','1') NOT NULL default '0' COMMENT '�Ƿ���ʾ',
  PRIMARY KEY  (`class_id`),
  KEY `class_parent_id` (`class_parent_id`),
  KEY `class_sort` (`class_sort`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='�Ż�ȯ����';

CREATE TABLE `#__daddress` (
  `address_id` mediumint(10) unsigned NOT NULL auto_increment COMMENT '��ַID',
  `store_id` mediumint(10) unsigned NOT NULL default '0' COMMENT '����ID',
  `seller_name` varchar(50) NOT NULL default '' COMMENT '��ϵ��',
  `area_id` mediumint(10) unsigned NOT NULL default '0' COMMENT '����ID',
  `city_id` mediumint(9) default NULL COMMENT '�м�ID',
  `area_info` varchar(255) NOT NULL default '' COMMENT '��������',
  `address` varchar(255) NOT NULL COMMENT '��ַ',
  `zip_code` char(6) default NULL COMMENT '�ʱ�',
  `tel_phone` varchar(20) default NULL COMMENT '�����绰',
  `mob_phone` varchar(15) default NULL COMMENT '�ֻ��绰',
  `company` varchar(255) NOT NULL COMMENT '��˾',
  `content` text COMMENT '��ע',
  `is_default` enum('0','1') NOT NULL default '0' COMMENT '�Ƿ�Ĭ��1��',
  PRIMARY KEY  (`address_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='���ҷ�����ַ��Ϣ��';

CREATE TABLE `#__document` (
  `doc_id` mediumint(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `doc_code` varchar(255) NOT NULL COMMENT '���ñ�ʶ��',
  `doc_title` varchar(255) NOT NULL COMMENT '����',
  `doc_content` text NOT NULL COMMENT '����',
  `doc_time` int(10) unsigned NOT NULL COMMENT '���ʱ��/�޸�ʱ��',
  PRIMARY KEY (`doc_id`),
  UNIQUE KEY `doc_code` (`doc_code`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='ϵͳ���±�';

CREATE TABLE `#__evaluate_goods` (
  `geval_id` int(11) NOT NULL auto_increment COMMENT '����ID',
  `geval_orderid` int(11) NOT NULL COMMENT '����������ID',
  `geval_orderno` bigint(20) unsigned NOT NULL COMMENT '�������',
  `geval_ordergoodsid` int(11) NOT NULL COMMENT '������Ʒ����',
  `geval_goodsid` int(11) NOT NULL COMMENT '��Ʒ����',
  `geval_goodsname` varchar(100) NOT NULL COMMENT '��Ʒ����',
  `geval_specinfo` varchar(50) default NULL COMMENT '�������',
  `geval_goodsprice` decimal(10,2) default NULL COMMENT '��Ʒ�۸�',
  `geval_scores` tinyint(1) NOT NULL COMMENT '1������� 0�������� -1�������',
  `geval_content` varchar(255) default NULL COMMENT '������������',
  `geval_isanonymous` tinyint(1) NOT NULL default '0' COMMENT '0��ʾ���� 1��ʾ����������',
  `geval_addtime` int(11) NOT NULL COMMENT '����ʱ��',
  `geval_storeid` int(11) NOT NULL COMMENT '���̱��',
  `geval_storename` varchar(100) NOT NULL COMMENT '��������',
  `geval_frommemberid` int(11) NOT NULL COMMENT '�����˱��',
  `geval_frommembername` varchar(100) NOT NULL COMMENT '����������',
  `geval_tomemberid` int(11) NOT NULL COMMENT '�����˱��',
  `geval_tomembername` varchar(100) NOT NULL COMMENT '�������û���',
  `geval_state` tinyint(1) NOT NULL default '0' COMMENT '������Ϣ��״̬ 0Ϊ���� 1Ϊ��ֹ��ʾ',
  `geval_remark` varchar(255) default NULL COMMENT '����Ա�����۵Ĵ���ע',
  `geval_explain` varchar(255) default NULL COMMENT '��������',
  `geval_bothstate` tinyint(1) NOT NULL default '1' COMMENT '���ۻ���״̬ 1��������2˫������',
  `geval_showtime` int(11) NOT NULL COMMENT '����չʾʱ��ͳ�Ƶȶ��Ը�ֵΪ׼',
  `geval_type` tinyint(1) NOT NULL default '1' COMMENT '�������� 1������� 2��������',
  PRIMARY KEY  (`geval_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='�������۱�';

CREATE TABLE `#__evaluate_goodsstat` (
  `gevalstat_id` int(11) NOT NULL auto_increment COMMENT '����ID',
  `gevalstat_storeid` int(11) NOT NULL COMMENT '����ID',
  `gevalstat_type` tinyint(1) NOT NULL COMMENT 'ͳ������ 1���һ�� 2���һ�� 3������� 4������ǰ 5�ܼ�¼',
  `gevalstat_level1num` int(11) NOT NULL default '0' COMMENT '��������',
  `gevalstat_level2num` int(11) NOT NULL default '0' COMMENT '��������',
  `gevalstat_level3num` int(11) NOT NULL default '0' COMMENT '��������',
  PRIMARY KEY  (`gevalstat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='��Ʒ����ͳ�Ʊ�';

CREATE TABLE `#__evaluate_store` (
  `seval_id` int(11) NOT NULL auto_increment COMMENT '����ID',
  `seval_orderid` int(11) NOT NULL COMMENT '����ID',
  `seval_orderno` varchar(100) NOT NULL COMMENT '�������',
  `seval_type` tinyint(1) NOT NULL COMMENT '��������  1��ʾ��������������� 2��ʾ���ҷ���̬�� 3��ʾ���ҷ����ٶ�',
  `seval_scores` tinyint(1) NOT NULL default '0' COMMENT '���۷���',
  `seval_addtime` int(11) NOT NULL COMMENT '����ʱ��',
  `seval_storeid` int(11) NOT NULL COMMENT '���̱��',
  `seval_storename` varchar(100) NOT NULL COMMENT '��������',
  `seval_memberid` int(11) NOT NULL COMMENT '��ұ��',
  `seval_membername` varchar(100) NOT NULL COMMENT '�������',
  PRIMARY KEY  (`seval_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='�������ֱ�';

CREATE TABLE `#__evaluate_storestat` (
  `evalstat_id` int(11) NOT NULL auto_increment COMMENT 'ͳ��ID',
  `evalstat_storeid` int(11) NOT NULL COMMENT '����ID',
  `evalstat_type` tinyint(1) NOT NULL COMMENT 'ͳ������ 1��ʾ��������������� 2��ʾ���ҷ���̬�� 3��ʾ���ҷ����ٶ�',
  `evalstat_average` float NOT NULL default '0' COMMENT 'ƽ����',
  `evalstat_timesnum` int(11) NOT NULL default '0' COMMENT '���۴���',
  `evalstat_onenum` int(11) NOT NULL default '0' COMMENT 'һ�Ǵ���',
  `evalstat_twonum` int(11) NOT NULL default '0' COMMENT '���Ǵ���',
  `evalstat_threenum` int(11) NOT NULL default '0' COMMENT '���Ǵ���',
  `evalstat_fournum` int(11) NOT NULL default '0' COMMENT '���Ǵ���',
  `evalstat_fivenum` int(11) NOT NULL default '0' COMMENT '���Ǵ���',
  PRIMARY KEY  (`evalstat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='��������ͳ�Ʊ�';

CREATE TABLE `#__express` (
  `id` tinyint(1) unsigned NOT NULL auto_increment COMMENT '����ID',
  `e_name` varchar(50) NOT NULL COMMENT '��˾����',
  `e_state` enum('0','1') NOT NULL default '1' COMMENT '״̬',
  `e_code` varchar(50) NOT NULL COMMENT '���',
  `e_letter` char(1) NOT NULL COMMENT '����ĸ',
  `e_order` enum('1','2') NOT NULL default '2' COMMENT '1����2������',
  `e_url` varchar(100) NOT NULL COMMENT '��˾��ַ',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='��ݹ�˾';

CREATE TABLE `#__favorites` (
  `member_id` int(10) unsigned NOT NULL COMMENT '��ԱID',
  `fav_id` int(10) unsigned NOT NULL COMMENT '�ղ�ID',
  `fav_type` varchar(20) NOT NULL COMMENT '�ղ�����',
  `fav_time` int(10) unsigned NOT NULL COMMENT '�ղ�ʱ��'
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='����ղر�';

CREATE TABLE `#__flowstat_1` (
  `date` int(8) unsigned NOT NULL COMMENT '��������',
  `clicknum` int(11) unsigned NOT NULL COMMENT '������',
  `store_id` int(11) unsigned NOT NULL COMMENT '����ID',
  `type` varchar(10) NOT NULL COMMENT '����',
  `goods_id` int(11) unsigned NOT NULL COMMENT '��ƷID'
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='������ͳ�Ʊ�';

CREATE TABLE `#__flowstat_2` (
  `date` int(8) unsigned NOT NULL COMMENT '��������',
  `clicknum` int(11) unsigned NOT NULL COMMENT '������',
  `store_id` int(11) unsigned NOT NULL COMMENT '����ID',
  `type` varchar(10) NOT NULL COMMENT '����',
  `goods_id` int(11) unsigned NOT NULL COMMENT '��ƷID'
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='������ͳ�Ʊ�';

CREATE TABLE `#__flowstat_3` (
  `date` int(8) unsigned NOT NULL COMMENT '��������',
  `clicknum` int(11) unsigned NOT NULL COMMENT '������',
  `store_id` int(11) unsigned NOT NULL COMMENT '����ID',
  `type` varchar(10) NOT NULL COMMENT '����',
  `goods_id` int(11) unsigned NOT NULL COMMENT '��ƷID'
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='������ͳ�Ʊ�';

CREATE TABLE `#__flowstat_4` (
  `date` int(8) unsigned NOT NULL COMMENT '��������',
  `clicknum` int(11) unsigned NOT NULL COMMENT '������',
  `store_id` int(11) unsigned NOT NULL COMMENT '����ID',
  `type` varchar(10) NOT NULL COMMENT '����',
  `goods_id` int(11) unsigned NOT NULL COMMENT '��ƷID'
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='������ͳ�Ʊ�';

CREATE TABLE `#__flowstat_5` (
  `date` int(8) unsigned NOT NULL COMMENT '��������',
  `clicknum` int(11) unsigned NOT NULL COMMENT '������',
  `store_id` int(11) unsigned NOT NULL COMMENT '����ID',
  `type` varchar(10) NOT NULL COMMENT '����',
  `goods_id` int(11) unsigned NOT NULL COMMENT '��ƷID'
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='������ͳ�Ʊ�';

CREATE TABLE `#__gold_buy` (
  `gbuy_id` int(11) NOT NULL auto_increment COMMENT '����id',
  `gbuy_mid` int(11) NOT NULL COMMENT '�����Ա���',
  `gbuy_membername` varchar(50) NOT NULL COMMENT '��Ա����',
  `gbuy_storeid` int(11) NOT NULL COMMENT '���̱��',
  `gbuy_storename` varchar(50) NOT NULL COMMENT '��������',
  `gbuy_num` int(11) NOT NULL default '0' COMMENT '����������',
  `gbuy_price` decimal(10,2) NOT NULL COMMENT '������������',
  `gbuy_addtime` int(11) NOT NULL COMMENT '�����¼���ʱ��',
  `gbuy_ispay` tinyint(4) NOT NULL default '0' COMMENT '�Ƿ��Ѿ�֧�� 0 δ֧�� 1��֧��',
  `gbuy_adminid` int(11) default NULL COMMENT '������¼����Ա���',
  `gbuy_sys_remark` varchar(255) default NULL COMMENT '������ע',
  `gbuy_user_remark` varchar(255) default NULL COMMENT '�û���ע',
  `gbuy_check_type` varchar(100) default NULL COMMENT '�����ҵ�֧������',
  PRIMARY KEY  (`gbuy_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='��ҹ����¼��';

CREATE TABLE `#__gold_log` (
  `glog_id` int(11) NOT NULL auto_increment COMMENT '�������',
  `glog_memberid` int(11) NOT NULL COMMENT '��Ա���',
  `glog_membername` varchar(50) NOT NULL COMMENT '��Ա����',
  `glog_storeid` int(11) NOT NULL COMMENT '���̱��',
  `glog_storename` varchar(50) NOT NULL COMMENT '��������',
  `glog_adminid` int(11) NOT NULL COMMENT '����Ա��ţ����û�й���Ա�����Ϊ0',
  `glog_adminname` varchar(20) NOT NULL COMMENT '����Ա����',
  `glog_goldnum` int(11) NOT NULL default '0' COMMENT '�����',
  `glog_method` tinyint(4) NOT NULL default '1' COMMENT '���������ʽ 1���� 2����',
  `glog_addtime` int(11) NOT NULL COMMENT '���ʱ��',
  `glog_desc` varchar(255) default NULL COMMENT '��������',
  `glog_stage` varchar(20) NOT NULL default 'system' COMMENT '��������',
  PRIMARY KEY  (`glog_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='�����־��';

CREATE TABLE `#__gold_payment` (
  `payment_id` tinyint(1) unsigned NOT NULL COMMENT '֧������id',
  `payment_code` char(10) NOT NULL COMMENT '֧����������',
  `payment_name` varchar(20) NOT NULL COMMENT '֧������',
  `payment_info` varchar(255) default NULL COMMENT '֧���ӿڽ���',
  `payment_config` text COMMENT '֧���ӿ�������Ϣ',
  `payment_online` tinyint(1) unsigned default '0' COMMENT '�Ƿ�Ϊ���߽ӿڣ�1�ǣ�0��',
  `payment_state` tinyint(1) unsigned default '1' COMMENT '�ӿ�״̬��1���ã�2������',
  `payment_sort` tinyint(1) unsigned default '3' COMMENT '֧������',
  PRIMARY KEY  (`payment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='���֧����ʽ��';

CREATE TABLE `#__goods` (
  `goods_id` int(10) unsigned NOT NULL auto_increment COMMENT '��Ʒ����id',
  `goods_name` varchar(100) NOT NULL COMMENT '��Ʒ����',
  `gc_id` int(10) unsigned NOT NULL COMMENT '��Ʒ����id',
  `gc_name` varchar(200) NOT NULL COMMENT '��Ʒ��������',
  `brand_id` mediumint(8) unsigned NOT NULL default '0' COMMENT '��ƷƷ��id',
  `type_id` int(10) unsigned NOT NULL default '0' COMMENT '����id',
  `store_id` int(10) unsigned NOT NULL COMMENT '����id',
  `spec_open` tinyint(1) NOT NULL default '0' COMMENT '��Ʒ�����״̬��1������0�ر�',
  `spec_id` int(11) NOT NULL COMMENT '��ƷĬ�϶�Ӧ�Ĺ��id',
  `spec_name` varchar(255) NOT NULL default '' COMMENT '�������',
  `goods_image` varchar(100) NOT NULL COMMENT '��ƷĬ�Ϸ���ͼƬ',
  `goods_image_more` text COMMENT '��Ʒ��ͼ',
  `goods_store_price` decimal(10,2) NOT NULL COMMENT '��Ʒ���̼۸�',
  `goods_store_price_interval` varchar(30) NOT NULL default '' COMMENT '��Ʒ�۸�����',
  `goods_serial` varchar(50) NOT NULL default '' COMMENT '��Ʒ����',
  `goods_show` tinyint(1) NOT NULL COMMENT '��Ʒ�ϼ�',
  `goods_click` int(11) NOT NULL default '1' COMMENT '��Ʒ�����',
  `goods_state` tinyint(1) NOT NULL default '0' COMMENT '��Ʒ״̬��0������1Υ���¼�',
  `goods_commend` tinyint(1) NOT NULL COMMENT '��Ʒ�Ƽ�',
  `goods_add_time` int(10) unsigned NOT NULL default '0' COMMENT '��Ʒ���ʱ��',
  `goods_keywords` varchar(255) NOT NULL default '' COMMENT '��Ʒ�ؼ���',
  `goods_description` varchar(255) NOT NULL default '' COMMENT '��Ʒ����',
  `goods_body` text NOT NULL COMMENT '��Ʒ��ϸ����',
  `goods_attr` text COMMENT '��Ʒ����',
  `goods_spec` text COMMENT '��Ʒ���',
  `goods_col_img` text COMMENT '��ɫ�Զ���ͼƬ',
  `goods_starttime` int(10) unsigned NOT NULL default '0' COMMENT '������ʼʱ��',
  `goods_endtime` int(10) unsigned NOT NULL default '0' COMMENT '��������ʱ��',
  `goods_form` tinyint(1) unsigned NOT NULL default '1' COMMENT '��Ʒ����,1Ϊȫ�¡�2Ϊ����',
  `transport_id` mediumint(8) unsigned default '0' COMMENT '�˷�ģ��ID����ʹ���˷�ģ��ֵΪ0',
  `py_price` decimal(10,2) default '0.00' COMMENT 'ƽ��',
  `kd_price` decimal(10,2) default '0.00' COMMENT '���',
  `es_price` decimal(10,2) default '0.00' COMMENT 'EMS',
  `city_id` mediumint(8) unsigned default '0' COMMENT '��Ʒ���ڵ�(��)',
  `province_id` mediumint(8) unsigned default '0' COMMENT '��Ʒ���ڵ�(ʡ)',
  `goods_close_reason` varchar(255) default NULL COMMENT '��ƷΥ���¼�ԭ��',
  `goods_store_state` tinyint(1) NOT NULL default '0' COMMENT '��Ʒ���ڵ���״̬ 0���� 1�ر�',
  `commentnum` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '���۴���',
  `salenum` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '�۳�����',
  `goods_collect` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '��Ʒ�ղ�����',
  `goods_goldnum` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'ֱͨ��ʣ���Ҷ�',
  `goods_isztc` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�Ƿ���ֱͨ����Ʒ 0���� 1��ֱͨ����Ʒ',
  `goods_ztcstate` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'ֱͨ��״̬  1��ʾ���� 2��ʾ��ֹ',
  `goods_ztcstartdate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '��ʼʱ��',
  `goods_ztclastdate` int(10) unsigned NULL COMMENT '������ѽ�ҵ�ʱ�� ���û�����õĻ�����û�м�������',
  `group_flag` tinyint(1) unsigned NULL DEFAULT '0' COMMENT '�Ź���ʶ(�Ź�1/���Ź�0)',
  `group_price` decimal(10,2) NOT NULL default '0.00' COMMENT '�Ź��۸�',
  `xianshi_flag` tinyint(1) unsigned NOT NULL default '0' COMMENT '��ʱ�ۿ���Ʒ��־(1-��/0-����)',
  `xianshi_discount` decimal(10,2) NOT NULL default '0.00' COMMENT '��ʱ�ۿ���',
  `goods_transfee_charge` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '��Ʒ�˷ѳе���ʽ Ĭ�� 0Ϊ��ҳе� 1Ϊ���ҳе�',
  PRIMARY KEY  (`goods_id`),
  KEY `store_id` (`store_id`),
  KEY `gc_id` (`gc_id`),
  KEY `goods_starttime` (`goods_starttime`),
  KEY `brand_id` (`brand_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='��Ʒ��';

CREATE TABLE `#__goods_attr_index` (
	`goods_id` int(10) unsigned NOT NULL COMMENT '��Ʒid',
	`gc_id` int(10) unsigned NOT NULL COMMENT '��Ʒ����id',
	`type_id` int(10) unsigned NOT NULL COMMENT '����id',
	`attr_id` int(10) unsigned NOT NULL COMMENT '����id',
	`attr_value_id` int(10) unsigned NOT NULL COMMENT '����ֵid',
	PRIMARY KEY (`goods_id`,`gc_id`,`attr_value_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='��Ʒ�����Զ�Ӧ��';

CREATE TABLE `#__goods_class` (
  `gc_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '����ID',
  `gc_name` varchar(100) NOT NULL COMMENT '��������',
  `type_id` int(10) unsigned NOT NULL COMMENT '����id',
  `type_name` varchar(100) NOT NULL COMMENT '��������',
  `store_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '����ID��0Ϊϵͳ��̨����',
  `gc_parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '��ID',
  `gc_sort` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '����',
  `gc_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'ǰ̨��ʾ��0Ϊ��1Ϊ�ǣ�Ĭ��Ϊ1',
  `gc_title` varchar(200) NOT NULL COMMENT '����',
  `gc_keywords` varchar(255) NOT NULL default '' COMMENT '�ؼ���',
  `gc_description` varchar(255) NOT NULL default '' COMMENT '����',
  PRIMARY KEY (`gc_id`),
  KEY `store_id` (`store_id`,`gc_parent_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='��Ʒ�����';

CREATE TABLE `#__goods_class_staple` (
	`staple_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '���÷���id',
	`staple_name` varchar(255) NOT NULL COMMENT '���÷�������',
	`gc_id` int(10) unsigned NOT NULL COMMENT '����id',
	`type_id` int(10) unsigned NOT NULL COMMENT '����id',
	`store_id` int(10) unsigned NOT NULL COMMENT '��������id',
  PRIMARY KEY (`staple_id`),
	KEY `store_id` (`store_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='���̳��÷����';

CREATE TABLE `#__goods_class_tag` (
	`gc_tag_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'TAGid',
	`gc_id_1` int(10) unsigned NOT NULL COMMENT 'һ������id',
	`gc_id_2` int(10) unsigned NOT NULL COMMENT '��������id',
	`gc_id_3` int(10) unsigned NOT NULL COMMENT '��������id',
	`gc_tag_name` varchar(255) NOT NULL COMMENT '����TAG����',
	`gc_tag_value` text NOT NULL COMMENT '����TAGֵ',
	`gc_id` int(10) unsigned NOT NULL COMMENT '��Ʒ����id',
	`type_id` int(10) unsigned NOT NULL COMMENT '����id',
  PRIMARY KEY (`gc_tag_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='��Ʒ����TAG��';

CREATE TABLE `#__goods_group` (
  `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '�Ź�ID',
  `group_name` varchar(255) NOT NULL COMMENT '�����',
  `template_id` int(10) unsigned NOT NULL COMMENT '�Ź�����',
  `template_name` varchar(50) NOT NULL COMMENT '�Ź������',
  `group_help` varchar(255) DEFAULT NULL COMMENT '�˵��',
  `start_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '��ʼʱ��',
  `end_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '����ʱ��',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '��ƷID',
  `goods_name` varchar(200) NOT NULL COMMENT  '��Ʒ����',
  `store_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '����ID',
  `store_name` varchar(50) NOT NULL COMMENT  '��������',
  `spec_price` varchar(255) NOT NULL COMMENT '���۸�',
  `goods_price` decimal(10,2) NOT NULL COMMENT  '��Ʒԭ��',
  `groupbuy_price` decimal(10,2) NOT NULL COMMENT  '�Ź��۸�',
  `limit_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�������� 1.�������� 2.���ռ���',
  `virtual_quantity` int(10) unsigned NOT NULL COMMENT  '���⹺������',
  `buyer_count` int(10) unsigned NOT NULL COMMENT  '�ѹ�������',
  `def_quantity` int(10) NOT NULL DEFAULT '0' COMMENT '�Ѷ�����',
  `min_quantity` int(10) NOT NULL DEFAULT '0' COMMENT '��С�Ź�����',
  `sale_quantity` int(10) NOT NULL DEFAULT '0' COMMENT 'ÿ���޹�����',
  `max_num` int(10) NOT NULL DEFAULT '0' COMMENT '��߼���',
  `group_intro` text DEFAULT NULL COMMENT '���Ž���',
  `state` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '�Ź�״̬ 1.δ���� 2.��ȡ�� 3.������ 4.����� 5.�ѽ���',
  `recommended` tinyint(1) unsigned NOT NULL COMMENT '�Ƿ��Ƽ� 0.δ�Ƽ� 1.���Ƽ�',
  `published` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�Ƿ񷢲� 1.δ���� 2.�ѷ���',
  `views` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '�鿴����',
  `cancel_intro` varchar(255) DEFAULT NULL COMMENT 'ȡ��˵��',
  `class_id` int(10) unsigned NOT NULL COMMENT  '�Ź������',
  `area_id` int(10) unsigned NOT NULL COMMENT  '�Ź��������',
  `group_pic` varchar(100) NOT NULL COMMENT  '�Ź�ͼƬ',
  `rebate` decimal(10,2) NOT NULL COMMENT '�ۿ���',
  `remark` varchar(255) NOT NULL COMMENT '��ע',
  PRIMARY KEY (`group_id`),
  KEY `template_id` (`template_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='�Ź���Ʒ��';

CREATE TABLE `#__goods_spec` (
  `spec_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '��Ʒ�������id',
  `goods_id` int(11) NOT NULL COMMENT '��Ʒid',
  `spec_name` varchar(255) NOT NULL COMMENT '�������',
  `spec_goods_price` decimal(10,2) NOT NULL COMMENT '�����Ʒ�۸�',
  `spec_goods_storage` int(11) NOT NULL COMMENT '�����Ʒ���',
  `spec_salenum` int NOT NULL DEFAULT '0' COMMENT '�۳�����',
  `spec_goods_color` varchar(20) NOT NULL COMMENT '�����Ʒ��ɫ',
  `spec_goods_serial` varchar(50) NOT NULL COMMENT '�����Ʒ���',
  `spec_goods_spec` text NOT NULL COMMENT '��Ʒ������л�',
  PRIMARY KEY (`spec_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='��Ʒ����';

CREATE TABLE `#__goods_spec_index` (
	`goods_id` int(10) unsigned NOT NULL COMMENT '��Ʒid',
	`gc_id` int(10) unsigned NOT NULL COMMENT '��Ʒ����id',
	`type_id` int(10) unsigned NOT NULL COMMENT '����id',
	`sp_id` int(10) unsigned NOT NULL COMMENT '���id',
	`sp_value_id` int(10) unsigned NOT NULL COMMENT '���ֵid',
	`sp_value_name` varchar(100) NULL COMMENT '���ֵ����',
	PRIMARY KEY (`goods_id`,`gc_id`,`sp_value_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='��Ʒ�����Ӧ��';

CREATE TABLE  `#__groupbuy_area` (
	`area_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT  '�������',
	`area_name` varchar(50) NOT NULL COMMENT  '��������',
	`area_parent_id` int(10) unsigned NOT NULL COMMENT  '���������',
	`area_sort` tinyint(1) unsigned NOT NULL COMMENT  '����',
	`area_deep` tinyint(1) unsigned NOT NULL COMMENT  '���',
	PRIMARY KEY (`area_id`)
) ENGINE=MYISAM  DEFAULT CHARSET=gbk COMMENT='�Ź�������';

CREATE TABLE `#__groupbuy_class` (
  `class_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '�����',
  `class_name` varchar(20) NOT NULL COMMENT '�������',
  `class_parent_id` int(10) unsigned NOT NULL COMMENT '�������',
  `sort` tinyint(1) unsigned NOT NULL COMMENT '����',
  `deep` tinyint(1) unsigned NOT NULL COMMENT '���',
  PRIMARY KEY (`class_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='�Ź�����';

CREATE TABLE `#__groupbuy_price_range` (
  `range_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '�۸�������',
  `range_name` varchar(20) NOT NULL COMMENT '��������',
  `range_start` int(10) unsigned NOT NULL COMMENT '��������',
  `range_end` int(10) unsigned NOT NULL COMMENT '��������',
  PRIMARY KEY (`range_id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='�Ź��۸������';

CREATE TABLE `#__groupbuy_template` (
  `template_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '�Ź�����',
  `template_name` varchar(50) NOT NULL COMMENT '�Ź���ܹ�����',
  `start_time` int(10) unsigned NOT NULL COMMENT '���ʼʱ��',
  `end_time` int(10) unsigned NOT NULL COMMENT '�����ʱ��',
  `join_end_time` int(10) unsigned NOT NULL COMMENT '���������ʱ��',
  `state` tinyint(1) unsigned NOT NULL COMMENT '״̬(1-�ɱ���/2-�ѹ���)',
  PRIMARY KEY (`template_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='�Ź����';

CREATE TABLE `#__inform` (
  `inform_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '�ٱ�id',
  `inform_member_id` int(11) NOT NULL COMMENT '�ٱ���id',
  `inform_member_name` varchar(50) NOT NULL COMMENT '�ٱ��˻�Ա��',
  `inform_goods_id` int(11) NOT NULL COMMENT '���ٱ�����Ʒid',
  `inform_goods_name` varchar(100) NOT NULL COMMENT '���ٱ�����Ʒ����',
  `inform_subject_id` int(11) NOT NULL COMMENT '�ٱ�����id',
  `inform_subject_content` varchar(50) NOT NULL COMMENT '�ٱ�����',
  `inform_content` varchar(100) NOT NULL COMMENT '�ٱ���Ϣ',
  `inform_pic1` varchar(100) NOT NULL COMMENT 'ͼƬ1',
  `inform_pic2` varchar(100) NOT NULL COMMENT 'ͼƬ2',
  `inform_pic3` varchar(100) NOT NULL COMMENT 'ͼƬ3',
  `inform_datetime` int(11) NOT NULL COMMENT '�ٱ�ʱ��',
  `inform_store_id` int(11) NOT NULL COMMENT '���ٱ���Ʒ�ĵ���id',
  `inform_state` tinyint(4) NOT NULL COMMENT '�ٱ�״̬(1δ����/2�Ѵ���)',
  `inform_handle_type` tinyint(4) NOT NULL COMMENT '�ٱ�������(1��Ч�ٱ�/2����ٱ�/3��Ч�ٱ�)',
  `inform_handle_message` varchar(100) NOT NULL COMMENT '�ٱ�������Ϣ',
  `inform_handle_datetime` int(11) NOT NULL DEFAULT '0' COMMENT '�ٱ�����ʱ��',
  `inform_handle_member_id` int(11) NOT NULL DEFAULT '0' COMMENT '����Աid',
  PRIMARY KEY (`inform_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='�ٱ���';

CREATE TABLE `#__inform_subject` (
  `inform_subject_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '�ٱ�����id',
  `inform_subject_content` varchar(100) NOT NULL COMMENT '�ٱ���������',
  `inform_subject_type_id` int(11) NOT NULL COMMENT '�ٱ�����id',
  `inform_subject_type_name` varchar(50) NOT NULL COMMENT '�ٱ��������� ',
  `inform_subject_state` tinyint(11) NOT NULL COMMENT '�ٱ�����״̬(1����/2ʧЧ)',
  PRIMARY KEY (`inform_subject_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='�ٱ������';

CREATE TABLE `#__inform_subject_type` (
  `inform_type_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '�ٱ�����id',
  `inform_type_name` varchar(50) NOT NULL COMMENT '�ٱ��������� ',
  `inform_type_desc` varchar(100) NOT NULL COMMENT '�ٱ���������',
  `inform_type_state` tinyint(4) NOT NULL COMMENT '�ٱ�����״̬(1��Ч/2ʧЧ)',
  PRIMARY KEY (`inform_type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='�ٱ����ͱ�';

CREATE TABLE `#__link` (
  `link_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '����id',
  `link_title` varchar(100) DEFAULT NULL COMMENT '����',
  `link_url` varchar(100) DEFAULT NULL COMMENT '����',
  `link_pic` varchar(100) DEFAULT NULL COMMENT 'ͼƬ',
  `link_sort` tinyint(3) unsigned NOT NULL DEFAULT '255' COMMENT '����',
  PRIMARY KEY (`link_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='��������';

CREATE TABLE `#__mail_msg_temlates` (
  `name` varchar(100) NOT NULL COMMENT 'ģ������',
  `title` varchar(100) DEFAULT NULL COMMENT 'ģ�����',
  `code` varchar(100) NOT NULL COMMENT 'ģ����ô���',
  `content` text NOT NULL COMMENT 'ģ������',
  `type` tinyint(1) NOT NULL COMMENT 'ģ�����0Ϊ�ʼ���1Ϊ����Ϣ��Ĭ��Ϊ0',
  `mail_switch` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '�Ƿ���',
  PRIMARY KEY (`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='�ʼ�ģ���';

CREATE TABLE `#__map` (
  `map_id` int(11) NOT NULL auto_increment COMMENT '��ͼID',
  `member_id` int(11) NOT NULL COMMENT '��ԱID',
  `member_name` varchar(20) NOT NULL COMMENT '��Ա����',
  `area_id` int(11) NOT NULL COMMENT '����ID',
  `area_info` varchar(50) NOT NULL COMMENT '��������',
  `address` varchar(50) default NULL COMMENT '��ַ',
  `point_lng` float NOT NULL default '0' COMMENT '������',
  `point_lat` float NOT NULL default '0' COMMENT '����γ��',
  `store_name` varchar(20) default NULL COMMENT '��������',
  `store_id` int(11) default '0' COMMENT '����ID',
  `map_api` char(9) NOT NULL default 'baidu' COMMENT '��ͼAPI(��ʱֻ��baidu)',
  PRIMARY KEY  (`map_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='��ͼ��';

CREATE TABLE `#__member` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '��Աid',
  `member_name` varchar(50) NOT NULL COMMENT '��Ա����',
  `member_truename` varchar(20) default NULL COMMENT '��ʵ����',
  `store_id` int(11) unsigned NOT NULL default '0' COMMENT '����id',
  `member_avatar` varchar(50) DEFAULT NULL COMMENT '��Աͷ��',
  `member_sex` tinyint(1) DEFAULT NULL COMMENT '��Ա�Ա�',
  `member_birthday` date DEFAULT NULL COMMENT '����',
  `member_passwd` varchar(32) NOT NULL COMMENT '��Ա����',
  `member_email` varchar(100) NOT NULL COMMENT '��Ա����',
  `member_qq` varchar(100) DEFAULT NULL COMMENT 'qq',
  `member_ww` varchar(100) DEFAULT NULL COMMENT '��������',
  `member_login_num` int(11) NOT NULL DEFAULT '1' COMMENT '��¼����',
  `member_time` varchar(10) NOT NULL COMMENT '��Աע��ʱ��',
  `member_login_time` varchar(10) NOT NULL COMMENT '��ǰ��¼ʱ��',
  `member_old_login_time` varchar(10) NOT NULL COMMENT '�ϴε�¼ʱ��',
  `member_login_ip` varchar(20) DEFAULT NULL COMMENT '��ǰ��¼ip',
  `member_old_login_ip` varchar(20) DEFAULT NULL COMMENT '�ϴε�¼ip',
  `member_goldnum` int(11) NOT NULL DEFAULT '0' COMMENT '�����',
  `member_goldnumcount` int(11) NOT NULL DEFAULT '0' COMMENT '����ӵ�й�������',
  `member_goldnumminus` int(11) NOT NULL DEFAULT '0' COMMENT '�Ѿ����ѽ����',
  `member_qqopenid` varchar(100) NULL COMMENT 'qq����id',
  `member_qqinfo` text NULL COMMENT 'qq�˺������Ϣ',
  `member_sinaopenid` varchar(100) NULL COMMENT '����΢����¼id',
  `member_sinainfo` text NULL COMMENT '�����˺������Ϣ���л�ֵ',
  `member_points` int(11) NOT NULL DEFAULT '0' COMMENT '��Ա����',
  `available_predeposit` decimal(10,2) NOT NULL DEFAULT '0' COMMENT 'Ԥ�����ý��',
  `freeze_predeposit` decimal(10,2) NOT NULL DEFAULT '0' COMMENT 'Ԥ������',
  `inform_allow` tinyint(1) NOT NULL default '1' COMMENT '�Ƿ�����ٱ�(1����/2������)',
  `is_buy` tinyint(1) NOT NULL default '1' COMMENT '��Ա�Ƿ��й���Ȩ�� 1Ϊ���� 0Ϊ�ر�',
  `is_allowtalk` tinyint(1) NOT NULL default '1' COMMENT '��Ա�Ƿ�����ѯ�ͷ���վ���ŵ�Ȩ�� 1Ϊ���� 0Ϊ�ر�',
  `member_state` tinyint(1) NOT NULL default '1' COMMENT '��Ա�Ŀ���״̬ 1Ϊ���� 0Ϊ�ر�',
  `member_credit` int(11) NOT NULL default '0' COMMENT '��Ա����',
  `member_snsvisitnum` int(11) NOT NULL default '0' COMMENT 'sns�ռ���ʴ���',
  `member_areaid` int(11) default NULL COMMENT '����ID',
  `member_cityid` int(11) default NULL COMMENT '����ID',
  `member_provinceid` int(11) default NULL COMMENT 'ʡ��ID',
  `member_areainfo` varchar(255) default NULL COMMENT '��������',
  PRIMARY KEY (`member_id`),
  KEY `member_name` (`member_name`,`store_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='��Ա��';

CREATE TABLE `#__message` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '����Ϣ����id',
  `message_parent_id` int(11) NOT NULL COMMENT '�ظ�����Ϣmessage_id',
  `from_member_id` int(11) NOT NULL COMMENT '����Ϣ������',
  `to_member_id` varchar(1000) NOT NULL COMMENT '����Ϣ������',
  `message_title` varchar(50) DEFAULT NULL COMMENT '����Ϣ����',
  `message_body` varchar(255) NOT NULL COMMENT '����Ϣ����',
  `message_time` varchar(10) NOT NULL COMMENT '����Ϣ����ʱ��',
  `message_update_time` varchar(10) DEFAULT NULL COMMENT '����Ϣ�ظ�����ʱ��',
  `message_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '����Ϣ��״̬',
  `message_state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '����Ϣ״̬��0Ϊ����״̬��1Ϊ������ɾ��״̬��2Ϊ������ɾ��״̬',
  `message_type` tinyint(1) NOT NULL default '0' COMMENT '0Ϊ˽�š�1Ϊϵͳ��Ϣ��2Ϊ����',
  `read_member_id` varchar(1000) NULL COMMENT '�Ѿ���������Ϣ�Ļ�Աid',
  `del_member_id` varchar(1000) NULL COMMENT '�Ѿ�ɾ������Ϣ�Ļ�Աid',
  `message_ismore` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'վ�����Ƿ�Ϊһ����������û� 0Ϊ�� 1Ϊ���� ',
  `from_member_name` varchar(100)  NULL COMMENT '����Ϣ���û���',
  `to_member_name` varchar(100) NULL COMMENT '�������û���',
  PRIMARY KEY (`message_id`),
  KEY `from_member_id` (`from_member_id`),
  KEY `to_member_id` (`to_member_id`),
  KEY `message_ismore` (`message_ismore`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='����Ϣ';

CREATE TABLE `#__navigation` (
  `nav_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '����ID',
  `nav_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '���0�Զ��嵼����1��Ʒ���࣬2���µ�����3�������Ĭ��Ϊ0',
  `nav_title` varchar(100) DEFAULT NULL COMMENT '��������',
  `nav_url` varchar(255) DEFAULT NULL COMMENT '��������',
  `nav_location` tinyint(1) NOT NULL DEFAULT '0' COMMENT '����λ�ã�0ͷ����1�в���2�ײ���Ĭ��Ϊ0',
  `nav_new_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�Ƿ����´��ڴ򿪣�0Ϊ��1Ϊ�ǣ�Ĭ��Ϊ0',
  `nav_sort` tinyint(3) unsigned NOT NULL DEFAULT '255' COMMENT '����',
  `item_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '���ID����Ӧ��nav_type�е����ݣ�Ĭ��Ϊ0',
  PRIMARY KEY (`nav_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='ҳ�浼����';

CREATE TABLE `#__order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '��������id',
  `order_sn` bigint(20) unsigned NOT NULL COMMENT '������ţ��̳��ڲ�ʹ��',
  `seller_id` int(11) NOT NULL COMMENT '����id',
  `store_id` int(11) NOT NULL COMMENT '���ҵ���id',
  `store_name` varchar(50) NOT NULL COMMENT '���ҵ�������',
  `buyer_id` int(11) NOT NULL COMMENT '���id',
  `buyer_name` varchar(50) NOT NULL COMMENT '�������',
  `buyer_email` varchar(100) NOT NULL COMMENT '��ҵ�������',
  `add_time` varchar(10) NOT NULL COMMENT '��������ʱ��',
  `order_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�������� 0.��ͨ 1.�Ź�',
  `payment_id` int(11) NOT NULL COMMENT '֧����ʽid',
  `payment_name` varchar(50) NOT NULL COMMENT '֧����ʽ����',
  `payment_code` varchar(50) NOT NULL COMMENT '֧����ʽ���ƴ���',
  `payment_direct` char(1) NULL DEFAULT '1' COMMENT '֧������:1�Ǽ�ʱ����,2�ǵ�������',
  `out_sn` varchar(100) NOT NULL COMMENT '������ţ��ⲿ֧��ʱʹ�ã���Щ�ⲿ֧��ϵͳҪ���ض��Ķ������',
  `payment_time` varchar(10) DEFAULT NULL COMMENT '֧��(����)ʱ��',
  `pay_message` text COMMENT '֧������',
  `shipping_time` varchar(10) DEFAULT NULL COMMENT '����ʱ��',
  `shipping_express_id` tinyint(1) NOT NULL default '0' COMMENT '���͹�˾ID',
  `shipping_code` varchar(50) DEFAULT NULL COMMENT '��������',
  `out_payment_code` varchar(255) DEFAULT NULL COMMENT '�ⲿ����ƽ̨����ʹ�õı�ʶ�ַ���',
  `finnshed_time` varchar(10) DEFAULT NULL COMMENT '�������ʱ��',
  `invoice` varchar(100) DEFAULT NULL COMMENT '��Ʊ��Ϣ',
  `goods_amount` decimal(10,2) NOT NULL COMMENT '��Ʒ�ܼ۸�',
  `discount` decimal(10,2) DEFAULT NULL COMMENT '�ۿۼ۸�',
  `order_amount` decimal(10,2) NOT NULL COMMENT '�����ܼ۸�',
  `shipping_fee` decimal(10,2) default NULL COMMENT '�˷Ѽ۸�',
  `shipping_name` char(3) default '' COMMENT '���ͷ�ʽ',
  `evaluation_status` tinyint(1) DEFAULT NULL COMMENT '����״̬ 0Ϊ���ۣ�1������',
  `evaluation_time` varchar(10) DEFAULT NULL COMMENT '����ʱ��',
  `evalseller_status` tinyint(1) NOT NULL default '0' COMMENT '�����Ƿ����������',
  `evalseller_time` int(11) default NULL COMMENT '����������ҵ�ʱ��',
  `order_message` varchar(300) DEFAULT NULL COMMENT '��������',
  `order_state` int(11) NOT NULL DEFAULT '10' COMMENT '����״̬��10(Ĭ��):δ����;20:�Ѹ���;30:�ѷ���;40:���ջ�;50:���ύ;60��ȷ��;',
  `order_pointscount` int(11) NOT NULL DEFAULT '0' COMMENT '�������ͻ���',
  `voucher_id` int(11) NULL COMMENT '����ȯid',
  `voucher_price` int(11) NULL COMMENT '����ȯ���',
  `voucher_code` varchar(32) NULL COMMENT '����ȯ����',
  `refund_state` tinyint(1) unsigned NULL DEFAULT '0' COMMENT '�˿�״̬:0�����˿�,1�ǲ����˿�,2��ȫ���˿�',
  `return_state` tinyint(1) unsigned NULL DEFAULT '0' COMMENT '�˻�״̬:0�����˻�,1�ǲ����˻�,2��ȫ���˻�',
  `refund_amount` decimal(10,2) NULL DEFAULT '0.00' COMMENT '�˿���',
  `return_num` int(10) unsigned NULL DEFAULT '0' COMMENT '�˻�����',
  `group_id` int(10) unsigned NULL DEFAULT '0' COMMENT '�Ź����(���Ź�����Ϊ0)',
  `group_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '�Ź�����',
  `xianshi_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT ' ��ʱ�ۿ۱��',
  `xianshi_explain` varchar(100) NOT NULL DEFAULT '' COMMENT '��ʱ�ۿ�˵��',
  `mansong_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '�����ͱ��',
  `mansong_explain` varchar(200) NOT NULL DEFAULT '' COMMENT '������˵��',
  `bundling_id` int(10) default NULL COMMENT '�����ײ�id',
  `bundling_explain` varchar(100) default NULL COMMENT '�����ײ�˵��',
  `order_from` enum('1','2') default '1' COMMENT '1PC2�ֻ���',
  `deliver_explain` text COMMENT '������ע',
  `daddress_id` mediumint(9) NOT NULL default '0' COMMENT '������ַID',
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='������';

CREATE TABLE `#__order_address` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '����id',
  `true_name` varchar(50) NOT NULL COMMENT '�ջ�������',
  `area_id` int(11) NOT NULL COMMENT '����id',
  `area_info` varchar(100) NOT NULL COMMENT '��������',
  `address` varchar(100) NOT NULL COMMENT '��ϸ��ַ',
  `zip_code` char(6) NOT NULL COMMENT '��������',
  `tel_phone` varchar(20) NOT NULL COMMENT '�绰����',
  `mob_phone` varchar(20) NOT NULL COMMENT '�ֻ�����',
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='����������Ϣ��';

CREATE TABLE `#__order_goods` (
  `rec_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '������Ʒ������id',
  `order_id` int(11) NOT NULL COMMENT '����id',
  `goods_id` int(11) NOT NULL COMMENT '��Ʒid',
  `goods_name` varchar(100) NOT NULL COMMENT '��Ʒ����',
  `spec_id` int(11) NOT NULL COMMENT '���id',
  `spec_info` varchar(50) DEFAULT NULL COMMENT '�������',
  `goods_price` decimal(10,2) NOT NULL COMMENT '��Ʒ�۸�',
  `goods_num` smallint(5) unsigned NOT NULL default '1' COMMENT '��Ʒ����',
  `goods_image` varchar(100) DEFAULT NULL COMMENT '��ƷͼƬ',
  `goods_returnnum` smallint(5) unsigned NULL DEFAULT '0' COMMENT '�˻�����',
  `stores_id` mediumint(9) NOT NULL default '0' COMMENT '����ID',
  PRIMARY KEY (`rec_id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='������Ʒ��';

CREATE TABLE `#__order_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '����������ʷ����id',
  `order_id` int(11) NOT NULL COMMENT '����id',
  `order_state` varchar(20) NOT NULL COMMENT '����״̬��Ϣ',
  `change_state` varchar(20) NOT NULL COMMENT '��һ������״̬��Ϣ',
  `state_info` varchar(20) NOT NULL COMMENT '����״̬����',
  `log_time` int(10) unsigned NOT NULL default '0' COMMENT '����ʱ��',
  `operator` varchar(30) NOT NULL COMMENT '������',
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='����������ʷ��';

CREATE TABLE `#__payment` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '����֧������id',
  `payment_code` varchar(50) NOT NULL COMMENT '֧����������',
  `payment_name` varchar(50) NOT NULL COMMENT '֧������',
  `payment_info` varchar(255) DEFAULT NULL COMMENT '֧���ӿڽ���',
  `payment_config` text NOT NULL COMMENT '֧���ӿ�������Ϣ',
  `store_id` int(11) NOT NULL COMMENT '��Ӧ�ĵ���id',
  `payment_online` tinyint(1) NOT NULL COMMENT '�Ƿ�Ϊ���߽ӿڣ�1�ǣ�0��',
  `payment_state` tinyint(1) NOT NULL COMMENT '�ӿ�״̬��1���ã�2������',
  `payment_sort` int(11) NOT NULL COMMENT '֧������',
  PRIMARY KEY (`payment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='����֧���ӿ����ݱ�';

CREATE TABLE `#__points_cart` (
  `pcart_id` int(11) NOT NULL auto_increment COMMENT '����ID',
  `pmember_id` int(11) NOT NULL COMMENT '��Ա���',
  `pgoods_id` int(11) NOT NULL COMMENT '������Ʒ���',
  `pgoods_name` varchar(100) NOT NULL COMMENT '������Ʒ����',
  `pgoods_points` int(11) NOT NULL COMMENT '������Ʒ�һ�����',
  `pgoods_choosenum` int(11) NOT NULL COMMENT 'ѡ�������Ʒ����',
  `pgoods_image` varchar(100) default NULL COMMENT '������ƷͼƬ',
  PRIMARY KEY  (`pcart_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='������Ʒ�һ����ﳵ';

CREATE TABLE `#__points_goods` (
  `pgoods_id` int(11) NOT NULL auto_increment COMMENT '������Ʒ����id',
  `pgoods_name` varchar(100) NOT NULL COMMENT '������Ʒ����',
  `pgoods_price` decimal(10,2) NOT NULL default '0.00' COMMENT '������Ʒԭ��',
  `pgoods_points` int(11) NOT NULL COMMENT '������Ʒ�һ��������',
  `pgoods_image` varchar(100) NOT NULL COMMENT '������ƷĬ�Ϸ���ͼƬ',
  `pgoods_tag` varchar(100) NOT NULL COMMENT '������Ʒ��ǩ',
  `pgoods_serial` varchar(50) NOT NULL COMMENT '������Ʒ����',
  `pgoods_storage` int(11) NOT NULL default '0' COMMENT '������Ʒ�����',
  `pgoods_show` tinyint(1) NOT NULL COMMENT '������Ʒ�ϼ� 0��ʾ�¼� 1��ʾ�ϼ�',
  `pgoods_commend` tinyint(1) NOT NULL COMMENT '������Ʒ�Ƽ�',
  `pgoods_add_time` int(11) NOT NULL COMMENT '������Ʒ���ʱ��',
  `pgoods_keywords` varchar(100) default NULL COMMENT '������Ʒ�ؼ���',
  `pgoods_description` varchar(200) default NULL COMMENT '������Ʒ����',
  `pgoods_body` text NOT NULL COMMENT '������Ʒ��ϸ����',
  `pgoods_state` tinyint(1) NOT NULL default '0' COMMENT '������Ʒ״̬��0������1����',
  `pgoods_close_reason` varchar(255) default NULL COMMENT '������Ʒ����ԭ��',
  `pgoods_salenum` int(11) NOT NULL default '0' COMMENT '������Ʒ�۳�����',
  `pgoods_view` int(11) NOT NULL default '0' COMMENT '������Ʒ�������',
  `pgoods_islimit` tinyint(1) NOT NULL COMMENT '�Ƿ�����ÿ��Ա�һ�����',
  `pgoods_limitnum` int(11) default NULL COMMENT 'ÿ��Ա���ƶһ�����',
  `pgoods_freightcharge` tinyint(1) NOT NULL default '0' COMMENT '�˷ѳе���ʽ 0��ʾ���ҳе� 1��ʾ��ҳе�',
  `pgoods_freightprice` decimal(10,2) default NULL COMMENT '�˷Ѽ۸�',
  `pgoods_islimittime` tinyint(1) NOT NULL default '0' COMMENT '�Ƿ����ƶһ�ʱ�� 0Ϊ������ 1Ϊ����',
  `pgoods_starttime` int(11) default NULL COMMENT '�һ���ʼʱ��',
  `pgoods_endtime` int(11) default NULL COMMENT '�һ�����ʱ��',
  `pgoods_sort` int(11) NOT NULL default '0' COMMENT '��Ʒ����',
  PRIMARY KEY  (`pgoods_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='������Ʒ��';

CREATE TABLE `#__points_log` (
	`pl_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '������־���',
	`pl_memberid` int(11) NOT NULL COMMENT '��Ա���',
	`pl_membername` varchar(100) NOT NULL COMMENT '��Ա����',
	`pl_adminid` int(11) NULL COMMENT '����Ա���',
	`pl_adminname` varchar(100) NULL COMMENT '����Ա����',
	`pl_points` int(11) NOT NULL DEFAULT '0' COMMENT '������������ʾ�۳�',
	`pl_addtime` int(11) NOT NULL COMMENT '���ʱ��',
	`pl_desc` varchar(100) NOT NULL COMMENT '��������',
	`pl_stage` varchar(50) NOT NULL COMMENT '�����׶�',
	PRIMARY KEY (`pl_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='��Ա������־��';

CREATE TABLE `#__points_order` (
  `point_orderid` int(11) NOT NULL auto_increment COMMENT '�һ��������',
  `point_ordersn` varchar(100) NOT NULL COMMENT '�һ��������',
  `point_buyerid` int(11) NOT NULL COMMENT '�һ���Աid',
  `point_buyername` varchar(50) NOT NULL COMMENT '�һ���Ա����',
  `point_buyeremail` varchar(100) NOT NULL COMMENT '�һ���Աemail',
  `point_addtime` int(11) NOT NULL COMMENT '�һ���������ʱ��',
  `point_paymentid` int(11) NOT NULL COMMENT '֧����ʽid',
  `point_paymentname` varchar(50) NOT NULL COMMENT '֧����ʽ����',
  `point_paymentcode` varchar(50) NOT NULL COMMENT '֧����ʽ���ƴ���',
  `point_paymentdirect` tinyint(1) default '1' COMMENT '֧������:1�Ǽ�ʱ����,2�ǵ�������',
  `point_outsn` varchar(100) NOT NULL COMMENT '������ţ��ⲿ֧��ʱʹ�ã���Щ�ⲿ֧��ϵͳҪ���ض��Ķ������',
  `point_paymenttime` int(11) default NULL COMMENT '֧��(����)ʱ��',
  `point_paymessage` varchar(300) default NULL COMMENT '֧������',
  `point_shippingtime` int(11) default NULL COMMENT '����ʱ��',
  `point_shippingcode` varchar(50) default NULL COMMENT '��������',
  `point_shippingdesc` varchar(500) default NULL COMMENT '��������',
  `point_outpaymentcode` varchar(255) default NULL COMMENT '�ⲿ����ƽ̨����ʹ�õı�ʶ�ַ���',
  `point_finnshedtime` int(11) default NULL COMMENT '�������ʱ��',
  `point_allpoint` int(11) NOT NULL default '0' COMMENT '�һ��ܻ���',
  `point_orderamount` decimal(10,2) NOT NULL COMMENT '�һ������ܽ��',
  `point_shippingcharge` tinyint(1) NOT NULL default '0' COMMENT '�˷ѳе���ʽ 0��ʾ���� 1��ʾ���',
  `point_shippingfee` decimal(10,2) NOT NULL default '0.00' COMMENT '�˷ѽ��',
  `point_ordermessage` varchar(300) default NULL COMMENT '��������',
  `point_orderstate` int(11) NOT NULL default '10' COMMENT '����״̬��10(Ĭ��):δ����;11�Ѹ���;20:ȷ�ϸ���;30:�ѷ���;40:���ջ�;50�����;2��ȡ��',
  PRIMARY KEY  (`point_orderid`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='�һ�������';

CREATE TABLE `#__points_orderaddress` (
  `point_oaid` int(11) NOT NULL auto_increment COMMENT '����id',
  `point_orderid` int(11) NOT NULL COMMENT '����id',
  `point_truename` varchar(50) NOT NULL COMMENT '�ջ�������',
  `point_areaid` int(11) NOT NULL COMMENT '����id',
  `point_areainfo` varchar(100) NOT NULL COMMENT '��������',
  `point_address` varchar(200) NOT NULL COMMENT '��ϸ��ַ',
  `point_zipcode` varchar(20) NOT NULL COMMENT '��������',
  `point_telphone` varchar(20) NOT NULL COMMENT '�绰����',
  `point_mobphone` varchar(20) NOT NULL COMMENT '�ֻ�����',
  PRIMARY KEY  (`point_oaid`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='�һ�������ַ��';

CREATE TABLE `#__points_ordergoods` (
  `point_recid` int(11) NOT NULL auto_increment COMMENT '������Ʒ������',
  `point_orderid` int(11) NOT NULL COMMENT '����id',
  `point_goodsid` int(11) NOT NULL COMMENT '��Ʒid',
  `point_goodsname` varchar(100) NOT NULL COMMENT '��Ʒ����',
  `point_goodspoints` int(11) NOT NULL COMMENT '��Ʒ�һ�����',
  `point_goodsnum` int(11) NOT NULL COMMENT '��Ʒ����',
  `point_goodsimage` varchar(100) default NULL COMMENT '��ƷͼƬ',
  PRIMARY KEY  (`point_recid`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='�һ�������Ʒ��';

CREATE TABLE `#__predeposit_cash` (
  `pdcash_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '�������',
  `pdcash_sn` varchar(100) NOT NULL COMMENT '��¼Ψһ��ʾ',
  `pdcash_memberid` int(11) NOT NULL COMMENT '��Ա���',
  `pdcash_membername` varchar(50) NOT NULL COMMENT '��Ա����',
  `pdcash_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '���',
  `pdcash_payment` varchar(50) NOT NULL COMMENT '֧����ʽ',
  `pdcash_paymentaccount` varchar(100) DEFAULT NULL COMMENT '֧���˺�',
  `pdcash_toname` varchar(100) DEFAULT NULL COMMENT '�տ�������',
  `pdcash_tobank` varchar(100) DEFAULT NULL COMMENT '�տ�����',
  `pdcash_memberremark` varchar(1000) DEFAULT NULL COMMENT '��Ա���ֱ�ע',
  `pdcash_addtime` int(11) NOT NULL COMMENT '���ʱ��',
  `pdcash_paystate` tinyint(1) NOT NULL DEFAULT '0' COMMENT '����֧��״̬ 0Ϊδ֧�� 1Ϊ֧��',
  `pdcash_adminid` int(11) DEFAULT NULL COMMENT '����Ա���',
  `pdcash_adminname` varchar(100) DEFAULT NULL COMMENT '����Ա����',
  `pdcash_adminremark` varchar(1000) DEFAULT NULL COMMENT '����Ա��ע',
  `pdcash_remark` varchar(1000) DEFAULT NULL COMMENT '����Ա�ͻ�Ա���ɲ鿴�ı�ע',
  PRIMARY KEY (`pdcash_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='Ԥ������ּ�¼��';

CREATE TABLE `#__predeposit_log` (
  `pdlog_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '�������',
  `pdlog_memberid` int(11) NOT NULL COMMENT '��Ա���',
  `pdlog_membername` varchar(50) NOT NULL COMMENT '��Ա����',
  `pdlog_adminid` int(11) DEFAULT NULL COMMENT '����Ա���',
  `pdlog_adminname` varchar(50) DEFAULT NULL COMMENT '����Ա����',
  `pdlog_stage` enum('system','recharge','cash','order','admin','income','') NOT NULL default '' COMMENT '��־���� ö�� system ϵͳ�Զ� recharge ��ֵ cash ���� order ���� admin ����Ա�ֶ��޸� income����',
  `pdlog_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '��־���� 0��ʾ���ý�� 1��ʾ������',
  `pdlog_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '���',
  `pdlog_addtime` int(11) NOT NULL COMMENT '���ʱ��',
  `pdlog_desc` varchar(1000) DEFAULT NULL COMMENT '����',
  PRIMARY KEY (`pdlog_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='Ԥ�����־��';

CREATE TABLE `#__predeposit_recharge` (
  `pdr_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '�������',
  `pdr_sn` varchar(100) NOT NULL COMMENT '��¼Ψһ��ʾ',
  `pdr_memberid` int(11) NOT NULL COMMENT '��Ա���',
  `pdr_membername` varchar(50) NOT NULL COMMENT '��Ա����',
  `pdr_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '��ֵ���',
  `pdr_payment` varchar(50) DEFAULT NULL COMMENT '֧����ʽ',
  `pdr_onlinecode` varchar(100) DEFAULT NULL COMMENT '����֧���Ľ�����ˮ��',
  `pdr_remittancename` varchar(100) DEFAULT NULL COMMENT '���������',
  `pdr_remittancebank` varchar(100) DEFAULT NULL COMMENT '�������',
  `pdr_remittancedate` int(11) DEFAULT NULL COMMENT '�������',
  `pdr_memberremark` varchar(1000) DEFAULT NULL COMMENT '��Ա��ע',
  `pdr_addtime` int(11) NOT NULL COMMENT '���ʱ��',
  `pdr_paystate` tinyint(1) NOT NULL DEFAULT '0' COMMENT '֧��״̬ 0��ʾδ֧�� 1��ʾ֧��',
  `pdr_adminid` int(11) DEFAULT NULL COMMENT '����Ա���',
  `pdr_adminname` varchar(100) DEFAULT NULL COMMENT '����Ա����',
  `pdr_adminremark` varchar(1000) DEFAULT NULL COMMENT '����Ա��ע',
  PRIMARY KEY (`pdr_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='Ԥ����ֵ��Ϣ��';

CREATE TABLE `#__p_bundling` (
  `bl_id` int(11) NOT NULL auto_increment COMMENT '���ID',
  `bl_name` varchar(50) NOT NULL COMMENT '�������',
  `store_id` int(11) NOT NULL COMMENT '��������',
  `store_name` varchar(50) NOT NULL COMMENT '��������',
  `bl_img_more` varchar(1000) NOT NULL COMMENT '��Ʒ��ͼ',
  `bl_discount_price` decimal(10,2) NOT NULL COMMENT '��ϼ۸�',
  `bl_freight_choose` tinyint(1) NOT NULL COMMENT '�˷ѳе���ʽ',
  `bl_freight` decimal(10,2) NOT NULL COMMENT '�˷�',
  `bl_desc` text NOT NULL COMMENT '�������',
  `bl_state` tinyint(1) NOT NULL default '1' COMMENT '���״̬ 0-�ر�/1-����',
  PRIMARY KEY  (`bl_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='������ۻ��';

CREATE TABLE `#__p_bundling_goods` (
  `bl_goods_id` int(11) NOT NULL auto_increment COMMENT '�����Ʒid',
  `bl_id` int(11) NOT NULL COMMENT '���id',
  `goods_id` int(11) NOT NULL COMMENT '��Ʒid',
  `goods_name` varchar(50) NOT NULL COMMENT '��Ʒ����',
  PRIMARY KEY  (`bl_goods_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='������ۻ��Ʒ��';

CREATE TABLE `#__p_bundling_quota` (
  `bl_quota_id` int(11) NOT NULL auto_increment COMMENT '�ײ�ID',
  `store_id` int(11) NOT NULL COMMENT '����id',
  `store_name` varchar(50) NOT NULL COMMENT '��������',
  `member_id` int(11) NOT NULL COMMENT '��Աid',
  `member_name` varchar(50) NOT NULL COMMENT '��Ա����',
  `bl_quota_month` tinyint(3) unsigned NOT NULL COMMENT '������������λ�£�',
  `bl_quota_starttime` varchar(10) NOT NULL COMMENT '�ײͿ�ʼʱ��',
  `bl_quota_endtime` varchar(10) NOT NULL COMMENT '�ײͽ���ʱ��',
  `bl_quota_state` tinyint(1) unsigned NOT NULL COMMENT '�ײ�״̬��0�رգ�1������Ĭ��Ϊ 1',
  `bl_pay_gold` int(10) unsigned NOT NULL COMMENT '���ѽ������',
  PRIMARY KEY  (`bl_quota_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='��������ײͱ�';

CREATE TABLE `#__p_mansong` (
  `mansong_id` int(10) unsigned NOT NULL auto_increment COMMENT '���ͻ���',
  `mansong_name` varchar(50) NOT NULL COMMENT '�����',
  `quota_id` int(10) unsigned NOT NULL COMMENT '�ײͱ��',
  `start_time` int(10) unsigned NOT NULL COMMENT '���ʼʱ��',
  `end_time` int(10) unsigned NOT NULL COMMENT '�����ʱ��',
  `member_id` int(10) unsigned NOT NULL COMMENT '�û����',
  `store_id` int(10) unsigned NOT NULL COMMENT '���̱��',
  `member_name` varchar(50) NOT NULL COMMENT '�û���',
  `store_name` varchar(50) NOT NULL COMMENT '��������',
  `state` tinyint(1) unsigned NOT NULL COMMENT '�״̬(1-δ����/2-����/3-ȡ��/4-ʧЧ/5-����)',
  `remark` varchar(200) NOT NULL COMMENT '��ע',
  PRIMARY KEY  (`mansong_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='�����ͻ��';

CREATE TABLE `#__p_mansong_apply` (
  `apply_id` int(10) unsigned NOT NULL auto_increment COMMENT '������',
  `member_id` int(10) unsigned NOT NULL COMMENT '�û����',
  `member_name` varchar(50) NOT NULL COMMENT '�û���',
  `store_id` int(10) unsigned NOT NULL COMMENT '���̱��',
  `store_name` varchar(50) NOT NULL COMMENT '��������',
  `apply_quantity` tinyint(1) unsigned NOT NULL COMMENT '��������',
  `apply_date` int(10) unsigned NOT NULL COMMENT '����ʱ��',
  `state` tinyint(1) unsigned NOT NULL COMMENT '״̬(1-������/2-���ͨ��/3-��ȡ��/4-���ʧ��)',
  PRIMARY KEY  (`apply_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='�������ײ������';

CREATE TABLE `#__p_mansong_quota` (
  `quota_id` int(10) unsigned NOT NULL auto_increment COMMENT '�������ײͱ��',
  `apply_id` int(10) unsigned NOT NULL COMMENT '������',
  `member_id` int(10) unsigned NOT NULL COMMENT '�û����',
  `store_id` int(10) unsigned NOT NULL COMMENT '���̱��',
  `member_name` varchar(50) NOT NULL COMMENT '�û���',
  `store_name` varchar(50) NOT NULL COMMENT '��������',
  `start_time` int(10) unsigned NOT NULL COMMENT '��ʼʱ��',
  `end_time` int(10) unsigned NOT NULL COMMENT '����ʱ��',
  `state` tinyint(1) unsigned NOT NULL COMMENT '���״̬(1-����/2-ȡ��/3-����)',
  PRIMARY KEY  (`quota_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='�������ײͱ�';

CREATE TABLE `#__p_mansong_rule` (
  `rule_id` int(10) unsigned NOT NULL auto_increment COMMENT '������',
  `mansong_id` int(10) unsigned NOT NULL COMMENT '����',
  `level` tinyint(1) unsigned NOT NULL COMMENT '���򼶱�(1/2/3)',
  `price` int(10) unsigned NOT NULL COMMENT '����۸�',
  `shipping_free` tinyint(1) unsigned NOT NULL COMMENT '���ʱ�־(0-������/1-���ʷ�)',
  `discount` int(10) unsigned NOT NULL COMMENT '���ֽ��Żݽ��',
  `gift_name` varchar(50) NOT NULL COMMENT '��Ʒ����',
  `gift_link` varchar(100) NOT NULL COMMENT '��Ʒ����',
  PRIMARY KEY (`rule_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='�����ͻ�����';

CREATE TABLE `#__p_xianshi` (
  `xianshi_id` int(10) unsigned NOT NULL auto_increment COMMENT '��ʱ���',
  `goods_limit` int(10) unsigned NOT NULL COMMENT '��Ʒ����',
  `xianshi_name` varchar(50) NOT NULL COMMENT '�����',
  `quota_id` int(10) unsigned NOT NULL COMMENT '�ײͱ��',
  `start_time` int(10) unsigned NOT NULL COMMENT '���ʼʱ��',
  `end_time` int(10) unsigned NOT NULL COMMENT '�����ʱ��',
  `member_id` int(10) unsigned NOT NULL COMMENT '�û����',
  `store_id` int(10) unsigned NOT NULL COMMENT '���̱��',
  `member_name` varchar(50) NOT NULL COMMENT '�û���',
  `store_name` varchar(50) NOT NULL COMMENT '��������',
  `discount` decimal(10,2) NOT NULL COMMENT '��ۿ�',
  `buy_limit` int(10) unsigned NOT NULL COMMENT '��������',
  `state` tinyint(1) unsigned NOT NULL COMMENT '�״̬(1-δ����/2-����/3-ȡ��/4-ʧЧ/5-����)',
  PRIMARY KEY  (`xianshi_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='��ʱ�ۿۻ��';

CREATE TABLE `#__p_xianshi_apply` (
  `apply_id` int(10) unsigned NOT NULL auto_increment COMMENT '������',
  `member_id` int(10) unsigned NOT NULL COMMENT '�û����',
  `member_name` varchar(50) NOT NULL COMMENT '�û���',
  `store_id` int(10) unsigned NOT NULL COMMENT '���̱��',
  `store_name` varchar(50) NOT NULL COMMENT '��������',
  `apply_quantity` tinyint(1) unsigned NOT NULL COMMENT '��������',
  `apply_date` int(10) unsigned NOT NULL COMMENT '����ʱ��',
  `state` tinyint(1) unsigned NOT NULL COMMENT '״̬(1-������/2-���ͨ��/3-��ȡ��/4-���ʧ��)',
  PRIMARY KEY  (`apply_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='��ʱ�ۿ��ײ������';

CREATE TABLE `#__p_xianshi_goods` (
  `xianshi_goods_id` int(10) unsigned NOT NULL auto_increment COMMENT '��ʱ�ۿ���Ʒ��',
  `xianshi_id` int(10) unsigned NOT NULL COMMENT '��ʱ����',
  `xianshi_name` varchar(50) NOT NULL COMMENT '�����',
  `quota_id` int(10) unsigned NOT NULL COMMENT '�ײͱ��',
  `goods_id` int(10) unsigned NOT NULL COMMENT '��Ʒ���',
  `goods_name` varchar(100) NOT NULL COMMENT '��Ʒ����',
  `goods_store_price` decimal(10,2) NOT NULL COMMENT '���̼۸�',
  `discount` decimal(10,2) NOT NULL COMMENT '�ۿ�',
  `buy_limit` int(10) unsigned NOT NULL COMMENT '�����޶�',
  `xianshi_price` decimal(10,2) NOT NULL COMMENT '��ʱ�ۿۼ۸�',
  `goods_image` varchar(100) NOT NULL COMMENT '��ƷͼƬ',
  `state` tinyint(1) unsigned NOT NULL COMMENT '״̬(1-����/2-ȡ��)',
  PRIMARY KEY  (`xianshi_goods_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='��ʱ�ۿ���Ʒ��';

CREATE TABLE `#__p_xianshi_quota` (
  `quota_id` int(10) unsigned NOT NULL auto_increment COMMENT '��ʱ�ۿ��ײͱ��',
  `apply_id` int(10) unsigned NOT NULL COMMENT '������',
  `member_id` int(10) unsigned NOT NULL COMMENT '�û����',
  `store_id` int(10) unsigned NOT NULL COMMENT '���̱��',
  `member_name` varchar(50) NOT NULL COMMENT '�û���',
  `store_name` varchar(50) NOT NULL COMMENT '��������',
  `start_time` int(10) unsigned NOT NULL COMMENT '�ײͿ�ʼʱ��',
  `end_time` int(10) unsigned NOT NULL COMMENT '�ײͽ���ʱ��',
  `times_limit` int(10) unsigned NOT NULL COMMENT '�ײ�ʱ������',
  `published_times` int(10) unsigned NOT NULL COMMENT '�ѷ�������',
  `goods_limit` int(10) unsigned NOT NULL COMMENT '���Ʒ������',
  `state` tinyint(1) unsigned NOT NULL COMMENT '���״̬(1-����/2-ȡ��/3-����)',
  PRIMARY KEY  (`quota_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='��ʱ�ۿ��ײͱ�';

CREATE TABLE `#__recommend` (
  `recommend_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '����ID',
  `recommend_name` varchar(50) DEFAULT NULL COMMENT '����',
  `recommend_code` varchar(255) NOT NULL COMMENT '�Ƽ���ʶ��',
  `recommend_desc` varchar(255) NOT NULL COMMENT '�Ƽ�����',
  `recommend_config` varchar(255) NULL COMMENT '������Ϣ',
  PRIMARY KEY (`recommend_id`),
  UNIQUE KEY `recommend_code` (`recommend_code`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='�Ƽ����ͱ�';

CREATE TABLE `#__recommend_goods` (
  `recommend_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '�Ƽ�ID',
  `goods_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '��ƷID',
  `sort` tinyint(1) unsigned NOT NULL DEFAULT '255' COMMENT '����',
  PRIMARY KEY (`recommend_id`,`goods_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='�Ƽ���Ʒ��';

CREATE TABLE `#__rec_position` (
  `rec_id` mediumint(8) unsigned NOT NULL auto_increment,
  `pic_type` enum('1','2','0') NOT NULL default '1' COMMENT '0����1����ͼƬ2Զ��',
  `title` varchar(200) NOT NULL default '' COMMENT '����',
  `content` text NOT NULL COMMENT '���л��Ƽ�λ����',
  PRIMARY KEY  (`rec_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='�Ƽ�λ';

CREATE TABLE `#__refund_log` (
  `log_id` int(10) unsigned NOT NULL auto_increment COMMENT '�˿��¼ID',
  `order_id` int(10) unsigned NOT NULL COMMENT '����ID',
  `refund_sn` varchar(100) NOT NULL COMMENT '�˿���',
  `order_sn` varchar(100) NOT NULL COMMENT '�������',
  `seller_id` int(10) unsigned NOT NULL COMMENT '����ID',
  `store_id` int(10) unsigned NOT NULL COMMENT '����ID',
  `store_name` varchar(20) NOT NULL COMMENT '��������',
  `buyer_id` int(10) unsigned NOT NULL COMMENT '���ID',
  `buyer_name` varchar(50) NOT NULL COMMENT '��һ�Ա��',
  `add_time` int(10) unsigned NOT NULL COMMENT '���ʱ��',
  `order_amount` decimal(10,2) NOT NULL COMMENT '�������',
  `order_refund` decimal(10,2) NOT NULL COMMENT '�˿���',
  `refund_paymentname` varchar(50) NOT NULL COMMENT '֧����ʽ����',
  `refund_paymentcode` varchar(50) NOT NULL COMMENT '֧����ʽ����',
  `refund_message` varchar(300) default NULL COMMENT '�˿ע',
  `buyer_message` varchar(300) default NULL COMMENT '�˿�ԭ��',
  `admin_message` varchar(300) default NULL COMMENT '����Ա����ԭ��',
  `seller_time` int(10) unsigned default '0' COMMENT '���Ҵ���ʱ��',
  `admin_time` int(10) unsigned default '0' COMMENT '����Ա����ʱ��',
  `confirm_time` int(10) unsigned default '0' COMMENT '���ȷ���տ�ʱ��',
  `refund_type` tinyint(1) unsigned default '2' COMMENT '����:1Ϊ���,2Ϊ����,Ĭ��Ϊ2',
  `refund_state` tinyint(1) unsigned default '2' COMMENT '״̬:1Ϊ������,2Ϊͬ��,3Ϊ�ܾ�,Ĭ��Ϊ2',
  `buyer_confirm` tinyint(1) unsigned default '2' COMMENT 'ȷ���տ�״̬:1Ϊ��ȷ��,2Ϊ��ȷ��,Ĭ��Ϊ2',
  PRIMARY KEY  (`log_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='�˿��';

CREATE TABLE `#__return` (
  `return_id` int(10) unsigned NOT NULL auto_increment COMMENT '�˻���¼ID',
  `order_id` int(10) unsigned NOT NULL COMMENT '����ID',
  `return_sn` varchar(100) NOT NULL COMMENT '�˻����',
  `order_sn` varchar(100) NOT NULL COMMENT '�������',
  `seller_id` int(10) unsigned NOT NULL COMMENT '����ID',
  `store_id` int(10) unsigned NOT NULL COMMENT '����ID',
  `store_name` varchar(20) NOT NULL COMMENT '��������',
  `buyer_id` int(10) unsigned NOT NULL COMMENT '���ID',
  `buyer_name` varchar(50) NOT NULL COMMENT '��һ�Ա��',
  `return_goodsnum` int(10) unsigned NOT NULL COMMENT '�˻�����',
  `add_time` int(10) unsigned NOT NULL COMMENT '���ʱ��',
  `seller_time` int(10) unsigned default '0' COMMENT '���Ҵ���ʱ��',
  `return_message` varchar(300) default NULL COMMENT '�˻���ע',
  `buyer_message` varchar(300) default NULL COMMENT '�˿�ԭ��',
  `return_type` tinyint(1) unsigned default '2' COMMENT '����:1Ϊ���,2Ϊ����,Ĭ��Ϊ2',
  `return_state` tinyint(1) unsigned default '2' COMMENT '״̬:1Ϊ�����,2Ϊͬ��,3Ϊ��ͬ��,Ĭ��Ϊ2',
  PRIMARY KEY  (`return_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='�˻���';

CREATE TABLE `#__return_goods` (
  `log_id` int(10) unsigned NOT NULL auto_increment COMMENT '�˻���Ʒ��¼ID',
  `return_id` int(10) unsigned NOT NULL COMMENT '�˻���¼ID',
  `order_id` int(10) unsigned NOT NULL COMMENT '����ID',
  `goods_id` int(10) unsigned NOT NULL COMMENT '��ƷID',
  `goods_name` varchar(100) NOT NULL COMMENT '��Ʒ����',
  `spec_id` int(10) unsigned NOT NULL COMMENT '���ID',
  `spec_info` varchar(50) default NULL COMMENT '�������',
  `goods_price` decimal(10,2) NOT NULL COMMENT '��Ʒ�۸�',
  `goods_num` int(10) unsigned NOT NULL COMMENT '��Ʒ����',
  `goods_returnnum` int(10) unsigned NOT NULL COMMENT '�˻�����',
  `goods_image` varchar(100) default NULL COMMENT '��ƷͼƬ',
  PRIMARY KEY  (`log_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='�˻���Ʒ��';

CREATE TABLE `#__salenum` (
  `date` int(8) unsigned NOT NULL COMMENT '��������',
  `salenum` int(11) unsigned NOT NULL COMMENT '����',
  `goods_id` int(11) unsigned NOT NULL COMMENT '��ƷID',
  `store_id` int(11) unsigned NOT NULL COMMENT '����ID'
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='����ͳ�Ʊ�';

CREATE TABLE `#__seo` (
  `id` mediumint(8) unsigned NOT NULL auto_increment  COMMENT '����',
  `title` varchar(255) NOT NULL  COMMENT '����',
  `keywords` varchar(255) NOT NULL  COMMENT '�ؼ���',
  `description` text NOT NULL  COMMENT '����',
  `type` varchar(20) NOT NULL COMMENT '����',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='SEO��Ϣ��ű�';

CREATE TABLE `#__setting` (
  `name` varchar(50) NOT NULL COMMENT '����',
  `value` text COMMENT 'ֵ',
  PRIMARY KEY  (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='ϵͳ���ñ�';

CREATE TABLE `#__sns_albumclass` (
  `ac_id` int(10) unsigned NOT NULL auto_increment COMMENT '���id',
  `ac_name` varchar(100) NOT NULL COMMENT '�������',
  `member_id` int(10) unsigned NOT NULL COMMENT '������Աid',
  `ac_des` varchar(255) NOT NULL COMMENT '�������',
  `ac_sort` tinyint(3) unsigned NOT NULL COMMENT '����',
  `ac_cover` varchar(255) NOT NULL COMMENT '������',
  `upload_time` int(10) unsigned NOT NULL COMMENT 'ͼƬ�ϴ�ʱ��',
  `is_default` tinyint(1) unsigned NOT NULL default '0' COMMENT '�Ƿ�Ϊ��������  1Ϊ��,0Ϊ��',
  PRIMARY KEY  (`ac_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='����';

CREATE TABLE `#__sns_albumpic` (
  `ap_id` int(10) unsigned NOT NULL auto_increment COMMENT '���ͼƬ��id',
  `ap_name` varchar(100) NOT NULL COMMENT 'ͼƬ����',
  `ac_id` int(10) unsigned NOT NULL COMMENT '���id',
  `ap_cover` varchar(255) NOT NULL COMMENT 'ͼƬ·��',
  `ap_size` int(10) unsigned NOT NULL COMMENT 'ͼƬ��С',
  `ap_spec` varchar(100) NOT NULL COMMENT 'ͼƬ���',
  `member_id` int(10) unsigned NOT NULL COMMENT '��������id',
  `upload_time` int(10) unsigned NOT NULL COMMENT 'ͼƬ�ϴ�ʱ��',
  `ap_type` tinyint(4) NOT NULL default '0' COMMENT 'ͼƬ���ͣ�0Ϊ�ޡ�1Ϊ�����',
  `item_id` tinyint(4) NOT NULL default '0' COMMENT '��ϢID',
  PRIMARY KEY  (`ap_id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='���ͼƬ��';

CREATE TABLE `#__sns_binding` (
  `snsbind_id` int(11) NOT NULL auto_increment COMMENT '����ID',
  `snsbind_memberid` int(11) NOT NULL COMMENT '��Ա���',
  `snsbind_membername` varchar(100) NOT NULL COMMENT '��Ա����',
  `snsbind_appsign` varchar(50) NOT NULL COMMENT 'Ӧ�ñ�־',
  `snsbind_updatetime` int(11) NOT NULL COMMENT '�󶨸���ʱ��',
  `snsbind_openid` varchar(100) NOT NULL COMMENT 'Ӧ���û����',
  `snsbind_openinfo` text COMMENT 'Ӧ���û���Ϣ',
  `snsbind_accesstoken` varchar(100) NOT NULL COMMENT '���ʵ�������Դ��ƾ֤',
  `snsbind_expiresin` int(11) NOT NULL COMMENT 'accesstoken����ʱ�䣬�Է��ص�ʱ���׼����λΪ�룬ע�����ʱ�����û�������Ȩ',
  `snsbind_refreshtoken` varchar(100) default NULL COMMENT 'ˢ��token',
  PRIMARY KEY  (`snsbind_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='����Ӧ���û��󶨼�¼��';

CREATE TABLE `#__sns_comment` (
  `comment_id` int(11) NOT NULL auto_increment COMMENT '����ID',
  `comment_memberid` int(11) NOT NULL COMMENT '��ԱID',
  `comment_membername` varchar(100) NOT NULL COMMENT '��Ա����',
  `comment_memberavatar` varchar(100) default NULL COMMENT '��Աͷ��',
  `comment_originalid` int(11) NOT NULL COMMENT 'ԭ��ID',
  `comment_originaltype` tinyint(1) NOT NULL default '0' COMMENT 'ԭ������ 0��ʾ��̬��Ϣ 1��ʾ������Ʒ Ĭ��Ϊ0',
  `comment_content` varchar(500) NOT NULL COMMENT '��������',
  `comment_addtime` int(11) NOT NULL COMMENT '���ʱ��',
  `comment_ip` varchar(50) NOT NULL COMMENT '��ԴIP',
  `comment_state` tinyint(1) NOT NULL default '0' COMMENT '״̬ 0���� 1����',
  PRIMARY KEY  (`comment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='���۱�';

CREATE TABLE `#__sns_friend` (
  `friend_id` int(11) NOT NULL auto_increment COMMENT 'idֵ',
  `friend_frommid` int(11) NOT NULL COMMENT '��Աid',
  `friend_frommname` varchar(100) default NULL COMMENT '��Ա����',
  `friend_frommavatar` varchar(100) default NULL COMMENT '��Աͷ��',
  `friend_tomid` int(11) NOT NULL COMMENT '����id',
  `friend_tomname` varchar(100) NOT NULL COMMENT '���ѻ�Ա����',
  `friend_tomavatar` varchar(100) default NULL COMMENT '����ͷ��',
  `friend_addtime` int(11) NOT NULL COMMENT '���ʱ��',
  `friend_followstate` tinyint(1) NOT NULL default '1' COMMENT '��ע״̬ 1Ϊ������ע 2Ϊ˫����ע',
  PRIMARY KEY  (`friend_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='�������ݱ�';

CREATE TABLE `#__sns_goods` (
  `snsgoods_goodsid` int(11) NOT NULL COMMENT '��ƷID',
  `snsgoods_goodsname` varchar(100) NOT NULL COMMENT '��Ʒ����',
  `snsgoods_goodsimage` varchar(100) default NULL COMMENT '��ƷͼƬ',
  `snsgoods_goodsprice` decimal(10,2) NOT NULL default '0.00' COMMENT '��Ʒ�۸�',
  `snsgoods_storeid` int(11) NOT NULL COMMENT '����ID',
  `snsgoods_storename` varchar(100) NOT NULL COMMENT '��������',
  `snsgoods_addtime` int(11) NOT NULL COMMENT '���ʱ��',
  `snsgoods_likenum` int(11) NOT NULL default '0' COMMENT 'ϲ����',
  `snsgoods_likemember` text COMMENT 'ϲ�����Ļ�ԱID���ö��ŷָ�',
  `snsgoods_sharenum` int(11) NOT NULL default '0' COMMENT '������',
  UNIQUE KEY `snsgoods_goodsid` (`snsgoods_goodsid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='SNS��Ʒ��';

CREATE TABLE `#__sns_membertag` (
  `mtag_id` int(10) NOT NULL auto_increment COMMENT '��Ա��ǩid',
  `mtag_name` varchar(20) NOT NULL COMMENT '��Ա��ǩ����',
  `mtag_sort` tinyint(4) NOT NULL default '0' COMMENT '��Ա��ǩ����',
  `mtag_recommend` tinyint(4) NOT NULL default '0' COMMENT '��ǩ�Ƽ� 0δ�Ƽ���Ĭ�ϣ���1Ϊ���Ƽ�',
  `mtag_desc` varchar(50) NOT NULL COMMENT '��ǩ����',
  `mtag_img` varchar(50) default NULL COMMENT '��ǩͼƬ',
  PRIMARY KEY  (`mtag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='��Ա��ǩ��';

CREATE TABLE `#__sns_mtagmember` (
  `mtag_id` int(11) NOT NULL COMMENT '��Ա��ǩ��id',
  `member_id` int(11) NOT NULL COMMENT '��Աid',
  `recommend` tinyint(4) NOT NULL default '0' COMMENT '�Ƽ���Ĭ��Ϊ0',
  PRIMARY KEY  (`mtag_id`,`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='��Ա��ǩ��Ա���ձ�';

CREATE TABLE `#__sns_setting` (
  `member_id` int(11) NOT NULL COMMENT '��Աid',
  `setting_skin` varchar(50) default NULL COMMENT 'Ƥ��',
  PRIMARY KEY  (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='�����������ñ�';

CREATE TABLE `#__sns_sharegoods` (
  `share_id` int(11) NOT NULL auto_increment COMMENT '����ID',
  `share_goodsid` int(11) NOT NULL COMMENT '��ƷID',
  `share_memberid` int(11) NOT NULL COMMENT '������ԱID',
  `share_membername` varchar(100) NOT NULL COMMENT '��Ա����',
  `share_content` varchar(500) default NULL COMMENT '��������',
  `share_addtime` int(11) NOT NULL COMMENT '�������ʱ��',
  `share_likeaddtime` int(11) NOT NULL default '0' COMMENT 'ϲ������ʱ��',
  `share_privacy` tinyint(1) NOT NULL default '0' COMMENT '��˽�ɼ��� 0�����˿ɼ� 1���ѿɼ� 2���Լ��ɼ�',
  `share_commentcount` int(11) NOT NULL default '0' COMMENT '������',
  `share_isshare` tinyint(1) NOT NULL default '0' COMMENT '�Ƿ���� 0Ϊδ���� 1Ϊ����',
  `share_islike` tinyint(1) NOT NULL default '0' COMMENT '�Ƿ�ϲ�� 0Ϊδϲ�� 1Ϊϲ��',
  PRIMARY KEY  (`share_id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='������Ʒ��';

CREATE TABLE `#__sns_sharestore` (
  `share_id` int(11) NOT NULL auto_increment COMMENT '����ID',
  `share_storeid` int(11) NOT NULL COMMENT '���̱��',
  `share_storename` varchar(100) NOT NULL COMMENT '��������',
  `share_memberid` int(11) NOT NULL COMMENT '������ԱID',
  `share_membername` varchar(100) NOT NULL COMMENT '������Ա����',
  `share_content` varchar(500) default NULL COMMENT '��������',
  `share_addtime` int(11) NOT NULL COMMENT '���ʱ��',
  `share_privacy` tinyint(1) NOT NULL default '0' COMMENT '��˽�ɼ��� 0�����˿ɼ� 1���ѿɼ� 2���Լ��ɼ�',
  PRIMARY KEY  (`share_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='������̱�';

CREATE TABLE `#__sns_s_autosetting` (
  `sauto_storeid` int(11) NOT NULL COMMENT '����id',
  `sauto_new` tinyint(4) NOT NULL default '1' COMMENT '��Ʒ,0Ϊ�ر�/1Ϊ����',
  `sauto_newtitle` varchar(150) NOT NULL COMMENT '��Ʒ����',
  `sauto_coupon` tinyint(4) NOT NULL default '1' COMMENT '�Ż�ȯ,0Ϊ�ر�/1Ϊ����',
  `sauto_coupontitle` varchar(150) NOT NULL COMMENT '�Ż�ȯ����',
  `sauto_xianshi` tinyint(4) NOT NULL default '1' COMMENT '��ʱ�ۿ�,0Ϊ�ر�/1Ϊ����',
  `sauto_xianshititle` varchar(150) NOT NULL COMMENT '��ʱ�ۿ�����',
  `sauto_mansong` tinyint(4) NOT NULL default '1' COMMENT '������,0Ϊ�ر�/1Ϊ����',
  `sauto_mansongtitle` varchar(150) NOT NULL COMMENT '����������',
  `sauto_bundling` tinyint(4) NOT NULL default '1' COMMENT '�������,0Ϊ�ر�/1Ϊ����',
  `sauto_bundlingtitle` varchar(150) NOT NULL COMMENT '�����������',
  `sauto_groupbuy` tinyint(4) NOT NULL default '1' COMMENT '�Ź�,0Ϊ�ر�/1Ϊ����',
  `sauto_groupbuytitle` varchar(150) NOT NULL COMMENT '�Ź�����',
  PRIMARY KEY  (`sauto_storeid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='�����Զ�������̬���ñ�';

CREATE TABLE `#__sns_s_comment` (
  `scomm_id` int(11) NOT NULL auto_increment COMMENT '���̶�̬����id',
  `strace_id` int(11) NOT NULL COMMENT '���̶�̬id',
  `scomm_content` varchar(150) default NULL COMMENT '��������',
  `scomm_memberid` int(11) default NULL COMMENT '��Աid',
  `scomm_membername` varchar(45) default NULL COMMENT '��Ա����',
  `scomm_memberavatar` varchar(50) default NULL COMMENT '��Աͷ��',
  `scomm_time` varchar(11) default NULL COMMENT '����ʱ��',
  `scomm_state` tinyint(1) NOT NULL default '1' COMMENT '����״̬ 1������0����',
  PRIMARY KEY  (`scomm_id`),
  UNIQUE KEY `scomm_id` (`scomm_id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='���̶�̬���۱�';

CREATE TABLE `#__sns_s_tracelog` (
  `strace_id` int(11) NOT NULL auto_increment COMMENT '���̶�̬id',
  `strace_storeid` int(11) default NULL COMMENT '����id',
  `strace_storename` varchar(100) default NULL COMMENT '��������',
  `strace_storelogo` varchar(255) NOT NULL COMMENT '���',
  `strace_title` varchar(150) default NULL COMMENT '��̬����',
  `strace_content` text COMMENT '��������',
  `strace_time` varchar(11) default NULL COMMENT '����ʱ��',
  `strace_cool` int(11) default '0' COMMENT '������',
  `strace_spread` int(11) default '0' COMMENT 'ת������',
  `strace_comment` int(11) default '0' COMMENT '��������',
  `strace_type` tinyint(4) default '1' COMMENT '1=relay,2=normal,3=new,4=coupon,5=xianshi,6=mansong,7=bundling,8=groupbuy,9=recommend,10=hotsell',
  `strace_goodsdata` varchar(1000) default NULL COMMENT '��Ʒ��Ϣ',
  `strace_state` tinyint(1) NOT NULL default '1' COMMENT '��̬״̬ 1������0����',
  PRIMARY KEY  (`strace_id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='���̶�̬��';

CREATE TABLE `#__sns_tracelog` (
  `trace_id` int(11) NOT NULL auto_increment COMMENT '����ID',
  `trace_originalid` int(11) NOT NULL default '0' COMMENT 'ԭ��̬ID Ĭ��Ϊ0',
  `trace_originalmemberid` int(11) NOT NULL default '0' COMMENT 'ԭ����Ա���',
  `trace_originalstate` tinyint(1) NOT NULL default '0' COMMENT 'ԭ����ɾ��״̬ 0Ϊ���� 1Ϊɾ��',
  `trace_memberid` int(11) NOT NULL COMMENT '��ԱID',
  `trace_membername` varchar(100) NOT NULL COMMENT '��Ա����',
  `trace_memberavatar` varchar(100) default NULL COMMENT '��Աͷ��',
  `trace_title` varchar(500) default NULL COMMENT '��̬����',
  `trace_content` text NOT NULL COMMENT '��̬����',
  `trace_addtime` int(11) NOT NULL COMMENT '���ʱ��',
  `trace_state` tinyint(1) NOT NULL default '0' COMMENT '״̬  0���� 1Ϊ��ֹ��ʾ Ĭ��Ϊ0',
  `trace_privacy` tinyint(1) NOT NULL default '0' COMMENT '��˽�ɼ��� 0�����˿ɼ� 1���ѿɼ� 2���Լ��ɼ�',
  `trace_commentcount` int(11) NOT NULL default '0' COMMENT '������',
  `trace_copycount` int(11) NOT NULL default '0' COMMENT 'ת����',
  `trace_orgcommentcount` int(11) NOT NULL default '0' COMMENT 'ԭ�����۴���',
  `trace_orgcopycount` int(11) NOT NULL default '0' COMMENT 'ԭ��ת������',
  `trace_from` tinyint default '1' COMMENT'��Դ  1=shop 2=storetracelog 3=microshop',
  PRIMARY KEY  (`trace_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='��̬��Ϣ��';

CREATE TABLE `#__sns_visitor` (
  `v_id` int(11) NOT NULL auto_increment COMMENT '����ID',
  `v_mid` int(11) NOT NULL COMMENT '�ÿͻ�ԱID',
  `v_mname` varchar(100) NOT NULL COMMENT '�ÿͻ�Ա����',
  `v_mavatar` varchar(100) default NULL COMMENT '�ÿͻ�Աͷ��',
  `v_ownermid` int(11) NOT NULL COMMENT '���˻�ԱID',
  `v_ownermname` varchar(100) NOT NULL COMMENT '���˻�Ա����',
  `v_ownermavatar` varchar(100) default NULL COMMENT '���˻�Աͷ��',
  `v_addtime` int(11) NOT NULL COMMENT '����ʱ��',
  PRIMARY KEY  (`v_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='sns�ÿͱ�';

CREATE TABLE `#__spec` (
	`sp_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '���id',
	`sp_name` varchar(100) NOT NULL COMMENT '�������',
	`sp_format` enum('text', 'image') NOT NULL COMMENT '��ʾ����',
	`sp_value` text NOT NULL COMMENT '���ֵ��',
	`sp_sort` tinyint(1) unsigned NOT NULL COMMENT '����',
  PRIMARY KEY  (`sp_id`)
) ENGINE = MYISAM CHARSET=gbk COMMENT='��Ʒ����';

CREATE TABLE `#__spec_value` (
	`sp_value_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '���ֵid',
	`sp_value_name` varchar(100) NOT NULL COMMENT '���ֵ����',
	`sp_id` int(10) unsigned NOT NULL COMMENT '�������id',
	`sp_value_image` varchar(100) NULL COMMENT '���ͼƬ',
	`sp_value_sort` tinyint(1) unsigned NOT NULL COMMENT '����',
  PRIMARY KEY  (`sp_value_id`)
) ENGINE = MYISAM CHARSET=gbk COMMENT='��Ʒ���ֵ��';

CREATE TABLE `#__store` (
  `store_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '��������id',
  `store_name` varchar(50) NOT NULL COMMENT '��������',
  `store_auth` tinyint(1) DEFAULT '0' COMMENT '������֤',
  `name_auth` tinyint(1) DEFAULT '0' COMMENT '������֤',
  `grade_id` int(11) NOT NULL COMMENT '���̵ȼ�',
  `member_id` int(11) NOT NULL COMMENT '��Աid',
  `member_name` varchar(50) NOT NULL COMMENT '��Ա����',
  `store_owner_card` varchar(50) NOT NULL COMMENT '���֤',
  `sc_id` int(11) NOT NULL COMMENT '���̷���',
  `area_id` int(11) NOT NULL COMMENT '����id',
  `area_info` varchar(100) NOT NULL COMMENT '�������ݣ���������',
  `store_address` varchar(100) NOT NULL COMMENT '��ϸ����',
  `store_zip` varchar(10) NOT NULL COMMENT '��������',
  `store_tel` varchar(50) NOT NULL COMMENT '�绰����',
  `store_image` varchar(100) DEFAULT NULL COMMENT '֤���ϴ�',
  `store_image1` varchar(100) DEFAULT NULL COMMENT 'ִ���ϴ�',
  `store_state` tinyint(1) NOT NULL DEFAULT '2' COMMENT '����״̬��0�رգ�1������2�����',
  `store_close_info` varchar(255) DEFAULT NULL COMMENT '���̹ر�ԭ��',
  `store_sort` int(11) NOT NULL DEFAULT '0' COMMENT '��������',
  `store_time` varchar(10) NOT NULL COMMENT '����ʱ��',
  `store_end_time` varchar(10) DEFAULT NULL COMMENT '���̹ر�ʱ��',
  `store_label` varchar(255) default NULL COMMENT '����logo',
  `store_banner` varchar(255) DEFAULT NULL COMMENT '���̺��',
  `store_logo` varchar(255) DEFAULT NULL COMMENT '���',
  `store_keywords` varchar(255)  NOT NULL DEFAULT '' COMMENT '����seo�ؼ���',
  `store_description` varchar(255) NOT NULL DEFAULT '' COMMENT '����seo����',
  `store_qq` varchar(50) DEFAULT NULL COMMENT 'QQ',
  `store_ww` varchar(50) DEFAULT NULL COMMENT '��������',
  `description` text COMMENT '���̼��',
  `store_zy` text COMMENT '��Ӫ��Ʒ',
  `store_domain` varchar(50) DEFAULT NULL COMMENT '���̶�������',
  `store_domain_times` tinyint(1) unsigned NULL DEFAULT '0' COMMENT '���������޸Ĵ���',
  `store_recommend` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�Ƽ���0Ϊ��1Ϊ�ǣ�Ĭ��Ϊ0',
  `store_theme` varchar(50) NOT NULL DEFAULT 'default' COMMENT '���̵�ǰ����',
  `store_credit` int(10) NOT NULL DEFAULT '0' COMMENT '��������',
  `praise_rate` float NOT NULL DEFAULT '0' COMMENT '���̺�����',
  `store_desccredit` float NOT NULL default '0' COMMENT '��������ȷ���',
  `store_servicecredit` float NOT NULL default '0' COMMENT '����̬�ȷ���',
  `store_deliverycredit` float NOT NULL default '0' COMMENT '�����ٶȷ���',
  `store_code` varchar(255) NOT NULL DEFAULT 'default_qrcode.png' COMMENT '���̶�ά��',
  `store_collect` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '�����ղ�����',
  `store_slide` text DEFAULT NULL COMMENT '���̻õ�Ƭ',
  `store_slide_url` text COMMENT '���̻õ�Ƭ����',
  `store_center_quicklink` text COMMENT '�������ĵĳ��ò����������',
  `store_stamp` varchar(200) default NULL COMMENT '����ӡ��',
  `store_printdesc` varchar(500) default NULL COMMENT '��ӡ����ҳ���·�˵������',
  `store_sales` int(10) unsigned NOT NULL default '0' COMMENT '��������',
  `store_presales` text COMMENT '��ǰ�ͷ�',
  `store_aftersales` text COMMENT '�ۺ�ͷ�',
  `store_workingtime` varchar(100) default NULL COMMENT '����ʱ��',
  PRIMARY KEY (`store_id`),
  KEY `store_name` (`store_name`),
  KEY `sc_id` (`sc_id`),
  KEY `area_id` (`area_id`),
  KEY `store_state` (`store_state`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='�������ݱ�';

CREATE TABLE `#__store_class` (
  `sc_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '����ID',
  `sc_name` varchar(100) NOT NULL COMMENT '��������',
  `sc_parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '��ID',
  `sc_sort` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '����',
  PRIMARY KEY (`sc_id`),
  KEY `sc_parent_id` (`sc_parent_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='���̷����';

CREATE TABLE `#__store_class_goods` (
  `stc_id` int(11) NOT NULL COMMENT '������Ʒ����id',
  `goods_id` int(11) NOT NULL COMMENT '��Ʒid'
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='��Ʒ���̷���洢��';

CREATE TABLE `#__store_extend` (
  `store_id` mediumint(8) unsigned NOT NULL COMMENT '����ID',
  `express` text COMMENT '��ݹ�˾ID�����',
  PRIMARY KEY  (`store_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='������Ϣ��չ��';

CREATE TABLE `#__store_goods_class` (
  `stc_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '����ID',
  `stc_name` varchar(50) NOT NULL COMMENT '������Ʒ��������',
  `stc_parent_id` int(11) NOT NULL COMMENT '����id',
  `stc_state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '������Ʒ����״̬',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '����id',
  `stc_sort` int(11) NOT NULL DEFAULT '0' COMMENT '��Ʒ��������',
  PRIMARY KEY (`stc_id`),
  KEY `stc_parent_id` (`stc_parent_id`,`stc_sort`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='������Ʒ�����';

CREATE TABLE `#__store_grade` (
  `sg_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '����ID',
  `sg_name` char(50) default NULL COMMENT '�ȼ�����',
  `sg_goods_limit` mediumint(10) unsigned NOT NULL DEFAULT '0' COMMENT '����������Ʒ����',
  `sg_album_limit` mediumint(8) unsigned NOT NULL default '0' COMMENT '�����ϴ�ͼƬ����',
  `sg_space_limit` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '�ϴ��ռ��С����λMB',
  `sg_template_number` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'ѡ�����ģ������',
  `sg_template` varchar(255) DEFAULT NULL COMMENT 'ģ������',
  `sg_price` varchar(100) DEFAULT NULL COMMENT '����',
  `sg_confirm` tinyint(1) NOT NULL DEFAULT '1' COMMENT '��ˣ�0Ϊ��1Ϊ�ǣ�Ĭ��Ϊ1',
  `sg_description` text COMMENT '����˵��',
  `sg_function` varchar(255) DEFAULT NULL COMMENT '���ӹ���',
  `sg_sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '������ĿԽ�󼶱�Խ��',
  PRIMARY KEY (`sg_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='���̵ȼ���';

CREATE TABLE `#__store_gradelog` (
  `gl_id` int(11) NOT NULL auto_increment COMMENT '�ȼ���־�������',
  `gl_shopid` int(11) NOT NULL COMMENT '���̱��',
  `gl_shopname` varchar(50) NOT NULL COMMENT '��������',
  `gl_memberid` int(11) NOT NULL COMMENT '��Ա���',
  `gl_membername` varchar(50) NOT NULL COMMENT '��Ա����',
  `gl_sgid` int(11) NOT NULL COMMENT '�ȼ����',
  `gl_sgname` varchar(100) NOT NULL COMMENT '�ȼ�����',
  `gl_sgconfirm` tinyint(4) NOT NULL default '1' COMMENT '�Ƿ���Ҫ��� 0����Ҫ 1��Ҫ',
  `gl_sgsort` tinyint(3) NOT NULL COMMENT '����',
  `gl_addtime` int(11) NOT NULL COMMENT '���ʱ��',
  `gl_allowstate` tinyint(1) NOT NULL COMMENT '���״̬ 0Ϊ��� 1���ͨ�� 2 ���δͨ��',
  `gl_allowadminid` int(11) NOT NULL default '0' COMMENT '����Ա��� Ĭ��Ϊ0 ',
  `gl_allowadminname` varchar(100) NOT NULL default 'system' COMMENT '����Ա���� Ĭ��Ϊsystem ��ʾϵͳ�Զ����',
  `gl_allowremark` varchar(500) NOT NULL COMMENT '��˱�ע',
  PRIMARY KEY  (`gl_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='�������������¼��';

CREATE TABLE `#__store_navigation` (
  `sn_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '����ID',
  `sn_title` varchar(50) NOT NULL COMMENT '��������',
  `sn_store_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '���ҵ���ID',
  `sn_content` text COMMENT '��������',
  `sn_sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '��������',
  `sn_if_show` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�����Ƿ���ʾ',
  `sn_add_time` int(10) NOT NULL COMMENT '����',
  `sn_url` varchar(255) default NULL COMMENT '���̵���������URL',
  `sn_new_open` tinyint(1) unsigned NOT NULL default '0' COMMENT '���̵��������Ƿ����´��ڴ򿪣�0�����´���1���´��ڣ�Ĭ����0',
  PRIMARY KEY (`sn_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='���ҵ��̵�����Ϣ��';

CREATE TABLE `#__store_partner` (
  `sp_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '���̺������ID',
  `sp_store_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '����ID',
  `sp_title` varchar(100) NOT NULL COMMENT '���̺���������',
  `sp_link` varchar(255) NOT NULL COMMENT '���̺����������',
  `sp_logo` varchar(255) DEFAULT NULL COMMENT '���̺������LOGO',
  `sp_sort` tinyint(1) unsigned NOT NULL DEFAULT '255' COMMENT '���̺����������',
  PRIMARY KEY (`sp_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='���ҵ��̺�������';

CREATE TABLE `#__store_theme` (
  `theme_id` int(10) unsigned NOT NULL auto_increment COMMENT '����ID',
  `member_id` int(10) unsigned NOT NULL COMMENT '��ԱID',
  `member_name` varchar(20) NOT NULL COMMENT '��Ա����',
  `style_id` varchar(10) NOT NULL default 'style6' COMMENT 'ģ������',
  `style_name` varchar(20) default '' COMMENT '�������',
  `theme_info` text COMMENT '��������',
  `store_name` varchar(20) default NULL COMMENT '��������',
  `store_id` int(10) unsigned default '0' COMMENT '����ID',
  `show_page` varchar(20) default 'index' COMMENT '����ҳ��(��ʱֻ��index)',
  `update_time` int(10) unsigned NOT NULL COMMENT '����ʱ��',
  PRIMARY KEY  (`theme_id`),
  KEY `style_id` (`style_id`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='���������';

CREATE TABLE `#__store_watermark` (
  `wm_id` int(11) NOT NULL auto_increment COMMENT 'ˮӡid',
  `jpeg_quality` int(3) NOT NULL default '90' COMMENT 'jpegͼƬ����',
  `wm_image_name` varchar(255) default NULL COMMENT 'ˮӡͼƬ��·���Լ��ļ���',
  `wm_image_pos` tinyint(1) NOT NULL default '1' COMMENT 'ˮӡͼƬ���õ�λ��',
  `wm_image_transition` int(3) NOT NULL default '20' COMMENT 'ˮӡͼƬ��ԭͼƬ���ں϶� ',
  `wm_text` text COMMENT 'ˮӡ����',
  `wm_text_size` int(3) NOT NULL default '20' COMMENT 'ˮӡ���ִ�С',
  `wm_text_angle` tinyint(1) NOT NULL default '4' COMMENT 'ˮӡ���ֽǶ�',
  `wm_text_pos` tinyint(1) NOT NULL default '3' COMMENT 'ˮӡ���ַ���λ��',
  `wm_text_font` varchar(50) default NULL COMMENT 'ˮӡ���ֵ�����',
  `wm_text_color` varchar(7) NOT NULL default '#CCCCCC' COMMENT 'ˮӡ�������ɫֵ',
  `wm_is_open` tinyint(1) NOT NULL default '0' COMMENT 'ˮӡ�Ƿ��� 0�ر� 1����',
  `store_id` int(11) default NULL COMMENT '����id',
  PRIMARY KEY  (`wm_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='����ˮӡͼƬ��';

CREATE TABLE `#__transport` (
  `id` mediumint(8) unsigned NOT NULL auto_increment COMMENT '�˷�ģ��ID',
  `title` varchar(60) default NULL COMMENT '�˷�ģ������',
  `send_tpl_id` mediumint(8) unsigned default NULL COMMENT '��������ģ��ID',
  `member_id` mediumint(8) unsigned default NULL COMMENT '��ԱID',
  `update_time` int(10) unsigned default '0' COMMENT '������ʱ��',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='�˷�ģ��';

CREATE TABLE `#__transport_extend` (
  `id` mediumint(8) unsigned NOT NULL auto_increment COMMENT '�˷�ģ����չID',
  `type` char(2) default NULL COMMENT 'ƽ��py ���kd EMS es',
  `area_id` text COMMENT '�м�����ID��ɵĴ����ԣ�����������Ҳ�У�',
  `top_area_id` text COMMENT 'ʡ������ID��ɵĴ����ԣ�����������Ҳ�У�',
  `area_name` text COMMENT '����name��ɵĴ����ԣ�����',
  `snum` mediumint(8) unsigned default '1' COMMENT '�׼�����',
  `sprice` decimal(10,2) default '0.00' COMMENT '�׼��˷�',
  `xnum` mediumint(8) unsigned default '1' COMMENT '��������',
  `xprice` decimal(10,2) default '0.00' COMMENT '�����˷�',
  `is_default` enum('1','2') default '2' COMMENT '�Ƿ�Ĭ���˷�1��2��',
  `transport_id` mediumint(8) unsigned NOT NULL COMMENT '�˷�ģ��ID',
  `transport_title` varchar(60) default NULL COMMENT '�˷�ģ��',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='�˷�ģ����չ��';

CREATE TABLE `#__type` (
	`type_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '����id',
	`type_name` varchar(100) NOT NULL COMMENT '��������',
	`type_sort` tinyint(1) unsigned NOT NULL COMMENT '����',
	 PRIMARY KEY  (`type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='��Ʒ���ͱ�';

CREATE TABLE `#__type_brand` (
	`type_id` int(10) unsigned NOT NULL COMMENT '����id',
	`brand_id` int(10) unsigned NOT NULL COMMENT 'Ʒ��id'
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='��Ʒ������Ʒ�ƶ�Ӧ��';

CREATE TABLE `#__type_spec` (
	`type_id` int(10) unsigned NOT NULL COMMENT '����id',
	`sp_id` int(10) unsigned NOT NULL COMMENT '���id'
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='��Ʒ���������Ӧ��';

CREATE TABLE `#__upload` (
  `upload_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '����ID',
  `file_name` varchar(100) DEFAULT NULL COMMENT '�ļ���',
  `file_thumb` varchar(100) DEFAULT NULL COMMENT '��΢ͼƬ',
  `file_wm` varchar(100) NULL COMMENT 'ˮӡͼƬ',
  `file_size` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '�ļ���С',
  `store_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '����ID��0Ϊ����Ա',
  `upload_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�ļ����0Ϊ�ޣ�1Ϊ����ͼƬ��Ĭ��Ϊ0��2Ϊ��Ʒ�л�ͼƬ��3Ϊ��Ʒ����ͼƬ��4Ϊϵͳ����ͼƬ��5Ϊ������Ʒ�л�ͼƬ��6Ϊ������Ʒ����ͼƬ',
  `upload_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '���ʱ��',
  `item_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '��ϢID',
  PRIMARY KEY (`upload_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='�ϴ��ļ���';

CREATE TABLE `#__voucher` (
  `voucher_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '����ȯ���',
  `voucher_code` varchar(32) NOT NULL COMMENT '����ȯ����',
  `voucher_t_id` int(11) NOT NULL COMMENT '����ȯģ����',
  `voucher_title` varchar(50) NOT NULL COMMENT '����ȯ����',
  `voucher_desc` varchar(255) NOT NULL COMMENT '����ȯ����',
  `voucher_start_date` int(11) NOT NULL COMMENT '����ȯ��Ч�ڿ�ʼʱ��',
  `voucher_end_date` int(11) NOT NULL COMMENT '����ȯ��Ч�ڽ���ʱ��',
  `voucher_price` int(11) NOT NULL COMMENT '����ȯ���',
  `voucher_limit` decimal(10,2) NOT NULL COMMENT '����ȯʹ��ʱ�Ķ����޶�',
  `voucher_store_id` int(11) NOT NULL COMMENT '����ȯ�ĵ���id',
  `voucher_state` tinyint(4) NOT NULL COMMENT '����ȯ״̬(1-δ��,2-����,3-����,4-�ջ�)',
  `voucher_active_date` int(11) NOT NULL COMMENT '����ȯ��������',
  `voucher_type` tinyint(4) NOT NULL COMMENT '����ȯ���',
  `voucher_owner_id` int(11) NOT NULL COMMENT '����ȯ������id',
  `voucher_owner_name` varchar(50) NOT NULL COMMENT '����ȯ����������',
  `voucher_order_id` int(11) DEFAULT NULL COMMENT 'ʹ�øô���ȯ�Ķ������',
  PRIMARY KEY (`voucher_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='����ȯ��';

CREATE TABLE `#__voucher_apply` (
  `apply_id` int(11) NOT NULL auto_increment COMMENT '������',
  `apply_memberid` int(11) NOT NULL COMMENT '��Ա���',
  `apply_membername` varchar(100) NOT NULL COMMENT '��Ա����',
  `apply_storeid` int(11) NOT NULL COMMENT '���̱��',
  `apply_storename` varchar(100) NOT NULL COMMENT '��������',
  `apply_quantity` int(11) NOT NULL COMMENT '��������',
  `apply_datetime` int(11) NOT NULL COMMENT '����ʱ��',
  `apply_state` tinyint(1) NOT NULL COMMENT '״̬(1-������/2-���ͨ��/3-��ȡ��)',
  PRIMARY KEY  (`apply_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='����ȯ�ײ������';

CREATE TABLE `#__voucher_price` (
  `voucher_price_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '����ȯ��ֵ���',
  `voucher_price_describe` varchar(255) NOT NULL COMMENT '����ȯ����',
  `voucher_price` int(11) NOT NULL COMMENT '����ȯ��ֵ',
  `voucher_defaultpoints` int(11) NOT NULL default '0' COMMENT '������Ĭ�ϵĶһ�������ֿ���Ϊ0',
  PRIMARY KEY (`voucher_price_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='����ȯ����';

CREATE TABLE `#__voucher_quota` (
  `quota_id` int(11) NOT NULL auto_increment COMMENT '�ײͱ��',
  `quota_applyid` int(11) NOT NULL COMMENT '������',
  `quota_memberid` int(11) NOT NULL COMMENT '��Ա���',
  `quota_membername` varchar(100) NOT NULL COMMENT '��Ա����',
  `quota_storeid` int(11) NOT NULL COMMENT '���̱��',
  `quota_storename` varchar(100) NOT NULL COMMENT '��������',
  `quota_starttime` int(11) NOT NULL COMMENT '��ʼʱ��',
  `quota_endtime` int(11) NOT NULL COMMENT '����ʱ��',
  `quota_timeslimit` int(11) NOT NULL default '0' COMMENT '���������',
  `quota_publishedtimes` int(11) NOT NULL default '0' COMMENT '���ʹ�ô���',
  `quota_state` tinyint(1) NOT NULL default '1' COMMENT '״̬(1-����/2-ȡ��/3-����)',
  PRIMARY KEY  (`quota_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='����ȯ�ײͱ�';

CREATE TABLE `#__voucher_template` (
  `voucher_t_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '����ȯģ����',
  `voucher_t_title` varchar(50) NOT NULL COMMENT '����ȯģ������',
  `voucher_t_desc` varchar(255) NOT NULL COMMENT '����ȯģ������',
  `voucher_t_start_date` int(11) NOT NULL COMMENT '����ȯģ����Ч�ڿ�ʼʱ��',
  `voucher_t_end_date` int(11) NOT NULL COMMENT '����ȯģ����Ч�ڽ���ʱ��',
  `voucher_t_price` int(11) NOT NULL COMMENT '����ȯģ�����',
  `voucher_t_limit` decimal(10,2) NOT NULL COMMENT '����ȯʹ��ʱ�Ķ����޶�',
  `voucher_t_store_id` int(11) NOT NULL COMMENT '����ȯģ��ĵ���id',
  `voucher_t_storename` varchar(100) default NULL COMMENT '��������',
  `voucher_t_creator_id` int(11) NOT NULL COMMENT '����ȯģ��Ĵ�����id',
  `voucher_t_state` tinyint(4) NOT NULL COMMENT '����ȯģ��״̬(1-��Ч,2-ʧЧ)',
  `voucher_t_total` int(11) NOT NULL COMMENT 'ģ��ɷ��ŵĴ���ȯ����',
  `voucher_t_giveout` int(11) NOT NULL COMMENT 'ģ���ѷ��ŵĴ���ȯ����',
  `voucher_t_used` int(11) NOT NULL COMMENT 'ģ���Ѿ�ʹ�ù��Ĵ���ȯ',
  `voucher_t_add_date` int(11) NOT NULL COMMENT 'ģ��Ĵ���ʱ��',
  `voucher_t_quotaid` int(11) NOT NULL COMMENT '�ײͱ��',
  `voucher_t_points` int(11) NOT NULL default '0' COMMENT '�һ��������',
  `voucher_t_eachlimit` int(11) NOT NULL default '1' COMMENT 'ÿ����������',
  `voucher_t_styleimg` varchar(200) default NULL COMMENT '��ʽģ��ͼƬ',
  `voucher_t_customimg` varchar(200) default NULL COMMENT '�Զ������ȯģ��ͼƬ',
  PRIMARY KEY (`voucher_t_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='����ȯģ���';

CREATE TABLE `#__web` (
  `web_id` int(10) unsigned NOT NULL auto_increment COMMENT 'ģ��ID',
  `web_name` varchar(20) default '' COMMENT 'ģ������',
  `style_name` varchar(20) default 'orange' COMMENT '�������',
  `web_page` varchar(10) default 'index' COMMENT '����ҳ��(��ʱֻ��index)',
  `update_time` int(10) unsigned NOT NULL COMMENT '����ʱ��',
  `web_sort` tinyint(1) unsigned default '9' COMMENT '����',
  `web_show` tinyint(1) unsigned default '1' COMMENT '�Ƿ���ʾ��0Ϊ��1Ϊ�ǣ�Ĭ��Ϊ1',
  `web_html` text COMMENT 'ģ��html����',
  PRIMARY KEY  (`web_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='ҳ��ģ���';

CREATE TABLE `#__web_code` (
  `code_id` int(10) unsigned NOT NULL auto_increment COMMENT '����ID',
  `web_id` int(10) unsigned NOT NULL COMMENT 'ģ��ID',
  `code_type` varchar(10) NOT NULL default 'array' COMMENT '��������:array,html,json',
  `var_name` varchar(20) NOT NULL COMMENT '��������',
  `code_info` text COMMENT '��������',
  `show_name` varchar(20) default '' COMMENT 'ҳ������',
  PRIMARY KEY  (`code_id`),
  KEY `web_id` (`web_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='ģ�����ݱ�';

CREATE TABLE `#__ztc_glodlog` (
  `glog_id` int(11) NOT NULL auto_increment COMMENT '�������',
  `glog_goodsid` int(11) NOT NULL COMMENT '��Ʒ���',
  `glog_goodsname` varchar(100) NOT NULL COMMENT '��Ʒ����',
  `glog_memberid` int(11) NOT NULL COMMENT '��Ա���',
  `glog_membername` varchar(50) NOT NULL COMMENT '��Ա����',
  `glog_storeid` int(11) NOT NULL COMMENT '���̱��',
  `glog_storename` varchar(50) NOT NULL COMMENT '��������',
  `glog_type` tinyint(4) NOT NULL COMMENT '�����־���� 1���� 2����',
  `glog_goldnum` int(11) NOT NULL default '0' COMMENT '��Ҷ�',
  `glog_addtime` int(11) NOT NULL COMMENT '���ʱ��',
  `glog_desc` varchar(500) NOT NULL COMMENT '��������',
  PRIMARY KEY  (`glog_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='ֱͨ�������־��';

CREATE TABLE `#__ztc_goods` (
  `ztc_id` int(11) NOT NULL auto_increment COMMENT '�������',
  `ztc_goodsid` int(11) NOT NULL COMMENT '��Ʒ���',
  `ztc_goodsname` varchar(100) NOT NULL COMMENT '��Ʒ����',
  `ztc_goodsimage` varchar(100) NOT NULL COMMENT '��ƷͼƬ',
  `ztc_memberid` int(11) NOT NULL COMMENT '��Ա���',
  `ztc_membername` varchar(50) NOT NULL COMMENT '��Ա����',
  `ztc_storeid` int(11) NOT NULL COMMENT '���̱��',
  `ztc_storename` varchar(50) NOT NULL COMMENT '��������',
  `ztc_gold` int(11) NOT NULL COMMENT '����ֱͨ������Ľ�Ҷ�',
  `ztc_remark` varchar(200) NOT NULL COMMENT '��ע��Ϣ',
  `ztc_addtime` int(11) NOT NULL COMMENT '���ʱ��',
  `ztc_startdate` int(11) default NULL COMMENT 'ֱͨ����ʼʱ�䣬û���ñ������̿�ʼ',
  `ztc_state` tinyint(1) NOT NULL default '0' COMMENT '���״̬ 0δ��� 1���ͨ�� 2 ���δͨ��',
  `ztc_paystate` tinyint(4) NOT NULL default '0' COMMENT '֧��״̬ 0δ֧�� 1��֧��',
  `ztc_type` tinyint(4) NOT NULL default '0' COMMENT '��ֵ���� 0��ʾ�������¼ 1��ʾ��ֵ��¼�����������ֱ�Ӹ�ֱͨ���ӽ��',
  PRIMARY KEY  (`ztc_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='ֱͨ�������';

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
INSERT INTO `#__setting` (`name`, `value`) VALUES('closed_reason', '�����С���');
INSERT INTO `#__setting` (`name`, `value`) VALUES('hot_search', '����,�Ϳ�,Kappa,˫���,�����');
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

INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (9, '��ҳ�ײ�ͨ��ͼƬ���', 'λ����ҳ�ײ���ͨ����ͼƬ���', 0, 2, 1, 1000, 90, 100, 0, 0, '84de815edad64024ae2e2c45979dc77e.jpg');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (13, '��ҳ�õ�Ƭ', '��ҳ�õ�Ƭ', 2, 0, 1, 530, 210, 100, 3, 0, '8d2b873c7dd4ed47aa907b95d7852e6f.jpg');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (14, '��ҳ���������', '��ҳ���������', 0, 2, 0, 150, 240, 100, 0, 0, '8d1531247fc8ce90b373360fd0b55fd4.jpg');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (15, '��ҳ���������', '��ҳ���������', 0, 2, 0, 150, 240, 100, 0, 0, '9a708eade54a7070918643a652cd3d7e.jpg');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (16, '���ﳵ���λ1', 'λ�ڹ��ﳵ��Ϣҳ���·�ͼƬ���', 0, 2, 1, 240, 135, 100, 0, 0, 'eb1ab09f6eb9fe7517c0612b3c45b503.jpg');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (17, '���ﳵ���λ2', 'λ�ڹ��ﳵ��Ϣҳ���·�ͼƬ���', 0, 2, 1, 240, 135, 100, 0, 0, '989d9e7bdefaa9568388c7d155ebb066.jpg');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (18, '���ﳵ���λ3', 'λ�ڹ��ﳵ��Ϣҳ���·�ͼƬ���', 0, 2, 1, 240, 135, 100, 0, 0, '8357db899b3ba02b5549702be7c4d17d.jpg');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (19, '���ﳵ���λ4', 'λ�ڹ��ﳵ��Ϣҳ���·�ͼƬ���', 0, 2, 1, 240, 135, 100, 0, 0, '96d16971074cbf29cc8fc08d2dcda137.jpg');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (20, '��ҳ�ر��Ƽ�-�ĸ��ֻ����λ01', '�̳��ر��Ƽ����ֶ����\r\n�ĸ�ͼƬ��Ϊһ����չʾ', 0, 1, 1, 117, 131, 100, 1, 1, 'f1414e558d853ebd8835f50bda72fdce.jpg');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (21, '��ҳ�ر��Ƽ�-�ĸ��ֻ����λ02', '�̳��ر��Ƽ����ֶ����\r\n�ĸ�ͼƬ��Ϊһ����չʾ', 0, 2, 1, 117, 131, 100, 0, 0, 'dafee38e6539ffe625f7658033e64bb1.jpg');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (22, '��ҳ�ر��Ƽ�-�ĸ��ֻ����λ03', '�̳��ر��Ƽ����ֶ����\r\n�ĸ�ͼƬ��Ϊһ����չʾ', 0, 2, 1, 117, 131, 100, 0, 0, '3b489eb71d6d7a760e61803cf191c1b7.jpg');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (23, '��ҳ�ر��Ƽ�-�ĸ��ֻ����λ04', '�̳��ر��Ƽ����ֶ����\r\n�ĸ�ͼƬ��Ϊһ����չʾ', 0, 2, 1, 117, 131, 100, 0, 0, '290e4cd2096b2b3ab1ce633cf3441401.jpg');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (24, '��ҳ�ر��Ƽ�-�����ֻ����λ01', '�̳��ر��Ƽ����ֶ����\r\n����ͼƬ��Ϊһ����չʾ', 0, 2, 1, 230, 115, 150, 0, 0, '3067e3fbe549d28e183590463cf9c97d.jpg');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (25, '��ҳ�ر��Ƽ�-�����ֻ����λ02', '�̳��ر��Ƽ����ֶ����\r\n����ͼƬ��Ϊһ����չʾ', 0, 2, 1, 230, 115, 150, 0, 0, '28d1eff4411f81442c8d4eb3ac255672.jpg');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (35, '�����б�ҳ�в����λ', '�����б�ҳ�в����λ', 0, 1, 1, 780, 254, 30, 0, 0, 'f448e48ee0deb06707480d46a2a360ae.gif');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (37, '��Ʒ�б�ҳ�����λ', '��Ʒ�б�ҳ�����λ', 0, 1, 1, 200, 350, 100, 0, 0, '7a4832d109ee46fe7677c1d3c30e067f.gif');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (301, '��ҳ���û���1', '��ҳ���û���1', 0, 2, 1, 208, 128, 100, 0, 0, 'adv200-100.jpg');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (302, '��ҳ���û���2', '��ҳ���û���2', 0, 2, 1, 208, 128, 100, 0, 0, 'web-1-13_53bfbfc958cb55a435545033bd075bf3.png');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (311, '��ҳ����ͼƬ���1', '��ҳ����ͼƬ���1', 0, 2, 1, 220, 100, 100, 0, 0, 'web-1-18_4c91b4889516f10059e6ccf921542323.gif');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (312, '��ҳ����ͼƬ���2', '��ҳ����ͼƬ���2', 0, 2, 1, 220, 100, 100, 0, 0, 'web-2-28_9f2f7dcad3049df7450cecd179e142d8.gif');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (313, '��ҳ����ͼƬ���3', '��ҳ����ͼƬ���3', 0, 2, 1, 220, 100, 100, 0, 0, 'web-3-38_ff9bd2d724f7138cec1b1937000f4feb.jpg');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (314, '��ҳ����ͼƬ���4', '��ҳ����ͼƬ���4', 0, 2, 1, 220, 100, 100, 0, 0, 'web-4-48_cce6e8b8852046a712028b85f99bfe20.jpg');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (371, '��������ҳ�Ҳ���λ', '��������ҳ�Ҳ���λ', 0, 1, 1, 200, 350, 100, 0, 0, 'adv200-300.gif');
INSERT INTO `#__adv_position` (`ap_id`, `ap_name`, `ap_intro`, `ap_class`, `ap_display`, `is_use`, `ap_width`, `ap_height`, `ap_price`, `adv_num`, `click_num`, `default_content`) VALUES (372, '�������ҳ�Ҳ���λ', '�������ҳ�Ҳ���λ', 0, 1, 1, 200, 350, 100, 0, 0, 'adv200-300.gif');

INSERT INTO `#__adv` (`adv_id`, `ap_id`, `adv_title`, `adv_content`, `adv_start_date`, `adv_end_date`, `slide_sort`, `member_id`, `member_name`, `click_num`, `is_allow`, `buy_style`, `goldpay`) VALUES (1, 13, '��ҳ�õ�Ƭ���Թ��1', 'a:2:{s:13:"adv_slide_pic";s:36:"271b2785f67f6119332213367516a426.jpg";s:13:"adv_slide_url";s:14:"www.shopnc.net";}', 1306857600, 1622476800, 1, 0, '', 0, 1, '', 0);
INSERT INTO `#__adv` (`adv_id`, `ap_id`, `adv_title`, `adv_content`, `adv_start_date`, `adv_end_date`, `slide_sort`, `member_id`, `member_name`, `click_num`, `is_allow`, `buy_style`, `goldpay`) VALUES (2, 13, '��ҳ�õ�Ƭ���Թ��2', 'a:2:{s:13:"adv_slide_pic";s:36:"bd32bd9949a93f96eeb7bf7fdc619361.jpg";s:13:"adv_slide_url";s:14:"www.shopnc.net";}', 1306857600, 1623772800, 2, 0, '', 0, 1, '', 0);
INSERT INTO `#__adv` (`adv_id`, `ap_id`, `adv_title`, `adv_content`, `adv_start_date`, `adv_end_date`, `slide_sort`, `member_id`, `member_name`, `click_num`, `is_allow`, `buy_style`, `goldpay`) VALUES (3, 13, '��ҳ�õ�Ƭ���Թ��3', 'a:2:{s:13:"adv_slide_pic";s:36:"7dbaaa6f5324cd4b7a3531dfc5ca810b.jpg";s:13:"adv_slide_url";s:14:"www.shopnc.net";}', 1306857600, 1622476800, 3, 0, '', 0, 1, '', 0);
INSERT INTO `#__adv` (`adv_id`, `ap_id`, `adv_title`, `adv_content`, `adv_start_date`, `adv_end_date`, `slide_sort`, `member_id`, `member_name`, `click_num`, `is_allow`, `buy_style`, `goldpay`) VALUES (4, 13, '��ҳ�õ�Ƭ���Թ��4', 'a:2:{s:13:"adv_slide_pic";s:36:"1c8f6c1c8192d7fa5d3cc7f30d7db09c.jpg";s:13:"adv_slide_url";s:14:"www.shopnc.net";}', 1306857600, 1622476800, 4, 0, '', 0, 1, '', 0);
INSERT INTO `#__adv` (`adv_id`, `ap_id`, `adv_title`, `adv_content`, `adv_start_date`, `adv_end_date`, `slide_sort`, `member_id`, `member_name`, `click_num`, `is_allow`, `buy_style`, `goldpay`) VALUES (5, 13, '��ҳ�õ�Ƭ���Թ��5', 'a:2:{s:13:"adv_slide_pic";s:36:"33e9d8a94c644cd87ca97f7ced8024af.jpg";s:13:"adv_slide_url";s:14:"www.shopnc.net";}', 1306857600, 1622476800, 5, 0, '', 0, 1, '', 0);
INSERT INTO `#__adv` (`adv_id`, `ap_id`, `adv_title`, `adv_content`, `adv_start_date`, `adv_end_date`, `slide_sort`, `member_id`, `member_name`, `click_num`, `is_allow`, `buy_style`, `goldpay`) VALUES (9, 25, '�����ֻ����02', 'a:2:{s:7:"adv_pic";s:36:"5591c0054e33b3d86fbdadb536bb50a5.jpg";s:11:"adv_pic_url";s:14:"www.shopnc.net";}', 1321977600, 1622476800, 0, 0, '', 0, 1, '', 0);
INSERT INTO `#__adv` (`adv_id`, `ap_id`, `adv_title`, `adv_content`, `adv_start_date`, `adv_end_date`, `slide_sort`, `member_id`, `member_name`, `click_num`, `is_allow`, `buy_style`, `goldpay`) VALUES (10, 24, '�����ֻ����01', 'a:2:{s:7:"adv_pic";s:36:"97caa4b287891a56f9434af1a5b71c82.jpg";s:11:"adv_pic_url";s:14:"www.shopnc.net";}', 1321977600, 1622476800, 0, 0, '', 0, 1, '', 0);
INSERT INTO `#__adv` (`adv_id`, `ap_id`, `adv_title`, `adv_content`, `adv_start_date`, `adv_end_date`, `slide_sort`, `member_id`, `member_name`, `click_num`, `is_allow`, `buy_style`, `goldpay`) VALUES (11, 23, '�ĸ��ֻ����01', 'a:2:{s:7:"adv_pic";s:36:"edbbe33a9dd3ca37861f4045e34edd5c.jpg";s:11:"adv_pic_url";s:14:"www.shopnc.net";}', 1321977600, 1622476800, 0, 0, '', 0, 1, '', 0);
INSERT INTO `#__adv` (`adv_id`, `ap_id`, `adv_title`, `adv_content`, `adv_start_date`, `adv_end_date`, `slide_sort`, `member_id`, `member_name`, `click_num`, `is_allow`, `buy_style`, `goldpay`) VALUES (12, 22, '�ĸ��ֻ����02', 'a:2:{s:7:"adv_pic";s:36:"606a56dfbd9509033358ad8beb8ac631.jpg";s:11:"adv_pic_url";s:14:"www.shopnc.net";}', 1321977600, 1622476800, 0, 0, '', 0, 1, '', 0);
INSERT INTO `#__adv` (`adv_id`, `ap_id`, `adv_title`, `adv_content`, `adv_start_date`, `adv_end_date`, `slide_sort`, `member_id`, `member_name`, `click_num`, `is_allow`, `buy_style`, `goldpay`) VALUES (13, 21, '�ĸ��ֻ����03', 'a:2:{s:7:"adv_pic";s:36:"7f7c874c8f3a4f3835c8fe0348b96600.jpg";s:11:"adv_pic_url";s:14:"www.shopnc.net";}', 1321977600, 1622476800, 0, 0, '', 0, 1, '', 0);
INSERT INTO `#__adv` (`adv_id`, `ap_id`, `adv_title`, `adv_content`, `adv_start_date`, `adv_end_date`, `slide_sort`, `member_id`, `member_name`, `click_num`, `is_allow`, `buy_style`, `goldpay`) VALUES (14, 20, '�ĸ��ֻ����04', 'a:2:{s:7:"adv_pic";s:36:"c2d7e0d98aab6f4f4f3c8639fe4b4722.jpg";s:11:"adv_pic_url";s:14:"www.shopnc.net";}', 1321977600, 1622476800, 0, 0, '', 0, 1, '', 0);

INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (1, '���Ŵ�', '0', 'anxindakuaixi', 'A', '2', 'http://www.anxinda.com');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (2, '����ƽ��', '1', 'youzhengguonei', 'B', '2', 'http://yjcx.chinapost.com.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (3, 'CCES', '1', 'cces', 'C', '2', 'http://www.cces.com.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (4, '��ϲ����', '1', 'chuanxiwuliu', 'C', '2', 'http://www.cxcod.com');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (5, 'DHL���', '1', 'dhl', 'D', '2', 'http://www.cn.dhl.com');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (6, '��������', '1', 'datianwuliu', 'D', '2', 'http://www.dtw.com.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (7, '�°�����', '1', 'debangwuliu', 'D', '2', 'http://www.deppon.com');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (8, 'EMS', '1', 'ems', 'E', '2', 'http://www.ems.com.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (9, 'EMS����', '1', 'emsguoji', 'E', '2', '###');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (10, '�ɿ���', '1', 'feikangda', 'F', '2', 'http://www.fkd.com.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (11, 'FedEx(����)', '1', 'fedex', 'F', '2', 'http://fedex.com/cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (12, '��������', '1', 'rufengda', 'F', '2', 'http://www.rufengda.com');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (13, '�����ܴ�', '1', 'ganzhongnengda', 'G', '2', 'http://www.nd56.com');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (14, '�Һ���', '1', 'youzhengguonei', 'G', '2', 'http://yjcx.chinapost.com.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (15, '���ٴ�', '1', 'gongsuda', 'G', '2', 'http://www.gongsuda.com/mall/Search.aspx');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (16, '��ͨ���', '1', 'huitongkuaidi', 'H', '2', 'http://www.htky365.com');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (17, '��������', '1', 'tiandihuayu', 'H', '2', 'http://www.hoau.net');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (18, '�Ѽ�����', '1', 'jiajiwuliu', 'J', '2', 'http://www.jiaji.com');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (19, '��������', '1', 'jiayiwuliu', 'J', '2', 'http://www.jiayi56.com');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (20, '���ȴ�', '1', 'jixianda', 'J', '2', 'http://www.joust.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (21, '����ٵ�', '1', 'kuaijiesudi', 'K', '2', 'http://www.fastexpress.com.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (22, '������', '1', 'longbanwuliu', 'L', '2', 'http://www.lbex.com.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (23, '������', '1', 'lianbangkuaidi', 'L', '2', 'http://cndxp.apac.fedex.com/dxp.html');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (24, '���ͨ', '1', 'lianhaowuliu', 'L', '2', 'http://www.lhtex.com.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (25, 'ȫһ���', '1', 'quanyikuaidi', 'Q', '2', 'http://www.apex100.com');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (26, 'ȫ����', '1', 'quanfengkuaidi', 'Q', '2', 'http://www.qfkd.com.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (27, 'ȫ��ͨ', '1', 'quanritongkuaidi', 'Q', '2', 'http://www.at-express.com');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (28, '��ͨ���', '1', 'shentong', 'S', '2', 'http://www.sto.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (29, '˳����', '1', 'shunfeng', 'S', '1', 'http://www.sf-express.com');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (30, '�ٶ����', '1', 'suer', 'S', '2', 'http://www.sure56.com');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (31, 'TNT���', '1', 'tnt', 'T', '2', 'http://www.tnt.com.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (32, '������', '1', 'tiantian', 'T', '2', 'http://www.ttkdex.com');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (33, '��ػ���', '1', 'tiandihuayu', 'T', '2', 'http://www.hoau.net');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (34, 'UPS���', '1', 'ups', 'U', '2', 'http://www.ups.com/cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (35, 'USPS', '1', 'usps', 'U', '2', 'http://www.kuaidi100.com/all/usps.shtml');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (36, '�°�����', '1', 'xinbangwuliu', 'X', '2', 'http://www.xbwl.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (37, '�ŷ�����', '1', 'xinfengwuliu', 'X', '2', 'http://www.xf-express.com.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (38, 'ϣ����˹', '1', 'cces', 'X', '2', 'http://www.cces.com.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (39, '�µ�����', '1', 'neweggozzo', 'X', '2', 'http://www.ozzo.com.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (40, 'Բͨ���', '1', 'yuantong', 'Y', '1', 'http://www.yto.net.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (41, '�ϴ���', '1', 'yunda', 'Y', '1', 'http://www.yundaex.com');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (42, '��������', '1', 'youzhengguonei', 'Y', '2', 'http://yjcx.chinapost.com.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (43, '���ٿ��', '1', 'youshuwuliu', 'Y', '2', 'http://www.uc56.com');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (44, '��ͨ���', '1', 'zhongtong', 'Z', '1', 'http://www.zto.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (45, '��������', '1', 'zhongtiewuliu', 'Z', '2', 'http://www.cre.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (46, 'լ����', '1', 'zhaijisong', 'Z', '2', 'http://www.zjs.com.cn');
INSERT INTO `#__express` (`id`, `e_name`, `e_state`, `e_code`, `e_letter`, `e_order`, `e_url`) VALUES (47, '��������', '1', 'zhongyouwuliu', 'Z', '2', 'http://www.cnpl.com.cn');

INSERT INTO `#__seo` (`id`, `title`, `keywords`, `description`, `type`) VALUES (1, '{sitename}', 'ShopNC,PHP�̳�ϵͳ,ShopNC�̳�ϵͳ,���û��̳�ϵͳ,����ERP,����CRM,��������������', 'ShopNCרע���з�����ʱ����չ��Ҫ�ĵ��������̳�ϵͳ����רҵ���ķ���ˮƽΪ��ҵ���û��ṩB(2B)2C��B2B2C����������ƽ̨���������ȫ���������ƽ̨ר��ERP(CRM)ϵͳ��ERP(RFID)ϵͳ�ȣ������й�����������ҵ��ҵ������ķ�չ������ѯ�绰��400-611-5098', 'index');
INSERT INTO `#__seo` (`id`, `title`, `keywords`, `description`, `type`) VALUES (2, '{sitename} - �Ź�', 'ShopNC,{sitename}', 'ShopNCרע���з�����ʱ����չ��Ҫ�ĵ��������̳�ϵͳ����רҵ���ķ���ˮƽΪ��ҵ���û��ṩB(2B)2C��B2B2C����������ƽ̨���������ȫ���������ƽ̨ר��ERP(CRM)ϵͳ��ERP(RFID)ϵͳ�ȣ������й�����������ҵ��ҵ������ķ�չ������ѯ�绰��400-611-5098', 'group');
INSERT INTO `#__seo` (`id`, `title`, `keywords`, `description`, `type`) VALUES (3, '{sitename} - {name}', 'ShopNC,{name},{sitename}', 'ShopNC,{name},{sitename}', 'group_content');
INSERT INTO `#__seo` (`id`, `title`, `keywords`, `description`, `type`) VALUES (4, '{sitename} - Ʒ��', 'ShopNC,{sitename}', 'ShopNC,{sitename}', 'brand');
INSERT INTO `#__seo` (`id`, `title`, `keywords`, `description`, `type`) VALUES (5, '{sitename} - {name}', 'ShopNC,{sitename},{name}', 'ShopNC,{sitename},{name}', 'brand_list');
INSERT INTO `#__seo` (`id`, `title`, `keywords`, `description`, `type`) VALUES (6, '{sitename} - �Ż�ȯ', 'ShopNC,{sitename}', 'ShopNC,{sitename}', 'coupon');
INSERT INTO `#__seo` (`id`, `title`, `keywords`, `description`, `type`) VALUES (7, '{sitename} - {name}', 'ShopNC,{sitename},{name}', 'ShopNC,{sitename},{name}', 'coupon_content');
INSERT INTO `#__seo` (`id`, `title`, `keywords`, `description`, `type`) VALUES (8, '{sitename} - �����̳�', 'ShopNC,{sitename}', 'ShopNC,{sitename}', 'point');
INSERT INTO `#__seo` (`id`, `title`, `keywords`, `description`, `type`) VALUES (9, '{sitename} - {name}', 'ShopNC,{sitename},{key}', 'ShopNC,{sitename},{description}', 'point_content');
INSERT INTO `#__seo` (`id`, `title`, `keywords`, `description`, `type`) VALUES (10, '{sitename} - {article_class}', 'ShopNC,{sitename}', 'ShopNC,{sitename}', 'article');
INSERT INTO `#__seo` (`id`, `title`, `keywords`, `description`, `type`) VALUES (11, '{sitename} - {name}', 'ShopNC,{sitename},{key}', 'ShopNC,{sitename},{description}', 'article_content');
INSERT INTO `#__seo` (`id`, `title`, `keywords`, `description`, `type`) VALUES (12, '{sitename} - {shopname}', 'ShopNC,{sitename},{key}', 'ShopNC,{sitename},{description}', 'shop');
INSERT INTO `#__seo` (`id`, `title`, `keywords`, `description`, `type`) VALUES (13, '{name} - {sitename}', 'ShopNC,{sitename},{key}', 'ShopNC,{sitename},{description}', 'product');
INSERT INTO `#__seo` (`id`, `title`, `keywords`, `description`, `type`) VALUES (14, '��{name}��ô�Ե��õı���-{sitename}', 'ShopNC,{sitename},{name}', 'ShopNC,{sitename},{name}', 'sns');

INSERT INTO `#__web` (`web_id`, `web_name`, `style_name`, `web_page`, `update_time`, `web_sort`, `web_show`, `web_html`) VALUES (1, '��ɫ', 'red', 'index', 1346654878, 1, 1, NULL);
INSERT INTO `#__web` (`web_id`, `web_name`, `style_name`, `web_page`, `update_time`, `web_sort`, `web_show`, `web_html`) VALUES (2, '��ɫ', 'pink', 'index', 1346654890, 2, 1, NULL);
INSERT INTO `#__web` (`web_id`, `web_name`, `style_name`, `web_page`, `update_time`, `web_sort`, `web_show`, `web_html`) VALUES (3, '��ɫ', 'orange', 'index', 1346654909, 3, 1, NULL);
INSERT INTO `#__web` (`web_id`, `web_name`, `style_name`, `web_page`, `update_time`, `web_sort`, `web_show`, `web_html`) VALUES (4, '��ɫ', 'green', 'index', 1346654944, 4, 1, NULL);
INSERT INTO `#__web` (`web_id`, `web_name`, `style_name`, `web_page`, `update_time`, `web_sort`, `web_show`, `web_html`) VALUES (5, '��ɫ', 'blue', 'index', 1346654957, 5, 0, NULL);
INSERT INTO `#__web` (`web_id`, `web_name`, `style_name`, `web_page`, `update_time`, `web_sort`, `web_show`, `web_html`) VALUES (6, '��ɫ', 'purple', 'index', 1346654976, 6, 0, NULL);
INSERT INTO `#__web` (`web_id`, `web_name`, `style_name`, `web_page`, `update_time`, `web_sort`, `web_show`, `web_html`) VALUES (7, '��ɫ', 'brown', 'index', 1346654987, 7, 0, NULL);
INSERT INTO `#__web` (`web_id`, `web_name`, `style_name`, `web_page`, `update_time`, `web_sort`, `web_show`, `web_html`) VALUES (8, '��ɫ', 'gray', 'index', 1346654998, 8, 0, NULL);

INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (11, 1, 'array', 'tit', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-11_f3acb5954fbdeef69591fd5a84ac3adb.png";s:3:"url";s:0:"";}', '����ͼƬ');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (12, 1, 'array', 'category_list', '', '�Ƽ�����');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (13, 1, 'array', 'act', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-13_53bfbfc958cb55a435545033bd075bf3.png";s:3:"url";s:0:"";}', '�ͼƬ');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (15, 1, 'array', 'recommend_list', '', '��Ʒ�Ƽ�');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (17, 1, 'array', 'goods_list', '', '��������');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (18, 1, 'array', 'adv', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-18_4c91b4889516f10059e6ccf921542323.gif";s:3:"url";s:0:"";}', '���ͼƬ');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (19, 1, 'array', 'brand_list', '', 'Ʒ���Ƽ�');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (21, 2, 'array', 'tit', 'a:2:{s:3:"pic";s:56:"upload/adv/web-2-21_82132e2a55300f4e3a32be07af077d63.png";s:3:"url";s:0:"";}', '����ͼƬ');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (22, 2, 'array', 'category_list', '', '�Ƽ�����');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (23, 2, 'array', 'act', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-13_53bfbfc958cb55a435545033bd075bf3.png";s:3:"url";s:0:"";}', '�ͼƬ');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (25, 2, 'array', 'recommend_list', '', '��Ʒ�Ƽ�');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (27, 2, 'array', 'goods_list', '', '��������');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (28, 2, 'array', 'adv', 'a:2:{s:3:"pic";s:56:"upload/adv/web-2-28_9f2f7dcad3049df7450cecd179e142d8.gif";s:3:"url";s:0:"";}', '���ͼƬ');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (29, 2, 'array', 'brand_list', '', 'Ʒ���Ƽ�');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (31, 3, 'array', 'tit', 'a:2:{s:3:"pic";s:56:"upload/adv/web-3-31_ebd488bcb4e1e97798cc0528135fbdd6.png";s:3:"url";s:0:"";}', '����ͼƬ');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (32, 3, 'array', 'category_list', '', '�Ƽ�����');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (33, 3, 'array', 'act', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-13_53bfbfc958cb55a435545033bd075bf3.png";s:3:"url";s:0:"";}', '�ͼƬ');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (35, 3, 'array', 'recommend_list', '', '��Ʒ�Ƽ�');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (37, 3, 'array', 'goods_list', '', '��������');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (38, 3, 'array', 'adv', 'a:2:{s:3:"pic";s:56:"upload/adv/web-3-38_ff9bd2d724f7138cec1b1937000f4feb.jpg";s:3:"url";s:0:"";}', '���ͼƬ');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (39, 3, 'array', 'brand_list', '', 'Ʒ���Ƽ�');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (41, 4, 'array', 'tit', 'a:2:{s:3:"pic";s:56:"upload/adv/web-4-41_aa1184ab1026c95ec8cc3c6f8c282287.png";s:3:"url";s:0:"";}', '����ͼƬ');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (42, 4, 'array', 'category_list', '', '�Ƽ�����');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (43, 4, 'array', 'act', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-13_53bfbfc958cb55a435545033bd075bf3.png";s:3:"url";s:0:"";}', '�ͼƬ');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (45, 4, 'array', 'recommend_list', '', '��Ʒ�Ƽ�');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (47, 4, 'array', 'goods_list', '', '��������');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (48, 4, 'array', 'adv', 'a:2:{s:3:"pic";s:56:"upload/adv/web-4-48_cce6e8b8852046a712028b85f99bfe20.jpg";s:3:"url";s:0:"";}', '���ͼƬ');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (49, 4, 'array', 'brand_list', '', 'Ʒ���Ƽ�');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (51, 5, 'array', 'tit', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-11_f3acb5954fbdeef69591fd5a84ac3adb.png";s:3:"url";s:0:"";}', '����ͼƬ');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (52, 5, 'array', 'category_list', '', '�Ƽ�����');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (53, 5, 'array', 'act', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-13_53bfbfc958cb55a435545033bd075bf3.png";s:3:"url";s:0:"";}', '�ͼƬ');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (55, 5, 'array', 'recommend_list', '', '��Ʒ�Ƽ�');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (57, 5, 'array', 'goods_list', '', '��������');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (58, 5, 'array', 'adv', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-18_4c91b4889516f10059e6ccf921542323.gif";s:3:"url";s:0:"";}', '���ͼƬ');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (59, 5, 'array', 'brand_list', '', 'Ʒ���Ƽ�');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (61, 6, 'array', 'tit', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-11_f3acb5954fbdeef69591fd5a84ac3adb.png";s:3:"url";s:0:"";}', '����ͼƬ');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (62, 6, 'array', 'category_list', '', '�Ƽ�����');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (63, 6, 'array', 'act', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-13_53bfbfc958cb55a435545033bd075bf3.png";s:3:"url";s:0:"";}', '�ͼƬ');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (65, 6, 'array', 'recommend_list', '', '��Ʒ�Ƽ�');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (67, 6, 'array', 'goods_list', '', '��������');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (68, 6, 'array', 'adv', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-18_4c91b4889516f10059e6ccf921542323.gif";s:3:"url";s:0:"";}', '���ͼƬ');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (69, 6, 'array', 'brand_list', '', 'Ʒ���Ƽ�');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (71, 7, 'array', 'tit', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-11_f3acb5954fbdeef69591fd5a84ac3adb.png";s:3:"url";s:0:"";}', '����ͼƬ');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (72, 7, 'array', 'category_list', '', '�Ƽ�����');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (73, 7, 'array', 'act', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-13_53bfbfc958cb55a435545033bd075bf3.png";s:3:"url";s:0:"";}', '�ͼƬ');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (75, 7, 'array', 'recommend_list', '', '��Ʒ�Ƽ�');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (77, 7, 'array', 'goods_list', '', '��������');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (78, 7, 'array', 'adv', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-18_4c91b4889516f10059e6ccf921542323.gif";s:3:"url";s:0:"";}', '���ͼƬ');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (79, 7, 'array', 'brand_list', '', 'Ʒ���Ƽ�');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (81, 8, 'array', 'tit', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-11_f3acb5954fbdeef69591fd5a84ac3adb.png";s:3:"url";s:0:"";}', '����ͼƬ');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (82, 8, 'array', 'category_list', '', '�Ƽ�����');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (83, 8, 'array', 'act', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-13_53bfbfc958cb55a435545033bd075bf3.png";s:3:"url";s:0:"";}', '�ͼƬ');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (85, 8, 'array', 'recommend_list', '', '��Ʒ�Ƽ�');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (87, 8, 'array', 'goods_list', '', '��������');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (88, 8, 'array', 'adv', 'a:2:{s:3:"pic";s:56:"upload/adv/web-1-18_4c91b4889516f10059e6ccf921542323.gif";s:3:"url";s:0:"";}', '���ͼƬ');
INSERT INTO `#__web_code` (`code_id`, `web_id`, `code_type`, `var_name`, `code_info`, `show_name`) VALUES (89, 8, 'array', 'brand_list', '', 'Ʒ���Ƽ�');

INSERT INTO `#__gold_payment` (`payment_id`, `payment_code`, `payment_name`, `payment_info`, `payment_config`, `payment_online`, `payment_state`, `payment_sort`) VALUES(1, 'offline', '����֧��', '����֧������', 'a:1:{s:0:"";s:0:"";}', 0, 1, 3);
INSERT INTO `#__gold_payment` (`payment_id`, `payment_code`, `payment_name`, `payment_info`, `payment_config`, `payment_online`, `payment_state`, `payment_sort`) VALUES(2, 'alipay', '֧����', '', 'a:1:{s:0:"";s:0:"";}', 1, 2, 3);
INSERT INTO `#__gold_payment` (`payment_id`, `payment_code`, `payment_name`, `payment_info`, `payment_config`, `payment_online`, `payment_state`, `payment_sort`) VALUES(3, 'tenpay', '�Ƹ�ͨ', '', 'a:2:{s:14:"tenpay_account";s:10:"1900000109";s:10:"tenpay_key";s:32:"8934e7d15453e97507ef794cf7b0519d";}', 1, 2, 3);
INSERT INTO `#__gold_payment` (`payment_id`, `payment_code`, `payment_name`, `payment_info`, `payment_config`, `payment_online`, `payment_state`, `payment_sort`) VALUES(4, 'chinabank', '��������', '', 'a:2:{s:17:"chinabank_account";s:4:"1001";s:13:"chinabank_key";s:4:"test";}', 1, 1, 3);
INSERT INTO `#__gold_payment` (`payment_id`, `payment_code`, `payment_name`, `payment_info`, `payment_config`, `payment_online`, `payment_state`, `payment_sort`) VALUES('5', 'predeposit', 'Ԥ���', NULL, NULL, '1', '2', '3');

INSERT INTO `#__article_class` (`ac_id`, `ac_code`, `ac_name`, `ac_parent_id`, `ac_sort`) VALUES(1, 'notice', '�̳ǹ���', 0, 255);
INSERT INTO `#__article_class` (`ac_id`, `ac_code`, `ac_name`, `ac_parent_id`, `ac_sort`) VALUES(2, 'member', '��������', 0, 255);
INSERT INTO `#__article_class` (`ac_id`, `ac_code`, `ac_name`, `ac_parent_id`, `ac_sort`) VALUES(3, 'store', '����֮��', 0, 255);
INSERT INTO `#__article_class` (`ac_id`, `ac_code`, `ac_name`, `ac_parent_id`, `ac_sort`) VALUES(4, 'payment', '֧����ʽ', 0, 255);
INSERT INTO `#__article_class` (`ac_id`, `ac_code`, `ac_name`, `ac_parent_id`, `ac_sort`) VALUES(5, 'sold', '�ۺ����', 0, 255);
INSERT INTO `#__article_class` (`ac_id`, `ac_code`, `ac_name`, `ac_parent_id`, `ac_sort`) VALUES(6, 'service', '�ͷ�����', 0, 255);
INSERT INTO `#__article_class` (`ac_id`, `ac_code`, `ac_name`, `ac_parent_id`, `ac_sort`) VALUES(7, 'about', '��������', 0, 255);

INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(6, 2, '', 1, 255, '���ע���Ϊ��Ա', '<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:24px;color:#003399;font-family:Microsoft YaHei;background-color:#ffffff;"><span style="font-size:18px;">��¼�̳���ҳ�����ҳ�����Ϸ���ע�ᡱ</span></span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span lang="EN-US" style="font-size:9pt;color:red;line-height:115%;font-family:Calibri;mso-bidi-font-size:8.0pt;mso-fareast-font-family:����;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><?xml:namespace prefix = v ns = "urn:schemas-microsoft-com:vml" /><v:shapetype id="_x0000_t75" coordsize="21600,21600" o:spt="75" o:preferrelative="t" path="m@4@5l@4@11@9@11@9@5xe" stroked="f" filled="f"><span style="font-size:24px;">&nbsp;</span><img alt="" src="./upload/editor/20110128134626_62236.jpg" border="0" /></v:shapetype></span></span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span lang="EN-US" style="font-size:9pt;color:red;line-height:115%;font-family:Calibri;mso-bidi-font-size:8.0pt;mso-fareast-font-family:����;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><v:shapetype coordsize="21600,21600" o:spt="75" o:preferrelative="t" path="m@4@5l@4@11@9@11@9@5xe" stroked="f" filled="f"><span style="font-size:24px;">&nbsp;</span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:����;"><span style="font-size:small;color:#003399;"><span style="font-size:18px;">����ע��ҳ�棬��д�����Ϣ���Ķ��û������ֲ�</span></span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:����;"><span style="font-size:small;color:#335a89;"><img alt="" src="./upload/editor/20110128135022_79350.jpg" border="0" /></span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:����;"><span style="font-size:small;color:#003399;"><span style="font-size:18px;">���������д��ɺ��������ע�ᡱ�ύ</span></span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:����;"><span style="font-size:small;color:#003399;"><img alt="" src="./upload/editor/20110128135237_43758.jpg" border="0" /></span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:����;"><span style="font-size:small;color:#003399;"><span style="font-size:18px;">��ʾע��ɹ�</span></span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:����;"><span style="font-size:small;color:#003399;"><img alt="" src="./upload/editor/20110128135406_55835.jpg" border="0" /></span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<h3>&nbsp;</h3>\r\n</v:shapetype></span></span></span>', 1294709136);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(7, 2, '', 1, 255, '�������', '<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:24px;color:#003399;font-family:Microsoft YaHei;background-color:#ffffff;"><span style="font-size:18px;">��¼�̳���ҳ����������Ʒ��������������Ҫ��������Ʒ�Ĺؼ��֣������������</span></span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:24px;color:#003399;font-family:Microsoft YaHei;background-color:#ffffff;"><span style="font-size:18px;"><img alt="" src="./upload/editor/20110208093142_97861.jpg" border="0" /></span></span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:24px;color:#003399;font-family:Microsoft YaHei;background-color:#ffffff;"><span style="font-size:18px;">���ֺ��йؼ��ֵ���Ʒҳ��</span></span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:24px;color:#003399;font-family:Microsoft YaHei;background-color:#ffffff;"><span style="font-size:18px;"><img alt="" src="./upload/editor/20110208094130_68431.jpg" border="0" width="700px" /></span></span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>', 1294709301);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(8, 2, '', 1, 255, '��������', '<span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;"> <h3 style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;">�����Ա��¼ҳ�棬������������롱</span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><img alt="" src="./upload/editor/20110208095308_38085.jpg" border="0" /></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"> <h3 style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;">����������ҳ������д�û����������������Ϣ��������ύ�һء�</span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><img alt="" src="./upload/editor/20110208095715_55839.jpg" border="0" /></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:x-small;color:#ff0000;">���������ַҪ��дע���û����ǵ�����</span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;">\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="color:#003399;">��ʾ�����ʼ��ѷ��ͳɹ�</span></span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><img alt="" src="./upload/editor/20110208095945_10374.jpg" border="0" /></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:18px;color:#003399;line-height:115%;font-family:SimSun;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-size:8.0pt;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;">��¼��������鿴���һ�����</span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:18px;color:#003399;line-height:115%;font-family:SimSun;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-size:8.0pt;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><img alt="" src="./upload/editor/20110208100610_22468.jpg" border="0" /></span></span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n</span></h3>\r\n</span></h3>\r\n<h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n</span></span></span>', 1294709313);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(9, 2, '', 1, 255, '��Ҫ��', '<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;">��Ա��½�̳���ҳ������Ʒ��Ϣҳ��</span></span></span></p>\r\n<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;"><img alt="" src="./upload/editor/20110208170115_29919.jpg" border="0" width="700px" /></span></span></span></p>\r\n<p>&nbsp;</p>\r\n<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;">��д������������������빺�ﳵ��</span></span></span></p>\r\n<p></p>\r\n<p><img alt="" src="./upload/editor/20110209093017_89659.jpg" border="0" /></p>\r\n<p>&nbsp;</p>\r\n<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;">������鿴���ﳵ��</span></span></span></p>\r\n<p><img alt="" src="./upload/editor/20110209093309_99011.jpg" border="0" /></p>\r\n<p>&nbsp;</p>\r\n<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;">�������д��ȷ�϶�����</span></span></span></p>\r\n<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;"><img alt="" src="./upload/editor/20110209093721_30123.jpg" border="0" width="700px" /></span></span></span></p>\r\n<p>&nbsp;</p>\r\n<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;">��д��Ϣ��������µ���ɲ�֧����</span></span></span></p>\r\n<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;"><img alt="" src="./upload/editor/20110209093819_87401.jpg" border="0" width="700px" /></span></span></span></p>\r\n<p>&nbsp;</p>\r\n<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;"><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;">ѡ��֧����ʽ�������ȷ��֧����</span></span></span></span></span></span></p>\r\n<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;"><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;"><img alt="" src="./upload/editor/20110209094020_49119.jpg" border="0" width="700px" /></span></span></span></span></span></span></p>\r\n<p>&nbsp;</p>\r\n<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;"><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;">������Ʒ�ɹ�</span></span></span></span></span></span></p>\r\n<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;"><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;"><img alt="" src="./upload/editor/20110209094145_20766.jpg" border="0" width="700px" /></span></span></span></span></span></span></p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>', 1294709365);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(10, 2, '', 1, 255, '�鿴�ѹ�����Ʒ', '<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;">��Ա��¼�̳ǣ������û�����</span></span></span></p>\r\n<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;"><img alt="" src="./upload/editor/20110209094358_99646.jpg" border="0" /></span></span></span></p>\r\n<p>&nbsp;</p>\r\n<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;">��������Ұ�������ҵĶ��������룬��ɲ鿴�ѹ��򱦱�</span></span></span></p>\r\n<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="color:#003399;"><img alt="" src="./upload/editor/20110209094502_62272.jpg" border="0" width="700px" /></span></span></span></p>', 1294709380);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(11, 3, '', 1, 255, '��ι������', '<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="font-size:18px;color:#003399;font-family:SimSun;"><span style="font-size:18px;color:#003399;font-family:SimSun;">&nbsp;</span><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;">��Ա��½�̳ǽ����û����ģ����������Ұ���ҵ����������á����</span></span></span></span></span></span></p>\r\n<p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="font-size:18px;color:#003399;font-family:SimSun;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;"><img alt="" src="./upload/editor/20110209101544_91746.jpg" border="0" /></span></span></span></span></span></span></p>\r\n<span style="font-family:SimSun;"><span style="font-size:18px;"><span style="font-size:18px;color:#003399;font-family:SimSun;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;"> <p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;">��д������Ϣ�������ύ��</span></span></span></p>\r\n<h3 style="margin:15pt 0cm 0pt;"></h3>\r\n<h3 style="margin:15pt 0cm 0pt;"><img alt="" src="./upload/editor/20110209132805_31517.jpg" border="0" /></h3>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;">����ҵĵ�����ҳ�ɲ鿴���ú����ҳ</span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;"><img alt="" src="./upload/editor/20110209133004_49592.jpg" border="0" /></span></span></span></p>\r\n</span></span></span></span></span></span> <p><span style="font-family:SimSun;"><span style="font-size:18px;"><span style="font-size:18px;color:#003399;font-family:SimSun;">&nbsp;</p>\r\n<p class="MsoNormal" style="margin:10pt 0cm;"><span style="font-size:x-small;"><span style="color:#000000;"><span style="font-size:18px;color:#003399;font-family:SimSun;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span lang="EN-US" style="font-size:10pt;line-height:115%;font-family:Calibri;mso-fareast-font-family:����;mso-bidi-font-family:Times New Roman;mso-bidi-font-size:10.5pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><?xml:namespace prefix = v /><v:shapetype stroked="f" filled="f" path="m@4@5l@4@11@9@11@9@5xe" o:preferrelative="t" o:spt="75" coordsize="21600,21600"></v:shapetype></span></span></span></span>&nbsp;</p>\r\n<p class="MsoNormal" style="margin:10pt 0cm;"><span style="font-size:x-small;"><span style="color:#000000;"><span style="font-size:18px;color:#003399;font-family:SimSun;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span lang="EN-US" style="font-size:10pt;line-height:115%;font-family:Calibri;mso-fareast-font-family:����;mso-bidi-font-family:Times New Roman;mso-bidi-font-size:10.5pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><v:shapetype stroked="f" filled="f" path="m@4@5l@4@11@9@11@9@5xe" o:preferrelative="t" o:spt="75" coordsize="21600,21600"><span style="color:#000000;"><?xml:namespace prefix = v ns = "urn:schemas-microsoft-com:vml" /><v:stroke joinstyle="miter"></v:stroke></span><v:formulas><v:f eqn="if lineDrawn pixelLineWidth 0"></v:f><v:f eqn="sum @0 1 0"></v:f><v:f eqn="sum 0 0 @1"></v:f><v:f eqn="prod @2 1 2"></v:f><v:f eqn="prod @3 21600 pixelWidth"></v:f><v:f eqn="prod @3 21600 pixelHeight"></v:f><v:f eqn="sum @0 0 1"></v:f><v:f eqn="prod @6 1 2"></v:f><v:f eqn="prod @7 21600 pixelWidth"></v:f><v:f eqn="sum @8 21600 0"></v:f><v:f eqn="prod @7 21600 pixelHeight"></v:f><v:f eqn="sum @10 21600 0"></v:f></v:formulas><v:path o:connecttype="rect" gradientshapeok="t" o:extrusionok="f"></v:path><?xml:namespace prefix = o ns = "urn:schemas-microsoft-com:office:office" /><o:lock aspectratio="t" v:ext="edit"></o:lock></v:shapetype></span></span></span></span>&nbsp;</p>\r\n</span></span></span>', 1294709442);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(12, 3, '', 1, 255, '�鿴�۳���Ʒ', '<span style="font-size:18px;color:#003399;font-family:SimSun;"> <p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;">��Ա��½�̳ǽ����û����ģ����������Ұ���ҵ��������������</span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;"><img alt="" src="./upload/editor/20110209141334_26280.jpg" border="0" /></span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;">������鿴������</span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;"><img alt="" src="./upload/editor/20110209143053_56888.jpg" border="0" /></span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n</span>', 1294709506);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(13, 3, '', 1, 255, '��η���', '<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;">�����ж����б�ҳ�棬������յ����</span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;"><img alt="" src="./upload/editor/20110209144219_67019.jpg" border="0" /></span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;"> <p style="margin:15pt 0cm 0pt;"><span style="font-family:SimSun;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;">��д���������������ȷ����</span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:SimSun;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><img alt="" src="./upload/editor/20110209144319_11772.jpg" border="0" /></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<span style="font-family:SimSun;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"> <p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="color:#335a89;font-size:small;">�����ж����б�ҳ�棬�����������</span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><img alt="" src="./upload/editor/20110209150146_55268.jpg" border="0" /></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"> <p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="color:#335a89;font-size:small;">��д��������Լ����������������ȷ����</span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><img alt="" src="./upload/editor/20110209150256_60581.jpg" border="0" /></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n</span></span> <p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n</span></span></span>', 1294709579);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(14, 3, '', 1, 255, '�̳���Ʒ�Ƽ�', '<p><span style="font-size:18px;color:#003399;line-height:115%;font-family:����;mso-bidi-font-size:8.0pt;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;">��Ա��½�̳ǽ����û����ģ����������Ұ���ҵ�����Ʒ�������</span></p>\r\n<p><span style="font-size:18px;color:#003399;line-height:115%;font-family:����;mso-bidi-font-size:8.0pt;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><img alt="" src="./upload/editor/20110209154027_17581.jpg" border="0" /></span></p>\r\n<p>&nbsp;</p>\r\n<span style="font-size:18px;color:#003399;line-height:115%;font-family:����;mso-bidi-font-size:8.0pt;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"> <p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;">����Ʒ�б��е������Ʒ��ġ��༭��</span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><img alt="" src="./upload/editor/20110209155654_54046.jpg" border="0" /></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;">ѡ���Ƽ���������ύ��</span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><img alt="" src="./upload/editor/20110209160008_38544.jpg" border="0" /></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><img alt="" src="./upload/editor/20110209160122_33174.jpg" border="0" /></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n</span>', 1294709599);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(15, 3, '', 1, 255, '������뿪��', '<p><span style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-ascii-font-family:Times New Roman;mso-hansi-font-family:Times New Roman;mso-bidi-font-family:Times New Roman;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;">��¼�̳���ҳ��������Ͻǡ��û�����</span><span lang="EN-US" style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;mso-fareast-font-family:����;">��</span></p>\r\n<p><span lang="EN-US" style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;mso-fareast-font-family:����;"><img alt="" src="./upload/editor/20110209162925_19705.jpg" border="0" /></span></p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p><span lang="EN-US" style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;mso-fareast-font-family:����;"><span style="color:#000000;"><span style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-ascii-font-family:Times New Roman;mso-hansi-font-family:Times New Roman;mso-bidi-font-family:Times New Roman;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;">��Ա�����û�����ҳ�棬����·�</span><span style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-ascii-font-family:Times New Roman;mso-hansi-font-family:Times New Roman;mso-bidi-font-family:Times New Roman;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;">�����뿪�ꡱ</span></span></span></p>\r\n<p><span lang="EN-US" style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;mso-fareast-font-family:����;"><span style="color:#000000;"><span style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-ascii-font-family:Times New Roman;mso-hansi-font-family:Times New Roman;mso-bidi-font-family:Times New Roman;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><img alt="" src="./upload/editor/20110209163229_20901.jpg" border="0" /></span></span></span></p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p><span lang="EN-US" style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;mso-fareast-font-family:����;"><span style="color:#000000;"><span style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-ascii-font-family:Times New Roman;mso-hansi-font-family:Times New Roman;mso-bidi-font-family:Times New Roman;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><span style="color:#000000;"><span style="font-size:18px;color:#003399;font-family:����;mso-bidi-font-size:12.0pt;mso-ascii-font-family:Times New Roman;mso-hansi-font-family:Times New Roman;mso-bidi-font-family:Times New Roman;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;">ѡ��������ͣ��շѱ�׼�ȣ�������������ꡱ</span></span></span></span></span></p>\r\n<p><span lang="EN-US" style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;mso-fareast-font-family:����;"><span style="color:#000000;"><span style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-ascii-font-family:Times New Roman;mso-hansi-font-family:Times New Roman;mso-bidi-font-family:Times New Roman;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><span style="color:#000000;"><span style="font-size:18px;color:#003399;font-family:����;mso-bidi-font-size:12.0pt;mso-ascii-font-family:Times New Roman;mso-hansi-font-family:Times New Roman;mso-bidi-font-family:Times New Roman;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><img alt="" src="./upload/editor/20110209163457_37558.jpg" border="0" width="700px"/></span></span></span></span></span></p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p><span lang="EN-US" style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;mso-fareast-font-family:����;"><span style="color:#000000;"><span style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-ascii-font-family:Times New Roman;mso-hansi-font-family:Times New Roman;mso-bidi-font-family:Times New Roman;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><span style="color:#000000;"><span style="font-size:18px;color:#003399;font-family:����;mso-bidi-font-size:12.0pt;mso-ascii-font-family:Times New Roman;mso-hansi-font-family:Times New Roman;mso-bidi-font-family:Times New Roman;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;">��д����������Ϣ��������������ꡱ</span></span></span></span></span></p>\r\n<p><span lang="EN-US" style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;mso-fareast-font-family:����;"><span style="color:#000000;"><span style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-ascii-font-family:Times New Roman;mso-hansi-font-family:Times New Roman;mso-bidi-font-family:Times New Roman;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><span style="color:#000000;"><span style="font-size:18px;color:#003399;font-family:����;mso-bidi-font-size:12.0pt;mso-ascii-font-family:Times New Roman;mso-hansi-font-family:Times New Roman;mso-bidi-font-family:Times New Roman;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><img alt="" src="./upload/editor/20110209164206_43906.jpg" border="0" /></span></span></span></span></span></p>\r\n<p>&nbsp;</p>\r\n<p><span lang="EN-US" style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;mso-fareast-font-family:����;"><span style="color:#000000;"><span style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-ascii-font-family:Times New Roman;mso-hansi-font-family:Times New Roman;mso-bidi-font-family:Times New Roman;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><span style="color:#000000;"><span style="font-size:18px;color:#003399;font-family:����;mso-bidi-font-size:12.0pt;mso-ascii-font-family:Times New Roman;mso-hansi-font-family:Times New Roman;mso-bidi-font-family:Times New Roman;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;">��ʾ���뿪��ɹ�</span></span></span></span></span></p>\r\n<p><span lang="EN-US" style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;mso-fareast-font-family:����;"><span style="color:#000000;"><span style="font-size:18px;color:#003399;font-family:SimSun;mso-bidi-font-size:12.0pt;mso-ascii-font-family:Times New Roman;mso-hansi-font-family:Times New Roman;mso-bidi-font-family:Times New Roman;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><span style="color:#000000;"><span style="font-size:18px;color:#003399;font-family:����;mso-bidi-font-size:12.0pt;mso-ascii-font-family:Times New Roman;mso-hansi-font-family:Times New Roman;mso-bidi-font-family:Times New Roman;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><img alt="" src="./upload/editor/20110209164344_55309.jpg" border="0" /></span></span></span></span></span></p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>', 1294709809);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(16, 4, '', 1, 255, '���ע��֧����', '<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;">��Ա��½�̳ǽ����û����ģ����������Ұ���ҵ���֧����ʽ�������</span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;"><img alt="" src="./upload/editor/20110210083402_90837.jpg" border="0" /></span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;"><span style="font-size:18px;color:#003399;line-height:115%;font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-size:8.0pt;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;">�����Ҫ����ӵ�֧����ʽ��ġ���װ��</span></span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;"><span style="font-size:18px;color:#003399;line-height:115%;font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-size:8.0pt;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><img alt="" src="./upload/editor/20110210084935_79853.jpg" border="0" /></span></span></span></span></p>\r\n<span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;"><span style="font-size:18px;color:#003399;line-height:115%;font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-size:8.0pt;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"> <h3 style="margin:15pt 0cm 0pt;">&nbsp;</h3>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;">��д�����Ϣ��������ύ��</span></span></p>\r\n</span></span></span></span> <p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;"><span style="font-size:18px;color:#003399;line-height:115%;font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-size:8.0pt;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><img alt="" src="./upload/editor/20110210085515_46504.jpg" border="0" /></span></span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>', 1294709827);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(17, 4, '', 1, 255, '����֧��', '����֧��', 1294713631);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(18, 6, '', 1, 255, '��Ա�޸�����', '<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;">��Ա��¼�̳ǣ�������Ͻǡ��û����ġ�����</span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;"><img alt="" src="./upload/editor/20110210100016_71548.jpg" border="0" width="700px" /></span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;">���ҵ��˻���������������ϡ�����</span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;"><img alt="" src="./upload/editor/20110210100143_75461.jpg" border="0" /></span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;">�ڸ�������ҳ�������޸����롱</span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;"><img alt="" src="./upload/editor/20110210100354_81369.jpg" border="0" /></span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;">��д������������ύ��</span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;font-family:SimSun;"><img alt="" src="./upload/editor/20110210100612_16845.jpg" border="0" /></span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>', 1294713819);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(19, 6, '', 1, 255, '��Ա�޸ĸ�������', '<p><span style="font-size:18px;color:#003399;line-height:115%;font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-size:8.0pt;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;">��Ա��¼�̳ǣ�������Ͻǡ��û����ġ�����</span></p>\r\n<p><span style="font-size:18px;color:#003399;line-height:115%;font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-size:8.0pt;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><img alt="" src="./upload/editor/20110210100846_23142.jpg" border="0" /></span></p>\r\n<p>&nbsp;</p>\r\n<span style="font-size:18px;color:#003399;line-height:115%;font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-size:8.0pt;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"> <p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;">���û����ĵ��ҵ��˻���������������ϡ�</span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><img alt="" src="./upload/editor/20110210101042_74191.jpg" border="0" /></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"> <p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;">Ҳ�����û�����Ĭ�Ͻ��棨�˻��ſ���������༭�������ϡ�</span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><img alt="" src="./upload/editor/20110210101209_36181.jpg" border="0" /></span></p>\r\n<span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"> <p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;">��д������Ϣ���ϣ����������ͷ��</span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><img alt="" src="./upload/editor/20110210101333_62566.jpg" border="0" /></span></span></p>\r\n<span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"> <p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;">���б����ϴ�ͼƬ����ͷ��</span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><img alt="" src="./upload/editor/20110210101528_80109.jpg" border="0" /></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:18px;color:#003399;line-height:115%;font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-size:8.0pt;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;">�޸�ͷ����д��ɸ�����Ϣ�����������޸ġ�</span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:18px;color:#003399;line-height:115%;font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-size:8.0pt;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><img alt="" src="./upload/editor/20110210101632_31534.jpg" border="0" /></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:18px;color:#003399;line-height:115%;font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-size:8.0pt;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"> <p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="color:#003399;">��ɸ�����Ϣ�޸�</span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="color:#003399;"><img alt="" src="./upload/editor/20110210101732_37374.jpg" border="0" /></span></span></span></p>\r\n</span></span> <p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n</span></span> <p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n</span></span></span>', 1294713836);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(20, 6, '', 1, 255, '��Ʒ����', '<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;">��Ա��½�̳ǽ����û����ģ����������Ұ���ҵ�����Ʒ�������</span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><img alt="" src="./upload/editor/20110210102523_43795.jpg" border="0" /></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"> <p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;">����Ʒ�б��е����������Ʒ��</span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><img alt="" src="./upload/editor/20110210102626_41732.jpg" border="0" /></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"> <p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;">��д��Ʒ����ϸ��Ϣ��������ύ������</span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><img alt="" src="./upload/editor/20110210102729_99892.jpg" border="0" /></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"> <p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;">��ʾ�����Ʒ�ɹ�</span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><img alt="" src="./upload/editor/20110210102812_84565.jpg" border="0" /></span></p>\r\n</span></span></span>', 1294713852);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(21, 6, '', 1, 255, '�޸��ջ���ַ', '<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;">��Ա��¼�̳ǽ����û����ģ���������Ұ���ҵ����ҵĵ�ַ���������</span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;"><img alt="" src="./upload/editor/20110210103254_50780.jpg" border="0" /></span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;"><span style="font-size:18px;color:#003399;line-height:115%;font-family:SimSun;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-size:8.0pt;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;">�ڵ�ַ�б�ҳ�����õ�ַ��ġ��༭��</span></span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;"><span style="font-size:18px;color:#003399;line-height:115%;font-family:SimSun;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-size:8.0pt;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"><img alt="" src="./upload/editor/20110210103509_39444.jpg" border="0" /></span></span></span></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><span style="font-size:small;color:#335a89;"><span style="font-size:18px;color:#003399;"><span style="font-size:18px;color:#003399;line-height:115%;font-family:SimSun;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;mso-bidi-font-size:8.0pt;mso-bidi-font-family:Times New Roman;mso-ansi-language:EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA;"> <p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;">�ɶԸõ�ַ�������Ϣ�����޸ĺ󣬵�����༭��ַ������</span></p>\r\n<p style="margin:15pt 0cm 0pt;"><span style="font-family:����;mso-ascii-font-family:Calibri;mso-hansi-font-family:Calibri;"><img alt="" src="./upload/editor/20110210103710_47524.jpg" border="0" /></span></p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n</span></span></span></span> <p style="margin:15pt 0cm 0pt;">&nbsp;</p>\r\n<p style="margin:15pt 0cm 0pt;">&nbsp;</p>', 1294713910);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(22, 7, '', 1, 255, '����ShopNC', '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ��������Ǵ���Ƽ��������ι�˾λ��������Ͽ�������רҵ��������������Ϣ����������ѯ����������ĸ��¼�����ҵ����˾ӵ�ж��������˲ź��������ҵ�������ר�ҡ�</p>\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ��˾ӵ��һ֧���ڿ��ء�����ս���۹�������г��ж������г�Ӫ�����飬һ����ʵ��ҵ��׷��׿Խ�����������˲ţ�һ��������ս���������㣬����ḻ�Ŀ����Ŷӡ���˾��ְ��ִ���ҵ�ƶȺ��г����ɰ��£�������Ӫ��ģ��ͬʱ��ע����ҵ����������������������Ʒ�з����н������Ŀ�������˺�ǿ�ľ������� �ҹ�˾Ҳ����������ڴ�ͳ��ҵ����Ϣ�����죬�������ʻ���Ʒ�����ı�׼���淶����������̣�ͨ���������������������˲ŵļ������ʣ�������������Ʒ��Ŀǰ�Ѿ���������������֪ʶ��Ȩ�������̳���������ڻ����������ڵ�������ƽ̨��Ч�ܡ���Ч��Ĺ���ϵͳ��Ϊ����һ�����ع����г����¼�ʵ�Ļ�������˾�����ڹ���һ�����š���չ���˲�ƽ̨������Ӫ��׷��׿Խ���������׵Ĺ�����Χ���ѡ�����Ϊ������������ʵ��ÿһ����幤���У�Ϊ��Щ��â�������������޵�ҵ�羫Ӣ�ṩ��ֵķ�չ�ռ䣬�������š������ԵõĹ�����������ҵ������������Ȥ�����˵����ʽ����ͨ��ÿ��Ա�������������ң����Լ��Ķ��ؼ�ֵ�۶Թ�������������׼ȷ���жϣ�ʹ����ÿһ��Ա�����Գ����ǳ�ɫ������Ʒλ�����еĹ������Ժ�׿Խ�Ĵ��·��������ʱ�̱�����ܡ����Ϲ�������������룬��Զ����ʱ������ǰ�ˡ���˾��չ���� ����ͼ�Σ�չ��δ������˾�ѷ�չ��ҵ�����뷢���˲Ų��Խ��ܽ�ϣ�������ᾫӢ���ھ���Ǳ�ܣ�����Ϊ��������������Ŭ��Ӫ���г���ɵĹ�����Χ��Ϊ�����˲ŵ���ӱ�����ṩ��������˾�������뷢չ�����ҵ��ͬʱ��ͨ����и��Ŭ������������������˾�ĻԻ����� </p>', 1294714215);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(23, 7, '', 1, 255, '��ϵ����', '<p>��ӭ�������ǵ�վ�㡢��������Ʒ�ͷ�������Լ������������顣���ǽ���������ʱ�𸴡�ͬʱҲ��ӭ�������ǹ�˾��Ǣ��ҵ��</p>\r\n<p><br />\r\n<strong>��˾����</strong>�� ��������Ǵ���Ƽ��������ι�˾ <br />\r\n<strong>ͨ�ŵ�ַ</strong>�� ������Ͽ�������·220�Ż۹ȴ���712 <br />\r\n<strong>��������</strong>�� 300072 <br />\r\n<strong>�绰</strong>�� 400-611-5098 <br />\r\n<strong>����Ǣ̸</strong>�� 86-022-87631069 <br />\r\n<strong>����</strong>�� 86-022-87631069 <br />\r\n<strong>�����ҵ���</strong>�� 120193000029441 <br />\r\n<strong>�������Ȩ�ǼǺ�</strong>�� 2008SR07843 <br />\r\n<strong>ICP������</strong>�� ��ICP��08000171�� </p>', 1294714228);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(24, 7, '', 1, 255, '��ƸӢ��', '<dl> <h3>PHP����Ա</h3>\r\n<dt>ְλҪ�� <dd>��ϤPHP5�������ԣ�<br />\r\n��ϤMySQL5���ݿ⣬ͬʱ��Ϥsqlserver��oracle�����ȣ�<br />\r\n��Ϥ�������˼�룬MVC������ϵ������ʹ�ù�Ŀǰ��֪PHP�������һ�֣�<br />\r\n��ϤSERVER2003/Linux����ϵͳ����Ϥ����Linux�������<br />\r\n��ϤMysql���ݿ�Ӧ�ÿ������˽�Mysql�����ݿ����ù��������Ż��Ȼ����������ܣ�<br />\r\n��Ϥjquery��smarty�ȳ��ÿ�Դ�����<br />\r\n�߱����õĴ�����ϰ�߼���ǿ���ĵ���д������<br />\r\n�߱����õ��ŶӺ���������<br />\r\n��Ϥ���ģʽ�����ȣ�<br />\r\n��Ϥjava��c++,c#,python����һ�������ȣ� </dd> <dt>ѧ��Ҫ�� <dd>�� </dd> <dt>�������飺 <dd>һ������ </dd> <dt>�����ص㣺 <dd>��� </dd></dl> <dl> <h3>��ҳ��ƣ�2����</h3>\r\n<dt>��λְ�� <dd>��վUI��ơ� ��Ƭ�Լ�HTML������ </dd> <dt>ְλҪ�� <dd>�д�����վ��ƾ��飻����վ�İ桢Ƶ�����辭�������ȿ��ǣ� <br />\r\n��������photoshop,fireworks,dreamwaver���������� <br />\r\n��������Div+Css������ҳ������CSS2.0-W3C��׼�������ղ�ͬ������£���ͬ�汾��CSSԪ�ص�����<br />\r\n��Ϥ��վ�������̣������ò��޸ļ�JavaScript����� <br />\r\n�������ϣ������õ��˼ʹ�ͨ���������õĹ���Э��������̤ʵ�ϸɵĹ������񣻾������õĹ�ͨ���������<br />\r\n�����ж������Ŷ�Э�������� <br />\r\n��ӦƸ���ڼ������ṩ���˽�����Ʒ���ӡ� </dd> <dt>ѧ��Ҫ�� <dd>ר�� </dd> <dt>�������飺 <dd>һ������ </dd> <dt>�����ص㣺 <dd>��� </dd></dl> <dl> <h3>�����߻���1����</h3>\r\n<dt>ְλҪ�� <dd>2�����ϵ��İ��༭����ع������飬�߱�һ�������ֹ��ף��м�ǿ�����Ա����߼�˼ά������ �ܶ��������Ŀ�����ı�д����ݸ���Э�顣��Ϥʹ�ð칫����� </dd> <dt>ѧ��Ҫ�� <dd>��ר���� </dd> <dt>�������飺 <dd>һ������ </dd> <dt>�����ص㣺 <dd>��� </dd></dl>', 1294714240);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(25, 7, '', 1, 255, '������Ǣ̸', '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ShopNCϣ�����������̡�������鲢�������Я�ֿ���������������繺������г��������ӵ�кõĽ��飬ӵ�зḻ������Դ��ӵ���ڶ�Ŀ��ͻ���ӵ����Ӧ���г���Դ����ϣ����ShopNC�������ҵ������� ��ӭ��ΪShopNCҵ�������飬����ϵ��</p>\r\n<p>&nbsp;</p>\r\n<p><strong>��˾����</strong>�� ��������Ǵ���Ƽ��������ι�˾ <br />\r\n<strong>ͨ�ŵ�ַ</strong>�� ������Ͽ�������·220�Ż۹ȴ���712 <br />\r\n<strong>��������</strong>�� 300072 <br />\r\n<strong>�绰</strong>�� 400-611-5098 <br />\r\n<strong>����Ǣ̸</strong>�� 86-022-87631069 <br />\r\n<strong>����</strong>�� 86-022-87631069 <br />\r\n</p>', 1294714257);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(26, 5, '', 1, 255, '��ϵ����', '��ϵ����', 1294714858);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(28, 4, '', 1, 255, '���ڸ���', '���ڸ���<br />', 1309835564);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(29, 4, '', 1, 255, '�ʾֻ��', '�ʾֻ��<br />', 1309835582);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(30, 4, '', 1, 255, '��˾ת��', '��˾ת��<br />', 1309835600);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(31, 5, '', 1, 255, '�˻�������', '�˻�������', 1309835651);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(32, 5, '', 1, 255, '�˻�������', '�˻�������', 1309835666);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(33, 5, '', 1, 255, '����/�˻���', '����/�˻���', 1309835679);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(34, 5, '', 1, 255, '�˿�����', '�˿�����', 1309835699);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(35, 1, 'http://www.shopnc.net/', 1, 255, '2.4���������', '2.4���������<br />', 1362023129);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(38, 1, '', 1, 252, '�������ֱͨ����վ��ӯ��', '<h3 style="font-size:16px;text-align:center;">ShopNC�̳�ϵͳ1.2�汾֮"ֱͨ��"����˵��</h3>\r\n<p style="text-indent:2em;">ֱͨ�������Ǿ����Կͻ�ϰ�ߵ������о���������һ����վ������ӯ����ģʽ���̼ң���ƽ̨�����û���ʹ��ֱͨ��������ƷӪ�����̼�ͨ��֧�����ʹ��Ʒ����ֱͨ�����ܹ�������ʾ����Ʒ�б�����Ʒʣ����Խ������Խ��ǰ��������Ʒ�����·���ʾֱͨ����־����Ʒ������ʾ������û�����͹�����ᡣվ��ͨ��ֱͨ��������ƽ̨���ƹ㲢��ʵ��ʵʵ���ڵ�ӯ����վ�����õ�Ϊ�̼ҷ��񣬼��̼�֮���裬ʹ˫�����õ���Ӧ�Ļر�������ֱͨ��ƽ̨ʵ�ְ�ʱ���Զ��۳�ֱͨ����ҹ��ܣ������վ�����ӵĲ������̡�</p>\r\n<p></p>\r\n<p style="color:red;">ע����ϸʹ�÷�������İ�װ����document�ļ����е���ذ����ĵ�</p>', 1310203091);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(36, 1, '', 1, 253, '�°桰����������˵��', '<h3 style="font-size:16px;text-align:center;">ShopNC�̳�ϵͳ1.2�汾֮"������"����˵��</h3>\r\n<p style="text-indent:2em;">��վ�����һ��վ�����Ҫ������Դ��Ҳ��վ����Ӫ��վ����ҪĿ��֮һ��һ������ǿ��������ɣ��������Ĺ��ϵͳ��ÿһ��վ��������Ҫ�ġ�</p>\r\n<p style="text-indent:2em;">ShopNC�̳�ϵͳ1.2�汾��֮ǰ�汾�ڹ��������ģ���������ش�ĸĽ������׵߸���֮ǰ�ǳ������Ĺ��ϵͳ��ʹվ���������ɵ��������λ�����䶨�۲��ŵ���վ���κ�һ���ط���ϵͳ�ṩ��"�õ�Ƭ"��"ͼƬ"��"����"��"Flash"�ȶ��ֹ����ʽ��վ��ѡ��ͬʱȫ�µĹ��ϵͳҲ�����̻�ֱ�����߹�����Ĺ��ܣ���1.2�汾����"���"ϵͳ���ʹ�ã���ʹ��վ���Ĺ����ķǳ��򵥡�ֱ�ӡ��������ܼ���̶ȵ����վ�������롣�������ɵĹ��ͳ��ͼ����Ҳ��ShopNC�̳�ϵͳ1.2�汾��һ����ɫ��ͨ�����߼�ʱ����Flash��ʽ��ͳ��ͼ���������վ������ֱ�۵����չ�����������ϵͳ�ṩ��"����ͼ"��"����ͼ"��"����ͼ"��չʾ��ʽ����ͬʱվ���ں�̨����ͨ�����λ����������ܣ�Ѹ�ٵ�֪��Щ���λ�����ױ��û��������������վ��Ĺ��λ�۸񣬽�һ������վ�������롣</p>\r\n<p></p>\r\n<p style="color:red;">ע����ϸʹ�÷�������İ�װ����document�ļ����е���ذ����ĵ�</p>', 1310198494);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(37, 1, '', 1, 251, '�������ˮӡ�����', '<h3 style="font-size:16px;text-align:center;">����ˮӡ���������֧�����</h3>\r\n<p style="text-indent:2em;"><b>ʹ�÷�����</b>�������ص�������ϴ�����վĿ¼"��վ��Ŀ¼\\resource\\font\\"����ļ����ڣ�ͬʱ��Ҫ�޸Ĵ��ļ����µ�font.info.php�ļ������磺��������һ��"����"�ֿ�simsun.ttf�����������ǰ�������ļ����ڣ�ʹ�ô���༭���ߣ���EditPlus����font.info.php�ļ������е�$fontInfo = array(''arial''=&gt;''Arial'')���������������ֿ���Ϣ��"=&gt;"����������ļ������ұ�����������վ����ʾ��������Ϣ��</p>\r\n<p style="text-indent:2em;">��Ӻ�������磺array(''arial''=&gt;''Arial'',''simsun''=&gt;''����'')����ʾ��</p>\r\n<p></p>\r\n<p style="text-indent:2em;">��������ShopNC�ٷ���վ����������ļ������ص�ַ��<a href="http://www.shopnc.net/downloads/product/multishop/fonts.zip">������ļ�[fonts.zip]</a>��</p>\r\n<p></p>\r\n<p style="color:red;">ע����ϸʹ�÷���Ҳ�ɲ��İ�װ����upload�ļ����е�readme�ĵ�</p>', 1310200272);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(40, 1, '', 1, 254, 'ShopNC�ٷ�ʹ����ʾ��Ϣ', '<p style="text-indent:2em;"><b>�ٷ���ʾ��</b>ShopNC�̳�ϵͳ�ɹ�վ�����������ʹ�ã����尲װʹ��Э�������װ�����е���ȨЭ���ĵ��������ø�����������ʹ��Ȩ�ޣ�����ϵ�ٷ�������Ȩ��</p>\r\n<p style="text-indent:2em;">ShopNC�����Ŷ����������ʺ�վ����Ӫ�������������̳�ϵͳ����ӭ��λվ����ٷ���ϵ������ı��������顣������Ҫ�������ǵĶ��������Ļر��������������Ŀ��ǡ�</p>\r\n<ul style="line-height:150%;">\r\n<li>�ٷ���ַ��<a href="http://www.shopnc.net">http://www.shopnc.net</a></li>\r\n<li>�ٷ���̳��<a href="http://bbs.shopnc.net">http://bbs.shopnc.net</a></li>\r\n<li>������ѯQQ��1045269763 ��921362895</li>\r\n<li>�����ѯ�绰��<b>400-611-5098</b></li>\r\n</ul>', 1310268647);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(39, 1, '', 1, 254, 'UCenter����˵��', '<h3 style="font-size:16px;text-align:center;">ShopNC�̳�ϵͳ1.2�汾֮"Ucenter����"����˵��</h3>\r\n<p style="text-indent:2em;">ƽ̨֮��Ļ�Ա��ͨ��վ���ǵ�һ�����󣬻�Ա�Ļ�ͨ����վ�����ֲ�ͬģʽ��ƽ̨��ͬ������Ӫ�����ø���ƽ̨֮���΢����ϵ��ǿ����ƽ̨���û�ճ�Ⱥ���ҵ��ֵ��</p>\r\n<p style="text-indent:2em;">ShopNC�̳�ϵͳ1.2��ܺõ���UCenter���������ϣ�ʵ�ֻ�Ա�Ļ�ͨ������վ�����ж���ģʽ��ϵͳ����Э����Ӫ���ڽ���UCenter���ϵ�ʱ����Ҫע�����¼��㣺</p>\r\n<ul>\r\n<li>���Ucenterʹ�õ���utf8�����̳ǵ�ҲҪ��utf8�ģ������gbk��ľͻ�����⡣</li>\r\n<li>������ʹ��ǰ�����ϣ���Ϊ���ϳɹ���ԭϵͳ�еĻ�Ա�������ٵ�¼������Ucenter��Ϊ����</li>\r\n<li>���̳�������Ϣ�������Ucenter�п���"ͨ�ųɹ�"��ʾ��˵��������ɡ�</li>\r\n<li>��������˲���ͬ����¼���⣬��������̳�ĺ�̨���»��档</li>\r\n</ul>\r\n<p></p>\r\n<p style="color:red;">ע����ϸʹ�÷�������İ�װ����document�ļ����е���ذ����ĵ�</p>', 1310262555);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(41, 2, '', 1, 255, '����ϸ��', '����ϸ�����ϸ��', 1322621203);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(42, 2, '', 1, 255, '���ֶһ�˵��', '���ֶһ�˵�����ֶһ�˵��<br />', 1322621243);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(43, 1, '', 1, 254, '�¹���ʹ��˵��', '<p>&nbsp;&nbsp;&nbsp; �����˺ŵ�¼��Ҫ���뿪ͨ������ں�̨���ÿ�����</p>\r\n<p>&nbsp;&nbsp;&nbsp; ���ֶһ���Ԥ����������ʹ������վ�����п���ѡ���Ƿ�ͨ��Ӧ���ܡ�</p>\r\n<p>&nbsp;&nbsp;&nbsp; ��������ϸ˵����ο���װ����document�ļ����е���ذ����ĵ���</p>', 1322789334);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(44, 1, '', 1, 255, '����������ʱ�ۿ�ʹ��˵��', '<p>\r\n	һ��<span style="font-size:10.5000pt;font-family:''����'';">���ҽ����û����� <span>-&gt; </span><span>���� </span><span>-&gt; </span><span>�������� </span><span>-&gt; </span><span>��Ʒ���� </span><span>-&gt; </span><span>��ʱ�ۿۣ������ǰû�п����ײͣ�ϵͳ����ʾ�������ȹ����ײ͡�</span></span><span style="font-size:10.5pt;font-family:''����'';"></span> \r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504022113_65206.png" alt="" /> \r\n</p>\r\n<p>\r\n	����<span style="font-size:10.5000pt;font-family:''����'';">���ҵ�������ײͰ�ť�������ײ͹�����棬��дҪ���������������ύ��ť����ײ͹������롣</span><span style="font-size:10.5000pt;font-family:''����'';"></span> \r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504022155_70768.png" alt="" /> \r\n</p>\r\n<p>\r\n	����<span style="font-size:10.5000pt;font-family:''����'';">�ײ��������ƽ̨û�����ͨ��ǰ��ϵͳ����ʾ�����Ѿ������ײ͵���û��ͨ����ˡ�</span><span style="font-size:10.5000pt;font-family:''����'';"></span> \r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504022223_45601.png" alt="" /> \r\n</p>\r\n<p>\r\n	�ġ�<span style="font-size:10.5000pt;font-family:''����'';">�ײ�����ͨ�������ҿ��Է�����ʱ�ۿۻ�������ӻ��ť�������ҳ�档����ײ��б����ӿ��Բ鿴�ײͼ�¼��</span><span style="font-size:10.5000pt;font-family:''����'';"></span><br />\r\n<span style="font-size:10.5000pt;font-family:''����'';"></span> \r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504022253_29124.png" alt="" /> \r\n</p>\r\n<p>\r\n	�塢<span style="font-size:10.5000pt;font-family:''����'';">������д����ơ���ʼʱ�䡢����ʱ���Ĭ���ۿۣ�����ύ��ť������Ʒѡ��ҳ�档</span><span style="font-size:10.5000pt;font-family:''����'';"></span> \r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504022317_65502.png" alt="" /> \r\n</p>\r\n<p>\r\n	����<span style="font-size:10.5000pt;font-family:''����'';">��������Ʒ��ťѡ����Ҫ�μӻ����Ʒ��</span><span style="font-size:10.5000pt;font-family:''����'';"></span> \r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504022344_86225.png" alt="" /> \r\n</p>\r\n<p>\r\n	�ߡ�<span style="font-size:10.5000pt;font-family:''����'';">�����Ʒ��ߵ���Ӱ�ť������ѡ��Ʒ��ӵ���ǰ��С���Ʒѡ����Ϻ����·��ķ��ػ����ť���ص������ҳ�档</span><span style="font-size:10.5000pt;font-family:''����'';"></span> \r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504022411_71122.png" alt="" /> \r\n</p>\r\n<p>\r\n	�ˡ�<span style="font-size:10.5pt;font-family:''����'';">�ڻ����ҳ����Ե�������ÿ����Ʒ���ۿ��ʣ���ȷ����������������ť�����ʱ�ۿۻ�ķ�����</span> \r\n</p>\r\n<p>\r\n	<span style="font-size:10.5pt;font-family:''����'';"><img src="./upload/editor/20120504022440_49064.png" alt="" /></span> \r\n</p>\r\n<p>\r\n	<span style="font-size:10.5000pt;font-family:''����'';">�š���ʱ�ۿ���Ʒ��������ʾ����Ʒ�б��У�����Ʒ�б�ҳ�����Զ���ʱ�ۿ���Ʒ����ɸѡ��������Ʒ��ϸҳ���������ʱ�ۿ۱�ʶ��������̹���ť��������ʱ�ۿۼ۹�����Ʒ��</span><span style="font-size:10.5000pt;font-family:''����'';"></span><span style="font-size:10.5pt;font-family:''����'';"></span> \r\n</p>\r\n<p>\r\n	<span style="font-size:10.5pt;font-family:''����'';"><img src="./upload/editor/20120504022517_84608.png" alt="" /></span> \r\n</p>\r\n<p>\r\n	<span style="font-size:10.5000pt;font-family:''����'';"><img src="./upload/editor/20120504022542_81820.png" alt="" /></span> \r\n</p>\r\n<br />', 1336098353);
INSERT INTO `#__article` (`article_id`, `ac_id`, `article_url`, `article_show`, `article_sort`, `article_title`, `article_content`, `article_time`) VALUES(45, 1, '', 1, 255, '��������������ʹ��˵��', '<p>\r\n	һ��<span style="font-size:10.5000pt;font-family:''����'';">���ҽ����û�����&nbsp;<span>-&gt;&nbsp;</span><span>����&nbsp;</span><span>-&gt;&nbsp;</span><span>��������&nbsp;</span><span>-&gt;&nbsp;</span><span>��Ʒ����&nbsp;</span><span>-&gt;&nbsp;</span><span>�����ͣ������ǰû�п����ײͣ�ϵͳ����ʾ�������ȹ����ײ͡�</span></span><span style="font-size:10.5pt;font-family:''����'';"></span>\r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504025039_83457.png" alt="" />\r\n</p>\r\n<p>\r\n	����<span style="font-size:10.5000pt;font-family:''����'';">���ҵ�������ײͰ�ť�������ײ͹�����棬��дҪ���������������ύ��ť����ײ͹������롣</span><span style="font-size:10.5000pt;font-family:''����'';"></span>\r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504025105_16849.png" alt="" />\r\n</p>\r\n<p>\r\n	����<span style="font-size:10.5000pt;font-family:''����'';">�ײ��������ƽ̨û�����ͨ��ǰ��ϵͳ����ʾ�����Ѿ������ײ͵���û��ͨ����ˡ�</span><span style="font-size:10.5000pt;font-family:''����'';"></span>\r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504025127_50866.png" alt="" />\r\n</p>\r\n<p>\r\n	�ġ�<span style="font-size:10.5000pt;font-family:''����'';">�ײ�����ͨ�������ҿ��Է��������ͻ�������ӻ��ť�������ҳ�档����ײ��б����ӿ��Բ鿴�ײͼ�¼��</span>\r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504025157_78499.png" alt="" />\r\n</p>\r\n<p>\r\n	�塢<span style="font-size:10.5000pt;font-family:''����'';">������д����ơ���ʼʱ��ͽ���ʱ��</span><span style="font-size:10.5000pt;font-family:''����'';"></span><br />\r\n<span style="font-size:10.5000pt;font-family:''����'';"></span>\r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504025227_23504.png" alt="" />\r\n</p>\r\n<p>\r\n	����<span style="font-size:10.5000pt;font-family:''����'';">�����ͻ������������������ÿ��������Էֱ�ѡ��μӼ��ֽ𡢰��ʺ�������Ʒ����ʽ����������������������һ������</span><span style="font-size:10.5000pt;font-family:''����'';"></span>\r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504025246_12664.png" alt="" />\r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504025255_72740.png" alt="" />\r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504025305_38366.png" alt="" />\r\n</p>\r\n<p>\r\n	�ߡ�<span style="font-size:10.5000pt;font-family:''����'';">�����͹���������ɺ���д��ע��Ϣ������ύ��ť��������ͻ�ķ�����</span><span style="font-size:10.5000pt;font-family:''����'';"></span>\r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504025316_42126.png" alt="" />\r\n</p>\r\n<p>\r\n	�ˡ�<span style="font-size:10.5000pt;font-family:''����'';">������Ʒ��ϸҳ���μ������ͻ�ĵ��̻���������ͱ�ʶ�����ﳵ����ʱ������������͹��򽫰��������ͻ���з�����</span><span style="font-size:10.5000pt;font-family:''����'';"></span>\r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504025440_23068.png" alt="" />\r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504025453_64906.png" alt="" />\r\n</p>\r\n<p>\r\n	<img src="./upload/editor/20120504025501_90167.png" alt="" />\r\n</p>\r\n<br />', 1336100107);

INSERT INTO `#__coupon_class` (`class_id`, `class_parent_id`, `class_name`, `class_sort`, `class_show`) VALUES(1, 0, '���Է���', 99, '1');

INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(1, '���Ǵ���', 'http://www.shopnc.net', 'ac1d6b368d9a8b048b974186c8d467a9.gif', 0);
INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(29, '��Ѷ��', 'http://www.qq.com', '75eb906e1b7a2f568f38517c3b338b76.png', 8);
INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(28, '�������', 'http://www.skycn.com', '7e6c4529c180781a4918728c59106a0d.jpg', 6);
INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(27, 'վ��֮��', 'http://www.chinaz.com', 'd3f4b551af9621eca9dce6b742c66540.gif', 7);
INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(26, '��������', 'http://www.onlinedown.net', '675e3c273601596996c7d9f56340c7ff.gif', 5);
INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(22, 'PHPChina', 'http://www.phpchina.com', '71f3651a995ef7a8d8bcc00dfe1fa018.gif', 3);
INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(23, '��ʢ����', 'http://www.comsenz.com', '2656c79dff5e988bc20d707d1a73a583.jpg', 2);
INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(24, 'A5����', 'http://down.admin5.com', '1ce6ffadfcf5e45d7fbd86d46d0e90db.gif', 4);
INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(25, 'DZ����', 'http://www.verydz.com', '29269def49a5d57a24490b69b3312260.gif', 1);
INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(38, '֧����ƽ̨', 'https://www.alipay.com/', '', 5);
INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(37, '����΢������ƽ̨', 'http://open.weibo.com/', '', 3);
INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(36, 'Discuz!��ƽ̨', 'http://discuz.qq.com/', '', 4);
INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(35, '���ѿ���ƽ̨', 'http://open.soso.com/', '', 6);
INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(34, 'QQ�ʱ���������', 'http://open.cb.qq.com/', '', 8);
INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(33, '�Ƹ�ͨ����ƽ̨', 'http://open.tenpay.com/', '', 7);
INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(32, '��Ѷ΢������ƽ̨', 'http://open.t.qq.com/', '', 2);
INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(31, '��Ѷ��������ƽ̨', 'http://opensns.qq.com/', '', 1);
INSERT INTO `#__link` (`link_id`, `link_title`, `link_url`, `link_pic`, `link_sort`) VALUES(30, 'QQ������¼', 'http://connect.opensns.qq.com/', '', 0);

INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[�����]</strong>���̵����˶������õ��ʼ�֪ͨ', '{$site_name}����:����{$store_name}���������Ķ�������', 'email_tobuyer_adjust_fee_notify', '<p>\r\n	�𾴵�{$buyer_name}:\r\n</p>\r\n<p style="" padding-left:="" 30px;="">�������׵ĵ���{$store_name}��������������Ϊ{$order_sn}�Ķ����ķ��ã�������ʱ���\r\n	</p>\r\n<p style="" padding-left:="" 30px;="">�鿴������ϸ��Ϣ������������\r\n</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=member&amp;op=show_order&amp;order_id={$order_id}" target="_blank">{$site_url}/index.php?act=member&amp;op=show_order&amp;order_id={$order_id}</a><br />\r\n \r\n	</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$site_name}\r\n</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$mail_send_time}\r\n	</p>', 0, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[�����]</strong>������ȡ�����ʼ�֪ͨ', '{$site_name}����:���Ķ���{$order_sn}�ѱ�ȡ��', 'email_tobuyer_cancel_order_notify', '<p>\r\n	�𾴵�{$buyer_name}:\r\n</p>\r\n<p style="" padding-left:="" 30px;="">�������׵ĵ���{$store_name}�Ѿ�ȡ�������Ķ���{$order_sn}��\r\n	</p>\r\n<p style="" padding-left:="" 30px;="">ԭ��{$reason}\r\n</p>\r\n<p style="" padding-left:="" 30px;="">�鿴������ϸ��Ϣ������������\r\n	</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=member&amp;op=show_order&amp;order_id={$order_id}" target="_blank">{$site_url}/index.php?act=member&amp;op=show_order&amp;order_id={$order_id}</a> \r\n</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$site_name}\r\n	</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$mail_send_time}\r\n</p>', 0, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[�����]</strong>����ȷ���յ���ʱ���ʵĻ����ɽ��׵��ʼ�֪ͨ', '{$site_name}����:����{$store_name}ȷ���յ������Ļ��������ɣ�', 'email_tobuyer_cod_order_finish_notify', '<p>\r\n	�𾴵�{$buyer_name}:\r\n</p>\r\n<p style="" padding-left:="" 30px;="">�������׵ĵ���{$store_name}�Ѿ�ȷ���յ������Ļ��������{$order_sn}�ĸ��������ɣ������Ե��û�����-&gt;�ҵĶ����жԸý��׽������ۡ�\r\n	</p>\r\n<p style="" padding-left:="" 30px;="">�鿴������ϸ��Ϣ������������\r\n</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=member&amp;op=show_order&amp;order_id={$order_id}" target="_blank">{$site_url}/index.php?act=member&amp;op=show_order&amp;order_id={$order_id}</a> \r\n	</p>\r\n<p style="" padding-left:="" 30px;="">�鿴�ҵĶ����б�������������\r\n</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=member&amp;op=order" target="_blank">{$site_url}/index.php?act=member&amp;op=order</a> \r\n	</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$site_name}\r\n</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$mail_send_time}\r\n	</p>', 0, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[�����]</strong>������ȷ���˶������ʼ�֪ͨ', '{$site_name}����:����{$store_name}��ȷ�������Ķ���', 'email_tobuyer_confirm_cod_order_notify', '�𾴵�{$buyer_name}:\r\n<p style="" padding-left:="" 30px;="">�������׵ĵ���{$store_name}�Ѿ�ȷ�������Ļ��������{$order_sn}�������ĵȴ�������\r\n	</p>\r\n<p style="" padding-left:="" 30px;="">�鿴������ϸ��Ϣ������������\r\n</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=member&amp;op=show_order&amp;order_id={$order_id}" target="_blank">{$site_url}/index.php?act=member&amp;op=show_order&amp;order_id={$order_id}</a> \r\n	</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$site_name}\r\n</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$mail_send_time}\r\n	</p>', 0, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[�����]</strong>���������ɵ��ʼ�֪ͨ', '{$site_name}����:���Ķ���������', 'email_tobuyer_new_order_notify', '�𾴵�{$buyer_name}:\r\n<p style="" padding-left:="" 30px;="">����{$site_name}���µĶ��������ɣ�������{$order_sn}��\r\n	</p>\r\n<p style="" padding-left:="" 30px;="">�鿴������ϸ��Ϣ������������\r\n</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=member&amp;op=show_order&amp;order_id={$order_id}" target="_blank">{$site_url}/index.php?act=member&amp;op=show_order&amp;order_id={$order_id}</a> \r\n	</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$site_name}\r\n</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$mail_send_time}\r\n	</p>', 0, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[�����]</strong>����ȷ���յ�����֧���Ļ�����ʼ�֪ͨ', '{$site_name}����:����{$store_name}��ȷ���յ���������֧���Ļ���', 'email_tobuyer_offline_pay_success_notify', '�𾴵�{$buyer_name}:\r\n<p style="" padding-left:="" 30px;="">�������׵ĵ���{$store_name}�Ѿ�ȷ�����յ������Ķ���{$order_sn}�ĸ�������ĵȴ����ҷ�����\r\n	</p>\r\n<p style="" padding-left:="" 30px;="">�鿴������ϸ��Ϣ������������\r\n</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=member&amp;op=show_order&amp;order_id={$order_id}" target="_blank">{$site_url}/index.php?act=member&amp;op=show_order&amp;order_id={$order_id}</a> \r\n	</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$site_name}\r\n</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$mail_send_time}\r\n	</p>', 0, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[�����]</strong>�����ѷ������ʼ�֪ͨ', '{$site_name}����:���Ķ���{$order_sn}�ѷ���', 'email_tobuyer_shipped_notify', '�𾴵�{$buyer_name}:\r\n<p style="" padding-left:="" 30px;="">�������׵ĵ���{$store_name}�Ѿ������Ķ���{$order_sn}�����ˣ���ע����ա�\r\n	</p>\r\n<p style="" padding-left:="" 30px;="">�������ţ�{$invoice_no}\r\n</p>\r\n<p style="" padding-left:="" 30px;="">�鿴������ϸ��Ϣ������������\r\n	</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=member&amp;op=show_order&amp;order_id={$order_id}" target="_blank">{$site_url}/index.php?act=member&amp;op=show_order&amp;order_id={$order_id}</a> \r\n</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$site_name}\r\n	</p>\r\n	<div style="text-align:right;">\r\n	</div>\r\n<p style="text-align: right;" text-align:="" right;="">{$mail_send_time}\r\n</p>', 0, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[������]</strong>���ȡ���˶������ʼ�֪ͨ', '{$site_name}����:���{$buyer_name}ȡ���˶���{$order_sn}', 'email_toseller_cancel_order_notify', '�𾴵�{$seller_name}:\r\n<p style="" padding-left:="" 30px;="">���{$buyer_name}�Ѿ�ȡ�����������׵Ķ���{$order_sn}��</p>\r\n<p style="" padding-left:="" 30px;="">ԭ��{$reason}</p>\r\n<p style="" padding-left:="" 30px;="">�鿴������ϸ��Ϣ������������</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=store&amp;op=show_order&amp;order_id={$order_id}" target="_blank">{$site_url}/index.php?act=store&amp;op=show_order&amp;order_id={$order_id}</a></p>\r\n<p style="" padding-left:="" 30px;="">�鿴���Ķ����б����ҳ������������</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=store&amp;op=store_order" target="_blank">{$site_url}/index.php?act=store&amp;op=store_order</a></p>\r\n<p style="text-align: right;" text-align:="" right;="">{$site_name}</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$mail_send_time}</p>', 0, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[������]</strong>���ȷ���˶�������ɽ��׵��ʼ�֪ͨ', '{$site_name}����:���ȷ�����������׵Ķ���{$order_sn}���������', 'email_toseller_finish_notify', '�𾴵�{$seller_name}:\r\n<p style="" padding-left:="" 30px;="">���{$buyer_name}�Ѿ�ȷ�����������׵Ķ���{$order_sn}���������</p>\r\n<p style="" padding-left:="" 30px;="">�鿴������ϸ��Ϣ������������</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=store&amp;op=show_order&amp;order_id={$order_id}" target="_blank">{$site_url}/index.php?act=store&amp;op=show_order&amp;order_id={$order_id}</a></p>\r\n<p style="" padding-left:="" 30px;="">�鿴���Ķ����б����ҳ������������</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=store&amp;op=store_order" target="_blank">{$site_url}/index.php?act=store&amp;op=store_order</a></p>\r\n<p style="text-align: right;" text-align:="" right;="">{$site_name}</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$mail_send_time}</p>', 0, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[������]</strong>���¶�����Ҫ������ʼ�֪ͨ', '{$site_name}����:����һ���¶�����Ҫ����', 'email_toseller_new_order_notify', '�𾴵�{$seller_name}:\r\n<p style="" padding-left:="" 30px;="">����һ���µĶ�����Ҫ����������{$order_sn}���뾡�촦��</p>\r\n<p style="" padding-left:="" 30px;="">�鿴������ϸ��Ϣ������������</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=store&amp;op=show_order&amp;order_id={$order_id}" target="_blank">{$site_url}/index.php?act=store&amp;op=show_order&amp;order_id={$order_id}</a></p>\r\n<p style="" padding-left:="" 30px;="">�鿴���Ķ����б����ҳ������������</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=store&amp;op=store_order" target="_blank">{$site_url}/index.php?act=store&amp;op=store_order</a></p>\r\n<p style="text-align: right;" text-align:="" right;="">{$site_name}</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$mail_send_time}</p>', 0, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[������]</strong>����Ѿ�������¸�����ʼ�֪ͨ', '{$site_name}����:���{$buyer_name}��ͨ������֧��֧���˶����ķ���', 'email_toseller_offline_pay_notify', '�𾴵�{$seller_name}:\r\n<p style="" padding-left:="" 30px;="">���{$buyer_name}��ͨ������֧��֧�����������׵Ķ���{$order_sn}����ע����ա�</p>\r\n<p style="" padding-left:="" 30px;="">֧����Ϣ��{$pay_message}</p>\r\n<p style="" padding-left:="" 30px;="">�鿴������ϸ��Ϣ������������</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=store&amp;op=show_order&amp;order_id={$order_id}" target="_blank">{$site_url}/index.php?act=store&amp;op=show_order&amp;order_id={$order_id}</a></p>\r\n<p style="" padding-left:="" 30px;="">�鿴���Ķ����б����ҳ������������</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=store&amp;op=store_order" target="_blank">{$site_url}/index.php?act=store&amp;op=store_order</a></p>\r\n<p style="text-align: right;" text-align:="" right;="">{$site_name}</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$mail_send_time}</p>', 0, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[������]</strong>����Ѹ�����ʼ�֪ͨ', '{$site_name}����:���{$buyer_name}�Ѹ���', 'email_toseller_online_pay_success_notify', '�𾴵�{$seller_name}:\r\n<p style="" padding-left:="" 30px;="">���{$buyer_name}��ͨ������֧������˶���{$.order_sn}�ĸ�����ʵ�����찲�ŷ�����</p>\r\n<p style="" padding-left:="" 30px;="">�鿴������ϸ��Ϣ������������</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=store&amp;op=show_order&amp;order_id={$order_id}" target="_blank">{$site_url}/index.php?act=store&amp;op=show_order&amp;order_id={$order_id}</a></p>\r\n<p style="" padding-left:="" 30px;="">�鿴���Ķ����б����ҳ������������</p>\r\n<p style="" padding-left:="" 30px;=""><a href="{$site_url}/index.php?act=store&amp;op=store_order" target="_blank">{$site_url}/index.php?act=store&amp;op=store_order</a></p>\r\n<p style="text-align: right;" text-align:="" right;="">{$site_name}</p>\r\n<p style="text-align: right;" text-align:="" right;="">{$mail_send_time}</p>', 0, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[���û�]</strong>�û��޸���������ʼ�֪ͨ', '{$site_name}����:{$user_name}�޸���������', 'email_touser_find_password', '<p>�𾴵�{$user_name}:</p>\r\n<p>����, ���ղ���{$site_name}�������������룬����������Ϊ<span style="color:#ff9900;">{$new_password}</span>��</p>\r\n<p>����<a href="{$site_url}" target="_blank">{$site_url}</a>��¼���޸����������롣</p>\r\n<p style="text-align:right;">{$site_name}</p>\r\n<p style="text-align:right;">{$mail_send_time}</p>', 0, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[������]</strong>���̱�����Ա�ر�ʱ��֪ͨ', NULL, 'msg_toseller_store_closed_notify', '���ĵ����ѱ��رգ�ԭ���ǣ�{$reason}', 1, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[������]</strong>���̹��ڱ��Զ��ر�ʱ��֪ͨ', NULL, 'msg_toseller_store_expired_closed_notify', '���ĵ����ѱ��رգ�ԭ���ǣ������ѵ���', 1, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[������]</strong>��Ʒ������Աɾ��ʱ��֪ͨ', NULL, 'msg_toseller_goods_droped_notify', '����Աɾ����������Ʒ��{$goods_name}\\r\\nԭ���ǣ�{$reason}', 1, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[������]</strong>Ʒ������ͨ�����ʱ��֪ͨ', NULL, 'msg_toseller_brand_passed_notify', '��ϲ���������Ʒ�� {$brand_name} ��ͨ����ˡ�', 1, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[������]</strong>Ʒ�����뱻�ܾ�ʱ��֪ͨ', NULL, 'msg_toseller_brand_refused_notify', '��Ǹ���������Ʒ�� {$brand_name} �ѱ��ܾ���ԭ�����£�\\r\\n{$reason}', 1, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[������]</strong>���̱�����Աɾ��ʱ��֪ͨ', NULL, 'msg_toseller_store_droped_notify', '���ĵ����ѱ�ɾ��', 1, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[������]</strong>�������뱻ͨ��ʱ��֪ͨ', NULL, 'msg_toseller_store_passed_notify', '��ϲ�����ĵ����ѿ�ͨ���Ͽ����û����ķ�����Ʒ�ɡ�', 1, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[������]</strong>�������뱻�ܾ�ʱ��֪ͨ', NULL, 'msg_toseller_store_refused_notify', '��Ǹ�����Ŀ��������ѱ��ܾ���ԭ�����£� {$reason}', 1, 0);
INSERT INTO `#__mail_msg_temlates` (`name`, `title`, `code`, `content`, `type`, `mail_switch`) VALUES('<strong>[������]</strong>��������ײͺ�Ľ������֪ͨ', NULL, 'msg_toseller_bundling_gold_consume_notify', '���ɹ���������ײͻ{$buy_month}���£�����{$bundling_price}��ң��ܹ�����{$pay_gold}��ң�ʱ���{$mail_send_time}��ʼ����', 1, 1);

INSERT INTO `#__navigation` (`nav_id`, `nav_type`, `nav_title`, `nav_url`, `nav_location`, `nav_new_open`, `nav_sort`, `item_id`) VALUES(6, 0, '����ShopNC', 'index.php?act=article&article_id=22', 2, 0, 255, 0);
INSERT INTO `#__navigation` (`nav_id`, `nav_type`, `nav_title`, `nav_url`, `nav_location`, `nav_new_open`, `nav_sort`, `item_id`) VALUES(7, 0, '��ϵ����', 'index.php?act=article&article_id=23', 2, 0, 240, 0);
INSERT INTO `#__navigation` (`nav_id`, `nav_type`, `nav_title`, `nav_url`, `nav_location`, `nav_new_open`, `nav_sort`, `item_id`) VALUES(8, 0, '������', 'index.php?act=article&article_id=25', 2, 0, 220, 0);
INSERT INTO `#__navigation` (`nav_id`, `nav_type`, `nav_title`, `nav_url`, `nav_location`, `nav_new_open`, `nav_sort`, `item_id`) VALUES(9, 0, '��ƸӢ��', 'index.php?act=article&article_id=24', 2, 0, 210, 0);

INSERT INTO `#__recommend` (`recommend_id`, `recommend_name`, `recommend_code`, `recommend_desc`, `recommend_config`) VALUES (1, '�ر��Ƽ�', 'best_item', '���������Ʒ������ҳ���ر��Ƽ�������ʾ', NULL);

INSERT INTO `#__goods_class` (`gc_id`, `gc_name`, `type_id`, `type_name`, `store_id`, `gc_parent_id`, `gc_sort`, `gc_show`) VALUES(1, '��Ů��װ', 1, '��װ', 0, 0, 1, 1);
INSERT INTO `#__goods_class` (`gc_id`, `gc_name`, `type_id`, `type_name`, `store_id`, `gc_parent_id`, `gc_sort`, `gc_show`) VALUES(2, 'Ь������', 0, '', 0, 0, 2, 1);
INSERT INTO `#__goods_class` (`gc_id`, `gc_name`, `type_id`, `type_name`, `store_id`, `gc_parent_id`, `gc_sort`, `gc_show`) VALUES(3, '������ױ', 0, '', 0, 0, 3, 1);
INSERT INTO `#__goods_class` (`gc_id`, `gc_name`, `type_id`, `type_name`, `store_id`, `gc_parent_id`, `gc_sort`, `gc_show`) VALUES(4, '����ҵ�', 0, '', 0, 0, 5, 1);
INSERT INTO `#__goods_class` (`gc_id`, `gc_name`, `type_id`, `type_name`, `store_id`, `gc_parent_id`, `gc_sort`, `gc_show`) VALUES(5, '�ҾӼ�װ', 0, '', 0, 0, 6, 1);
INSERT INTO `#__goods_class` (`gc_id`, `gc_name`, `type_id`, `type_name`, `store_id`, `gc_parent_id`, `gc_sort`, `gc_show`) VALUES(6, 'ʳƷ����', 0, '', 0, 0, 7, 1);
INSERT INTO `#__goods_class` (`gc_id`, `gc_name`, `type_id`, `type_name`, `store_id`, `gc_parent_id`, `gc_sort`, `gc_show`) VALUES(7, 'ĸӤ��Ʒ', 0, '', 0, 0, 8, 1);
INSERT INTO `#__goods_class` (`gc_id`, `gc_name`, `type_id`, `type_name`, `store_id`, `gc_parent_id`, `gc_sort`, `gc_show`) VALUES(8, '�˶�����', 0, '', 0, 0, 4, 1);
INSERT INTO `#__goods_class` (`gc_id`, `gc_name`, `type_id`, `type_name`, `store_id`, `gc_parent_id`, `gc_sort`, `gc_show`) VALUES(9, '�Ļ�����', 0, '', 0, 0, 9, 1);
INSERT INTO `#__goods_class` (`gc_id`, `gc_name`, `type_id`, `type_name`, `store_id`, `gc_parent_id`, `gc_sort`, `gc_show`) VALUES(10, '��������', 0, '', 0, 0, 10, 1);
INSERT INTO `#__goods_class` (`gc_id`, `gc_name`, `type_id`, `type_name`, `store_id`, `gc_parent_id`, `gc_sort`, `gc_show`) VALUES(11, 'Ʊ������', 0, '', 0, 0, 11, 1);
INSERT INTO `#__goods_class` (`gc_id`, `gc_name`, `type_id`, `type_name`, `store_id`, `gc_parent_id`, `gc_sort`, `gc_show`) VALUES(12, 'Ůװ', 1, '��װ', 0, 1, 255, 1);
INSERT INTO `#__goods_class` (`gc_id`, `gc_name`, `type_id`, `type_name`, `store_id`, `gc_parent_id`, `gc_sort`, `gc_show`) VALUES(13, '��װ', 1, '��װ', 0, 1, 255, 1);
INSERT INTO `#__goods_class` (`gc_id`, `gc_name`, `type_id`, `type_name`, `store_id`, `gc_parent_id`, `gc_sort`, `gc_show`) VALUES(14, '����/˯��', 1, '��װ', 0, 1, 255, 1);
INSERT INTO `#__goods_class` (`gc_id`, `gc_name`, `type_id`, `type_name`, `store_id`, `gc_parent_id`, `gc_sort`, `gc_show`) VALUES(15, '���޷�', 1, '��װ', 0, 13, 255, 1);
INSERT INTO `#__goods_class` (`gc_id`, `gc_name`, `type_id`, `type_name`, `store_id`, `gc_parent_id`, `gc_sort`, `gc_show`) VALUES(16, '����', 1, '��װ', 0, 12, 255, 1);

INSERT INTO `#__type` (`type_id`, `type_name`, `type_sort`) VALUES(1, '��װ', 1);
INSERT INTO `#__type` (`type_id`, `type_name`, `type_sort`) VALUES(2, 'Ь��', 2);
INSERT INTO `#__type` (`type_id`, `type_name`, `type_sort`) VALUES(3, '���', 3);
INSERT INTO `#__type` (`type_id`, `type_name`, `type_sort`) VALUES(4, '���', 4);
INSERT INTO `#__type` (`type_id`, `type_name`, `type_sort`) VALUES(5, '�����', 1);

INSERT INTO `#__spec` (`sp_id`, `sp_name`, `sp_format`, `sp_value`, `sp_sort`) VALUES(1, '��ɫ', 'image', '��ɫ,��ɫ,��ɫ,��ɫ,��ɫ,��ɫ,��ɫ,��ɫ,��ɫ,��ɫ,��ɫ,͸��', 1);
INSERT INTO `#__spec` (`sp_id`, `sp_name`, `sp_format`, `sp_value`, `sp_sort`) VALUES(2, '����', 'text', 'XXS,XS,S,M,L,XL,XXL,XXXL,�Ӵ�XXXL,����', 2);
INSERT INTO `#__spec` (`sp_id`, `sp_name`, `sp_format`, `sp_value`, `sp_sort`) VALUES(3, 'Ь��', 'text', '35,45,44,43,42,41,40,39,38,37,36,46', 3);

INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(1, '��ɫ', 1, 'c53bca14dc85bb3af17d8fe91b34e4b2.png_small.png', 0);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(2, '��ɫ', 1, 'ec769a6ddb0704a805bfe5f4b917dbfc.png_small.png', 1);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(3, '��ɫ', 1, '7e79c94b506b4f26064c5ad9cf415d6a.png_small.png', 2);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(4, '��ɫ', 1, '36dffaac297ed95204d5a5e7ffc9cfc0.png_small.png', 3);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(5, '��ɫ', 1, 'cd0a502349ba45ff6e57a9c56faead64.png_small.png', 4);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(6, '��ɫ', 1, '51e66b9e43213cc8eddf6038477dc0ea.png_small.png', 5);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(7, '��ɫ', 1, '17cac2d3e7c5f7a3d258912287c86cf5.png_small.png', 6);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(8, '��ɫ', 1, 'dd12d18ad6d68331149083265ee225f9.png_small.png', 7);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(9, '��ɫ', 1, '9984776d635bd493b9b83a59712283e2.png_small.png', 8);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(10, '��ɫ', 1, '27f09f244c0aea8157d81e9f59e3a2ed.png_small.png', 9);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(11, '��ɫ', 1, 'b700b535d2995468263e92541e2f74c9.png_small.png', 10);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(12, '͸��', 1, '81416e9137b049dc494fbc21e18aac58.png_small.png', 11);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(13, 'XXS', 2, '', 1);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(14, 'XS', 2, '', 2);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(15, 'S', 2, '', 3);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(16, 'M', 2, '', 4);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(17, 'L', 2, '', 5);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(18, 'XL', 2, '', 6);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(19, 'XXL', 2, '', 7);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(20, 'XXXL', 2, '', 8);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(21, '�Ӵ�XXXL', 2, '', 9);
INSERT INTO `#__spec_value` (`sp_value_id`, `sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) VALUES(22, '����', 2, '', 10);
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

INSERT INTO `#__store_class` (`sc_id`, `sc_name`, `sc_parent_id`, `sc_sort`) VALUES(4, '��װЬ��', 0, 1);
INSERT INTO `#__store_class` (`sc_id`, `sc_name`, `sc_parent_id`, `sc_sort`) VALUES(13, 'Ůװ', 4, 2);
INSERT INTO `#__store_class` (`sc_id`, `sc_name`, `sc_parent_id`, `sc_sort`) VALUES(14, '��װ', 4, 2);
INSERT INTO `#__store_class` (`sc_id`, `sc_name`, `sc_parent_id`, `sc_sort`) VALUES(15, 'ŮЬ', 4, 3);
INSERT INTO `#__store_class` (`sc_id`, `sc_name`, `sc_parent_id`, `sc_sort`) VALUES(16, '�˶�Ь', 4, 4);
INSERT INTO `#__store_class` (`sc_id`, `sc_name`, `sc_parent_id`, `sc_sort`) VALUES(17, '��Ь/ƤЬ/����Ь', 4, 5);
INSERT INTO `#__store_class` (`sc_id`, `sc_name`, `sc_parent_id`, `sc_sort`) VALUES(18, '�˶���/�˶���/�������', 4, 6);

INSERT INTO `#__inform_subject_type` (`inform_type_id`, `inform_type_name`, `inform_type_desc`, `inform_type_state`) VALUES (1, '���۽���Ʒ', '�����̳ǽ�ֹ�����ƽ��׹��������涨��������Ʒ��', 1);

INSERT INTO `#__inform_subject` (`inform_subject_id`, `inform_subject_content`, `inform_subject_type_id`, `inform_subject_type_name`, `inform_subject_state`) VALUES (1, '���Ƶ��ߡ������ࡢ����������', 1, '���۽���Ʒ', 1);
INSERT INTO `#__inform_subject` (`inform_subject_id`, `inform_subject_content`, `inform_subject_type_id`, `inform_subject_type_name`, `inform_subject_state`) VALUES (2, '�Ĳ��þ���', 1, '���۽���Ʒ', 1);
INSERT INTO `#__inform_subject` (`inform_subject_id`, `inform_subject_content`, `inform_subject_type_id`, `inform_subject_type_name`, `inform_subject_state`) VALUES (3, 'ǹ֧��ҩ', 1, '���۽���Ʒ', 1);
INSERT INTO `#__inform_subject` (`inform_subject_id`, `inform_subject_content`, `inform_subject_type_id`, `inform_subject_type_name`, `inform_subject_state`) VALUES (4, '��Ʒ����������', 1, '���۽���Ʒ', 1);

INSERT INTO `#__complain_subject` (`complain_subject_id`, `complain_subject_content`, `complain_subject_desc`, `complain_subject_type`, `complain_subject_state`) VALUES (1, '���Ҳ�ͬ���˿�', '��������˿�ܾ���', 1, 2);
INSERT INTO `#__complain_subject` (`complain_subject_id`, `complain_subject_content`, `complain_subject_desc`, `complain_subject_type`, `complain_subject_state`) VALUES (7, 'δ�յ���', '���׳ɹ���δ�յ�����Ǯ�Ѿ��������ң��ɽ���άȨ��', 1, 1);
INSERT INTO `#__complain_subject` (`complain_subject_id`, `complain_subject_content`, `complain_subject_desc`, `complain_subject_type`, `complain_subject_state`) VALUES (8, '�ۺ��Ϸ���', '������ɺ�30���ڣ���ʹ����Ʒ�����У�������Ʒ������������޷�����ʹ�ã��ɽ���άȨ��', 1, 1);
INSERT INTO `#__complain_subject` (`complain_subject_id`, `complain_subject_content`, `complain_subject_desc`, `complain_subject_type`, `complain_subject_state`) VALUES (9, 'δ�յ�����', '�����Ѿ�������δ�յ������Ʒ�Ѿ��ĸ���ң��ɽ���άȨ��', 2, 1);

INSERT INTO `#__voucher_price` (`voucher_price_id`, `voucher_price_describe`, `voucher_price`) VALUES (1, '10Ԫ���', 10);
INSERT INTO `#__voucher_price` (`voucher_price_id`, `voucher_price_describe`, `voucher_price`) VALUES (2, '50Ԫ���', 50);

INSERT INTO `#__store_grade` (`sg_id`, `sg_name`, `sg_goods_limit`, `sg_album_limit`, `sg_space_limit`, `sg_template_number`, `sg_template`, `sg_price`, `sg_confirm`, `sg_description`, `sg_function`, `sg_sort`) VALUES(1, 'ϵͳĬ��', 100, 500, 100, 6, 'default|style1|style2|style3|style4|style5', '100Ԫ/��', 0, '�û�ѡ��Ĭ�ϵȼ���������������ͨ��', '', 0);
INSERT INTO `#__store_grade` (`sg_id`, `sg_name`, `sg_goods_limit`, `sg_album_limit`, `sg_space_limit`, `sg_template_number`, `sg_template`, `sg_price`, `sg_confirm`, `sg_description`, `sg_function`, `sg_sort`) VALUES(2, '�׽����', 200, 1000, 100, 6, 'default|style1|style2|style3|style4|style5', '200Ԫ/��', 1, '���ܸ�����Ȩ', 'editor_multimedia', 2);

INSERT INTO `#__document` (`doc_id`, `doc_code`, `doc_title`, `doc_content`, `doc_time`) VALUES(1, 'agreement', '�û�����Э��', '<p>�ر������û������Ķ������û�����Э�顷(�³ơ�Э�顷) �и�������������ܱ���Э�顷�����������Ȩʹ�ñ���վ�ṩ����ط�������ʹ����Ϊ����Ϊ�Ա���Э�顷�Ľ��ܣ���ͬ����ܱ���Э�顷���������Լ���� <br /> <br /> <strong>һ������</strong><br /></p>\r\n<ol>\r\n<li>"�û�"ָ���ϱ�Э�����涨��������ͬ�����ر���վ���ֹ�����������������ڱ�Э�飩����ʹ�ñ���վ�ĸ��˻������</li>\r\n<li>"����"��ָ�ڱ���վ�ϳ�����Ʒ���û���"���"��ָ�ڱ���վ������Ʒ���û���</li>\r\n<li>"�ɽ�"ָ��Ҹ������������ǵĽ���Ҫ�����ض�ʱ����������ŵĽ������������ȡ�������������������ý�����Ʒ��Ȩ����</li>\r\n</ol>\r\n<p><br /> <br /> <strong>�����û��ʸ�</strong><br /> <br /> ֻ�з�����������֮һ����Ա��ʵ����������Ϊ����վ�û�������ʹ�ñ���վ�ķ���</p>\r\n<ol>\r\n<li>����ʮ���꣬����������Ȩ��������������Ϊ��������Ȼ�ˣ�</li>\r\n<li>δ��ʮ���꣬���໤�ˣ��������������ڸ�ĸ����������ͬ�����Ȼ�ˣ�</li>\r\n<li>�����й����ɻ������ط��ɡ������/����³������Ϸ����ڵĹ�˾������ҵ��λ��������֯��������֯��</li>\r\n</ol>\r\n<p><br /> ��������Ϊ�����ˡ�����������Ϊ�������Լ��޾�Ӫ���ض���Ӫ�ʸ����֯����ע��Ϊ����վ�û��򳬹�������Ȩ������Ϊ������Χ���½��׵ģ����뱾��վ֮���Э����ʼ��Ч������վһ�����֣���Ȩ����ע�����û�����׷����ʹ�ñ���վ"����"��һ�з������Ρ�<br /> <br /> <strong>��.�û���Ȩ��������</strong><br /></p>\r\n<ol>\r\n<li>�û���Ȩ���ݱ�Э��Ĺ涨������վ��������ع������ñ���վ���Ͻ���ƽ̨��¼��Ʒ������������Ϣ����ѯ��Ʒ��Ϣ��������Ʒ���������û�������Ʒ������ͬ���ڱ���վ�����������μӱ���վ���йػ����Ȩ���ܱ���վ�ṩ���������й���Ѷ����Ϣ����</li>\r\n<li>�û���Ȩ������Ҫ��������ͽ������롣�û�Ӧ���Ը��û������е����л���¼���ȫ�����Ρ�</li>\r\n<li>�û�������ȷ������վ�ṩ���κ����ϡ�ע����Ϣ��ʵ׼ȷ����������������ʵ���������֤�š���ϵ�绰����ַ����������ȡ���֤����վ�������û�����ͨ��������ϵ��ʽ���Լ�������ϵ��ͬʱ���û�Ҳ���������������ʵ�ʱ��ʱ��ʱ�����й�ע�����ϡ�</li>\r\n<li>�û��������κ���ʽ����ת�û���Ȩ����ʹ���Լ��ڱ���վ���û��ʺš�</li>\r\n<li>�û�������ȷ���ڱ���վ���Ͻ���ƽ̨�ϵ�¼��Ʒ�������Ľ�����Ϣ��ʵ��׼ȷ�������ԡ�</li>\r\n<li>�û������ڱ���վ���Ͻ���ƽ̨�������ҽ�ֹ���۵Ļ��������۵���Ʒ�����������ַ�����֪ʶ��Ȩ�������Ϸ�Ȩ�����Ʒ��Ҳ��������Υ����ṫ������򹫹����µ���Ʒ��</li>\r\n<li>�û������ڱ���վ��������Υ����Υ����Ϣ����������������Ʒ��Ϣ��������Ϣ���������ӡ���Ʒ���ԣ��������ԣ��������ݵȡ�</li>\r\n<li>�û��ڱ���վ������Ӧ�����س�ʵ����ԭ�򣬲����Ը�Ԥ�������Ʒ�۸�Ȳ�����������ʽ�������Ͻ������򣬲��ô��������Ͻ����޹صĲ�����Ϊ�������ڽ���ƽ̨�Ϸ����κ�Υ����Ϣ��</li>\r\n<li>�û���Ӧ��ȡ�������ֶΣ���������������ٽ��ס����������ȷ�ʽ�����������������öȣ�����ò������ֶζ������������û������������û����öȡ�</li>\r\n<li>�û���ŵ�Լ���ʹ�ñ���վ���Ͻ���ƽ̨ʵʩ��������Ϊ���ع��ҷ��ɡ�����ͱ���վ����ع涨�Լ�������ṫ������򹫹����¡������κη��ɺ���ķ������û������Լ�����������е�������Ӧ�ķ������Ρ�</li>\r\n<li>�û��ڱ���վ���Ͻ��׹��������������û����ײ������ף�����������վ��������Э�����û��緢�������û���Υ����Υ����Э�����Ϊ����������վ�ٱ������û������Ͻ����������û��������ϵģ��û���Ȩͨ��˾������Ҫ����վ�ṩ������ϡ�</li>\r\n<li>�û�Ӧ���ге����ײ�������ط��ã���������˰��</li>\r\n<li>δ������վ���������û����ý�����վ�����Լ��ڽ���ƽ̨����չʾ���κ���Ϣ�Ը��ơ��޸ġ��������ʽ����������Ʒ���ַ��򹫿�չʾ��</li>\r\n<li>�û�ͬ��������Ա���վ����Ϣ�������������ڻ��Ϣ��������Ϣ��������Ϣ�ȡ�</li>\r\n</ol>\r\n<p><br /> <br /> <strong>�ġ� ����վ��Ȩ��������</strong><br /></p>\r\n<ol>\r\n<li>����վ���Ǵ�ͳ�����ϵ�"������"����Ϊ�û��ṩһ����Ϣ������������Ʒ������ƽ̨���䵱����˫��֮��Ľ���ý�飬���������������Ĵ����̡��ϻ�  �ˡ���Ա������Ⱦ�Ӫ��ϵ�ˡ������ڱ���վ�ϵĽ�����Ʒ���û������ϴ����н��׵���Ʒ�����Ǳ���վ���С������û�������Ʒ���ṩ����Ϣ����뾺��Ĺ��̣�  ����վ�������Լ��ӻ���ƣ��಻������Ʒ�Ľ��׹��̣��������͡�����˿覴õ�����������������Ҳ��е�������Ʒ����Ʒ�ʡ�Ȩ���ϵ�覴��Լ�����  �����н���Э����������������κ����Σ����ڳ����������ϵ���ƷƷ�ʡ���ȫ�Ի�Ϸ��ԣ�����վ�����豣֤��</li>\r\n<li>����վ�����������м���ˮƽ�Ļ�����Ŭ��ȷ���������Ͻ���ƽ̨���������У�������������жϻ��ж�ʱ�����������ʱ���ڣ���֤�û����Ͻ��׻��˳�����С�</li>\r\n<li>����վ��������û���ע��ʹ�ñ���վ���Ͻ���ƽ̨�������������⼰��ӳ�������ʱ�����ظ��� </li>\r\n<li>����վ��Ȩ���û���ע�����Ͻ��в��ģ��Դ����κ�������ɵ�ע�����ϣ�����վ��Ȩ����֪ͨѯ���û���Ҫ���û��������͡���������ֱ������������ɾ���ȴ���</li>\r\n<li>��  �����ڱ���վ���Ͻ����������û��������׵ģ��û�ͨ��˾�����Ż������������շ�������Ҫ����վ�ṩ������ϣ�����վ��������ϲ��ṩ�й����ϣ��û�����  �׸�֪����վ������վ֪Ϥ��������ģ�����˺󣬱���վ��Ȩͨ�������ʼ����绰��ϵ�����˫���˽����������������˽�����ͨ�������ʼ�����֪ͨ��  ���� </li>\r\n<li>�����Ͻ���ƽ̨�������ԣ�����վû������������û���ע�����ϡ����еĽ�����Ϊ�Լ��뽻���йص������������������飬���緢���������Σ�����վ��Ȩ�����û��Ļ�����û���ʵ�й����ϡ���������֪ͨ����ʱ��ֹ�������ڵ���ֹ���ܾ�����û��ṩ����         \r\n<ul>\r\n<li>�û�Υ����Э������ἰ�����뱾Э����ļ���</li>\r\n<li>�����û�������������֪ͨ����վ����Ϊĳ���û�����彻���������Υ���򲻵���Ϊ�����ṩ���֤�ݣ�������վ�޷���ϵ�����û���֤����֤���û�����վ�ṩ���κ����ϣ�</li>\r\n<li>�����û�������������֪ͨ����վ����Ϊĳ���û�����彻���������Υ���򲻵���Ϊ�����ṩ���֤�ݡ�����վ����ͨ��רҵ�����ߵ�֪ʶˮƽ��׼��������ݽ����б𣬿���������Ϊ��Щ���ݻ���Ϊ���ܶԱ���վ�û�����վ��ɲ�����ʧ�������Ρ� </li>\r\n</ul>\r\n</li>\r\n<li>�ڷ�������թ�ж��У����ű�������û������ԭ�򣬵��û��ٱ��Լ����׿��ܴ�����թ��������������ʱ������վ��Ȩͨ�������ж���ʱ��������û��˺ţ�����Ȩ�˶Ե�����������ϼ�Ҫ���ṩ�������֤�����ϡ�</li>\r\n<li>���ݹ��ҷ��ɷ��桢��Э������ݺͱ���վ�����յ���ʵ���ݣ������϶��û�����Υ����Υ����Э����Ϊ�Լ��ڱ���վ����ƽ̨�ϵ�����������Ϊ������վ��Ȩ�ڱ���վ����ƽ̨��������վ�������緢����ʽ�����û���Υ����Ϊ������Ȩ��ʱ����ɾ�������Ϣ�������������û���ͬ�⡣</li>\r\n<li>��  ��վ��Ȩ�ڲ�֪ͨ�û���ǰ����ɾ�����ȡ���������Դ�ʩ����������Ϣ���������������Թ�ܷ���ΪĿ�ģ��Գ�������ΪĿ�ģ�������թ�ȶ����������ݣ�����  �Ͻ����޹ػ����Խ���ΪĿ�ģ����ڶ��⾺�ۻ�������ͼ�������������������أ�����ϢΥ�������������������𺦱���վ�������û��Ϸ�����ġ�</li>\r\n<li>��  �����豾��վ���ҵġ�ȫ��ͨ�õġ����õġ���ѵ���Ϣ���ʹ��Ȩ��������վ��Ȩ�Ը�Ȩ����������Ȩ��������Ȩ����վ��Ȩ(ȫ���򲿷ݵ�)  ʹ�á����ơ��޶�����д�����������롢�ַ���ִ�к�չʾ�û���ʾ����վ�ĸ�����Ϣ��������������Ʒ����������֪���պ󿪷����κ���ʽ��ý�������������  ��Ϣ����������Ʒ�ڡ�</li>\r\n</ol>\r\n<p><br /> <br /> <strong>�塢������жϺ���ֹ</strong><br /></p>\r\n<ol>\r\n<li>��  ����վδ���û���ȡ��ط�����õ�����£�����վ������ȫȨ�������κ�����  (�����������ڱ���վ��Ϊ�û���Υ����Э�����������;��񣬻��û��ڳ���180����δ��¼����վ��)  ��ֹ���û��ķ��񣬲����ٱ����û��ڱ���վ��ȫ�����ϣ��������������û���Ϣ����Ʒ��Ϣ��������Ϣ�ȣ���ͬʱ����վ������ȫȨ�������ڷ���֪ͨ�򲻷���ͨ  ֪������£���ʱֹͣ�ṩȫ���򲿷ַ��񡣷�����ֹ�󣬱���վû������Ϊ�û�����ԭ�û����ϻ���֮��ص��κ���Ϣ����ת���κ�δ���Ķ����͵���Ϣ���û�  ������������⣬����վ������ֹ���û��ķ�������û����κε������е��κ����Ρ� </li>\r\n<li>���û�����վ���ע������վע���û���ݣ��辭����վ���ͬ�⣬�ɱ���վע����ע���û����û�������뱾��վ��Э���ϵ��������վ�Ա�������Ȩ����         \r\n<ul>\r\n<li>�û�ע���󣬱���վ��Ȩ�������û�������,��������������ǰ���û����ϡ��������ϡ���Ʒ���Ϻͽ��׼�¼�ȡ� </li>\r\n<li>�û�ע�������û���ע��ǰ�ڱ���վ����ƽ̨�ϴ���Υ����Ϊ��Υ����Э�����Ϊ������վ�Կ���ʹ��Э�����涨��Ȩ���� </li>\r\n</ul>\r\n</li>\r\n<li>������������������վ����ͨ��ע���û��ķ�ʽ��ֹ����         \r\n<ul>\r\n<li>���û�Υ����Э����ع涨ʱ������վ��Ȩ��ֹ����û��ṩ���񡣱���վ�����жϷ���ʱ֪ͨ�û���������û��ڱ�����վ��ֹ�ṩ�������һ��ֱ�ӻ��ӻ�����������ע��Ϊ����վ�û��ģ�����վ��Ȩ�ٴε�������ֹΪ���û��ṩ����</li>\r\n<li>һ������վ�����û�ע����������Ҫ��������ٵģ�����վ��Ȩ��ʱ��ֹΪ���û��ṩ���� </li>\r\n<li>��Э����ֹ�����ʱ���û�δȷ���µ�Э��ġ� </li>\r\n<li>��������վ��Ϊ����ֹ���������� </li>\r\n</ul>\r\n</li>\r\n<li>���û�Υ����ط��ɷ������Υ����Э��涨��ԭ�����ʹ����վ�жϡ���ֹ���û�����ģ����ڷ����жϡ���ֹ֮ǰ�û�������Ϊ������ԭ����         \r\n<ul>\r\n<li>����վ��Ȩ�����Ƿ����жϡ���ֹ���û�����ǰ���û����жϻ���ֹ����������ԭ��֪ͨ�û����׹�ϵ���������������ڶԸý�����������δ��ɽ��׵��û�,����ý��׾��۵��û����Ѵ�ɽ���ҪԼ�û���</li>\r\n<li>�����жϡ���ֹ֮ǰ���û��Ѿ��ϴ�������վ����Ʒ��δ���׻�����δ��ɵģ�����վ��Ȩ���жϡ���ֹ�����ͬʱɾ��������Ʒ�������Ϣ�� </li>\r\n<li>�����жϡ���ֹ֮ǰ���û��Ѿ��������û����۵ľ�����Ʒ����ҪԼ����������δ����������վ��Ȩ���жϻ���ֹ�����ͬʱɾ�����û������ҪԼ����Ϣ��</li>\r\n</ul>\r\n</li>\r\n<li>����վ�����û�����Ϊ�������������ڿ��ǵ���Ʒ���ڱ���վ���������ȣ��ֺ��˵�������Ȩ����Υ������ع涨�����ܵ���������׷�����ܵ����ܻ��صĴ���ʱ���û�Ӧ�⳥����վ�����������һ����ʧ�����á�</li>\r\n<li>��Υ����ط��ɷ������Υ����Э��涨����������ص��û�������վ��Ȩ��ֹ���û�����������</li>\r\n</ol>\r\n<p><br /> <br /> <strong>����Э����޶�</strong><br /> <br /> ��Э����ɱ���վ��ʱ�޶��������޶����Э�鹫���ڱ���վ֮�ϣ��޶�������������Թ���ʱ����Ч������Ϊ��Э���һ���֡��û����ڱ�Э���޸�֮���Լ���ʹ�ñ���վ������Ϊ�û����ܺ���Ը�����޶����Э�顣����վ��ʹ�޸Ļ��жϷ���ʱ��������κε���������<br /> <br /> <strong>�ߡ� ����վ�����η�Χ </strong><br /> <br /> ���û����ܸ�Э��ʱ���û�Ӧ��ȷ�˽Ⲣͬ���</p>\r\n<ol>\r\n<li>�Ƿ��ɱ���վ���ػ�ȡ���κ����ϣ����û����п��ǡ����������Ը����գ��������κ����϶������û�����ϵͳ���κ��𻵻�������ʧ���û�Ӧ����ȫ���Ρ�</li>\r\n<li>�û����ɱ���վȡ�õĽ������Ѷ����������ʽ����֣��������ɱ�Э��δ��ʾ�涨���κα�֤��</li>\r\n<li>��������ԭ�����ɵ�����������ʹ�á�������ʧ������������ʧ������վ���е��κ�ֱ�ӡ���ӡ��������ر������Ի�ͷ����⳥����ʹ����վ�ѱ���֪ǰ���⳥�Ŀ����ԣ���         \r\n<ul>\r\n<li>����վ��ʹ�û��޷�ʹ�á�</li>\r\n<li>���ɻ�ͨ������վ�����ȡ�õ��κ���Ʒ�������֮��Ϣ������н�������֮�����������Ʒ������Ĺ���ɱ���</li>\r\n<li>�û��Ĵ���������⵽δ����Ȩ�Ĵ�ȡ������</li>\r\n<li>����վ���κε�����֮��������Ϊ��</li>\r\n<li>����վ����������ˡ�</li>\r\n</ul>\r\n</li>\r\n<li>����վֻ��Ϊ�û��ṩһ�����׵�ƽ̨�������û������ǵĽ�����Ʒ�ĺϷ��ԡ���ʵ�Լ���Ʒ�ʣ��Լ��û����н��׵������ȣ�����վһ�ɲ����κε������Ρ��û������ʹ�ñ���վ�������򿯵��ڱ���վ���κ���Ʒ����������ʱ������վ�����κβ������⳥���Ρ�</li>\r\n<li>��  ��վ�ṩ�������������ϵ���վ����Դ�����ӣ��û����ܻ����������������Ӫ�̾�Ӫ����վ��������ʾ����վ����Щ��Ӫ�����κι�ϵ��������Ӫ�̾�Ӫ����վ��  �ɸ���Ӫ�����и��𣬲����ڱ���վ���Ƽ�����Χ֮�ڡ����ڴ��ڻ���Դ�ڴ�����վ����Դ���κ����ݡ���桢��Ʒ���������ϣ�����վ�಻�豣֤������ʹ  �û������κδ�����վ����Դ�����Ļ��ɴ�����վ����Դ��õ��κ����ݡ���Ʒ��������������κ��𺦻���ʧ������վ�����κ�ֱ�ӻ��ӵ����Ρ�</li>\r\n</ol>\r\n<p><br /> <br /> <strong>��.�����ɿ���</strong><br /> <br /> �򲻿ɿ����������������¼���ʹ�ñ�Э������в����ܡ�����Ҫ����������ģ�˫�������е����Ρ�����ͬ����֮���ɿ�����ָ����Ԥ�������ܱ��Ⲣ���ܿ˷���  �͹������������������ս����̨�硢ˮ�֡����֡��׻�����𡢰չ��������������������ڿ͹��������粡�������Ų��ż������ơ�������Ϊ���κ�������Ȼ����  Ϊ��ɵ����ѵȿ͹������<br /> <br /> <strong>�š���������ʽ</strong><br /></p>\r\n<ol>\r\n<li>��Э�鼰���޶�������Ч�ԡ����к��뱾Э�鼰���޶���Ч���йص��������ˣ������л����񹲺͹����ɹ�Ͻ���κ�����������л����񹲺͹����ɡ�</li>\r\n<li>��  ʹ�ñ���վ�����������뱾��վ���κ����飬��Ӧ�ύ�����ٲ�ίԱ�ᰴ�ոû��ʱ��Ч���ٲù�������ٲá��������Ӧ�����ٲã��������κ�����������������  ���ٲ��кϲ��������ٲòþ����վ֣��Ը�������Լ������������漰�����鲻�����ٲý�����û�ͬ��һ������������Ժ��Ͻ��</li>\r\n</ol>', 1293773586);
INSERT INTO `#__document` (`doc_id`, `doc_code`, `doc_title`, `doc_content`, `doc_time`) VALUES(2, 'real_name', 'ʲô��ʵ����֤', '<p><strong>ʲô��ʵ����֤��</strong></p>\r\n<p>&ldquo;��֤����&rdquo;������һ��Ե��������ʵ��ʶ����񡣵�������ͨ��վ��PM���绰�����ԱEMail�ķ�ʽ ��ϵ�����������֤����������Ա���ȷ���˵�������ʵ��ݣ��Ϳ��Կ�ͨ������֤��</p>\r\n<p>ͨ������֤������˵��������ݵ���ʵ��Ч�ԣ�Ϊ��������罻�׵Ĺ������ṩһ�������ĺͱ�֤��</p>\r\n<p><strong>��֤����ķ�ʽ��</strong></p>\r\n<p>Email��XXXX@XX.com</p>\r\n<p>����Ա��XXXXXX</p>', 1293773817);
INSERT INTO `#__document` (`doc_id`, `doc_code`, `doc_title`, `doc_content`, `doc_time`) VALUES(3, 'real_store', 'ʲô��ʵ�������֤', '<p><strong>ʲô��ʵ�������֤��</strong></p>\r\n<p>&ldquo;��֤����&rdquo;������һ��Ե��������ʵ��ʶ����񡣵�������ͨ��վ��PM���绰�����ԱEMail�ķ�ʽ ��ϵ�����������֤����������Ա���ȷ���˵�������ʵ��ݣ��Ϳ��Կ�ͨ������֤��</p>\r\n<p>ͨ������֤������˵��������ݵ���ʵ��Ч�ԣ�Ϊ��������罻�׵Ĺ������ṩһ�������ĺͱ�֤��</p>\r\n<p><strong>��֤����ķ�ʽ��</strong></p>\r\n<p>Email��XXXX@XX.com</p>\r\n<p>����Ա��XXXXXX</p>', 1293773875);
INSERT INTO `#__document` (`doc_id`, `doc_code`, `doc_title`, `doc_content`, `doc_time`) VALUES(4, 'open_store', '����Э��', '<p>ʹ�ñ���˾�����������ص������������<br /><br />1.�û��ʸ�<br />����˾�ķ���������÷������ܹ�ǩ�����з���Լ�����ĺ�ͬ�ĸ����ṩ��������ʹ�á��ڲ�����ǰ���涨��ǰ���£�����˾�ķ�����18�������»���ʱ����������ֹ���û��ṩ�����������ʸ�����ʹ�ñ���˾�ķ��񡣴��⣬�����ʻ��������������ۣ����û���������������ת�û���ۡ����⣬����˾������������Ը��ֹ����ֹ�����ʻ���Ȩ����<br /><br />2.�������ϣ�����������������ӵ��κ���Ʒ�����ã�<br />*������թ�ԡ���١���׼ȷ������ԣ�<br />*�ַ��κε���������Ȩ��ר��Ȩ���̱�Ȩ����ҵ���ܻ�����ר��Ȩ���򷢱�Ȩ����˽Ȩ��<br />*Υ���κ����õķ��ɻ򷨹棨�������������йس��ڹ��ơ������߱������������������̷��������ӻ�ó�׹���/��ƽó�׷��ɵķ��ɻ򷨹棩��<br />*��������߷̰����ˣ��ֺ����˺Ϸ�Ȩ������ݣ�<br />*�����ࡢɫ�顢�Ĳ�����������ɱ���ֲ����߽�����������ݣ�<br />*���������ƻ����ı䡢ɾ��������Ӱ�졢���ܽ�ȡ��δ����Ȩ���Ӵ��������κ�ϵͳ�����ݻ�������ϵ��κβ�����������ľ����桢��ʱը����ɾ��Ӭ������ڲʵ������������������Գ���<br /><br />3.ΥԼ<br />�緢���������Σ�����˾�����������Ļ������ɾ��������Ʒ���򱾹�˾���������й�������Ϊ�ľ��桢��������֪ͨ����ʱ��ֹ�������ڵ���ֹ����ֹ�����û��ʸ񼰾ܾ������ṩ����<br />(a)��Υ����Э������뱾Э����ļ���<br />(b)����˾�޷���֤����֤���򱾹�˾�ṩ���κ����ϣ�<br />(c)����˾����������Ϊ���ܶ���������˾�û��򱾹�˾�����ʧ�������Ρ�<br /><br />4.��������<br />����˾������˾�Ĺ�����˾�����ʵ��򱾹�˾�Ĺ�Ӧ�����κ�����¾������򱾹�˾����վ������˾�ķ����Э�����������֮�йص�������ʧ���κ��ر𡢼�ӻ����Ե��𺦣������Ժ��ַ�ʽ����������������е��κ����Ρ���ͬ��������������Ϊ֮�Ϸ��Ե����е����Ρ���ͬ�⣬����˾�ͱ���˾�����й�����˾�����ʵ��Ա���˾�û�����Ϊ�ĺϷ��Լ��������κν�����е����Ρ�<br /><br />5.�޴����ϵ<br />�û��ͱ���˾�Ƕ����ĺ�ͬ������Э�����⽨��Ҳû�д����κδ����ϻ��Ӫ����Ա�����������Ӫ��ϵ������˾Ҳ�����κ��û��������Ͻ�����Ϊ������ʾ��Ĭ����Ƽ�����ŵ�򵣱���<br /><br />6.һ��涨<br />��Э�������з�������л����񹲺͹����ɹ�Ͻ����Э��Ĺ涨�ǿɷָ�ģ��籾Э���κι涨���ö�Ϊ��Ч�򲻿�ִ�У��ù涨�ɱ�ɾ������������Ӧ����ִ�С�</p>', 1293773901);
INSERT INTO `#__document` (`doc_id`, `doc_code`, `doc_title`, `doc_content`, `doc_time`) VALUES(5, 'groupbuy', '�Ź��Э��', '<p>\r\n	һ���Ź�������Ȩ������Ȩ�鱾��˾��\r\n</p>\r\n<p>\r\n	��������˾��Ȩ�ڱ�Ҫʱ�޸ı�Э�飬��Э��һ��������������������ҳ���Ϲ������������ͬ�����Ķ������ݣ���Ӧ����ֹͣʹ���Ź��������������ʹ�÷�������Ϊ���ܱ�Э��ı����\r\n</p>\r\n<p>\r\n	�����緢�������κ�һ�����Σ�����˾��Ȩ�жϻ���ֹ�����ṩ�ķ��������֪ͨ����\r\n</p>\r\n1�� ���ṩ�ĸ������ϲ���ʵ��<br />\r\n2����Υ����Э��Ĺ涨��<br />\r\n3�� �����������ܲ��ŵļ��Ҫ��<br />\r\n4������˾��Ϊ������ΪΥ���Ź��������ʻ�������������Ρ�\r\n<p>\r\n	�ġ����ܱ�Э��������������涨������˾��Ȼ������ʱ��ֹ��Э�顣\r\n</p>\r\n<p>\r\n	�塢����˾��ֹ��Э���Ȩ�������������˾����ӵ�е��ڱ�Э����ֹǰ����Υ����Э��򱾹�˾��Ӧ���е��κ�����Ȩ����\r\n</p>\r\n<p>\r\n	��������Ⲣ��ȫ���ܣ�����˾��Ȩ���ж��Ź���Դ�����ߴ���\r\n</p>', 1328580944);
