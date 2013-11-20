CREATE TABLE `shopnc_flea` (
  `goods_id` int(11) NOT NULL auto_increment COMMENT '��������id',
  `goods_name` varchar(100) NOT NULL COMMENT '��������',
  `gc_id` int(11) NOT NULL COMMENT '���÷���id',
  `gc_name` varchar(200) NOT NULL COMMENT '���÷�������',
  `member_id` int(11) NOT NULL COMMENT '����id',
  `member_name` varchar(110) NOT NULL COMMENT '��Ա����',
  `goods_image` varchar(100) NOT NULL COMMENT '����Ĭ�Ϸ���ͼƬ',
  `goods_tag` varchar(100) NOT NULL COMMENT '���ñ�ǩ',
  `goods_price` decimal(10,2) NOT NULL COMMENT '����ԭ��',
  `goods_store_price` decimal(10,2) NOT NULL COMMENT '����ת�ü۸�',
  `goods_show` tinyint(1) NOT NULL COMMENT '�����ϼ�',
  `goods_click` int(11) NOT NULL default '0' COMMENT '���������',
  `flea_collect_num` int(11) unsigned NOT NULL COMMENT '������Ʒ���ղش���',
  `goods_commend` tinyint(1) NOT NULL COMMENT '�����Ƽ�',
  `goods_add_time` varchar(10) NOT NULL COMMENT '�������ʱ��',
  `goods_keywords` varchar(255) NOT NULL COMMENT '���ùؼ���',
  `goods_description` varchar(255) NOT NULL COMMENT '��������',
  `goods_body` text NOT NULL COMMENT '��Ʒ��ϸ����',
  `commentnum` int(11) NOT NULL default '0' COMMENT '���۴���',
  `salenum` int(11) NOT NULL default '0' COMMENT '�۳�����',
  `flea_quality` tinyint(4) NOT NULL default '0' COMMENT '������Ʒ��ɫ��0δѡ��9-5������£�3�ǵ��������',
  `flea_pname` varchar(20) default NULL COMMENT '������Ʒ��ϵ��',
  `flea_pphone` varchar(20) default NULL COMMENT '������Ʒ��ϵ�˵绰',
  `flea_area_id` int(11) unsigned NOT NULL COMMENT '������Ʒ����id',
  `flea_area_name` varchar(50) NOT NULL COMMENT '������Ʒ��������',
  PRIMARY KEY  (`goods_id`),
  KEY `goods_name` (`goods_name`,`gc_id`,`member_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='������Ʒ';

CREATE TABLE `shopnc_flea_area` (
  `flea_area_id` int(11) unsigned NOT NULL auto_increment COMMENT '���õ���id',
  `flea_area_name` varchar(50) NOT NULL COMMENT '���õ�������',
  `flea_area_parent_id` int(11) unsigned NOT NULL default '0' COMMENT '���õ����ϼ�����id',
  `flea_area_sort` tinyint(3) unsigned NOT NULL default '0' COMMENT '���õ�������',
  `flea_area_deep` tinyint(1) unsigned NOT NULL default '1' COMMENT '���õ����㼶',
  `flea_area_hot` int(11) NOT NULL default '0' COMMENT '���������ȶ�',
  PRIMARY KEY  (`flea_area_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='���õ���';

CREATE TABLE `shopnc_flea_class` (
  `gc_id` int(10) unsigned NOT NULL auto_increment COMMENT '����ID',
  `gc_name` varchar(100) NOT NULL COMMENT '��������',
  `gc_name_index` varchar(100) NOT NULL COMMENT '������ҳ��ʾ������',
  `gc_parent_id` int(10) unsigned NOT NULL default '0' COMMENT '��ID',
  `gc_sort` tinyint(3) unsigned NOT NULL default '0' COMMENT '����',
  `gc_show` tinyint(1) NOT NULL default '1' COMMENT 'ǰ̨��ʾ��0Ϊ��1Ϊ�ǣ�Ĭ��Ϊ1',
  `gc_index_show` tinyint(1) NOT NULL default '1' COMMENT '��ҳ��ʾ 1��Ĭ�� ��ʾ 0������ʾ',
  PRIMARY KEY  (`gc_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='���÷���';

CREATE TABLE `shopnc_flea_class_index` (
  `fc_index_id` int(11) unsigned NOT NULL auto_increment COMMENT '����id',
  `fc_index_class` varchar(50) NOT NULL COMMENT '�������',
  `fc_index_code` varchar(50) NOT NULL COMMENT '���code',
  `fc_index_id1` varchar(50) NOT NULL default '0' COMMENT '����id1',
  `fc_index_name1` varchar(50) NOT NULL,
  `fc_index_id2` varchar(50) NOT NULL default '0' COMMENT '����id2',
  `fc_index_name2` varchar(50) NOT NULL,
  `fc_index_id3` varchar(50) NOT NULL default '0' COMMENT '����id3',
  `fc_index_name3` varchar(50) NOT NULL,
  `fc_index_id4` varchar(50) NOT NULL default '0' COMMENT '����id4',
  `fc_index_name4` varchar(50) NOT NULL,
  PRIMARY KEY  (`fc_index_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='������ҳ����';

CREATE TABLE `shopnc_flea_consult` (
  `consult_id` int(10) unsigned NOT NULL auto_increment COMMENT '��ѯ���',
  `goods_id` int(11) default '0' COMMENT '��Ʒ���',
  `member_id` int(11) NOT NULL default '0' COMMENT '��ѯ�����߻�Ա���(0���ο�)',
  `seller_id` int(11) NOT NULL COMMENT '��Ϣ�����߱��',
  `email` varchar(255) default NULL COMMENT '��ѯ����������',
  `consult_content` varchar(4000) default NULL COMMENT '��ѯ����',
  `consult_addtime` int(10) default NULL COMMENT '��ѯ����ʱ��',
  `consult_reply` varchar(4000) default NULL COMMENT '��ѯ�ظ�����',
  `consult_reply_time` int(10) default NULL COMMENT '��ѯ�ظ�ʱ��',
  `type` varchar(20) NOT NULL default 'flea' COMMENT '��ѯ����',
  PRIMARY KEY  (`consult_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='������ѯ';

CREATE TABLE `shopnc_flea_upload` (
  `upload_id` int(10) unsigned NOT NULL auto_increment COMMENT '����ID',
  `file_name` varchar(100) default NULL COMMENT '�ļ���',
  `file_thumb` varchar(100) default NULL COMMENT '��΢ͼƬ',
  `file_wm` varchar(100) default NULL COMMENT 'ˮӡͼƬ',
  `file_size` int(10) unsigned NOT NULL default '0' COMMENT '�ļ���С',
  `store_id` int(10) unsigned NOT NULL default '0' COMMENT '��ԱID',
  `upload_type` tinyint(1) NOT NULL default '0' COMMENT 'Ĭ��Ϊ0��12Ϊ��Ʒ�л�ͼƬ��13Ϊ��Ʒ����ͼƬ',
  `upload_time` int(10) unsigned NOT NULL default '0' COMMENT '���ʱ��',
  `item_id` int(11) unsigned NOT NULL default '0' COMMENT '��ϢID',
  PRIMARY KEY  (`upload_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='�����ϴ��ļ���';

CREATE TABLE `shopnc_flea_favorites` (
  `member_id` int(10) unsigned NOT NULL COMMENT '��ԱID',
  `fav_id` int(10) unsigned NOT NULL COMMENT '�ղ�ID',
  `fav_type` varchar(20) NOT NULL COMMENT '�ղ�����',
  `fav_time` varchar(10) NOT NULL COMMENT '�ղ�ʱ��'
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='��������ղر�';
