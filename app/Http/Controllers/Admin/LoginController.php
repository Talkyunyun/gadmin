<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;

class LoginController extends BaseController {

    // 登录页面
    public function getIndex(Request $request) {
        // 判断是否已经登录
        if ($request->session()->has('uid')) {
            return redirect('/');
        }

        if ($request->isMethod('POST')) {
            return $this->_login($request);
        }

        return view($this->module . '.login.index');
    }

    // 退出登录
    public function logout(Request $request) {
        $request->session()->flush();

        return redirect('login');
    }

    // 登录处理
    private function _login($request) {
        $uname = $request->input('uname', false);
        $upass = $request->input('upass', false);

        // 判断是否存在该用户
        $user = Admin::select([
            'id', 'username', 'password', 'roles'
        ])->whereRaw('status=1 AND username=?', [$uname])->first();
        if (empty($user)) {
            return response()->json([
                'code' => 10001,
                'msg'  => '用户名或者密码错误'
            ]);
        }

        // 验证密码
        if (adminEncrypt($upass) != $user->password) {
            return response()->json([
                'code' => 10001,
                'msg'  => '用户名或者密码错误'
            ]);
        }

        // 保存用户信息
        session([
            'uid'      => $user->id,
            'username' => $user->username,
            'roles'    => $user->roles
        ]);

        return response()->json([
            'code' => 0,
            'msg'  => '登录成功!'
        ]);
    }
}