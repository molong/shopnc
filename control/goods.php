<?php
/**
 * 前台商品
 *
 * 
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');

class goodsControl extends BaseStoreControl {

    const XIANSHI_STATE_PUBLISHED = 2;
    const XIANSHI_STATE_END = 5;
    const XIANSHI_GOODS_STATE_NORMAL = 1;
    const MANSONG_STATE_PUBLISHED = 2;
	
	public function __construct() {
		parent::__construct();
		//读取语言包
		Language::read('store_goods_index');
	}

	/**
	 * 单个商品信息页
	 *
	 */
	public function indexOp() {
		if(empty($_GET['goods_id']))showMessage(Language::get('miss_argument'),'','html','error');//"缺少参数:商品编号"
		$goods_id	= intval($_GET['goods_id']);
		$model_store_goods	= Model('goods');
		//$goods_array		= $model_store_goods->getGoods(array('goods_id'=>intval($_GET['goods_id'])),'','goods.*,goods_spec.spec_goods_storage');
		$goods_array = $model_store_goods->where(array('goods_id'=>intval($_GET['goods_id'])))->find();
		// 验证商品是否存在
		if(empty($goods_array) || $goods_array['goods_store_state'] == 1 )showMessage(Language::get('goods_index_no_goods'),'','html','error');

		//获取店铺信息
		$store_info = $this->getStoreInfo($goods_array['store_id']);

		$_GET['id']	= $goods_array['store_id'];
		//得到商品规格
		$spec_array	= $model_store_goods->getSpecGoods($goods_array['goods_id']);
		if(empty($spec_array)) {
			showMessage(Language::get('goods_index_no_goods'),'','html','error');
		}
		if(!empty($spec_array) && is_array($spec_array)){
			foreach ($spec_array as $key => $val){
				$s_array	= unserialize($val['spec_goods_spec']);
				$val['spec_goods_spec']	= '';
				if(!empty($s_array) && is_array($s_array)){
					foreach ($s_array as $k=>$v){
						$val['spec_goods_spec'] .= "'".$k."',";
					}
				}
				$val['spec_goods_spec']	= rtrim($val['spec_goods_spec'],',');
				//将商品默认规格的库存复制到商品数组中
				if ($val['spec_id'] == $goods_array['spec_id']){
					$goods_array['spec_goods_storage'] = $val['spec_goods_storage'];
				}
				$spec_array[$key]	= $val;
			}
		}
		$goods_array['goods_spec'] = unserialize($goods_array['goods_spec']);
		$goods_array['spec_name'] = unserialize($goods_array['spec_name']);
		$goods_array['goods_attr'] = unserialize($goods_array['goods_attr']);
		$goods_array['goods_col_img'] = unserialize($goods_array['goods_col_img']);// 规格图片
		
		$model = Model();//该model为公用model实例
		
		//商品受关注次数加1
		$_times = cookie('tm_visit_product');
		if (empty($_times)){
			$model->table('goods')->where(array('goods_id' => $goods_id))->attr('LOW_PRIORITY')->update(array('goods_click' =>array('exp','goods_click+1')));
			setNcCookie('tm_visit_product',1);
			$goods_array['goods_click'] = intval($goods_array['goods_click'])+1;
		}
		Tpl::output('spec_array',$spec_array);
		Tpl::output('spec_count',count($goods_array['goods_spec']));
		Tpl::output('goods_spec', $goods_array['goods_spec']);
		Tpl::output('goods_col_img', $goods_array['goods_col_img']);
		
		//生成缓存的键值
		$hash_key = $goods_array['goods_id'];
		//先查找$hash_key缓存
		$cachekey_arr = array('likenum','sharenum','brand_name');
		if ($_cache = rcache($hash_key,'product')){
			foreach ($_cache as $k=>$v){
				$goods_array[$k] = $v;
			}
		}else {
			//查询SNS中该商品的信息
			$snsgoodsinfo = $model->table('sns_goods')->where(array('snsgoods_goodsid'=>$goods_array['goods_id']))->find();
			$goods_array['likenum'] = $snsgoodsinfo['snsgoods_likenum'];
			$goods_array['sharenum'] = $snsgoodsinfo['snsgoods_sharenum'];
			//得到商品品牌
			$brand_array = $model->table('brand')->where(array('brand_id'=>$goods_array['brand_id'],'brand_apply'=>'1'))->find();
			$goods_array['brand_name'] = $brand_array['brand_name'];

			$data = array();
			if (!empty($goods_array)){
				foreach ($goods_array as $k=>$v){
					if (in_array($k,$cachekey_arr)){
						$data[$k] = $v;
					}
				}
			}
			//缓存商品信息
			wcache($hash_key,$data,'product');
		}
		//Tpl::output('snsgoodsinfo', $snsgoodsinfo);
		//Tpl::output('brand',$brand_array);
		
        //检查是否为店主本人
        $store_self = false;
        if(!empty($_SESSION['store_id'])) {
            if ($goods_array['store_id'] == $_SESSION['store_id']) {
                $store_self = true;
            }
        }
        Tpl::output('store_self',$store_self);
        
        
		//商品多图
		$desc_image			= explode(',', $goods_array['goods_image_more']);
		if($goods_array['goods_image_more'] == ''){//商品多图与淘宝导入和2.0兼容
			$desc_image			= $model_store_goods->getListImageGoods(array('image_store_id'=>$goods_array['store_id'],'item_id'=>$goods_array['goods_id'],'image_type'=>2));
			
			$image_key = 0;
			if(!empty($desc_image) && is_array($desc_image)) {//将封面图放到第一位显示
				$goods_image_1	= $goods_array['goods_image'];//封面图
				foreach ($desc_image as $key => $val) {
					if($goods_image_1 == $val['thumb_small']){
						$image_key = $key;break;
					}
				}
				if($image_key > 0) {//将封面图放到第一位显示
					$desc_image_0	= $desc_image[0];
					$desc_image[0]	= $desc_image[$image_key];
					$desc_image[$image_key]	= $desc_image_0;
				}
				$image_array = array();
				foreach ($desc_image as $key => $val) {
					$image_array[] = $val['file_thumb'];
				}
				$desc_image	= $image_array;
			}
		}
		//如果使用运费模板
		if ($goods_array['transport_id'] > 0){
			//取得三种运送方式默认运费
			$model_transport = Model('transport');
			$transport = $model_transport->getExtendList(array('transport_id'=>$goods_array['transport_id'],'is_default'=>1));
			if (!empty($transport) && is_array($transport)){
				foreach ($transport as $v) {
					$goods_array[$v['type']."_price"] = $v['sprice'];
				}
			}
		}
		Tpl::output('goods',$goods_array);
		Tpl::output('goods_image',$desc_image[0]);
		Tpl::output('desc_image',$desc_image);

		//输出一级地区
		$area_list = array (1 => '北京',2 => '天津',3 => '河北',4 => '山西',5 => '内蒙古',6 => '辽宁',7 => '吉林',8 => '黑龙江',9 => '上海',10 => '江苏',11 => '浙江',12 => '安徽',13 => '福建',14 => '江西',15 => '山东',16 => '河南',17 => '湖北',18 => '湖南',19 => '广东',20 => '广西',21 => '海南',22 => '重庆',23 => '四川',24 => '贵州',25 => '云南',26 => '西藏',27 => '陕西',28 => '甘肃',29 => '青海',30 => '宁夏',31 => '新疆',32 => '台湾',33 => '香港',34 => '澳门',35 => '海外');
		if (strtoupper(CHARSET) == 'GBK'){
			$area_list = Language::getGBK($area_list);
		}
		Tpl::output('area_list',$area_list);

		
		
		//优先得到推荐商品
		$goods_commend_list = $model_store_goods->getGoods(array(
			'store_id'=>$goods_array['store_id'],
			'goods_id_diff'=>intval($_GET['goods_id']),
			'goods_show'=>1,
			'goods_commend'=>1,
			'order'=>'goods_commend desc',
			'limit'=>'0,4'
		),'','goods.goods_id,goods.goods_name,goods.goods_image,goods.store_id,goods.goods_store_price','goods');

		Tpl::output('goods_commend',$goods_commend_list);


		/**
		 * 生成浏览过产品的cookie
		 */
		$cookievalue = $goods_id.'-'.$goods_array['store_id'];
		if(cookie('viewed_goods')){
			$string_viewed_goods = cookie('viewed_goods');
			if (get_magic_quotes_gpc()) $string_viewed_goods = stripslashes($string_viewed_goods);//去除斜杠
			$vg_ca = @unserialize($string_viewed_goods);
			$sign = true;
			if(!empty($vg_ca) && is_array($vg_ca)){
				foreach ($vg_ca as $vk=>$vv){
					if($vv == $cookievalue){
						$sign = false;
					}
				}
			}else{
				$vg_ca = array();
			}
				
			if($sign){
				if(count($vg_ca) >= 4){
					$vg_ca[]  = $cookievalue;
					array_shift($vg_ca);
				}else{
					$vg_ca[]  = $cookievalue;
				}				
			}
		}else{
			$vg_ca[]  = $cookievalue;
		}
		$vg_ca = serialize($vg_ca);	
        setNcCookie('viewed_goods',$vg_ca);

        //团购活动
        $group_flag = FALSE;
        if(intval($goods_array['group_flag']) === 1) {
            $group_list = $this->get_group_list($goods_id);
            if(!empty($group_list) && is_array($group_list)) {
                $current_time = time();
                foreach($group_list as $group) {
                    if(intval($group['start_time']) < $current_time && intval($group['end_time']) > $current_time) {
                        if(intval($group['state']) === 3) {
                            if($group['def_quantity'] < $group['max_num']) {
                                $group_flag = TRUE;
                                Tpl::output('group_info',$group);
                                break;
                            }
                        }
                    }
                }
            } else {
                //没有新的团购活动，取消商品团购标志
                $model_store_goods->updateGoods(array('group_flag'=>0),$goods_id); 
            }
        }
        Tpl::output('group_flag',$group_flag);

        //限时折扣
        $xianshi_flag = FALSE;
        $start_flag = FALSE;
        $goods_xianshi_flag = FALSE;
        if(intval($GLOBALS['setting_config']['promotion_allow']) === 1){
            if(!$group_flag && intval($goods_array['xianshi_flag']) === 1) {
                $xianshi_goods = $this->get_xianshi_goods($goods_id);  
                if(!empty($xianshi_goods) && intval($xianshi_goods['state']) === self::XIANSHI_GOODS_STATE_NORMAL ) {
                    $xianshi_id = $xianshi_goods['xianshi_id'];
                    $model_xianshi = Model('p_xianshi');
                    $xianshi_info = $model_xianshi->getOne($xianshi_id);
                    if(!empty($xianshi_info)) {
                        if(intval($xianshi_info['state']) === self::XIANSHI_STATE_PUBLISHED) {
                            $current_time = time();
                            if(intval($xianshi_info['end_time']) > $current_time) {
                                $xianshi_flag = TRUE;
                                if(intval($xianshi_info['start_time']) < $current_time) {
                                    $start_flag = TRUE;
                                }
                                Tpl::output('xianshi_info',$xianshi_info);
                                $xianshi_goods['discount'] /= 10;
                                Tpl::output('xianshi_goods',$xianshi_goods);
                            }
                            else {
                                //更新过期限时折扣状态
                                $model_xianshi->update(array('state'=>self::XIANSHI_STATE_END),array('xianshi_id'=>$xianshi_id));
                                $goods_xianshi_flag = TRUE;
                            }
                        }
                        else {
                            $goods_xianshi_flag = TRUE;
                        }
                    }
                } else {
                    $goods_xianshi_flag = TRUE;
                }
            }
        } else {
            if(intval($goods_array['xianshi_flag']) === 1) {
                $goods_xianshi_flag = TRUE;
            }
        }

        //没有限时折扣活动，取消限时折扣标志
        if($goods_xianshi_flag) { 
            $model_store_goods->updateGoods(array('xianshi_flag'=>0),$goods_id); 
        }

        Tpl::output('xianshi_flag',$xianshi_flag);
        Tpl::output('start_flag',$start_flag);

        //如果不是团购和限时折扣输出满就送活动
        if(intval($GLOBALS['setting_config']['promotion_allow']) === 1){
            if($group_flag || $xianshi_flag) {
                Tpl::output('mansong_flag',FALSE);
            }
            else {
                $this->output_mansong($goods_array['store_id']);
            }
        } else {
            Tpl::output('mansong_flag',FALSE);
        }
        Tpl::output('page','goods');
        
 		$seo_param = array();
		$seo_param['name'] = $goods_array['goods_name'];
		$seo_param['key']  = $goods_array['goods_keywords'];
		$seo_param['description'] = $goods_array['goods_description'];
		Model('seo')->type('product')->param($seo_param)->show();       
        Tpl::showpage('goods');
	}
    /**
     * 获取团购列表 
     **/
    private function get_group_list($goods_id) {

        $current_time = time();
        $model_group = Model('goods_group');
        $param = array();
        $param['goods_id'] = $goods_id;
        $param['state'] = 3;
        $param['less_than_end_time'] = $current_time;
        return $model_group->getList($param);
    }
    /**
     * 获取限时折扣商品
     **/
    private function get_xianshi_goods($goods_id) {

        $model_xianshi_goods = Model('p_xianshi_goods');
        $param = array();
        $param['goods_id'] = $goods_id;
        $param['order'] = 'xianshi_goods_id desc';
        $param['limit'] = 1;
        $xianshi_goods = $model_xianshi_goods->getList($param);
        return $xianshi_goods[0];
    }
    /**
     * 输出满就送活动
     **/
    private function output_mansong($store_id) {

        $model_mansong = Model('p_mansong');
        $param = array();
        $param['state'] = self::MANSONG_STATE_PUBLISHED;
        $current_time = time();
        $param['greater_than_start_time'] = $current_time;
        $param['less_than_end_time'] = $current_time;
        $param['store_id'] = $store_id;
        $param['limit'] = 1;
        $mansong_list = $model_mansong->getList($param);
        $mansong = $mansong_list[0];
        $mansong_flag = FALSE;
        if(!empty($mansong)) {
            $model_mansong_rule = Model('p_mansong_rule');
            $mansong_rule = $model_mansong_rule->getList(array('mansong_id'=>$mansong['mansong_id'],'order'=>'level asc'));
            if(!empty($mansong_rule)) {
                $mansong_flag = TRUE;
                Tpl::output('mansong_info',$mansong);
                Tpl::output('mansong_rule',$mansong_rule);
            }
        }
        Tpl::output('mansong_flag',$mansong_flag);
    }

    /**
	 * 商品评论
	 */
	public function commentsOp() {
		$goods_id = intval($_GET['goods_id']);
		$result = true;//信息是否出现错误的结果，false将不继续执行代码
		if ($goods_id <= 0){
			$result = false;
		}
		if ($result){
			//查询商品信息
			$goods_model = Model('goods');
			$goods_info = $goods_model->getOne($goods_id);
			if (empty($goods_info)){
				$result = false;
			}
		}
		if ($result){
			//评价等级默认评语
			$evaluate_defaulttext = array('1'=>Language::get('nc_credit_defaultcontent_good'),'0'=>Language::get('nc_credit_defaultcontent_normal'),'-1'=>Language::get('nc_credit_defaultcontent_bad'));
			$condition = array();
			//评价等级
			if($_GET['evalscore']){
				switch($_GET['evalscore']){
					case 1:
						$condition['geval_scores'] = '1';
						break;
					case 2:
						$condition['geval_scores'] = '0';
						break;
					case 3:
						$condition['geval_scores'] = '-1';
						break;
				}
			}
			//评价是否有内容
			if(intval($_GET['havecontent']) == 1){
				$condition['havecontent'] = 'yes';
			}
			$condition['geval_goodsid'] = "{$goods_id}";
			$condition['geval_storeid'] = "{$goods_info['store_id']}";
			$condition['geval_type'] = "1";
			$condition['geval_showtime_lt'] = time();
			//查询商品评分信息
			$page	= new Page();
			$page->setEachNum(10);
			$page->setStyle('admin');
			$evaluate_model = Model("evaluate");
			$goodsevallist = $evaluate_model->getGoodsEvalList($condition,$page,'*','member');
			if (!empty($goodsevallist)){
				foreach ($goodsevallist as $k=>$v){					
					//处理评论内容的显示
					if ($v['geval_content'] == '' || $v['geval_state'] == '1'){
						$v['geval_content'] = $evaluate_defaulttext[$v['geval_scores']];
					}
					switch ($v['geval_scores']){
						case 1:
							$v['geval_scoressign'] = 'good';
							break;
						case 0:
							$v['geval_scoressign'] = 'normal';
							break;
						case -1:
							$v['geval_scoressign'] = 'bad';
							break;
					}
					//买家信用
					$v['credit_arr'] = getCreditArr(intval($v['member_credit']));
					//显示匿名
					$v['geval_frommembername'] = $v['geval_isanonymous'] == 1?str_cut($v['geval_frommembername'],2).'***':$v['geval_frommembername'];
					$goodsevallist[$k] = $v;
				}
			}
			Tpl::output('goods_info',$goods_info);
			Tpl::output('goodsevallist',$goodsevallist);
			Tpl::output('show_page',$page->show());
		}
		Tpl::showpage('comments','null_layout');
	}
	
	/**
	 * 销售记录
	 */
	public function salelogOp() {		
		$goods_id	 = intval($_GET['goods_id']);
		$order_class = Model('order');
		/**
		 * 得到出售记录
		 */
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		/**
		 * 得到售出信息
		 */
		$sales = $order_class->getOrderGoodsList(array(
		'`order_goods`.goods_id'=>$goods_id,
		'status_no'=>'0',
		'order'=>'`order`.add_time desc'
		),$page);
		/**
		 * 输出分页
		 */
		Tpl::output('show_page',$page->show());
		/**
		 * 输出评论
		 */
		Tpl::output('sales',$sales);
		Tpl::showpage('salelog','null_layout');
	}
	/**
	 * 产品咨询
	 */
	public function cosultingOp() {
		$goods_id	 = intval($_GET['goods_id']);
		if($goods_id <= 0){
			showMessage(Language::get('wrong_argument'),'','html','error');
		}
		// 分页信息
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
				
		//得到商品咨询信息
		$consult		= Model('consult');
		$consult_list	= $consult->getConsultList(array('goods_id'=>$goods_id),$page,'simple');
		Tpl::output('consult_list',$consult_list);
		/**
		 * 输出分页
		 */
		Tpl::output('show_page', $page->show());		
		
		//检查是否为店主本身
		$store_self = false;
        if(!empty($_SESSION['store_id'])) {
            if (intval($_GET['id']) == $_SESSION['store_id']) {
                $store_self = true;
            }
        }
        //查询会员信息
        $member_info	= array();
        $member_model = Model('member');
        if(!empty($_SESSION['member_id'])) $member_info = $member_model->infoMember(array('member_id'=>"{$_SESSION['member_id']}"));
		//检查是否可以评论
        $consult_able = true;
        if((!$GLOBALS['setting_config']['guest_comment'] && !$_SESSION['member_id'] ) || $store_self == true || ($_SESSION['member_id']>0 && $member_info['is_allowtalk'] == 0)){
        	$consult_able = false;
        }
        Tpl::output('nchash',substr(md5(SiteUrl.$_GET['act'].$_GET['op']),0,8));
        Tpl::output('consult_able',$consult_able);
		Tpl::showpage('cosulting');
	}
	/**
	 * 商品咨询添加
	 */
	public function save_consultajaxOp(){
		//检查是否可以评论
        if(!C('guest_comment') && !$_SESSION['member_id']){
        	echo json_encode(array('done'=>'false','msg'=>Language::get('goods_index_goods_noallow')));
        	die;
        }
		$goods_id	 = intval($_GET['goods_id']);
		if($goods_id <= 0){
			echo json_encode(array('done'=>'false','msg'=>Language::get('wrong_argument')));
        	die;
		}
		//咨询内容的非空验证
		if(trim($_GET['goods_content'])== ""){
			echo json_encode(array('done'=>'false','msg'=>Language::get('goods_index_input_consult')));
        	die;
		}
		//验证码验证
		if(C('captcha_status_goodsqa') == '1' && !checkSeccode($_GET['nchash'],$_GET['captcha'])){
			echo json_encode(array('done'=>'false','msg'=>Language::get('wrong_checkcode')));
        	die;
		}
        if (check_repeat('comment')){
        	echo json_encode(array('done'=>'false','msg'=>Language::get('nc_common_op_repeat')));
        	die;
        }		
        if($_SESSION['member_id']){
	        //查询会员信息
	        $member_model = Model('member');
	        $member_info = $member_model->infoMember(array('member_id'=>"{$_SESSION['member_id']}"));
			if(empty($member_info) || $member_info['is_allowtalk'] == 0){
	        	echo json_encode(array('done'=>'false','msg'=>Language::get('goods_index_goods_noallow')));
        		die;
	        }
        }
		//判断商品编号的存在性和合法性
		$goods	= Model('goods');
		$goods_info	= array();
		$goods_info	= $goods->checkGoods(array('goods_id'=>"{$goods_id}"));
		if(empty($goods_info)){
			echo json_encode(array('done'=>'false','msg'=>Language::get('goods_index_goods_not_exists')));
        	die;
		}
        //判断是否是店主本人
        if($_SESSION['store_id'] && $goods_info['store_id'] == $_SESSION['store_id']) {
            echo json_encode(array('done'=>'false','msg'=>Language::get('goods_index_consult_store_error')));
        	die;
        }
		//检查店铺状态
		$store_model = Model('store');
		$store_info	= $store_model->shopStore(array('store_id'=>"{$goods_info['store_id']}"));
		if($store_info['store_state'] == '0' || intval($store_info['store_state']) == '2' || (intval($store_info['store_end_time']) != 0 && $store_info['store_end_time'] <= time())){
			echo json_encode(array('done'=>'false','msg'=>Language::get('goods_index_goods_store_closed')));
        	die;
		}
		//接收数据并保存
		$input	= array();
		$input['goods_id']			= $goods_id;
		$input['cgoods_name']		= $goods_info['goods_name'];
		$input['member_id']			= intval($_SESSION['member_id']) > 0?$_SESSION['member_id']:0;
		$input['cmember_name']		= $_SESSION['member_name']?$_SESSION['member_name']:'';
		$input['seller_id']			= $store_info['member_id'];
		$input['email']				= $_GET['email'];
		if (strtoupper(CHARSET) == 'GBK') {
			$input['consult_content']	= Language::getGBK($_GET['goods_content']);
		}else{
			$input['consult_content']	= $_GET['goods_content'];
		}
		$input['isanonymous']		= $_GET['hide_name']=='hide'?1:0;
		$consult_model	= Model('consult');
		if($consult_model->addConsult($input)){
			echo json_encode(array('done'=>'true'));
        	die; 
		}else{
			echo json_encode(array('done'=>'false','msg'=>Language::get('goods_index_consult_fail')));
        	die; 
		}
	}
	/**
	 * 异步显示组合销售
	 */
	public function get_bundlingOp(){
		$goods_id = intval($_GET['goods_id']);
		$store_id = intval($_GET['id']);
		if($goods_id <= 0 || $store_id <= 0){
			exit;
		}
		// 实力化模型
		$model = Model();
		
		// 更新组合销售状态
		$update = array();
		$update['bl_quota_state']	= '0';
		$model->table('p_bundling_quota')->where('store_id='.$store_id.' and bl_quota_endtime<'.time())->update($update);
		
		// 查询店铺套餐活动是否开启
		$quota_list = $model->table('p_bundling_quota')->where('store_id='.$store_id.' and bl_quota_state=1')->select();
		if(!empty($quota_list)){
			
			// 根据商品id查询bl_id
			$b_g_list = $model->table('p_bundling_goods')->field('bl_id')->where('goods_id='.$goods_id)->select();
	
			if(!empty($b_g_list) && is_array($b_g_list)){
				$b_id_array = array();
				foreach ($b_g_list as $val){
					$b_id_array[] = $val['bl_id'];
				}
				
				// 查询套餐列表
				$bundling_list	= $model->table('p_bundling')->where('bl_id in ('.implode(',', $b_id_array).') and bl_state=1')->select();
				// 整理
				if(!empty($bundling_list) && is_array($bundling_list)){
					$bundling_array = array();
					foreach ($bundling_list as $val){
						$bundling_array[$val['bl_id']]['id']		= $val['bl_id'];
						$bundling_array[$val['bl_id']]['name']		= $val['bl_name'];
						$bundling_array[$val['bl_id']]['cost_price']= 0;
						$bundling_array[$val['bl_id']]['price']		= $val['bl_discount_price'];
					}
				}
	
				// 查询商品列表
				$b_goods_list	= $model->table('p_bundling_goods,goods')
										->field('p_bundling_goods.bl_goods_id, p_bundling_goods.bl_id, p_bundling_goods.goods_id, p_bundling_goods.goods_name, goods.goods_image, goods.goods_store_price, goods.store_id')
										->join('inner')->on('p_bundling_goods.goods_id=goods.goods_id')
										->where('bl_id in ('.implode(',', $b_id_array).') and goods_show=1')->select();
				// 整理
				if(!empty($b_goods_list) && is_array($b_goods_list)){
					$b_goods_array	= array();
					foreach($b_goods_list as $val){
						$k = intval($val['goods_id']) == $goods_id?0:$val['goods_id'];
						$b_goods_array[$val['bl_id']][$k]['id']		= $val['goods_id'];
						$b_goods_array[$val['bl_id']][$k]['image']	= $val['goods_image'];
						$b_goods_array[$val['bl_id']][$k]['price']	= $val['goods_store_price'];
						$b_goods_array[$val['bl_id']][$k]['name']		= $val['goods_name'];
						$b_goods_array[$val['bl_id']][$k]['store_id']	= $val['store_id'];
						$bundling_array[$val['bl_id']]['cost_price']	+= intval($val['goods_store_price']);
					}
				}
				
				Tpl::output('bundling_array', $bundling_array);
				Tpl::output('b_goods_array', $b_goods_array);
			}
		}
		Tpl::showpage('goods_bundling','null_layout');
	}
	/**
	 * 商品详细页运费显示
	 *
	 * @return unknown
	 */
	function calcOp(){
		if (!is_numeric($_GET['id']) || !is_numeric($_GET['tid'])) return false;

		$model_transport = Model('transport');
//		$extend = $model_transport->getExtendList(array('transport_id'=>array(intval($_GET['tid'])),'top_area_id'=>intval($_GET['id'])));
		$extend = $model_transport->getExtendList(array('transport_id'=>array(intval($_GET['tid']))));
		if (!empty($extend) && is_array($extend)){
			$calc = array();
			$calc_default = array();
			foreach ($extend as $v) {
				if (strpos($v['top_area_id'],",".intval($_GET['id']).",") !== false){
					$calc[$v['type']] = $v['sprice'];
				}
				if ($v['is_default']==1){
					$calc_default[$v['type']] = $v['sprice'];
				}
			}
			//如果运费模板中没有指定该地区，取默认运费
			foreach (array('py','kd','es') as $v){
				if (!isset($calc[$v]) && isset($calc_default[$v])){
					$calc[$v] = $calc_default[$v];
				}
			}
		}
		echo json_encode($calc);
	}
	
	/**
	 * 显示规格属性
	 */
	function get_s_aOp(){
		if(!is_numeric($_GET['goods_id']) || !is_numeric($_GET['id'])) die('null');

		$model	= Model();
		$goods_info		= $model->table('goods')->field('spec_name, goods_spec, goods_attr, goods_col_img')->find($_GET['goods_id']);
		
		if(C('spec_model') == 1){
			$spec_name	= unserialize($goods_info['spec_name']);
			if(!empty($spec_name) && is_array($spec_name)){
				$k = array();
				foreach($spec_name as $key=>$val){
					$k[] = $key;
				}
				if (!empty($k)) $return = $model->table('spec')->field('sp_id, sp_name')->select(implode(',', $k));
				if(!empty($return) && is_array($return)){
					foreach ($return as $val){
						if(isset($spec_name[$val['sp_id']])) $spec_name[$val['sp_id']] = $val['sp_name'];
					}
				}
			}
			
			$goods_spec = unserialize($goods_info['goods_spec']);
			if(!empty($goods_spec) && is_array($goods_spec)){
				$k = array();
				foreach ($goods_spec as $value){
					if(!empty($value) && is_array($value)){
						foreach ($value as $key=>$val){
							$k[] = $key;
						}
					}
				}
				if (!empty($k)) $return = $model->table('spec_value')->field('sp_value_id, sp_value_name, sp_id')->select(implode(',', $k));
				if(!empty($return) && is_array($return)){
					foreach ($return as $val){
						if(isset($goods_spec[$val['sp_id']][$val['sp_value_id']])) $goods_spec[$val['sp_id']][$val['sp_value_id']] = array('name'=>$val['sp_value_name'],'id'=>$val['sp_value_id']);
					}
				}
			}
			
			$goods_col_img = unserialize($goods_info['goods_col_img']);
		}else{
			$spec_name		= 'null';
			$goods_spec		= 'null';
			$goods_col_img	= 'null';
		}
		
		$goods_attr	= unserialize($goods_info['goods_attr']);
		if(!empty($goods_attr) && is_array($goods_attr)){
			$k = array();
			foreach ($goods_attr as &$value){
				if(!empty($value) && is_array($value)){
					foreach ($value as $key=>$val){
						if(is_numeric($key)) $k[] = $key;
					}
				}
			}
			if (!empty($k)) $return = $model->table('attribute_value,attribute')->join('inner')->on('attribute_value.attr_id=attribute.attr_id')->field('attr_value_id, attr_value_name,attribute_value.attr_id, attr_name')->where('attr_value_id in ('.implode(',', $k).')')->select();
			if(!empty($return) && is_array($return)){
				foreach ($return as $key=>$val){
					if(isset($goods_attr[$val['attr_id']]))$goods_attrs[$val['attr_id']] = array('name'=>$val['attr_name'],'value'=>$val['attr_value_name']);
				}
			}else{
				$goods_attrs = 'null';
			}
		}
		
		$data['spec_name']		= $spec_name;
		$data['goods_spec']		= $goods_spec;
		$data['goods_attr']		= $goods_attrs;
		$data['goods_col_img']	= $goods_col_img?$goods_col_img:'null';
		
		
		/**
		 * 转码
		 */
		if (strtoupper(CHARSET) == 'GBK'){
			$data = Language::getUTF8($data);
		}
		echo json_encode($data);
	}
}
