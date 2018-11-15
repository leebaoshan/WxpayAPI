<?php

require_once "WxPay.Data.Base.php";

/**
 * 
 * 企业付款到零钱输入对象
 * @author donghui | dongsir | dongsir007
 *
 */
class WxPayMchpay extends WxPayDataBase{

	/**
	* 设置商户账号appid
	* @param string $value 
	**/
	public function SetAppid($value)
	{
		$this->values['mch_appid'] = $value;
	}
	/**
	* 获取商户账号appid的值
	* @return 值
	**/
	public function GetAppid()
	{
		return $this->values['mch_appid'];
	}
	/**
	* 判断商户账号appid是否存在
	* @return true 或 false
	**/
	public function IsAppidSet()
	{
		return array_key_exists('mch_appid', $this->values);
	}


	/**
	* 设置微信支付分配的商户号
	* @param string $value 
	**/
	public function SetMch_id($value)
	{
		$this->values['mchid'] = $value;
	}
	/**
	* 获取微信支付分配的商户号的值
	* @return 值
	**/
	public function GetMch_id()
	{
		return $this->values['mchid'];
	}
	/**
	* 判断微信支付分配的商户号是否存在
	* @return true 或 false
	**/
	public function IsMch_idSet()
	{
		return array_key_exists('mchid', $this->values);
	}


	/**
	* 设置微信支付分配的终端设备号，商户自定义
	* @param string $value 
	**/
	public function SetDevice_info($value)
	{
		$this->values['device_info'] = $value;
	}
	/**
	* 获取微信支付分配的终端设备号，商户自定义的值
	* @return 值
	**/
	public function GetDevice_info()
	{
		return $this->values['device_info'];
	}
	/**
	* 判断微信支付分配的终端设备号，商户自定义是否存在
	* @return true 或 false
	**/
	public function IsDevice_infoSet()
	{
		return array_key_exists('device_info', $this->values);
	}


	/**
	* 设置随机字符串，不长于32位。推荐随机数生成算法
	* @param string $value 
	**/
	public function SetNonce_str($value)
	{
		$this->values['nonce_str'] = $value;
	}
	/**
	* 获取随机字符串，不长于32位。推荐随机数生成算法的值
	* @return 值
	**/
	public function GetNonce_str()
	{
		return $this->values['nonce_str'];
	}
	/**
	* 判断随机字符串，不长于32位。推荐随机数生成算法是否存在
	* @return true 或 false
	**/
	public function IsNonce_strSet()
	{
		return array_key_exists('nonce_str', $this->values);
	}

	/**
	* 设置企业付款备注
	* @param string $value 
	**/
	public function SetDesc($value)
	{
		$this->values['desc'] = $value;
	}
	/**
	* 获取企业付款备注的值
	* @return 值
	**/
	public function GetDesc()
	{
		return $this->values['desc'];
	}
	/**
	* 判断企业付款备注是否存在
	* @return true 或 false
	**/
	public function IsDescSet()
	{
		return array_key_exists('desc', $this->values);
	}


	/**
	* 设置商品名称明细列表
	* @param string $value 
	**/
	public function SetDetail($value)
	{
		$this->values['detail'] = $value;
	}
	/**
	* 获取商品名称明细列表的值
	* @return 值
	**/
	public function GetDetail()
	{
		return $this->values['detail'];
	}
	/**
	* 判断商品名称明细列表是否存在
	* @return true 或 false
	**/
	public function IsDetailSet()
	{
		return array_key_exists('detail', $this->values);
	}


	/**
	* 设置附加数据，在查询API和支付通知中原样返回，该字段主要用于商户携带订单的自定义数据
	* @param string $value 
	**/
	public function SetAttach($value)
	{
		$this->values['attach'] = $value;
	}
	/**
	* 获取附加数据，在查询API和支付通知中原样返回，该字段主要用于商户携带订单的自定义数据的值
	* @return 值
	**/
	public function GetAttach()
	{
		return $this->values['attach'];
	}
	/**
	* 判断附加数据，在查询API和支付通知中原样返回，该字段主要用于商户携带订单的自定义数据是否存在
	* @return true 或 false
	**/
	public function IsAttachSet()
	{
		return array_key_exists('attach', $this->values);
	}


