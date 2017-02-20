<?php
/**
 *  公共函数
 *  @author: Gene
 */

/**
 * 管理员密码加密规则
 * @param string $password
 * @return string
 */
function adminEncrypt($password = '') {
    return sha1(hash('sha512', $password) . sha1(md5($password) . md5('gene @admin Gadmin')));
}


/**
 * 应用用户密码加密规则
 * @param string $password
 * @return string
 */
function userEncrypt($password = '') {
    return sha1(hash('sha512', $password) . sha1(md5($password) . md5('gadmin @user gene')));
}




/**
 * 跳转提示函数
 * @param : string $msg    弹窗提示内容
 * @param : string $url    跳转地址
 * @param : boolen $parent 是否在父窗口中打开
 * @param : int    $time    跳转时间(默认300)
 * @param : int    $status 状态提示取值范围：1绿色勾---2红色叉---3黄色问号---4灰色锁---5红色笑脸--6绿色笑脸---7黄色感叹号
 */
function alert($msg, $url = null, $status = 2, $parent = FALSE, $time = 2) {
    $html = '';
    $time = $time * 1000;
    $html .= '<title>' . $msg . '</title>';
    $html .= '<style>.layui-layer-btn{display:none;}</style><script type="text/javascript" src="http://s2.ystatic.cn/lib/jQuery/jQuery-2.2.3.min.js"></script>';
    $html .= '<script type="text/javascript" src="//cdn.bootcss.com/layer/3.0.1/layer.min.js"></script>';
    $html .= '<script type="text/javascript">';
    $html .= '$(function(){';
    $html .= "layer.alert('{$msg}', {
					title    : '提示',
			      	icon	 : {$status},
			      	skin	 : 'layer-ext-moon',
			    	time	 : {$time},
			    	scrollbar: false,
			    	shift    : 0,
			    	offset   : '10%',
			    	closeBtn : 0,";
    if ($url) {// 跳转提示
        if ($parent) {// 在父窗口中打开
            $html .= "end :function(){parent.window.location.href='{$url}';}";
        } else {
            $html .= "end :function(){window.location.href='{$url}';}";
        }
    }
    if ($parent) {// 在父窗口中打开
        $html .= "end :function(){parent.window.location.reload();}";
    }

    $html .= '});});</script>';

    echo $html;die;
}




/**
 *  直播状态显示
 *  @param: string $msg 提示语
 *  @param: string $live 直播信息
 */
function msg($msg = false, $live = false) {
    $live = (array)$live;
    $msg   = empty($msg) ? trans('msg.live_not_exist') : $msg;
    $live['title'] = empty($live['title']) ? $msg : $live['title'];
    $live['cover'] = empty($live['cover']) ? null : $live['cover'];

    return view('public.msg', [
        'msg'  => $msg,
        'live' => $live
    ]);
}