<?php
/**
 *  语言处理
 *  @author: Alim
 */
namespace App\Http\Middleware;

use Closure;
use App;

class Lang {

    // 赋值语言包
    public function handle($request, Closure $next) {
        $lang = $request->input('lang', 'zh-cn');

        App::setLocale($lang);

        return $next($request);
    }
}
