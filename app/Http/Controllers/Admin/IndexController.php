<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class IndexController extends BaseController {

    // 我的桌面
    public function getWelcome() {
        return view($this->module . '.index.welcome');
    }

    // 首页
    public function getIndex(Request $request) {

        return view($this->module . '.index.index');
    }
}