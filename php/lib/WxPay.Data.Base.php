<?php

require_once "WxPay.Exception.php";

/**
 * 
 * 数据对象基础类，该类中定义数据类最基本的行为，包括：
 * 计算/设置/获取签名、输出xml格式的参数、从xml读取数据对象等
 * @author widyhu
 *
 */
class WxPayDataBase
{
	protected $values = array();

	/**
	* 设置签名，详见签名生成算法类型
	* @param string $value 
	**/
	public function SetSignType($sign_type)
	{
		$this->values['sign_type'] = $sign_type;
		return $sign_type;
	}

	/**
	* 设置签名，详见签名生成算法
	* @param string $value 
	**/
	public function SetSign($config)
	{	
		$sign = $this->MakeSign($config);
		$this->values['sign'] = $sign;
		return $sign;
	}
	
	/**
	* 获取签名，详见签名生成算法的值
	* @return 值
	**/
	public function GetSign()
	{
		return $this->values['sign'];
	}
	
	/**
	* 判断签名，详见签名生成算法是否存在
	* @return true 或 false
	**/
	public function IsSignSet()
	{
		return array_key_exists('sign', $this->values);
	}

	/**
	 * 输出xml字符
	 * @throws WxPayException
	**/
	public function ToXml()
	{
		if(!is_array($this->values) || count($this->values) <= 0)
		{
    		throw new WxPayException("数组数据异常！");
    	}
    	
    	$xml = "<xml>";
    	foreach ($this->values as $key=>$val)
    	{
    		if (is_numeric($val)){
    			$xml.="<".$key.">".$val."</".$key.">";
    		}else{
    			$xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
    		}
        }
        $xml.="</xml>";
        return $xml; 
	}

    /**
     * 将xml转为array
     * @param string $xml
     * @throws WxPayException
     */
	public function FromXml($xml)
	{	
		if(!$xml){
			throw new WxPayException("xml数据异常！");
		}
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $this->values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		return $this->values;
	}
	
	/**
	 * 格式化参数格式化成url参数
	 */
	public function ToUrlParams()
	{
		$buff = "";
		foreach ($this->values as $k => $v)
		{
			if($k != "sign" && $v != "" && !is_array($v)){
				$buff .= $k . "=" . $v . "&";
			}
		}
		
		$buff = trim($buff, "&");
		return $buff;
	}
	
	/**
	 * 生成签名
	 * @param WxPayConfigInterface $config  配置对象
	 * @param bool $needSignType  是否需要补signtype
	 * @return 签名，本函数不覆盖sign成员变量，如要设置签名需要调用SetSign方法赋值
	 */
	public function MakeSign($config, $needSignType = true){
		
		// if($needSignType) {
		// 	$this->SetSignType($config->GetSignType());
		// }
		//签名步骤一：按字典序排序参数
		ksort($this->values);
		$string = $this->ToUrlParams();
		//签名步骤二：在string后加入KEY
		$string = $string . "&key=".$config->GetKey();
		//签名步骤三：MD5加密或者HMAC-SHA256
		if($config->GetSignType() == "MD5"){
			$string = md5($string);
		} else if($config->GetSignType() == "HMAC-SHA256") {
			$string = hash_hmac("sha256",$string ,$config->GetKey());
		} else {
			throw new WxPayException("签名类型不支持！");
		}
		
		//签名步骤四：所有字符转为大写
		$result = strtoupper($string);
		return $result;
	}
	
	/**
	 * 获取设置的值
	 */
	public function GetValues()
	{
		return $this->values;
	}
}

/**
 *
 * 只使用md5算法进行签名， 不管配置的是什么签名方式，都只支持md5签名方式
 *
**/
class WxPayDataBaseSignMd5 extends WxPayDataBase
{
	/**
	 * 生成签名 - 重写该方法
	 * @param WxPayConfigInterface $config  配置对象
	 * @param bool $needSignType  是否需要补signtype
	 * @return 签名，本函数不覆盖sign成员变量，如要设置签名需要调用SetSign方法赋值
	 */
	public function MakeSign($config, $needSignType = false)
	{
		if($needSignType) {
			$this->SetSignType($config->GetSignType());
		}
		//签名步骤一：按字典序排序参数
		ksort($this->values);
		$string = $this->ToUrlParams();
		//签名步骤二：在string后加入KEY
		$string = $string . "&key=".$config->GetKey();
		//签名步骤三：MD5加密
		$string = md5($string);
		//签名步骤四：所有字符转为大写
		$result = strtoupper($string);
		return $result;
	}
}

