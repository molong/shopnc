-- ΢�̳ǰ�װ
-- by dqw

-- ΢�̳ǿ���
INSERT INTO `shopnc_setting` (`name`, `value`) VALUES ('microshop_isuse', '1');
-- Ĭ�Ϸ���
INSERT INTO `shopnc_setting` (`name`, `value`) VALUES ('microshop_goods_default_class', '0');
-- ΢�̳����� 
INSERT INTO `shopnc_setting` (`name`, `value`) VALUES ('microshop_style', 'default');
-- ΢�̳�URL 
INSERT INTO `shopnc_setting` (`name`, `value`) VALUES ('microshop_url', '');
-- ΢�̳�LOGO 
INSERT INTO `shopnc_setting` (`name`, `value`) VALUES ('microshop_logo', '');
-- ΢�̳�header_pic
INSERT INTO `shopnc_setting` (`name`, `value`) VALUES ('microshop_header_pic', '');
-- ΢�̳Ǹ�������������
INSERT INTO `shopnc_setting` (`name`, `value`) VALUES ('microshop_personal_limit', '50');
-- ΢�̳ǵ��̽�banner
INSERT INTO `shopnc_setting` (`name`, `value`) VALUES ('microshop_store_banner', '');
-- ΢�̳��Ա��ӿڿ���
INSERT INTO `shopnc_setting` (`name`, `value`) VALUES ('taobao_api_isuse', '0');
INSERT INTO `shopnc_setting` (`name`, `value`) VALUES ('taobao_app_key', '');
INSERT INTO `shopnc_setting` (`name`, `value`) VALUES ('taobao_secret_key', '');
-- ΢�̳�SEO
INSERT INTO `shopnc_setting` (`name`, `value`) VALUES ('microshop_seo_keywords','ShopNC�̳�ϵͳ,΢�̳�,���Ŀ�,������,���̽�,���Ϲ���');
INSERT INTO `shopnc_setting` (`name`, `value`) VALUES ('microshop_seo_description','ShopNC�̳�ϵͳ,΢�̳�,���Ŀ�,������,���̽�');

-- ������Ĭ�Ϸ���
INSERT INTO `shopnc_micro_personal_class` ( `class_name`, `class_sort`, `class_image`) VALUES ('Ůװ',0,'');
INSERT INTO `shopnc_micro_personal_class` ( `class_name`, `class_sort`, `class_image`) VALUES ('��װ',0,'');
INSERT INTO `shopnc_micro_personal_class` ( `class_name`, `class_sort`, `class_image`) VALUES ('��ʳ',0,'');
INSERT INTO `shopnc_micro_personal_class` ( `class_name`, `class_sort`, `class_image`) VALUES ('�Ҿ�',0,'');
INSERT INTO `shopnc_micro_personal_class` ( `class_name`, `class_sort`, `class_image`) VALUES ('����',0,'');

-- ���Ŀ�Ĭ�Ϸ���
INSERT INTO `shopnc_micro_goods_class` ( `class_name`, `class_parent_id`, `class_sort`, `class_keyword`, `class_image`, `class_commend`, `class_default`) VALUES ('Ů��',0,0,'','',0,0);
INSERT INTO `shopnc_micro_goods_class` ( `class_name`, `class_parent_id`, `class_sort`, `class_keyword`, `class_image`, `class_commend`, `class_default`) VALUES ('����',0,0,'','',0,0);
INSERT INTO `shopnc_micro_goods_class` ( `class_name`, `class_parent_id`, `class_sort`, `class_keyword`, `class_image`, `class_commend`, `class_default`) VALUES ('�Ҿ�����',0,0,'','',0,0);
INSERT INTO `shopnc_micro_goods_class` ( `class_name`, `class_parent_id`, `class_sort`, `class_keyword`, `class_image`, `class_commend`, `class_default`) VALUES ('ĸӤ',0,0,'','',0,0);
INSERT INTO `shopnc_micro_goods_class` ( `class_name`, `class_parent_id`, `class_sort`, `class_keyword`, `class_image`, `class_commend`, `class_default`) VALUES ('����',0,0,'','',0,0);
