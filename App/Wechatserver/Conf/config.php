<?php
return [
    'TMPL_PARSE_STRING' => array(
		'__IMG__'    => __ROOT__ . '/Public/Default/tp/img',
    ),
	//图文消息数据-门店查询
	'max_back_material_news_num' => 5,
	
	'SESSION_AUTO_START' => false,
    //发送优惠 领取券制定redis之后和后台冲突，导致门店数据的缓存不一致，解决是公用一个reids
	/************************************????**********************************/
    //'REDIS_DB'                           => 9,
    'RAND_MAX_NUM'			=> 1,
    'DB_CONFIGTWO' => 'mysql://ehtwx:ehtwx_123@10.10.32.15/eichitoo#utf8',
];
