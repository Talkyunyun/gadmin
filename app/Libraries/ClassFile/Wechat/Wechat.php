<?php
/**
 *  微信公众号接口调用
 *  User: alim
 *  Date: 16/10/27
 *  Time: 下午6:07
 */
namespace App\Libraries\ClassFile\Wechat;

class Wechat extends WechatCore {

    public function __construct() {
        parent::__construct();
    }

    /**
     *  微信模板消息发送接口调用
     *  @param $openid  用户唯一标识
     *  @param $data    模板消息数据
     *  @return bool   true发送成功,false发送失败
     */
    public function sendTplMsg($openid, $data) {
        // 1.判断用户是否关注公众号
        if (!$this->isFollow($openid)) return false;

        // 2.发送模板消息
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->getToken();
        $result = $this->curlReq($url, $data, true, true);
        if ($result['errcode'] == 0) {
            return true;
        }

        return false;
    }


    /**
     *  判断用户是否关注公众号
     *  @param bool $openid 用户唯一标识
     *  @return bool true表示关注,false表示未关注
     */
    public function isFollow($openid = null) {
        if (empty($openid)) return false;

        $url = 'https://api.weixin.qq.com/cgi-bin/user/info';
        $data = [
            'access_token'=> $this->getToken(),
            'openid'      => $openid,
            'lang'        => 'zh_CN'
        ];

        $result = $this->curlReq($url, $data);
        if ($result['subscribe'] == 1) {// 关注
            return true;
        }

        return false;
    }


    /**
     *  JS-SDK签名
     */
    public function getSignPack($url = null) {
        if (empty($url)) {
            return false;
        }

        $ticket   = $this->getTicket();
        $timestamp= time();
        $nonceStr = $this->getNonceStr();
        $string   = "jsapi_ticket={$ticket}&noncestr={$nonceStr}&timestamp={$timestamp}&url={$url}";
        $signture = sha1($string);

        return [
            'appId'    => $this->_APPID,
            'noncestr' => $nonceStr,
            'timestamp'=> $timestamp,
            'url'      => $url,
            'signture' => $signture
        ];
    }
}