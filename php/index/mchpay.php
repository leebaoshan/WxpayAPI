<?php
/**
* 简单的企业付款(企业付款到零钱)样例，能用于搭建快速体验微信企业付款使用
* 样例的作用仅限于指导如何使用sdk，在安全上面仅做了简单处理，复制使用样例代码时请慎重！
* dongsir007 | dongsir.cn
**/

require_once "../lib/WxPay.Api.php";
require_once "WxPay.Config.php";
require_once 'log.php';

//初始化日志
$logHandler= new CLogFileHandler("../logs/mchpay_".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);
try{

	$openId = "o2kAXuL6sadOb3lhTBl9UaIfpFsA1";
	$input = new WxPayMchpay();
	$input->SetOut_trade_no(date("YmdHis")); //商户订单号，需保持唯一性
	$input->SetTotal_fee(1*100); //企业付款金额，单位为分,低于最小金额1.00元或累计超过20000.00元
	$input->SetCheck_name("FORCE_CHECK"); //NO_CHECK：不校验真实姓名 FORCE_CHECK：强校验真实姓名
	$input->SetRe_user_name("董辉"); //如果check_name设置为FORCE_CHECK，则必填用户真实姓名
	$input->SetDesc("理赔");
	$input->SetOpenid($openId);

	$config = new WxPayConfig();
	$order = WxPayApi::mchpay($config, $input);
	Log::ERROR(json_encode($order));
echo "<pre>";
print_r($order);
print_r(1);
exit(); 

} catch(Exception $e) {
	Log::ERROR(json_encode($e));
}
?>