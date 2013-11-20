-- ΢�̳ǰ�װ
-- by dqw

-- ΢�̳ǹ���
CREATE TABLE `shopnc_micro_adv` (
  `adv_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '�����',
  `adv_type` varchar(50) DEFAULT '' COMMENT '�������',
  `adv_name` varchar(255) NOT NULL DEFAULT '' COMMENT '�������',
  `adv_image` varchar(255) NOT NULL DEFAULT '' COMMENT '���ͼƬ',
  `adv_url` varchar(255) NOT NULL DEFAULT '' COMMENT '�������',
  `adv_sort` tinyint(1) unsigned NOT NULL DEFAULT '255' COMMENT '�������',
  PRIMARY KEY (`adv_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk COMMENT='΢�̳ǹ���';

-- ΢�̳���Ʒ���۱�
CREATE TABLE `shopnc_micro_comment` (
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '���۱��',
  `comment_type` tinyint(1) NOT NULL COMMENT '�������ͱ��',
  `comment_object_id` int(10) unsigned NOT NULL COMMENT '�Ƽ���Ʒ���',
  `comment_message` varchar(255) NOT NULL COMMENT '��������',
  `comment_member_id` int(10) unsigned NOT NULL COMMENT '�����˱��',
  `comment_time` int(10) unsigned NOT NULL COMMENT '����ʱ��',
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk COMMENT='΢�̳���Ʒ���۱�';

-- ΢�̳��Ƽ���Ʒ��(���Ŀ�) 
CREATE TABLE `shopnc_micro_goods` (
  `commend_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '�Ƽ����',
  `commend_member_id` int(10) unsigned NOT NULL COMMENT '�Ƽ����û����',
  `commend_goods_id` int(10) unsigned NOT NULL COMMENT '�Ƽ���Ʒ���',
  `commend_goods_store_id` int(10) unsigned NOT NULL COMMENT '�Ƽ���Ʒ���̱��',
  `commend_goods_name` varchar(100) NOT NULL COMMENT '�Ƽ���Ʒ����',
  `commend_goods_price` decimal(11,2) NOT NULL COMMENT '�Ƽ���Ʒ�۸�',
  `commend_goods_image` varchar(100) NOT NULL COMMENT '�Ƽ���ƷͼƬ',
  `commend_goods_image_more` text NOT NULL COMMENT '�Ƽ���Ʒ����ͼƬ',
  `commend_message` varchar(1000) NOT NULL COMMENT '�Ƽ���Ϣ',
  `commend_time` int(10) unsigned NOT NULL COMMENT '�Ƽ�ʱ��',
  `class_id` int(10) unsigned NOT NULL,
  `like_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'ϲ����',
  `comment_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '������',
  `click_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '�����',
  `microshop_commend` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '��ҳ�Ƽ� 0-�� 1-�Ƽ�',
  `microshop_sort` tinyint(3) unsigned NOT NULL DEFAULT '255' COMMENT '����',
  PRIMARY KEY (`commend_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk COMMENT='΢�̳��Ƽ���Ʒ��(���Ŀ�)';

-- ΢�̳���Ʒ(���Ŀ�)����� 
CREATE TABLE `shopnc_micro_goods_class` (
  `class_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '������ ',
  `class_name` varchar(50) NOT NULL COMMENT '��������',
  `class_parent_id` int(11) unsigned NOT NULL COMMENT '����������',
  `class_sort` tinyint(4) unsigned NOT NULL COMMENT '����',
  `class_keyword` varchar(500) NOT NULL DEFAULT '' COMMENT '����ؼ���',
  `class_image` varchar(100) NOT NULL DEFAULT '' COMMENT '����ͼƬ',
  `class_commend` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '�Ƽ���־0-���Ƽ� 1-�Ƽ�����ҳ',
  `class_default` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Ĭ�ϱ�־��0-��Ĭ�� 1-Ĭ��',
  PRIMARY KEY (`class_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk COMMENT='΢�̳���Ʒ(���Ŀ�)�����';

-- ΢�̳���Ʒ������̳���Ʒ�����Ӧ��ϵ 
CREATE TABLE `shopnc_micro_goods_relation` (
  `relation_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '��ϵ���',
  `class_id` int(10) unsigned NOT NULL COMMENT '΢�̳���Ʒ������',
  `shop_class_id` int(10) unsigned NOT NULL COMMENT '�̳���Ʒ������',
  PRIMARY KEY (`relation_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk COMMENT='΢�̳���Ʒ������̳���Ʒ�����Ӧ��ϵ';

-- ΢�̳�ϲ���� 
CREATE TABLE `shopnc_micro_like` (
  `like_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ϲ�����',
  `like_type` tinyint(1) NOT NULL COMMENT 'ϲ�����ͱ��',
  `like_object_id` int(10) unsigned NOT NULL COMMENT 'ϲ��������',
  `like_member_id` int(10) unsigned NOT NULL COMMENT 'ϲ���˱��',
  `like_time` int(10) unsigned NOT NULL COMMENT 'ϲ��ʱ��',
  PRIMARY KEY (`like_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk COMMENT='΢�̳�ϲ����';

-- ΢�̳��û���Ϣ��
CREATE TABLE `shopnc_micro_member_info` (
  `member_id` int(11) unsigned NOT NULL COMMENT '�û����',
  `visit_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '�������ķ��ʼ���',
  `personal_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '�ѷ�������������',
  `goods_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '�ѷ������Ŀ�����',
  PRIMARY KEY (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='΢�̳��û���Ϣ��';

-- ΢�̳Ǹ������
CREATE TABLE `shopnc_micro_personal` (
  `personal_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '�Ƽ����',
  `commend_member_id` int(10) unsigned NOT NULL COMMENT '�Ƽ����û����',
  `commend_image` text NOT NULL COMMENT '�Ƽ�ͼƬ',
  `commend_buy` text NOT NULL COMMENT '������Ϣ',
  `commend_message` varchar(1000) NOT NULL COMMENT '�Ƽ���Ϣ',
  `commend_time` int(10) unsigned NOT NULL COMMENT '�Ƽ�ʱ��',
  `class_id` int(10) unsigned NOT NULL,
  `like_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'ϲ����',
  `comment_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '������',
  `click_count` int(10) unsigned NOT NULL DEFAULT '0',
  `microshop_commend` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '��ҳ�Ƽ� 0-�� 1-�Ƽ�',
  `microshop_sort` tinyint(3) unsigned NOT NULL DEFAULT '255' COMMENT '����',
  PRIMARY KEY (`personal_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk COMMENT='΢�̳Ǹ������';

-- ΢�̳Ǹ��������� 
CREATE TABLE `shopnc_micro_personal_class` (
  `class_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '������ ',
  `class_name` varchar(50) NOT NULL COMMENT '��������',
  `class_sort` tinyint(4) unsigned NOT NULL COMMENT '����',
  `class_image` varchar(100) NOT NULL DEFAULT '' COMMENT '����ͼƬ',
  PRIMARY KEY (`class_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk COMMENT='΢�̳Ǹ���������';

-- ΢�̳ǵ��ֱ̽� 
CREATE TABLE `shopnc_micro_store` (
  `microshop_store_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '���ֵ̽��̱��',
  `shop_store_id` int(11) unsigned NOT NULL COMMENT '�̳ǵ��̱��',
  `microshop_sort` tinyint(1) unsigned DEFAULT '255' COMMENT '����',
  `microshop_commend` tinyint(1) unsigned DEFAULT '1' COMMENT '�Ƽ���ҳ��־ 1-���� 2-�Ƽ�',
  `like_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'ϲ����',
  `comment_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '������',
  `click_count` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`microshop_store_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk COMMENT='΢�̳ǵ��ֱ̽�';