/**
 * 
 * 接口调用结果类
 * @author widyhu
 *
 */
class WxPayResults extends WxPayDataBase
{
	/**
	 * 生成签名 - 重写该方法
	 * @param WxPayConfigInterface $config  配置对象
	 * @param bool $needSignType  是否需要补signtype
	 * @return 签名，本函数不覆盖sign成员变量，如要设置签名需要调用SetSign方法赋值
	 */
	public function MakeSign($config, $needSignType = false)
	{
		//签名步骤一：按字典序排序参数
		ksort($this->values);
		$string = $this->ToUrlParams();
		//签名步骤二：在string后加入KEY
		$string = $string . "&key=".$config->GetKey();
		//签名步骤三：MD5加密或者HMAC-SHA256
		if(strlen($this->GetSign()) <= 32){
			//如果签名小于等于32个,则使用md5验证
			$string = md5($string);
		} else {
			//是用sha256校验
			$string = hash_hmac("sha256",$string ,$config->GetKey());
		}
		//签名步骤四：所有字符转为大写
		$result = strtoupper($string);
		return $result;
	}

	/**
	 * @param WxPayConfigInterface $config  配置对象
	 * 检测签名
	 */
	public function CheckSign($config)
	{
		if(!$this->IsSignSet()){
			throw new WxPayException("签名错误！");
		}
		
		$sign = $this->MakeSign($config, false);
		if($this->GetSign() == $sign){
			//签名正确
			return true;
		}
		throw new WxPayException("签名错误2！");
	}
	
	/**
	 * 
	 * 使用数组初始化
	 * @param array $array
	 */
	public function FromArray($array)
	{
		$this->values = $array;
	}
	
	/**
	 * 
	 * 使用数组初始化对象
	 * @param array $array
	 * @param 是否检测签名 $noCheckSign
	 */
	public static function InitFromArray($config, $array, $noCheckSign = false)
	{
		$obj = new self();
		$obj->FromArray($array);
		if($noCheckSign == false){
			$obj->CheckSign($config);
		}
        return $obj;
	}
	
	/**
	 * 
	 * 设置参数
	 * @param string $key
	 * @param string $value
	 */
	public function SetData($key, $value)
	{
		$this->values[$key] = $value;
	}
	
    /**
     * 将xml转为array
     * @param WxPayConfigInterface $config  配置对象
     * @param string $xml
     * @throws WxPayException
     */
	public static function Init($config, $xml)
	{	
		$obj = new self();
		$obj->FromXml($xml);
		//失败则直接返回失败
		if($obj->values['return_code'] != 'SUCCESS') {
			foreach ($obj->values as $key => $value) {
				#除了return_code和return_msg之外其他的参数存在，则报错
				if($key != "return_code" && $key != "return_msg"){
					throw new WxPayException("输入数据存在异常！");
					return false;
				}
			}
			return $obj->GetValues();
		}
        return $obj->GetValues();
	}
}

/**
 *
 * 回调回包数据基类
 *
 **/
class WxPayNotifyResults extends WxPayResults
{
	/**
     * 将xml转为array
     * @param WxPayConfigInterface $config
     * @param string $xml
     * @return WxPayNotifyResults
     * @throws WxPayException
     */
	public static function Init($config, $xml)
	{	
		$obj = new self();
		$obj->FromXml($xml);
		//失败则直接返回失败
		$obj->CheckSign($config);
        return $obj;
	}
}

/**
 * 
 * 回调基础类
 * @author widyhu
 *
 */
class WxPayNotifyReply extends  WxPayDataBaseSignMd5
{
	/**
	 * 
	 * 设置错误码 FAIL 或者 SUCCESS
	 * @param string
	 */
	public function SetReturn_code($return_code)
	{
		$this->values['return_code'] = $return_code;
	}
	
	/**
	 * 
	 * 获取错误码 FAIL 或者 SUCCESS
	 * @return string $return_code
	 */
	public function GetReturn_code()
	{
		return $this->values['return_code'];
	}

	/**
	 * 
	 * 设置错误信息
	 * @param string $return_code
	 */
	public function SetReturn_msg($return_msg)
	{
		$this->values['return_msg'] = $return_msg;
	}
	
	/**
	 * 
	 * 获取错误信息
	 * @return string
	 */
	public function GetReturn_msg()
	{
		return $this->values['return_msg'];
	}
	
	/**
	 * 
	 * 设置返回参数
	 * @param string $key
	 * @param string $value
	 */
	public function SetData($key, $value)
	{
		$this->values[$key] = $value;
	}
}