	/**
	* 设置商户系统内部的订单号,32个字符内、可包含字母, 其他说明见商户订单号
	* @param string $value 
	**/
	public function SetOut_trade_no($value)
	{
		$this->values['partner_trade_no'] = $value;
	}
	/**
	* 获取商户系统内部的订单号,32个字符内、可包含字母, 其他说明见商户订单号的值
	* @return 值
	**/
	public function GetOut_trade_no()
	{
		return $this->values['partner_trade_no'];
	}
	/**
	* 判断商户系统内部的订单号,32个字符内、可包含字母, 其他说明见商户订单号是否存在
	* @return true 或 false
	**/
	public function IsOut_trade_noSet()
	{
		return array_key_exists('partner_trade_no', $this->values);
	}

	/**
	* 设置企业付款金额，单位为分
	* 低于最小金额1.00元或累计超过20000.00元
	* @param string $value 
	**/
	public function SetTotal_fee($value)
	{
		$this->values['amount'] = $value;
	}
	/**
	* 获取企业付款金额，单位为分
	* @return 值
	**/
	public function GetTotal_fee()
	{
		return $this->values['amount'];
	}
	/**
	* 判断企业付款金额，单位为分
	* @return true 或 false
	**/
	public function IsTotal_feeSet()
	{
		return array_key_exists('amount', $this->values);
	}

	/**
	* 设置APP和网页支付提交用户端ip，Native支付填调用微信支付API的机器IP。
	* @param string $value 
	**/
	public function SetSpbill_create_ip($value)
	{
		$this->values['spbill_create_ip'] = $value;
	}
	/**
	* 获取APP和网页支付提交用户端ip，Native支付填调用微信支付API的机器IP。的值
	* @return 值
	**/
	public function GetSpbill_create_ip()
	{
		return $this->values['spbill_create_ip'];
	}
	/**
	* 判断APP和网页支付提交用户端ip，Native支付填调用微信支付API的机器IP。是否存在
	* @return true 或 false
	**/
	public function IsSpbill_create_ipSet()
	{
		return array_key_exists('spbill_create_ip', $this->values);
	}

	/**
	* 设置trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识。下单前需要调用【网页授权获取用户信息】接口获取到用户的Openid。 
	* @param string $value 
	**/
	public function SetOpenid($value)
	{
		$this->values['openid'] = $value;
	}
	/**
	* 获取trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识。下单前需要调用【网页授权获取用户信息】接口获取到用户的Openid。 的值
	* @return 值
	**/
	public function GetOpenid()
	{
		return $this->values['openid'];
	}
	/**
	* 判断trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识。下单前需要调用【网页授权获取用户信息】接口获取到用户的Openid。 是否存在
	* @return true 或 false
	**/
	public function IsOpenidSet()
	{
		return array_key_exists('openid', $this->values);
	}

	/**
	* 校验用户姓名选项
	* @param string $value 
	**/
	public function SetCheck_name($value)
	{
		$this->values['check_name'] = $value;
	}
	/**
	* 校验用户姓名选项
	* @return 值
	**/
	public function GetCheck_name()
	{
		return $this->values['check_name'];
	}
	/**
	* 校验用户姓名选项
	* @return true 或 false
	**/
	public function IsCheck_nameSet()
	{
		return array_key_exists('check_name', $this->values);
	}

	/**
	* 收款用户姓名
	* @param string $value 
	**/
	public function SetRe_user_name($value)
	{
		$this->values['re_user_name'] = $value;
	}

	/**
	* 收款用户姓名
	* @return 值
	**/
	public function GetRe_user_name()
	{
		return $this->values['re_user_name'];
	}

	/**
	* 收款用户姓名
	* @return true 或 false
	**/
	public function IsRe_user_nameSet()
	{
		return array_key_exists('re_user_name', $this->values);
	}

}