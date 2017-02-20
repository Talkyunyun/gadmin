<?php
/**
 *  微信公众号相关接口调用
 *  User: alim
 *  Date: 16/10/27
 *  Time: 下午6:07
 */
namespace App\Libraries\ClassFile\Wechat;

use Illuminate\Support\Facades\Redis;

class WechatCore {
    // 微信access_token主键
    private   $_tokenKey;
    private   $_ticketKey;
    private   $_token;
    protected $_APPID;
    protected $_SECRET;

    private $_pre = 'WECHAT';// 微信相关主键前缀

    // 初始化
    public function __construct() {
        $wechatConfig = config('wechat');

        // 获取微信相关配置
        $this->_APPID    = $wechatConfig['app_id'];
        $this->_SECRET   = $wechatConfig['secret'];
        $this->_tokenKey = $this->_pre . ':' .$wechatConfig['redis_access_token'];
        $this->_ticketKey= $this->_pre . ':' .$wechatConfig['redis_wechat_ticket'];

        // 判断微信token是否存在
        if (Redis::exists($this->_tokenKey)) {
            $this->_token = Redis::get($this->_tokenKey);
        } else {// 重新获取token
            $this->_getToken();
        }
    }

    // 对外暴露接口:获取微信token
    public function getToken() {

        return $this->_token;
    }

    /**
     *  获取jsapi_ticket
     *  @return: 成功返回ticket,失败返回false
     */
    public function getTicket() {
        if (Redis::exists($this->_ticketKey)) {
            return Redis::get($this->_ticketKey);
        }

        $arr = [
            'type'         => 'jsapi',
            'access_token' => $this->getToken()
        ];

        $result = $this->curlReq('https://api.weixin.qq.com/cgi-bin/ticket/getticket', $arr);
        if ($result['errcode'] == 0) {
            Redis::set($this->_ticketKey, $result['ticket']);
            Redis::expire($this->_ticketKey, $result['expires_in'] - 10);

            return $result['ticket'];
        }

        return false;
    }

    /**
     * 	CURL请求封装
     * 	@param  string $url    [请求的URL地址]
     * 	@param  array  $params [请求的参数]
     * 	@param  boolen $ipost  [是否采用POST形式]
     *  @param  boolen $isJson [是否采用json格式发送数据]
     * 	@return array
     */
    public function curlReq($url, $params=[], $isPost=false, $isJson=false) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);// 结果以文件流返回，不直接输出
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);// 使用http/1.1
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22');
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        if ($isPost) {// POST请求
            if ($isJson) {// 是否为json发送
                $params = json_encode($params);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type:application/json;charset=utf-8',
                    'Content-Length:'.strlen($params))
                );
            } else {// 普通post请求
                curl_setopt($ch, CURLOPT_POSTFIELDS, $this->_getParams($params));
            }

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, TRUE);
        } else {// GET请求
            if ($params) {
                curl_setopt($ch, CURLOPT_URL, $url.'?'.$this->_getParams($params));
            } else {
                curl_setopt($ch, CURLOPT_URL, $url);
            }
        }

        $res   = curl_exec($ch);
        $error = curl_errno($ch);
        if ($error) {
            return ['error'=>'error', 'msg'=>$error];
        }
        curl_close($ch);

        return json_decode($res, true);
    }

    /**
     *  获取随机字符串
     *  @param: $length 获取长度
     *  @return: 返回字符串
     */
    public function getNonceStr($length = 16) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $str   = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }

        return $str;
    }

    // 请求微信接口获取token
    private function _getToken() {
        $arr = [
            'grant_type' => 'client_credential',
            'appid'      => $this->_APPID,
            'secret'     => $this->_SECRET
        ];

        $result = $this->curlReq('https://api.weixin.qq.com/cgi-bin/token', $arr);
        if ($result['access_token']) {// 获取成功token
            Redis::set($this->_tokenKey, $result['access_token']);
            Redis::expire($this->_tokenKey, $result['expires_in'] - 10);

            $this->_token = $result['access_token'];
        }
    }


    /**
     *  获取请求参数格式
     *  @param array $params
     *  @return string
     */
    private function _getParams(&$params = array()) {
        if (!is_array($params) || empty($params)) {
            return '';
        }

        $result = '';
        foreach($params as $key=>$val) {
            $result .= "&{$key}={$val}";
        }

        return substr($result, 1);
    }

}