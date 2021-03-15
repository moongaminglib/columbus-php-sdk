<?php
include('RsaTool.php');

$servers = $_SERVER;

$php_self = $servers['PHP_SELF'];

$query_string = $servers['QUERY_STRING'];


if(trim($php_self, '/') == 'pay_notify'){
	payNotify();
}else if(trim($php_self, '/') == 'get_point'){
	getPoint();
}else if(trim($php_self, '/') == 'reduce_point'){
	reducePoint();
}else if(trim($php_self, '/') == 'reduce_point_notify'){
	reducePointNotify();
}

function payNotify()
{
	$req_params = $_POST;
	$_signature = $req_params['_signature'];
	$res = verifySignatureRSA($req_params, $_signature);
	if(!$res) {
		echo 'error';
		exit;
	}

	$app_id = $req_params['app_id'];
	$out_trade_no = $req_params['out_trade_no'];
	$openid = $req_params['openid'];
	$status = $req_params['status'];
	$amount = $req_params['amount'];
	$real_amount = $req_params['real_amount'];
	$confirm_time = $req_params['confirm_time'];

	if($status != 3){
		echo 'error';
		exit;
	}
	echo 'success';
}

function getPoint()
{
	$req_params = $_POST;
	$_signature = $req_params['_signature'];
	$res = verifySignatureRSA($req_params, $_signature);
	if(!$res) {
		echo 'error';
		exit;
	}

	$app_id = $req_params['app_id'];
	$openid = $req_params['openid'];
	$point = 100;

	// refer application/json
	// Pseudocode
	// return json({
	//    "code": 0,
	// 	"point": 100,
	// 	"msg": ''
	// })

	echo 'get_point';
}

function reducePoint()
{
	$req_params = $_POST;
	$_signature = $req_params['_signature'];
	$res = verifySignatureRSA($req_params, $_signature);
	if(!$res) {
		echo 'error';
		exit;
	}

	$app_id = $req_params['app_id'];
	$openid = $req_params['openid'];
	$point = $req_params['point'];
	$trans_id = $req_params['trans_id'];
	$title = $req_params['title'];

	// refer application/json
	// Pseudocode
	// return json({
	//    "code": 0,
	// 	"point": 100,
	// 	"msg": ''
	// })

	echo 'reduce_point';

}

function reducePointNotify()
{
	$req_params = $_POST;
	$_signature = $req_params['_signature'];
	$res = verifySignatureRSA($req_params, $_signature);
	if(!$res) {
		echo 'error';
		exit;
	}

	$app_id = $req_params['app_id'];
	$is_success = $req_params['is_success'];
	$trans_id = $req_params['trans_id'];

	if($is_success != 2){
		echo 'do nothing';
		exit;
	}

	// refer application/json
	// Pseudocode
	// return json({
	//    "code": 0,
	// 	"point": 100,
	// 	"msg": ''
	// })

	echo 'reduce_point_notify';
}

?>
