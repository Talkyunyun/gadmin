<?php

namespace App\Http\Controllers\Wechat;

use App\Libraries\ClassFile\Wechat\Wechat;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class WechatController extends Controller {

    // API获取微信js-sdk签名数据
    public function getWechatJssdk(Request $request) {
        $callback = $request->input('callback');
        $url = $request->input('url');
        $wechat = new Wechat();
        if ($sign = $wechat->getSignPack($url)) {
            $res = ['code'=>200, 'msg'=>'签名成功', 'data'=>$sign];
        } else {
            $res = ['code'=>0, 'msg'=>'签名失败'];
        }

        return $callback.'('. json_encode($res) .')';
    }

    // 对外同意提供获取token
    public function getWechatToken() {
        $wechat = new Wechat();
        $token  = $wechat->getToken();
        if ($token) {
            $res = ['code'=>200, 'msg'=>'获取成功', 'token'=>$token];
        } else {
            $res = ['code'=>0, 'msg'=>'获取失败'];
        }

        return response()->json($res);
    }
}