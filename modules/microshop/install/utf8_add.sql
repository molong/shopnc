-- 微商城安装
-- by dqw

-- 微商城开关
INSERT INTO `shopnc_setting` (`name`, `value`) VALUES ('microshop_isuse', '1');
-- 默认分类
INSERT INTO `shopnc_setting` (`name`, `value`) VALUES ('microshop_goods_default_class', '0');
-- 微商城主题 
INSERT INTO `shopnc_setting` (`name`, `value`) VALUES ('microshop_style', 'default');
-- 微商城URL 
INSERT INTO `shopnc_setting` (`name`, `value`) VALUES ('microshop_url', '');
-- 微商城LOGO 
INSERT INTO `shopnc_setting` (`name`, `value`) VALUES ('microshop_logo', '');
-- 微商城header_pic
INSERT INTO `shopnc_setting` (`name`, `value`) VALUES ('microshop_header_pic', '');
-- 微商城个人秀数量限制
INSERT INTO `shopnc_setting` (`name`, `value`) VALUES ('microshop_personal_limit', '50');
-- 微商城店铺街banner
INSERT INTO `shopnc_setting` (`name`, `value`) VALUES ('microshop_store_banner', '');
-- 微商城淘宝接口开关
INSERT INTO `shopnc_setting` (`name`, `value`) VALUES ('taobao_api_isuse', '0');
INSERT INTO `shopnc_setting` (`name`, `value`) VALUES ('taobao_app_key', '');
INSERT INTO `shopnc_setting` (`name`, `value`) VALUES ('taobao_secret_key', '');
-- 微商城SEO
INSERT INTO `shopnc_setting` (`name`, `value`) VALUES ('microshop_seo_keywords','ShopNC商城系统,微商城,随心看,个人秀,店铺街,网上购物');
INSERT INTO `shopnc_setting` (`name`, `value`) VALUES ('microshop_seo_description','ShopNC商城系统,微商城,随心看,个人秀,店铺街');

-- 个人秀默认分类
INSERT INTO `shopnc_micro_personal_class` ( `class_name`, `class_sort`, `class_image`) VALUES ('女装',0,'');
INSERT INTO `shopnc_micro_personal_class` ( `class_name`, `class_sort`, `class_image`) VALUES ('男装',0,'');
INSERT INTO `shopnc_micro_personal_class` ( `class_name`, `class_sort`, `class_image`) VALUES ('美食',0,'');
INSERT INTO `shopnc_micro_personal_class` ( `class_name`, `class_sort`, `class_image`) VALUES ('家居',0,'');
INSERT INTO `shopnc_micro_personal_class` ( `class_name`, `class_sort`, `class_image`) VALUES ('其它',0,'');

-- 随心看默认分类
INSERT INTO `shopnc_micro_goods_class` ( `class_name`, `class_parent_id`, `class_sort`, `class_keyword`, `class_image`, `class_commend`, `class_default`) VALUES ('女人',0,0,'','',0,0);
INSERT INTO `shopnc_micro_goods_class` ( `class_name`, `class_parent_id`, `class_sort`, `class_keyword`, `class_image`, `class_commend`, `class_default`) VALUES ('男人',0,0,'','',0,0);
INSERT INTO `shopnc_micro_goods_class` ( `class_name`, `class_parent_id`, `class_sort`, `class_keyword`, `class_image`, `class_commend`, `class_default`) VALUES ('家居生活',0,0,'','',0,0);
INSERT INTO `shopnc_micro_goods_class` ( `class_name`, `class_parent_id`, `class_sort`, `class_keyword`, `class_image`, `class_commend`, `class_default`) VALUES ('母婴',0,0,'','',0,0);
INSERT INTO `shopnc_micro_goods_class` ( `class_name`, `class_parent_id`, `class_sort`, `class_keyword`, `class_image`, `class_commend`, `class_default`) VALUES ('其它',0,0,'','',0,0);
