<?php
/**
 *  验证是否登录系统
 *  @author: Alim
 */
namespace App\Http\Middleware;

use Closure;

class VerifyLogin {

    // 赋值语言包
    public function handle($request, Closure $next) {
        if (!$request->session()->has('uid')) {
            return redirect('login');
        }

        return $next($request);
    }
}
